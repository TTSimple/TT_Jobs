<?php
/**
 * Created by PhpStorm.
 * User: safer
 * Date: 2018/5/25
 * Time: 0:21
 */

namespace Home\Example\RPC;


use Core\Component\RPC\AbstractInterface\AActionRegister;
use Core\Component\RPC\Common\ActionList;
use Core\Component\RPC\Common\Package;

/**
 * Class Goods
 * @package Home\RPC
 */
class Goods extends AActionRegister
{

    function register(ActionList $actionList)
    {
        $actionList->setDefaultAction(function (Package $req,Package $res){
            $res->setMessage('this is goods default');
        });
    }
}