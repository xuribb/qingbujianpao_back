<?php

namespace app\validate;

use app\BaseValidate;

class UserValidate extends BaseValidate
{
    protected $rule = [
        'code' => 'require',
        'openid' => 'require'
    ];

    protected $message = [
        'code.require' => 'code不能为空',
        'openid.require' => 'openid不能为空'
    ];

    protected function sceneCode2Session()
    {
        return $this->only(['code']);
    }

    protected function sceneSetLine()
    {
        return $this->only(['openid']);
    }
}