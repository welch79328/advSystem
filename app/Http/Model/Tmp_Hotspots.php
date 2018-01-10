<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Tmp_Hotspots extends Model
{
    protected $table = 'tmp_hotspots';
    protected $primaryKey = 'rid';
    public $timestamps = false;
    protected $guarded = [];
}
