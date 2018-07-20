<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/24
 * Time: 18:01
 */

namespace Home\Controller\WebSocket;

use Core\AbstractInterface\AHttpController as Controller;

/**
 * Class WebSocketCommandParser
 * @package Home\Controller\WebSocket
 */
class WebSocketCommandParser extends Controller
{
    function index()
    {
        $this->display('WebSocket/command_parser_client');
    }
}
