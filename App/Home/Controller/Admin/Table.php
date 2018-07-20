<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/15
 * Time: 17:45
 */

namespace Home\Controller\Admin;

use Core\AbstractInterface\AHttpController as Controller;
use Core\Http\Message\Status;

class Table extends Controller
{
    function index()
    {
        $jsonFile = file_get_contents(APP_ROOT."/Static/table.json");
        $responseData = json_decode($jsonFile);
        $this->response()->writeJson(Status::CODE_OK, $responseData);
    }
}
