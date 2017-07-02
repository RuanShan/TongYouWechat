<?php

namespace Home\Controller;


use EasyWeChat\Foundation\Application;

class ReplyController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);

        $reply = $app->reply;

        var_dump($reply->current());
    }
}