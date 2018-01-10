<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $table = 'view';
    protected $primaryKey = 's_id';
    public $timestamps = false;
    protected $guarded = [];
}
