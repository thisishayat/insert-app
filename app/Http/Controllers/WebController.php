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
        return $retData;
    }
    public function getCallData($en,$list_status,Request $request){
        $repo = new WebRepository();
        $request->offsetSet('list_status', $list_status);

        $retData = $repo->getCallData($request);
        return  $retData;
    }
    public function updateStatus($en,Request $request){
        $repo = new WebRepository();
        $retData = $repo->updateStatus($request);
        return  $retData;
    }
    public function logout($en,Request $request){
        $repo = new WebRepository();
        $retData = $repo->logout($request);
        return  $retData;
    }

}