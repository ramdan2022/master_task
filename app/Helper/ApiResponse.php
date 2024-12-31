<?php

namespace App\Helper;




class ApiResponse
{


    static function send_response($code, $msg = null, $data = [])
    {

        $response = [
            'code'    => $code,
            'massege' => $msg,
            'Data'    => $data

        ];

        return response()->json($response, $code);
    }
}
