<?php
/**
 * Created by PhpStorm.
 * User: backend
 * Date: 2/19/18
 * Time: 4:12 PM
 */
namespace App\Http\Repositories;



use App\InsertApp;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserAuthRepo
{

    /**
     *
     * @param $postVars
     * @return array|int|string
     */
    public function insertApp($request)
    {

        try {

            $input = $request->input();

            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.dataInsertFail'),
            ];

            // dd($input);
            $validator = Validator::make($request->all(), [
                'call_number' => 'required|numeric',
                'call_receive_number' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return ['status' => trans('custom.status.failed'), 'error' => $validator->errors()];
            }
            //dd($input);

            $getALlStatus = DB::table('insert_app')->where('call_receive_number',$input['call_receive_number'])->get()->last();
            //dd();
            if(is_numeric($getALlStatus->status) && $getALlStatus->status == 1){
                // status,is_call,updated by default insert 0 , set from DB
                $user = InsertApp::create(
                    [
                        'call_number' => $input['call_number'],
                        'call_receive_number' => $input['call_receive_number'],
                        'input_date_time' => $input['date_time'],
                        'start_end' => $input['start_end'],
                        'remarks' =>$input['remarks'],
                    ]);

                // api call here

                if(count($user->toArray())){
                    $res = [
                        'status'=>trans('custom.status.success'),
                        'msg'=>trans('custom.msg.dataSuccess'),
                        'data'=>$user->toArray(),
                    ];
                    return $res;
                }

            }else{
                $res = [
                    'status'=>trans('custom.status.dbInsertError'),
                    'msg'=>trans('custom.msg.dataInsertZeroStatus'),
                ];

            }

        } catch (Exception $e) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => $e->getCode().$e->getMessage()
            ];
        }
        return $res;

    }

    public function updateStatusApi($request){
        try{
                $input = $request->input();
                $validator = Validator::make($request->all(), [
                    'call_id' => 'required|numeric|exists:insert_app,id',
                ]);
                if ($validator->fails()) {
                    return ['status' => 500, 'get_prodottierror' => $validator->errors()];
                }

                //dd($input);
                $insertApp = new InsertApp();
                $getMobile =  $insertApp->select('call_receive_number')->where('id',$input['call_id'])->get()->first()->toArray();

                $getData = $insertApp->where('id','<=',$input['call_id'])->where(['call_receive_number'=>$getMobile,'status'=>0])->update(['status'=>1]);
                //dd($getData);
                if($getData){
                    $updateCall = $insertApp->where('id',$input['call_id'])->update(['is_call'=>1]);
                    $getData = $insertApp->where('id',$input['call_id'])->get()->toArray();
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


            //dd($res);
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

    function curlReq($url, $method = 'GET', $data = [], $PHPSESSID='')
    {
        $query = http_build_query($data);
        $ch = curl_init();
        if ($method == 'GET') {
            curl_setopt($ch, CURLOPT_URL, $url . $query);
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $strCookie = 'PHPSESSID=' . session_name() . '; path=/';
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Cookie: PHPSESSID='.$PHPSESSID,
        ));

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, count($data));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        }
        $result = curl_exec($ch);

        curl_close($ch);
        return $result;
    }

    function AuthGenerate($input)
    {

        $data['LoginForm']['username'] = $input['username'];
        $data['LoginForm']['password'] = $input['password'];
        $data['yt0'] = 'Login';
        $url = 'https://app.spaysy.com/frontend/main/login';
        $method = 'POST';

        $query = http_build_query($data);
        $ch = curl_init();
        if ($method == 'GET') {
            curl_setopt($ch, CURLOPT_URL, $url . $query);
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, count($data));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        }
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $result = curl_exec($ch);
        //dd($result);
        curl_close($ch);
        preg_match_all('/login/i', $result, $authCheck);
        if(count($authCheck[0]) > 0){
            return ['error' => 'Authentication Failed'];
        } else {
            preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
            $cookies = [];
            if(isset($matches[1]) && count($matches[1])){
                $cookies = array();
                foreach($matches[1] as $item) {
                    parse_str($item, $cookie);
                    $cookies = array_merge($cookies, $cookie);
                }

            }
            return $cookies;
        }
    }

    function getProducts(){
        //dd('dd');
        $url = 'https://app.spaysy.com/backend/rec/get_produttori/?tipo_prodotto=0';
        if(isset($auth['PHPSESSID'])){
            $rv = $this->curlReq($url,'GET',[],$auth['PHPSESSID']);
            $product = json_decode($rv, true);
            return $product;
        }
    }





}