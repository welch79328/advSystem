<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Hotspots_Swarmlist extends Model
{
    protected $table = 'hotspots_swarmlist';
    protected $primaryKey = 'swarmId';
    public $timestamps = false;
    protected $guarded = [];
}
