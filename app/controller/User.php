<?php

namespace app\controller;

use app\BaseController;
use app\validate\UserValidate;

class User extends BaseController
{
    public function code2Session()
    {
        $params = (new UserValidate())->isGet()->goCheck('Code2Session');
        return json($params);








//        $qurry = [
//            'appid' => "",
//            'secret' => "",
//            'js_code' => $params['code'],
//            'grant_type' => "authorization_code"
//        ];
//        request("https://api.weixin.qq.com/sns/jscode2session")
//        return json($params);
    }
}
