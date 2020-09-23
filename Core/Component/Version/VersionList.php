<?php

namespace Core\Component\Version;


class VersionList
{
    private $list = [];

    function add($name, callable $judge)
    {
        $version           = new Version($name, $judge);
        $this->list[$name] = $version;
        return $version;
    }

    function get($name)
    {
        if (isset($this->list[$name])) {
            return $this->list[$name];
        }
        return null;
    }

    function all()
    {
        return $this->list;
    }
}