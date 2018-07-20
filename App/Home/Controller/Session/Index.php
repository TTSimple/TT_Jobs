<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/24
 * Time: 18:01
 */

namespace Home\Controller\Session;

use Core\AbstractInterface\AHttpController as Controller;
use Core\Http\SessionFacade as Session;

/**
 * Class Index
 * @package Home\Controller\Session
 */
class Index extends Controller
{

    public function index()
    {
        Session::set('session_test', ['swoole' => 'swoole.com']);
        $ret = Session::find('session_test');
        $this->response()->write($ret);
    }

    public function cookie()
    {
        $this->response()->setCookie('cookie_test', 'cookie_test');
        $this->response()->write('cookie');
    }

//    function index()
//    {
//        $this->session()->sessionStart();
//        var_dump($this->session()->sessionId());
//        $this->session()->set('test',time());
//        $this->response()->write('yes');
//    }
//
//    function test()
//    {
//        $this->session()->sessionStart();
//        var_dump($this->session()->sessionId());
//        var_dump($this->session()->get('test'));
//        $this->response()->write('yes2');
//    }

}