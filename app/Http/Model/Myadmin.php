<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Myadmin extends Model
{
    protected $table = 'myadmin';
    protected $primaryKey = 'ma_id';
    public $timestamps = false;
    protected $guarded = [];
}
