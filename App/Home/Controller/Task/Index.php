<?php
/**
 * Created by PhpStorm.
 * User: safer
 * Date: 2018/5/27
 * Time: 19:48
 */

namespace Home\Controller\Task;

use Core\AbstractInterface\AHttpController as Controller;
use Core\Swoole\Task\TaskManager;

class Index extends Controller
{
    function index()
    {
        TaskManager::getInstance()->addSync(function (){
            sleep(2);
            var_dump('this is sync task');
        });
        $this->response()->write('async task add');
    }

    function async()
    {
        TaskManager::getInstance()->add(function (){
            sleep(2);
            var_dump('this is async task');
        });
        $this->response()->write('async task add');
    }
}