<?php

namespace app\controller;

use app\BaseController;
use app\validate\Register;
use think\exception\ValidateException;

class Login2Register extends BaseController
{
    public function login()
    {
        if (empty($code)) {
            return json(['code' => 1, 'errmsg' => '登录失败，用户code不能为空。']);
        }

        $response = util_getAccessToken();
        $response = json_decode($response, true);
        if ($response['code'] == 0) {
            $at = $response['data'];
            return $at;
        } else {
            return json($response);
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

        // TODO  $this->login();


        // return json($data);
    }
}
