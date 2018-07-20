<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/24
 * Time: 18:01
 */

namespace Home\Controller\Live;

use Core\AbstractInterface\AHttpController as Controller;

/**
 * Class Index
 * @package Home\Controller\Live
 */
class Index extends Controller
{
    function index()
    {
        $this->display('Live/index');
    }

    function camera()
    {
        $this->display('Live/camera');
    }
}
