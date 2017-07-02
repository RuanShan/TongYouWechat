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
                'name' => '点一下',
                'key' => 'CLICK_0001',
            ],
            [
                'name'       => '菜单',
                'sub_button' =>
                    [
                        [
                            'type' => 'view',
                            'name' => '授权登录',
                            'url'  => 'http://'.$_SERVER['HTTP_HOST'].U('OAuth/index'),
                        ],
                        [
                            'type' => 'pic_sysphoto',
                            'key' => 'camera',
                            'name' => '拍摄',
                        ],
                    ]
            ],
        ];

        $menu->add($buttons);

        $menus = $menu->current();

        var_dump($menus);
    }
}