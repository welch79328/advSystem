<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Tb_List extends Model
{
    protected $table = 'tb_list';
    protected $primaryKey = 'tl_id';
    public $timestamps = false;
    protected $guarded = [];
}
