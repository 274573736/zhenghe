<?php
namespace Server\order;

class OrderList{

    public function getStatusWhere($status){
        $where = array();
        switch ($status){
            case 0:
                $where['o.status >'] = 2;//全部
                break;
            case 2:
                $where['o.status'] = 2;//待抢单
                break;
            case 3:
                $where['o.status'] = 3; break;//待取件
            case 4:
                $where['o.status'] = 4; //待送达
                break;
            case 5:
                $where['accept_time >='] = strtotime(date('Y-m-d'));
                $where['accept_time <']  = strtotime(date('Y-m-d',strtotime("+1 day")));//当天抢单记录
                break;
            case 6:
                $where['o.status'] = [0,5,6];//已完成
                break;
            case 7:
                $where['o.status'] = 1;//已取消
                break;
            default:
                $where['o.status >='] = 3;
                $where['o.status <='] = 4;//进行中
                break;
        }
        return $where;
    }

    public function order_list(){
        $sql = "SELECT * FROM ".tablename('make_speed_order')." AS o leftjoin ";
    }
}