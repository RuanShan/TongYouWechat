<?php
namespace Common\Service;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;

class Sms {

  public function _initialize () {

  }
    public function send_code($mobile) {
      return  1234;
      //https://github.com/flc1125/alidayu
      // 使用方法二
      $config = C('ALIDAYU');
      Client::configure($config);  // 全局定义配置（定义一次即可，无需重复定义）

      $resp = Client::request('alibaba.aliqin.fc.sms.num.send', function (IRequest $req) {
          $req->setRecNum($mobile)
              ->setSmsParam([
                  'number' => mt_rand(1000, 9999)
              ])
              ->setSmsFreeSignName('大连软山')
              ->setSmsTemplateCode('SMS_21680327');
      });

      // 返回结果
      print_r($resp);
      print_r($resp->result->model);

    }

}
