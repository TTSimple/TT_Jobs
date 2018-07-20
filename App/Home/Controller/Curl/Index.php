<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/21
 * Time: 15:30
 */

namespace Home\Controller\Curl;

use Core\AbstractInterface\AHttpController as Controller;
use Core\Http\Message\Status;
use Core\Utility\Curl\Request;


/**
 * Class Index
 * @package Home\Controller\Curl
 */
class Index extends Controller
{
    function index()
    {
        // 获取快递100接口数据
        $param = ['type' => 'zhongtong', 'postid' => '457500981717'];
        $url   = 'http://www.kuaidi100.com/query?' . http_build_query($param);
        // 创建Request对象
        $request = new Request($url);
        // 获取Response对象
        $response = $request->exec();
        // 接口返回内容
        $resources = $response->getBody();
        if ($resources) {
            $resources = \json_decode($resources);
        }
        $this->response()->writeJson(Status::CODE_OK, $resources, '操作成功');
    }
}
