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

            $("input").focus(function(){
                ph = $(this).attr("placeholder");
                $(this).attr("placeholder","");
            }).blur(function(){
                $(this).attr("placeholder",ph);
            });


            $("#form1").validate({
                rules: {
                    p_quantity: {
                        required: true,
                        digits: true
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
                        <a href="javascript:;">帳號管理 (Account Management)</a>
                    </li>
                    <li>
                        <a href="point_gift.php?act=3">點數列表 (Points List)</a>
                    </li>
                    <li>
                        <a href="javascript:;">新增儲值 (Add Gift)</a>
                    </li>
                </ul>
            </div>

            <!--/row-->

            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">
                        <div class="box-header well" data-original-title="">
                            <h2><i class="glyphicon glyphicon-edit"></i> 新增儲值 (Add Gift)</h2>
                        </div>
                        <div class="box-content">
                            <form action="{{url('admin/point_deal_with')}}" method="post" enctype="multipart/form-data" id="form1" role="form">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="ma_user">帳號 (Account)</label><br />
                                    <select name="ma_user" id="ma_user" class="form-control3">
                                        @foreach($rs as $v)
                                        <option value="{{$v->ma_user}}">{{$v->ma_name}}</option>
                                        @endforeach
                                    </select><br />
                                    <p>&nbsp;</p>

                                </div>
                                <div class="form-group">
                                    <label for="p_quantity">儲值點數 (Gift Points)</label>
                                    <input name="p_quantity" type="text" class="form-control" id="p_quantity" placeholder="儲值點數 (Gift Points)">
                                </div>
                                <button type="submit" class="btn btn-default">新增儲值 (Add Gift)</button>
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