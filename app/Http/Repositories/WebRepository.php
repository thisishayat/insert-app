<?php
namespace App\Http\Repositories;
use App\InsertApp;
use App\User;
use App\UsersNumberSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;

/**
 * Created by PhpStorm.
 * User: backend
 * Date: 5/28/18
 * Time: 4:03 PM
 */
class WebRepository
{



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
                return redirect()->route('get_call_data',['en'=>'en','list_status'=>0]) ;
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

    public function getCallData($request){
        $userAuthCheck = Auth::check();
        if($userAuthCheck){
            $input = $request->input();
            $insertApp = new InsertApp();
            if(isset($input['list_status']) && $input['list_status'] == 1){
                $getData = $insertApp->select()->where(['status'=>1])->orderBy('id','desc')->paginate(1000);
            }else{
                $getData = $insertApp->where(['status'=>0])->orderBy('id','desc')->paginate(1000);
            }
            $getData = $getData->toArray();
//            dd($getData);
//            $result = array();
//            $data =$getData['data'];
//            foreach ($data as $element) {
//                $result[$element['call_number']][] = $element;
//            }
//dd($result);
//            $getComplete = $insertApp->where('status',1)->get()->toArray();
            $getComplete = DB::table('insert_app')->select('call_number')->where('status',1)->distinct()->get();
            $getNotComleted = DB::table('insert_app')->select('call_number')->where('status',0)->distinct()->get();
            //dd($getData->toArray());
            return view('call-data-list', ['result'=>$getData['data'],'getData' => $getData,'get_complete'=>count($getComplete->toArray()),'get_not_complete'=>count($getNotComleted->toArray())]);
        }
        return redirect()->route('login') ;

    }

    public function getNumbersData($request){
        $userAuthCheck = Auth::check();
        if($userAuthCheck){
            $input = $request->input();
            $insertApp = new UsersNumberSeeder();

            $getData = $insertApp->where(['is_active'=>1])->orderBy('id','desc')->paginate(1000);
            $getData = $getData->toArray();
//            dump($getData);
            return view('call-number-list', ['result'=>$getData['data'],'getData' => $getData]);
        }
        return redirect()->route('login') ;

    }
    public function insertNewNumber($request){
        $userAuthCheck = Auth::check();
        if($userAuthCheck){
            $input = $request->input();
            $insertApp = new UsersNumberSeeder();

            $CallDataInsert = UsersNumberSeeder::create(
                [
                    'email' => $input['email'],
                    'call_receive_number' => $input['call_receive_number'],
                    'start_end' => $input['start_end'],
                    'service_id' => $input['service_id'],
                ]);
            return redirect()->route('get_numbers',['en'=>'en']) ;
        }
        return redirect()->route('login') ;

    }
    public function FormInsertNewNumber($request){
        $userAuthCheck = Auth::check();
        if($userAuthCheck){

            return view('insert-new-number-form');
        }
        return redirect()->route('login') ;

    }
    public function FormEditNumber($request){
        $userAuthCheck = Auth::check();
        if($userAuthCheck){
            $input = $request->input();
            $insertApp = new UsersNumberSeeder();

            $getData = $insertApp->where(['id'=>$input['number_id']])->get()->first();
            $getData = $getData->toArray();
//            dd($getData);
            return view('edit-new-number-form',['getData'=>$getData]);
        }
        return redirect()->route('login') ;

    }
    public function forDdeleteNumber($request){
        $userAuthCheck = Auth::check();
        if($userAuthCheck){
            $input = $request->input();
//            dd($getData);
            return view('delete-number-form',['getData'=>$input]);
        }
        return redirect()->route('login') ;

    }
    public function submitEditNumber($request){
        $userAuthCheck = Auth::check();
        if($userAuthCheck){
            $input = $request->input();
           // dd($input);
            $insertApp = new UsersNumberSeeder();

            $getData = $insertApp->where(['id'=>$input['number_id']])->update([
                'email'=>$input['email'],
                'call_receive_number'=>$input['call_receive_number'],
                'start_end'=>$input['start_end'],
                'service_id'=>$input['service_id']
            ]);
//            $getData = $getData->toArray();
            return redirect()->route('get_numbers',['en'=>'en']) ;
        }
        return redirect()->route('login') ;

    }
    public function deleteNumber($request){
        $userAuthCheck = Auth::check();
        if($userAuthCheck){
            $input = $request->input();
           // dd($input);
            $insertApp = new UsersNumberSeeder();
            $getData = $insertApp->where(['id'=>$input['number_id']])->update([
                'is_active'=>0
            ]);
//            $getData = $getData->toArray();
            return redirect()->route('get_numbers',['en'=>'en']) ;
        }
        return redirect()->route('login') ;

    }
    public function updateStatus($request){
        try{
            $userAuthCheck = Auth::check();
            if($userAuthCheck){
                $input = $request->input();
                $validator = Validator::make($request->all(), [
                    'id' => 'required|numeric',
                    'status' => 'required|numeric',
                    'call_receive_number' => 'required|numeric',
                ]);
                if ($validator->fails()) {
                    return ['status' => 5000, 'get_prodottierror' => $validator->errors()];
                }

                 //dd($input);
                $insertApp = new InsertApp();
                $getMobile =  $insertApp->select('call_receive_number')->where('id',$input['id'])->get()->first()->toArray();

                $getData = $insertApp->where('id','<=',$input['id'])->where(['call_receive_number'=>$getMobile,'status'=>0])->update(['status'=>$input['status']]);
                //dd($getData);
                if($getData){
                    $updateCall = $insertApp->where('id',$input['id'])->update(['is_call'=>1]);
                    $getData = $insertApp->where('id',$input['id'])->get()->toArray();
                    $res = [
                        'status'=>trans('custom.status.success'),
                        'msg'=>trans('custom.msg.dataUpdate'),
                        'data_status'=>$getData,
                    ];
                    return $res;
                }
                $res = [
                    'status'=>trans('custom.status.failed'),
                    'msg'=>trans('custom.msg.dataUpdated'),
                    'data_status'=>$getData,
                    'req_data'=>$input,
                    'mobile'=>$request->get('call_receive_number'),

                ];
                return  $res;

            }
            //dd($res);
            return redirect()->route('login') ;
        }
        catch (Exception $e){
            $retData = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => $e->getCode()." Message:".$e->getMessage()
            ];
            $data =  response()->json($retData,$retData['status']);
            return $data;
        }


    }

    public function logout($request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

}