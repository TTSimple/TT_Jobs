<?php

namespace Core\Component\RPC\Common;


class ActionList
{
    private $list = [];

    function registerAction($name, callable $call)
    {
        $this->list[$name] = $call;
    }

    function setDefaultAction(callable $call)
    {
        $this->list['__DEFAULT__'] = $call;
    }

    function getHandler($name)
    {
        if (isset($this->list[$name])) {
            return $this->list[$name];
        } else {
            return isset($this->list['__DEFAULT__']) ? $this->list['__DEFAULT__'] : null;
        }
    }
}