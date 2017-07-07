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
                'name' => '产品展示',
                'key' => 'CLICK_0001'
            ],
            [
              'type' => 'view',
              'name'       => '产品激活',
              'url'  => 'http://'.$_SERVER['HTTP_HOST'].U('/Home/Index/')
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
                ]
            ],
        ];

        $menu->add($buttons);

        $menus = $menu->current();

        var_dump($menus);
    }
}
