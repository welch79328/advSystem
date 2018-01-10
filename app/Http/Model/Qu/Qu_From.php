<?php

namespace App\Http\Model\Qu;

use Illuminate\Database\Eloquent\Model;

class Qu_From extends Model
{
    protected $table = 'qu_from';
    protected $primaryKey = 'fr_id';
    public $timestamps = false;
    protected $guarded = [];
}
