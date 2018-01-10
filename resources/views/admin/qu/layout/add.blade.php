@extends('layouts.qu.admin')

@section('include')
    <script type="text/javascript" src="{{asset('js/qu/upload.js')}}"></script>
@endsection

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('qu/admin/info')}}">首页</a> &raquo; 版面管理
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
                <a href="{{url('qu/admin/layout/create')}}"><i class="fa fa-plus"></i>版面修改</a>
                <a href="http://tool.c7sky.com/webcolor/" target="main"><i class="fa fa-fw fa-tachometer"></i>配色板</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('qu/admin/layout/store')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120">標題：</th>
                        <td>
                            <input type="text" size="50" name="title_name" value="{{$layout['title_name']}}">
                        </td>
                    </tr>

                    <tr>
                        <th width="120">標題尺寸：</th>
                        <td>
                            <input type="number" size="50" name="title_size" min="15" max="100" value="{{$layout['title_size']}}">
                        </td>
                    </tr>

                    <tr>
                        <th width="120">題目顏色：</th>
                        <td>
                            <input type="text" size="50" name="title_colour" value="{{$layout['title_colour']}}">
                        </td>
                    </tr>

                    <tr>
                        <th width="120">副標題：</th>
                        <td>
                            <input type="text" size="50" name="subtitle_name" value="{{$layout['subtitle_name']}}">
                        </td>
                    </tr>

                    <tr>
                        <th width="120">副標題尺寸：</th>
                        <td>
                            <input type="number" size="50" name="subtitle_size" min="15" max="100" value="{{$layout['subtitle_size']}}">
                        </td>
                    </tr>

                    <tr>
                        <th width="120">副標題顏色：</th>
                        <td>
                            <input type="text" size="50" name="subtitle_colour" value="{{$layout['subtitle_colour']}}">
                        </td>
                    </tr>

                    <tr>
                        <th width="120">題目尺寸：</th>
                        <td>
                            <input type="number" size="50" name="topic_size" min="15" max="100" value="{{$layout['topic_size']}}">
                        </td>
                    </tr>

                    <tr>
                        <th width="120">題目顏色：</th>
                        <td>
                            <input type="text" size="50" name="topic_colour" value="{{$layout['topic_colour']}}">
                        </td>
                    </tr>

                    <tr>
                        <th width="120">選項尺寸：</th>
                        <td>
                            <input type="number" size="50" name="option_size" min="15" max="100" value="{{$layout['option_size']}}">
                        </td>
                    </tr>

                    <tr>
                        <th width="120">選項顏色：</th>
                        <td>
                            <input type="text" size="50" name="option_colour" value="{{$layout['option_colour']}}">
                        </td>
                    </tr>

                    <tr>
                        <th>背景選項：</th>
                        <td>
                            <input type="radio" name="background_type" onclick="option('plain','background')" value="plain" @if($layout['background_type'] == 'plain') checked @endif>素色背景
                            <input type="radio" name="background_type" onclick="option('custom','background')" value="custom"  @if($layout['background_type'] == 'custom') checked @endif>自訂背景
                        </td>
                    </tr>

                    <tr id="background_tr">
                        <th>背景：</th>
                        <td id="background">

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

        option("{{$layout['background_type']}}",'background');

        function option(obj,id) {

            if(obj == 'custom'){
                $('#'+id+'').html('');
                $('#'+id+'').html("<div>選項(建議尺寸): "+uploadifive_build(timestamp,csrf_token,upload_url,upload_js,upload_css,name,'_'+id)+"</div>");
            }else{
                $('#'+id+'').html('');
                $('#'+id+'').html("<div>選項: <input type='text' size='40' name='"+id+"' value='{{$layout['background']}}'></div>");
            }
        }

    </script>
@endsection