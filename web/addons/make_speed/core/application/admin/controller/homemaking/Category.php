<?php
namespace app\admin\controller\homemaking;
use app\common\controller\Backend;
use fast\Tree;

class Category extends Backend{

    protected $model     = null;
    protected $cateList  = [];
    protected $multiFields = 'is_show';

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\homemaking\Category;
        $cateList = collection($this->model->where(['uniacid'=>$GLOBALS['uniacid'] ])->order('sort', 'desc')->select())->toArray();
        Tree::instance()->init($cateList);
        $this->cateList = Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0), 'title');
        $data = [ 0 => '无'];
        foreach ($this->cateList as $k => &$v) {
            if( $v['pid'] == 0 ){
                $data[$v['id']] = $v['title'];
            }
        }
        $this->assign([ 'data'=>$data ]);
    }

    public function index(){
        if ($this->request->isAjax()) {
            $list = $this->cateList;
            $total = count($this->cateList);

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
    public function add(){
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params['uniacid'] = $GLOBALS['uniacid'];
                $result = $this->model->save($params);

                if ($result === false) {
                    $this->error($this->model->getError());
                }
                $this->success();
            }
            $this->error();
        }
        return $this->view->fetch();
    }

    public function edit($ids = NULL){
        $row = $this->model->get(['id' => $ids]);
        if (!$row)
            $this->error(__('No Results were found'));
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                if($params['pid'] == $row->id){
                    return $this->error('不能选择自己为父级！');
                }
                $result = $row->save($params);
                if ($result === FALSE) {
                    $this->error($row->getError());
                }
                $this->success();
            }
            $this->error();
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    public function del($ids = ""){
        if ($ids) {
            $adminIds = $this->getDataLimitAdminIds();
            if (is_array($adminIds)) {
                $count = $this->model->where($this->dataLimitField, 'in', $adminIds);
            }

            $delIds = [];
            foreach (explode(',', $ids) as $k => $v) {
                $delIds = array_merge($delIds, Tree::instance()->getChildrenIds($v, TRUE));
            }
            $delIds = array_unique($delIds);

            $count = $this->model->where('id', 'in', $delIds)->delete();
            if ($count) {
                $this->success();
            } else {
                $this->error(__('No rows were deleted'));
            }
        }

        $this->error(__('Parameter %s can not be empty', 'ids'));
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
            $pagesize = 100;
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

        $where1 = array('uniacid'=>$GLOBALS['uniacid'],'pid'=>['neq',0]);

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