<?php

namespace app\controller;

use app\BaseController;
use think\facade\Env;

class Weather extends BaseController
{
    public function now()
    {
        $params = $this->request->param();
        $response = weather("/v7/weather/now?location=".$params['location']);
        return json($response);
    }

    public function city()
    {
        $params = $this->request->param();
        $response = weather("/geo/v2/city/lookup?location=".$params['location']);
        return json($response);
    }
}
