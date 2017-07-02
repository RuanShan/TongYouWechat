<?php

namespace Home\Controller;


use EasyWeChat\Foundation\Application;

class MaterialController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);

        $material = $app->material;

        $result = $material->uploadImage("./Uploads/img/1.png");
        var_dump($result);
    }
}