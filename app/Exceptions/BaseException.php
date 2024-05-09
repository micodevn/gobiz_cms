<?php

namespace App\Exceptions;

use Illuminate\Support\Arr;

class BaseException extends \Exception
{
    protected $data;

    public function __construct($message = "", $code = 0, $data = [])
    {
        if (!$code) {
            $exceptionConfig = config('exception.codes');

            $code = Arr::get($exceptionConfig, get_class($this), BaseException::class);
        }

        $this->data = $data;

        parent::__construct($message, intval($code));
    }

    public function __toString()
    {
        return __(parent::__toString());
    }

    public function getData()
    {
        return $this->data;
    }
}
