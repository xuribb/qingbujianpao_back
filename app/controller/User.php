<?php

namespace app\controller;

use app\BaseController;
use app\validate\UserValidate;
use think\facade\Env;
use think\facade\Db;

class User extends BaseController
{
    public function code2Session()
    {
        $params = (new UserValidate())->isGet()->goCheck('Code2Session');
        $query = [
            'appid' => Env::get("APPID"),
            'secret' => Env::get("APPSECRET"),
            'js_code' => $params['code'],
            'grant_type' => "authorization_code"
        ];
        $response = request("https://api.weixin.qq.com/sns/jscode2session", $query);
        if (isset($response['code'])) {
            return json($response);
        } else {
            if (empty($response['openid'])) {
                return json(['code' => 0, 'msg' => $response['errmsg']]);
            } else {
                $user = Db::name("user")->where("openid", $response['openid'])->find();
                if ($user) {
                    return json(['code' => '1', 'msg' => '用户已存在', 'data' => ['openid' => $response['openid']]]);
                } else {
                    $result = Db::name("user")->save(["openid" => $response['openid']]);
                    if ($result) {
                        return json(['code' => '1', 'msg' => '用户创建成功', 'data' => ['openid' => $response['openid']]]);
                    } else {
                        return json(['code' => '0', 'msg' => '用户创建失败']);
                    }
                }
            }
        }
    }
}
