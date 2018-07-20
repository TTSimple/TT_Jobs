<?php

namespace Home\Example;

use Core\Swoole\Server;
use Core\Swoole\Task\TaskManager;
use Core\Swoole\Timer;
use Core\Component\Socket\Dispatcher;
use Home\Model\WebSock\Parser;
use Home\Model\WebSock\Register;


// Web Socket Command Parser
class WebSocketCommandParser
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    // 添加定时广播
    function onWorkerStart(\swoole_server $server, $workerId)
    {
        //如何避免定时器因为进程重启而丢失
        //例如，我第一个进程，添加一个10秒的定时器
        if ($workerId == 0) {
            Timer::loop(3 * 1000, function () {
                /*
                * 注意   本example未引入redis来做fd信息记录，因此每次采用遍历的形式来获取结果，
                * 仅供思路参考，不建议在生产环节使用
                 */
                $list = [];
                foreach (Server::getInstance()->getServer()->connections as $fd) {
                    $info = Server::getInstance()->getServer()->connection_info($fd);
                    if ($info['websocket_status']) {
                        $list[] = $fd;
                    }
                }
                //广播属于重任务，交给Task执行
                TaskManager::getInstance()->add(function () use ($list) {
                    foreach ($list as $fd) {
                        Server::getInstance()->getServer()->push($fd, "this is tick broadcast ");
                    }
                });
            });
        }
    }

    // 添加监听
    function beforeWorkerStart(\swoole_server $server)
    {
        $server->on("message", function (\swoole_websocket_server $server, \swoole_websocket_frame $frame) {
            Dispatcher::getInstance(Register::class, Parser::class)->dispatchWEBSOCK($frame);
        });
    }
}
