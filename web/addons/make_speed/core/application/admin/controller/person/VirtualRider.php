<?php
/**
 * Created by PhpStorm.
 * User: HelloWord
 * Date: 2019/10/26
 * Time: 16:45
 */

namespace app\admin\controller\person;
use app\common\controller\Backend;
use think\Db;


class VirtualRider extends Backend
{
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\VirtualRider();
        $this->view->assign("isShowList", $this->model->getIsShowList());

    }

    public function add()
    {
        $tencentKey = Db::name('setting')->where(['key'=>'tencent_key','uniacid' => $GLOBALS['uniacid']])->value('value');
        if (!$tencentKey) {
            $this->error('腾讯地图key未配置');
        }

        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
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
        $this->view->assign([
            "tencentKey"=> $tencentKey
        ]);
        return $this->view->fetch();
    }

    /**
     * 编辑
     */
    public function edit($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $tencentKey = Db::name('setting')->where(['key'=>'tencent_key','uniacid' => $GLOBALS['uniacid']])->value('value');
        if (!$tencentKey) {
            $this->error('腾讯地图key未配置');
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
                        $row->validateFailException(true)->validate($validate);
                    }
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
        $this->view->assign([
            "row"       => $row,
            "tencentKey"=> $tencentKey
        ]);
        return $this->view->fetch();
    }

    public function distribution(){
        $tencentKey = Db::name('setting')->where(['key'=>'tencent_key','uniacid' => $GLOBALS['uniacid']])->value('value');
        $riders     = Db::name('virtual_rider')->where(['is_show'=>1,'uniacid' => $GLOBALS['uniacid']])->field('lat,lng')->select();

        $this->view->assign([
            'tencentKey'  => $tencentKey,
            'riders'      => $riders
        ]);
        return $this->view->fetch();
    }



}