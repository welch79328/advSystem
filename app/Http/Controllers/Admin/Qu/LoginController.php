<?php

namespace App\Http\Controllers\Admin\Qu;

use App\Http\Model\Account;
use App\Http\Model\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class LoginController extends CommonController
{
    public function login() {
        if($input = Input::all()){

            $user = Account::where('account',$input['account'])->first();
            if($user->account != $input['account'] || Crypt::decrypt($user->password) != $input['password']){
                return back()->with('msg','帳號或是密碼錯誤');
            }
            $level = $user->level;
            $user_name = $user->account;
            session(['level'=>$level]);
            session(['user_name'=>$user_name]);
            $input = Input::except('_token','password');
            $ip = $_SERVER['REMOTE_ADDR'];

            //ipv6 轉 ipv4
            if (($ip == '0000:0000:0000:0000:0000:0000:0000:0001') OR ($ip == '::1')) {
                $ip = '127.0.0.1';
            }
            $ip = strtolower($ip);
            // remove unsupported parts
            if (($pos = strrpos($ip, '%')) !== false) {
                $ip = substr($ip, 0, $pos);
            }
            if (($pos = strrpos($ip, '/')) !== false) {
                $ip = substr($ip, 0, $pos);
            }
            $ip = preg_replace("/[^0-9a-f:\.]+/si", '', $ip);
            // check address type
            $is_ipv6 = (strpos($ip, ':') !== false);
            $is_ipv4 = (strpos($ip, '.') !== false);
            if ((!$is_ipv4) AND (!$is_ipv6)) {
                return false;
            }
            if ($is_ipv6 AND $is_ipv4) {
                // strip IPv4 compatibility notation from IPv6 address
                $ip = substr($ip, strrpos($ip, ':') + 1);
                $is_ipv6 = false;
            }
            if ($is_ipv4) {
                // convert IPv4 to IPv6
                $ip_parts = array_pad(explode('.', $ip), 4, 0);
                if (count($ip_parts) > 4) {
                    return false;
                }
                for ($i = 0; $i < 4; ++$i) {
                    if ($ip_parts[$i] > 255) {
                        return false;
                    }
                }
                $part7 = base_convert(($ip_parts[0] * 256) + $ip_parts[1], 10, 16);
                $part8 = base_convert(($ip_parts[2] * 256) + $ip_parts[3], 10, 16);
                $ip = '::ffff:'.$part7.':'.$part8;
            }
            // expand IPv6 notation
            if (strpos($ip, '::') !== false) {
                $ip = str_replace('::', str_repeat(':0000', (8 - substr_count($ip, ':'))).':', $ip);
            }
            if (strpos($ip, ':') === 0) {
                $ip = '0000'.$ip;
            }
            // normalize parts to 4 bytes
            $ip_parts = explode(':', $ip);
            foreach ($ip_parts as $key => $num) {
                $ip_parts[$key] = sprintf('%04s', $num);
            }
            $ip = implode(':', $ip_parts);
            $aa = base_convert(substr($ip_parts['6'],2),16,10);
            $bb = base_convert(substr($ip_parts['6'],0,2),16,10);
            $cc = base_convert(substr($ip_parts['7'],2),16,10);
            $dd = base_convert(substr($ip_parts['7'],0,2),16,10);
            $ip = $bb.'.'.$aa.'.'.$dd.'.'.$cc;

            $input['action'] = $ip;
            $input['time'] = date("Y-m-d H:i:s");

            Log::create($input);

            //dd(session('user'));
            return redirect('admin');
        }else{
            //dd($_SERVER);

            return view('admin.login');
        }
    }

    public function quit() {
        session(['user'=>null]);
        return redirect('admin/login');
    }

    public function test()
    {
        $str = '1234';
        $aa = Crypt::encrypt($str);

        dd($aa);
    }


}
