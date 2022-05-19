<?php
/**
 * Created by PhpStorm.
 * User: backend
 * Date: 2/19/18
 * Time: 4:12 PM
 */
namespace App\Http\Repositories;



use App\ApiFailedReq;
use App\InsertApp;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\UsersNumberSeeder;

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
            $validator = Validator::make($request->all(), [
                'call_number' => 'required|numeric',
                'call_receive_number' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return ['status' => trans('custom.status.failed'), 'error' => $validator->errors()];
            }
            $rcvNumber = $input['call_number'];
            $callNumber = $input['call_receive_number'];
            $input['call_receive_number'] = $rcvNumber;
            $input['call_number'] = $callNumber;

            $getALlStatus = DB::table('insert_app')->where('call_number',$input['call_number'])->where('call_receive_number',$input['call_receive_number'])->get()->last();
            if(is_null($getALlStatus) || (is_numeric($getALlStatus->status) && $getALlStatus->status == 1) || ($input['start_end'] == 0)){
                $getEmail = $this->getEmail($input);
                $input['remarks'] = isset($getEmail['service_id']) ? 'Helpdesk Service ID '.$getEmail['service_id'] :'';
                // status,is_call,updated by default insert 0 , set from DB
                $status = 0;
                $is_call = 0;
                if($input['start_end'] == 0){
                    $status = 1;
                    $is_call = 1;
                }
                DB::beginTransaction();
                $CallDataInsert = InsertApp::create(
                    [
                        'call_number' => $input['call_number'],
                        'call_receive_number' => $input['call_receive_number'],
                        'input_date_time' => $input['date_time'],
                        'start_end' => $input['start_end'],
                        'status' => $status,
                        'is_call' => $is_call,
                        'remarks' =>$input['remarks'],
                    ]);
                $helpDeskDataArray = [];
                $ticketCreate = [];
                if(isset($getEmail['service_id'])){
                    $helpDeskDataArray = [
                        'service_id'=>$getEmail['service_id'],
                        'note'=>$input['call_receive_number'],
                        'receive_number'=>$input['call_number'],
                        'call_id'=>$CallDataInsert->id,
//                      'call_id'=>99,
                        'email'=>$getEmail['email'],
                    ];
                    $ticketCreate=$this->creatHelpDeskTicket($helpDeskDataArray);
                }
                if(count($CallDataInsert->toArray())){
                    $res = [
                        'status'=>trans('custom.status.success'),
                        'msg'=>trans('custom.msg.dataSuccess'),
                        'data'=>$CallDataInsert->toArray(),
                        'helpdeskDataArrReq'=>$helpDeskDataArray,
                        'helpdeskRes'=>$ticketCreate,
                    ];
                    DB::commit();
                }

            }
            else{
                $input['remarks'] = json_encode($input);
                $CallDataFailed = ApiFailedReq::create(
                    [
                        'call_number_failed_reqs' => $input['call_number'],
                        'call_receive_number_failed_reqs' => $input['call_receive_number'],
                        'input_date_time' => $input['date_time'],
                        'start_end' => $input['start_end'],
                        'is_call' => 0,
                        'remarks' =>$input['remarks'],
                    ]);
                $res = [
                    'status'=>trans('custom.status.dbInsertError'),
                    'msg'=>trans('custom.msg.dataInsertZeroStatus'),
                    'FailedReq'=>$CallDataFailed->toArray(),                ];
                DB::commit();
            }

        } catch (Exception $e) {
            $input['error'] = $e->getLine()." ".$e->getCode()." ".$e->getMessage();
            $input['remarks'] = json_encode($input);
            $CallDataFailed = ApiFailedReq::create(
                [
                    'call_number_failed_reqs' => $input['call_number'],
                    'call_receive_number_failed_reqs' => $input['call_receive_number'],
                    'input_date_time' => $input['date_time'],
                    'start_end' => $input['start_end'],
                    'is_call' => 0,
                    'remarks' =>$input['remarks'],
                ]);
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => [$e->getLine(), $e->getCode(),$e->getMessage()]
            ];
            DB::commit();
        }
        return $res;
    }

    public function getEmail($input){
        $res = [];
        $userNumModel = new UsersNumberSeeder();
        $getData = $userNumModel->where(['call_receive_number'=>$input['call_receive_number'],'start_end'=>$input['start_end']])->get()->toArray();
        if(count($getData) == 1){
            $res =  $getData[0];
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

                $getData = $insertApp->where('id',$input['call_id'])->where(['status'=>0])->update(['status'=>1]);
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

    function creatHelpDeskTicket($helpDeskDataArray){
        //dd('dd');
        $url = env('HELPDESK_APP_URL').'/api/ticket-create';
            $rv = $this->curlReq($url,'POST',$helpDeskDataArray,'');
           // dd($rv);
            $returnArr = json_decode($rv, true);
            return is_null($returnArr) ? $rv : $returnArr;

    }





}