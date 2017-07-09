<?php
namespace Common\Service;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;
use Think\Log;

class Sms {

  public function _initialize () {

  }

  //  返回： 0 或 发送的4位数字验证码
    public function send_code($mobile) {
      $config = C('ALIDAYU');
      $code = mt_rand(1000, 9999);
      //https://github.com/flc1125/alidayu
      // 使用方法一
      $client = new Client(new App($config));
      $req    = new AlibabaAliqinFcSmsNumSend;

      {
        $req->setRecNum($mobile)
            ->setSmsParam([
                'code' => $code
            ])
            ->setSmsFreeSignName('大连软山')
            ->setSmsTemplateCode('SMS_21680327');

        $resp = $client->execute($req);

        // 使用方法二
        //Client::configure($config);  // 全局定义配置（定义一次即可，无需重复定义）
        //$resp = Client::request('alibaba.aliqin.fc.sms.num.send', function (IRequest $req) {
        //    $req->setRecNum($mobile)
        //        ->setSmsParam([
        //            'code' => $code
        //        ])
        //        ->setSmsFreeSignName('大连软山')
        //        ->setSmsTemplateCode('SMS_21680327');
        //});

        // 返回结果
        Log::write( print_r($resp,true) );
        //https://api.alidayu.com/doc2/apiDetail?spm=a3142.7629140.1999205496.19.JTmig8&apiId=25450
        //(
        //    [result] => stdClass Object
        //        (
        //            [err_code] => 0
        //            [model] => 108634148052^1111620910060
        //            [msg] => *
        //            [success] => 1
        //        )
        //    [request_id] => 44nrc0fho1a5
        //)
        //ERROR
        //(
        //    [code] => 29
        //    [msg] => Invalid app Key
        //    [sub_code] => isv.appkey-not-exists
        //    [request_id] => 15a03jo0qpk16
        //)
        if( ! $resp['result']['success'])
        {
          $code = 0;
        }
      }
      return $code;
    }

}
