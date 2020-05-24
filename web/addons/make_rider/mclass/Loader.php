<?php
namespace Mclass;

class Loader {
    private static $instance;
    private static $cache = [];

    public static function instance(){
       if (!self::$instance instanceof self) {
           self::$instance = new self();
       }
        return self::$instance;
    }

    public function func($name) {
        $file = MODULE_ROOT.DIRECTORY_SEPARATOR.'function'.DIRECTORY_SEPARATOR. $name . '.php';
        if (isset(self::$cache[$name])) {
            return true;
        }

        if (is_file($file)) {
            include $file;
            self::$cache[$name] = true;
            return true;
        } else {
            throw new Exception($file.'  not exist');
        }
    }

}