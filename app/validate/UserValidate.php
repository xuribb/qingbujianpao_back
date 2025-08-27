<?php

namespace app\validate;

use app\BaseValidate;

class UserValidate extends BaseValidate
{
    protected $rule = [
        'code' => 'require',
        'openid' => 'require',
        'points' => 'require'
    ];

    protected $message = [
        'code.require' => 'code不能为空',
        'openid.require' => 'openid不能为空',
        'points.require' => 'points不能为空'
    ];

    protected function sceneCode2Session()
    {
        return $this->only(['code']);
    }

    protected function sceneSetLine()
    {
        return $this->only(['openid', 'points']);
    }

    protected function sceneGetLine()
    {
        return $this->only(['openid']);
    }
}