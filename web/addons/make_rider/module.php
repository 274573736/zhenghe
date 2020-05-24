<?php
/**
 * 本破解程序由易码资源提供
 * 易码资源www.ymzy100.com
 *   承接网站建设、公众号搭建、小程序建设、企业网站
 */
error_reporting(E_ERROR);

defined('IN_IA') or exit('Access Denied');

class Init
{
    public function run()
    {
        global $_W;

        $module_name = !empty($_W['current_module']['name']) ? $_W['current_module']['name'] : 'make_rider';
        $uniacid = $_W['uniacid'];

        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
           
            load()->model('module');
            load()->model('welcome');
            $uni_modules_talbe = table('uni_modules');
            $uni_modules_talbe->searchWithModuleName($module_name);
            $module_info = $uni_modules_talbe->getModulesByUid($_W['uid'], $uniacid);
            
            $module_info = current($module_info['modules']);

            $module_info['welcome_display'] = true;

            $data = array(
                'module_info' => $module_info,
            );          
            
            iajax(0,$data);
        }

        echo "<h4 style='color:red;font-size:26px;text-align: center;margin-top:250px'>骑手端模块无后台管理功能，仅用于更新骑手端小程序，后台管理请从用户端模块进入，如有疑问请联系管理员！</h4>";
        exit;
    
    }

}

(new Init())->run();
exit;