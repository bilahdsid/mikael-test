<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function successResponse($result, $message,$code=200){
        $response = [
            'success' => true,
            'status_code'    =>$code,
            'message' => $message,
            'data'   => $result
        ];

        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function errorResponse($error, $errorMessages = [], $code = 402){

        $response = [
            'success' => false,
            'status_code'    =>$code,
            'message' => $error,
            'data'    => $errorMessages
        ];

        return response()->json($response, $code);
    }
}
