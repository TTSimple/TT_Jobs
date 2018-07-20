<?php
/**
 * Created by PhpStorm.
 * User: safer
 * Date: 2018/5/25
 * Time: 0:22
 */

namespace Home\Example\RPC;


use Core\Component\RPC\AbstractInterface\AActionRegister;
use Core\Component\RPC\Common\ActionList;
use Core\Component\RPC\Common\Package;
use Core\Component\Socket\Client\TcpClient;

/**
 * Class User2
 * @package Home\RPC
 */
class User2 extends AActionRegister
{
    function register(ActionList $actionList)
    {
        $actionList->registerAction('who', function (Package $req, Package $res, TcpClient $client) {
            var_dump('your req package is' . $req->__toString());
            $res->setMessage('this is User.who');
        });

        $actionList->registerAction('login', function (Package $req, Package $res, TcpClient $client) {
            var_dump('your req package is' . $req->__toString());
            $res->setMessage('this is User.login');
        });

        $actionList->setDefaultAction(function (Package $req, Package $res, TcpClient $client) {
            $res->setMessage('this is user.default');
        });

    }
}