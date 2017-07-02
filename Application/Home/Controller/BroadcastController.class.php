<?php

namespace Home\Controller;

use EasyWeChat\Foundation\Application;

class BroadcastController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);

        $broadcast = $app->broadcast;

        $broadcast->sendText('大家好，呵呵');
    }
}
