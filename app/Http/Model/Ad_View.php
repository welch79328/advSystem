<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Ad_View extends Model
{
    protected $table = 'ad_view';
    protected $primaryKey = 'av_id';
    public $timestamps = false;
    protected $guarded = [];
}
