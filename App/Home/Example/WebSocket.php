<?php

namespace Home\Example;

use Core\Swoole\Server;
use Core\Component\Logger;
use Core\Utility\Random;


// WebSocket
class WebSocket
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
            Logger::getInstance()->console("receive data " . $frame->data);
            $json = json_decode($frame->data, 1);
            if (is_array($json)) {
                if ($json['action'] == 'who') {
                    //可以获取bind后的uid
                    //var_dump($server->connection_info($frame->fd));
                    $server->push($frame->fd, "your fd is " . $frame->fd);
                } else {
                    $server->push($frame->fd, "this is server and you say :" . $json['content']);
                }
            } else {
                $server->push($frame->fd, "command error");
            }
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

            $key     = base64_encode(sha1($request->header['sec-websocket-key']
                . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11',
                true));
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
            //注意 一定要有101状态码，协议规定
            $response->status(101);
            Logger::getInstance()->console('fd is ' . $request->fd);
            //再做标记，保证唯一性，此操作可选
            Server::getInstance()->getServer()->bind($request->fd, time() . Random::randNumStr(6));
            $response->end();
            return true;
        });

        $server->on("close", function ($ser, $fd) {
            Logger::getInstance()->console("client {$fd} close");
        });
    }
}
