<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Tmp_Hotspots_Swarmlist extends Model
{
    protected $table = 'tmp_hotspots_swarmlist';
    protected $primaryKey = 'swarmId';
    public $timestamps = false;
    protected $guarded = [];
}
