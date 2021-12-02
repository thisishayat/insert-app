<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'sur_name',
        'date_of_birth',
        'place_of_birth',
        'identity_card_no',
        'type_of_identity',
        'comp_name',
        'vat_id',
        'address',
        'city',
        'region',
        'post_code',
        'country_id',
        'otp',
        'otp_code',
        'otp_expire',
        'role',
        'acnt_sts',
        'is_active',
        'email',
        'password',
        'pin',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','pin'
    ];
}
