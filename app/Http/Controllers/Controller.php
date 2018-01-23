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
     * @param bool $success
     * @param mx $data
     * @param null $error
     * @return \Illuminate\Http\JsonResponse
     */
    protected function result($success = true, $data = null, $error = null)
    {
        $resultData=[];
        $resultData['success']=$success;
        if( $data){
            $resultData['data']=$data;
        }
        if($error){
            $resultData['error']=$error;
        }
        return response()->json($resultData,200);
    }


}
