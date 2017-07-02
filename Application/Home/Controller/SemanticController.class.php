<?php

namespace Home\Controller;


use EasyWeChat\Foundation\Application;

class SemanticController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);

        $semantic = $app->semantic;

        $result = $semantic->query('查一下明天从北京到上海的机票',"flight,hotel",['city' => '北京','uid'=> 'oFBEXwAkPD7EYhPyzOIVKHPB2USY']);

        header('Content-type: application/json;charset=utf-8');
        echo json_encode($result);
    }
}