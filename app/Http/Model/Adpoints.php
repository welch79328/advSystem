<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Adpoints extends Model
{
    protected $table = 'adpoints';
    protected $primaryKey = 'rid';
    public $timestamps = false;
    protected $guarded = [];
}
