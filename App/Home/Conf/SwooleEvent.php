<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/24
 * Time: 17:53
 */

namespace Home\Conf;

use Core\Component\RPC\Server\Server as RPCServer;
use Core\Component\RPC\Common\Config as RPCConfig;

use Core\Swoole\Timer;

/**
 * Class SwooleEvent
 * @package Conf
 */
class SwooleEvent
{

    function frameInitialize()
    {

    }

    function frameInitialized()
    {
    }

    function beforeWorkerStart(\swoole_server $server)
    {
//        // Live
//        \Home\Example\Live::getInstance()->beforeWorkerStart($server);
//
//        // WebSocket
//        \Home\Example\WebSocket::getInstance()->beforeWorkerStart($server);

//        // WebSocketCommandParser
//        \Home\Example\WebSocketCommandParser::getInstance()->beforeWorkerStart($server);

//        // RPC
//        $conf = new RPCConfig();
//        $server = new RPCServer($conf);
//        $server->registerServer('user')->setActionRegisterClass(\Home\Example\RPC\User::class);
//        $server->registerServer('goods')->setActionRegisterClass(\Home\Example\RPC\Goods::class);
//        $server->attach(9502);
//
//        $server2 = new RPCServer($conf);
//        $server2->registerServer('user')->setActionRegisterClass(\Home\Example\RPC\User2::class);
//        $server2->attach(9503);
    }

    function onWorkerStart(\swoole_server $server, $workerId)
    {
//        var_dump('onWorkerStart');
////        ini_set('default_socket_timeout', -1);  //避免在默认的配置下，1分钟后终端了与redis服务器的链接
//        $redis = new \Redis();
//        $redis->connect('127.0.0.1', 6379);
//        $redis->subscribe(['task_queue'], function ($redis, $chan, $msg) {
//            var_dump($chan, $msg);
//            switch ($chan) {
//                case 'task_queue':
//                    $task = unserialize($msg);
//                    var_dump($task);
//                    if ($task['task'] == 'send_email') {
//                        // send email
//                    }
//                    // do other job
//                    break;
//                default:
//                    break;
//            }
//        });
//        Timer::loop(3000, function () {
//            $redis = new \Redis();
//            $redis->connect('127.0.0.1', 6379);
//            $task = [
//                'task'=>'send_email',
//                'data'=>'你好，隔壁老王',
//            ];
//            $redis->publish('task_queue', serialize($task));
//        });
    }
}
