<?php
namespace Home\Controller;


use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Video;

class WechatController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);

        $server = $app->server;

        $server->setMessageHandler(function ($message)
        {
            switch($message->MsgType)
            {
                case 'event':
                    switch($message->Event)
                    {
                        case 'subscribe':
                            return '谢谢关注';
                            break;
                        case 'SCAN':
                            return $message->EventKey."扫码事件";
                            break;
                        case 'CLICK':
                            return $message->EventKey."点击事件";
                            break;
                        default:
                            return '收到事件消息';
                            break;
                    }
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                default:
                    return '收到其他消息';
                    break;
            }
        });

        $response = $server->serve();

        $response->send();
    }
}
