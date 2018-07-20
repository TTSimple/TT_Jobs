<?php
/**
 * Created by PhpStorm.
 * User: safer
 * Date: 2018/5/25
 * Time: 0:43
 */

namespace Home\Controller\Process;

use Core\AbstractInterface\AHttpController as Controller;
use Core\Swoole\Process\ProcessManager;
use Home\Example\Process;


/**
 * Class Index
 * @package Home\Controller\Process
 */
class Index extends Controller
{
    public function index()
    {
        // 创建自定义进程 上面定时器中发送的消息 由 Test 类进行处理
        // ------------------------------------------------------------------------------------------
        $processName = 'swoole_process_test';
        ProcessManager::getInstance()->addProcess($processName, Process::class);
        $process = ProcessManager::getInstance()->getProcessByName($processName)->getProcess();
        $pid = $process->start();
        $this->response()->write("process pid : {$pid}");
    }
}