<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Ad;
use App\Http\Model\Ad_Rp;
use App\Http\Model\Ad_St;
use App\Http\Model\Adevents;
use App\Http\Model\Adpoints;
use App\Http\Model\Connect;
use App\Http\Model\Hot_Add;
use App\Http\Model\Hotspots;
use App\Http\Model\Myadmin;
use App\Http\Model\Point;
use App\Http\Model\Style;
use App\Http\Model\Using_Tb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
    public function index()
    {

        $input = Input::all();
        ini_set('max_execution_time', 0);


        $ad_rid       = empty($input['ad_rid'])?'':$input['ad_rid'];
        $ad_hsname    = empty($input['ad_hsname'])?0:$input['ad_hsname'];    //熱點名稱
        $ad_mac       = empty($input['ad_mac'])?'':$input['ad_mac'];       //裝置MAC
        $ad_type      = empty($input['ad_type'])?'':$input['ad_type'];      //廣告類型
        $ad_key       = empty($input['ad_key'])?'':$input['ad_key'];       //認證金鑰
        $ad_domain    = empty($input['ad_domain'])?'':$input['ad_domain'];    //來源網域
        $ad_nums      = empty($input['ad_nums'])?'':$input['ad_nums'];      //廣告數量
        $ad_defaultId = empty($input['ad_defaultId'])?'':$input['ad_defaultId']; //預設的廣告 ID,若查詢後都沒廣告內容，根 據該 ID 設定廣告內容。
        $ad_specifyId = empty($input['ad_specifyId'])?'':$input['ad_specifyId']; //指定廣告 ID,若此項參數非空值，則根據 該參數設定廣告。
        $ad_site      = empty($input['ad_site'])?'':$input['ad_site'];      //熱點別名，此參數暫定為之 後接上 google analyics 使用
//$phonedrive = $input['$phonedrive'];	   //使用者裝置("A"=android/"I"=iphone/"D"=default)
        $sex          = empty($input['sex'])?'':$input['sex'];
//die($sex);

        $ua = $_SERVER["HTTP_USER_AGENT"];

// Android
        $android = strpos($ua, 'Android')?true:false;
// iPhone
        $iphone = strpos($ua, 'iPhone')?true:false;
// ---- Test if using a Handheld Device ----
        if ($android) { // Android
            $phonedrive="A";
        }
        elseif ($iphone) { // iPhone
            $phonedrive="I";
        }
        else
        {
            $phonedrive="D";

        }


        /* 先比對是否為合法參數 */
        if($ad_key == 'aadc342ccbe697b5998ce30a0533c005') {

            /* 今天的日期 */
            $myday = date('Y-m-d');



            /* 先取出熱點資料 */
            try {
//                cache()->forget($myday.'-'.$ad_rid);

                if(!(cache()->has($myday.'-'.$ad_rid))) {
                    $data = [];
                    $hotspots = Hotspots::where('rid', $ad_rid)->first();
                    $rid = $hotspots['rid'];
                    array_push ($data,$rid);

                    /* 取出費率表 */
//                Adpoints::where('rid',$hotspots['rid'])->where('adEvents','view-page')->get();

                    /* 使用者完成整個流程要扣的點數 */

                    $poc = DB::select("SELECT sum(points) AS poc FROM adpoints WHERE rid = $rid");
                    $site = DB::select("SELECT a_id FROM hot_add WHERE rid = $rid");

                    foreach ($poc as $v){
                        $poc = $v;
                        foreach ($v as $q){
                            $poc = $q;
                        }
                    }

                    empty($poc)?0:$poc;
                    array_push ($data,$poc);
                    array_push ($data,$site);

                    cache()->add($myday.'-'.$ad_rid,$data, 120);
                    $siteArray = [];
                    foreach ($data[2] as $v){
                        foreach ($v as $q){
                            array_push ($siteArray,$q);
                        }
                    }
                    $rid = $data[0];
                    $poc = (int)$data[1];
                }else{
                    $data = cache($myday.'-'.$ad_rid);
                    $siteArray = [];
                    foreach ($data[2] as $v){
                        foreach ($v as $q){
                            array_push ($siteArray,$q);
                        }
                    }
                    $rid = $data[0];
                    $poc = (int)$data[1];

                }



                /* 如果有指定ID以指定ID為優先 */
                if(!empty($ad_specifyId)) {

                    $ad_row = Ad::where('a_id',$ad_specifyId)->get();

                    /* 如果沒有指定ID,執行下面的動作 */
                }else {

                    /* 取出播放類型 */
//                    Style::where('s_type',$ad_type)->get();


                    /* 取出廣告資料 */
//                    $adc = DB::select("SELECT ad.* FROM ad LEFT JOIN myadmin AS ma ON ad.ma_user = ma.ma_user LEFT JOIN hot_add AS ha ON ad.a_id = ha.a_id WHERE
//ad.gender_type = '$sex' OR ad.gender_type = 'public' AND ha.rid = '$rid' AND ad.a_status = 1 AND ad.a_mode = 1  AND ad.a_pq >= '$poc'
// AND ma.ma_point >= '$poc' AND ad.a_s_period <= '$myday'  AND ad.a_e_period >= '$myday'   ORDER BY RAND() LIMIT $ad_nums");
//                cache()->forget($myday);


                    if(!(cache()->has($myday))) {
                        $data = [];
                        $adc = DB::select("SELECT ad.* FROM ad LEFT JOIN myadmin AS ma ON ad.ma_user = ma.ma_user  WHERE
 ad.a_status = 1 AND ad.a_mode = 1  AND ad.a_pq >= '$poc' AND ma.ma_point >= '$poc' AND ad.a_s_period <= '$myday'  AND ad.a_e_period >= '$myday'   ");

                        $default = Ad::where('a_id',1)->first();

//                        array_push ($data,count($adc));
                        array_push ($data,0);
                        array_push ($data, $default);
                        //$at_row['s_id'] = ad.s_id;
                        /* 預設的廣告 ID,若查詢後都沒廣告內容，根據該 ID 設定廣告內容。  */
                        if (count($adc) == 0) {
                            $ad_row = Ad::where('a_id', $ad_defaultId)->first();
                            $ad_row = $ad_row['attributes'];

                        }else if(count($adc) == 1){
                            foreach ($adc as $k => $v) {
                                foreach ($v as $q => $p) {
                                    $ad_row[$q] = $p;
                                }
                            }
                        }else{
                            $data_array = [];
                            $data_name = ['a_id','s_id','a_name','a_type','a_img','a_video','a_html','a_ad','a_default','a_android','a_ios','a_s_period',
                                'a_e_period','a_mode','a_pq','a_status','ma_user','gender_type'];
                            foreach ($adc as $k=>$v){
                                $num = 0;
                                foreach ($v as $p=>$q){
                                    $data_array[$k][$data_name[$num]] = $q;
                                    $num++;
                                }
                            }
                            $ad_row = $data_array;
                        }
                        array_push ($data,$ad_row);

                        cache()->add($myday,$data, 120);
                    }

                    $data = cache($myday);
                    if(!empty($data[2])){
                        if (count($data[2])==count($data[2], 1)) {
                            // 一维数组
                            if(!empty($data[2])){
                                if (in_array($data[2]['a_id'], $siteArray)){
                                    $data[0] = $data[0] +1;
                                }else{
                                    unset($data[2]);
                                }
                            }

                        } else {
                            // 多维数组\
                            foreach ($data[2] as $k=>$v){
                                if (in_array($v['a_id'], $siteArray)){
                                    $data[0] = $data[0] +1;
                                }else{
                                    unset($data[2][$k]);
                                }
                            }

                            $data[2] = array_values($data[2]);
                        }
                    }


                    if($data[0] == 0) {
                        $ad_row = $data[1];
                    }else if($data[0] == 1){
                        try{
                            $ad_row = $data[2][0];
                        }catch (\Exception $e){
                            $ad_row = $data[2];
                        }

                    }else if($data[0] > 1){
                        $rand = rand(1,$data[0]) - 1;
                        $ad_row = $data[2][$rand];
                    }



                }

                if (!empty($ad_row)){
//                    dd($ad_row);
//                    while($ad_row) {

                        $a_id = $ad_row['a_id'];

                        //1051125 增加 偵測設備為Android認證結束後跑a_android,如是iphone跑a_ios,如果都不是跑預設
                        if($phonedrive=="A"){

                            if($ad_row['a_android']!='') {
                                $url = $ad_row['a_android'];
                            }else{
                                $url = $ad_row['a_default'];
                            }

                        }elseif($phonedrive=="I"){

                            if($ad_row['a_ios']!='') {
                                $url = $ad_row['a_ios'];
                            }else{
                                $url = $ad_row['a_default'];
                            }

                        }else{
                            $url = $ad_row['a_default'];
                        }



                        /* 完成後要前往的網址

                        if($ad_row['a_android']!='') {
                            $url = $ad_row['a_android'];
                        }elseif($ad_row['a_ios']!='') {
                            $url = $ad_row['a_ios'];
                        }else{
                            $url = $ad_row['a_default'];
                        }

                        */

                        if($ad_row['a_type']==1) {
                            $ad_type = "2x3";
                            $type = $this->s_type($ad_row['s_id']);


                            $ad = '';
//                            $ad .= '<div id="banner"><img id="img" src="'.$ad_row['a_img'].'" width="100%" onclick="returnPoint(\''.$a_id.'\',\''.$ad_mac.'\',\''.$ad_site.'\',\''.$type.'\',\''.$rid.'\',\'return-banner\',\''.$url.'\')"/></div>';
                            $ad .= '<div id="banner"><img id="img" src="image/'.$ad_row['a_img'].'" width="100%" onclick="returnPoint(\''.$a_id.'\',\''.$ad_mac.'\',\''.$ad_site.'\',\''.$type.'\',\''.$rid.'\',\'return-banner\',\''.$url.'\')"/></div>';
                        }else {
//                            $ad_type = "youtube";
//                            $yid = explode('=',$ad_row['a_video']);
//                            $yad = $yid[1];

                            $ad = '';
                            $ad .= '<video width="100%"  autoplay  controls  muted  loop playsinline>
                                        <source src="video/111.mp4" type="video/mp4">
                                        <source src="video/111.mp4" type="video/ogg">
                                    Your browser does not support HTML5 video.
                                    </video>';

                        }

//                    }
                }


                /* 若沒問題結束交易 */

            } catch(\Exception $e) {

                /* 若有問題回復未執行前的SQL */
                echo 'error';

            }


        }else {

            exit();

        }



        $url = empty($url)?'':$url;
        $ad = empty($ad)?'':$ad;
        $yad = empty($yad)?'':$yad;
        if(empty($ad_row)){
            $ad_row_array = ['a_id'];
            foreach ($ad_row_array as $v){
                $ad_row[$v] = '';
            }
        }


        
        

        return view('home.index',compact('ad_type','url','ad_row','input','ad','yad','ad_hsname'));
    }


    public function point()
    {
        $input = Input::all();




        if(!empty($input['a_id'])) {

            $myday = date('Y-m-d'); //今天的日期

//            $nt = time() - 300; //現在時間減5分鐘
            $nt = time() - 300; //現在時間減5分鐘

            $nt = date("Y-m-d H:i:s",$nt);


            /* 如果有分配點數 */
            try {


                $connect = Connect::where('a_id',$input['a_id'])->where('c_mac',$input['mac'])->where('adEvents',$input['action'])->where('rid',$input['rid'])->where('c_time','>=',$nt)->get();
                $pc = count($connect);




                if($pc == 0) {


                    $adpoints = Adpoints::where('rid',$input['rid'])->where('adType',$input['type'])->where('adEvents',$input['action'])->first();
                    $pc2 = count($adpoints);

                    if($pc2 > 0) {

//                        $pc2_row = $rs2->fetch(PDO::FETCH_ASSOC); //取得相關資料

                        /*  先查詢該則廣告是否有分配點數 */
                        $ad_row = Ad::where('a_id',$input['a_id'])->first();


//                          /* 先查詢該帳號總額 */
//                        $sp_row = Myadmin::where('ma_user',$ad_row['ma_user'])->where('ma_status',1)->first();
//
//                        $p_sum = $sp_row['ma_point'] - $adpoints['points']; //扣完的總額
//                        $p_sum = ($p_sum > 0)?$p_sum:0;
//
//
//                        /* 查詢扣點原因 */
//                        $ae_row = Adevents::where('adEvents',$input['action'])->first();


                        switch($input['action']) {

                            case 'view-page':
                                $aps = 5;
                                break;
                            case 'start-youtube':
                                $aps = 7;
                                break;
                            case 'return-banner':
                                $aps = 8;
                                break;
                            case 'final-youtube':
                                $aps = 9;
                                break;
                            case 'redirect':
                                $aps = 10;
                                break;
                        }


                        if($ad_row['a_mode']==1) {

                            /* 如果廣告有分配點數 */


                            if($adpoints['points'] != 0){
                                $points = Ad::where('a_id',$input['a_id'])->first();
                                $total = $points['attributes']['a_pq'] - $adpoints['points'];
                                Ad::where('a_id',$input['a_id'])->update(['a_pq'=>$total]);

                                if($total == 0 && $input['a_id'] != 1){
                                    $data = cache($myday);
                                    $data[0] = (($data[0]-1) >=  0)?$data[0]-1:0;
                                    if (count($data[2])==count($data[2], 1)) {
                                        // 一维数组
                                        unset($data[2]);
                                    } else {
                                        // 多维数组\
                                        foreach ($data[2] as $k=>$v){
                                            if($v['a_id'] == $points['a_id']){
                                                unset($data[2][$k]);
                                            }
                                        }
                                    }

                                    cache()->forget($myday);
                                    cache()->add($myday,$data, 1200);
                                }
                            }




//                            /* 取出剩餘的分配餘額 */
//                            $row_pq = Ad::where('a_id',$input['a_id'])->first();
//
//                            $site = (empty($input['site']))?'':$input['site'];
//                            /* 寫入點數歷程表 */
//                            $pi_rs = Point::create([
//                                'p_name' => $aps,
//                                'p_quantity' => $adpoints['points'],
//                                'a_id' => $input['a_id'],
//                                'p_act' => $ae_row['eventTagtw'],
//                                'p_local' => $site,
//                                'p_over' => $row_pq['a_pq'],
//                                'p_sum' => $sp_row['ma_point'],
//                                'ma_user' => $ad_row['ma_user'],
//                            ]);


                        }else{

                            /* 如果沒有分配點數,則由總額扣 */
                            $myadmin = Myadmin::where('ma_user',$ad_row['ma_user'])->where('ma_status',1)->first();
                            $ma_point = $myadmin->ma_point - $adpoints['points'];
                            $ma_point = ($ma_point > 0)?$ma_point:0;
                            Myadmin::where('ma_user',$ad_row['ma_user'])->where('ma_status',1)->update(['ma_point'=>$ma_point]);

//                            /* 寫入點數歷程表 */
//                            Point::create([
//                                'p_name' => $aps,
//                                'p_quantity' => $adpoints['points'],
//                                'a_id' => (int)$input['a_id'],
//                                'p_act' => $ae_row['eventTagtw'],
//                                'p_local' => $input['site'],
//                                'p_sum' => $p_sum,
//                                'ma_user' => $ad_row['ma_user']
//                            ]);

                        }

                        /* 寫入其他相關資訊 */

//                        /* 先查詢廣告總表是否已存在資料 */
//                        $st_rs = Ad_St::where('a_id',$ad_row['a_id'])->where('as_date',$myday)->first();
//                        $stc = count($st_rs);
//
//
//                        $action = $input['action'];
//
//                        if(!empty($stc)) {
//
//                            /* 觀看廣告開始 */
//                            if(($action=='view-page')||($action=='start-youtube')) {
//
//                                $stu_rs = Ad_St::where('as_id',$st_rs['as_id'])->first();
//
//
//                                $stu_rs = Ad_St::where('as_id',$st_rs['as_id'])->update([
//                                        'as_ef' => $stu_rs['as_ef']+1,
//                                        'as_ep' => $stu_rs['as_ep']+$adpoints['points'],
//                                        'as_use' => $stu_rs['as_use']+$adpoints['points'],
//                                ]);
//
//                            }
//                            /* 觀看廣告結束 */
//
//
//                            /* 點擊圖片開始 */
//                            if($action=='return-banner') {
//
//                                $stu_rs = Ad_St::where('as_id',$st_rs['as_id'])->first();
//                                $stu_rs = Ad_St::where('as_id',$st_rs['as_id'])->update([
//                                    'as_cf' => $stu_rs['as_cf']+1,
//                                    'as_cp' => $stu_rs['as_cp']+$adpoints['points'],
//                                    'as_use' => $stu_rs['as_use']+$adpoints['points'],
//                                ]);
//
//                            }
//                            /* 點擊圖片結束 */
//
//
//                            /* 播放結束(Youtube影片)開始 */
//                            if($action=='final-youtube') {
//
//                                $stu_rs = Ad_St::where('as_id',$st_rs['as_id'])->first();
//                                $stu_rs = Ad_St::where('as_id',$st_rs['as_id'])->update([
//                                    'as_pf' => $stu_rs['as_pf']+1,
//                                    'as_pp' => $stu_rs['as_pp']+$adpoints['points'],
//                                    'as_use' => $stu_rs['as_use']+$adpoints['points'],
//                                ]);
//
//                            }
//                            /* 播放結束(Youtube影片)結束 */
//
//                        }else {
//
//                            /* 觀看廣告開始 */
//                            if(($action=='view-page')||($action=='start-youtube')) {
//
//                                $stu_rs = Ad_St::create([
//                                    'as_date' => $myday,
//                                    'a_id' => $ad_row['a_id'],
//                                    'as_ef' => 1,
//                                    'as_ep' => $adpoints['points'],
//                                    'as_use' => $adpoints['points']
//                                ]);
//
//
//                            }
//                            /* 觀看廣告結束 */
//
//
//                            /* 點擊圖片開始 */
//                            if($action=='return-banner') {
//
//                                $stu_rs = Ad_St::create([
//                                    'as_date' => $myday,
//                                    'a_id' => $ad_row['a_id'],
//                                    'as_ef' => 1,
//                                    'as_ep' => $adpoints['points'],
//                                    'as_use' => $adpoints['points']
//                                ]);
//
//                            }
//                            /* 點擊圖片結束 */
//
//
//                            /* 播放結束(Youtube影片)開始 */
//                            if($action=='final-youtube') {
//
//                                $stu_rs = Ad_St::create([
//                                    'as_date' => $myday,
//                                    'a_id' => $ad_row['a_id'],
//                                    'as_ef' => 1,
//                                    'as_ep' => $adpoints['points'],
//                                    'as_use' => $adpoints['points']
//                                ]);
//
//                            }
//                            /* 播放結束(Youtube影片)結束 */
//
//
//                        }
//
//
//                        /* 先查詢廣告報表是否已存在資料 */
//                        $rp_row = Ad_Rp::where('a_id',$ad_row['a_id'])->where('ar_date',$myday)->where('rid',$input['rid'])->first();
//                        $rpc = count($rp_row);
//
//
//                        if(!empty($rpc)) {
//
//                            /* 觀看廣告開始 */
//                            if(($action=='view-page')||($action=='start-youtube')) {
//                                $rpu_rs = Ad_Rp::where('ar_id',$rp_row['ar_id'])->first();
//                                $rpu_rs = Ad_Rp::where('ar_id',$rp_row['ar_id'])->update([
//                                    'ar_ef' => $rpu_rs['ar_ef']+1,
//                                    'ar_ep' => $rpu_rs['ar_ep']+$adpoints['points'],
//                                    'ar_use' => $rpu_rs['ar_use']+$adpoints['points'],
//                                ]);
//
//
//                            }
//                            /* 觀看廣告結束 */
//
//
//                            /* 點擊圖片開始 */
//                            if($action=='return-banner') {
//
//                                $rpu_rs = Ad_Rp::where('ar_id',$rp_row['ar_id'])->first();
//                                $rpu_rs = Ad_Rp::where('ar_id',$rp_row['ar_id'])->update([
//                                    'ar_cf' => $rpu_rs['ar_cf']+1,
//                                    'ar_cp' => $rpu_rs['ar_cp']+$adpoints['points'],
//                                    'ar_use' => $rpu_rs['ar_use']+$adpoints['points'],
//                                ]);
//
//
//                            }
//                            /* 點擊圖片結束 */
//
//
//                            /* 播放結束(Youtube影片)開始 */
//                            if($action=='final-youtube') {
//
//                                $rpu_rs = Ad_Rp::where('ar_id',$rp_row['ar_id'])->first();
//                                $rpu_rs = Ad_Rp::where('ar_id',$rp_row['ar_id'])->update([
//                                    'ar_pf' => $rpu_rs['ar_pf']+1,
//                                    'ar_pp' => $rpu_rs['ar_pp']+$adpoints['points'],
//                                    'ar_use' => $rpu_rs['ar_use']+$adpoints['points'],
//                                ]);
//
//                            }
//                            /* 播放結束(Youtube影片)結束 */
//
//
//                        }else {
//
//                            /* 觀看廣告開始 */
//                            if(($action=='view-page')||($action=='start-youtube')) {
//
//                                $rpu_rs = Ad_Rp::create([
//                                    'ar_date' => $myday,
//                                    'a_id' => $ad_row['a_id'],
//                                    'rid' => $input['rid'],
//                                    'ar_ef' => 1,
//                                    'ar_ep' => $adpoints['points'],
//                                    'ar_use' => $adpoints['points']
//                                ]);
//
//
//                            }
//                            /* 觀看廣告結束 */
//
//
//                            /* 點擊圖片開始 */
//                            if($action=='return-banner') {
//
//                                $rpu_rs = Ad_Rp::create([
//                                    'ar_date' => $myday,
//                                    'a_id' => $ad_row['a_id'],
//                                    'rid' => (int)$input['rid'],
//                                    'ar_cf' => 1,
//                                    'ar_cp' => $adpoints['points'],
//                                    'ar_use' => $adpoints['points'],
//                                ]);
//
//
//                            }
//                            /* 點擊圖片結束 */
//
//
//                            /* 播放結束(Youtube影片)開始 */
//                            if($action=='final-youtube') {
//
//                                $rpu_rs = Ad_Rp::create([
//                                    'ar_date' => $myday,
//                                    'a_id' => $ad_row['a_id'],
//                                    'rid' => $input['rid'],
//                                    'ar_pf' => 1,
//                                    'ar_pp' => $adpoints['points'],
//                                    'ar_use' => $adpoints['points']
//                                ]);
//
//
//                            }
//                            /* 播放結束(Youtube影片)結束 */
//
//
//                        }


                        /* 寫入廣告連結資料表 */


                        /* 先查出熱點名稱 */
                        $hp_row = Hotspots::where('rid',$input['rid'])->first();


                        $c_time = time();


                        /* 是否超過五分鐘 */
                        $c_row = Connect::where('a_id',$ad_row['a_id'])->where('c_mac',$input['mac'])->where('rid',$input['rid'])->where('adEvents',$input['action'])->orderBy('c_time','DESC')->first();
                        $cc = count($c_row);


//                        $cct = ($cc > 0)?strtotime($c_row['c_time']) + 300:0;
                        $cct = ($cc > 0)?strtotime($c_row['c_time']) + 300:0;


                        if(($cc == 0) || ($c_time > $cct)) {

                            $c_time = date("Y-m-d H:i:s",$c_time);

                            Connect::create([
                                'a_id' => $ad_row['a_id'],
                                'c_mac' => $input['mac'],
                                'routerName' => $hp_row['aliasName'],
                                'rid' => $input['rid'],
                                'c_time' => $c_time,
                                'adEvents' => $input['action'],
                                'c_point' => $adpoints['points']
                            ]);


                        }


                    }

                }


                /* 若沒問題結束交易 */


                echo 'ok';

            } catch(\Exception $e) {

                /* 若有問題回復未執行前的SQL */

                echo 'error';

            }

        }else {
            echo 'no a_id';
        }
    }

    public function test()
    {

        $str = '1234';
        $data = Crypt::encrypt($str);
        echo $data;
    }
}
