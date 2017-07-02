<?php

namespace Home\Controller;


use EasyWeChat\Foundation\Application;

class NoticeController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);

        $notice = $app->notice;

        $userId = 'oFBEXwAkPD7EYhPyzOIVKHPB2USY';
        $templateId = 'qQ2fUa9Qq0fN7xVHyrT1nODFHXVZW9LQve0zRoREY98';

        $url = 'https://github.com';

        $data = [
            'name' => '人生经验',
        ];

        $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();

        var_dump($result);
    }

    public function color()
    {
        $app = new Application($this->options);

        $notice = $app->notice;

        $userId = 'oFBEXwAkPD7EYhPyzOIVKHPB2USY';
        $templateId = '8G-OZkZADR2mwGhlNa50TqFxMq1H-VaN5M0wFn55Ac8';

        $url = 'https://github.com';

        $data = [
            'poem' => ['苟利国家生死以', '#33FF99'],
            'journalist' => ['华莱士', '#AA0011'],
        ];

        $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();

        var_dump($result);
    }
}