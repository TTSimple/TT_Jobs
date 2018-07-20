<?php
/**
 * Created by PhpStorm.
 * User: safer
 * Date: 2018/7/9
 * Time: 0:31:07
 */

namespace Cron\Event;

use Core\Http\Message\Status as HttpStatus;
use Core\Http\Request;
use Core\Http\Response;
use Core\Utility\Auth\Web as Auth;
use Common\Model\AuthAccessLog as AuthAccessLogModel;

/**
 * Class onHttpDispatcher
 * @package Cron\Event
 */
class onHttpDispatcher
{
    static function auth(Request $request, Response $response, $targetControllerClass, $action)
    {
        $authSession = $request->session()->get('auth');
        if ($authSession && $authSession['username'] == 'admin') {
            return TRUE;
        }
        $path = explode('\\', $targetControllerClass);
        if (count($path) >= 3 && $path[2] == 'Index') {
            return TRUE;
        }
//        $authCheckName = $path[2] . '\\' . $path[3] . '\\' . $action;
        $authCheckName = $path[2] . '\\' . $path[3];
        try {
            if (FALSE === (new Auth)->check($authCheckName, $authSession['id'], 'Cron')) {
                self::_error($response);
                return FALSE;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            echo $e->getFile();
            echo $e->getLine();
        }
        return TRUE;
    }

    static function accessLog(Request $request, Response $response, $targetControllerClass, $action)
    {
        if (NULL === $authSession = $request->session()->get('auth')) {
            return;
        }
        $path = explode('\\', $targetControllerClass);
        if (count($path) >= 3 && $path[2] == 'Index') {
            return;
        }
        $accessPath = $targetControllerClass . '\\' . $action;
        $accessData = empty($request->getPostData())
            ? ''
            : json_encode($request->getPostData(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $data       = [
            'uid'         => $authSession['id'],
            'access_path' => $accessPath,
            'access_data' => $accessData,
        ];
        AuthAccessLogModel::create($data);
    }

    static private function _error(Response $response)
    {
        $response->writeJson(HttpStatus::CODE_FORBIDDEN, ['message' => '权限错误', 'status' => 0]);
    }
}