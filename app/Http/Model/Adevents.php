<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Adevents extends Model
{
    protected $table = 'adevents';
    protected $primaryKey = 'adEvents';
    public $timestamps = false;
    protected $guarded = [];
}
