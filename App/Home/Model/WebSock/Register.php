<?php

namespace Home\Model\WebSock;

use Core\Component\Socket\AbstractInterface\ACommandRegister;
use Core\Component\Socket\Client\TcpClient;
use Core\Component\Socket\Common\Command;
use Core\Component\Socket\Common\CommandList;
use Core\Swoole\Task\TaskManager;
use Core\Swoole\Server;

// 定义命令注册类
class Register extends ACommandRegister
{

    function register(CommandList $commandList)
    {
        $commandList->addCommandHandler('who', function (Command $command, TcpClient $client) {
            return 'your fd is ' . $client->getFd();
        });
        $commandList->addCommandHandler('sendTo', function (Command $command, TcpClient $client) {
            $dest = intval($command->getMessage());
            $info = Server::getInstance()->getServer()->connection_info($dest);
            if ($info['websocket_status']) {
                Server::getInstance()->getServer()->push($dest, 'you receive a message from ' . $client->getFd());
                return 'send success';
            } else {
                return 'fd error';
            }
        });
        $commandList->addCommandHandler('broadcast', function (Command $command) {
            /*
               * 注意   本example未引入redis来做fd信息记录，因此每次采用遍历的形式来获取结果，
               * 仅供思路参考，不建议在生产环节使用
             */
            $message = $command->getMessage();
            $list    = array();
            foreach (Server::getInstance()->getServer()->connections as $fd) {
                $info = Server::getInstance()->getServer()->connection_info($fd);
                if ($info['websocket_status']) {
                    $list[] = $fd;
                }
            }
            //广播属于重任务，交给Task执行
            TaskManager::getInstance()->add(function () use ($list, $message) {
                foreach ($list as $fd) {
                    Server::getInstance()->getServer()->push($fd, "this is broadcast :{$message}");
                }
            });
        });
    }
}
