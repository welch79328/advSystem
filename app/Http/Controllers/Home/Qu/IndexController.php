<?php

namespace App\Http\Controllers\Home\Qu;



use App\Http\Model\Qu\Qu;
use App\Http\Model\Qu\Qu_Content;
use App\Http\Model\Qu\Qu_From;
use App\Http\Model\Qu\Qu_From_Content;
use App\Http\Model\Qu\Qu_Gift;
use App\Http\Model\Qu\Qu_Gift_Content;
use App\Http\Model\Qu\Qu_Layout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use function Sodium\compare;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $input = Input::all();
        $input = $request->all();
//        dd($input);
        $data= [];
        $day = date("Y-m-d");
        $qu = Qu::where('qu_s_period','<=',$day)->where('qu_e_period','>=',$day)->orderBy(DB::raw('RAND()'))->first();
        $qu_content = Qu_Content::where('qu_id',$qu->qu_id)->get();
        foreach ($qu_content as $k=>$v){
            $data[$qu_content[$k]['name']] = $qu_content[$k]['content'];
        }
        $layout = Qu_Layout::first();

        dd($data);


        return view('home.qu.index',compact('qu','data','input','layout'));
    }

    public function index_submit(Request $request)
    {
        $input = $request->all();
//        $input =  $request->only(['rid','mac','linkloginonly','chapchallenge','router_version','ip','link_login']);
        $time =  date("Y/m/d H:i:s");
        $rules=[
//                'qu_email'=>'email',
        ];
        $message=[
//            'qu_email.email'=>'必須為email',
        ];
        $array = '[]';

        $index_type = $request->except(['_token','rid','mac','linkloginonly','chapchallenge','router_version','ip','link_login','qu_email','gi_id']);

        foreach ($index_type as $k=>$v){
            $option = explode("_",$k);
            if (!empty($option[2])){
                unset($index_type[$k]);
                $index_type[$option[0].'_'.$option[1]] = $v;
//                if(count($v) == 1){
//                    $rules[$k.$array] = 'required';
//                    $message[$k.$array] = '不能為空!';
//                }
            }
        }


        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            try{
                $re = Qu_From::create([
                    'qu_email'=>$input['qu_email'],
                    'qu_time'=>$time,
                ]);
                foreach ($index_type as $k=>$v){
//                dd($index_type,$k,$v);
                    if(is_array($v)){
                        foreach ($v as $q){
                            if($q != Null){
                                $re1 = Qu_From_Content::create([
                                    'name'=>$k,
                                    'content'=>$q,
                                    'fr_id'=>$re['fr_id'],
                                ]);
                            }
                        }
                    }else{
                        $re1 = Qu_From_Content::create([
                            'name'=>$k,
                            'content'=>$q,
                            'fr_id'=>$re['fr_id'],
                        ]);
                    }
                }

                DB::commit();

            } catch(\Exception $e) {
                DB::rollBack();
                echo 'error';
            }

//            if($re && $re1){
            if($re){

                try{
                    $gift = Qu_Gift::where('gi_id',$input['gi_id'])->first();
                    $gift_content = Qu_Gift_Content::where('gi_id',$input['gi_id'])->where('amount','>',0)->first();
                    $number = $gift_content['amount'] - 1;
                    Qu_Gift_Content::where('id',$gift_content['id'])->update(['amount'=>$number]);

                    Mail::send(
                        'emails.test',
                        ['gift' => $gift, 'gift_content' => $gift_content],
                        function ($message) use($re) {
                            $message->subject('Laravel');
                            $message->to($re['qu_email']);
                        }
                    );
                }catch(\Exception $e) {

                }

                $input['advSystem'] = 'ADING';
                $input['ad_sort'] = 'ading';
                $input['orig_url'] = 'http://www.looder.com.tw/mobile/product.php?pid_for_show=4938&product_standard_sn=3252';

                $location = Config::get('qu.default.qu_location_inurl');
                return view('home.qu.submit',compact('input','location'));
            }else {
                return back()->withInput()->with('errors','數據填充錯誤, 請稍後重試');
            }
        }else{
            return back()->withInput()->withErrors($validator);
        }



        $input['advSystem'] = 'ADING';
        $input['ad_sort'] = 'ading';
        $input['orig_url'] = 'http://www.looder.com.tw/mobile/product.php?pid_for_show=4938&product_standard_sn=3252';

        $location = Config::get('default.qu_location_inurl');

        return view('home.qu.submit',compact('input','location'));
    }

    public function mail()
    {
        Mail::send(
            'emails.test',
            [],
            function ($message) {
                $message->subject('Laravel');
                $message->to('welch79328@gmail.com');
            }
        );
    }
}
