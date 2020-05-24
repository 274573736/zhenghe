<?php

namespace app\admin\controller\distribution;

use app\common\controller\Backend;
use think\Db;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Distributor extends Backend
{
    
    /**
     * Distributor模型对象
     * @var \app\admin\model\distribution\Distributor
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\distribution\Distributor;
        $this->view->assign("statusList", $this->model->getStatusList());
    }

    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = false;
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['user','grade','superior'])
                    ->where( ['uniacid'=>$GLOBALS['uniacid'] ])
                    ->where(['is_distributor'=>1])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['user','grade','superior'])
                    ->where( ['uniacid'=>$GLOBALS['uniacid'] ])
                    ->where(['is_distributor'=>1])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();


            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        $this->assignconfig('url',tp_url('admin/person/user'));
        return $this->view->fetch();
    }

    public function userInfo(){
        $id     = $this->request->get('id');
        $user   = \think\Db::name('user')->field(['nick_name','id','avatar','add_time'])->find(['id'=>$id]);

        return $this->fetch('',[
            'user'  => $user
        ]);
    }

    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            $params['uniacid'] = $GLOBALS['uniacid'];

            if ($params) {
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : true) : $this->modelValidate;
                        $row->validate($validate);
                    }
//
//                    if($params['status'] == 1){
//                        $params['is_distributor'] = 1;
//                    }else{
//                        $params['is_distributor'] = 0;
//                    }

                    $result = $row->allowField(true)->save($params);
                    if ($result !== false) {
                        $this->success();
                    } else {
                        $this->error($row->getError());
                    }
                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                } catch (\think\Exception $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    public function detail($ids){
        $list = Db::name('distribution_distributor')->where([ 'pid'=>['neq',0] ])->field(['pid','user_id'])->select();
        $uid  = Db::name('distribution_distributor')->where(['id'=>$ids])->value('user_id');
        $down = $this->down_list($list,$uid);
        return $this->fetch('',[
            'list'  => $down
        ]);
    }

    public function down_list($list, $uid, $level = 1){
        static  $arr = array();
        foreach ($list as $key => $v) {
            if ($v['pid'] == $uid) {
                    $user = Db::name('user')->where([ 'id'=>$v['user_id'] ])->field(['id','nick_name','avatar','add_time'])->find();
                    $user['level'] = $level;
                    if($level > 3 ){
                        return $arr;
                    }
                    array_push($arr,$user);

                $this->down_list($list, $v['user_id'],$level + 1);
            }
        }
        return $arr;
    }

    public function poster($ids){
        if ($this->request->isAjax()) {
            $userID = $this->model->where(['id' => $ids])->value('user_id');
            $qrcoPath   = ROOT_PATH . 'public/uploads/qrcode/qrcode' . $userID . '.png';

            if(!is_file($qrcoPath)){
                $this->createQrcode($userID);
            }

            $imagePath = '/uploads/qrcode/qrcode_'.$userID.'.png';
            $this->success('success', '', ['img' => $imagePath]);

        }
    }

    public function createQrcode($user_id){

        $accessToken = get_access_token();
        $url         = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$accessToken;
        $data        = [ 'path' => 'make_speed/router/router?recommend_id='.$user_id ];
        $response    = setRequest($url,json_encode($data) );
        $dir = ROOT_PATH . 'public/uploads/qrcode/';
        if(!is_dir($dir))
            mkdir($dir, 0775, true);

        $file = 'qrcode_' . $user_id .'.png';
        $re = file_put_contents($dir.$file,$response);
        if(!$re){
            $this->error('生成小程序二维码失败！');
        }
        return true;
    }

    public function selectpage()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags', 'htmlspecialchars']);

        //搜索关键词,客户端输入以空格分开,这里接收为数组
        $word = (array)$this->request->request("q_word/a");
        //当前页
        $page = $this->request->request("pageNumber");
        //分页大小
        $pagesize = $this->request->request("pageSize");
        //搜索条件
        $andor = $this->request->request("andOr", "and", "strtoupper");
        //排序方式
        $orderby = (array)$this->request->request("orderBy/a");
        //显示的字段
        $showField = $this->request->request("showField");
        //主键
        $primarykey = $this->request->request("keyField");
        //主键值
        $primaryvalue = $this->request->request("keyValue");
        //搜索字段
        $searchfield = (array)$this->request->request("searchField/a");
        //自定义搜索条件
        $custom = (array)$this->request->request("custom/a");
        $order = [];
        foreach ($orderby as $k => $v) {
            $order[$v[0]] = $v[1];
        }

        $field = $showField ? $showField : 'name';

        $searchfield = explode("|",implode('',$searchfield));

        $field = explode("|",$field);

        //如果有primaryvalue,说明当前是初始化传值
        if ($primaryvalue !== null) {
            $where = [$primarykey => ['in', $primaryvalue]];
        } else {
            $where = function ($query) use ($word, $andor, $field, $searchfield, $custom) {
                $logic = $andor == 'AND' ? '&' : '|';
                $searchfield = is_array($searchfield) ? implode($logic, $searchfield) : $searchfield;
                foreach ($word as $k => $v) {
                    $query->where(str_replace(',', $logic, $searchfield), "like", "%{$v}%");
                }
                if ($custom && is_array($custom)) {
                    foreach ($custom as $k => $v) {
                        $query->where($k, '=', $v);
                    }
                }
            };
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            $this->model->where($this->dataLimitField, 'in', $adminIds);
        }
        $list = [];

        $where1 = array('uniacid'=>$GLOBALS['uniacid'],'is_distributor' => 1,'status' => 1);
        $total = $this->model->where($where)->where($where1)->count();
        if ($total > 0) {
            if (is_array($adminIds)) {
                $this->model->where($this->dataLimitField, 'in', $adminIds);
            }
            $datalist = $this->model->where($where)
                ->where($where1)
                ->order($order)
                ->page($page, $pagesize)
                ->field(['user_id','name'])
                ->select();
            foreach ($datalist as $index => $item) {
                unset($item['password'], $item['salt']);

                $list[$index] = [
                    $primarykey => isset($item[$primarykey]) ? $item[$primarykey] : '',
                ];

                $list[$index][$showField] = '';
                foreach($field as $f){
                    $list[$index][$showField] .= isset($item[$f]) ? $item[$f].' / ' : '';
                }
                $list[$index][$showField] = rtrim($list[$index][$showField],"/ ");
            }
        }
        //这里一定要返回有list这个字段,total是可选的,如果total<=list的数量,则会隐藏分页按钮
        return json(['list' => $list, 'total' => $total]);
    }
}
