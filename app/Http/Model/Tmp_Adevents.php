<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Tmp_Adevents extends Model
{
    protected $table = 'tmp_adevents';
    protected $primaryKey = 'adEvents';
    public $timestamps = false;
    protected $guarded = [];
}
