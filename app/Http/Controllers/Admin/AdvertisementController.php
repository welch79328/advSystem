<?php

namespace App\Http\Controllers\Admin;



use App\Http\Model\Style;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AdvertisementController extends CommonController
{
    public function calss($act)
    {

        $rs = Style::where('s_status','!=',2)->orderBy('s_id','desc')->paginate(15);

        $level = $this->fun_level(session('ma_level'));

        return view('admin.class',compact('act','rs','level'));
    }

    public function calss_add($act)
    {

        $level = $this->fun_level(session('ma_level'));

        return view('admin.class_add',compact('act','level'));
    }

    public function class_deal_with()
    {
        $input = Input::except('_token');



        if($input['act']=='inst') {

            unset($input['act']);


                $rules=[
                    's_filename'=>'required|regex:/css$/',
                    's_name'=>'required',
                    's_type'=>'required',
                ];

                $message=[
                    's_filename.required'=>'樣式檔CSS不能為空!',
                    's_filename.regex'=>'樣式檔必須為CSS!',
                    's_name.required'=>'廣告類型名稱不能為空!',
                    's_type.required'=>'廣告類型代碼不能為空!',
                ];

                $validator = Validator::make($input,$rules,$message);

                if($validator->passes()){
                    $re = Style::create($input);
                    if($re){
                        return redirect('admin/class/4');
                    }else {
                        return back()->with('errors', '數據填充錯誤, 請稍後重試');
                    }
                }else{
                    return back()->withErrors($validator)->withInput();
                }

//                /* 上傳程式 */
//                $myfiles = '../css/'; //檔案存放資料夾
//                $handle = new Upload($_FILES['s_filename'],"zh_TW");
//                $new_name = date('YmdHis');
//
//                if ($handle->uploaded){
//                    $handle->file_new_name_body = $new_name;
//                    $handle->file_safe_name = false;
//                    $handle->file_no_script = false;
//                    $handle->file_new_name_ext = 'css';
//                    $handle->process($myfiles);
//
//                    if (!$handle->processed) {
//                        echo '<script language="javascript" charset="utf-8">';
//                        echo 'alert("檔案上傳失敗,請重新上傳!!");';
//                        echo 'location.href="class_add.php?act=4";';
//                        echo '</script>';
//                        exit();
//                    }
//
//                    $s_filename = $handle->file_dst_name;
//                    $handle-> Clean();
//
//                    /* 寫入資料庫 */
//                    $rs = $conn->prepare('INSERT style (s_name, s_type, s_filename, s_status) VALUES(:s_name, :s_type, :s_filename, :s_status)');
//                    $rs->bindValue(':s_name', $input['s_name'], PDO::PARAM_STR);
//                    $rs->bindValue(':s_type', $input['s_type'], PDO::PARAM_STR);
//                    $rs->bindValue(':s_filename', $s_filename, PDO::PARAM_STR);
//                    $rs->bindValue(':s_status', $input['s_status'], PDO::PARAM_INT);
//                    $rs->execute();
//
//                }


        }


        if($input['act']=='up') {

            if($input['s_filename'] == null){
                $input['s_filename'] = $input['s_filename2'];
            }
            unset($input['act']);
            unset($input['s_filename2']);



            $rules=[
                's_filename'=>'required|regex:/css$/',
                's_name'=>'required',
                's_type'=>'required',
            ];

            $message=[
                's_filename.required'=>'樣式檔CSS不能為空!',
                's_filename.regex'=>'樣式檔必須為CSS!',
                's_name.required'=>'廣告類型名稱不能為空!',
                's_type.required'=>'廣告類型代碼不能為空!',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $re = Style::where('s_id',$input['s_id'])->update($input);
                if($re){
                    return redirect('admin/class/4');
                }else {
                    return back()->with('errors', '數據填充錯誤, 請稍後重試');
                }
            }else{
                return back()->withErrors($validator)->withInput();
            }



        }


        return redirect('admin/class/4');

    }

    public function class_up($s_id,$act)
    {

        $style = Style::where('s_id',$s_id)->first();

        $style['s_file_name'] = explode('/',$style['s_filename']);


        $level = $this->fun_level(session('ma_level'));

        return view('admin.class_up',compact('style','level','act'));
    }

    public function class_del()
    {
        $input = Input::all();

        $re = Style::where('s_id',$input['s_id'])->update(['s_status'=>2]);

    }
}
