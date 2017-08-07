<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;

class WechatController extends Controller
{
    //
    public function wechat()
    {
        $options = [
            'debug'     => true,
            'app_id'    => 'wx6b2b1a8cc619de79',
            'secret'    => 'c4212df8b8902783840a4cee8aa42730',
            'token'     => 'weixin',
            'log' => [
                'level' => 'debug',
                'file'  => '/tmp/easywechat.log',
            ],
            // ...
        ];
        $app = new Application($options);

        // 从项目实例中得到服务端应用实例。
        $userApi = $app->user;
        $server = $app->server;
        $server->setMessageHandler(function ($message) use ($userApi){
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
            switch ($message->MsgType) {
                case 'event':
                    return '你好'. $userApi->get($message-->FromUserName)->nickname;
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
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });



        $menu = $app->menu;
        $menu->destroy();
        $response = $server->serve();
        return $response; // Laravel 里请使用：return $response;

    }
}
