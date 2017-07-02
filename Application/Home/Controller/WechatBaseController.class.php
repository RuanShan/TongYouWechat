<?php
namespace Home\Controller;

use Home\Lib\MysqlDoctrineCacheDriver;
use Think\Controller;

class WechatBaseController extends Controller
{
    protected $options;

    public function __construct()
    {
        $this->options = C('EASY_WECHAT');
        $cacheDriver = new MysqlDoctrineCacheDriver();
        $this->options['cache'] = $cacheDriver;
        parent::__construct();
    }
}
