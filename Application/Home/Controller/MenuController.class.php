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
                'name' => '走进童游',
                "sub_button"=>
                  [
                    [
                        "type" => "view",
                        "name" => "童游介绍",
                        'url'  => 'http://mp.weixin.qq.com/s/_y1bYLlEpetskkdX3jzj5A',
                    ],
                    [
                      "type" => "view",
                      "name" => "合作流程",
                      'url'  => 'http://mp.weixin.qq.com/s/_y1bYLlEpetskkdX3jzj5A',
                    ],
                    [
                      "type" => "view",
                      "name" => "案例展示",
                      'url'  => 'http://mp.weixin.qq.com/s/_y1bYLlEpetskkdX3jzj5A',
                    ],
                    [
                      "type" => "view",
                      "name" => "官方网站",
                      'url'  => 'http://www.dltongyou.com',
                    ],
                  ]
            ],
            [
              'name'       => '童游产品',
              "sub_button"=>
                [
                  [
                      "type" => "view",
                      "name" => "产品介绍",
                      'url'  => 'http://x.eqxiu.com/s/T1jcFZQ4',
                  ],
                  [
                    "type" => "view",
                    "name" => "定制开发",
                    'url'  => 'http://mp.weixin.qq.com/s/_y1bYLlEpetskkdX3jzj5A',
                  ]
                ]
            ],
            [
              'name' => '会员中心',
              "sub_button"=>
                [
                  [
                        "type"=> "view",
                        "name" => "注册/登录",
                        'url'  => 'http://'.$_SERVER['HTTP_HOST'].U('/Home/Session/'),
                  ],
                  [
                        "type"=> "view",
                        "name" => "激活产品",
                        'url'  => 'http://'.$_SERVER['HTTP_HOST'].U('/Home/Index/'),
                  ],
                  [
                        "type"=> "view",
                        "name" => "我的订单",
                        'url'  => 'http://'.$_SERVER['HTTP_HOST'].U('/Home/Index/orders'),
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
