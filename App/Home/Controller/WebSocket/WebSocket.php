<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/24
 * Time: 18:01
 */

namespace Home\Controller\WebSocket;

use Core\AbstractInterface\AHttpController as Controller;
use Core\Component\Logger;
use Core\Swoole\Task\TaskManager;
use Core\Swoole\Server;

/**
 * Class WebSocket
 * @package Home\Controller\WebSocket
 */
class WebSocket extends Controller
{
    function index()
    {
        $this->display('WebSocket/client');
    }

    // 推送
    function push()
    {
        /*
         * url :/webSocket/push/index.html?fd=xxxx
         */
        $fd   = $this->request()->getRequestParam("fd");
        $info = Server::getInstance()->getServer()->connection_info($fd);
        if ($info['websocket_status']) {
            Logger::getInstance()->console("push data to client {$fd}");
            Server::getInstance()->getServer()->push($fd, "data from server at " . time());
            $this->response()->write("push to fd :{$fd}");
        } else {
            $this->response()->write("fd {$fd} not a websocket");
        }
    }

    // 当前链接数
    function connectionList()
    {
        /*
         * url:/webSocket/connectionList/index.html
         * 注意   本example未引入redis来做fd信息记录，因此每次采用遍历的形式来获取结果，
         * 仅供思路参考，不建议在生产环节使用
         */
        $server = Server::getInstance()->getServer();
        $list   = [];
        foreach ($server->connections as $connection) {
            $info = $server->connection_info($connection);
            if ($info['websocket_status']) {
                $list[] = $connection;
            }
        }
        $list = Server::getInstance()->getServer()->connection_list();
        $this->response()->writeJson(200, $list, "this is all websocket list");
    }

    // 广播
    function broadcast()
    {
        /*
         * url :/webSocket/broadcast/index.html?fds=xx,xx,xx
         */
        $fds = $this->request()->getRequestParam("fds");
        $fds = explode(",", $fds);
        TaskManager::getInstance()->add(function () use ($fds) {
            foreach ($fds as $fd) {
                Server::getInstance()->getServer()->push($fd, "this is broadcast");
            }
        });
        $this->response()->write('broadcast to client');
    }

    // 广播全部
    function broadcastAll()
    {
        /*
         * url :/webSocket/broadcastAll
         */
        $fds = [];
        foreach (Server::getInstance()->getServer()->connections as $connection) {
            $info = Server::getInstance()->getServer()->connection_info($connection);
            if ($info['websocket_status']) {
                $fds[] = $connection;
            }
        }
        TaskManager::getInstance()->add(function () use ($fds) {
            foreach ($fds as $fd) {
                Server::getInstance()->getServer()->push($fd, "this is broadcast all");
            }
        });
        $this->response()->write('broadcast to all client');
    }
}
