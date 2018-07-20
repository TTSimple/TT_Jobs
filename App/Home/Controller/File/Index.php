<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/24
 * Time: 17:13
 */

namespace Home\HttpController\File;


use Core\AbstractInterface\AHttpController as Controller;
use Core\Http\Message\UploadFile;

class Index extends Controller
{
    function index()
    {
        $file = $this->request()->getUploadedFile('testFile');
        if($file instanceof UploadFile){
            $file->moveTo(ROOT . "/Temp/a.json");
        }else{
            $this->response()->write('you have not file');
        }
    }
}