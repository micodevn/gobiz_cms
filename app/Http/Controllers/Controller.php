<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const DEFAULT_KEY_MESSAGE = 'message';

    const DEFAULT_KEY_MESSAGE_ERROR = 'message-error';

    const DEFAULT_STATUS_VALUE = 'on';

    public function responseSuccess($data = [], $message = "", $code = 0)
    {
        return response_success($data, $message, $code);
    }

    public function responseError($message = "", $code = 1000, $data = [])
    {
        return response_error($message, $code, $data);
    }
}
