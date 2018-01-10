<div class="navbar navbar-default" role="navigation">

    <div class="navbar-inner">
        <button type="button" class="navbar-toggle pull-left animated flip">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{url('admin/index/2')}}"> <img alt="Charisma Logo" src="{{asset('img/logo20.png')}}" class="hidden-xs"/>
            <span>ADWiFi後台管理系統</span></a>

        <!-- user dropdown starts -->
        <div class="btn-group pull-right">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <i class="glyphicon glyphicon-user"></i>
                <span class="hidden-sm hidden-xs">
                    {{session('ma_name').$level}}
                    </span>
                <span class="caret"></span>
            </button>

            <ul class="dropdown-menu">
                <li><a href="up_pass.php">變更密碼 (Update Password)</a></li>
                <li class="divider"></li>
                <li><a href="{{url('admin/logout')}}">登出系統 (Sign out)</a></li>
            </ul>
        </div>

    </div>

</div>