<?php

namespace App\Traits;

trait CustomResponse
{
    protected function success($data, $message,  $status = 200)
    {
        return response([
            'success' => true,
            'status_code' => $status,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    protected function failure($data, $message, $status = 400)
    {
        return response([
            'success' => false,
            'status_code' => $status,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
