<?php

namespace app\controller;

use app\BaseController;
use think\facade\Env;

class Weather extends BaseController
{
    public function now(){
        $params = $this->request->param();

    }
}
