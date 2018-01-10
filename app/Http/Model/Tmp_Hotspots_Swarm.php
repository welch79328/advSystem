<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Tmp_Hotspots_Swarm extends Model
{
    protected $table = 'tmp_hotspots_swarm';
    protected $primaryKey = 'swarmId';
    public $timestamps = false;
    protected $guarded = [];
}
