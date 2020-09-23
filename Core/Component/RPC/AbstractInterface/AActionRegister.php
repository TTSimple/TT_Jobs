<?php

namespace Core\Component\RPC\AbstractInterface;


use Core\Component\RPC\Common\ActionList;

abstract class AActionRegister
{
    abstract function register(ActionList $actionList);
}