<?php
$redis = new Redis();
$redis->connect('127.0.0.1','6379');
$redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
$redis->psubscribe(array('__keyevent@0__:expired'), 'keyCallback');

function keyCallback($redis, $pattern, $channel, $msg){
    echo $msg;
}