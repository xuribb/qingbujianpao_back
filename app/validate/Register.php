<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Register extends Validate
{
    protected $rule = [
        'code' => 'require',
        'nickName' => 'require',
        'avatarUrl' => 'require'
    ];

    protected $message = [
        'code' => '用户CODE不能为空',
        'nickName' => '用户昵称不能为空',
        'avatarUrl' => '用户头像不能为空'
    ];
}
