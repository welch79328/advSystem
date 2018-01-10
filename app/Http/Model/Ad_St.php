<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Ad_St extends Model
{
    protected $table = 'ad_st';
    protected $primaryKey = 'as_id';
    public $timestamps = false;
    protected $guarded = [];
}
