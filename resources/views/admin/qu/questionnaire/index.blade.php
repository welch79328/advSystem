@extends('layouts.qu.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('qu/admin/info')}}">首頁</a> &raquo; 問卷管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	{{--<div class="search_wrap">--}}

    {{--</div>--}}
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    {{--<form action="#" method="post">--}}
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_title">
                <h1>questionnaire list</h1>
            </div>
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('qu/admin/questionnaire/create')}}"><i class="fa fa-plus"></i>Add Questionnaire</a>
                    <a href="{{url('qu/admin/questionnaire')}}"><i class="fa fa-recycle"></i>All Questionnaire</a>
                    {{--<div  onclick="search_type()" style="display:inline;">--}}
                        {{--<a href="#"><i class="fa fa-recycle"></i>Search</a>--}}

                    {{--</div>--}}
                    <div style="display:inline;">
                            <input type="text" id="search_bar" name="search" style="display:none;" placeholder="AliasName....">
                            <input type="submit" onclick="search()"  id="search_bar_1" style="display:none;" value="提交">
                    </div>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">問卷名稱  (Qu Name)</th>
                        <th>期間 (Period)</th>
                        <th>狀態 (Status)</th>
                        <th>創建者 (Creator)</th>
                        <th>編輯 (Edit) | 刪除 (Del)</th>
                        {{--<th>演示 (Demo)</th>--}}
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td>
                            {{$v->qu_name}}
                        </td>
                        <td>{{$v->qu_s_period}} - {{$v->qu_e_period}}</td>
                        <td>{{$v->qu_status}}</td>
                        <td>{{$v->qu_creator}}</td>
                        <td>
                            {{--<a href="{{url('admin/questionnaire/'.$v->questionnaireName.'/demo/')}}">Demo</a>--}}
                            <a href="{{url('qu/admin/questionnaire/'.$v->qu_id.'/edit ')}}">Modify</a>
                            <a href="javascript::" onclick="delArt({{$v->qu_id}})">Del</a>
                        </td>
                    </tr>
                    @endforeach
                </table>

                <div class="page_list">
                    {{--{{$data->links()}}--}}
                </div>
            </div>
        </div>
    {{--</form>--}}
    <!--搜索结果页面 列表 结束-->
    <style>
        .result_content ul li span {
            font-size: 15px;
            padding: 6px 12px;
        }
    </style>

    <script>
        //刪除分類
        function delArt(qu_id) {
            layer.confirm('您確定要刪除這則問卷嗎？', {
                btn: ['確定','取消'] //按钮
            }, function(){
                $.post("{{url('qu/admin/questionnaire')}}/"+qu_id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
                    if(data.status == 0){
                        location.href = location.href;
                        layer.msg(data.msg, {icon: 6});
                    }else{
                        layer.msg(data.msg, {icon: 5});
                    }
                });
            }, function(){

            });
        }

        function search_type(){
            $('#search_bar').slideToggle();
            $('#search_bar_1').slideToggle();
        }

        function search() {
            var val = $('#search_bar').val();
            $.get("{{url('qu/admin/questionnaire_/search')}}",{'_token':'{{csrf_token()}}','search_bar':val},function (data) {
                $('body').html(data);
            });
        }

    </script>

@endsection