<?php
/**
 * Created by PhpStorm.
 * User: backend
 * Date: 2/19/18
 * Time: 4:12 PM
 */
namespace App\Http\Repositories;



use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RootSystemAuthRepo
{

    /**
     *
     * @param $postVars
     * @return array|int|string
     */


    function getOperator($request){
        try {
            $res = [
                'status'=>trans('custom.status.noData'),
                'msg'=>trans('custom.msg.invalid'),
                'error'=>trans('custom.msg.noData'),
            ];

            $input = $request->input();
            $validator = Validator::make($request->all(), [
                'root_token_id' => 'required|string',
            ]);
            if ($validator->fails()) {
                return ['status' => trans('custom.status.failed'), 'error' => $validator->errors()];
            }


            if (isset($input['root_token_id'])) {
                $url = 'https://app.spaysy.com/backend/rec/get_produttori/?tipo_prodotto=0';
                if(isset($input['root_token_id'])){
                    $userAuthRepo = new UserAuthRepo();
                    $rv = $userAuthRepo->curlReq($url,'GET',[],$input['root_token_id']);
                    $getOperator = json_decode($rv, true);
                    if($getOperator!=null){
                        $getOperatorArray = [];
                        foreach ($getOperator as $o){
                            $oArr = [];
                           // $oArr['id'] = $o['id'];
                           // $oArr['description'] = $o['descrizione'];//operator_description
                           // $oArr['service_code'] = $o['codice_servizio'];// operator_code
                            $oArr['type_of_interfacing'] = $o['tipo_interfacciamento'];
                            /*international operators*/
                            $oArr['operator_id'] = $o['id'];
                            $oArr['country_code'] = $input['country_code'];
                            $oArr['operator_code'] = $o['codice_servizio'];
                            $oArr['operator_description'] = $o['descrizione'];
                            $oArr['customer_care'] = '';
                            $oArr['prefix'] = '';
                            $oArr['validation'] = '';
                            $oArr['minimum'] = '';
                            $oArr['maximum'] = '';
                            $oArr['minimum_currency'] = '';
                            $oArr['maximum_currency'] = '';
                            $oArr['amounts'] = [];
                            $oArr['number_digits_validation'] = 11;
                            $oArr['rate'] = 0;
                            $oArr['fee'] = 0;
                            $oArr['fee_base_perc'] = 0;
                            $oArr['currency_icon'] = "€";
                            $oArr['currency'] = 'EUR';
                            $oArr['oper_logo'] = env('APP_URL')."/operator-logos/".$input['country_code']."/".$o['codice_servizio'].".png";


                            $getOperatorArray[] = $oArr;
                        }
                        $res = [
                            'status'=>trans('custom.status.success'),
                            'msg'=>trans('custom.msg.dataGet'),
                            'data' => $getOperatorArray,
                        ];
                    }

                }
            }
        } catch (Exception $e) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => "Code=".$e->getCode().";"."Message=".$e->getMessage()
            ];
        }
        return $res;


    }

    function getIgetProductnational($request){
        try {
            $res = [
                'status'=>trans('custom.status.noData'),
                'msg'=>trans('custom.msg.invalid'),
                'error'=>trans('custom.msg.noData'),
            ];

            $input = $request->input();
            $validator = Validator::make($request->all(), [
                'root_token_id' => 'required|string',
                'country_code' => 'required|string',
            ]);
            if ($validator->fails()) {
                return ['status' => trans('custom.status.failed'), 'error' => $validator->errors()];
            }


            if (isset($input['root_token_id'])) {
                $url = 'https://app.spaysy.com/backend/recInt/operatori?paese='.$input['country_code'];
                if(isset($input['root_token_id'])){
                    $userAuthRepo = new UserAuthRepo();
                    $rv = $userAuthRepo->curlReq($url,'GET',[],$input['root_token_id']);
                    $getOperator = json_decode($rv, true);
                    //dd($getOperator);
                    if($getOperator!=null){
                        $getOperatorArray = [];
                        foreach ($getOperator as $o){
                            $oArr = [];
                            $oArr['type_of_interfacing'] = "";
                            $oArr['operator_id'] = $o['IDOperatore'];
                            $oArr['country_code'] = $o['CodicePaese'];
                            $oArr['operator_code'] = $o['CodiceOperatore'];
                            $oArr['operator_description'] = $o['DescrizioneOperatore'];
                            $oArr['customer_care'] = $o['ServizioClienti'];
                            $oArr['prefix'] = $o['Prefisso'];
                            $oArr['validation'] = $o['Validazione'];
                            $oArr['minimum'] = $o['Minimo'];
                            $oArr['maximum'] = $o['Massimo'];
                            $oArr['minimum_currency'] = $o['MinimoValuta'];
                            $oArr['maximum_currency'] = $o['MassimoValuta'];
                            $oArr['amounts'] = $o['Importi'];
                            $oArr['number_digits_validation'] = $o['NumeroCifreValidazione'];
                            $oArr['currency'] = $o['Currency'];
                            $oArr['rate'] = $o['Rate'];
                            $oArr['fee'] = $o['FeeBaseAmount'];
                            $oArr['fee_base_perc'] = $o['FeeBasePerc'];
                            $oArr['currency_icon'] = $o['Currency'];
                            $oArr['oper_logo'] = env('APP_URL')."/operator-logos/".$o['CodicePaese']."/".$o['CodiceOperatore'].".png";
                            $getOperatorArray[] = $oArr;
                        }
                        $res = [
                            'status'=>trans('custom.status.success'),
                            'msg'=>trans('custom.msg.dataGet'),
                            'data' => $getOperatorArray,
                        ];
                    }

                }
            }
        } catch (Exception $e) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => "Code=".$e->getCode().";"."Message=".$e->getMessage()
            ];
        }
        return $res;


    }

    function getServiceProviderAmountById($request){
        try {
            $res = [
                'status'=>trans('custom.status.noData'),
                'msg'=>trans('custom.msg.invalid'),
                'error'=>trans('custom.msg.noData'),
            ];

            $input = $request->input();
            $validator = Validator::make($request->all(), [
                'root_token_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return ['status' => trans('custom.status.failed'), 'error' => $validator->errors()];
            }

            if (isset($input['root_token_id'])) {
                $url = 'https://app.spaysy.com/backend/rec/get_prodotti?id_produttore='.$input['manufacturer_id'];
                if(isset($input['root_token_id'])){
                    $userAuthRepo = new UserAuthRepo();
                    $rv = $userAuthRepo->curlReq($url,'GET',[],$input['root_token_id']);
                    $getOperator = json_decode($rv, true);
                    //dd($getOperator);
                    if($getOperator!=null){
                        $getOperatorArray = [];
                        foreach ($getOperator as $o){
                            $oArr = [];
                            $oArr['id'] = $o['id'];
                            $oArr['description'] = $o['descrizione'];
                            $oArr['customer_margin'] = $o['margine_cliente'];
                            $oArr['amount'] = $o['importo'];
                            $oArr['currency_icon'] = "€";
                            $oArr['currency'] = 'EUR';
                            $oArr['interfacing_type'] = $o['TipoInterfacciamento'];
                            $oArr['extra_fee'] = $o['margine_cliente'];
                            $oArr['recharge_amount'] = number_format((float)($o['importo']-$o['margine_cliente']), 2, '.', '') ;
                            $getOperatorArray[] = $oArr;
                        }
                        $res = [
                            'status'=>trans('custom.status.success'),
                            'msg'=>trans('custom.msg.dataGet'),
                            'data' => $getOperatorArray,
                        ];
                    }

                }
            }
        } catch (Exception $e) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => "Code=".$e->getCode().";"."Message=".$e->getMessage()
            ];
        }
        return $res;


    }



    function getCountryLists($request){
        try {
            $res = [
                'status'=>trans('custom.status.noData'),
                'msg'=>trans('custom.msg.invalid'),
                'error'=>trans('custom.msg.noData'),
            ];
            $input = $request->input();
            $validator = Validator::make($request->all(), [
                'root_token_id' => 'required|string',
            ]);
            if ($validator->fails()) {
                return ['status' => trans('custom.status.failed'), 'error' => $validator->errors()];
            }

            if (isset($input['root_token_id'])) {

                $url = 'https://app.spaysy.com/backend/recInt/paesi';
                if(isset($input['root_token_id'])){
                    $userAuthRepo = new UserAuthRepo();
                    $rv = $userAuthRepo->curlReq($url,'GET',[],$input['root_token_id']);
                    $getCountry = json_decode($rv, true);
                    if($getCountry!=null){
                        $getCountryArray = [];
                        foreach ($getCountry as $c){
                            $cArr = [];
                            $cArr['code'] = $c['codice'];
                            $cArr['prefix'] = $c['prefisso'];
                            $cArr['description'] = $c['descrizione'];
                            $cArr['country_flag'] = env('APP_URL')."/country/svg/".strtolower($c['codice']).".svg";
                            $getCountryArray[] = $cArr;
                        }
                        $res = [
                            'status'=>trans('custom.status.success'),
                            'msg'=>trans('custom.msg.dataGet'),
                            'data' => $getCountryArray,
                        ];
                    }

                }
            }
        } catch (Exception $e) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => "Code=".$e->getCode().";"."Message=".$e->getMessage()
            ];
        }
        return $res;


    }

    function mobileRecharge($request){
        try {
            $res = [
                'status'=>trans('custom.status.noData'),
                'msg'=>trans('custom.msg.invalid'),
                'error'=>trans('custom.msg.noData'),
            ];
            $input = $request->input();
            //dd($input);
            $validator = Validator::make($request->all(), [
                'root_token_id' => 'required|string',
                'country_code' => 'required|string',
                'operator_code' => 'required|string',
                'number' => 'required|string',
                'amount' => 'required|numeric',
                'oper_amount_id' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return ['status' => trans('custom.status.failed'), 'error' => $validator->errors()];
            }

            if (isset($input['root_token_id'])) {
                //Request URL: https://app.spaysy.com/backend/recInt/ricarica/?CodicePaese=BD&CodiceOperatore=EXT-BK&Numero=+8801797248121&Importo=1&Prezzo=1.000
                $input['price'] = number_format((float)$input['amount'], 3, '.', '');
                $url = 'https://app.spaysy.com/backend/recInt/ricarica/?CodicePaese='.$input['country_code'].'&CodiceOperatore='.$input['operator_code'].'&Numero='.$input['number'].'&Importo='.$input['amount'].'&Prezzo='.$input['price'];
                if($input['country_code'] == "IT"){
                    $url = 'https://app.spaysy.com/backend/rec/acquista_prodotto/?id_prodotto=26&usercode=+390549121212';
                }
                    $userAuthRepo = new UserAuthRepo();
                    $rv = $userAuthRepo->curlReq($url,'GET',[],$input['root_token_id']);
                    $mobileRecharge = json_decode($rv, true);
                    if($mobileRecharge!=null){
                        $res = [
                            'status'=>trans('custom.status.success'),
                            'msg'=>trans('custom.msg.dataGet'),
                            'data' => $mobileRecharge,
                        ];
                        if(isset($mobileRecharge['messages'][0])){
                            $res = [
                                'status'=>trans('custom.status.failed'),
                                'msg'=>trans('custom.msg.rechargeFailed'),
                                'data' => $mobileRecharge['messages'][0],
                            ];
                        }
                    }
            }
        } catch (Exception $e) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => "Code=".$e->getCode().";"."Message=".$e->getMessage()
            ];
        }
        return $res;


    }
    function getBalance($request){
        try {
            $res = [
                'status'=>trans('custom.status.noData'),
                'msg'=>trans('custom.msg.invalid'),
                'error'=>trans('custom.msg.noData'),
            ];
            $input = $request->input();
            //dd($input);
            $validator = Validator::make($request->all(), [
                'root_token_id' => 'required|string',
            ]);
            if ($validator->fails()) {
                return ['status' => trans('custom.status.failed'), 'error' => $validator->errors()];
            }

            if (isset($input['root_token_id'])) {
                $url = "https://app.spaysy.com/backend/cont/get_plafond";
                    $userAuthRepo = new UserAuthRepo();
                    $rv = $userAuthRepo->curlReq($url,'GET',[],$input['root_token_id']);
                    $balacne = json_decode($rv, true);
                    if($balacne!=null){
                        if(count($balacne) > 0){
                            $res = [
                                'status'=>trans('custom.status.success'),
                                'msg'=>trans('custom.msg.dataGet'),
                                'data' => ['account_balance'=>$balacne['importo'],'currency'=>$balacne['valuta']],
                            ];
                        }
                    }
            }
        } catch (Exception $e) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => "Code=".$e->getCode().";"."Message=".$e->getMessage()
            ];
        }
        return $res;


    }

    function getUserInfo($request){
        try {
            $res = [
                'status'=>trans('custom.status.noData'),
                'msg'=>trans('custom.msg.invalid'),
                'error'=>trans('custom.msg.noData'),
            ];
            $input = $request->input();
            $validator = Validator::make($request->all(), [
                'root_token_id' => 'required|string',
            ]);
            if ($validator->fails()) {
                return ['status' => trans('custom.status.failed'), 'error' => $validator->errors()];
            }
            if (isset($input['root_token_id'])) {
                $url = "https://app.spaysy.com/backend/anag/get_anagrafica";
                    $userAuthRepo = new UserAuthRepo();
                    $rv = $userAuthRepo->curlReq($url,'GET',[],$input['root_token_id']);
                    $getUserInfo = json_decode($rv, true);
                    if($getUserInfo!=null){
                        if(count($getUserInfo) > 0){
                            $userInfo['id'] = $getUserInfo['id'];
                            $userInfo['id_type_registry'] = $getUserInfo['id_tipo_anagrafica'];
                            $userInfo['first_name'] = $getUserInfo['nome'];
                            $userInfo['last_name'] = $getUserInfo['cognome'];
                            $userInfo['business_name'] = $getUserInfo['ragione_sociale'];
                            $userInfo['fiscal_code'] = $getUserInfo['codice_fiscale'];
                            $userInfo['vat_number'] = $getUserInfo['partita_iva'];
                            $userInfo['receipt_header'] = $getUserInfo['intestazione_scontrino'];
                            $userInfo['flag_enabling_caf'] = $getUserInfo['flag_abilitazione_caf'];
                            $res = [
                                'status'=>trans('custom.status.success'),
                                'msg'=>trans('custom.msg.dataGet'),
                                'data' => $userInfo,
                            ];
                        }
                    }
            }
        } catch (Exception $e) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => "Code=".$e->getCode().";"."Message=".$e->getMessage()
            ];
        }
        return $res;


    }

    function getItayRecentTopUp($request){
        try {
            $res = [
                'status'=>trans('custom.status.noData'),
                'msg'=>trans('custom.msg.invalid'),
                'error'=>trans('custom.msg.noData'),
            ];
            $input = $request->input();
            $validator = Validator::make($request->all(), [
                'root_token_id' => 'required|string',
                'filter_from' => 'required',
                'filter_to' => 'required',
            ]);
            if ($validator->fails()) {
                return ['status' => trans('custom.status.failed'), 'error' => $validator->errors()];
            }
            if (isset($input['root_token_id'])) {
                $url = "https://app.spaysy.com/backend/rec/lista_ricariche?tipo_prodotto=0&filter_from=".$input['filter_from']."&filter_to=".$input['filter_to'];
                    $userAuthRepo = new UserAuthRepo();
                    $rv = $userAuthRepo->curlReq($url,'GET',[],$input['root_token_id']);
                    $getItayRecentTopUp = json_decode($rv, true);
                    if(count($getItayRecentTopUp) > 0){
                        $getItayRecentTopUp = [];
                        foreach ($getItayRecentTopUp as $l){
                            $cArr = [];
                            $cArr['id'] = $l['codice'];
                            $cArr['requested_date'] = $l['data_richiesta'];
                            $cArr['mobile_number'] = $l['UserCode'];
                            $cArr['refill_manufacturer'] = $l['RicaricaProduttore'];
                            $cArr['refill_product'] = $l['RicaricaProdotto'];
                            $cArr['reload_sale_amount'] = $l['RicaricaImportoVendita'];
                            $cArr['plain_pin_code'] = $l['PlainPinCode'];
                            $getItayRecentTopUp[] = $cArr;
                        }
                        $res = [
                            'status'=>trans('custom.status.success'),
                            'msg'=>trans('custom.msg.dataGet'),
                            'data' => $getItayRecentTopUp,
                        ];
                    }
            }
        } catch (Exception $e) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => "Code=".$e->getCode().";"."Message=".$e->getMessage()
            ];
        }
        return $res;


    }

    function getInternationalRecentTopUp($request){
        try {
            $res = [
                'status'=>trans('custom.status.noData'),
                'msg'=>trans('custom.msg.invalid'),
                'error'=>trans('custom.msg.noData'),
            ];
            $input = $request->input();
            $validator = Validator::make($request->all(), [
                'root_token_id' => 'required|string',
                'filter_from' => 'required',
                'filter_to' => 'required',
            ]);
            if ($validator->fails()) {
                return ['status' => trans('custom.status.failed'), 'error' => $validator->errors()];
            }
            if (isset($input['root_token_id'])) {
                $url = "https://app.spaysy.com/backend/recInt/archivio/?Offset=".$input['offset']."&Limit=".$input['limit']."&FilterFrom=".$input['filter_from']."&FilterTo=".$input['filter_to'];
                    $userAuthRepo = new UserAuthRepo();
                    $rv = $userAuthRepo->curlReq($url,'GET',[],$input['root_token_id']);
                    $getInternationalRecentTopUp = json_decode($rv, true);
                    if(count($getInternationalRecentTopUp) > 0){
                        $getInternationalRecentTopUp = [];
                        foreach ($getInternationalRecentTopUp as $l){
                            $cArr = [];
                            $cArr['id'] = $l['codice'];
                            $cArr['requested_date'] = $l['data_richiesta'];
                            $cArr['mobile_number'] = $l['UserCode'];
                            $cArr['refill_manufacturer'] = $l['RicaricaProduttore'];
                            $cArr['refill_product'] = $l['RicaricaProdotto'];
                            $cArr['reload_sale_amount'] = $l['RicaricaImportoVendita'];
                            $cArr['plain_pin_code'] = $l['PlainPinCode'];
                            $getItayRecentTopUp[] = $cArr;
                        }
                        $res = [
                            'status'=>trans('custom.status.success'),
                            'msg'=>trans('custom.msg.dataGet'),
                            'data' => $getItayRecentTopUp,
                        ];
                    }
            }
        } catch (Exception $e) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => "Code=".$e->getCode().";"."Message=".$e->getMessage()
            ];
        }
        return $res;


    }

    function getMovements($request){
        try {
            $res = [
                'status'=>trans('custom.status.noData'),
                'msg'=>trans('custom.msg.invalid'),
                'error'=>trans('custom.msg.noData'),
            ];
            $input = $request->input();
            $validator = Validator::make($request->all(), [
                'root_token_id' => 'required|string',
                'filter_from' => 'required',
                'filter_to' => 'required',
            ]);
            if ($validator->fails()) {
                return ['status' => trans('custom.status.failed'), 'error' => $validator->errors()];
            }
            if (isset($input['root_token_id'])) {
                $url = "https://app.spaysy.com/backend/cont/lista_movimenti?FilterFrom=".$input['filter_from']."&FilterTo=".$input['filter_to'];
                    $userAuthRepo = new UserAuthRepo();
                    $rv = $userAuthRepo->curlReq($url,'GET',[],$input['root_token_id']);
                    $getMovements = json_decode($rv, true);
                    if(count($getMovements) > 0){
                        $getMovementsArr = [];
                        foreach ($getMovements as $l){
                            $cArr = [];
                            $cArr['id'] = $l['id'];
                            $cArr['data_moviment'] = $l['data_movimento'];
                            $cArr['causal'] = $l['causale'];
                            $cArr['amount'] = $l['importo'];
                            $cArr['commission'] = $l['commissione'];
                            $getMovementsArr[] = $cArr;
                        }
                        //dd($getMovementsArr);
                        $res = [
                            'status'=>trans('custom.status.success'),
                            'msg'=>trans('custom.msg.dataGet'),
                            'data' => $getMovementsArr,
                        ];
                    }
            }
        } catch (Exception $e) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => "Code=".$e->getCode().";"."Message=".$e->getMessage()
            ];
        }
        return $res;


    }

    function getLocalCurrency($request){
        try {
            $res = [
                'status'=>trans('custom.status.noData'),
                'msg'=>trans('custom.msg.invalid'),
                'error'=>trans('custom.msg.noData'),
            ];
            $input = $request->input();
            $validator = Validator::make($request->all(), [
                'root_token_id' => 'required|string',
                'rate' => 'required|numeric',
                'amount' => 'required|numeric',
                'fee' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return ['status' => trans('custom.status.failed'), 'error' => $validator->errors()];
            }
            if (isset($input['root_token_id'])) {
                //dd(env('APP_URL').'/storage');
                $localcurrency['rate'] = $input['rate'];
                $localcurrency['amount'] = $input['amount'];
                $localcurrency['fee'] = $input['fee'];
                $localcurrency['currency_icon'] = "৳";
                $localcurrency['local_currency_amount'] =  number_format((float)($input['rate']*$input['amount']), 4, '.', ''); ;
                $localcurrency['total_amount'] = $input['amount']+$input['fee'];
                $res = [
                    'status'=>trans('custom.status.success'),
                    'msg'=>trans('custom.msg.dataGet'),
                    'data' => $localcurrency,
                ];
            }
        } catch (Exception $e) {
            $res = [
                'status'=>trans('custom.status.failed'),
                'msg'=>trans('custom.msg.invalid'),
                'error' => "Code=".$e->getCode().";"."Message=".$e->getMessage()
            ];
        }
        return $res;


    }





}