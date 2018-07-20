<?php
/**
 * Created by PhpStorm.
 * User: safer
 * Date: 2018/7/17
 * Time: 0:26:52
 */

namespace Cron\Logic;

use Core\AbstractInterface\ALogic;
use Common\Model\AuthAccessLog as Model;

/**
 * Class AuthAccessLog
 * @package Cron\Logic
 */
class AuthAccessLog extends ALogic
{
    function getList()
    {
        $model = new Model;
        $model->where('id', '>', 0);
        /* 分页 */
        if ($page = $this->request()->getPage()) {
            if ($page['is_first']) {
                $page['total'] = $model->count('id') | 0;
            }
            $model = $model->limit($page['start'], $page['limit']);
            $this->response()->setPage($page);
        }
        /* 查询 */
        if ($where = $this->request()->getWhere()) {
            $where = 0 < sizeof($where) ? join(' and ', $where) : array_shift($where);
            $model = $model->where($where);
        }
        /* 排序 */
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
        if (!$id = $this->request()->getId()) {
            return $this->response()->error();
        }
        if (!$model = Model::get($id)) {
            return $this->response()->error();
        }
        $responseData = $model->toArray();
        return $this->response()
            ->setData($responseData)
            ->success();
    }

    function create()
    {
        if (!$responseData = $this->request()->getData()) {
            return $this->response()->error();
        }
        $model = new Model;
        if (!$ret = $model->save($responseData)) {
            return $this->response()->error();
        }
        $responseData = $model->toArray();
        return $this->response()
            ->setData($responseData)
            ->success();
    }

    function update()
    {

    }

    function delete()
    {
    }
}