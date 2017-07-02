<?php

namespace Home\Controller;


use EasyWeChat\Foundation\Application;

class JsSdkController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);

        $js = $app->js;

        $jsStr = $js->config(['onMenuShareQQ'],true);

        var_dump($jsStr);
    }
}