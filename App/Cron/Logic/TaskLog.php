<?php
/**
 * Created by PhpStorm.
 * User: safer
 * Date: 2018/6/23
 * Time: 2:48:09
 */

namespace Cron\Logic;

use Core\AbstractInterface\ALogic;
use Cron\Model\TaskLog as Model;

class TaskLog extends ALogic
{
    function getList()
    {
        $model = new Model;
        $model->where('id', '>', 0);
        /* 分页 */
        if ($page = $this->request()->getPage()) {
            if ($page['is_first']) {
                $page['total'] = $model->count('id')|0;
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
        $list = $ret->toArray();
        $responseData = $list;
        return $this->response()
            ->setData($responseData)
            ->success();
    }


    function getInfo()
    {
        // TODO: Implement getInfo() method.
    }


    function create()
    {
        // TODO: Implement create() method.
    }


    function update()
    {
        // TODO: Implement update() method.
    }


    function delete()
    {
        // TODO: Implement delete() method.
    }
}