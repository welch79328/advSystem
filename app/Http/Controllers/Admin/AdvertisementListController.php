<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\Ad;
use App\Http\Model\Ad_View;
use App\Http\Model\Hot_Add;
use App\Http\Model\Hotspots;
use App\Http\Model\Hotspots_Swarm;
use App\Http\Model\Hotspots_Swarmlist;
use App\Http\Model\Myadmin;
use App\Http\Model\Point;
use App\Http\Model\Style;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AdvertisementListController extends CommonController
{
    public function banner($act)
    {
        $session = session('ma_user');
        /* 輪播廣告 */
        $data = Ad::join('style','ad.s_id','=','style.s_id')->where('ad.a_status','!=',2)->where('ma_user',$session)->orderBy('ad.a_id','DESC')->paginate(15);

        $level = $this->fun_level(session('ma_level'));

        return view('admin.banner',compact('data','level','act'));
    }

    public function banner_add($act)
    {
        /* 取出已分配點數總額 */
        $session = session('ma_user');
        $allocation_total = DB::select("SELECT sum(a_pq) AS pq FROM ad WHERE ma_user = '$session'");

        foreach ($allocation_total as $v){
            foreach ($v as $q){
                $allocation_total = number_format($q);
            }
        }

        /* 取出目前總額 */
        $total = Point::where('ma_user',$session)->orderBy('p_id','desc')->first();

        $total_sum = empty($total->p_sum)?0:$total->p_sum;

        $total = number_format($total_sum);


        /* 取出廣告類型 */
        $style = Style::where('s_status',1)->orderBy('s_id', 'ASC')->get();

        /* 取出檢視帳號 */
        $myadmin = Myadmin::where('ma_ul',$session)->where('ma_status',1)->orderBy('ma_id', 'ASC')->get();

        $hotspots_swarm = Hotspots_Swarm::orderBy('swarmId', 'ASC')->get();


        $hotspots = Hotspots::orderBy('rid', 'ASC')->get();


        $level = $this->fun_level(session('ma_level'));

        return view('admin.banner_add',compact('act','level','allocation_total','total','style','myadmin','hotspots_swarm','hotspots'));
    }

    public function banner_up($a_id,$act)
    {
        $session = session('ma_user');
        /* 取出已分配點數總額 */
        $pq_row = DB::select("SELECT sum(a_pq) AS pq FROM ad WHERE ma_user = '$session'");
        foreach ($pq_row as $v){
            foreach ($v as $q){
                $pq_row['pq'] = $q;
            }
        }

        /* 取出目前總額 */
        $pt_row = Point::where('ma_user',$session)->orderBy('p_id','DESC')->first();

        $p_sum = (!empty($pt_row['p_sum']))?$pt_row['p_sum']:0;

        /* 取出目前廣告資料 */
        $ad_row = Ad::where('a_id',$a_id)->where('a_status','!=',3)->first();

        /* 廣告類型*/
        $s_row = Style::where('s_status',1)->orderBy('s_id','asc')->get();

        /*檢視帳號*/
        /* 取出目前的資料 */
        $av_row = Ad_View::where('a_id',$a_id)->get();
        $av = array();
        foreach ($av_row as $v){
            $av[] = $v->ma_user;
        }
        /* 取得要被核選的帳號 */
        $v_row = Myadmin::where('ma_ul',$session)->where('ma_status',1)->orderBy('ma_id','asc')->get();

        $ha_row = DB::select("SELECT ha.*, h.aliasName FROM (hot_add AS ha LEFT JOIN hotspots AS h ON ha.rid = h.rid) WHERE ha.a_id = $a_id");

        $hs_row = Hotspots_Swarm::orderBy('swarmId','asc')->get();

        $pl_row = Hotspots::orderBy('rid','asc')->get();


        $level = $this->fun_level(session('ma_level'));

        return view('admin.banner_up',compact('act','pq_row','p_sum','pt_row','ad_row','s_row','av','v_row','ha_row','hs_row','pl_row','level'));
    }

    public function banner_up_deal_with()
    {
        $input = Input::all();
//        dd($input);





//        if($input['act']=='up') {

//            $rc = count($input['rid2']); //統計單點數量

            if((empty($input['hah']))&&(empty($rc))) {

                echo '<script language="javascript" charset="utf-8">';
                echo 'alert("需先選擇播放地點!!");';
                echo 'location.href="banner_up/'.$input['a_id'].'/4";';
                echo '</script>';
                exit();
            }

            $pq_max = $input['a_pq2'] + $input['pq_max']; //實際可用點數

            if($input['a_pq'] > $pq_max) {

                echo '<script language="javascript" charset="utf-8">';
                echo 'alert("點數配額不可大於可用點數!!");';
                echo 'location.href="banner_up/'.$input['a_id'].'/4";';
                echo '</script>';
                exit();
            }


            /* 寫入資料庫 */
            $a_id     = strip_tags($input['a_id']);
            $s_id       = strip_tags($input['s_id']);
            $a_name     = strip_tags($input['a_name']);
            $a_type     = strip_tags($input['a_type']);
            $a_img      = ($input['a_type']==1)?$input['a_img']:'';
            $a_video    = ($input['a_type']==2)?$input['a_video']:'';
            $a_ad       = $input['a_ad'];
            $a_default  = strip_tags($input['a_default']);
            $a_android  = strip_tags($input['a_android']);
            $a_ios      = strip_tags($input['a_ios']);
            $a_s_period = strip_tags($input['a_s_period']);
            $a_e_period = strip_tags($input['a_e_period']);
            $a_mode     = strip_tags($input['a_mode']);
            $a_pq       = strip_tags($input['a_pq']);
            $a_status   = strip_tags($input['a_status']);


            /* 寫入資料庫 */
            try {

                $rs = Ad::where('a_id',$a_id)->update([
                    's_id' => $s_id,
                    'a_name' => $a_name,
                    'a_type' => $a_type,
                    'a_img' => $a_img,
                    'a_video' => $a_video,
                    'a_ad' => $a_ad,
                    'a_default' => $a_default,
                    'a_android' => $a_android,
                    'a_ios' => $a_ios,
                    'a_s_period' => $a_s_period,
                    'a_e_period' => $a_e_period,
                    'a_mode' => $a_mode,
                    'a_pq' => $a_pq,
                    'a_status' => $a_status,
                ]);


                if ($rs > 0) {


                    /* 先取出帳號總額 */
                    $row = Point::where('ma_user',session('ma_user'))->orderBy('p_id','DESC')->first();

                    $p_sum = $row['p_sum'] + $input['a_pq2']; //先加回原本分配出去的點數
                    $p_sum = $p_sum - $input['a_pq']; //算出帳戶餘額

                    Point::create([
                        'p_name' => 3,
                        'p_quantity' => $a_pq,
                        'a_id' => $a_id,
                        'p_over' => $a_pq,
                        'p_sum' => $p_sum,
                        'ma_user' => session('ma_user'),
                    ]);


                    /* 更新會員點數總額 */
                    Myadmin::where('ma_user',session('ma_user'))->update(['ma_point'=>$p_sum]);

                }

                /* 插入廣告檢視資料表 */
                if(session('ma_level') == 'root') {

                    /* 先取出所有筆數 */
                    $avc = Ad_View::where('a_id',$a_id)->get();//取得資料總行數

                    $pavc = empty($input['av'])?null:$input['av'];

                    if(count($avc) != count($pavc)) {

                        /* 先刪除資料 */
                        Ad_View::where('a_id',$a_id)->delete();

                        foreach($input['av'] as $key) {

                            Ad_View::create([
                                'a_id' => $a_id,
                                'ma_user' => $key,
                            ]);

                        }

                    }

                }

                /* 先刪除資料 */
                Hot_Add::where('a_id',$a_id)->delete();

                /* 插入廣告播放地點 */
                $hah = str_replace ('undefined','',$input['hah']);
                $hah = explode(',',$hah);

                /* 合併陣列 */
//                foreach($input['rid2'] as $val) {
//
//                    array_push($hah, $val);
//
//                }

                $hah = array_unique($hah); //刪除重覆元素

                foreach($hah as $val) {

                    if($val != '') {

                        Hot_Add::create([
                            'a_id' => $a_id,
                            'rid' => $val,
                        ]);

                    }

                }
                /* 若沒問題結束交易 */
                $myday = date('Y-m-d');
                cache()->forget($myday);


            } catch(\Exception $e) {

                /* 若有問題回復未執行前的SQL */
                //$conn->rollBack();
                echo 'error';

            }

//        }

        return redirect('admin/banner/4');

    }

    public function banner_del()
    {
        $input = Input::all();


        if(!empty($input['a_id'])) {


            /* 先查出是否還有餘額 */
            try {

                $row = Ad::where('a_id',$input['a_id'])->first();


                /* 如果沒有餘額才能刪除 */
                if($row['a_pq']==0) {

                    Ad::where('a_id',$input['a_id'])->update([
                        'a_status' => 2,
                    ]);

                }

                /* 若沒問題結束交易 */

            } catch(\Exception $e) {

                /* 若有問題回復未執行前的SQL */
                //$conn->rollBack();
                echo 'error';

            }
        }
    }

    public function banner_return()
    {
        $input = Input::all();
        
        if(isset($input['a_id'])) {

            /* 先取出剩餘點數 */
            try {

                $row = Ad::where('a_id',$input['a_id'])->where('ma_user',session('ma_user'))->get();

                /* 進行點數歸戶 */
                $rs2 = Ad::where('a_id',$input['a_id'])->where('ma_user',session('ma_user'))->update([
                    'a_pq' => 0,
                ]);


                if ($rs2 > 0) {

                    /* 取出目前的點數總額 */
                    $row3 = Point::where('ma_user',session('ma_user'))->orderBy('p_id','DESC')->first();

                    $p_sum = $row['a_pq'] + $row3['p_sum']; //最新的點數總額

                    /* 進行資料寫入 */
                    Point::create([
                        'p_name' => 4,
                        'a_id' => $input['a_id'],
                        'p_quantity' => $row['a_pq'],
                        'p_over' => 0,
                        'p_sum' => $p_sum,
                        'ma_user' => session('ma_user'),
                    ]);


                    /* 更新會員點數總額 */
                    Myadmin::where('ma_user',session('ma_user'))->update([
                        'ma_point' => $p_sum,
                    ]);

                }

                /* 若沒問題結束交易 */


            } catch(\Exception $e) {

                /* 若有問題回復未執行前的SQL */
                //$conn->rollBack();
                echo 'error';

            }

        }
    }


    public function banner_deal_with()
    {
        $input = Input::all();


        if($input['act']=='inst') {


            $s_id       = strip_tags($input['s_id']);
            $a_name     = strip_tags($input['a_name']);
            $a_type     = strip_tags($input['a_type']);
            $a_img      = ($input['a_type']==1)?$input['a_img']:'';
            $a_video    = ($input['a_type']==2)?$input['a_video']:'';
            $a_ad       = $input['a_ad'];
            $a_default  = strip_tags($input['a_default']);
            $a_android  = strip_tags($input['a_android']);
            $a_ios      = strip_tags($input['a_ios']);
            $a_s_period = strip_tags($input['a_s_period']);
            $a_e_period = strip_tags($input['a_e_period']);
            $a_mode     = strip_tags($input['a_mode']);
            $a_pq       = strip_tags($input['a_pq']);
            $a_status   = strip_tags($input['a_status']);
            $ma_v_user  = empty($input['ma_v_user'])?'':strip_tags($input['ma_v_user']);

            /* 寫入資料庫 */
            try {

                DB::beginTransaction();
                $rs = Ad::insertGetId([
                    's_id' => $s_id,
                    'a_name' => $a_name,
                    'a_type' => $a_type,
                    'a_img' => $a_img,
                    'a_video' => $a_video,
                    'a_ad' => $a_ad,
                    'a_default' => $a_default,
                    'a_android' => $a_android,
                    'a_ios' => $a_ios,
                    'a_s_period' => $a_s_period,
                    'a_e_period' => $a_e_period,
                    'a_mode' => $a_mode,
                    'a_pq' => $a_pq,
                    'a_status' => $a_status,
                    'ma_user' => session('ma_user'),
                ]);



                if ($rs > 0) {

                    $a_id = $rs; //取得廣告id

                    /* 先取出帳號總額 */
                    $row = Point::where('ma_user',session('ma_user'))->orderBy('p_id','DESC')->first();

                    $p_sum = $row['p_sum'] - $a_pq; //算出帳戶餘額

                    Point::create([
                        'p_name' => 2,
                        'p_quantity' => $a_pq,
                        'a_id' => $a_id,
                        'p_over' => $a_pq,
                        'p_sum' => $p_sum,
                        'ma_user' => session('ma_user'),
                    ]);



                    /* 更新會員點數總額 */
                    Myadmin::where('ma_user',session('ma_user'))->update([
                        'ma_point' => $p_sum,
                    ]);

                }

                /* 插入廣告檢視資料表 */
                if(session('ma_level') == 'root') {
                    if(!empty($input['av'])){
                        foreach($input['av'] as $key) {

                            Ad_View::create([
                                'a_id' => $a_id,
                                'ma_user' => $key,
                            ]);

                        }
                    }


                }

                /* 插入廣告播放地點 */
                $hah = str_replace ('undefined','',$input['hah']);
                $hah = explode(',',$hah);

                /* 合併陣列 */
                if (!empty($input['rid2'])){
                    foreach($input['rid2'] as $val) {

                        array_push($hah, $val);

                    }
                }


                $hah = array_unique($hah); //刪除重覆元素


                foreach($hah as $val) {

                    if($val != '') {

                        Hot_Add::create([
                            'a_id' => $a_id,
                            'rid' => $val,
                        ]);

                    }

                }


                /* 若沒問題結束交易 */
                DB::commit();

            } catch(\Exception $e) {

                /* 若有問題回復未執行前的SQL */
                DB::rollBack();
                echo 'error';

            }

        }

        return redirect('admin/banner/4');
        exit();
    }

}
