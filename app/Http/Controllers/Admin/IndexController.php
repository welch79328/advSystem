<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\Login;
use App\Http\Model\Myadmin;
use App\Http\Model\Point;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
    public function index($act)
    {
        if(empty(session('ma_user'))){
            redirect('admin/login');
        }elseif(session('ma_level')=='view') {
            redirect('admin/log/2');
        }

        if(session('ma_level')=='admin') {
            $rs = Myadmin::where([
                ['ma_user','!=',session('ma_user')],
                ['ma_level','!=','view'],
                ['ma_status','!=',2],
            ])->paginate(15);
//            $rs2 = $conn->prepare("SELECT * FROM myadmin WHERE ma_user != :ma_user AND ma_level !='view' AND ma_status != 2  ORDER BY ma_id DESC LIMIT :startRow_records , :pageRow_records");
        }else{
            $rs = Myadmin::where([
                ['ma_user','!=',session('ma_user')],
                ['ma_ul','=',session('ma_user')],
                ['ma_level','!=','admin'],
                ['ma_status','!=',2],
            ])->paginate(15);
        }

        $rs = $this->fun_ma($rs);

        $level = $this->fun_level(session('ma_level'));

        return view('admin.index',compact('act','rs','level'));
    }

    public function point($act)
    {
//        dd(session('ma_user'));
//
//        $rs2 = $conn->prepare("SELECT p.*, ad.a_name FROM (point AS p LEFT JOIN ad ON p.a_id = ad.a_id) WHERE p.ma_user = :ma_user ORDER BY p.p_id DESC LIMIT :startRow_records , :pageRow_records");
//        $rs2->bindValue(':ma_user', $_SESSION['ma_user'], PDO::PARAM_STR);
//        $rs2->bindValue(':startRow_records', $startRow_records, PDO::PARAM_INT);
//        $rs2->bindValue(':pageRow_records', $pageRow_records, PDO::PARAM_INT);
//        $rs2->execute();

        $point = Point::join('ad','point.a_id','=','ad.a_id')->where('point.ma_user',session('ma_user'))->get();

        dd($point);

        return view('admin.point');
    }

    public function log($act)
    {

        if(session('ma_level')=='admin') {
            $rs = Login::orderBy('l_id','desc')->paginate(15);
        }else {
            $rs = Login::where('ma_user',session('ma_user'))->orderBy('l_id','desc')->paginate(15);
        }

        $level = $this->fun_level(session('ma_level'));

        return view('admin.log',compact('act','rs','level'));
    }

    public function member_add($act)
    {
        $rs = Myadmin::where('ma_level','root')->orderBy('ma_id','asc')->get();

        $level = $this->fun_level(session('ma_level'));

        return view('admin.member_add',compact('act','rs','level'));
    }

    public function member_deal_with()
    {
        $input = Input::all();

        if($input['act']=='inst') {

            $ma_ul = (isset($input['ma_ul']))?$input['ma_ul']:session('ma_user');
            $ma_pass = Crypt::encrypt($input['ma_pass']);

            $ma_time = date('Y-m-d H:i:s');  //建立時間
            $ma_cm   = session('ma_user'); //創建人


            /* 檢查帳號是否已存在 */
            $rs = Myadmin::where('ma_user',$input['ma_user'])->get();
            $mac = count($rs);//取得資料總行數

            if($mac == 0) {

                $rs2 = Myadmin::create(['ma_name'=>$input['ma_name'], 'ma_user'=>$input['ma_user'], 'ma_pass'=>$ma_pass,
                    'ma_level'=>$input['ma_level'], 'ma_company'=>$input['ma_company'], 'ma_tel'=>$input['ma_tel'], 'ma_add'=>$input['ma_add'],
                    'ma_un'=>$input['ma_un'], 'ma_pm'=>$input['ma_pm'], 'ma_phone'=>$input['ma_phone'], 'ma_sex'=>$input['ma_sex'],
                    'ma_ul'=>$ma_ul, 'ma_time'=>$ma_time, 'ma_cm'=>$ma_cm, 'ma_status'=>$input['ma_status']]);


            }else {

                echo '<script language="javascript" charset="utf-8">';
                echo 'alert("帳號已存在,不能重覆新增加!!");';
                echo 'location.href="member_add.php?act=2";';
                echo '</script>';

            }

        }

        return redirect('admin/index/2');

    }

    public function member_up($ma_id,$act)
    {

        /* 取出資料 */
        $rs = Myadmin::where('ma_id',$ma_id)->first();

        $ml_rs = Myadmin::where('ma_level','root')->orderBy('ma_id','asc')->get();

        $level = $this->fun_level(session('ma_level'));

        return view('admin.member_up',compact('act','rs','ml_rs','level'));
    }

    public function member_up_deal_with()
    {
        $input = Input::except('_token');


        
        if($input['act']=='up') {

            $input['ma_pass']  = (!empty($input['ma_pass']))?Crypt::encrypt($input['ma_pass']):$input['ma_pass2'];
            $input['ma_user'] = $input['ma_user2'];

            unset($input['act']);
            unset($input['ma_user2']);
            unset($input['ma_pass2']);

            Myadmin::where('ma_id',$input['ma_id'])->update($input);
        }

        return redirect('admin/index/2');
    }

    public function member_del()
    {
        $input = Input::all();

        Myadmin::where('ma_id',$input['ma_id'])->update(['ma_status'=>2]);
    }
}
