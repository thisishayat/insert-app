<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class InsertApp extends Model
{
    use Notifiable;
    protected $table = 'insert_app';

    protected $fillable = [
        'call_number',
        'call_receive_number',
        'input_date_time',
        'start_end',
        'remarks',
        'status',
        'is_call',
        'updated_by',
    ];
}
