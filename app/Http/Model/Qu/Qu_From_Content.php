<?php

namespace App\Http\Model\Qu;

use Illuminate\Database\Eloquent\Model;

class Qu_From_Content extends Model
{
    protected $table = 'qu_from_content';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}
