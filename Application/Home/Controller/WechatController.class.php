<?php
namespace Home\Controller;


use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Video;
use EasyWeChat\Message\Image;

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
                          if( $message->EventKey == 'CLICK_0004' )
                          {
                            $media_id = $this->GetCustomerServiceImage( 3 );
                            if( $media_id != null)
                            {
                                $image = new Image(['media_id' => $media_id]);
                                return $image;
                            }else
                            {
                              $text = '客服不在线，请在工作时间联系客服8:00-22:00';
                              return $text;
                            }
                          }
                          elseif( $message->EventKey == 'CLICK_0005' )
                          {
                              $media_id = $this->GetCustomerServiceImage( 4 );
                              if( $media_id != null)
                              {
                                  $image = new Image(['media_id' => $media_id]);
                                  return $image;
                              }else{
                                $text = '客服不在线，请在工作时间联系客服8:00-22:00';
                                return $text;                              }
                          }
                          else {
                            $text = '客服不在线，请在工作时间联系客服8:00-22:00';
                            return $text;
                          }
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

    //取得当前在岗的客服的二维码
    protected function GetCustomerServiceImage($group_id)
    {
      $Member = M('Member');
      $media_id = null;
      $member = null;
      //$media_id = 'lSOwmeHQZMIGBir05FjW-g_lNd2A1t9XmK8b_dIESRo';

      if( $group_id == 4 )
      {
        $member = $Member->where('group_id=4 AND cs_status=1 AND cs_media_id IS NOT NULL')->find();
      }
      else {
        $member = $Member->where('group_id=3 AND cs_status=1 AND cs_media_id IS NOT NULL')->find();
      }
  		//Log::write( print_r($this->member,true) );

  		if( $member != null)
  		{
  			  $media_id =  $member['cs_media_id'];
  		}
      return $media_id;
    }
}
