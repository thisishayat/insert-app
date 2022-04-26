<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiFailedReq extends Model
{
    protected $table = 'api_failed_reqs';

    protected $fillable = [
        'call_number_failed_reqs',
        'call_receive_number_failed_reqs',
        'input_date_time',
        'start_end',
        'remarks',
    ];
}
