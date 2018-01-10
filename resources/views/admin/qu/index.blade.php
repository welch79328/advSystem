@extends('layouts.qu.admin')

@section('content')
	<!--头部 开始-->
	<div class="top_box">
		<div class="top_left">
			<div class="logo">Questionnaire System</div>
			<ul>
				{{--<li><a href="{{url('/')}}" target="_blank" class="active">{{trans('Backstage.nav.Home')}}</a></li>--}}
				<li><a href="{{url('qu/admin/info')}}" target="main">{{trans('Backstage.nav.Management page')}}</a></li>
			</ul>
		</div>
		<div class="top_right">
			<ul>
				<li>{{session('user_name')}} Welcome</li>
				<li><a href="{{url('qu/admin/quit')}}">Logout</a></li>
			</ul>
		</div>
	</div>
	<!--头部 结束-->

	<!--左侧导航 开始-->
	<div class="menu_box">
		<ul>
			<li>
				<h3><i class="fa fa-fw fa-clipboard"></i>{{trans('Backstage.nav.Management')}}</h3>
				<ul class="sub_menu">
					{{--<li><a href="{{url('admin/user')}}" target="main"><i class="fa fa-fw fa-square"></i>{{trans('Backstage.nav.User')}}</a></li>--}}
					{{--<li><a href="{{url('admin/category')}}" target="main"><i class="fa fa-fw fa-square"></i>{{trans('Backstage.nav.Category')}}</a></li>--}}
					<li><a href="{{url('qu/admin/questionnaire')}}" target="main"><i class="fa fa-fw fa-square"></i>問卷管理</a></li>
					<li><a href="{{url('qu/admin/gift')}}" target="main"><i class="fa fa-fw fa-square"></i>禮品管理</a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-clipboard"></i>{{trans('Backstage.nav.Report')}}</h3>
				<ul class="sub_menu">
					<li><a href="{{url('qu/admin/report')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>{{trans('Backstage.nav.CountReport')}}</a></li>
				</ul>
			</li>
            <li>
            	<h3><i class="fa fa-fw fa-cog"></i>系统设置</h3>
                <ul class="sub_menu" style="display: block;">
					{{--<li><a href="{{url('admin/config')}}" target="main"><i class="fa fa-fw fa-cogs"></i>網站配置</a></li>--}}
					<li><a href="{{url('qu/admin/layout/demo')}}" target="main"><i class="fa fa-fw fa-cogs"></i>版面配置</a></li>
					{{--<li><a href="{{url('admin/navs')}}" target="main"><i class="fa fa-fw fa-navicon"></i>自定義登入紐</a></li>--}}
                </ul>
            </li>
            {{--<li>--}}
            	{{--<h3><i class="fa fa-fw fa-thumb-tack"></i>工具导航</h3>--}}
                {{--<ul class="sub_menu">--}}
                    {{--<li><a href="http://www.yeahzan.com/fa/facss.html" target="main"><i class="fa fa-fw fa-font"></i>图标调用</a></li>--}}
                    {{--<li><a href="http://hemin.cn/jq/cheatsheet.html" target="main"><i class="fa fa-fw fa-chain"></i>Jquery手册</a></li>--}}
                    {{--<li><a href="http://tool.c7sky.com/webcolor/" target="main"><i class="fa fa-fw fa-tachometer"></i>配色板</a></li>--}}
                    {{--<li><a href="element.html" target="main"><i class="fa fa-fw fa-tags"></i>其他组件</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        </ul>
	</div>
	<!--左侧导航 结束-->

	<!--主体部分 开始-->
	<div class="main_box">
		<iframe src="{{url('qu/admin/info')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
	</div>
	<!--主体部分 结束-->

	<!--底部 开始-->
	<div class="bottom_box">
		CopyRight © 2015. Powered By <a href="http://www.houdunwang.com">http://www.houdunwang.com</a>.
	</div>
	<!--底部 结束-->
@endsection