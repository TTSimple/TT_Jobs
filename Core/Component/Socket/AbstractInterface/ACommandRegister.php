<?php

namespace Core\Component\Socket\AbstractInterface;


use Core\Component\Socket\Common\CommandList;

abstract class ACommandRegister
{
    abstract function register(CommandList $commandList);
}