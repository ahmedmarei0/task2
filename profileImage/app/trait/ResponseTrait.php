<?php

namespace App\trait;

trait ResponseTrait
{
    public function responseMessage($status, $code, $message, $data = null)
    {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}
