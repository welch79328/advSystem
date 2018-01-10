<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = 'point';
    protected $primaryKey = 'p_id';
    public $timestamps = false;
    protected $guarded = [];
}
