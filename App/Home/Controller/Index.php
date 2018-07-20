<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/24
 * Time: 18:01
 */

namespace Home\Controller;


use Core\AbstractInterface\AHttpController as Controller;
use Core\Http\Message\Status;
use Core\Swoole\Server;

/**
 * Class Index
 * @package Home\Controller
 */
class Index extends Controller
{
    function index()
    {
        $this->response()->withHeader("Content-type","text/html;charset=utf-8");
        $this->response()->write(file_get_contents("App/Public/index.html"));
    }

    function onRequest($actionName)
    {

    }

    function actionNotFound($actionName = null, $arguments = null)
    {
        $this->response()->withStatus(Status::CODE_NOT_FOUND);
        $this->display('404');
    }

    function afterAction()
    {

    }

    function shutdown(){
        Server::getInstance()->getServer()->shutdown();
    }

    function router(){
        $this->response()->write("your router not end");
    }

}