<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/24
 * Time: 17:53
 */

namespace Cron\Conf;

use Core\Http\Request;
use Core\Http\Response;
use Core\AbstractInterface\AEvent;
use Common\Cron\Tasks as CronTasks;
use Common\Cron\TasksLoad as CronLoadTasks;
use Common\Cron\Dispatcher as CronDispatcher;
use Common\Cron\ProcessManager as CronProcessManager;
use Cron\Event\onHttpDispatcher;

/**
 * Class SwooleEvent
 * @package Conf
 */
class SwooleEvent extends AEvent
{
    function frameInitialize()
    {

    }

    function frameInitialized()
    {
    }

    function beforeWorkerStart(\swoole_server $server)
    {
        CronTasks::getInstance();
        CronLoadTasks::getInstance();
        CronProcessManager::getInstance();
    }

    function onStart(\swoole_server $server)
    {
    }

    function onShutdown(\swoole_server $server)
    {
    }

    function onWorkerStart(\swoole_server $server, $workerId)
    {
        CronDispatcher::getInstance()->setServer($server, $workerId)->dispatch();
    }

    function onWorkerStop(\swoole_server $server, $workerId)
    {
    }

    function onRequest(Request $request, Response $response)
    {
    }

    function onDispatcher(Request $request, Response $response, $targetControllerClass, $targetAction)
    {
        onHttpDispatcher::auth($request, $response, $targetControllerClass, $targetAction);
        onHttpDispatcher::accessLog($request, $response, $targetControllerClass, $targetAction);
    }

    function onResponse(Request $request, Response $response)
    {
    }

    function onTask(\swoole_server $server, $taskId, $workerId, $taskObj)
    {
    }

    function onFinish(\swoole_server $server, $taskId, $taskObj)
    {
    }

    function onWorkerError(\swoole_server $server, $workerId, $workerPid, $exitCode)
    {
    }

    function onMessage(\swoole_server $server, $frame)
    {
    }
}
