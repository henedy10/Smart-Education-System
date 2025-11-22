<?php

namespace App\Traits;

trait ApiResponse {

    public function success($data = null , string $message = "Success" , int $status = 200)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ],$status)->header('Content-Type' , 'application/json');
    }

    public function error(string $message = "Error" , $errors = null , int $status = 404)
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors,
        ],$status)->header('Content-Type' , 'application/json');
    }
}
