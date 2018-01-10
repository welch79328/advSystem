<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Hotspots extends Model
{
    protected $table = 'hotspots';
    protected $primaryKey = 'rid';
    public $timestamps = false;
    protected $guarded = [];
}
