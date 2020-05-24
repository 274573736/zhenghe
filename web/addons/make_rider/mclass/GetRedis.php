<?php


namespace Mclass;


class GetRedis
{
    private static $instance = NULL;
    public  static $host = '127.0.0.1';
    public  static $port = 6379;
    public function __construct()
    {
    }
    public function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function instance()
    {
        if (!self::$instance instanceof self) {
            $redis = new \Redis();
            $redis->connect(self::$host, self::$port);
            self::$instance = $redis;
        }
        return self::$instance;
    }

}