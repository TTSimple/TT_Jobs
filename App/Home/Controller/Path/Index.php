<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/3/16
 * Time: 下午12:58
 */

namespace Home\Controller\Path;


use Core\AbstractInterface\AHttpController as Controller;

class Index extends Controller
{

    function index()
    {
        $this->actionNotFound('index');
    }

    protected function onRequest($action)
    {
        return parent::onRequest($action);
    }

    /*
     * /path/a/1-1-1-1.html
     */
    public function a()
    {
        $this->response()->write($this->request()->getUri()->getPath());
    }
}