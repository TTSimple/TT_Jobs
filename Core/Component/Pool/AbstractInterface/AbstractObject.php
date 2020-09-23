<?php

namespace Core\Component\Pool\AbstractInterface;


abstract class AbstractObject
{
    protected abstract function gc();

    //使用后,free的时候会执行
    abstract function initialize();

    function __destruct()
    {
        $this->gc();
    }
}