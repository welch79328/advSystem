<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    protected $table = 'style';
    protected $primaryKey = 's_id';
    public $timestamps = false;
    protected $guarded = [];
}
