<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $table = 'admins';

    protected $fillable = [
    	'name', 'type', 'mobile', 'email', 'password', 'image', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
