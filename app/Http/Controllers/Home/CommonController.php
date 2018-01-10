<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Style;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function s_type($s_id)
    {
        $style = Style::where('s_id',$s_id)->first();

        return $style['s_type'];
    }
}
