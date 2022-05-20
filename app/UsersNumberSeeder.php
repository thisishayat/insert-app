<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersNumberSeeder extends Model
{
    //
    //protected $table = "users_number_seeders";
    protected $table = 'users_number_seeders';

    protected $fillable = [
        'email',
        'call_receive_number',
        'start_end',
        'service_id'
    ];

}
