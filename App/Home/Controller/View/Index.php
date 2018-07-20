<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/21
 * Time: 13:44
 */

namespace Home\Controller\View;

use Core\AbstractInterface\AHttpController as Controller;

/**
 * Class Index
 * @package Home\Controller\View
 */
class Index extends Controller
{
    public function index()
    {
        // 输出Index模板
        $desc = "I'm ThinkPHP template engine :)";
        $date = date('Y-m-d H:i:s');
        $this->assign(compact('desc', 'date'));
        $this->display('index');
    }

    function redirect()
    {
        $this->response()->redirect('http://www.baidu.com');
    }
}