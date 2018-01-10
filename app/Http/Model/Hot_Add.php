<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Hot_Add extends Model
{
    protected $table = 'hot_add';
    protected $primaryKey = 'ha_id';
    public $timestamps = false;
    protected $guarded = [];
}
