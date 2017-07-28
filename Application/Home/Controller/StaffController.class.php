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

        $lists = $staff->lists();

        var_dump($lists);

    }

    public function index2()
    {
        $app = new Application($this->options);

        $staff = $app->staff;

        $message = new Text(['content'=>'现在的时间是'.date('Y-m-d H:i:s')]);
        $staff->message($message)->to('oFBEXwAkPD7EYhPyzOIVKHPB2USY')->send();
    }

    public function add_tester()
    {
      $app = new Application($this->options);
      $staff = $app->staff;
      $response = $staff->create('test2@tongyoukeji', '测试客服2');
      var_dump($response);
    }

    public function delete_tester()
    {
      $app = new Application($this->options);
      $staff = $app->staff;
      $response = $staff->delete('test2@tongyoukeji');
      var_dump($response);

    }

    public function invite_tester()
    {
      $app = new Application($this->options);
      $staff = $app->staff;
      $response = $staff->invite('test2@tongyoukeji', 'desertcloud');
      var_dump($response);
    }


}
