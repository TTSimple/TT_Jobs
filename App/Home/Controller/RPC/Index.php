<?php
/**
 * Created by PhpStorm.
 * User: safer
 * Date: 2018/5/25
 * Time: 0:28
 */

namespace Home\Controller\RPC;

use Core\AbstractInterface\AHttpController as Controller;
use Core\Component\RPC\Client\Client as RPCClient;
use Core\Component\RPC\Common\Config as RPCConfig;
use Core\Component\RPC\Common\Package as RPCPackage;

/**
 * Class Index
 * @package Home\Controller\RPC
 */
class Index extends Controller
{
    function index()
    {
        $conf = new RPCConfig();
        $conf->setPort(9502);
        $conf->setHost('127.0.0.1');

        $client = new RPCClient();

        $server1 = $client->selectServer($conf);
        $server1->addCall('user','who',null,function (RPCPackage $req,RPCPackage $res){
            echo "call success at".$res->__toString()."\n";
        },function (RPCPackage $req,RPCPackage $res){
            echo "call fail at".$res->__toString()."\n";
        });

        $server1->addCall("user",'login',[1,2,3,4],function (RPCPackage $req,RPCPackage $res){
            echo "call success at".$res->__toString()."\n";
        });

        $server1->addCall("user",'404',[1,2,3,4],function (RPCPackage $req,RPCPackage $res){
            echo "call success at".$res->__toString()."\n";
        });

        $server1->addCall('goods','404',null,function (){
            echo "success"."\n";
        });

        $conf2 = new RPCConfig();
        $conf2->setHost('127.0.0.1');
        $conf2->setPort(9503);

        $server2 = $client->selectServer($conf2);
        $server2->addCall('user','404',null,function (){
            echo "success at server 2";
        });

        $client->call();
    }
}