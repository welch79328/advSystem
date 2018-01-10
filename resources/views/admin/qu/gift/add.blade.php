@extends('layouts.qu.admin')

@section('include')
    <script type="text/javascript" src="{{asset('js/qu/upload.js')}}"></script>
@endsection

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('qu/admin/info')}}">首页</a> &raquo; 禮品管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h1>New router</h1>
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
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('qu/admin/gift/create')}}"><i class="fa fa-plus"></i>Add gift</a>
                <a href="{{url('qu/admin/gift')}}"><i class="fa fa-recycle"></i>All gift</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('qu/admin/gift')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                {{--<tr>--}}
                    {{--<th width="120">Category：</th>--}}
                    {{--<td>--}}
                        {{--<select name="cate_id" style="width:337px;font-size:14px;">--}}
                            {{--<option value="">null</option>--}}
                            {{--@foreach($cate as $v)--}}
                                {{--@if($v->cate_name != 'ALL')--}}
                                {{--<option value="{{$v->cate_id}}">{{$v->cate_name}}</option>--}}
                                {{--@endif--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--</td>--}}
                {{--</tr>--}}
                    <tr>
                        <th width="120">類型：</th>
                        <td>
                            <select name="gi_type" onchange="option(this,'gi_type_content')" style="width:337px;font-size:14px;">
                                <option value="text">發送序號</option>
                                <option value="img">發送圖片</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th>名稱：</th>
                        <td>
                            <input type="text" size="50" name="gi_name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>必須填寫</span>
                        </td>
                    </tr>

                    <tr>
                        <th>內容：</th>
                        <td>
                            <textarea id="gift-ckeditor" name="gi_content"></textarea>
                            <script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
                            <script>
                                CKEDITOR.replace( 'gift-ckeditor' );
                            </script>

                        </td>
                    </tr>

                    <tr>
                        <th>序號數量：</th>
                        <td id="gi_type_content">
                            <input type="number" size="50" onchange="subject(this,'qu_topic_list')" name="serial_number"  min="1" max="999">
                        </td>
                    </tr>

                    <tr id="qu_topic" style="display: none;">
                    {{--<tr id="qu_topic">--}}
                        <th>問卷題目：</th>
                        <td id="qu_topic_list"></td>
                    </tr>

                    <tr>
                        <th width="120"></th>
                        <td size="50">
                            <select name="gi_status" style="width:337px;font-size:14px;">
                                <option value="1">online</option>
                                <option value="0">offline</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script>
        <?php $timestamp = time();?>
        var timestamp = '<?php echo $timestamp;?>';
        var csrf_token = "{{csrf_token()}}";
        var upload_url = "{{url('qu/admin/upload')}}";
        var upload_css = "{{asset('org/uploadifive/uploadifive.css')}}";
        var upload_js = "{{asset('org/uploadifive/jquery.uploadifive.js')}}";
        var now_number = 0;

        function subject(obj,id) {
            var main  = "";
            var amount = $(obj).val();
            var mantissa = id.split("_");


            if(amount > now_number) {
                var start_number = parseInt(now_number)+1;

                for (var i=start_number;i<=amount;i++){
                    switch(id)
                    {
                        case 'qu_topic_list':
                            $('#qu_topic').show();
                            main += "<div id='de_"+i+"'>選項: <input  id='serial_number_list_"+i+"' type='text' size='40' onchange='redirectpage(this)'  name='serial_number_list[]'>";
                            main += "<span id='serial_number_list_amount_"+i+"' style='display: none'>數量: <input type='number' min='1' max='9999' name='serial_number_list_amount[]' value='1'></span></div>";

                            break;
                        default:
                    }
                }
                $('#'+id+'').append(main);
            }else{
                var end_number = parseInt(now_number);
                for (var i=end_number;i>amount;i--){
                    switch(id) {
                        case 'qu_topic_list':
                            $('#de_'+i+'').remove();
                            break;
                    }
                }
            }

            switch(id) {
                case 'qu_topic_list':
                    now_number = amount;
                    break;
            }
        }

        function option(obj,id) {
            var mantissa = id.split("_");
            var judgment = $(obj).val();
            $("#option_amount_"+mantissa[2]).val(1);
            if(mantissa[0] == 'option'){
                var number = '_1';
                var main = " 導連頁: <input type='text' size='40' onchange='redirectpage(this)' name='redirect_"+id+"_1'><span id='priority_"+id+"_1' style='display: none'>優先度: <input type='number' min='1' max='10' name='priority_"+id+"_1'></span>";
            }else{
                var number = '';
                var main = '';
            }

            switch (judgment){
                case 'text':
                    $('#'+id+'').html('');
                    $('#'+id+'').html("<input type='number' size='50' onchange=\"subject(this,'qu_topic_list')\" name='subject_amount'  min='1' max='999'>");
                    break;
                case 'img':
                    $('#qu_topic').hide();
                    $('#'+id+'').html('');
                    $('#'+id+'').html("<div>選項(建議尺寸): "+uploadifive_build(timestamp,csrf_token,upload_url,upload_js,upload_css,name,'_'+id+number)+main+"</div>");
                    break;
            }

        }

        function redirectpage(obj) {
            var redirectpage_mantissa = $(obj).attr('id').split("_");
            var redirectName = '#serial_number_list_amount_'+redirectpage_mantissa[3];
            $(redirectName).show();
            if($(obj).val() == ''){
                $(redirectName).hide();
            }
        }


    </script>
@endsection