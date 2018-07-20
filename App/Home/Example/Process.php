<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/24
 * Time: 11:25
 */

namespace Home\Example;

use Core\Swoole\Process\AProcess;
use Core\Swoole\Timer;

class Process extends AProcess
{
    public function run(\swoole_process $process)
    {
        $this->addTick(1000, function () {
            var_dump('this is ' . $this->getProcessName() . ' process tick');
        });
        Timer::delay(3000, function () use($process) {
            var_dump('swoole_process_test has exit');
            $process->exit(0);
        });
    }

    public function onShutDown()
    {
        var_dump('process shut down');
    }

    public function onReceive($str, ...$args)
    {
        var_dump('process rec' . $str);
    }
}