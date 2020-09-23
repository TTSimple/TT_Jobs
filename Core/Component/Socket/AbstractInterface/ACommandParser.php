<?php

namespace Core\Component\Socket\AbstractInterface;



use Core\Component\RPC\Client\Client;
use Core\Component\Socket\Common\Command;

abstract class ACommandParser
{
    abstract function parser(Command $result, AClient $client, $rawData);
}