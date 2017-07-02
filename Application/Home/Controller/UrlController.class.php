<?php

namespace Home\Controller;


use EasyWeChat\Foundation\Application;

class UrlController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);

        $url = $app->url;

        $shortUrl = $url->shorten("http://blog.codecantabile.xyz/2017/03/10/some-gitlab-tips");

        var_dump($shortUrl);
    }
}