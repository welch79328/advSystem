<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\Login;
use App\Http\Model\Myadmin;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

    class LoginController extends CommonController
{
    public function login()
    {
        $user = session('ma_user');


        if(isset($user)) {
            redirect('admin/index');
        }
        return view('admin.login');
    }

    public function logout()
    {
        session(['ma_user'=>null]);
        session(['ma_name'=>null]);
        session(['ma_level'=>null]);

        return redirect('admin/login');
    }

    public function login_deal_with()
    {
        $input = Input::all();
        /* 如果管理員已登入，則轉址導向功能頁面 */
        $user = session('ma_user');

        if(isset($user)) {
            redirect('admin/index');
        }

        /* 管理員登入作業開始 */

        $msg = 0;

        if($input['act']=='login') {

            $ma_user = strip_tags($input['ma_user']);
            $ma_pass = Crypt::encrypt($input['ma_pass']);

            $account = Myadmin::where([
                ['ma_user',$ma_user],
                ['ma_status','1'],
            ])->first();

            if(count($account) > 0 && $input['ma_pass'] == Crypt::decrypt($account['ma_pass'])) {


                /* 如果有勾選記住我則進行COOKIE寫入 */
                if(!empty($input['remember'])) {

                    Cookie::make("ma_user", $ma_user, time()+2592000);
                    Cookie::make("ma_pass", $ma_pass, time()+2592000);

                }

                /* 一切都沒問題的話，則註冊會員變數 */
                session(['ma_user'=>$account['ma_user']]);
                session(['ma_name'=>$account['ma_name']]);
                session(['ma_level'=>$account['ma_level']]);

                /* 取得登入的IP */
                $l_ip = $this->ipv($_SERVER['REMOTE_ADDR']);

                Login::create(['ma_user'=>$account['ma_user'],'l_ip'=>$l_ip]);

                $msg = 'ok';

            }

        }

        echo $msg;
        /* 管理員登入作業結束 */
    }

    public function test()
    {
        $str = '1234';
        $aa = Crypt::encrypt($str);

        dd($aa);
    }
}
