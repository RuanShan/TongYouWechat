<?php

namespace Home\Controller;


use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;

class StaffController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);

        $staff = $app->staff;


        $message = new Text(['content'=>'现在的时间是'.date('Y-m-d H:i:s')]);
        $staff->message($message)->to('oFBEXwAkPD7EYhPyzOIVKHPB2USY')->send();
    }
}