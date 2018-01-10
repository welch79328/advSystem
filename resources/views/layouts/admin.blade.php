<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="utf-8">
    <title>ADWiFi後台管理系統</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ADWiFi後台管理系統">
    <meta name="author" content="ADWiFi後台管理系統">

    <!-- The styles -->
    <link  href="{{asset('css/bootstrap-simplex.min.css')}}" rel="stylesheet">
    <link  href="{{asset('css/bootstrap-cerulean.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/charisma-app.css')}}" rel="stylesheet">
    <link href='{{asset('bower_components/fullcalendar/dist/fullcalendar.css')}}' rel='stylesheet'>
    <link href='{{asset('bower_components/fullcalendar/dist/fullcalendar.print.css')}}' rel='stylesheet' media='print'>
    <link href='{{asset('bower_components/chosen/chosen.min.css')}}' rel='stylesheet'>
    <link href='{{asset('bower_components/colorbox/example3/colorbox.css')}}' rel='stylesheet'>
    <link href='{{asset('bower_components/responsive-tables/responsive-tables.css')}}' rel='stylesheet'>
    <link href='{{asset('bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css')}}' rel='stylesheet'>
    <link href='{{asset('css/jquery.noty.css')}}' rel='stylesheet'>
    <link href='{{asset('css/noty_theme_default.css')}}' rel='stylesheet'>
    <link href='{{asset('css/elfinder.min.css')}}' rel='stylesheet'>
    <link href='{{asset('css/elfinder.theme.css')}}' rel='stylesheet'>
    <link href='{{asset('css/jquery.iphone.toggle.css')}}' rel='stylesheet'>
    <link href='{{asset('css/uploadify.css')}}' rel='stylesheet'>
    <link href='{{asset('css/animate.min.css')}}' rel='stylesheet'>
    <link href='{{asset('css/jquery-impromptu.css')}}' rel='stylesheet'>
    @yield('css')
    <!-- jQuery -->
    <script src="{{asset('bower_components/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery-impromptu.js')}}"></script>
    <script src="{{asset('js/removeUser.js')}}"></script>

    @yield('js')

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">

    <style>
        h3 {
            font-size: 14px;
            text-align: center;
        }

        .td {
            text-align: center;
            padding: 4px;
        }
    </style>

</head>

<body>
<!-- topbar starts -->
@include('layouts.header')
<!-- topbar ends -->
<div class="ch-container">
    <div class="row">

        <!-- left menu starts -->
        <div class="col-sm-3 col-lg-3">
            @include('layouts.left_meun')
        </div>
        <!--/span-->
        <!-- left menu ends -->

        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">警告！!</h4>

                <p>你需要有 <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    才能夠使用這個網站。</p>
            </div>
        </noscript>

@yield('content')


        <hr>
        @include('layouts.footer')
    </div><!--/.fluid-container-->
<!-- external javascript -->

    <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <!-- library for cookie management -->
    <script src="{{asset('js/jquery.cookie.js')}}"></script>
    <!-- calender plugin -->
    <script src='{{asset('bower_components/moment/min/moment.min.js')}}'></script>
    <script src='{{asset('bower_components/fullcalendar/dist/fullcalendar.min.js')}}'></script>
    <!-- data table plugin -->
    <script src='{{asset('js/jquery.dataTables.min.js')}}'></script>

    <!-- select or dropdown enhancer -->
    <script src="{{asset('bower_components/chosen/chosen.jquery.min.js')}}"></script>
    <!-- plugin for gallery image view -->
    <script src="{{asset('bower_components/colorbox/jquery.colorbox-min.js')}}"></script>
    <!-- notification plugin -->
    <script src="{{asset('js/jquery.noty.js')}}"></script>
    <!-- library for making tables responsive -->
    <script src="{{asset('bower_components/responsive-tables/responsive-tables.js')}}"></script>
    <!-- tour plugin -->
    <script src="{{asset('bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js')}}"></script>
    <!-- star rating plugin -->
    <script src="{{asset('js/jquery.raty.min.js')}}"></script>
    <!-- for iOS style toggle switch -->
    <script src="{{asset('js/jquery.iphone.toggle.js')}}"></script>
    <!-- autogrowing textarea plugin -->
    <script src="{{asset('js/jquery.autogrow-textarea.js')}}"></script>
    <!-- multiple file upload plugin -->
    <script src="{{asset('js/jquery.uploadify-3.1.min.js')}}"></script>
    <!-- history.js for cross-browser state change on ajax -->
    <script src="{{asset('js/jquery.history.js')}}"></script>
    <!-- application script for Charisma demo -->
    <script src="{{asset('js/charisma.js')}}"></script>


    </body>
</html>