<?php 
defined("IN_IA") or exit("Access Denied");
include "extend/common.func.php";
include "init.php";
use Mclass\ScopePersonnel;
use Model\Test;
use Server\DesignateDriver;
use Model\Config;
use Server\Order;
use Server\Gateway;
use Mclass\Request;
class Make_speedModuleWxapp extends WeModuleWxapp
{
    protected $request;
    //loger日志 曹青2020-5-17

    
    public function doPageTest()
    {
    }
    public function __construct()
    {
        global $_GPC, $_W;
        $this->request = Request::instance();
        $GLOBALS["uniacid"] = !empty($_W["uniacid"]) ? $_W["uniacid"] : 0;
        $GLOBALS["CURRENT_USER"] = 0;
        $GLOBALS["order_type"] = !empty($_GPC["order_type"]) ? intval($_GPC["order_type"]) : 0;
        if (!empty($_W["openid"]) && empty($GLOBALS["CURRENT_USER"])) {
            $current = pdo_get("make_speed_user", array("open_id" => $_W["openid"], "uniacid" => $GLOBALS["uniacid"]), array("id"));
            if (!empty($current["id"])) {
                $GLOBALS["CURRENT_USER"] = !empty($current["id"]) ? (int) $current["id"] : 0;
            }
        }
    }
    public function doPageLogin()
    {
        global $_W, $_GPC;
        if (empty($_W["openid"])) {
            return $this->result(0, "未获取到用户信息");
        }
        $recommend = !empty($_GPC["recommend_id"]) ? intval($_GPC["recommend_id"]) : 0;
        $rider = !empty($_GPC["rider_id"]) ? intval($_GPC["rider_id"]) : 0;
        $userData = array("nick_name" => !empty($_GPC["nickName"]) ? $_GPC["nickName"] : '', "avatar" => !empty($_GPC["avatarUrl"]) ? $_GPC["avatarUrl"] : '', "sex" => !empty($_W["fans"]["gender"]) ? $_W["fans"]["gender"] : 1, "open_id" => $_W["openid"], "uniacid" => $GLOBALS["uniacid"], "logged_ip" => $_W["clientip"], "logged_time" => time());
        loader()->func("emoji");
        $userData["nick_name"] = filterEmoji($userData["nick_name"]);
        $exits = pdo_get("make_speed_user", array("open_id" => $_W["openid"], "uniacid" => $GLOBALS["uniacid"]), array("id"));
        $add = null;
        if (!empty($exits)) {
            $add = pdo_update("make_speed_user", $userData, array("open_id" => $_W["openid"], "uniacid" => $GLOBALS["uniacid"]));
        } else {
            $userData["add_time"] = time();
            $userData["recommend_id"] = $recommend;
            $userData["recommend_rider"] = $rider;
            $userData["update_time"] = $userData["add_time"];
            $add = pdo_insert("make_speed_user", $userData);
            if ($recommend) {
                $data = ["user_id" => $GLOBALS["CURRENT_USER"], "create_time" => time(), "pid" => $recommend, "uniacid" => $GLOBALS["uniacid"], "is_distributor" => 0];
                pdo_insert("make_speed_distribution_distributor", $data);
            }
            if (!empty($add)) {
                get_invite_coupon($recommend);
                if (!empty($rider)) {
                    $uid = pdo_insertid();
                    rider_invite_user($uid, $rider, "reg");
                }
            }
        }
        if (empty($add)) {
            return $this->result(0, "信息保存失败！");
        }
        return $this->result(0, '', array(2));
    }
    public function doPageCity()
    {
        global $_GPC, $_W;
        $results = pdo_getall("make_speed_city", array("uniacid" => $GLOBALS["uniacid"], "is_disabled" => 0), array("name", "key"), '', array("key asc"));
        if (empty($results)) {
            return $this->result(0, "城市列表为空!");
        }
        $initial = array_merge(array_unique(array_column($results, "key")));
        $exitsCount = array_count_values(array_column($results, "key"));
        $data = array();
        $num = 0;
        foreach ($initial as $ik => $iv) {
            $data[$ik]["title"] = $iv;
            $data[$ik]["item"] = array_slice($results, $num, $exitsCount[$iv]);
            $num += $exitsCount[$iv];
        }
        $hot[0]["title"] = "热门城市";
        $hot[0]["type"] = "hot";
        $hot[0]["item"] = pdo_getall("make_speed_city", array("uniacid" => $GLOBALS["uniacid"], "is_disabled" => 0, "is_hot" => 1), array("name", "key"), '', array("key asc"));
        $data = array_merge($hot, $data);
        return $this->result(0, '', $data);
    }
    public function doPageMymoney()
    {
        global $_GPC;
        $type = $_GPC["type"] ? (int) $_GPC["type"] : 0;
        if (!$type) {
            $user = pdo_get("make_speed_user", array("id" => $GLOBALS["CURRENT_USER"]), array("valid"));
        } else {
            $user = pdo_get("make_speed_business", ["user_id" => $GLOBALS["CURRENT_USER"]], ["valid"]);
            if (!$user) {
                $user = pdo_get("make_speed_business_user", ["user_id" => $GLOBALS["CURRENT_USER"]], ["business_id"]);
                if ($user) {
                    $user = pdo_get("make_speed_business", ["id" => $user["business_id"]], ["valid"]);
                }
            }
        }
        if (!isset($user["valid"])) {
            return $this->result(0, "获取数据失败！");
        }
        return $this->result(0, '', $user);
    }
    public function doPageGoodsType()
    {
         
        logger("测试日志");
        global $_GPC, $_W;
        //logger($_GPC);
        //logger(json_encode($_GPC));
        //logger($_W);
        // logger(json_encode($_W));
        //$where = array("order_type" => $GLOBALS["order_type"], "uniacid" => $GLOBALS["uniacid"]);
        $where = array( "uniacid" => $GLOBALS["uniacid"]);
        $results = pdo_getall("make_speed_goods_type", $where, array("id", "icon", "iconed", "name"), '', array("weight desc", "id desc"));
        
        logger(json_encode($results));
        
        if (empty($results)) {
            return $this->result(0, '');
        }
        foreach ($results as $k => $v) {
            $results[$k]["icon"] = toimgurl($v["icon"]);
            $results[$k]["iconed"] = toimgurl($v["iconed"]);
        }
        return $this->result(0, '', $results);
        //return $this->result(0, '','456');
    }
    public function doPageCoupons()
    {
        global $_GPC, $_W;
        $type = !empty($_GPC["type"]) ? intval($_GPC["type"]) : 0;
        $order_type = $GLOBALS["order_type"] + 1;
        $where = array();
        if (!empty($order_type)) {
            $where["order_type"] = array(0, $order_type);
        }
        if (empty($type)) {
            $where["status"] = 0;
        }
        if ($type === 1) {
            $where["expire_time <="] = time();
            pdo_update("make_speed_user_coupons", array("status" => 2), array("user_id" => $GLOBALS["CURRENT_USER"], "expire_time <=" => time()));
        }
        $where["user_id"] = $GLOBALS["CURRENT_USER"];
        $results = pdo_getall("make_speed_user_coupons", $where, array(), '', array("id desc"));
        if (empty($results)) {
            return $this->result(0, '');
        }
        foreach ($results as $k => $v) {
            $results[$k]["title"] = $v["tips"];
            $results[$k]["money"] = $v["amount"];
            $results[$k]["distance"] = $v["limit_distance"];
            $results[$k]["satisfy_money"] = $v["full_amount"];
            $results[$k]["begin_time"] = date("Y-m-d", $v["begin_time"]);
            $results[$k]["expire_time"] = !empty($v["expire_time"]) ? date("Y-m-d", $v["expire_time"]) : 0;
        }
        return $this->result(0, '', $results);
    }
    public function doPageCouponShop()
    {
        global $_W, $_GPC;
        $page = !empty($_GPC["page"]) ? intval($_GPC["page"]) : 0;
        $coupons = pdo_getall("make_speed_coupons", array("gral >" => 0), array("id", "money", "satisfy_money", "gral"), '', array("id desc"), array($page, 12));
        foreach ($coupons as $k => $v) {
            $coupons[$k]["money"] = toint($v["money"]);
        }
        return $this->result(0, '', array("coupon_list" => $coupons));
    }
    public function doPageCouponDetail()
    {
        global $_W, $_GPC;
        $id = !empty($_GPC["id"]) ? intval($_GPC["id"]) : 0;
        $coupon = pdo_get("make_speed_coupons", array("id" => $id));
        $coupon["img"] = MODULE_URL . "core/public/" . $coupon["img"];
        return $this->result(0, '', $coupon);
    }
    public function doPageBuyCoupon()
    {
        global $_W, $_GPC;
        $id = !empty($_GPC["id"]) ? intval($_GPC["id"]) : 0;
        $coupon = pdo_get("make_speed_coupons", array("id" => $id), array());
        if (empty($coupon)) {
            return $this->result(0, "无此优惠券，请确认后重试");
        }
        $user = pdo_get("make_speed_user", array("id" => $GLOBALS["CURRENT_USER"]), array("gral"));
        if ($coupon["gral"] > $user["gral"]) {
            return $this->result(0, "账户积分不足,无法兑换");
        }
        $data = array("user_id" => $GLOBALS["CURRENT_USER"], "coupon_id" => $id, "uniacid" => $GLOBALS["uniacid"], "type" => "buy", "tips" => $coupon["title"], "amount" => $coupon["money"], "begin_time" => time(), "expire_time" => strtotime("+ " . $coupon["day"] . "day", time()), "full_amount" => $coupon["satisfy_money"]);
        if (pdo_fieldexists("make_speed_user_coupons", "limit_distance")) {
            $add["limit_distance"] = $coupon["distance"];
        }
        $add = pdo_insert("make_speed_user_coupons", $data);
        if (empty($add)) {
            return $this->result(0, "领取失败，请确认后重试");
        }
        pdo_update("make_speed_user", array("gral -=" => $coupon["gral"]), array("id" => $GLOBALS["CURRENT_USER"]));
        return $this->result(0, '', array(888));
    }
    public function doPageGetTime()
    {
        global $_GPC, $_W;
        $errno = 0;
        $message = "返回消息";
        $day = 7;
        $days = array();
        $i = 0;
        while ($i < $day) {
            if ($i === 0) {
                $days[] = "今天";
            } else {
                $days[] = date("m月d日", strtotime("+" . $i . " day"));
            }
            $i++;
        }
        $data = array("days" => $days, "hours" => date("H"), "minutes" => date("i"));
        return $this->result($errno, $message, $data);
    }
    public function doPageAddOrder()
    {
        global $_W, $_GPC;
        if (empty($GLOBALS["CURRENT_USER"])) {
            return $this->result(0, "未获取到用户信息,请删除小程序重新授权登录");
        }
        $system = pdo_get("make_speed_setting", array("uniacid" => $GLOBALS["uniacid"], "key" => "system_switch"), array("value"));
        if (!empty($system["value"])) {
            $tip = "系统暂时关闭, 无法下单";
            $system_tip = pdo_get("make_speed_setting", array("uniacid" => $GLOBALS["uniacid"], "key" => "off_tip"), array("value"));
            if (!empty($system_tip["value"])) {
                $tip = $system_tip["value"];
            }
            return $this->result(0, $tip);
        }
        $user = pdo_get("make_speed_user", ["id" => $GLOBALS["CURRENT_USER"]], ["blacklist"]);
        if ($user["blacklist"] == 1) {
            return $this->result(0, "该账号暂时无法下单，如有疑问请联系管理员");
        }
        $business = array("跑腿", "帮买", "万能服务", "代驾", '', "货运", "家政");
        if (!isopen_business($GLOBALS["order_type"])) {
            return $this->result(0, "暂未开通" . (!empty($business[$GLOBALS["order_type"]]) ? $business[$GLOBALS["order_type"]] : "所选业务"));
        }
        $expire_time = Config::get("order_expire");
        $expire_time = $expire_time ? intval($expire_time) : 30;
        $data = array("goods_id" => !empty($_GPC["standard_id"]) ? (int) $_GPC["standard_id"] : 0, "weight" => !empty($_GPC["weight_num"]) ? sprintf("%.1f", $_GPC["weight_num"]) : 0.0, "coupon_id" => !empty($_GPC["coupons_id"]) ? (int) $_GPC["coupons_id"] : 0, "payment" => !empty($_GPC["pay_method"]) ? (int) $_GPC["pay_method"] : 0, "distance" => !empty($_GPC["distance"]) ? sprintf("%.2f", $_GPC["distance"]) : 0.0, "description" => !empty($_GPC["remark"]) ? $_GPC["remark"] : "无", "pay_price" => !empty($_GPC["actual_payment"]) ? sprintf("%.2f", $_GPC["actual_payment"]) : 0.0, "total_price" => !empty($_GPC["moneys"]) ? sprintf("%.2f", $_GPC["moneys"]) : 0.0, "small_price" => !empty($_GPC["tip_money"]) ? sprintf("%.2f", $_GPC["tip_money"]) : 0.0, "night_price" => !empty($_GPC["night_price"]) ? sprintf("%.2f", $_GPC["night_price"]) : 0.0, "change_price" => !empty($_GPC["change_price"]) ? sprintf("%.2f", $_GPC["change_price"]) : 0.0, "discount_price" => !empty($_GPC["discount_price"]) ? sprintf("%.2f", $_GPC["discount_price"]) : 0.0, "floor_price" => !empty($_GPC["floor_price"]) ? sprintf("%.2f", $_GPC["floor_price"]) : 0.0, "user_id" => $GLOBALS["CURRENT_USER"], "uniacid" => $GLOBALS["uniacid"], "add_time" => time(), "update_time" => time(), "expire_time" => strtotime("+" . $expire_time . "minute"));
        !empty($_GPC["buy_type"]) && ($data["distance"] = 0);
        $data["total_price"] = $data["total_price"] + $data["discount_price"];
        $data["img"] = !empty($_GPC["imgs"]) ? $_GPC["imgs"] : '';
        $data["audio"] = !empty($_GPC["audio_url"]) ? $_GPC["audio_url"] : '';
        $data["is_discuss"] = !empty($_GPC["bargain"]) ? 1 : 0;
        $data["budget_price"] = !empty($_GPC["goods_predict"]) ? sprintf("%.2f", $_GPC["goods_predict"]) : 0;
        $data["distance_price"] = !empty($_GPC["distance_price"]) ? sprintf("%.2f", $_GPC["distance_price"]) : 0.0;
        if ($GLOBALS["order_type"] != 3 && $GLOBALS["order_type"] != 6 && (empty($data["goods_id"]) || $data["goods_id"] < 1)) {
            return $this->result(0, "请选择物品类型");
        }
        if ($data["pay_price"] < 0) {
            return $this->result(0, "支付金额不能小于0");
        }
        $data["type"] = !empty($_GPC["order_type"]) ? intval($_GPC["order_type"]) : 0;
        $goods = pdo_get("make_speed_goods_type", array("id" => $data["goods_id"]), array("name"));
        $data["goodsname"] = !empty($goods["name"]) ? $goods["name"] . "/" . $data["weight"] : "未知/" . $data["weight"];
        if ($data["type"] == 6) {
            $data["category_id"] = $_GPC["cate_id"];
            if (!$data["category_id"]) {
                return $this->result(0, "请选择服务类型！");
            }
            $category = pdo_get("make_speed_homemaking_category", ["id" => $data["category_id"]], ["title"]);
            if (!$category) {
                return $this->result(0, "服务类目不存在！");
            }
            $data["goodsname"] = $category["title"];
        }
        if ($data["type"] == 2) {
            $data["goodsname"] = !empty($goods["name"]) ? $goods["name"] : "未知";
        }
        $driverCharg = 1;
        if ($data["type"] == 3) {
            $data["goodsname"] = '';
            $driverCharg = Config::get("dcharge_type");
            $driverCharg = $driverCharg ? $driverCharg : 1;
            if ($driverCharg == 2) {
                $data["status"] = 2;
                $data["charg_type"] = 2;
            }
        }
        $get_time = empty($_GPC["time"]) || $_GPC["time"] == 1 ? 1 : json_decode(htmlspecialchars_decode($_GPC["time"]), true);
        if (isset($get_time["day"], $get_time["hour"], $get_time["minute"])) {
            $data["get_time"] = $get_time["day"] . " " . $get_time["hour"] . ":" . $get_time["minute"];
        } else {
            if ($get_time == 1) {
                $data["get_time"] = "立即服务";
            } else {
                $data["get_time"] = "未知";
            }
        }
        $data["distance_time"] = !empty($_GPC["duration"]) ? intval($_GPC["duration"]) : 0;
        $data["order_code"] = generate_order_code(18, "make_speed_order");
        if (empty($data["order_code"])) {
            return $this->result(0, "生成订单错误！稍后重试");
        }
        $cityname = !empty($_GPC["city"]) ? $_GPC["city"] : "南宁";
        $city = pdo_get("make_speed_city", array("name" => $cityname), array("id"));
        if (empty($city["id"])) {
            return $this->result(0, "此城市暂无服务业务");
        }
        $data["city_id"] = intval($city["id"]);
        $fa = empty($_GPC["fahuo"]) || !empty($_GPC["buy_type"]) ? array() : json_decode(htmlspecialchars_decode($_GPC["fahuo"]), true);
        $shou = empty($_GPC["shouhuo"]) ? array() : json_decode(htmlspecialchars_decode($_GPC["shouhuo"]), true);
        if ($data["type"] == 2 || $data["type"] == 1 && empty($fa)) {
            $fa["location"]["lat"] = !empty($shou["location"]["lat"]) ? $shou["location"]["lat"] : '';
            $fa["location"]["lng"] = !empty($shou["location"]["lng"]) ? $shou["location"]["lng"] : '';
        }
        $address = array("begin_username" => !empty($fa["person_name"]) ? $fa["person_name"] : '', "begin_phone" => !empty($fa["person_tel"]) ? $fa["person_tel"] : '', "begin_detail" => !empty($fa["person_address"]) ? $fa["person_address"] : '', "begin_address" => !empty($fa["title"]) ? $fa["title"] : '', "begin_lat" => !empty($fa["location"]["lat"]) ? $fa["location"]["lat"] : '', "begin_lng" => !empty($fa["location"]["lng"]) ? $fa["location"]["lng"] : '', "end_username" => !empty($shou["person_name"]) ? $shou["person_name"] : '', "end_phone" => !empty($shou["person_tel"]) ? $shou["person_tel"] : '', "end_detail" => !empty($shou["person_address"]) ? $shou["person_address"] : '', "end_address" => !empty($shou["title"]) ? $shou["title"] : '', "end_lat" => !empty($shou["location"]["lat"]) ? $shou["location"]["lat"] : '', "end_lng" => !empty($shou["location"]["lng"]) ? $shou["location"]["lng"] : '', "end_floor" => !empty($_GPC["floor"]) ? intval($_GPC["floor"]) : 0);
        pdo_begin();
        $addOrder = pdo_insert("make_speed_order", $data);
        $order_id = pdo_insertid();
        $address["order_id"] = $order_id;
        $addAddress = pdo_insert("make_speed_order_address", $address);
        if (!$addOrder || !$addAddress) {
            pdo_rollback();
            return $this->result(0, "下单失败，请重试！");
        } else {
            pdo_commit();
        }
        $switch = Config::get("d_switch");
        if ($switch == 1) {
            \Server\distribution\Order::addOrder($data, $order_id);
        }
        if ($data["type"] != 3 && $driverCharg != 2) {
            pdo_update("make_speed_user_coupons", array("status" => 1), array("id" => $data["coupon_id"]));
        }
        if ($data["type"] == 3 && $driverCharg == 2) {
            $desDriver = new DesignateDriver();
            $desDriver->callDriver($address, $order_id);
        }
        loader()->func("Tools");
        setKeyExpire($order_id);
        return $this->result(0, '', array("order_id" => $order_id, "charg_type" => $driverCharg));
    }
    public function doPagePay()
    {
        global $_GPC, $_W;
        $id = !empty($_GPC["id"]) ? (int) $_GPC["id"] : 0;
        $order = pdo_get("make_speed_order", array("id" => $id), array("city_id", "expire_time", "id", "type", "get_time", "user_id", "order_code", "pay_price", "status", "charg_type"));
        if ($order["expire_time"] < time()) {
            return $this->result(0, "该订单已过期");
        }
        if (empty($order)) {
            return $this->result(0, "没有此订单信息！");
        }
        if ($order["status"] >= 2) {
            return $this->result(0, "该订单已支付~");
        }
        $GLOBALS["order_type"] = $order["type"];
        $payment = !empty($_GPC["pay_method"]) ? (int) $_GPC["pay_method"] : 0;
        if ($payment === 1 || $order["pay_price"] == 0) {
            $pay = updateUserMoney($order["user_id"], $order["pay_price"]);
            if (empty($pay["code"]) && $order["type"] == 3 && $order["charg_type"] == 2) {
                $orderServer = new Order();
                $orderServer->designateDriverUpdate($order);
                addCashLog($order["user_id"], $order["order_code"], $order["pay_price"], 0, "订单余额支付");
                try {
                    @(Gateway::$registerAddress = "127.0.0.1:1238");
                    @Gateway::sendTouid("uniacid" . $GLOBALS["uniacid"], $id . "," . $order["city_id"]);
                } catch (Exception $e) {
                }
                return $this->result(0, '', array("order_id" => $order["id"]));
            } else {
                if (!empty($pay["code"]) && $order["pay_price"] != 0) {
                    return $this->result(0, !empty($pay["message"]) ? $pay["message"] : "支付失败！");
                }
                if (isset($order["status"]) && $order["status"] < 2) {
                    pdo_update("make_speed_order", ["status" => 2, "payment" => $payment], ["id" => $order["id"]]);
                    pdo_insert("make_speed_order_pickcode", array("order_id" => $order["id"], "pick_code" => generate_pick_code(0, 6, $id)));
                    addCashLog($order["user_id"], $order["order_code"], $order["pay_price"], 0, "订单余额支付");
                    $content = "恭喜您! 订单:" . $order["order_code"] . "余额支付成功, 等待骑手接单中...";
                    addUserMessage($order["user_id"], "订单支付消息", $content);
                }
                ob_clean();
                ob_start();
                if ($order["type"] == 6) {
                    $technicians = Server\PushOrderType::getTechnician($order["id"]);
                    echo json_encode(["errno" => 0, "message" => '', "data" => ["order_id" => $order["id"], "data" => $technicians]]);
                } else {
                    echo json_encode(["errno" => 0, "message" => '', "data" => ["order_id" => $order["id"], "data" => getScopeRider($id)]]);
                }
                header("Content-Encoding: none");
                header("Content-Length: " . ob_get_length());
                header("Connection: close");
                ob_end_flush();
                ob_flush();
                flush();
                if (function_exists("fastcgi_finish_request")) {
                    fastcgi_finish_request();
                }
                try {
                    @(Gateway::$registerAddress = "127.0.0.1:1238");
                    @Gateway::sendTouid("uniacid" . $GLOBALS["uniacid"], $id . "," . $order["city_id"]);
                } catch (Exception $e) {
                }
                loader()->func("SendTpl");
                UserPayOrder($order["id"]);
                sendToRiderOrderTpl($order["id"]);
                \Server\distribution\Order::updateOrder($order["id"], 1);
                $cids = ScopePersonnel::getRider($order["id"], 0, "app_client_id");
                loader()->func("Getui");
                sendUniMesssage($cids);
                die;
            }
        }
        $params = array("tid" => $order["order_code"], "user" => $_W["openid"], "fee" => sprintf("%.2f", $order["pay_price"]), "title" => "订单支付");
        $pay_params = $this->pay($params);
        if (is_error($pay_params)) {
            return $this->result(0, $pay_params["message"]);
        }
        $data["pay_params"] = $pay_params;
        $ordertype = 2;
        if (is_numeric(substr($order["get_time"], -1))) {
            $ordertype = 1;
        }
        if ($order["type"] != 3 && $order["charg_type"] != 2) {
            if ($order["type"] == 6) {
                $technicians = Server\PushOrderType::getTechnician($order["id"]);
                $data["data"] = $technicians;
            } else {
                $data["data"] = getScopeRider($id, $ordertype);
            }
        }
        return $this->result(0, '', $data);
    }
    public function doPageRechargeValid()
    {
        global $_W, $_GPC;
        $cou = pdo_get("make_speed_setting", array("uniacid" => $GLOBALS["uniacid"], "key" => "user_recharge_coupon"), array("value"));
        $list = array(20, 30, 50, 100, 200, 300);
        if (!empty($_GPC["list"])) {
            return $this->result(0, '', array("list" => $list, "discount" => !empty($cou["value"]) ? floatval($cou["value"]) : 0));
        }
        $money = !empty($_GPC["money"]) ? intval($_GPC["money"]) : 0;
        if (empty($money)) {
            return $this->result(0, "请选择充值余额");
        }
        $ordercode = generate_order_code(18, "make_speed_user_cashlog", "order_code", "CZ");
        $params = array("tid" => $ordercode, "user" => $_W["openid"], "fee" => $money, "title" => "订单支付");
        $pay_params = $this->pay($params);
        if (is_error($pay_params)) {
            return $this->result(0, "支付失败，请重试");
        }
        if (!empty($cou["value"])) {
            $money += $money * floatval($cou["value"]);
        }
        addCashLog($GLOBALS["CURRENT_USER"], $ordercode, $money, 1, "余额充值", 0, 0);
        return $this->result(0, '', array("pay_params" => $pay_params));
    }
    public function doPageUserCashLog()
    {
        global $_W, $_GPC;
        $type = isset($_GPC["type"]) ? intval($_GPC["type"]) : -1;
        $ctime = !empty($_GPC["time"]) ? strtotime($_GPC["time"]) : 0;
        $page = !empty($_GPC["page"]) ? intval($_GPC["page"]) : 0;
        $limit = !empty($_GPC["limit"]) ? intval($_GPC["limit"]) : 0;
        $page > 0 || ($page = 1);
        $limit > 0 || ($limit = 10);
        $where = array("user_id" => $GLOBALS["CURRENT_USER"], "uniacid" => $GLOBALS["uniacid"], "status" => 1);
        $type < 0 || ($where["type"] = $type);
        if (!empty($ctime)) {
            $where["add_time >="] = $ctime;
            $where["add_time <"] = strtotime("+1 month", $ctime);
        }
        $results = pdo_getall("make_speed_user_cashlog", $where, array("title", "type", "status", "user_id", "add_time", "amount"), '', array("id desc"), array($page, $limit));
        if (empty($results)) {
            return $this->result(0, '');
        }
        $status = array("待完成", "已完成");
        foreach ($results as $k => $v) {
            if ($v["type"] < 1) {
                $results[$k]["amount"] = sprintf("%.2f", $v["amount"] * -1);
            } else {
                $results[$k]["amount"] = "+" . $v["amount"];
            }
            $results[$k]["status"] = $status[$v["status"]];
            $results[$k]["add_time"] = date("Y-m-d H:i", $v["add_time"]);
            $results[$k]["day_time"] = date("d日", $v["add_time"]);
            $results[$k]["hour_time"] = date("H:i", $v["add_time"]);
        }
        return $this->result(0, "success", $results);
    }
    public function payResult($param)
    {
        global $_W;
        $pre = substr($param["tid"], 0, 2);
        switch ($pre) {
            case "XF":
                $this->xfPayResult($param);
                break;
            case "CZ":
                $this->czPayResult($param);
                break;
            case "RC":
                $this->rcPayResult($param);
                break;
            case "BC":
                $this->BusinessPayResult($param);
                break;
            default:
                if ($param["result"] == "success") {
                    $order = pdo_get("make_speed_order", array("order_code" => $param["tid"]), array("city_id", "id", "type", "charg_type", "order_code", "user_id", "pay_price", "status"));
                    if ($order["type"] == 3 && $order["charg_type"] == 2) {
                        pdo_update("make_speed_order", ["status" => 5], ["order_code" => $param["tid"]]);
                        $driverOrder = pdo_get("make_speed_order_rider", ["order_id" => $order["id"]], ["rider_id"]);
                        riderGotoOrder($order["id"], $driverOrder["rider_id"]);
                        addCashLog($order["user_id"], $order["order_code"], $order["pay_price"], 0, "订单微信支付");
                        $content = "恭喜您! 订单:" . $order["order_code"] . "使用微信支付成功";
                        addUserMessage($order["user_id"], "订单支付消息", $content);
                        sendOrderTpl($order["id"]);
                        try {
                            @(Gateway::$registerAddress = "127.0.0.1:1238");
                            @Gateway::sendTouid("uniacid" . $GLOBALS["uniacid"], $order["id"] . "," . $order["city_id"]);
                        } catch (Exception $e) {
                        }
                    }
                    if (isset($order["status"]) && $order["status"] < 2) {
                        pdo_update("make_speed_order", ["status" => 2], ["order_code" => $param["tid"]]);
                        pdo_insert("make_speed_order_pickcode", array("order_id" => $order["id"], "pick_code" => generate_pick_code(0, 6, $order["id"])));
                        addCashLog($order["user_id"], $order["order_code"], $order["pay_price"], 0, "订单微信支付");
                        pdo_update("make_speed_distribution_order", ["status" => 1], ["order_id" => $order["id"]]);
                        $content = "恭喜您! 订单:" . $order["order_code"] . "使用微信支付成功, 等待骑手接单中...";
                        addUserMessage($order["user_id"], "订单支付消息", $content);
                        loader()->func("SendTpl");
                        sendToRiderOrderTpl($order["id"]);
                        UserPayOrder($order["id"]);
                        try {
                            @(Gateway::$registerAddress = "127.0.0.1:1238");
                            @Gateway::sendTouid("uniacid" . $GLOBALS["uniacid"], $order["id"] . "," . $order["city_id"]);
                            $cids = ScopePersonnel::getRider($order["id"], 0, "app_client_id");
                            loader()->func("Getui");
                            sendUniMesssage($cids);
                        } catch (Exception $e) {
                        }
                    }
                }
                break;
        }
    }
    private function xfPayResult($param)
    {
        if ($param["result"] == "success") {
            $cash = pdo_get("make_speed_user_cashlog", array("order_code" => $param["tid"]), array("id", "user_id", "object_id", "amount"));
            if (empty($cash)) {
                return false;
            }
            $order = pdo_get("make_speed_order", array("id" => $cash["object_id"]), array("id", "order_code", "status"));
            if (isset($order["status"]) && $order["status"] == 2) {
                pdo_update("make_speed_user_cashlog", array("status" => 1), array("id" => intval($cash["id"])));
                $data = array("small_price +=" => $cash["amount"], "pay_price +=" => $cash["amount"], "total_price +=" => $cash["amount"]);
                pdo_update("make_speed_order", $data, array("id" => $cash["object_id"]));
                return true;
            }
        }
        return false;
    }
    private function czPayResult($param)
    {
        if ($param["result"] == "success") {
            $cash = pdo_get("make_speed_user_cashlog", array("order_code" => $param["tid"]), array("id", "user_id", "status", "amount"));
            if (!empty($cash) && $cash["status"] == 0) {
                pdo_update("make_speed_user_cashlog", array("status" => 1), array("id" => $cash["id"]));
                updateUserMoney($cash["user_id"], $cash["amount"], 1);
            }
        }
    }
    private function BusinessPayResult($param)
    {
        if ($param["result"] == "success") {
            $cash = pdo_get("make_speed_user_cashlog", array("order_code" => $param["tid"]), array("id", "business_id", "status", "amount"));
            if (!empty($cash) && $cash["status"] == 0) {
                pdo_update("make_speed_user_cashlog", array("status" => 1), array("id" => $cash["id"]));
                pdo_update("make_speed_business", array("valid +=" => $cash["amount"]), array("id" => $cash["business_id"]));
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
    public function doPageOrderList()
    {
        global $_W, $_GPC;
        $status = !empty($_GPC["status"]) ? (int) $_GPC["status"] : 0;
        $page = !empty($_GPC["page"]) ? (int) $_GPC["page"] : 0;
        $limit = !empty($_GPC["limit"]) ? (int) $_GPC["limit"] : 0;
        $page > 0 || ($page = 1);
        $limit > 10 || ($limit = 10);
        $where = array("business_id" => 0, "user_id" => $GLOBALS["CURRENT_USER"]);
        switch ($status) {
            case 0:
                break;
            case 1:
                $where["status >="] = 2;
                $where["status <="] = 4;
                break;
            case 2:
                $where["status"] = 5;
                break;
            case 3:
                $where["status"] = 6;
                break;
            case 4:
                $where["status"] = 1;
                break;
            default:
                $where["status"] = -1;
                break;
        }
        $results = load()->object("query")->from("make_speed_order", "o")->leftjoin("make_speed_order_address", "a")->on(array("o.id" => "a.order_id"))->where($where)->page($page, $limit)->select("o.order_code", "o.car_id", "o.status", "o.add_time", "a.*", "type")->orderby("id desc")->getall();
        if (empty($results)) {
            return $this->result(0, '');
        }
        $ordertype = array("帮送", "帮买", "万能服务", "代驾", '', "货运", "技能服务");
        foreach ($results as $k => $v) {
            $results[$k]["add_time"] = date("Y年m月d H:i分", $v["add_time"]);
            $results[$k]["id"] = !empty($v["order_id"]) ? $v["order_id"] : $v["id"];
            if (empty($v["car_id"])) {
                $results[$k]["order_type"] = !empty($ordertype[$v["type"]]) ? $ordertype[$v["type"]] : '';
            } else {
                $results[$k]["order_type"] = "货运";
            }
        }
        return $this->result(0, "获取订单列表成功！", $results);
    }
    public function doPageOrderDetail()
    {
        global $_W, $_GPC;
        $id = isset($_GPC["id"]) ? (int) $_GPC["id"] : 0;
        $where = array("o.id" => $id, "o.user_id" => $GLOBALS["CURRENT_USER"]);
        $field = ["o.charg_type", "o.img", "order_code", "o.city_id", "o.business_id", "o.floor_price", "o.type as order_type", "o.distance", "o.add_time", "get_time", "o.night_price", "o.distance_price", "o.change_price", "o.discount_price", "o.coupon_id", "o.business_id", "o.small_price", "o.description as remark", "payment", "pay_price", "total_price", "o.goodsname as goods", "weight", "status", "a.*", "p.pick_code", "p.end_code"];
        $result = load()->object("query")->from("make_speed_order", "o")->innerjoin("make_speed_order_address", "a")->on(["a.order_id" => "o.id"])->leftjoin("make_speed_order_pickcode", "p")->on("p.order_id", "o.id")->where($where)->select($field)->get();
        if (empty($result)) {
            return $this->result(0, "无此订单信息！");
        }
        empty($result["add_time"]) || ($result["add_time"] = date("m-d H:i", $result["add_time"]));
        $result["coupon_money"] = 0.0;
        $result["pick_code"] = !empty($result["pick_code"]) ? $result["pick_code"] : 0;
        $result["end_code"] = !empty($result["end_code"]) ? $result["end_code"] : 0;
        $coupon = pdo_get("make_speed_user_coupons", ["id" => $result["coupon_id"]], ["amount"]);
        if (!empty($coupon["amount"])) {
            $result["coupon_money"] = $coupon["amount"];
        }
        $result["id"] = !empty($result["order_id"]) ? $result["order_id"] : $result["id"];
        $result["order_gral"] = intval($result["total_price"]);
        $result["riders"] = array();
        $result["pick_img"] = $result["end_img"] = '';
        if ($result["status"] > 2 || $result["status"] == 0 && $result["charg_type"] == 2) {
            $result["riders"] = load()->object("query")->from("make_speed_rider_info", "i")->leftjoin("make_speed_order_rider", "o")->on(["o.rider_id" => "i.rider_id"])->leftjoin("make_speed_rider", "r")->on(["r.id" => "i.rider_id"])->where(["o.order_id" => $id])->select("o.*", "i.service_total", "i.score as rider_score", "r.real_name as rider_name", "i.lat", "i.lng", "r.avatar", "r.mobile")->get();
            if (!empty($result["riders"]["accept_time"]) && !empty($result["riders"]["goto_time"])) {
                $result["riders"]["total_time"] = ceil(($result["riders"]["goto_time"] - $result["riders"]["accept_time"]) / 60);
            }
            empty($result["riders"]["tag"]) || ($result["riders"]["tag"] = explode("|", $result["riders"]["tag"]));
            if (!empty($result["riders"]["pick_img"])) {
                $result["pick_img"] = str_replace("/uploads/", $_W["siteroot"] . "addons/make_speed/core/public/uploads/", $result["riders"]["pick_img"]);
                $result["pick_img"] = !empty($result["pick_img"]) ? explode(",", $result["pick_img"]) : '';
            }
            if (!empty($result["riders"]["end_img"])) {
                $result["end_img"] = str_replace("/uploads/", $_W["siteroot"] . "addons/make_speed/core/public/uploads/", $result["riders"]["end_img"]);
                $result["end_img"] = !empty($result["end_img"]) ? explode(",", $result["end_img"]) : '';
            }
            empty($result["riders"]["accept_time"]) || ($result["riders"]["accept_time"] = date("m-d H:i", $result["riders"]["accept_time"]));
            empty($result["riders"]["get_time"]) || ($result["riders"]["get_time"] = date("m-d H:i", $result["riders"]["get_time"]));
            empty($result["riders"]["goto_time"]) || ($result["riders"]["goto_time"] = date("m-d H:i", $result["riders"]["goto_time"]));
            empty($result["riders"]["complete_time"]) || ($result["riders"]["complete_time"] = date("m-d H:i", $result["riders"]["complete_time"]));
            $result["riders"]["score"] = $result["riders"]["score"] / 20 - 1;
        }
        $gralgrow = pdo_getall("make_speed_setting", array("uniacid" => $GLOBALS["uniacid"], "key" => array("user_gral", "user_grow")), array("value", "key"));
        $gralgrows = array_column($gralgrow, "value", "key");
        $gralgrows["user_gral"] = !empty($gralgrows["user_gral"]) ? $gralgrows["user_gral"] : 0;
        $gralgrows["user_grow"] = !empty($gralgrows["user_grow"]) ? $gralgrows["user_grow"] : 0;
        $result["gral"] = ceil($gralgrows["user_gral"] * $result["total_price"]);
        $result["grow"] = ceil($gralgrows["user_grow"] * $result["total_price"]);
        if ($result["img"]) {
            $result["img"] = str_replace("/uploads/", $_W["siteroot"] . "addons/make_speed/core/public/uploads/", $result["img"]);
            $result["img"] = explode(",", $result["img"]);
        }
        $result["accept_rider"] = getScopeRider($id);
        return $this->result(0, "success", $result);
    }
    public function doPageCheckOrder()
    {
        global $_W, $_GPC;
        $status = !empty($_GPC["status"]) ? (int) $_GPC["status"] : 0;
        $id = !empty($_GPC["id"]) ? intval($_GPC["id"]) : 0;
        $result = pdo_get("make_speed_order", ["id" => $id], ["id", "status"]);
        if (empty($result)) {
            return $this->result(0, "暂无此订单~");
        }
        if ($result["status"] >= $status) {
            return $this->result(0, "更新操作失败！请稍后重试");
        }
        if (pdo_update("make_speed_order", ["status" => $status], ["id" => $id])) {
            return $this->result(0, "订单状态更新成功！");
        }
        return $this->result(0, "订单状态更新失败！");
    }
    public function doPageGetPrice()
    {
        global $_W, $_GPC;
        $x = !empty($_GPC["distance"]) ? floatval($_GPC["distance"]) : 0;
        $w = !empty($_GPC["weight_num"]) ? floatval($_GPC["weight_num"]) : 0;
        $floor = !empty($_GPC["floor"]) ? intval($_GPC["floor"]) : 0;
        $hour = $_GPC["hour"];
        $type = $GLOBALS["order_type"];
        $curTime = date("H:i", time());
        if (is_numeric($hour)) {
            $curTime = $hour . ":" . date("i", time());
        }
        $per = $type !== 0 ? $type !== 1 ? $type !== 2 ? $type !== 3 ? '' : "drive_" : "line_" : "buy_" : '';
        $keys = array($per . "floor_price", $per . "distance", $per . "weight", $per . "initial_price", $per . "night_price", $per . "change_price", $per . "night_time");
        $cityname = !empty($_GPC["city"]) ? trim($_GPC["city"]) : '';
        $city = pdo_get("make_speed_city", array("name" => $cityname), array("id"));
        if (!empty($city["id"])) {
            $results = pdo_getall("make_speed_setting", array("uniacid" => $GLOBALS["uniacid"], "key" => $keys, "city_id" => $city["id"]), array("key", "value"));
        }
        if (empty($results)) {
            $results = pdo_getall("make_speed_setting", array("uniacid" => $GLOBALS["uniacid"], "key" => $keys, "city_id" => 0), array("key", "value"));
        }
        if (empty($results)) {
            $this->result(0, '', array("money" => 12, "night_price" => 0, "change_price" => 0));
        }
        $results = array_column($results, "value", "key");
        $ekeys = array_keys($results);
        foreach ($ekeys as $kk => $kv) {
            $ekeys[$kk] = str_replace($per, '', $kv);
        }
        $results = array_combine($ekeys, array_values($results));
        $results["distance"] = !empty($results["distance"]) ? unserialize($results["distance"]) : array();
        $results["weight"] = !empty($results["weight"]) ? unserialize($results["weight"]) : array();
        $money = 12;
        if (!empty($results["initial_price"])) {
            $money = sprintf("%.2f", $results["initial_price"]);
        }
        krsort($results["distance"]);
        foreach ($results["distance"] as $k => $v) {
            if ($x > $k) {
                $money += ($x - $k) * $v;
                $x = $k;
            }
        }
        krsort($results["weight"]);
        foreach ($results["weight"] as $wk => $wv) {
            if ($w > $wk) {
                $money += ($w - $wk) * $wv;
                $w = $wk;
            }
        }
        $distance_price = $money;
        $floor_price = 0;
        $floor_prices = !empty($results["floor_price"]) ? @unserialize($results["floor_price"]) : array();
        if (!empty($floor_prices) && !empty($floor_prices[0]) && !empty($floor_prices[1]) && !empty($floor_prices[0] <= $floor)) {
            $money += ($floor - $floor_prices[0]) * $floor_prices[1];
            $floor_price = ($floor - $floor_prices[0]) * $floor_prices[1];
        }
        empty($results["change_price"]) && ($results["change_price"] = 0);
        $results["night_price"] = isset($results["night_price"]) ? unserialize($results["night_price"]) : array();
        $nightPrice = 0;
        if ($results["night_price"] && is_array($results["night_price"])) {
            if ($curTime < 6) {
                $curTime += 24;
            }
            array_multisort(array_column($results["night_price"], "start"), SORT_DESC, $results["night_price"]);
            foreach ($results["night_price"] as $k => $v) {
                if ($v["start"] > $v["end"]) {
                    $v["end"] += 24;
                }
                if ($curTime >= $v["start"] && $curTime <= $v["end"]) {
                    $nightPrice = floatval($v["price"]);
                    break;
                }
            }
            $money += $nightPrice;
        }
        $money += !empty($results["change_price"]) ? $results["change_price"] : 0;
        $discount = load()->object("query")->from("make_speed_user", "u")->leftjoin("make_speed_user_grade", "g")->on(array("u.user_grade" => "g.id"))->where(array("u.id" => $GLOBALS["CURRENT_USER"]))->select("g.discount")->get();
        $discount_price = 0;
        $_discount = 0;
        if (!empty($discount["discount"])) {
            $discount_price = $money - $discount["discount"] * $money;
            $money = $discount["discount"] * $money;
            $_discount = $discount["discount"];
        }
        $data = array("money" => sprintf("%.2f", $money), "night_price" => sprintf("%.2f", $nightPrice), "change_price" => sprintf("%.2f", $results["change_price"]), "distance_price" => sprintf("%.2f", $distance_price), "discount_price" => sprintf("%.2f", $discount_price), "discount" => !empty($_discount) ? $_discount : 1, "floor_price" => sprintf("%.2f", $floor_price), "max_money" => intval($money * 10));
        return $this->result(0, "success", $data);
    }
    public function doPageGetPosition()
    {
        global $_W, $_GPC;
        $clat = !empty($_GPC["latitude"]) ? $_GPC["latitude"] : 0;
        $clng = !empty($_GPC["longitude"]) ? $_GPC["longitude"] : 0;
        $type = isset($_GPC["type"]) ? $_GPC["type"] : 0;
        $distance = pdo_get("make_speed_setting", array("key" => "rider_distance", "uniacid" => $GLOBALS["uniacid"]), array("value"));
        $distance["value"] = !empty($distance["value"]) ? intval($distance["value"]) : 20;
        $scope = getPointDistance($clng, $clat, $distance["value"]);
        $where["uniacid"] = $GLOBALS["uniacid"];
        $where = array("lat >=" => $scope["minlat"], "lat <=" => $scope["maxlat"], "lng >=" => $scope["minlng"], "lng <=" => $scope["maxlng"]);
        $query = load()->object("query");
        $virtual_rider = $query->from("make_speed_virtual_rider")->select(["lat", "lng"])->where($where)->getall();
        $where["is_accept"] = 1;
        if ($type == 1) {
            $riders = $query->from("make_speed_rider_info", "i")->inneerjoin("make_speed_rider_driver", "d")->on(["i.rider_id" => "d.rider_id"])->select(["lat", "lng"])->where(["uniacid" => $GLOBALS["uniacid"], "i.is_accept" => 1, "i.lat >=" => $scope["minlat"], "i.lat <=" => $scope["maxlat"], "i.lng >=" => $scope["minlng"], "i.lng <=" => $scope["maxlng"]])->getall();
        } else {
            $riders = pdo_getall("make_speed_rider_info", $where, array("lat", "lng"));
        }
        $riders = @array_merge($riders, $virtual_rider);
        $riders = array_values($riders);
        $key = $type == 1 ? "driver_map_icon" : "rider_map_icon";
        $icon = Config::get($key);
        $icon1 = !empty($icon) ? $icon : "/uploads/program_icon/client/rider.png";
        return $this->result(0, "success", array("rider" => $riders, "icon" => toimgurl($icon1)));
    }
    public function doPageGetNewperson()
    {
        global $_W;
        $setting = pdo_get("make_speed_setting", array("uniacid" => $GLOBALS["uniacid"], "key" => "newperson_coupon"), array("value"));
        if (empty($setting["value"])) {
            return $this->result(0, '', array("money" => 0, "img" => '', "coupon_id" => 0));
        }
        $newpers = unserialize($setting["value"]);
        if (empty($newpers["coupon_id"]) || intval($newpers["coupon_id"]) < 1) {
            return $this->result(0, '', array("money" => 0, "img" => '', "coupon_id" => 0));
        }
        $coupon = pdo_get("make_speed_coupons", array("id" => intval($newpers["coupon_id"])), array("money"));
        if (empty($coupon["money"])) {
            return $this->result(0, '', array("money" => 0, "img" => '', "coupon_id" => 0));
        }
        $exits = pdo_get("make_speed_user_coupons", array("type" => "newperson", "user_id" => $GLOBALS["CURRENT_USER"]), array("id"));
        if (!empty($exits["id"])) {
            return $this->result(0, '', array("money" => 0, "img" => '', "coupon_id" => 0));
        }
        if (empty($newpers["coupon_bg"])) {
            $newpers["coupon_bg"] = MODULE_URL . "core/public/program_icon/client/newperson.png";
        } else {
            $newpers["coupon_bg"] = MODULE_URL . "core/public/" . $newpers["coupon_bg"];
        }
        $newpers["coupon_id"] = intval($newpers["coupon_id"]);
        $newpers["money"] = $coupon["money"];
        return $this->result(0, '', $newpers);
    }
    public function doPageAcceptNewperson()
    {
        global $_W, $_GPC;
        $couponid = !empty($_GPC["coupon_id"]) ? intval($_GPC["coupon_id"]) : 0;
        $coupon = pdo_get("make_speed_coupons", array("id" => $couponid), array("id", "title", "satisfy_money", "money", "day"));
        if (empty($coupon)) {
            return $this->result(0, "领取失败！");
        }
        $exits = pdo_get("make_speed_user_coupons", array("type" => "newperson", "user_id" => $GLOBALS["CURRENT_USER"]), array("id"));
        if (!empty($exits["id"])) {
            return $this->result(0, "很抱歉！您已领取过该优惠券");
        }
        $data = array("type" => "newperson", "user_id" => intval($GLOBALS["CURRENT_USER"]), "tips" => $coupon["title"], "amount" => $coupon["money"], "full_amount" => $coupon["satisfy_money"], "coupon_id" => $couponid, "begin_time" => time(), "add_time" => time(), "uniacid" => $GLOBALS["uniacid"]);
        $data["expire_time"] = !empty(intval($coupon["day"])) ? strtotime("+ " . intval($coupon["day"]) . "day") : 0;
        $add = pdo_insert("make_speed_user_coupons", $data);
        if (!empty($add)) {
            return $this->result(0, '', array($add));
        }
        return $this->result(0, "领取失败！请稍后重试");
    }
    public function doPageCancelOrder()
    {
        global $_W, $_GPC;
        $id = !empty($_GPC["id"]) ? intval($_GPC["id"]) : 0;
        $where = array("id" => $id);
        $field = array("charg_type", "id", "type", "business_id", "user_id", "small_price", "status", "order_code", "pay_price", "payment", "coupon_id");
        $result = pdo_get("make_speed_order", array("id" => $id), $field);
        if (empty($result) || $result["user_id"] != $GLOBALS["CURRENT_USER"]) {
            return $this->result(0, "暂无此订单信息！");
        }
        if ($result["type"] == 3 && $result["charg_type"] == 2) {
            if ($result["status"] == 0) {
                return $this->result(0, "该订单为实时计费，请付款！");
            }
        }
        if ($result["status"] >= 3) {
            return $this->result(0, "您的订单已接单, 需取消请联系客服");
        }
        $up = pdo_update("make_speed_order", array("status" => 1), $where);
        if (empty($up)) {
            return $this->result(0, "操作失败！请稍后重试");
        }
        $distributionOrder = \Server\distribution\Order::updateOrder($id, 3);
        if ($result["status"] == 3) {
            pdo_delete("make_speed_order_rider", array("order_id" => $id));
        }
        if (!empty($result["coupon_id"])) {
            pdo_update("make_speed_user_coupons", array("status" => 0), array("id" => $result["coupon_id"]));
        }
        $businessWhere = array("user_id" => $result["user_id"], "order_code" => $result["order_code"], "status" => 1, "type <" => 2);
        $cash = pdo_get("make_speed_user_cashlog", $businessWhere, array("amount", "business_id"));
        if (!empty($cash["amount"])) {
            if (!empty($cash["business_id"])) {
                $business = business_refund($cash["business_id"], $result);
                if (is_error($business)) {
                    return $this->result(0, !empty($refund["message"]) ? $refund["message"] : "退款失败!请联系管理员");
                }
                return $this->result(0, '', array(1));
            }
            $smallcount = pdo_get("make_speed_user_cashlog", array("type" => 0, "status" => 1, "object_id" => $id, "user_id" => $result["user_id"]), array("SUM(amount) as amount"));
            if (!empty($smallcount)) {
                empty($smallcount["amount"]) && ($smallcount["amount"] = 0);
                if ($result["payment"] == 2) {
                    $cashid = addCashLog($result["user_id"], $result["order_code"], $result["pay_price"] - $smallcount["amount"], 2, "微信退款", 0, 0);
                    $refund = weixinRefund($result["order_code"], $result["pay_price"] - $smallcount["amount"]);
                    if (is_error($refund)) {
                        return $this->result(0, !empty($refund["message"]) ? $refund["message"] : "退款失败！");
                    }
                    pdo_update("make_speed_user_cashlog", array("status" => 1), array("id" => $cashid));
                } else {
                    updateUserMoney($result["user_id"], $result["pay_price"] - $smallcount["amount"], 1);
                    addCashLog($result["user_id"], $result["order_code"], $result["pay_price"] - $smallcount["amount"], 2, "退款到余额", $id);
                }
            }
            $small = pdo_getall("make_speed_user_cashlog", array("object_id" => $id, "type" => 0, "status" => 1, "uniacid" => $GLOBALS["uniacid"]), array("business_id", "id", "amount", "user_id", "order_code"));
            if (!empty($small)) {
                foreach ($small as $v) {
                    if ($v["business_id"]) {
                        pdo_update("make_speed_business", array("valid +=" => $v["amount"]), array("id" => $v["make_speed_business"]));
                        addCashLog($v["user_id"], $v["order_code"], $v["amount"], 2, "[小费]余额退款", $id, 1);
                    } else {
                        $re = weixinRefund($v["order_code"], $v["amount"]);
                        if (is_error($re)) {
                            addCashLog($v["user_id"], $v["order_code"], $v["amount"], 2, "[小费]余额退款", $id, 1);
                            pdo_update("make_speed_user", array("valid +=" => $v["amount"]), array("id" => $v["user_id"]));
                        } else {
                            addCashLog($v["user_id"], $v["order_code"], $v["amount"], 2, "[小费]微信退款", $id, 1);
                        }
                    }
                }
            }
            loader()->func("SendTpl");
            userCancelOrder($result);
        }
        return $this->result(0, '', array(1));
    }
    public function doPageSetComment()
    {
        global $_W, $_GPC;
        $id = !empty($_GPC["order_id"]) ? (int) $_GPC["order_id"] : 0;
        $result = pdo_get("make_speed_order", array("id" => $id), array("status", "total_price", "user_id"));
        if (!isset($result["status"])) {
            return $this->result(0, "暂无此订单信息！");
        }
        $data["score"] = isset($_GPC["star_num"]) ? (intval($_GPC["star_num"]) + 1) * 20 : 80;
        $data["tag"] = !empty($_GPC["evaluete_value"]) ? $_GPC["evaluete_value"] : '';
        $data["complete_time"] = time();
        $order = pdo_get("make_speed_order_rider", array("order_id" => $id), array("rider_id"));
        $up = pdo_update("make_speed_order_rider", $data, array("order_id" => $id));
        if (!empty($up)) {
            $score = pdo_get("make_speed_rider_info", array("rider_id" => $order["rider_id"]), array("score"));
            $scores = ceil(($score["score"] + $data["score"]) / 2);
            pdo_update("make_speed_rider_info", array("score" => $scores), array("rider_id" => $order["rider_id"]));
            $gralgrow = pdo_getall("make_speed_setting", array("uniacid" => $GLOBALS["uniacid"], "key" => array("user_gral", "user_grow")), array("value", "key"));
            $gralgrows = array_column($gralgrow, "value", "key");
            $gralgrows["user_gral"] = !empty($gralgrows["user_gral"]) ? $gralgrows["user_gral"] : 1;
            $gralgrows["user_grow"] = !empty($gralgrows["user_grow"]) ? $gralgrows["user_grow"] : 1;
            $updata = array("gral +=" => ceil($gralgrows["user_gral"] * $result["total_price"]), "grow +=" => ceil($gralgrows["user_grow"] * $result["total_price"]));
            $user = pdo_get("make_speed_user", array("id" => $result["user_id"]), array("grow", "user_grade"));
            $grade = pdo_getall("make_speed_user_grade", array("uniacid" => $GLOBALS["uniacid"]), array("id", "grow"));
            if (!empty($grade)) {
                $grade = array_column($grade, "grow", "id");
                arsort($grade);
                foreach ($grade as $k => $v) {
                    if ($user["grow"] + $updata["grow +="] >= $v && (!empty($grade[$user["user_grade"]]) && $v >= $grade[$user["user_grade"]])) {
                        $updata["user_grade"] = $k;
                        break;
                    }
                }
            }
            pdo_update("make_speed_user", $updata, array("id" => $result["user_id"]));
            pdo_update("make_speed_order", array("status" => 6), array("id" => $id));
            $resultData = array("status" => 6, "star_num" => intval($_GPC["star_num"]), "evaluete_value" => explode("|", $data["tag"]));
            return $this->result(0, '', $resultData);
        }
        return $this->result(0, "评价提交失败！请稍后重试");
    }
    public function doPageGetAgreement()
    {
        global $_W, $_GPC;
        $type = !empty($_GPC["type"]) ? trim($_GPC["type"]) : "user_redbao";
        $result = pdo_get("make_speed_agreement", array("type" => 0, "position" => $type, "uniacid" => $GLOBALS["uniacid"]), array("content"));
        if ($type == "user_helper") {
            $result["content"] = !empty($result["content"]) ? unserialize($result["content"]) : array();
        }
        $result["content"] = !empty($result["content"]) ? str_replace("\"/addons/make_speed/core", "\"" . $_W["siteroot"] . "/addons/make_speed/core", $result["content"]) : array();
        if (!empty($result["content"])) {
            return $this->result(0, '', $result);
        }
        return $this->result(0, "暂无设置~");
    }
    public function doPageUploadImage()
    {
        global $_W, $_GPC;
        load()->func("file");
        if (empty($_FILES["file"])) {
            return $this->result(0, "请选择上传图片");
        }
        $ect = "jpg";
        $arr = explode(".", $_FILES["file"]["name"]);
        empty($arr) || ($ect = end($arr));
        $newFile = "../addons/make_speed/core/public/uploads/program/" . date("Ymd") . "/" . uniqid(mt_rand(1, 1000)) . "." . $ect;
        $dir = dirname($newFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $path = file_upload($_FILES["file"], "image", $newFile);
        if ($path) {
            $newFile = stristr($newFile, "/uploads/");
            return json_encode(array("path" => $newFile));
        }
        return $this->result(0, "图片上传失败！");
    }
    public function doPageUploadAudio()
    {
        global $_W, $_GPC;
        load()->func("file");
        if (empty($_FILES["file"])) {
            return $this->result(0, "请选择上传音频");
        }
        $ect = "mp3";
        $arr = explode(".", $_FILES["file"]["name"]);
        empty($arr) || ($ect = end($arr));
        $newFile = "../addons/make_speed/core/public/uploads/program/" . date("Ymd") . "/" . uniqid(mt_rand(1, 1000)) . "." . $ect;
        $dir = dirname($newFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $path = file_upload($_FILES["file"], "audio", $newFile);
        if ($path) {
            $newFile = stristr($newFile, "/uploads/");
            return json_encode(array("path" => $newFile));
        }
        return $this->result(0, "音频上传失败！");
    }
    protected function get_access_token()
    {
        global $_W;
        $appid = $_W["account"]["key"];
        $secret = $_W["account"]["secret"];
        $tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret;
        $html = file_get_contents($tokenUrl);
        $arr = json_decode($html, true);
        return $arr["access_token"];
    }
    public function doPageGetCode()
    {
        $accessToken = get_access_token();
        $url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=" . $accessToken;
        $data = ["path" => "make_speed/router/router?recommend_id=" . $GLOBALS["CURRENT_USER"]];
        load()->func("communication");
        $response = ihttp_post($url, json_encode($data));
        $path = MODULE_ROOT . "/core/public/uploads/qrcode/";
        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }
        $file = "qrcode_" . $GLOBALS["CURRENT_USER"] . ".png";
        file_put_contents($path . $file, $response["content"]);
        return $this->result(0, "success", MODULE_URL . "core/public/uploads/qrcode/" . $file);
    }
    public function doPageGetPoster()
    {
        global $_W;
        $setting = pdo_get("make_speed_setting", array("uniacid" => $GLOBALS["uniacid"], "key" => "user_poster"), array("value"));
        $imgpath = !empty($setting["value"]) ? $setting["value"] : "uploads/program_icon/client/poster.jpg";
        return $this->result(0, '', array("img_url" => MODULE_URL . "core/public/" . $imgpath));
    }
    public function doPageGetShareInvite()
    {
        $setting = pdo_get("make_speed_setting", array("uniacid" => $GLOBALS["uniacid"], "key" => "users_invite"), array("value"));
        $result = !empty($setting["value"]) ? unserialize($setting["value"]) : array();
        $user = pdo_get("make_speed_user", array("recommend_id" => $GLOBALS["CURRENT_USER"]), array("COUNT(*) as total"));
        $result["exist_total"] = !empty($user["total"]) ? $user["total"] : 0;
        $coupon = pdo_get("make_speed_user_coupons", array("type" => "invite", "user_id" => $GLOBALS["CURRENT_USER"]), array("SUM(amount) as money"));
        $result["exist_money"] = !empty($coupon["money"]) ? toint($coupon["money"]) : 0;
        if ($result["exist_total"] > $result["person_num"]) {
            $result["differ_num"] = !empty($result["person_num"]) ? $result["exist_total"] % $result["person_num"] : "N";
        } else {
            $result["differ_num"] = $result["person_num"] - $result["exist_total"];
        }
        $user_invite_txt = pdo_get("make_speed_agreement", array("uniacid" => $GLOBALS["uniacid"], "position" => "user_invite_txt", "type" => 0), array("content"));
        $result["agreement"] = !empty($user_invite_txt["content"]) ? $user_invite_txt["content"] : '';
        return $this->result(0, '', $result);
    }
    public function doPageGetUserId()
    {
        global $_W, $_GPC;
        $recommend = !empty($_GPC["recommend_id"]) ? intval($_GPC["recommend_id"]) : 0;
        $rider = !empty($_GPC["rider_id"]) ? intval($_GPC["rider_id"]) : 0;
        $exits = pdo_get("make_speed_user", array("open_id" => $_W["openid"], "uniacid" => $GLOBALS["uniacid"]), array("id"));
        $add = null;
        if (empty($exits)) {
            $userData["add_time"] = time();
            $userData["recommend_id"] = $recommend;
            $userData["recommend_rider"] = $rider;
            $userData["open_id"] = $_W["openid"];
            $userData["uniacid"] = $GLOBALS["uniacid"];
            $add = pdo_insert("make_speed_user", $userData);
            if (empty($add)) {
                return $this->result(0, "信息保存失败！");
            }
            $GLOBALS["CURRENT_USER"] = pdo_insertid();
            if ($recommend) {
                $data = ["user_id" => $GLOBALS["CURRENT_USER"], "create_time" => time(), "pid" => $recommend, "uniacid" => $GLOBALS["uniacid"], "is_distributor" => 0];
                pdo_insert("make_speed_distribution_distributor", $data);
            }
            get_invite_coupon($recommend);
            if (!empty($rider)) {
                $uid = pdo_insertid();
                rider_invite_user($uid, $rider, "reg");
            }
        }
        return $this->result(0, '', array("user_id" => $GLOBALS["CURRENT_USER"], "open_id" => $_W["openid"]));
    }
    public function doPageGetRedbao()
    {
        global $_W, $_GPC;
        $recommend = !empty($_GPC["recommend_id"]) ? intval($_GPC["recommend_id"]) : 0;
        $mobile = !empty($_GPC["mobile"]) ? $_GPC["mobile"] : '';
        $smscode = !empty($_GPC["code"]) ? $_GPC["code"] : '';
        $sendSms = !empty($_GPC["is_send"]) ? true : false;
        if (isset($_GPC["is_init"])) {
            $coupon = get_newperson_coupon();
            return $this->result(0, '', $coupon);
        }
        load()->func("cache");
        if ($sendSms) {
            if (!is_mobile($mobile)) {
                return $this->result(0, "请输入正确的手机号码");
            }
            $nextTime = cache_load("sms_nextTime");
            if (!empty($nextTime) && $nextTime > time()) {
                return $this->result(0, "距离下次发送还剩" . ($nextTime - time()) . "秒~");
            }
            $randCode = mt_rand(1000, 9999);
            $sms = send_aliyun_sms($mobile, array("code" => $randCode));
            if (empty($sms["Code"]) || strtolower($sms["Code"]) !== "ok") {
                return $this->result(0, !empty($sms["Message"]) ? $sms["Message"] : "短信发送失败!");
            }
            cache_write("sms_Code", $randCode);
            cache_write("sms_nextTime", time() + 180);
            cache_write("sms_mobile", $mobile);
            return $this->result(0, "短信已发送, 请注意查收");
        }
        if (empty($mobile)) {
            return $this->result(0, "手机号不能为空！");
        }
        $randCode = cache_load("sms_Code");
        $nextTime = cache_load("sms_nextTime");
        $smsMobile = cache_load("sms_mobile");
        if (empty($randCode) || empty($nextTime) || empty($smsMobile)) {
            return $this->result(0, "尚未接收短息验证码" . "-" . $randCode . "-" . $nextTime . "-" . $smsMobile);
        }
        if ($smsMobile != $mobile) {
            return $this->result(0, "请输入接收验证码的手机号");
        }
        if ($randCode != $smscode) {
            return $this->result(0, "请输入正确的验证码");
        }
        if (empty($_W["openid"]) || empty($_W["fans"])) {
            return $this->result(0, "请先进行小程序授权！");
        }
        $conpon_id = !empty($_GPC["id"]) ? intval($_GPC["id"]) : 0;
        $exitscoupon = pdo_get("make_speed_user_coupons", array("user_id" => $GLOBALS["CURRENT_USER"], "coupon_id" => $conpon_id), array("id"));
        if (!empty($exitscoupon)) {
            return $this->result(0, "很抱歉，您已领取过该优惠券");
        }
        $add = pdo_insert("make_speed_user_coupons", array("user_id" => $GLOBALS["CURRENT_USER"], "coupon_id" => $conpon_id));
        if (!empty($add)) {
            return $this->result(0, "恭喜你, 领取成功！", array($add));
        }
        return $this->result(0, "领取失败！请稍后重试");
    }
    public function doPageUserMessage()
    {
        global $_W, $_GPC;
        $type = !empty($_GPC["type"]) ? intval($_GPC["type"]) : 0;
        $page = !empty($_GPC["page"]) ? intval($_GPC["page"]) : 0;
        $limit = !empty($_GPC["limit"]) ? intval($_GPC["limit"]) : 0;
        $page > 0 || ($page = 1);
        $limit > 0 || ($limit = 10);
        $where = array("uniacid" => $GLOBALS["uniacid"]);
        if (empty($type)) {
            $where["type"] = 1;
            $where["user_id"] = $GLOBALS["CURRENT_USER"];
            $filed = array("id", "title", "summary", "add_time", "is_read");
        } else {
            $where["type"] = 0;
            $filed = array("id", "title", "summary", "add_time", "img", "is_read");
        }
        $results = pdo_getall("make_speed_user_message", $where, $filed, '', array("id desc"), array($page, $limit));
        if (empty($results)) {
            return $this->result(0, '');
        }
        foreach ($results as $k => $v) {
            $results[$k]["add_time"] = !empty($type) ? date("Y年m月d H:i", $v["add_time"]) : date("m月d H:i", $v["add_time"]);
            $results[$k]["img"] = toimgurl($v["img"]);
        }
        $ids = array_column($results, "id");
        pdo_update("make_speed_user_message", array("is_read" => 1), array("id" => $ids));
        return $this->result(0, '', $results);
    }
    public function doPageIsNewMessage()
    {
        $where = array("uniacid" => $GLOBALS["uniacid"], "user_id" => $GLOBALS["CURRENT_USER"], "is_read" => 0);
        $result = pdo_get("make_speed_user_message", $where, array("id"));
        $where = array("uniacid" => $GLOBALS["uniacid"], "type" => 0, "is_read" => 0);
        empty($result) && ($result = pdo_get("make_speed_user_message", $where, array("id")));
        if (empty($result)) {
            return $this->result(0, '', -1);
        }
        return $this->result(0, '', 1);
    }
    public function doPageUserMessageDetail()
    {
        global $_W, $_GPC;
        $id = !empty($_GPC["id"]) ? intval($_GPC["id"]) : 0;
        $result = pdo_get("make_speed_user_message", array("id" => $id), array("title", "content"));
        $result["content"] = str_replace("\"/addons/make_speed/core", "\"" . $_W["siteroot"] . "/addons/make_speed/core", $result["content"], $i);
        return $this->result(0, '', $result);
    }
    public function doPageUserinfo()
    {
        global $_W;
        global $_GPC;
        $user = pdo_get("make_speed_user", array("id" => $GLOBALS["CURRENT_USER"]), array("user_grade", "valid", "gral"));
        $grade = pdo_get("make_speed_user_grade", array("id" => $user["user_grade"]), array("name", "grow", "icon", "grade"));
        $path = MODULE_URL . "core/public/";
        $default_icon = "/uploads/program_icon/client/user_grade_icon0.png";
        $default_vip = "/uploads/program_icon/client/user_vip_icon0.png";
        $coupon = pdo_get("make_speed_user_coupons", array("user_id" => $GLOBALS["CURRENT_USER"], "status" => 0), array("COUNT(*) AS count"));
        $data = array("userinfo" => array("name" => "普通用户", "icon" => $path . $default_icon), "coupontotal" => intval($coupon["count"]), "user_valid" => $user["valid"], "user_gral" => $user["gral"]);
        if (!empty($grade)) {
            $grade["icon"] = !empty($grade["icon"]) ? $path . $grade["icon"] : $path . $default_vip;
            $data["userinfo"] = $grade;
        }
        return $this->result(0, '', $data);
    }
    public function doPageGetBanner()
    {
        global $_GPC, $_W;
        $results = pdo_getall("make_speed_banner", array("uniacid" => $GLOBALS["uniacid"], "disabled" => 0));
        if (empty($results)) {
            $this->result(0, '');
        }
        foreach ($results as $k => $v) {
            $results[$k]["img"] = toimgurl($v["img"]);
        }
        $this->result(0, '', $results);
    }
    public function doPageGetCodeCoupon()
    {
        global $_W, $_GPC;
        $code = !empty($_GPC["code"]) ? strtoupper(trim($_GPC["code"])) : '';
        if (empty($code)) {
            return $this->result(0, "兑换码错误或已失效!");
        }
        $exits = pdo_get("make_speed_user_coupons", array("type" => $code, "user_id" => $GLOBALS["CURRENT_USER"]), array("id"));
        if (!empty($exits)) {
            return $this->result(0, "您已兑换该券无法重复兑换");
        }
        $coupon = pdo_get("make_speed_coupons", array("code" => $code, "uniacid" => $GLOBALS["uniacid"]));
        if (empty($coupon)) {
            return $this->result(0, "请输入正确的兑换码!");
        }
        if ($coupon["code_num"] < 1) {
            return $this->result(0, "该券兑换次数已用完!");
        }
        $data = array("user_id" => $GLOBALS["CURRENT_USER"], "order_type" => $coupon["type"], "type" => $code, "tips" => $coupon["title"], "amount" => $coupon["money"], "coupon_id" => $coupon["id"], "begin_time" => time(), "full_amount" => $coupon["satisfy_money"], "limit_distance" => $coupon["distance"], "expire_time" => strtotime("+" . $coupon["day"] . " day"), "add_time" => time(), "uniacid" => $GLOBALS["uniacid"]);
        $add = pdo_insert("make_speed_user_coupons", $data);
        if (empty($add)) {
            return $this->result(0, "兑换失败请稍后重试");
        }
        return $this->result(0, '', array(pdo_insertid()));
    }
    public function doPageGetOpenbusine()
    {
        $setting = pdo_get("make_speed_setting", array("key" => "open_business", "uniacid" => $GLOBALS["uniacid"]), array("value"));
        $setting = @unserialize($setting["value"]);
        $setting = array_merge($setting);
        if (empty($setting) || count($setting) != 5 || !isset($setting[0]["type"])) {
            $setting = array(array("type" => 0, "status" => true, "title" => "帮我送", "sort" => 3), array("type" => 1, "status" => true, "title" => "帮我买", "sort" => 0), array("type" => 2, "status" => true, "title" => "万能服务", "sort" => 0), array("type" => 3, "status" => true, "title" => "帮我代驾", "sort" => 0));
        }
        $results = array_combine(array_column($setting, "type"), array_column($setting, "status"));
        $this->result(0, '', $results);
    }
    public function doPageAddInvoice()
    {
        global $_W;
        global $_GPC;
        $where = array("uniacid" => $GLOBALS["uniacid"], "user_id" => $GLOBALS["CURRENT_USER"]);
        $wheres = $where;
        $wheres["status"] = array(0, 2);
        $invoice = pdo_get("make_speed_user_invoice", $wheres, array("SUM(amount) as amount"));
        !empty($invoice["amount"]) || ($invoice["amount"] = 0);
        $where["status"] = 1;
        $where["type"] = 0;
        $payamount = pdo_get("make_speed_user_cashlog", $where, array("SUM(amount) as amount"));
        !empty($payamount["amount"]) || ($payamount["amount"] = 0);
        $where["type"] = 2;
        $refunamount = pdo_get("make_speed_user_cashlog", $where, array("SUM(amount) as amount"));
        !empty($refunamount["amount"]) || ($refunamount["amount"] = 0);
        $money = $payamount["amount"] - $refunamount["amount"] - $invoice["amount"];
        $data = array("user_id" => $GLOBALS["CURRENT_USER"], "type_name" => !empty($_GPC["type_name"]) ? trim($_GPC["type_name"]) : '', "type" => !empty($_GPC["type"]) ? intval($_GPC["type"]) : 0, "tax_number" => !empty($_GPC["tax_number"]) ? trim($_GPC["tax_number"]) : '', "content" => !empty($_GPC["content"]) ? trim($_GPC["content"]) : '', "amount" => !empty($_GPC["amount"]) ? sprintf("%.2f", $_GPC["amount"]) : '', "mobile" => !empty($_GPC["mobile"]) ? trim($_GPC["mobile"]) : '', "email" => !empty($_GPC["email"]) ? trim($_GPC["email"]) : '', "add_time" => time(), "uniacid" => $GLOBALS["uniacid"]);
        if ($data["amount"] > $money) {
            $this->result(0, "可申请金额不足!");
        }
        $add = pdo_insert("make_speed_user_invoice", $data);
        if (!empty($add)) {
            $this->result(0, '', array(pdo_insertid()));
        }
        $this->result(0, "申请失败, 请稍后重试");
    }
    public function doPageInvoiceList()
    {
        global $_W;
        global $_GPC;
        $results = pdo_getall("make_speed_user_invoice", array("user_id" => $GLOBALS["CURRENT_USER"], "uniacid" => $GLOBALS["uniacid"]));
        if (empty($results)) {
            $this->result(0, '');
        }
        $status = array("等待开票", "申请不通过", "开票成功");
        foreach ($results as $k => $v) {
            $results[$k]["add_time"] = date("Y-m-d H:i", $v["add_time"]);
            $results[$k]["status_text"] = !empty($status[$v["status"]]) ? $status[$v["status"]] : 0;
        }
        $this->result(0, '', $results);
    }
    public function doPageInvoiceMoney()
    {
        global $_W;
        global $_GPC;
        $where = array("uniacid" => $GLOBALS["uniacid"], "user_id" => $GLOBALS["CURRENT_USER"]);
        $wheres = $where;
        $wheres["status"] = array(0, 2);
        $invoice = pdo_get("make_speed_user_invoice", $wheres, array("SUM(amount) as amount"));
        !empty($invoice["amount"]) || ($invoice["amount"] = 0);
        $where["status"] = 1;
        $where["type"] = 0;
        $payamount = pdo_get("make_speed_user_cashlog", $where, array("SUM(amount) as amount"));
        !empty($payamount["amount"]) || ($payamount["amount"] = 0);
        $where["type"] = 2;
        $refunamount = pdo_get("make_speed_user_cashlog", $where, array("SUM(amount) as amount"));
        !empty($refunamount["amount"]) || ($refunamount["amount"] = 0);
        $money = bcsub($payamount["amount"] - $refunamount["amount"], floatval($invoice["amount"]), 2);
        $this->result(0, '', array("money" => $money));
    }
    public function doPageGetYewu()
    {
        $setting = pdo_get("make_speed_setting", array("key" => "open_business", "uniacid" => $GLOBALS["uniacid"]), array("value"));
        $setting = !empty($setting["value"]) ? @unserialize($setting["value"]) : array();
        if (empty($setting)) {
            $setting = array(array("type" => 0, "status" => true, "title" => "帮我送", "sort" => 3), array("type" => 1, "status" => true, "title" => "帮我买", "sort" => 0), array("type" => 2, "status" => true, "title" => "万能服务", "sort" => 0), array("type" => 3, "status" => true, "title" => "帮我代驾", "sort" => 0));
        }
        $exists = pdo_tableexists("make_speed_vehicle");
        if ($exists && !isset($setting[4])) {
            array_push($setting, array("type" => 4, "status" => true, "title" => "货运", "sort" => 0));
        }
        $img = array("present", "buy", "line_up", "replace_driver", "freight", "homemaking");
        foreach ($setting as $k => $v) {
            $setting[$k]["img"] = !empty($img[$v["type"]]) ? $img[$v["type"]] : "present";
        }
        array_multisort(array_column($setting, "sort"), SORT_DESC, $setting);
        return $this->result(0, '', $setting);
    }
    public function doPageGetWxMobile()
    {
        global $_W, $_GPC;
        $encryptedData = !empty($_GPC["encryptedData"]) ? $_GPC["encryptedData"] : '';
        $iv = !empty($_GPC["iv"]) ? $_GPC["iv"] : '';
        $wxapp = pdo_get("account_wxapp", array("uniacid" => $GLOBALS["uniacid"]), array("key"));
        $appid = !empty($wxapp["key"]) ? $wxapp["key"] : '';
        $sessionKey = !empty($_SESSION["session_key"]) ? $_SESSION["session_key"] : '';
        if (strlen($sessionKey) != 24) {
            return $this->result(0, "-41001");
        }
        $aesKey = base64_decode($sessionKey);
        if (strlen($iv) != 24) {
            return $this->result(0, "-41002");
        }
        $aesIV = base64_decode($iv);
        $aesCipher = base64_decode($encryptedData);
        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        $dataObj = json_decode($result);
        if ($dataObj == NULL) {
            return $this->result(0, "-41003 aes 解密失败");
        }
        if ($dataObj->watermark->appid != $appid) {
            return $this->result(0, "-41003 aes解密失败");
        }
        $data = json_decode($result, true);
        if (!empty($data["phoneNumber"])) {
            pdo_update("make_speed_user", array("mobile" => $data["phoneNumber"]), array("id" => $GLOBALS["CURRENT_USER"]));
        }
        return $this->result(0, '', $data);
    }
    public function doPagetestdoc()
    {
        $test = Server\PushOrderType::getTechnician(1167);
        var_dump($test);
    }
}
?>