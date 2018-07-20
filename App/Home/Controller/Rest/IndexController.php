<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/24
 * Time: 18:01
 */

namespace Home\Controller\Rest;


use Core\AbstractInterface\ARESTController as Controller;
use Core\Http\Message\Status;

/**
 * Class Index
 * @package Home\Controller\Rest
 */
class Index extends Controller
{
    function GETIndex()
    {
        $this->response()->write("this is REST GET Index");
    }

    function POSTIndex()
    {
        $this->response()->write("this is REST POST Index");
    }

    function GETTest()
    {
        $this->response()->write("this is REST GET test");
    }

    function POSTTest()
    {
        $this->response()->write("this is REST POST test");
    }

    function PUTindex()
    {
        $res = ['hello world'];
        $msg = "this is REST POST test";
        $this->response()->writeJson(Status::CODE_OK, $res, $msg);
    }

}