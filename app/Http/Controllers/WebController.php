<?php
/**
 * Created by PhpStorm.
 * User: backend
 * Date: 5/28/18
 * Time: 2:16 PM
 */

namespace App\Http\Controllers;


use App\Http\Repositories\WebRepository;
use Illuminate\Http\Request;

class WebController
{

    public function logIn($en,Request $request){
        $repo = new WebRepository();
        $retData = $repo->logIn($request);
        return response()->json($retData);
    }
    public function getCallData($en,Request $request){
        $repo = new WebRepository();
        $retData = $repo->getCallData($request);
        return  $retData;
    }
    public function updateStatus($en,Request $request){
        $repo = new WebRepository();
        $retData = $repo->updateStatus($request);
        return  $retData;
    }

}