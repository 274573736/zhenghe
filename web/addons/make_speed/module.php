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

        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            $module_name = !empty($_W['current_module']['name']) ? $_W['current_module']['name'] : 'make_speed';
            $uniacid = $_W['uniacid'];
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
//        var_dump($_GET['uniacid']);die;
        $url = $_W['siteroot'] . 'addons/' . $_W['current_module']['name'] . '/core/public/index.php/admin/index/index';

        if (file_exists(__DIR__ . '/core/public/index.php')) {
            header('Location:' . $url);
            exit;
        }
    }


}

(new Init())->run();
exit;