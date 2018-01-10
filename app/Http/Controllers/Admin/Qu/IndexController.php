<?php

namespace App\Http\Controllers\Admin\Qu;


use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    public function index() {
        return view('admin.qu.index');
    }

    public function info() {
        dd(phpinfo());
        return view('admin.qu.info');
    }

    //更改管理員密碼
    public function pass() {

        if($input = Input::all()){
            $rules=[
                'password'=>'required|between:6,20|confirmed',
            ];

            $message=[
                'password.required'=>'新密碼不能為空!',
                'password.between'=>'新密碼必須為6-20為之間!',
                'password.confirmed'=>'新密碼和確認密碼必須一致!',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $user = User::first();
                $_password = Crypt::decrypt($user->user_pass);
                if($input['password_o'] == $_password){
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors','密碼修改成功!');
                }else{
                    return back()->with('errors','原密碼錯誤!');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.pass');
        }
    }
}
