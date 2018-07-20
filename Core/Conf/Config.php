<?php

namespace Core\Conf;

use Core\Component\Di;
use Core\Component\Spl\SplArray;
use Core\Component\SysConst;

class Config
{
    private static $instance;
    protected $conf;

    function __construct()
    {
        $this->conf = $this->appConf();
        $this->conf = $this->sysConf() + $this->conf;
        $this->conf = new SplArray($this->conf);
    }

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    function getConf($keyPath)
    {
        return $this->conf->get($keyPath);
    }

    /*
    * 在server启动以后，无法动态的去添加，修改配置信息（进程数据独立）
    */
    function setConf($keyPath, $data)
    {
        $this->conf->set($keyPath, $data);
    }

    private function sysConf()
    {
        return [
            "SERVER" => [
                "LISTEN"          => "0.0.0.0",
                "SERVER_NAME"     => "swoole",
                "PORT"            => $this->conf['SWOOLE']['PORT'],
                "RUN_MODE"        => SWOOLE_PROCESS,    //不建议更改此项
                "CONTROLLER_POOL" => true,              //web或web socket模式有效
                "SERVER_TYPE"     => \Core\Swoole\Config::SERVER_TYPE_WEB,
                "SESSION_NAME"    => 'SESSION_NAME',
                //                "SERVER_TYPE"     => \Core\Swoole\Config::SERVER_TYPE_WEB_SOCKET, // 直播打开
//                'SOCKET_TYPE'     => SWOOLE_TCP,        //当SERVER_TYPE为SERVER_TYPE_SERVER模式时有效
                "CONFIG" => [
                    'enable_static_handler' => true,
                    'document_root'         => $this->conf['APP_PUBLIC_DIR'],
                ] + $this->conf['SWOOLE']['CONFIG'],
            ]
        ];
    }

    private function appConf()
    {
        $confPath = ROOT . '/App/' . APP_NAME . '/Conf';
        $initConf = parse_ini_file($confPath . '/config.ini');
        $envConf  = require_once($confPath . '/env/' . $initConf['APP_ENV'] . '.php');
        return array_merge($initConf, $envConf);
    }
}