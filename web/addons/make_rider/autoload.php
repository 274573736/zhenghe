<?php


require_once __DIR__ . '/composer/autoload_real.php';
return ComposerAutoloader::getLoader();


//spl_autoload_register(function ($class_name) {
//    $class_name = str_replace('Model','model',$class_name);
//    $clsName = str_replace("\\",DIRECTORY_SEPARATOR, $class_name);
//    if (is_file(__DIR__.DIRECTORY_SEPARATOR.$clsName.'.php')) {
//        require_once(__DIR__.DIRECTORY_SEPARATOR.$clsName.'.php');
//    }
//});