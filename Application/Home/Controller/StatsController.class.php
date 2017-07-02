<?php

namespace Home\Controller;


use EasyWeChat\Foundation\Application;

class StatsController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);

        $stats = $app->stats;

        $usersSummary = $stats->interfaceSummary('2017-05-07','2017-05-10');
        header('Content-type: application/json;charset=utf-8');
        echo json_encode($usersSummary);
    }
}