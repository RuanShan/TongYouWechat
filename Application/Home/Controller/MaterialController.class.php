<?php

namespace Home\Controller;


use EasyWeChat\Foundation\Application;

class MaterialController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);

        $material = $app->material;

        $result = $material->lists('image');

        var_dump($result);
    }

    public function upload_tester()
    {
        $options = C('EASY_WECHAT');
        $app = new Application( $options);

        $material = $app->material;

        //$result = $material->uploadImage("./Uploads/cs/wechat/betester.png");
        $result = $material->uploadImage("./Uploads/cs/wechat/shentianyu.jpg");
        var_dump($result);
    }
}
