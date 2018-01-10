@extends('layouts.qu.admin')

@section('include')
    <script type="text/javascript" src="{{asset('js/qu/upload.js')}}"></script>
@endsection

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('qu/admin/info')}}">首页</a> &raquo; 問卷管理
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
                <a href="{{url('qu/admin/questionnaire/create')}}"><i class="fa fa-plus"></i>Add Questionnaire</a>
                <a href="{{url('qu/admin/questionnaire')}}"><i class="fa fa-recycle"></i>All Questionnaire</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('qu/admin/questionnaire')}}" method="post">
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
                        <th width="120">場域：</th>
                        <td>
                            <select name="qu_field" style="width:337px;font-size:14px;">
                                <option value="field">大場域</option>
                                <option value="mrt">捷運</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th>問卷名稱：</th>
                        <td>
                            <input type="text" size="50" name="qu_name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>必須填寫</span>
                        </td>
                    </tr>

                    <tr>
                        <th>期間：</th>
                        <td>
                            <input type="text" id="dom-id" size="20" name="qu_period">
                            <link rel ="stylesheet" href ="{{asset('org/jquery-date-range-picker/dist/daterangepicker.min.css')}}">
                            <script type ="text/javascript" src ="{{asset('org/jquery-date-range-picker/moment.min.js')}}"> </script>
                            <script type ="text/javascript" src ="jquery.min.js"> </script>
                            <script type ="text/javascript" src ="{{asset('org/jquery-date-range-picker/dist/jquery.daterangepicker.min.js')}}"> </script>
                            <script>
                                $('#dom-id').dateRangePicker();
                            </script>
                        </td>
                    </tr>

                    <tr>
                        <th>題目數量：</th>
                        <td>
                            <input type="number" size="50" onchange="subject(this,'qu_topic_list')" name="subject_amount"  min="1" max="10">
                        </td>
                    </tr>

                    <tr id="qu_topic" style="display: none;">
                    {{--<tr id="qu_topic">--}}
                        <th>問卷題目：</th>
                        <td id="qu_topic_list">
                            {{--<div>--}}
                                {{--<table>--}}
                                    {{--<tr>--}}
                                        {{--<th width='60'>題目1 :</th>--}}
                                        {{--<td>--}}
                                            {{--<select name='topic_name_1' style='width:100px;font-size:14px;' onchange="option(this,'topic_value_1')">--}}
                                                {{--<option value='text'>文字</option>--}}
                                                {{--<option value='image'>圖片</option>--}}
                                                {{--<option value='video'>影片</option>--}}
                                            {{--</select>--}}
                                            {{--<select name='topic_select_1' style='width:100px;font-size:14px;'>--}}
                                                {{--<option value='radio'>單選</option>--}}
                                                {{--<option value='checkbox'>複選</option>--}}
                                            {{--</select>--}}
                                            {{--<select name='topic_need_1' style='width:100px;font-size:14px;'>--}}
                                                {{--<option value='unimportant'>非必填</option>--}}
                                                {{--<option value='important'>必填</option>--}}
                                            {{--</select>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<th></th>--}}
                                        {{--<td id='topic_value_1'></td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<th width='40'>選項 :</th>--}}
                                        {{--<td>--}}
                                            {{--<select id='option_name_1' name='option_name_1' style='width:100px;font-size:14px;' onchange="option(this,'option_value_1')">--}}
                                                {{--<option value='text'>文字</option>--}}
                                                {{--<option value='image'>圖片</option>--}}
                                            {{--</select>--}}
                                            {{--<select id='option_amount_1' name='option_amount_1' style='width:100px;font-size:14px;' onchange="subject(this,'option_value_1')">--}}
                                                {{--<option value='1'>1</option>--}}
                                                {{--<option value='2'>2</option>--}}
                                                {{--<option value='3'>3</option>--}}
                                                {{--<option value='4'>4</option>--}}
                                                {{--<option value='5'>5</option>--}}
                                                {{--<option value='6'>6</option>--}}
                                                {{--<option value='7'>7</option>--}}
                                                {{--<option value='8'>8</option>--}}
                                                {{--<option value='9'>9</option>--}}
                                                {{--<option value='10'>10</option>--}}
                                            {{--</select>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<th>--}}
                                        {{--</th>--}}
                                        {{--<td id='option_value_1'>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                {{--</table>--}}
                            {{--</div>--}}
                        </td>
                    </tr>

                    <tr>
                        <th>禮品選擇：</th>
                        <td>
                            @foreach($gift as $v)
                                <select name="gi_id" style="width:337px;font-size:14px;">
                                    <option value="{{$v->gi_id}}">{{$v->gi_name}}</option>
                                </select>
                            @endforeach
                        </td>
                    </tr>

                    <tr>
                        <th width="120"></th>
                        <td size="50">
                            <select name="qu_status" style="width:337px;font-size:14px;">
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
        var now_topic_number = 0;
        var now_option_number = [];
        for(var i=1;i<=10;i++) {
            now_option_number[i] = 0;
        }



        function subject(obj,id) {
            var main  = "";
            var amount = $(obj).val();
            var mantissa = id.split("_");
            switch(id) {
                case 'qu_topic_list':
                    var now_number = now_topic_number;
                    break;
                case 'option_value_'+mantissa[2]:
                    var now_number = now_option_number[mantissa[2]];
                    break;
            }
            if(amount > now_number){
                var start_number = parseInt(now_number)+1;

                for (var i=start_number;i<=amount;i++){
                    switch(id)
                    {
                        case 'qu_topic_list':
                            $('#qu_topic').show();
//                        main += "<div><table><tr><th width='60'>題目"+i+" :</th><td><select name='topic_name_"+i+"' style='width:100px;font-size:14px;' onchange=\"option(this,'topic_value_"+i+"')\"><option value='text'>文字</option><option value='image'>圖片</option><option value='video'>影片</option></select></td></tr><tr><th></th><td id='topic_value_"+i+"'></td></tr><tr><th width='40'>選項 :</th><td><select id='option_name_"+i+"' name='option_name_"+i+"' style='width:100px;font-size:14px;' onchange=\"option(this,'option_value_"+i+"')\"><option value='text'>文字</option><option value='image'>圖片</option></select><select id='option_amount_"+i+"' name='option_amount_"+i+"' style='width:100px;font-size:14px;' onchange=\"subject(this,'option_value_"+i+"')\"><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option></select></td></tr><tr><th></th><td id='option_value_"+i+"'></td></tr></table></div>";
                            main += "<div id='de_"+i+"'><table><tr><th width='60'>題目"+i+" :</th><td><select name='topic_name_"+i+"' style='width:100px;font-size:14px;' onchange=\"option(this,'topic_value_"+i+"')\"><option value='text'>文字</option><option value='image'>圖片</option><option value='video'>影片</option></select><select name='topic_select_"+i+"' style='width:100px;font-size:14px;'><option value='radio'>單選</option><option value='checkbox'>複選</option></select><select name='topic_need_"+i+"' style='width:100px;font-size:14px;'><option value='unimportant'>非必填</option><option value='important'>必填</option></select></td></tr><tr><th></th><td id='topic_value_"+i+"'><div>選項: <input type='text' size='40' name='option_topic_value_"+i+"'></td></tr><tr><th width='40'>選項 :</th><td><select id='option_name_"+i+"' name='option_name_"+i+"' style='width:100px;font-size:14px;' onchange=\"option(this,'option_value_"+i+"')\"><option value='text'>文字</option><option value='image'>圖片</option></select><select id='option_amount_"+i+"' name='option_amount_"+i+"' style='width:100px;font-size:14px;' onchange=\"subject(this,'option_value_"+i+"')\"><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option></select></td></tr><tr><th></th><td id='option_value_"+i+"'></div></td></tr></table></div>"
                            break;
                        case 'option_value_'+mantissa[2]:
                            console.log(start_number);
                            console.log(amount);
                            var option_name = $("#option_name_"+mantissa[2]+" :selected").val();
                            if(option_name == 'image'){
                                main += "<div id='de_"+id+'_'+i+"'>選項(建議尺寸): "+uploadifive_build(timestamp,csrf_token,upload_url,upload_js,upload_css,name,'_'+id+'_'+i);
                                main += "導連頁: <input type='text' size='40' onchange='redirectpage(this)' name='redirect_"+id+'_'+i+"'>";
                                main += "<span id='priority_"+id+'_'+i+"' style='display: none'>優先度: <input type='number' min='1' max='10' name='priority_"+id+'_'+i+"'></span></div>";
                            }else if(option_name == 'text'){
                                main += "<div id='de_"+id+'_'+i+"'>選項: <input type='text' size='40' name='option_"+id+'_'+i+"'>";
                                main += "導連頁: <input type='text' size='40' onchange='redirectpage(this)' name='redirect_"+id+'_'+i+"'>";
                                main += "<span id='priority_"+id+'_'+i+"' style='display: none'>優先度: <input type='number' min='1' max='10' name='priority_"+id+'_'+i+"'></span></div>";
                            }
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
                        case 'option_value_'+mantissa[2]:
                            console.log(start_number);
                            console.log(amount);
                            $('#de_'+id+'_'+i+'').remove();
                            break;
                    }
                }
            }
            switch(id) {
                case 'qu_topic_list':
                    now_topic_number = amount;
                    break;
                case 'option_value_'+mantissa[2]:
                    now_option_number[mantissa[2]] = amount;
                    break;
            }
//            $('#'+id+'').html('');
        }

        

        function option(obj,id) {
            var mantissa = id.split("_");
            now_option_number[mantissa[2]] = 1;
            $("#option_amount_"+mantissa[2]).val(1);
            if(mantissa[0] == 'option'){
                var number = '_1';
                var main = " 導連頁: <input type='text' size='40' onchange='redirectpage(this)' name='redirect_"+id+"_1'><span id='priority_"+id+"_1' style='display: none'>優先度: <input type='number' min='1' max='10' name='priority_"+id+"_1'></span>";
            }else{
                var number = '';
                var main = '';
            }

            if($(obj).val() == 'image' || $(obj).val() == 'video'){
                $('#'+id+'').html('');
                $('#'+id+'').html("<div>選項(建議尺寸): "+uploadifive_build(timestamp,csrf_token,upload_url,upload_js,upload_css,name,'_'+id+number)+main+"</div>");
            }else if($(obj).val() == 'text' || obj == ''){
                $('#'+id+'').html('');
                $('#'+id+'').html("<div>選項: <input type='text' size='40' name='option_"+id+number+"'>"+main+"</div>");
            }
        }

        function redirectpage(obj) {
            var redirectpage_mantissa = $(obj).attr('name').split("_");
            var redirectName = '#priority_'+redirectpage_mantissa[1]+'_'+redirectpage_mantissa[2]+'_'+redirectpage_mantissa[3]+'_'+redirectpage_mantissa[4];
            $(redirectName).show();
            if($(obj).val() == ''){
                $(redirectName).hide();
            }
        }


    </script>
@endsection