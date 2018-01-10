<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table = 'ad';
    protected $primaryKey = 'a_rid';
    public $timestamps = false;
    protected $guarded = [];
}
