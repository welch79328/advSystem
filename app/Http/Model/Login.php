<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = 'login';
    protected $primaryKey = 'l_id';
    public $timestamps = false;
    protected $guarded = [];
}
