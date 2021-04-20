<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $guard = 'banners';

    protected $fillable = [
    	'image', 'link', 'title', 'alt', 'status'
    ];
}
