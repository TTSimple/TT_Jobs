<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/21
 * Time: 15:30
 */

namespace Home\Logic;

use Core\AbstractInterface\ALogic;
use Home\Model\User as UserModel;


/**
 * Class User
 * @package Home\Logic
 */
class User extends ALogic
{
    function getList()
    {
        $model = UserModel::where("update_at > UNIX_TIMESTAMP('2018-01-01 00:00:00') and update_at < UNIX_TIMESTAMP('2018-12-12 00:00:00')")->select();
        $responseData = $model->toArray();
        return $responseData;
    }

    function getInfo()
    {
        if (!$id = $this->getId()) {
            return false;
        }
        if (!$model = UserModel::get($id)) {
            return false;
        }
        $responseData = $model->toArray();
        return $responseData;
    }

    function create()
    {
//        // 获取单条
//        if (!$name = $this->getRequestData('name')) {
//            return false;
//        }
        // 获取多条
        if (!$responseData = $this->getRequestData()) {
            return false;
        }
        $model = new UserModel;
        if (!$ret = $model->save($responseData)) {
            return false;
        }
        $responseData = $model->toArray();
        return $responseData;
    }

    function update()
    {
        if (!$id = $this->getId()) {
            return false;
        }
        if (!$responseData = $this->getRequestData()) {
            return false;
        }
        if (!$model = UserModel::get($id)) {
            return false;
        }
        if (!$ret = $model->save($responseData)) {
            return false;
        }
        $responseData = $model->toArray();
        return $responseData;
    }

    function delete()
    {
        if (!$id = $this->getId()) {
            return false;
        }
        if (!$user = UserModel::get($id)) {
            return false;
        }
        $responseData = $user->delete();
        return $responseData;
    }

}