<?php

namespace App\Http\Model\Qu;

use Illuminate\Database\Eloquent\Model;

class Qu_Content extends Model
{
    protected $table = 'qu_content';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}
