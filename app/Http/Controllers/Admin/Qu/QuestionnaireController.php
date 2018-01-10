<?php

namespace App\Http\Controllers\Admin\Qu;


use App\Http\Model\Qu\Qu;
use App\Http\Model\Qu\Qu_Content;
use App\Http\Model\Qu\Qu_Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class QuestionnaireController extends CommonController
{
    //get.admin/questionnaire  全部管理列表
    public function index(){
        $data = Qu::all();
        return view('admin.qu.questionnaire.index',compact('data'));
    }

    public function demo($questionnaireName)
    {
        return view('admin.qu.questionnaire.demo',compact('questionnaireName'));
    }

    public function imitation($questionnaireName)
    {
        $serverName = $questionnaireName;

        return view('admin.qu.questionnaire.imitation',compact('serverName'));
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
        return view('admin.qu.questionnaire.search',compact('data','category'));
    }

    //get.admin/questionnaire/create  添加管理
    public function create(){
        $gift = Qu_Gift::all();

        return view('admin.qu.questionnaire.add',compact('gift'));
    }

    //post.admin/questionnaire  添加管理提交
    public function store(Request $request){
        $input = $request->all();
        $qu =  array_filter($request->only(['qu_field','qu_name','qu_period','subject_amount','qu_gift','qu_status']));
        $period = explode(" ",$qu['qu_period']);
        unset($qu['qu_period']);
        $qu['qu_s_period'] = $period[0];
        $qu['qu_e_period'] = $period[2];
        $re = Qu::create($qu);

        $qu_comtent = $request->except(['_token','qu_field','qu_name','qu_period','subject_amount','qu_gift','qu_status']);
        foreach ($qu_comtent as $k=>$v){
            $re1 = Qu_Content::create([
                'name' =>$k,
                'content' =>$v,
                'qu_id' =>$re['qu_id'],
            ]);
        }

        if($re && $re1){
            return redirect('qu/admin/questionnaire');
        }else {
            return back()->with('errors', '數據填充錯誤, 請稍後重試');
        }
    }

    //get.admin/questionnaire/{questionnaire}/edit 編輯管理
    public function edit($qu_id){
        $data = [];
        $qu = Qu::where('qu_id',$qu_id)->first();
        $qu_content = Qu_Content::where('qu_id',$qu_id)->get();
        foreach ($qu_content as $k=>$v){
            $data[$qu_content[$k]['name']] = $qu_content[$k]['content'];
        }

        $gift = Qu_Gift::all();

        return view('admin.qu.questionnaire.edit',compact('qu','data','gift'));
    }

    //put.admin/questionnaire/{questionnaire}  更新管理
    public function update(Request $request,$qu_id){
        $input = Input::except('_token','_method');

        $qu =  array_filter($request->only(['qu_field','qu_name','qu_period','subject_amount','qu_gift','qu_status']));
        $period = explode(" ",$qu['qu_period']);
        unset($qu['qu_period']);
        $qu['qu_s_period'] = $period[0];
        $qu['qu_e_period'] = $period[2];
        $re = Qu::where('qu_id',$qu_id)->update($qu);

        $qu_comtent = $request->except(['_token','_method','qu_field','qu_name','qu_period','subject_amount','qu_gift','qu_status']);
        Qu_Content::where('qu_id',$qu_id)->delete();
        foreach ($qu_comtent as $k=>$v){
            $re1 = Qu_Content::create([
                'name' =>$k,
                'content' =>$v,
                'qu_id' =>$qu_id,
            ]);
        }

        if($re || $re1 ){
            return redirect('qu/admin/questionnaire');
        }else{
            return back()->with('errors', '管理更新失敗, 請稍後重試');
        }
    }

    //delete.admin/questionnaire/{questionnaire}  刪除單個管理
    public function destroy($qu_id){

        $re = Qu::where('qu_id',$qu_id)->delete();
        $re1 = Qu_Content::where('qu_id',$qu_id)->delete();


        if($re && $re1){
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
