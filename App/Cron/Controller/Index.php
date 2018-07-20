<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/24
 * Time: 18:01
 */

namespace Cron\Controller;


use Core\AbstractInterface\AHttpController as Controller;
use Core\Http\SessionFacade as Session;
use Core\Http\Message\Status as HttpStatus;
use Common\Model\Admin as AdminModel;

/**
 * Class Index
 * @package Home\Controller
 */
class Index extends Controller
{
    function index()
    {
        $this->response()->withHeader("Content-type", "text/html;charset=utf-8");
        if (FALSE === $this->_auth()) {
            $this->response()->write(file_get_contents(ROOT . "/Public/login.html"));
            return;
        }
        $this->response()->write(file_get_contents(ROOT . "/Public/index.html"));
    }

    function login()
    {
        $responseError   = [
            'status'  => 0,
            'message' => 'error',
        ];
        $responseSuccess = [
            'status'  => 1,
            'message' => 'success',
        ];
        if (NULL === $username = $this->request()->getParsedBody('username')) {
            return $this->response()->writeJson(HttpStatus::CODE_OK, $responseError);
        }
        if (NULL === $password = $this->request()->getParsedBody('password')) {
            return $this->response()->writeJson(HttpStatus::CODE_OK, $responseError);
        }
        $model = new AdminModel;
        $model = $model->where('username', '=', $username);
        $model = $model->where('password', '=', md5($password));
        try {
            if (!$ret = $model->find()) {
                return $this->response()->writeJson(HttpStatus::CODE_OK, $responseError);
            }
            Session::set('auth', $ret->toArray());
            $clientIp = $this->request()->getSwooleRequest()->header['x-real-ip'];
            $ret->save([
                'last_ip'    => ip2long($clientIp),
                'last_login' => time(),
            ]);
        } catch (\Exception $e) {
            return $this->response()->writeJson(HttpStatus::CODE_OK, $responseError);
        }
        return $this->response()->writeJson(HttpStatus::CODE_OK, $responseSuccess);
    }

    function loginOut()
    {
        $responseSuccess = [
            'status'  => 1,
            'message' => 'success',
        ];
        Session::delete('auth');
        return $this->response()->writeJson(HttpStatus::CODE_OK, $responseSuccess);
    }

    private function _auth()
    {
        if (NULL === Session::find('auth')) {
            return FALSE;
        }
        return TRUE;
    }
}