<?php
/**
 * Created by PhpStorm.
 * User: safer
 * Date: 2018/6/11
 * Time: 22:45
 */

namespace Home\Controller\Crontab;

use Core\AbstractInterface\AHttpController as Controller;
use Core\Component\Crontab\Parse;

/**
 * Class Index
 * @package Home\Controller\Crontab
 */
class Index extends Controller
{
    function index()
    {
//        $data = Parse::parse('*/5 * * * *');
//        var_dump($data);
        $this->response()->write("index");
    }
}