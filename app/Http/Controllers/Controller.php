<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function sendSuccessResponse($data = [], string $message = '', int $statusCode = 200)
    {

        $contextData =  [
            'data' => $data,
            'message' => $message
        ];
        return response()->json(
            $contextData,
            $statusCode
        );
    }

    public function sendErrorResponse($errors = [], string $message = '', int $statusCode = 400)
    {

        $contextData =  [
            'errors' => $errors,
            'message' => $message
        ];
        return response()->json(
            $contextData,
            $statusCode
        );
    }
}
