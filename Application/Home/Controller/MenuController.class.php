<?php

namespace Home\Controller;


use EasyWeChat\Foundation\Application;

class MenuController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);

        $menu = $app->menu;

        $buttons = [
            [
                'type' => 'click',
                'name' => '走进童游',
                'key' => 'CLICK_0001'
            ],
            [
              'type' => 'click',
              'name'       => '童游产品',
              'key' => 'CLICK_0002'
            ],
            [
              'name' => '会员中心',
              "sub_button"=>
                [
                  [
                      "type" => "view",
                      "name" => "登录",
                      'url'  => 'http://'.$_SERVER['HTTP_HOST'].U('/Home/Session/'),
                  ],
                  [
                        "type"=> "view",
                        "name" => "注册",
                        'url'  => 'http://'.$_SERVER['HTTP_HOST'].U('/Home/Member/'),
                  ],
                  [
                        "type"=> "view",
                        "name" => "激活产品",
                        'url'  => 'http://'.$_SERVER['HTTP_HOST'].U('/Home/Index/'),
                  ],
                  [
                        "type"=> "click",
                        "name" => "我的订单",
                        'key' => 'CLICK_0003'
                  ],
                  [
                        "type"=> "click",
                        "name" => "我的客服",
                        'key' => 'CLICK_0004'
                  ],
                ]
            ],
        ];

        $menu->add($buttons);

        $menus = $menu->current();

        var_dump($menus);
    }
}
