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
            $rcvNumber = $input['call_number'];
            $callNumber = $input['call_receive_number'];
            $input['call_receive_number'] = $rcvNumber;
            $input['call_number'] = $callNumber;
            $input['remarks'] = "helpdesk_43";

            $getALlStatus = DB::table('insert_app')->where('call_number',$input['call_number'])->where('call_receive_number',$input['call_receive_number'])->get()->last();
            //dd(is_null($getALlStatus));
         //   dd(is_numeric($getALlStatus->status) , $getALlStatus->status == 1);
//            if(true){
            $input['remarks'] = isset($input['remarks']) ? $input['remarks'] :'';
//            if(true){
            if(is_null($getALlStatus) || (is_numeric($getALlStatus->status) && $getALlStatus->status == 1)){
                // status,is_call,updated by default insert 0 , set from DB
                DB::beginTransaction();
                $CallDataInsert = InsertApp::create(
                    [
                        'call_number' => $input['call_number'],
                        'call_receive_number' => $input['call_receive_number'],
                        'input_date_time' => $input['date_time'],
                        'start_end' => $input['start_end'],
                        'status' => 0,
                        'is_call' => 0,
                        'remarks' =>$input['remarks'],
                    ]);

                // api call here
                $helpDeskDataArray = [];
                $ticketCreate = [];
                $str_arr = explode ("_", $input['remarks']);
                $getEmail = $this->getEmail($input['call_receive_number']);

                if(isset($str_arr[0]) && $str_arr[0] == 'helpdesk'){
                    $helpDeskDataArray = [
                        'service_id'=>$str_arr[1],
                        'note'=>$input['call_receive_number'],
                        'receive_number'=>$input['call_number'],
                        'call_id'=>$CallDataInsert->id,
//                      'call_id'=>99,
                        'email'=>$getEmail,
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

            }else{
                $res = [
                    'status'=>trans('custom.status.dbInsertError'),
                    'msg'=>trans('custom.msg.dataInsertZeroStatus'),
                ];
                DB::rollBack();

            }

        } catch (Exception $e) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => $e->getCode().$e->getMessage()
            ];
            DB::rollBack();
        }
        return $res;
    }

    public function getEmail($call_number){
        $listOfEmaails = [
            '+390280886909' => 'vpaservice@vpaservice.it',
            '+390410980024' => 'vpaservice@vpaservice.it', // test
            '+3904441497243' => 'csnvicenza@cafcsn.it',
            '+395406011904' => 'helpdesknazionale@cafcsn.it',
            '+390687155140' => 'csnroma@cafcsn.it',
            '+390490990064' => 'csnpadova@cafcsn.it'
        ];
        return $listOfEmaails[$call_number];
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

    function creatHelpDeskTicket($helpDeskDataArray){
        //dd('dd');
        $url = env('HELPDESK_APP_URL').'/api/ticket-create';
            $rv = $this->curlReq($url,'POST',$helpDeskDataArray,'');
           // dd($rv);
            $returnArr = json_decode($rv, true);
            return is_null($returnArr) ? $rv : $returnArr;

    }





}