<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Connect extends Model
{
    protected $table = 'connect';
    protected $primaryKey = 'c_id';
    public $timestamps = false;
    protected $guarded = [];
}
