<?php

namespace Core\Swoole\Pipe;


use Core\Swoole\Server;

class Send
{
    static function send(Message $message, $workerId)
    {
        return Server::getInstance()->getServer()->sendMessage($message->__toString(), $workerId);
    }
}