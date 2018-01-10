<?php

namespace App\Http\Controllers\Admin\Qu;

use App\Http\Model\Qu\Qu_Layout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class LayoutController extends Controller
{
    public function demo()
    {
        $rid = 14;
        return view('admin.qu.layout.demo',compact('rid'));
    }

    public function imitation($rid)
    {
        $location = Config::get('qu.default.qu_location_view');

        return view('admin.qu.layout.imitation',compact('rid','location'));
    }

    public function create()
    {
        $layout = Qu_Layout::first();

        return view('admin.qu.layout.add',compact('layout'));
    }

    public function store()
    {
        $input = Input::except('_token');

        if(!empty($input['background_type'])){
            if($input['background_type'] == 'custom'){
                if(!empty($input['main'])){
                    $input['background'] = $input['main'];
                }
                unset($input['main']);
                unset($input['file_upload']);
            }
        }

        $layout = Qu_Layout::first();
        if(count($layout) == 0){
            $re = Qu_Layout::create($input);
        }else if(count($layout) > 0){
            $re = Qu_Layout::where('id',$layout['id'])->update($input);
        }

        if($re){
            return redirect('qu/admin/layout/demo');
        }else {
            return back()->with('errors', '數據填充錯誤, 請稍後重試');
        }
    }
}
