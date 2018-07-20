<?php

namespace Home\Example;

use Core\Swoole\Server;
use Core\Swoole\Task\TaskManager;

// 直播
class Live
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function beforeWorkerStart(\swoole_server $server)
    {
        $server->on("message", function (\swoole_websocket_server $server, \swoole_websocket_frame $frame) {
            /*
             * 注意   本example未引入redis来做fd信息记录，因此每次采用遍历的形式来获取结果，
             * 仅供思路参考，不建议在生产环节使用
             */
            $list = [];
            foreach (Server::getInstance()->getServer()->connections as $connection) {
                $info = Server::getInstance()->getServer()->connection_info($connection);
                if ($info['websocket_status']) {
                    $list[] = $connection;
                }
            }
            $data = $frame->data;
            TaskManager::getInstance()->add(function () use ($list, $data) {
                foreach ($list as $fd) {
                    Server::getInstance()->getServer()->push($fd, $data);
                }
            });
        });

        $server->on("handshake", function (\swoole_http_request $request, \swoole_http_response $response) {
            //自定定握手规则，没有设置则用系统内置的（只支持version:13的）
            if (!isset($request->header['sec-websocket-key'])) {
                //'Bad protocol implementation: it is not RFC6455.'
                $response->end();
                return false;
            }
            if (0 === preg_match('#^[+/0-9A-Za-z]{21}[AQgw]==$#', $request->header['sec-websocket-key'])
                || 16 !== strlen(base64_decode($request->header['sec-websocket-key']))
            ) {
                //Header Sec-WebSocket-Key is illegal;
                $response->end();
                return false;
            }

            $key     = base64_encode(sha1($request->header['sec-websocket-key'] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
            $headers = [
                'Upgrade'               => 'websocket',
                'Connection'            => 'Upgrade',
                'Sec-WebSocket-Accept'  => $key,
                'Sec-WebSocket-Version' => '13',
                'KeepAlive'             => 'off',
            ];
            foreach ($headers as $key => $val) {
                $response->header($key, $val);
            }
            $response->status(101);
            $response->end();
            return true;
            // Server::getInstance()->getServer()->push($request->fd,"hello world,your fd is ".$request->fd);
        });
    }
}
