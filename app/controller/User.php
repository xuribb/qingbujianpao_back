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

    public function setLine()
    {
        $params = (new UserValidate())->isPost()->goCheck('setLine');
        $result = Db::name("record")->insertGetId($params);
        if ($result) {
            return json(['code' => 1, 'msg' => '保存记录成功', 'data' => ['_id' => $result]]);
        } else {
            return json(['code' => 0, 'msg' => '保存记录失败']);
        }
    }

    public function getLine()
    {
        $params = (new UserValidate())->isPost()->goCheck('getLine');
        if (empty($params['_id'])) {
            $result = Db::name("record")->where("openid", $params['openid'])->field('_id')->order("_id", 'desc')->select()->toArray();
            $result = array_map(function ($val) {
                $val['timestamp'] = $val['_id']->getTimestamp();
                $val['_id'] = $val['_id']->__toString();
                return $val;
            }, $result);
        } else {
            $result = Db::name("record")->where("openid", $params['openid'])->where('_id', $params['_id'])->field('points')->findOrEmpty();
        }
        return json(['code' => 1, 'msg' => '获取信息成功', 'data' => $result]);
    }
}
