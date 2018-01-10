<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Ad_Rp extends Model
{
    protected $table = 'ad_rp';
    protected $primaryKey = 'ar_id';
    public $timestamps = false;
    protected $guarded = [];
}
