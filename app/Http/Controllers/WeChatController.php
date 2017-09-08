<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class WeChatController extends Controller
{
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function($message){
            return "欢迎关注 overtrue！";
        });

        Log::info('return response.');

        return $wechat->server->serve();
    }

    public function user()
    {
        $user = session('wechat.oauth_user');
        return view('user');
    }

    public function index(Request $request)
    {
        $userFormData = $request->except('_token');
        $WeChatUser = session('wechat.oauth_user');
        $userFormData['openid'] = $WeChatUser->id;
        if (User::where('openid', $WeChatUser->id)->first()) {
            return json_encode(['success' => 2, 'tip' => '您已报名']);
        } else {
            if(User::create($userFormData)) {
                return json_encode(['success' => 1, 'tip' => '添加成功']);
            } else {
                return json_encode(['success' => 0, 'tip' => '添加失败']);
            }
        }
    }

    public function sign(Request $request)
    {
        $WeChatUser = session('wechat.oauth_user');
        $status = User::where('openid', $WeChatUser->id)->where('activity_id', $request->input('k'))->update(['status' => 1]);
        if ($status) {
            return view('sign')->with('tip', '签到成功');
        } else {
            return view('sign')->with('tip', '签到失败');
        }
    }

    public function addMenu()
    {
        $app = app('wechat');
        $menu = $app->menu;
        $buttons = [
            [
                "type" => "click",
                "name" => "签到测试",
                "key"  => "V1001_TODAY_MUSIC",
                "url"  => "http://wechat.srise.xin/user"
            ],
        ];
        $menu->add($buttons);
    }
}
