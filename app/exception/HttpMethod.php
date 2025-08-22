<?php

namespace app\exception;

use think\Exception;

class HttpMethod extends Exception
{
    protected $code = 10001;
    protected $message = '请求方法错误';
    public function __construct($message = null, $code = null)
    {
        if (!is_null($message)) {
            $this->message = $message;
        }

        if (!is_null($code)) {
            $this->code = $code;
        }

        parent::__construct($this->message, $this->code);
    }

    public function getError()
    {
        return $this->message;
    }
}