<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Tmp_Adpoints extends Model
{
    protected $table = 'tmp_adpoints';
    protected $primaryKey = 'rid';
    public $timestamps = false;
    protected $guarded = [];
}
