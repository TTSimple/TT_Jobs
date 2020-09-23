<?php

namespace Core\Component\Socket\Common;


class CommandList
{
    protected $list = [];

    function addCommandHandler($commandStr, callable $callback)
    {
        $this->list[$commandStr] = $callback;
    }

    function setDefaultHandler(callable $callback)
    {
        $this->list['DEFAULT_HANDLER'] = $callback;
    }

    function getHandler(Command $command)
    {
        $name = $command->getCommand();
        if (isset($this->list[$name])) {
            return $this->list[$name];
        } else if (isset($this->list['DEFAULT_HANDLER'])) {
            return $this->list['DEFAULT_HANDLER'];
        } else {
            return null;
        }
    }
}