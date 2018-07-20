<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/3/16
 * Time: 下午12:59
 */

namespace Home\Controller\Path;


use Core\AbstractInterface\AHttpController as Controller;
use Core\Http\UrlParser;

class Test extends Controller
{

    protected $arg = null;
    function index()
    {
        $this->actionNotFound('index');
    }

    protected function onRequest($action)
    {
        $ret = pathInfo($this->request()->getUri()->getPath());
        if(isset($ret['filename'])){
            $this->arg = $ret['filename'];
        }
        return parent::onRequest($action);
    }

    /*
    * /path/test/a/1-1-1-1.html
    */
    public function a()
    {
        $this->response()->write('your arg is'.$this->arg);
    }
}