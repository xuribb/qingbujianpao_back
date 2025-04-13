<?php

namespace app\controller;

use app\BaseController;
use app\validate\Register;
use think\exception\ValidateException;
use think\facade\Db;

class Login2Register extends BaseController
{
    public function login($data)
    {
        $APPID = env('APPID');
        $APPSECRET = env('APPSECRET');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid={$APPID}&secret={$APPSECRET}&js_code={$data['code']}&grant_type=authorization_code";
        $response = util_request($url);
        $response = json_decode($response, true);
        if (@$response['openid']) {
            unset($data['code']);
            $data['openid'] = $response['openid'];
            $response = Db::name('user')->insertGetId($data);
            if (is_string($response) && strlen($response) == 24) {
                unset($data['openid']);
                $data['id'] = $response;
                return ['code' => 0, 'data' => $data];
            } else {
                return ['code' => 1, 'errmsg' => $response];
            }
        } else {
            return $response;
        }
    }

    public function register()
    {
        $data = input('');
        try {
            validate(Register::class)->check($data);
        } catch (ValidateException $e) {
            return json(['code' => 1, 'errmsg' => $e->getError()]);
        }

        $response = $this->login($data);
        return json($response);
    }

    public function isRegister($code)
    {
        if (empty($code)) {
            return json(['code' => 1, 'errmsg' => '登录失败，用户CODE不能为空']);
        }

        $APPID = env('APPID');
        $APPSECRET = env('APPSECRET');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid={$APPID}&secret={$APPSECRET}&js_code={$code}&grant_type=authorization_code";
        $response = util_request($url);
        $response = json_decode($response, true);
        if (@$response['openid']) {
            $response = Db::table('user')->where('openid', $response['openid'])->find();
            if ($response) {
                $response['id'] = (string)$response['_id'];
                unset($response['openid']);
                unset($response['_id']);
                return json(['code' => 0, 'data' => $response]);
            } else {
                return json(['code' => 1, 'errmsg' => $response]);
            }
        } else {
            return json($response);
        }
    }
}
