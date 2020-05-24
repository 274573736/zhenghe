<?php
/*
*author:make
*/
namespace app\Console;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class Websocket extends Command{

    protected $server;
    protected function configure()
    {
        $this->setName('websocket:start')->setDescription('Start Web Socket Server!');
    }
    protected function execute(Input $input, Output $output)
    {
        $ws = new \swoole_websocket_server('0.0.0.0',9502,SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);

        $ws->set(array(
            'ssl_cert_file' => __DIR__.'/config/ssl.crt',
            'ssl_key_file' => __DIR__.'/config/ssl.key',
        ));

        //监听WebSocket连接打开事件
        $ws->on('open', function ($ws, $request) {

            foreach($ws->connections as $fd)
            {
                if($request->fd != $fd){
                    $ws->push($fd, "送给小壮gg\n");
                }

            }

            var_dump($request->fd);
            var_dump($request->fd, $request->get, $request->server);
            $ws->push($request->fd, "小壮gg\n");



        });

        //监听WebSocket消息事件
        $ws->on('message', function ($ws, $frame) {
            echo "Message: \n";

            var_dump($frame->data);

            $ws->push($frame->fd, "server: {$frame->data}");
        });

        //监听WebSocket连接关闭事件
        $ws->on('close', function ($ws, $fd) {
            echo "client-{$fd} is closed\n";
        });

        $ws->start();
    }
}