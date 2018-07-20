<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/16
 * Time: 17:25
 */

namespace Home\Controller\Admin;

use Core\AbstractInterface\AHttpController as Controller;
use Home\Logic\User as UserLogic;


/**
 * Class User
 * @package Home\Controller\Admin
 */
class User extends Controller
{
    function index()
    {
        $userLogic = new UserLogic();
        $responseData = $userLogic->getList();
        $this->response()->write($responseData);
    }

    function info()
    {
        $userLogic = new UserLogic();
        $responseData = $userLogic->getList();
        $this->response()->write($responseData);
    }

    function add()
    {
//        // 获取单条
//        if (!$name = $this->request()->getParsedBody('name')) {
//            $this->response()->write('操作失败');
//        }
//        if (!$phone = $this->request()->getParsedBody('phone')) {
//            $this->response()->write('操作失败');
//        }
//        $requestData = [
//            'name' => $name,
//            'phone' => $phone,
//        ];
        // 获取多条
        $requestData = $this->request()->getParsedBody();
        $userLogic = new UserLogic();
        $userLogic->setRequestData($requestData);
        if (!$ret = $userLogic->create()) {
            $this->response()->write('操作失败');
        }
        $responseData = [
            'data' => $ret
        ];
        $this->response()->write($responseData);

    }

    function update()
    {
        if (!$id = $this->request()->getQueryParam('id')) {
            $this->response()->write('操作失败');
        }
        if (!$requestData = $this->request()->getParsedBody()) {
            $this->response()->write('操作失败');
        }
        $userLogic = new UserLogic();
        $userLogic->setId($id);
        $userLogic->setRequestData($requestData);
        if (!$ret = $userLogic->create()) {
            $this->response()->write('操作失败');
        }
        $responseData = [
            'data' => $ret
        ];
        $this->response()->write($responseData);
    }

    function delete()
    {
        if (!$id = $this->request()->getQueryParam('id')) {
            $this->response()->write('操作失败');
        }
        $userLogic = new UserLogic();
        $userLogic->setId($id);
        $responseData = $userLogic->delete();
        $this->response()->write($responseData);
    }
}