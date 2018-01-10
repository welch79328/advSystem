<?php

namespace App\Http\Model\Qu;

use Illuminate\Database\Eloquent\Model;

class Qu_Gift extends Model
{
    protected $table = 'qu_gift';
    protected $primaryKey = 'gi_id';
    public $timestamps = false;
    protected $guarded = [];
}
