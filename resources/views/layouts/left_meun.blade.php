<div class="sidebar-nav">
    <div class="nav-canvas">
        <div class="nav-sm nav nav-stacked">

        </div>
        <ul class="nav nav-pills nav-stacked main-menu">
            <li class="nav-header">功能列表 (Menu List)</li>


            <li @if($act == 2) class="accordion active" @else class="accordion" @endif>
                <a href="javascript:;"><i class="glyphicon glyphicon-user"></i><span> 帳號管理 (Account Management)</span></a>
                <ul class="nav nav-pills nav-stacked">
                    @if(session('ma_level')!='view')
                    <li><a href="{{url('admin/index/2')}}">帳號列表 (Accoun List)</a></li>
                    @endif
                    @if(session('ma_level')=='root')
                    <li><a href="{{url('admin/point/2')}}">點數列表 (Points List)</a></li>
                    @endif
                    <li><a href="{{url('admin/log/2')}}">登入記錄 (Sign Recorded)</a></li>
                </ul>
            </li>

            @if(session('ma_level')=='admin')
            <li @if($act == 3)class="accordion active" @else class="accordion" @endif>
                <a href="javascript:;"><i class="glyphicon glyphicon-th"></i><span> 點數管理 (Points Management)</span></a>
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="{{url('admin/point_gift/3')}}">點數儲值 (Points Gift)</a></li>
                    @if(session('ma_level')=='admin')
                    <li><a href="{{url('admin/point2/3')}}">點數列表 (Points List)</a></li>
                    @endif
                </ul>
            </li>
            @endif

            <li @if($act == 4) class="accordion active" @else class="accordion" @endif>
                <a href="javascript:;"><i class="glyphicon glyphicon-film"></i><span> 廣告管理 (Ad Manager)</span></a>
                <ul class="nav nav-pills nav-stacked">
                    @if(session('ma_level')=='admin')
                    <li><a href="{{url('admin/class/4')}}">廣告類型列表 (Ad Type List)</a></li>
                    @endif
                    @if(session('ma_level')!='admin')
                    <li><a href="{{url('admin/banner/4')}}">廣告列表 (Ad List)</a></li>
                    @endif
                </ul>
            </li>

        <!--

                -->

            @if(session('ma_level')!='admin')
            <li  @if($act == 6) class="active" @endif >
                <a class="ajax-link" href="export.php?act=6">
                    <i class="glyphicon glyphicon-list-alt"></i>
                    <span> 點數報表 (Points Report)</span>
                </a>
            </li>
            @endif


            <li @if($act == 7) class="accordion active" @else class="accordion" @endif>
                <a href="javascript:;"><i class="glyphicon glyphicon-print"></i><span> 廣告報表 (Ad Report)</span></a>
                <ul class="nav nav-pills nav-stacked">
                @if(session('ma_level')=='admin')
                <!--<li><a href="ad_st.php?act=7">廣告總表 (Ad Summary Report)</a></li>-->
                    <!--<li><a href="ad_ir.php?act=7">收溢報表 (Income Report)</a></li>-->
                @endif
                    <li><a href="ad_et.php?act=7">廣告報表 (Ad Report)</a></li>
                </ul>
            </li>



    </div>
</div>