<?php
namespace App\Helper;
use App\Country;
use App\phoneCodeDetails;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/**
 * Created by PhpStorm.
 * User: backend
 * Date: 6/7/18
 * Time: 12:00 PM
 */
class Helper
{

    /**
     * @param $request
     * @return array
     * mobile msg send
     */
    /**
     * @param $postVars
     * @return array
     */



    function curlReqJsonBasicAuth($url, $method = 'GET', $auth=[], $data = [])
    {
        $username = $auth['username'];
        $password = $auth['password'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic ".base64_encode("$username:$password"),
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));
        if($method=='POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return $response;
    }

    function curlReqJson($url, $method = 'GET', $data = []) {
        $userAgent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
        $query = http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
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
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }



    public function sendSmsPhoneInfobip($param = array()) {
        //====================================== send SMS to the user
        $phoneCodeDetails = new phoneCodeDetails();
        try {
            $hasPlus = strpos($param['phone'],'+');
            $phone = ($hasPlus === false) ? $param['phone'] : substr($param['phone'], 1);
            $msg = $param['msg'];
            $helper = new Helper();
            $auth = ['username'=>env('INFOBIP_USER'),'password'=>env('INFOBIP_PASS')];
            $live_url = "https://api.infobip.com/sms/1/text/single";
            $data = [
                'from'=>'8804445651234',
                // 'from'=>'8804445650000',
                'to'=>$phone,
                'text'=>$msg

            ];
            $parse_url = $helper->curlReqJsonBasicAuth($live_url, "POST", $auth, $data);
            //dump($parse_url);
            //$parse_url = '{"messages":[{"to":"8801991126415","status":{"groupId": 1,"groupName": "PENDING","id": 7,"name": "PENDING_ENROUTE","description": "Message sent to next instance"},"smsCount": 1,"messageId": "2101149718951631161"}]}';
            //$parse_url = '{"messages":[{"status":{"groupId":5,"groupName":"REJECTED","id":51,"name":"MISSING_TO","description":"Missing destination.","action":"Check to parameter."}}]}';

            $response_msg = json_decode($parse_url, true);
            $statusGroupId = $response_msg['messages'][0]['status']['groupId'];

            $sms_send = 0;
            $status = 0;
            $msgCode = '';
            if($statusGroupId==1 || $statusGroupId == 3) { // pending/delivered
                $sms_send = 1;
                $status = 1;
                $msgCode = $response_msg['messages'][0]['messageId'];
            }
            // update sms send status and datetime
            $updateCodeDtls =  $phoneCodeDetails->find($param['code_id']);
            $updateCodeDtls->sms_send = $sms_send;
            $updateCodeDtls->sms_send_at = Carbon::now();
            $updateCodeDtls->save();
        }
        catch (\Exception $e) {
            return 0;
        }

        $updateCodeDtls = null;
        try {
            $updateCodeDtls = $phoneCodeDetails->find($param['code_id']);
            $updateCodeDtls->code = $statusGroupId;
            $updateCodeDtls->status = $status;
            $updateCodeDtls->msg_id = $msgCode;
            $updateCodeDtls->response_msg = json_encode($response_msg);
            $updateCodeDtls->response_at = Carbon::now();
            $saveUpdate = $updateCodeDtls->save();
            if ($saveUpdate) {
                return 1;
            }
        }
        catch (\Exception $e) {
            return 0;
        }
        return 0;
    }

    public function getSingleUserInfoById($userId){
        $get = User::find($userId);
        $get = $get->toArray();
        $get['prof_link']=env('PROF_LINK');
        return $get;
    }
    public function getSingleUserInfoByShopperId($userId){
        $get = User::with('getShopDetails')->where(['role'=>1,'shopper_id'=>$userId])->get()->toArray();
        $get = isset($get[0]) ? $get[0] : [];
        return $get;
    }

    public function getErrors($e){
//        return [];
        return [$e->getLine(),$e->getMessage(),$e->getFile()];
    }
}