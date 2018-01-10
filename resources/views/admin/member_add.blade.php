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
    <script src="{{asset('js/input.js')}}"></script>
    <script src="{{asset('js/TWIDCheck.js')}}"></script>
    <script>
        $(function(){

            @if(session('ma_level')=='admin') $(".sub, .ml").hide(); @endif

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
                        required: true,
                        minlength:8
                    },
                    ma_user: {
                        required: true,
                        email: true,
                        cn: '$("#ma_user").val();'
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
                    }
                },
                submitHandler:function(form){

                    $.blockUI({ message: '<h1><img src="img/busy.gif" /> 新增中，請稍候...</h1>' });
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
                        <a href="javascript:;">新增帳號 (Create An Account)</a>
                    </li>
                </ul>
            </div>

            <!--/row-->

            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">
                        <div class="box-header well" data-original-title="">
                            <h2><i class="glyphicon glyphicon-edit"></i> 新增帳號 (Create An Account)</h2>
                        </div>
                        <div class="box-content">
                            <form action="{{url('admin/member_deal_with')}}" method="post" enctype="multipart/form-data" id="form1" role="form" autocomplete="off">
                                {{csrf_field()}}
                                <input style="display:none;" type="text" name="somefakename" />
                                <input style="display:none;" type="password" name="anotherfakename" />
                                <div class="form-group">

                                    <label for="ma_name">名稱 (Name)</label>
                                    <input name="ma_name" type="text" class="form-control" id="ma_name" placeholder="名稱 (Nane)">
                                </div>
                                <div class="form-group">
                                    <label for="ma_user">帳號 (Account)</label>
                                    <input name="ma_user" type="text" class="form-control" id="ma_user" placeholder="帳號 (Account)" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="ma_pass">密碼 (Password)</label>
                                    <input name="ma_pass" type="password" class="form-control" id="ma_pass" placeholder="密碼 (Password)" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="ma_level">權限 (Level)</label><br />
                                    <select name="ma_level" id="ma_level" class="form-control3">
                                        @if(session('ma_level')=='admin')
                                        <option selected="selected" value="admin">系統帳號 (System)</option>
                                        <option value="root">客戶帳號 (Guest)</option>
                                        <option value="view">檢視帳號 (View)</option>
                                        @else
                                    <!-- <option selected="selected" value="root">客戶帳號 (Guest)</option> //-->
                                        <option selected="selected" value="view">檢視帳號 (View)</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group sub">&nbsp;</div>
                                <!-- 次帳號與檢視帳號 //-->
                                <div class="form-group sub">
                                    <label for="ma_company">公司 (Company)</label>
                                    <input name="ma_company" type="text" class="form-control" id="ma_company" placeholder="公司 (Company)">
                                </div>

                                <div class="form-group sub">
                                    <label for="ma_tel">電話 (Telephone)</label>
                                    <input name="ma_tel" type="text" class="form-control" id="ma_tel" placeholder="電話 (Telephone)">
                                </div>

                                <div class="form-group sub">
                                    <label for="ma_add">地址 (Address)</label>
                                    <input name="ma_add" type="text" class="form-control" id="ma_add" placeholder="地址 (Address)">
                                </div>

                                <div class="form-group sub">
                                    <label for="ma_un">統一編號 / 身份證編號 (Uniform Numbers / Identification Number)</label>
                                    <input name="ma_un" type="text" class="form-control" id="ma_un" placeholder="統一編號 / 身份證編號 (Uniform Numbers / Identification Number)">
                                </div>

                                <div class="form-group sub">
                                    <label for="ma_pm">聯絡人 (Contact Person)</label>
                                    <input name="ma_pm" type="text" class="form-control" id="ma_pm" placeholder="聯絡人 (Contact Person)">
                                </div>

                                <div class="form-group sub">
                                    <label for="ma_phone">行動電話 (Mobile Phone)</label>
                                    <input name="ma_phone" type="text" class="form-control" id="ma_phone" placeholder="行動電話 (Mobile Phone">
                                </div>

                                @if(session('ma_level')=='admin')
                                <div class="form-group ml">
                                    <label for="ma_ul">上層帳號 (Mobile Phone)</label><br />
                                    <select name="ma_ul" id="ma_ul" class="form-control3">
                                        @foreach($rs as $v)
                                        <option value="{{$v->ma_user}}">{{$v->ma_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="ml">&nbsp;</p>
                                @endif

                                <div class="form-group sub">
                                    <label for="ma_sex">性別 (Gender)</label><br />
                                    <input name="ma_sex" type="radio" id="ma_sex" value="先生" checked="CHECKED">
                                    先生
                                    <input type="radio" name="ma_sex" id="ma_sex2" value="女士">
                                    女士
                                </div>
                                <p>&nbsp;</p>
                                <div class="form-group">
                                    <label for="ma_status">狀態 (Status)</label><br />
                                    <input name="ma_status" type="radio" id="ma_status" value="1">
                                    啟用 (on)
                                    <input name="ma_status" type="radio" id="ma_status2" value="0" checked="CHECKED">
                                    關閉 (off)
                                </div>
                                <p>&nbsp;</p>


                                <button type="submit" class="btn btn-default">新增帳號 (Create An Account)</button>
                                <button type="button" class="btn btn-default" style="margin-left:10px;" onclick="history.back()">回上一頁 (Back)</button>
                                <input name="act" type="hidden" id="act" value="inst">
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

