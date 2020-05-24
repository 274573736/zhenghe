<?php 
defined("IN_IA") or exit("Access Denied");
include IA_ROOT . "/addons/make_speed/extend/common.func.php";
include "init.php";
include "extend/common.func.php";
use Server\app\Token;
use Server\DesignateDriver;
use Mclass\GetRedis;
class Make_riderModuleWxapp extends WeModuleWxapp
{
    public function __construct()
    {
        global $_W;
        load()->func("logging");
        logging_run(date("Y-m-d H:i") . "[RIDER CLIENT]rider uniacid: " . (string) $_W["uniacid"], "trace", "makespeedlog");
        $result = pdo_get("make_speed_setting", array("key" => "rider_uniacid", "value" => $_W["uniacid"]), array("uniacid"));
        logging_run(date("Y-m-d H:i") . "[RIDER CLIENT] uniacid: " . (string) $result["uniacid"], "trace", "makespeedlog");
        if (empty($result["uniacid"])) {
            return $this->result(0, "未与用户端小程序绑定");
        }
        if ($result["uniacid"] == $_W["uniacid"]) {
            return $this->result(0, "与用户端小程序绑定有误");
        }
        $GLOBALS["uniacid"] = $result["uniacid"];
        if (empty($GLOBALS["CURRENT_RIDER"])) {
            $currentRider = pdo_get("make_speed_rider", array("open_id" => $_W["openid"], "uniacid" => $GLOBALS["uniacid"]), array("id"));
            $GLOBALS["CURRENT_RIDER"] = !empty($currentRider["id"]) ? (int) $currentRider["id"] : 0;
        }
    }
    public function doPageTokenExist()
    {
        $token = $this->request->param("token");
    }
    public function doPageTest()
    {
        $riderID = $GLOBALS["CURRENT_RIDER"];
        $designateDriver = new DesignateDriver();
        $coord = $designateDriver->getCoord($riderID);
        $redis = GetRedis::instance();
        $order_id = $redis->get("driver" . $riderID);
        if (!$order_id) {
            msg("未读取到缓存订单");
        }
        $designateDriver->uploadCoord($order_id, $coord);
        $distance = $designateDriver->getTrackDistance($order_id);
        if (!$distance) {
            return $this->result(0, "ok", ["distance" => $distance]);
        }
        loader()->func("Driver");
        $price = countDestDriverPrice($distance);
        pdo_update("make_speed_order", $price, ["id" => $riderID]);
        try {
            @(\Server\Gateway::$registerAddress = "127.0.0.1:1238");
            @\Server\Gateway::sendToUid("order" . $order_id, json_encode(["price" => $price, "type" => "real_time_price"]));
        } catch (\Exception $e) {
        }
        return $this->result(0, "ok", ["id" => "order" . $order_id, "price" => $price, "distance" => $distance]);
    }
    public function payResult($param)
    {
        global $_W;
        $pre = substr($param["tid"], 0, 2);
        switch ($pre) {
            case "RC":
                $this->rcPayResult($param);
                break;
            case "EO":
                $this->equipPayResult($param);
                break;
            default:
                break;
        }
    }
    public function equipPayResult($param)
    {
        if ($param["result"] == "success") {
            $equip = pdo_get("make_speed_equip_order", array("order_code" => $param["tid"]), array("id", "status"));
            if (!empty($equip) && $equip["status"] < 1) {
                pdo_update("make_speed_equip_order", array("status" => 1), array("id" => $equip["id"]));
            }
        }
    }
    private function rcPayResult($param)
    {
        if ($param["result"] == "success") {
            $cash = pdo_get("make_speed_rider_cashlog", array("order_code" => $param["tid"]), array("id", "rider_id", "status", "amount"));
            if (!empty($cash) && $cash["status"] < 2) {
                pdo_update("make_speed_rider_cashlog", array("status" => 2), array("id" => $cash["id"]));
                updateRiderMoney($cash["rider_id"], $cash["amount"], 0);
            }
        }
    }
}
?>