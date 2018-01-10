<?php

namespace App\Http\Controllers\Admin\Qu;

use App\Http\Model\Qu\Qu_Gift;
use App\Http\Model\Qu\Qu_Gift_Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class GiftController extends CommonController
{
    //get.admin/gift  全部管理列表
    public function index(){
        $data = Qu_Gift::all();
        return view('admin.qu.gift.index',compact('data'));
    }

    public function demo($giftName)
    {
        return view('admin.qu.gift.demo',compact('giftName'));
    }

    public function imitation($giftName)
    {
        $serverName = $giftName;

        return view('admin.gift.imitation',compact('serverName'));
    }

    public function search()
    {
        $input = Input::all();
        if(empty($input['page'])){
            session(['search_bar'=>null]);
        }
        if(!empty($input['search_bar'])){
            session(['search_bar'=>$input['search_bar']]);
        }

//        $hotspotsinfo = Hostpotsinfo::where('aliasName','LIKE','%'.$input['search_bar'].'%')->get();
        $data = Hotspotsinfo::where('aliasName','LIKE','%'.session('search_bar').'%')->join('adbertkey','hotspotsinfo.rid','=','adbertkey.rid')->paginate(10);
        $this->onlineType($data);
        $category = Category::all();
        return view('admin.qu.gift.search',compact('data','category'));
    }

    //get.admin/gift/create  添加管理
    public function create(){
//        $data = gift::all();
//        $cate = Category::all();
//        return view('admin.gift.add',compact('data','cate'));
        return view('admin.qu.gift.add');
    }

    //post.admin/gift  添加管理提交
    public function store(Request $request){
        $input = $request->all();
//        dd($input);
        $gi =  array_filter($request->only(['gi_type','gi_name','gi_content','serial_number','gi_status']));
        $re = Qu_Gift::create($gi);

        $qu_comtent = $request->except(['_token','gi_type','gi_name','gi_content','serial_number','gi_status']);
        $qu_comtent_total = count($qu_comtent['serial_number_list']);
        for ($i = 0; $i < $qu_comtent_total;$i++){
            $re1 = Qu_Gift_Content::create([
                'content' =>$qu_comtent['serial_number_list'][$i],
                'amount' =>$qu_comtent['serial_number_list_amount'][$i],
                'gi_id' =>$re['gi_id'],
            ]);
        }

        if($re && $re1){
            return redirect('qu/admin/gift');
        }else {
            return back()->with('errors', '數據填充錯誤, 請稍後重試');
        }
    }

    //get.admin/gift/{gift}/edit 編輯管理
    public function edit($gi_id){
        $data = [];
        $gi = Qu_Gift::where('gi_id',$gi_id)->first();
        $gi_content = Qu_Gift_Content::where('gi_id',$gi_id)->get();
        foreach ($gi_content as $k=>$v){
            $data[$gi_content[$k]['content']] = $gi_content[$k]['amount'];
        }

        return view('admin.qu.gift.edit',compact('gi','gi_content'));
    }

    //put.admin/gift/{gift}  更新管理
    public function update(Request $request,$gi_id){
        $input = Input::except('_token','_method');

        $gi =  array_filter($request->only(['gi_name','gi_content','gi_status','gi_type','serial_number']));

        $re = Qu_Gift::where('gi_id',$gi_id)->update($gi);

        $qu_comtent = $request->except(['_token','gi_type','gi_name','gi_content','serial_number','gi_status']);
        $qu_comtent_total = count($qu_comtent['serial_number_list']);
        Qu_Gift_Content::where('gi_id',$gi_id)->delete();
        for ($i = 0; $i < $qu_comtent_total;$i++){
            $re1 = Qu_Gift_Content::create([
                'content' =>$qu_comtent['serial_number_list'][$i],
                'amount' =>$qu_comtent['serial_number_list_amount'][$i],
                'gi_id' =>$gi_id,
            ]);
        }


        if($re || $re1){
            return redirect('qu/admin/gift');
        }else{
            return back()->with('errors', '管理更新失敗, 請稍後重試');
        }
    }

    //delete.admin/gift/{gift}  刪除單個管理
    public function destroy($gi_id){
        $re = Qu_Gift::where('gi_id',$gi_id)->delete();
        $re1 = Qu_Gift_Content::where('gi_id',$gi_id)->delete();


        if($re || $re1){
            $data = [
                'status' => 0,
                'msg' => '管理刪除成功!',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '管理刪除失敗, 請稍後重試!',
            ];
        }
        return $data;
    }

    public function show()
    {
        
    }
}
