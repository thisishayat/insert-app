<?php
namespace App\Http\Repositories;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Created by PhpStorm.
 * User: backend
 * Date: 5/28/18
 * Time: 4:03 PM
 */
class WebRepository
{


    public function signUp($request)
    {

        try {
            $input = $request->input();
            $validator = Validator::make($input, [
                'username' => 'required|string',
                'password' => 'required|string',
                'name' => 'required|string',
                'date_of_birth' => 'required|string',
                'place_of_birth' => 'required|string',
                'identity_card_no' => 'required|string',
                'type_of_identity' => 'required|string',
                'email' => 'required|string',
                'comp_name' => 'required|string',
                'vat_id' => 'required|string',
                'address' => 'required|string',
                'city' => 'required|string',
                'region' => 'required|string',
                'post_code' => 'required|string',
                'country_id' => 'required|exists:countries,id',
            ]);
            if ($validator->fails()) {
                $res = [
                    'status' => trans('custom.status.validError'),
                    'msg' => trans('custom.msg.validError'),
                    'error' => $validator->errors()

                ];
                return response()->json($res);
            } else {
                DB::beginTransaction();
                $userTbl = User::Create([
                    'username'=> $request->get('username'),
                    'password'=> bcrypt($request->get('password')),
                    'name'=> $request->get('name'),
                    'sur_name'=> $request->get('sur_name'),
                    'date_of_birth'=> $request->get('date_of_birth'),
                    'place_of_birth'=> $request->get('place_of_birth'),
                    'identity_card_no'=> $request->get('identity_card_no'),
                    'type_of_identity'=> $request->get('type_of_identity'),
                    'email'=> $request->get('email'),
                    'pin'=> rand(111,999),
                    'api_token' => md5(time().rand(11111111,99999999).uniqid().time()),
                    'comp_name'=> $request->get('comp_name'),
                    'vat_id'=> $request->get('vat_id'),
                    'address'=> $request->get('address'),
                    'city'=> $request->get('city'),
                    'region'=> $request->get('region'),
                    'post_code'=> $request->get('post_code'),
                    'country_id'=> $request->get('country_id'),
                    'role'=> 1,
                ]);

//                    $tempLoginTbl = new TempLogin();
//                    $tempLoginTbl->user_id = $userTbl->id;
//                    $tempLoginTbl->token = md5(time().$userTbl->id.$input['phoner_number'].rand(100000,999999));
//                    $tempLoginTbl->status = 1;
//                    $tempLoginTbl->save();

//                $emailData = $userTbl->toArray();
//                $emailData['title'] = "NDVCBD sign up";
//                $userMailSend = Mail::send('email.sign-up-mail', ['emdailData' => $emailData], function ($message) use ($emailData) {
//                    $message->from(env('MAIL_FROM'), 'NDVCBD');
//                    $message->to($emailData['email']);
//                    $message->subject($emailData['title']);
//                });
//
//                $emailDataAdmin = $userTbl->toArray();
//                $emailDataAdmin['title'] = "NDVCBD signed up by a user";
////                $emailDataAdmin['email'] = 'h.u.zaman@gmail.com';
//                $emailDataAdmin['email'] = 'support@tgalimited.com';
//                $userMailSend = Mail::send('email.sign-up-mail-admin', ['emailDataAdmin' => $emailDataAdmin], function ($message) use ($emailDataAdmin) {
//                    $message->from(env('MAIL_FROM'), 'NDVCBD');
//                    $message->to($emailDataAdmin['email']);
//                    $message->subject($emailDataAdmin['title']);
//                });

                DB::commit();
                $res = [
                    'status'=>trans('custom.status.success'),
                    'msg'=>trans('custom.msg.dataSuccess'),
                    'data' => $userTbl->toArray(),
                ];
            }

        } catch (\Exception $e) {
            dump($e);
            DB::rollBack();
            $res = [
                'status'=>trans('custom.status.dbInsertError'),
                'msg'=>trans('custom.msg.invalid')
            ];

        }
        return $res;

    }

    //========================
    // Authentication
    //========================
    public function login($request)
    {
        try {
            $input = $request->input();
            $validator = Validator::make($request->all(), [
                'username' => 'required|string',
                'password' => 'required|string',
            ]);
            if ($validator->fails()) {
                return ['status' => 5000, 'get_prodottierror' => $validator->errors()];
            }
            $credentials = array(
                'username' => $input['username'],
                'password' => $input['password']
            );
            $remember = isset($input['remember']) ? $input['remember'] : false;

            if (Auth::attempt($credentials, $remember)) {
                session('test','123456');
                $res = [
                    'status'=>trans('custom.status.success'),
                    'msg'=>trans('custom.msg.dataGet'),
                    'data' => Auth::user()->toArray(),
                ];
            } else {
                $res = [
                    'status'=>trans('custom.status.failed'),
                    'msg'=>trans('custom.msg.invalid'),
                ];
            }
        } catch (Exception $e) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => $e->getCode()
            ];
        }
        return $res;

    }

    public function getUserData($request){
        $user = Auth::user();
        return $user;
    }

}