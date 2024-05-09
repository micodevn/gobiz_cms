<?php
use Illuminate\Support\Facades\Response;

if (!function_exists('response_success')) {
    function response_success($data = [], $message = "", $code = 0)
    {
        return Response::json([
            "success" => true,
            "code" => $code,
            "message" => $message,
            "data"  => $data
        ]);
    }
}

if (!function_exists('response_error')) {
    function response_error($message = "", $code = 1000, $data = [])
    {
        return Response::json([
            "success" => false,
            "code" => $code,
            "message" => $message,
            "data"  => $data
        ]);
    }
}
