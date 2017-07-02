<?php

namespace Home\Controller;


use EasyWeChat\Foundation\Application;

class OAuthController extends WechatBaseController
{
    public function index()
    {
        $this->options['oauth']['callback'] = U('oauthCallback');

        $app = new Application($this->options);
        $oauth = $app->oauth;

        if(empty(session('wechat_user')))
        {
            session('target_url',U('Index/index'));
            redirect($oauth->redirect()->getTargetUrl());
        }
        else
        {
            redirect(U('Index/index'));
        }
    }

    public function oauthCallback()
    {
        $app = new Application($this->options);

        $oauth = $app->oauth;

        $user = $oauth->user();

        session('wechat_user',$user->toArray());

        redirect(session('target_url'));
    }
}