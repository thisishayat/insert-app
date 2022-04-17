<?php
/**
 * Created by PhpStorm.
 * User: backend
 * Date: 5/30/18
 * Time: 1:12 PM
 */

namespace App\Http\Controllers;


use App\Country;
use App\Http\Repositories\RootSystemAuthRepo;
use App\Http\Repositories\UserAuthRepo;
use Illuminate\Http\Request;

class ApiController
{



    public function insertApp($en,Request $request)
    {
        $UserAuthRepo = new UserAuthRepo();
        $retData = $UserAuthRepo->insertApp($request);
        return response()->json($retData,$retData['status']);
    }


    public function updateStatusApi($en,Request $request){
        $repo = new UserAuthRepo();
        $retData = $repo->updateStatusApi($request);
        return  $retData;
    }



}