<?php

namespace app\validate;

use app\BaseValidate;

class UserValidate extends BaseValidate
{
    protected $rule = [
        'code' => 'require'
    ];

    protected $message = [
        'code.require' => 'code不能为空'
    ];

    protected function sceneCode2Session()
    {
        return $this->only(['code']);
    }
}