<?php

namespace App\Http\Model\Qu;

use Illuminate\Database\Eloquent\Model;

class Qu_Gift_Content extends Model
{
    protected $table = 'qu_gift_content';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}
