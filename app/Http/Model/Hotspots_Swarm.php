<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Hotspots_Swarm extends Model
{
    protected $table = 'hotspots_swarm';
    protected $primaryKey = 'swarmId';
    public $timestamps = false;
    protected $guarded = [];
}
