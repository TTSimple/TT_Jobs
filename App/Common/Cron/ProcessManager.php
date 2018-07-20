<?php
/**
 * Created by PhpStorm.
 * User: safer
 * Date: 2018/6/13
 * Time: 23:06
 */

namespace Common\Cron;

use Core\Component\Error\Trigger;
use Core\Swoole\Memory\TableManager;
use Core\Swoole\Server;

/**
 * Class ProcessManager
 * @package Core\Swoole\Process
 */
class ProcessManager
{
    const SWOOLE_TABLE_NAME = 'CRON_PROCESS_MANAGER';

    private $_processList = [];
    private $_table;

    protected static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    function __construct()
    {
        TableManager::getInstance()->add(
            self::SWOOLE_TABLE_NAME, [
            'pid' => [
                'type' => \swoole_table::TYPE_INT,
                'size' => 10
            ]
        ], 256
        );
        $this->_table = TableManager::getInstance()->get(self::SWOOLE_TABLE_NAME);
    }

    /**
     * @param $key
     * @param $processName
     * @param $processClass
     * @param callable $onFinish
     * @param array $args
     * @return bool
     */
    public function addProcess($key, $processName, $processClass, $onFinish, array $args = [])
    {
        if (Server::SERVER_NOT_START === Server::getInstance()->isStart()) {
            trigger_error("you can not add a process {$processName}.{$processClass} after server start");
            return false;
        }
        $md5Key = $this->_generateKey($key);
        if (!isset($this->_processList[$md5Key])) {
            try {
                $process = new $processClass($key, $processName, $onFinish, $args);
                $this->_processList[$md5Key] = $process;
                return true;
            } catch (\Throwable $throwable) {
                Trigger::error($throwable);
                return false;
            }
        } else {
            trigger_error("you can not add the same name process : {$processName}.{$processClass}");
            return false;
        }
    }

    /**
     * @param $key
     * @return bool
     */
    public function removeProcessByKey($key)
    {
        if ($process = $this->getProcessByKey($key)) {
            $pid = $process->getPid();
            $this->removeProcessByPid($pid);
        }
        return true;
    }

    /**
     * @param $pid
     * @return bool
     */
    public function removeProcessByPid($pid)
    {
        if ($process = $this->getProcessByPid($pid)) {
            $this->_removeInTable($process);
            if (\swoole_process::kill($pid, 0)) {
                \swoole_process::kill($pid);
                while($ret = \swoole_process::wait(false)) {
//                    echo "PID={$ret['pid']}\n";
                }
            }
        }
        return true;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function getProcessByKey($key)
    {
        $key = $this->_generateKey($key);
        if (isset($this->_processList[$key])) {
            return $this->_processList[$key];
        } else {
            return null;
        }
    }

    /**
     * @param $pid
     * @return Process|null
     */
    public function getProcessByPid($pid)
    {
        foreach ($this->_table as $key => $item) {
            if ($item['pid'] == $pid) {
                return $this->_processList[$key];
            }
        }
        return null;
    }

    /**
     * @param $key
     * @param $process
     */
    public function setProcess($key, $process)
    {
        $key  = $this->_generateKey($key);
        $this->_processList[$key] = $process;
    }

    /**
     * @param $key
     * @return bool
     */
    public function reboot($key)
    {
        if ($process = $this->getProcessByKey($key)) {
            \swoole_process::kill($process->getPid(), SIGTERM);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $key
     * @return bool
     */
    public function kill($key)
    {
        if ($process = $this->getProcessByKey($key)) {
            $pid = $process->getPid();
            if (\swoole_process::kill($pid, 0)) {
                \swoole_process::kill($pid);
                while($ret = \swoole_process::wait(false)) {
//                    echo "PID={$ret['pid']}\n";
                }
            }
            $this->_removeInTable($process);
        }
        return true;
    }

    /**
     * @param Process $process
     */
    private function _removeInTable(Process $process)
    {
        $key = $this->_generateKey($process->getProcessKey());
        if ($this->_table->exist($key)) {
            $this->_table->del($key);
        }
        if (isset($this->_processList[$key])) {
            unset($this->_processList[$key]);
        }
    }

    private function _generateKey($key)
    {
        return hash('md5', $key);
    }
}