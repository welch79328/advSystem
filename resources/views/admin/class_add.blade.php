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
                        <a href="javascript:;">廣告管理 (Ad Manager)</a>
                    </li>
                    <li>
                        <a href="{{url('admin/class/4')}}">廣告類型列表 (Ad Type List)</a>
                    </li>
                    <li>
                        <a href="javascript:;">新增廣告類型 (New Ad Categories)</a>
                    </li>
                </ul>
            </div>

            <!--/row-->

            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">
                        <div class="box-header well" data-original-title="">
                            <h2><i class="glyphicon glyphicon-edit"></i> 新增廣告類型 (New Ad Categories)</h2>
                        </div>
                        <div class="box-content">
                            @if(count($errors)>0)
                                <div class="mark">
                                    @if(is_object($errors))
                                        @foreach($errors->all() as $erroe)
                                            <p>{{$erroe}}</p>
                                        @endforeach
                                    @else
                                        <p>{{$errors}}</p>
                                    @endif
                                </div>
                            @endif
                            <form action="{{url('admin/class_deal_with')}}" method="post" enctype="multipart/form-data" id="form1" role="form">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="s_name">廣告類型名稱 (Ad Type Name)</label>
                                    <input name="s_name" type="text" class="form-control" id="s_name" placeholder="廣告類型名稱 (Ad Type Name)">
                                </div>
                                <div class="form-group">
                                    <label for="s_type">廣告類型代碼 (Ad Type Code)</label>
                                    <input name="s_type" type="text" class="form-control" id="s_type" placeholder="廣告類型代碼 (Ad Type Code)">
                                </div>
                                <div class="form-group">
                                    <label for="s_filename">樣式檔CSS上傳 (Style files CSS Upload)</label>
                                    <input type="text" size="50" name="s_filename" id="s_filename">
                                    <input id="file_upload" name="file_upload" type="file">
                                    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
                                    <script src="{{asset('org/uploadifive/jquery.uploadifive.js')}}" type="text/javascript"></script>
                                    <link rel="stylesheet" type="text/css" href="{{asset('org/uploadifive/uploadifive.css')}}">
                                    <script type="text/javascript">
                                        <?php $timestamp = time();?>
                                        $(function() {
                                            $('#file_upload').uploadifive({
                                                'formData'     : {
                                                    'timestamp' : '<?php echo $timestamp;?>',
                                                    '_token'     : '{{csrf_token()}}'
                                                },
                                                'uploadScript' : '{{url('admin/upload/css')}}',
                                                'onUploadComplete' : function(file, data) {
                                                    data = data.slice(0,29);
                                                    $('input[name = s_filename]').val(data);
                                                }
                                            });
                                        });
                                    </script>
                                    <style>
                                        .uploadifive{display:inline-block;}
                                        .uploadifive-button{border:none; border-radius:5px; margin-top:8px;}
                                        table.add_tab tr td span.uploadifive-button-text{color: #FFFFFF; margin: 0;}
                                    </style>
                                </div>
                                <div class="form-group">
                                    <label for="s_filename">狀態 (Status)</label><br />
                                    <input type="radio" name="s_status" id="s_status1" value="1"> 上架 (Start)
                                    <input name="s_status" type="radio" id="s_status2" value="0" checked="CHECKED"> 下架 (Stop)
                                </div>
                                <button type="submit" class="btn btn-default">新增廣告類型 (New Ad Categories)</button>
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