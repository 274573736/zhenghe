<?php

namespace app\admin\controller\freight;

use app\admin\controller\freight\Fbase;

use think\Db;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Vehicle extends Fbase
{
    
    /**
     * Vehicle模型对象
     * @var \app\admin\model\freight\Vehicle
     */
    protected $model = null;

    public function _initialize()
    {
        $table      = 'vehicle';
        $this->checkPlug($table);
        parent::_initialize();
        $this->model = new \app\admin\model\freight\Vehicle;

    }

    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->where($where)
                ->where(['uniacid'=>$GLOBALS['uniacid'] ])
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->where($where)
                ->where(['uniacid'=>$GLOBALS['uniacid'] ])
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            $size   = $this->request->post("size/a");
            $xuc    = array_filter($this->request->post("xuc/a"));
            $per_km = array_filter($this->request->post("per_km/a"));
            $load   = array_filter($this->request->post("load_price/a"));
            $weight = $this->request->post("added_weight/a");
            $cub    = $this->request->post("cub/a");

            if ($params) {
                if ( !$load ){
                    $this->error('请输入装卸计费');
                }

                if($weight){
                    $params['added_weight'] = @serialize( $this->weightInfo($weight) );
                }
                if ($cub ){
                    $params['cub_price']    = @serialize( $this->cubInfo($cub) );
                }
                $params['load_price']   = serialize( $this->loadInfo($load) );

                if(!$xuc || !$per_km){
                    return $this->error('请输入续程或价格');
                }elseif(count($xuc) !== count($per_km)){
                    return $this->error('请填写完续程或价格');
                }
                $xuc    = array_combine($xuc,$per_km);
                $params['xuc']     = serialize($xuc);
                $params['size']    = serialize($size);
                $params['uniacid'] = $GLOBALS['uniacid'];

                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validateFailException(true)->validate($validate);
                    }
                    $result = $this->model->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were inserted'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }

    public function edit($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            $size   = $this->request->post("size/a");
            $xuc    = array_filter($this->request->post("xuc/a"));
            $per_km = array_filter($this->request->post("per_km/a"));
            $load   = array_filter($this->request->post("load_price/a"));
            $weight = array_filter($this->request->post("added_weight/a"));
            $cub    = array_filter($this->request->post("cub/a") );

            if(!$xuc || !$per_km){
                return $this->error('请输入续程或价格');
            }elseif(count($xuc) !== count($per_km)){
                return $this->error('续程和价格的个数要匹配');
            }
            $xuc    = array_combine($xuc,$per_km);

            if ($params) {
                if ( !$load ){
                    $this->error('请输入装卸计费');
                }
                if($weight){
                    $params['added_weight'] = serialize( $this->weightInfo($weight) );
                }
                if ($cub ){
                    $params['cub_price']    = serialize( $this->cubInfo($cub) );
                }

                $params['load_price']   = serialize( $this->loadInfo($load) );

                $params['xuc']     = serialize($xuc);
                $params['size']    = serialize($size);

                $result = false;
                Db::startTrans();
                try {
                    $result = $row->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were updated'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }

        $row['xuc']  = unserialize($row['xuc']);
        $row['size'] = unserialize($row['size']);
        $row['added_weight'] = @unserialize($row['added_weight']);
        $row['load_price']   = @unserialize($row['load_price']);
        $row['cub_price']   = @unserialize($row['cub_price']);

//        dump($row->toArray());die;
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    public function loadInfo($load){
        $arr    = [];
        foreach ($load as $k=>$v){
            foreach ($v as $k1=>$v1){
                if($k == 'load_kg'){
                    $arr[$k1]['kg'] = $v1;
                    unset($v[$k1]);
                }elseif ($k == 'per_load_kg' ){
                    $arr[$k1]['per_kg'] = $v1;
                    unset($v[$k1]);
                }elseif ($k == 'per_load_price'){
                    $arr[$k1]['price'] = $v1;
                    unset($v[$k1]);
                }
            }
        }
        return $arr;
    }

    public function weightInfo($weight){
        $arr    = [];
        foreach ($weight as $k=>$v){
            foreach ($v as $k1=>&$v1){
                if($k == 'we_kg'){
                    $arr[$k1]['kg'] = $v1;
                    unset($v[$k1]);
                }elseif ($k == 'per_we_kg' ){
                    $arr[$k1]['per_kg'] = $v1;
                    unset($v[$k1]);
                }elseif ($k == 'per_we_price'){
                    $arr[$k1]['price'] = $v1;
                    unset($v[$k1]);
                }
            }
        }
        return $arr;
    }

    public function cubInfo($cub){
        $arr    = [];
        foreach ($cub as $k=>$v){
            foreach ($v as $k1=>&$v1){
                if($k == 'start'){
                    $arr[$k1]['start'] = $v1;
                    unset($v[$k1]);
                }elseif ($k == 'per_cub' ){
                    $arr[$k1]['per_cub'] = $v1;
                    unset($v[$k1]);
                }elseif ($k == 'per_cub_price'){
                    $arr[$k1]['price'] = $v1;
                    unset($v[$k1]);
                }
            }
        }
        return $arr;
    }



    public  function selectpage()
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

        $where1 = array('uniacid'=>$GLOBALS['uniacid']);

        $total = $this->model->where($where)->where($where1)->count();
        if ($total > 0) {
            if (is_array($adminIds)) {
                $this->model->where($this->dataLimitField, 'in', $adminIds);
            }
            $datalist = $this->model->where($where)
                ->where($where1)
                ->order($order)
                ->page($page, $pagesize)
                ->field($this->selectpageFields)
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
