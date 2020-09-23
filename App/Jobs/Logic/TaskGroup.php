<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/21
 * Time: 15:30
 */

namespace App\Jobs\Logic;

use Core\AbstractInterface\ALogic;
use App\Jobs\Model\TaskGroup as Model;
use App\Jobs\Model\Bean\TaskGroup as TaskGroupBean;


/**
 * Class TaskGroup
 *
 * @package Jobs\Logic
 */
class TaskGroup extends ALogic
{
    function getList()
    {
        $model = new Model;
        $model->where('is_del', Model::UN_DELETE);
        // 分页
        if ($page = $this->request()->getPage()) {
            if ($page['is_first']) {
                $page['total'] = $model->count('id') | 0;
            }
            $model = $model->limit($page['start'], $page['limit']);
            $this->response()->setPage($page);
        }
        // 排序
        if ($order = $this->request()->getOrder()) {
            $model = $model->order($order);
        }
        try {
            $ret = $model->select();
        } catch (\Exception $e) {
            return $this->response()
                ->setMsg($e->getMessage())
                ->error();
        }
        $list         = $ret->toArray();
        $responseData = $list;
        return $this->response()
            ->setData($responseData)
            ->success();
    }

    function getInfo()
    {
        if (! $id = $this->request()->getId()) {
            return $this->response()->error();
        }
        if (! $model = (new Model)->get($id)) {
            return $this->response()->error();
        }
        $responseData = $model->toArray();
        return $this->response()
            ->setData($responseData)
            ->success();
    }

    function create()
    {
        if (! $responseData = $this->request()->getData()) {
            return $this->response()->error();
        }
        $model = new Model;
        if (! $ret = $model->save($responseData)) {
            return $this->response()->error();
        }
        $responseData = $model->toArray();
        return $this->response()
            ->setData($responseData)
            ->success();
    }

    function update()
    {
        if (! $id = $this->request()->getId()) {
            return $this->response()->error();
        }
        if (! $requestData = $this->request()->getData()) {
            return $this->response()->error();
        }
        if (! $model = (new Model)->get($id)) {
            return $this->response()->error();
        }
        if (! $ret = $model->save($requestData)) {
            return $this->response()->error();
        }
        return $this->response()
            ->success();
    }

    function delete()
    {
        if (! $id = $this->request()->getId()) {
            return $this->response()->error();
        }
        if (! $model = (new Model)->get($id)) {
            return $this->response()->error();
        }
        $model->setAttr('is_del', Model::DELETED);
        if (! $ret = $model->save()) {
            return $this->response()->error();
        }
        return $this->response()
            ->success();
    }
}