<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Ad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class CommonController extends Controller
{
    //圖片上傳
//    public function upload(){
//        $file = Input::file('Filedata');
//        if($file->isValid()){
//            $realPath = $file->getRealPath();//臨時文件的絕對路徑
//            $entension = $file->getClientOriginalExtension();//獲得上傳文件的後綴
//            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
//            $path = $file->move(base_path().'/public/uploads',$newName);//移動文件並重命名
//            $filepath = 'uploads/'.$newName;
//            return $filepath;
//        }
//    }

    public function upload(){
        $file = Input::file('Filedata');
        if($file->isValid()){
            $realPath = $file->getRealPath();//臨時文件的絕對路徑
            $entension = $file->getClientOriginalExtension();//獲得上傳文件的後綴
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file->move(base_path().'/public/image',$newName);//移動文件並重命名
            $filepath = $newName;
            return $filepath;
        }
    }

    public function upload_css(){
        $file = Input::file('Filedata');

        if($file->isValid()){
            $realPath = $file->getRealPath();//臨時文件的絕對路徑
            $entension = $file->getClientOriginalExtension();//獲得上傳文件的後綴
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file->move(base_path().'/public/css/ad',$newName);//移動文件並重命名
            $filepath = 'css/ad/'.$newName;
            return $filepath;
        }

    }

    public function ipv($ip)
    {
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


        return $ip;
    }

    public function fun_level($val) {

        $msg='';
        switch($val) {

            case 'admin':
                $msg = ' (系統管理員)';
                break;
            case 'root':
                $msg = ' (客戶)';
                break;
            case 'view':
                $msg = ' (僅供檢視)';
                break;
        }

        return $msg;
    }

    public function fun_ma($rs)
    {
        foreach ($rs as $v){
            switch($v->ma_level) {

                case 'admin':
                    $v->ma_level = '系統帳號 (System)';
                    break;
                case 'root':
                    $v->ma_level = '客戶帳號 (Customer)';
                    break;
                case 'view':
                    $v->ma_level = '檢視帳號 (Inspection)';
                    break;
            }
        }

        return $rs;
    }

    public function fun_ap($rs)
    {
        foreach ($rs as $v){
            $ad = Ad::where('ma_user',$v->ma_user)->first();
            $v['a_pq'] = $ad['a_pq'];
        }

        return $rs;
    }

    public function fun_point($rs)
    {
        foreach ($rs as $v){
            switch($v->p_name) {

                case 1:
                    $v->p_name = '儲值';
                    break;
                case 2:
                    $v->p_name = '點數分配';
                    break;
                case 3:
                    $v->p_name = '編輯點數分配';
                    break;
                case 4:
                    $v->p_name = '點數歸戶';
                    break;
                case 5:
                    $v->p_name = '廣告扣點 - 觀看廣告';
                    break;
                case 6:
                    $v->p_name = '儲值變更';
                    break;
                case 7:
                    $v->p_name = '廣告扣點 - 開始播放(Youtube影片)';
                    break;
                case 8:
                    $v->p_name = '廣告扣點 - 點擊圖片';
                    break;
                case 9:
                    $v->p_name = '廣告扣點 - 播放結束(Youtube影片)';
                    break;
                case 10:
                    $v->p_name = '廣告扣點 - 導連網頁';
                    break;
            }
        }

        return $rs;
    }
}
