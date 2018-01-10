<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Using_Tb extends Model
{
    protected $table = 'using_tb';
    protected $primaryKey = 'adevents';
    public $timestamps = false;
    protected $guarded = [];
}
