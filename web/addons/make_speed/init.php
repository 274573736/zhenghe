<?php 
defined("IN_IA") or exit("Access Denied");
require "autoload.php";
use Mclass\Loader;
function loader()
{
    $loader = Loader::instance();
    return $loader;
}
function msg($msg = '', $data = '', $code = 0)
{
    $params = ["data" => $data, "errno" => $code, "message" => $msg];
    exit(json_encode($params));
}
function dump($var, $echo = true, $label = null, $flags = ENT_SUBSTITUTE)
{
    $label = null === $label ? '' : rtrim($label) . ":";
    ob_start();
    var_dump($var);
    $output = preg_replace("/\\]\\=\\>\\n(\\s+)/m", "] => ", ob_get_clean());
    if (PHP_SAPI == "cli") {
        $output = PHP_EOL . $label . $output . PHP_EOL;
    } else {
        if (!extension_loaded("xdebug")) {
            $output = htmlspecialchars($output, $flags);
        }
        $output = "<pre>" . $label . $output . "</pre>";
    }
    if ($echo) {
        echo $output;
        return;
    }
    return $output;
}
function logger($log_content)
{
    $max_size = 100000;
    $log_filename = "raw-end.txt";
    if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
    file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
}
?>