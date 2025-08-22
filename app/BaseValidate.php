<?php

namespace app;

use think\Validate;
use app\exception\HttpMethod;

abstract class BaseValidate extends Validate
{
    public function isPost()
    {
        if($this->request->isPost()){
            return $this;
        }else{
            throw new HttpMethod();
        }
    }

    public function isGet()
    {
        if($this->request->isGet()){
            return $this;
        }else{
            throw new HttpMethod();
        }
    }

    public function goCheck($scene)
    {
        $params = $this->request->param();
        validate(static::class)->scene($scene)->check($params);
        return $params;
    }
}
