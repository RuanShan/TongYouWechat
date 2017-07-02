<?php

namespace Home\Controller;


use EasyWeChat\Foundation\Application;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class WebLoginController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);

        $url = $app->url;

        $randStr = time().'_'.uniqid();
        M('WebLoginStr')->add(['str' => $randStr,'session_id' => session_id(),'created_at' => time()]);
        $initiallyUrl = 'http://'.$_SERVER['HTTP_HOST'].U('mobile').'&token='.$randStr;
        $shortUrl = $url->shorten($initiallyUrl);
        $url = $shortUrl['short_url'];
        $this->assign(compact('url','randStr'));
        $this->display();
    }

    public function qr($url)
    {
        $qrCode = new QrCode($url);
        $qrCode->setMargin(10)->setEncoding('UTF-8')->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH);
        header('Content-Type: '.$qrCode->getContentType(PngWriter::class));
        echo $qrCode->writeString(PngWriter::class);
    }

    public function mobile($token)
    {
        $this->options['oauth']['callback'] = U('callback',['token'=>$token]);

        $app = new Application($this->options);
        $oauth = $app->oauth;


        redirect($oauth->redirect()->getTargetUrl());
    }

    public function callback($token)
    {
        $app = new Application($this->options);

        $oauth = $app->oauth;

        $user = $oauth->user();

        $this->redirect(U('confirm',['token'=>$token,'openid'=>$user['id']]));
    }

    public function confirm($token,$openid)
    {
        $this->assign(compact('token','openid'));
        $this->display();
    }

    public function decide($token,$openid)
    {
        $result = M('WebLoginStr')->where(['str'=>$token])->save(['openid'=>$openid,'is_confirm'=>1]);
        var_dump($result);
    }

    public function checkLogin($token)
    {
        $check = M('WebLoginStr')->where(['str'=>$token,'session_id'=>session_id()])->find();
        if($check['is_confirm'] == 1)
        {
            $app = new Application($this->options);

            $userService = $app->user;

            $user = $userService->get($check['openid']);
            session('wechat_user',$user);
        }
        header('Content-type: application/json;charset=utf-8');
        echo $check['is_confirm'];
    }

    public function home()
    {
        var_dump(session('wechat_user'));
    }
}