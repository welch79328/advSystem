<?php

namespace App\Http\Controllers\Admin\Qu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //圖片上傳
    public function upload(){
        $file = Input::file('Filedata');
        if($file->isValid()){
            $realPath = $file->getRealPath();//臨時文件的絕對路徑
            $entension = $file->getClientOriginalExtension();//獲得上傳文件的後綴
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file->move(base_path().'/public/uploads/qu',$newName);//移動文件並重命名
            $filepath = 'uploads/qu/'.$newName;
            return $filepath;
        }
    }

    public function onlineType($data)
    {
        foreach ($data as $v){
            switch ($v->isOnline){
                case 1:
                    $v->isOnline = '上線';
                    break;
                case 0:
                    $v->isOnline = '離線';
                    break;
            }
        }
        return $data;
    }
}
