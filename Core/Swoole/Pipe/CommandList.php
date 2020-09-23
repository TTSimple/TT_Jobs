<?php

namespace Core\Swoole\Pipe;


class CommandList
{
    private $list = [];

    function add($command, callable $handler)
    {
        $this->list[$command] = $handler;
        return $this;
    }

    function setDefaultHandler(callable $handler)
    {
        $this->list['__DEFAULT__'] = $handler;
        return $this;
    }

    function getHandler($command)
    {
        if (isset($this->list[$command])) {
            return $this->list[$command];
        } elseif (isset($this->list['__DEFAULT__'])) {
            return $this->list['__DEFAULT__'];
        } else {
            return null;
        }
    }
}