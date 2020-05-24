<?php

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;
use \Workerman\Lib\Timer;


class Events
{
    /**
     * 当客户端连接时触发
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        var_dump($client_id);

        // 向当前client_id发送数据 
        //Gateway::sendToClient($client_id, "Hello $client_id\r\n");
        // 向所有人发送
        //Gateway::sendToAll("$client_id login\r\n");
    }
    
   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
   public static function onMessage($client_id, $message)
   {
//       $a = file_get_contents("https://t.xiaomawei.com/addons/make_speed/function/DesignateDriver.php");
//       var_dump($a);
//
//       require __DIR__ . '/../../../function/DesignateDriver.php';
//       var_dump(complateOrder(48,836)) ;

       echo "\n[".date('Y-m-d H:i')."] accept from <{$client_id}> send data: $message \n";

       parse_str($message, $data);

       var_dump(Gateway::getAllUidList());

       $type = !empty($data['type']) ? strtolower($data['type']) : '';

       switch ($type){
           case 'place_order':
               self::place_order($client_id, $data);
               break;

           case 'bind_rider':
                self::bind_rider($client_id, $data);
               break;

           case 'accept_order':
               self::accept_order($client_id, $data);
               break;

           case 'pc_message':
               self::pc_bind($client_id, $data);
               break;

           case 'rider_position':
               self::rider_position($client_id, $data);
               break;
           case 'send_coord':
               self::send_coord($client_id,$data);
               break;

           default: break;
       }

        // 向所有人发送 
        //Gateway::sendToAll("$client_id said $message\r\n");
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id)
   {
       $uid = Gateway::getUidByClientId($client_id);
       var_dump("\n[".date('Y-m-d H:i:s')."] uid:".$uid." closed\n");
       // 向所有人发送 
//       GateWay::sendToClient($client_id,json_encode(['type'=>'close']));
   }

   private static function place_order($client_id, $data){

       if(empty($data['order_id']))
           return false;

       Gateway::bindUid($client_id, 'order'.$data['order_id']);
       Gateway::sendToClient($client_id,json_encode(['rid'=>'bind success: order'.$data['order_id'],'type'=>'bind_order']));


       if(!empty($data['rider_id'])) {
           Gateway::joinGroup($client_id, 'rider-'.$data['rider_id']);
       }

       $city = empty($data['city_id']) ? '' : (','.$data['city_id']);
	
//        if(isset($data['data'])){
//               Gateway::sendToGroup('pc_message', $data['order_id'].$city);
//        }
	
       if(empty($data['data']))
           return false;

       $datas = explode('|', $data['data']);

       $rids = explode(',', $datas[0]);
       var_dump($rids);
       foreach ($rids as $v){
           $online = Gateway::isUidOnline(intval($v));
           if(!empty($online)){
               Gateway::sendToUid(intval($v),json_encode(['order_id'=>$data['order_id'],'type' => 'update_order']));
           }
       }
       $i = count($datas);

       if($i > 1) {

           for ($j = 1; $j < $i; $j++) {

               Timer::add(60 * $j, function ($data, $Oid) {
                   echo "Timer " . $data . "\n";
                   $rids = explode(',', $data);

                   foreach ($rids as $v) {
                       $online = Gateway::isUidOnline(intval($v));
                       if (!empty($online)) {
                           Gateway::sendToUid(intval($v), json_encode(['order_id' => $Oid,'type' => 'update_order']));
                       }
                   }

               }, array($datas[$j], $data['order_id']), false);

           }
       }


       return true;
   }

   private static function bind_rider($client_id, $data){
       $rid = !empty($data['rider_id']) ? intval($data['rider_id']) : 0;
       if(!empty($rid)) {
           Gateway::bindUid($client_id, $rid);
       }
       Gateway::sendToClient($client_id,json_encode(['rid'=>'bind success: '.$rid,'type'=>'bind_rider']));

       return true;
   }

   private static function accept_order($client_id, $data){
       empty($data['order_id']) && $data['order_id'] = null;
       echo "[".date('Y-m-d H:i')."] clientid:{$client_id} accept order {$data['order_id']}\n";

       if(empty($data['order_id']))
           return false;

       $online = Gateway::isUidOnline('order'.$data['order_id']);
       if(!empty($online)){
           Gateway::sendToUid('order'.$data['order_id'], json_encode(array('order_id'=>$data['order_id'],'type'=>'update_order')));
       }

       return true;
   }

    private static function pc_bind($client_id, $data){

        Gateway::bindUid($client_id, 'uniacid'.$data['uniacid']);
//        Gateway::joinGroup($client_id, 'pc_message');
        return true;
    }

    private static function rider_position($client_id, $data){
        $redis = self::getRedis();
        $deriverid = $redis->get('driver'.$data['rider_id'] );
        if( $deriverid ){
            self::send_coord($client_id,$data);
        }

        if(isset($data['rider_id'])) {
            $num =  Gateway::getClientIdCountByGroup('rider-' . $data['rider_id']);
            if(!empty($num)) {
                $sendData = json_decode($data['position'],true);
                $sendData['type'] = 'rider_position';
                Gateway::sendToGroup('rider-' . $data['rider_id'], json_encode($sendData));
            }
        }

        return true;
    }


    private static function send_coord($client_id,$data){
        static $next_time;

        if($next_time && (int)$next_time > time()){
            var_dump('距离下次'.intval( $next_time - time() ).'s' );return;
        }

        $redis = self::getRedis();
        $count = $redis->lLen('d'.$data['rider_id']);
        if( $count > 2 ){
            Gateway::sendToUid($data['rider_id'],json_encode(['count' => $count,'type'=>'upload_coord']));
        }

        $position = json_decode($data['position'],true);

        if( isset($position['lat']) && isset($position['lng']) && $data['rider_id'] ){
            list($usec, $sec) = explode(" ", microtime());
            $time = (float)sprintf('%.0f',(floatval($usec)+floatval($sec))*1000);
            $lng  = substr($position['lng'],0,strpos( $position['lng'],'.') ).substr($position['lng'],strpos($position['lng'],'.'),7 );
            $lat  = substr($position['lat'],0,strpos( $position['lat'],'.') ).substr($position['lat'],strpos($position['lat'],'.'),7 );
            $coord = [
                'location'   => $lng.','.$lat,
                'locatetime' => $time,
            ];
            $coord = json_encode($coord);
            $redis->rPush('d'.$data['rider_id'],$coord);
            $next_time = time() + 6;
        }
    }

    private static function getRedis(){
        static $redis;
        if(!$redis){
            $redis = new Redis();
            $redis->connect('127.0.0.1', '6379');
        }
        return $redis;
    }

}
