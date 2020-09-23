<?php

namespace Core\Swoole\Pipe;


abstract class ACommandRegister
{
    abstract function register(CommandList $commandList);
}