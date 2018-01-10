<?php

namespace App\Http\Model\Qu;

use Illuminate\Database\Eloquent\Model;

class Qu extends Model
{
    protected $table = 'qu';
    protected $primaryKey = 'qu_id';
    public $timestamps = false;
    protected $guarded = [];
}
