<?php

namespace App\Traits;

// reusable code === trait
trait HttpResponses {
    protected function success($data, $message= null, $code = 200) {
        return response()->json([
            "status" => "success",
            "message" => $message,
            'data' => $data
        ], $code);
    }

    protected function error($data, $message= null, $code) {
        return response()->json([
            "status" => "error",
            "message" => $message,
            'data' => $data
        ], $code);
    }
}