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
    public function getNumbersData($en,Request $request){
        $repo = new WebRepository();
        $retData = $repo->getNumbersData($request);
        return  $retData;
    }
    public function FormInsertNewNumber($en,Request $request){
        $repo = new WebRepository();
        $retData = $repo->FormInsertNewNumber($request);
        return  $retData;
    }
    public function FormEditNumber($en,Request $request,$number_id){
        $repo = new WebRepository();
        $request->offsetSet('number_id', $number_id);
        $retData = $repo->FormEditNumber($request);
        return  $retData;
    }
    public function forDdeleteNumber($en,Request $request,$number_id){
        $repo = new WebRepository();
        $request->offsetSet('number_id', $number_id);
        $retData = $repo->forDdeleteNumber($request);
        return  $retData;
    }
    public function submitEditNumber($en,Request $request,$number_id){
        $repo = new WebRepository();
        $request->offsetSet('number_id', $number_id);
        $retData = $repo->submitEditNumber($request);
        return  $retData;
    }
    public function deleteNumber($en,Request $request,$number_id){
        $repo = new WebRepository();
        $request->offsetSet('number_id', $number_id);
        $retData = $repo->deleteNumber($request);
        return  $retData;
    }
    public function insertNewNumber($en,Request $request){
        $repo = new WebRepository();
        $retData = $repo->insertNewNumber($request);
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