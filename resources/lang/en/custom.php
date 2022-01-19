<?php

return [

    'status'=>[
        'success' => '200',
        'failed' => '500',
        'noData' => '404',
        'validError' => '400',
        'dbInsertError' => '499',
        'notAcceptable' => '406',
        'Created' => '201',
        'noContent' => '204',
        'notModified' => '304',
        'Unauthorized' => '401',
        'notFound' => '404',
        'Forbidden' => '403',
        'Conflict' => '409',
        'serviceUnavailable' => '409',
        'unprocessableEntity' => '422',
    ],

    'msg'=>[
        'invalid'=>'Invalid request. Something wrong, please try again.',
        'dataSuccess'=>'Data create successfully',
        'dataUpdate'=>'Data update successfully',
        'dataGet'=>'Data get successfully',
        'dataExist'=>'Data already exist or duplicate entry. Please try later.',
        'dataUpdated'=>'Data already updated. Please try later or something wrong.',
        'dataInsertFail'=>'Data insert failed. Please try later.',
        'noData'=>'No data found.Please try later.',
        'loginNotSeccess'=>'Login token is not valid.',
        'rechargeFailed'=>'Recharge failed. Insufficient founds or Something Wrong. Please try again.',
    ]

];