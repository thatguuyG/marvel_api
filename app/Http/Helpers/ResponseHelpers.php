<?php

/** This method is used to return the json response
 * @param $message
 * @param int $status
 * @param array $data
 * @param int $code
 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
 */

function result($message, $data = [],$status = 200, $code = 0, $suppress_logging = false)
{
    $error = (!($status == 200 || $status == 201) || ($status == -1));
    $status = ($status == -1)? 200 : $status;

    if(!empty($data)){
        $response = [
            'status' => $status,
            'response_code' => $code,
            'error' => $error,
            'message' => $message,
            'data' => $data
        ];
    }
    else{
        $response = [
            'status' => $status,
            'response_code' => $code,
            'error' => $error,
            'message' => $message
        ];
    }

    // Skip logging for sensitive information
    if($suppress_logging){
        return response($response,$status);
    }

    if(!request('draw',false) && !request('photoImage',false)){
        $data = [
            'url' => url()->current(),
            'request' => json_encode(request()->all()),
            'status' => $error ? 0 : 1,
            'response' => json_encode($response),
        ];
        // insert('tbl_request_logs',$data);
    }

    return response($response,$status);

}