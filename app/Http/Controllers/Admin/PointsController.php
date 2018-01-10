<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Myadmin;
use App\Http\Model\Point;
use Illuminate\Support\Facades\Input;

class PointsController extends CommonController
{
    public function point_gift($act)
    {

        $rs = Point::select('point.*','myadmin.ma_name','myadmin.ma_point')->join('myadmin','point.ma_user','=','myadmin.ma_user')->where('ma_level','root')->groupBy('point.ma_user')->paginate(15);

        $rs = $this->fun_ap($rs);

        $level = $this->fun_level(session('ma_level'));

        return view('admin.point_gift',compact('act','rs','level'));
    }

    public function point_add($act)
    {

        $rs = Myadmin::where([
            ['ma_level','root'],
            ['ma_status',1],
        ])->get();


        $level = $this->fun_level(session('ma_level'));

        return view('admin.point_add',compact('act','rs','level'));
    }


    public function point_deal_with()
    {
        $input = Input::all();

        if($input['act']=='inst') {

            $ma_user    = strip_tags($input['ma_user']);
            $p_quantity = strip_tags($input['p_quantity']);

            /* 先取出會員總額 */
            try {
                $rs1 = Point::where('ma_user', $ma_user)->orderBy('p_id','desc')->first();
                $p_sum = $rs1['p_sum'] + $p_quantity; //儲值後的總額

                /* 更新點數列表 */
                $rs = Point::create(['p_name'=>1, 'p_quantity'=>$p_quantity, 'p_sum'=>$p_sum, 'ma_user'=>$ma_user, 'ma_a_user'=>session('ma_user')]);

                if($rs1 == null){
                    $rs1 = Point::where('ma_user', $ma_user)->orderBy('p_id','desc')->first();
                    $p_sum = $rs1['p_sum'] + $p_quantity; //儲值後的總額
                }

                /* 更新會員點數總額 */
                $rs = Myadmin::where('ma_user',$ma_user)->update(['ma_point'=>$p_sum]);

                /* 若沒問題結束交易 */

            } catch(\Exception $e) {

                /* 若有問題回復未執行前的SQL */
                //$conn->rollBack();
//                echo 'error';
                var_dump($e);

            }


        }


        return redirect('admin/point_gift/3');
    }

    public function point_edit()
    {
        $input = Input::all();

        $act = $input['act'];

        $myadmin = Myadmin::where('ma_user',$input['ma_user'])->first();

        $level = $this->fun_level(session('ma_level'));

        return view('admin.point_edit',compact('myadmin','level','act'));
    }

    public function point_up_deal_with()
    {
        $input = Input::all();

        if($input['act']=='up') {
            $rs = Myadmin::where('ma_user',$input['ma_user'])->update(['ma_point'=>$input['ma_point']]);
        }

        return redirect('admin/point_gift/3');
    }

    public function point2($act)
    {

        $rs = Point::where('p_name',1)->orwhere('p_name',6)->orderBy('p_id','desc')->paginate(15);

        $rs = $this->fun_point($rs);

        $level = $this->fun_level(session('ma_level'));

        return view('admin.point2',compact('act','rs','level'));
    }


}
