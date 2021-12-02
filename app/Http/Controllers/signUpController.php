<?php
/**
 * Created by PhpStorm.
 * User: backend
 * Date: 2/19/18
 * Time: 1:05 PM
 */

namespace App\Http\Controllers;


use App\Http\Repositories\UserAuthRepo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class signUpController extends Controller
{
    /**
     * user sign up
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userSignp($en,Request $request)
    {
        $input = $request->input();
        $UserAuthRepo = new UserAuthRepo();
        $retData = $UserAuthRepo->userSignp($request);
        return response()->json($retData,$retData['status']);

    }
    public function webUserSignp(Request $request)
    {
        $input = $request->input();
        $UserAuthRepo = new UserAuthRepo();
        $retData = $UserAuthRepo->webUserSignp($request);
        return response()->json($retData,$retData['status']);

    }
    public function webUserSignpVerfiy($en,Request $request)
    {
        $input = $request->input();
        $UserAuthRepo = new UserAuthRepo();
        $retData = $UserAuthRepo->webUserSignpVerfiy($request);
        return response()->json($retData,$retData['status']);

    }

    /**
     * mobile code verification
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobileCodeSignUpCodeVerify(Request $request){
        $input = $request->input();
        $UserAuthRepo = new UserAuthRepo();
        $retData =  $UserAuthRepo->mobileCodeSignUpCodeVerify($input);
        return response()->json($retData,$retData['status']);
    }

    /**
     * device nomber verify
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deviceNoVerify(Request $request){
        $res = [
            'status'=>trans('custom.status.success'),
            'msg'=>trans('custom.msg.deviceExist')
        ];
        $input = $request->all();
        $validator = Validator::make($input, [
            'device_id' => 'required|string|exists:users,device_id',
        ]);
        if ($validator->fails()) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.validationError'),
                'data'=>$validator->messages(),
            ];
        }else{
            $userTbl = new User();
            $getMob = $userTbl->where(['device_id'=>$input['device_id'],'is_active'=>1])->get();
            if(count($getMob) > 0){
                $getMob = $getMob->toArray();
                $getMob = $getMob[0];
                $res['mobile'] = $getMob['mobile'];
            }
        }
        return response()->json($res,$res['status']);
    }



    public function wrongMobileNumber(Request $request){
        $input = $request->input();
        $UserAuthRepo = new UserAuthRepo();
        $retData =  $UserAuthRepo->wrongMobileNumber($input);
        return response()->json($retData,$retData['status']);
    }

    public function getTokenViaCode(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'mobile' => 'required|string|exists:users,mobile',
        ]);
        if ($validator->fails()) {
            $retData = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.validationError'),
                'data'=>$validator->messages(),
            ];
            return $retData;
        }

        $UserAuthRepo = new UserAuthRepo();
        $retData =  $UserAuthRepo->getTokenViaCode($request);
        return response()->json($retData,$retData['status']);
    }

    public function logIn(Request $request){
        $UserAuthRepo = new UserAuthRepo();
        $retData = $UserAuthRepo->logIn($request);
        return response()->json($retData);
    }

    public function getUserData(Request $request){
        $UserAuthRepo = new UserAuthRepo();
        $retData = $UserAuthRepo->getUserData($request);
        return response()->json($retData);
    }




}