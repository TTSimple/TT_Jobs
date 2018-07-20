<?php

namespace Home\Model\WebSock;

use Core\Component\Socket\AbstractInterface\AClient;
use Core\Component\Socket\AbstractInterface\ACommandParser;
use Core\Component\Socket\Common\Command;

// 定义命令解析
class Parser extends ACommandParser
{

    function parser(Command $result, AClient $client, $rawData)
    {
        //这里的解析规则是与客户端匹配的，等会请看客户端代码
        $js = json_decode($rawData, 1);
        if (is_array($js)) {
            if (isset($js['action'])) {
                $result->setCommand($js['action']);
            }
            if (isset($js['content'])) {
                $result->setMessage($js['content']);
            }
        }
    }
}
