<?php 
namespace Model;

use Model\Config;
class FreightDriver
{
    public $table = "make_speed_rider_fdriver";
    public function getScopeDriver($order_id)
    {
        $address = pdo_get("make_speed_order_address", array("order_id" => $order_id), array("begin_lat", "begin_lng"));
        if (empty($address) || empty($address["begin_lat"]) || empty($address["begin_lng"])) {
            return '';
        }
        $distance = Config::get("driver_scope");
        $distance = !empty($distance) ? intval($distance) : 20;
        $scope = getPointDistance($address["begin_lng"], $address["begin_lat"], $distance);
        $orderCar = pdo_get("make_speed_order", ["id" => $order_id], ["car_id"]);
        $field = "i.rider_id";
        $where = "i.lat >=:minlat AND i.lat <=:maxlat AND i.lng >=:minlng AND i.lng <=:maxlng AND ";
        $where .= "FIND_IN_SET(:car,d.car_id) AND d.uniacid = :uniacid AND i.is_accept = :is_accept";
        $sql = "SELECT {$field} FROM " . tablename("make_speed_rider_info") . " AS i INNER JOIN " . tablename($this->table) . " AS d ON i.rider_id = d.rider_id WHERE {$where}";
        $params = [":car" => $orderCar["car_id"], ":uniacid" => $GLOBALS["uniacid"], ":is_accept" => 1, ":minlat" => $scope["minlat"], ":maxlat" => $scope["maxlat"], ":minlng" => $scope["minlng"], ":maxlng" => $scope["maxlng"]];
        $driver = pdo_fetchall($sql, $params);
        if (empty($driver)) {
            return '';
        }
        $driver = implode(",", array_column($driver, "rider_id"));
        return $driver;
    }
}
?>