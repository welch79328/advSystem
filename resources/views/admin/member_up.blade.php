@extends('layouts.admin')

@section('css')
    <link href='{{asset('css/other.css')}}' rel='stylesheet'>
@endsection
@section('js')
    <script type="text/javascript" src="{{asset('org/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('bower_components/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.validate.js')}}"></script>
    <script src="{{asset('js/additional-methods.min.js')}}"></script>
    <script src="{{asset('js/messages_zh_TW.js')}}"></script>
    <script src="{{asset('js/jquery.blockUI.js')}}"></script>
    <script>
        $(function(){

            $("#form1").submit(function(e){

                var ma_level = $("#ma_level").val(); //公司

                if(ma_level!='admin') {

                    var ma_company = $("#ma_company").val(); //公司
                    var ma_tel     = $("#ma_tel").val();     //電話
                    var ma_add     = $("#ma_add").val();     //地址
                    var ma_pm      = $("#ma_pm").val();      //聯絡人
                    var ma_phone   = $("#ma_phone").val();   //行動電話
                    var ma_un      = $("#ma_un").val();      //統一編號
                    var msg        = '';

                    if(ma_company=='') {

                        msg = '公司欄位不能為空白!!\r\n'
                    }

                    if(ma_tel=='') {

                        msg += '電話欄位不能為空白!!\r\n'
                    }

                    if(ma_add=='') {

                        msg += '地址欄位不能為空白!!\r\n'
                    }

                    if(ma_pm=='') {

                        msg += '聯絡人欄位不能為空白!!\r\n'
                    }

                    if(ma_phone=='') {

                        msg += '行動電話欄位不能為空白!!\r\n'
                    }

                    if(ma_un=='') {

                        msg += '統一編號 / 身份證編號不能為空白!!'
                    }

                    if(msg!=0) {

                        alert(msg);
                        return false;

                    }

                }

            });

            $("input").focus(function(){
                ph = $(this).attr("placeholder");
                $(this).attr("placeholder","");
            }).blur(function(){
                $(this).attr("placeholder",ph);
            });

            /* 一開始的預設狀態開始 */
            var mls = $("#ma_level").val();

            if(mls=='admin') {
                $(".sub, .ml").hide();
            }else if(mls=='root') {
                $(".sub").show();
                $(".ml").hide();
            }else {
                $(".sub, .ml").show();
            }
            /* 一開始的預設狀態結束 */

            $("#ma_level").change(function(){

                var ml = $("#ma_level").val();

                if(ml=='admin') {
                    $(".sub, .ml").hide();
                }else if(ml=='root') {
                    $(".sub").show();
                    $(".ml").hide();
                }else {
                    $(".sub, .ml").show();
                }

            });


            /* 檢查是否已存在 */
            jQuery.validator.addMethod("cn", function(value, element) {

                $.ajax({
                    url: "check_member.php",
                    data: $('#form1').serialize(),
                    type:"POST",
                    dataType:'text',

                    success: function(msg){

                        msg2 = Number(msg);

                    }

                });

                if(msg2==0) {
                    return true;
                }else {
                    return false;
                }

            }, "帳號不可重複");


            /* 檢查統一編號 */
            jQuery.validator.addMethod("un", function(value, element) {

                var sid = value;
                var tbNum = new Array(1,2,1,2,1,2,4,1);
                var temp = 0;
                var total = 0;
                var alerts = "" ;
                if(sid==""){
                    return false;
                }else if(!sid.match(/^\d{8}$/)) {
                    return false;
                }else{
                    for(var i = 0; i < tbNum.length ;i ++){
                        temp = sid.charAt(i) * tbNum[i];
                        total += Math.floor(temp/10)+temp%10;
                    }
                    if(total%10==0 || (total%10==9 && sid.charAt(6)==7)){
                        return true;
                    }else{
                        return false;
                    }
                }


            }, "統一編號錯誤");


            $("#form1").validate({
                rules: {
                    ma_name: {
                        required: true
                    },
                    ma_pass: {
                        minlength:8
                    },
                    ma_company: {
                        required: true
                    },
                    ma_tel: {
                        required: true
                    },
                    ma_add: {
                        required: true
                    },
                    ma_un: {
                        required: true,
                        un: '$("#ma_un").val();'
                    },
                    ma_pm: {
                        required: true
                    },
                    ma_phone: {
                        required: true
                    },
                    ma_user: {
                        required: true,
                        email: true,
                        cn: '$("#ma_user").val();'
                    }
                },
                submitHandler:function(form){

                    $.blockUI({ message: '<h1><img src="img/busy.gif" /> 更新中，請稍候...</h1>' });
                    setTimeout(function() {
                        form.submit();
                    }, 1000);

                }
            });
        });
    </script>
@endsection
@section('content')

        <div id="content" class="col-lg-9 col-sm-9">
            <!-- content starts -->
            <div>
                <ul class="breadcrumb">
                    <li>
                        <a href="index.php?act=2">帳號管理 (Account Management)</a>
                    </li>
                    <li>
                        <a href="index.php?act=2">帳號列表 (Accoun List)</a>
                    </li>
                    <li>
                        <a href="javascript:;">更新帳號 (Update Account)</a>
                    </li>
                </ul>
            </div>

            <!--/row-->

            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">
                        <div class="box-header well" data-original-title="">
                            <h2><i class="glyphicon glyphicon-edit"></i> 更新帳號 (Update Account)</h2>
                        </div>
                        <div class="box-content">
                            <form action="{{url('admin/member_up_deal_with')}}" method="post" enctype="multipart/form-data" id="form1" role="form">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="ma_name">名稱 (Name)</label>
                                    <input name="ma_name" type="text" class="form-control" id="ma_name" placeholder="名稱 (Nane)" value="{{$rs->ma_name}}">
                                </div>
                                <div class="form-group">
                                    <label for="ma_user">帳號 (Account)</label>
                                    <input name="ma_user" type="text" disabled class="form-control" id="ma_user" placeholder="帳號 (Account)" value="{{$rs->ma_user}}">
                                </div>
                                <div class="form-group">
                                    <label for="ma_pass">密碼 (Password)</label>
                                    <input name="ma_pass" type="password" class="form-control" id="ma_pass" placeholder="密碼欄位值為空白時，此欄位更新後密碼不變">
                                </div>
                                <div class="form-group">
                                    <label for="ma_level">權限 (Level)</label><br />
                                    <select name="ma_level" id="ma_level" class="form-control3">
                                        @if($rs->ma_level=='admin')
                                        <option selected="selected" value="admin">系統帳號 (System)</option>
                                        @endif
                                        @if($rs->ma_level=='root')
                                        <option selected="selected" value="root">客戶帳號 (Guest)</option>
                                        @endif
                                        @if($rs->ma_level=='view')
                                        <option selected="selected" value="view">檢視帳號 (View)</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group sub">&nbsp;</div>
                                <!-- 次帳號與檢視帳號 //-->
                                <div class="form-group sub">
                                    <label for="ma_company">公司 (Company)</label>
                                    <input name="ma_company" type="text" class="form-control" id="ma_company" placeholder="公司 (Company)" value="{{$rs->ma_company}}">
                                </div>

                                <div class="form-group sub">
                                    <label for="ma_tel">電話 (Telephone)</label>
                                    <input name="ma_tel" type="text" class="form-control" id="ma_tel" placeholder="電話 (Telephone)" value="{{$rs->ma_tel}}">
                                </div>

                                <div class="form-group sub">
                                    <label for="ma_add">地址 (Address)</label>
                                    <input name="ma_add" type="text" class="form-control" id="ma_add" placeholder="地址 (Address)" value="{{$rs->ma_add}}">
                                </div>

                                <div class="form-group sub">
                                    <label for="ma_un">統一編號 / 身份證編號 (Uniform Numbers / Identification Number)</label>
                                    <input name="ma_un" type="text" class="form-control" id="ma_un" placeholder="統一編號 / 身份證編號 (Uniform Numbers / Identification Number)" value="{{$rs->ma_un}}">
                                </div>

                                <div class="form-group sub">
                                    <label for="ma_pm">聯絡人 (Contact Person)</label>
                                    <input name="ma_pm" type="text" class="form-control" id="ma_pm" placeholder="聯絡人 (Contact Person)" value="{{$rs->ma_pm}}">
                                </div>

                                <div class="form-group sub">
                                    <label for="ma_phone">行動電話 (Mobile Phone)</label>
                                    <input name="ma_phone" type="text" class="form-control" id="ma_phone" placeholder="行動電話 (Mobile Phone" value="{{$rs->ma_phone}}">
                                </div>

                                @if(session('ma_level')=='admin')
                                <div class="form-group ml">
                                    <label for="ma_ul">上層帳號 (Mobile Phone)</label><br />
                                    <select name="ma_ul" id="ma_ul" class="form-control3">
                                        @foreach($ml_rs as $v)
                                        <option value="{{$v->ma_user}}" @if($v->ma_user==$rs->ma_ul) selected="selected"@endif >{{$v->ma_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="ml">&nbsp;</p>
                                @endif

                                <div class="form-group sub">
                                    <label for="ma_sex">性別 (Gender)</label><br />
                                    <input name="ma_sex" type="radio" id="ma_sex" value="先生" @if($rs->ma_sex=='先生') checked="CHECKED" @endif>
                                    先生
                                    <input type="radio" name="ma_sex" id="ma_sex2" value="女士" @if($rs->ma_sex=='女士') checked="CHECKED" @endif>
                                    女士
                                </div>
                                <P>&nbsp;</P>
                                <div class="form-group">
                                    <label for="ma_status">狀態 (Status)</label><br />
                                    <input name="ma_status" type="radio" id="ma_status" value="1" @if($rs->ma_status==1) checked="CHECKED" @endif>
                                    啟用 (on)
                                    <input name="ma_status" type="radio" id="ma_status2" value="0" @if($rs->ma_status==0) checked="CHECKED" @endif>
                                    關閉 (off)
                                </div>
                                <p>&nbsp;</p>

                                <button type="submit" class="btn btn-default">更新帳號 (Update Account)</button>
                                <button type="button" class="btn btn-default" style="margin-left:10px;" onclick="history.back()">回上一頁 (Back)</button>
                                <input name="act" type="hidden" id="act" value="up">
                                <input name="ma_id" type="hidden" id="ma_id" value="{{$rs->ma_id}}">
                                <input name="ma_pass2" type="hidden" id="ma_pass2" value="{{$rs->ma_pass}}">
                                <input name="ma_user2" type="hidden" id="ma_user2" value="{{$rs->ma_user}}">
                            </form>

                        </div>
                    </div>
                </div>
                <!--/span-->

            </div><!--/row-->

            <!-- content ends -->
        </div><!--/#content.col-md-0-->
    </div><!--/fluid-row-->

    <!-- Ad, you can remove it -->
    <div class="row"></div>
    <!-- Ad ends -->

@endsection