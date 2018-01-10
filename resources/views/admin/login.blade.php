<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="utf-8">
    <title>ADWiFi後台管理系統</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ADWiFi後台管理系統">
    <meta name="author" content="ADWiFi後台管理系統">

    <!-- The styles -->
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
    <link href='{{asset('css/other.css')}}' rel='stylesheet'>
    <style>
        .row {
            margin-left: 0px;
            margin-right: 0px;
        }

        .btn-primary, .btn-primary:hover {
            background-image: -webkit-linear-gradient(#179bd7, #179bd7 6%, #179bd7);
            background-image: -o-linear-gradient(#179bd7, #179bd7 6%, #179bd7);
            background-image: linear-gradient(#179bd7, #179bd7 6%, #179bd7);
            background-repeat: no-repeat;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffe72510', endColorstr='#ffcb210e', GradientType=0);
            filter: none;
            border: 1px solid #179bd7;
        }
    </style>

    <!-- jQuery -->
    <script src="{{asset('bower_components/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.blockUI.js')}}"></script>
    <script src="{{asset('js/jquery.validate.js')}}"></script>
    <script src="{{asset('js/messages_zh_TW.js')}}"></script>

    <script>
        $(function(){

            /* 不以var宣告的變數為全域變數 */
            $("input").focus(function(){
                ph = $(this).attr("placeholder");
                $(this).attr("placeholder","");
            }).blur(function(){
                $(this).attr("placeholder",ph);
            });

            $("#form1").validate({
                rules: {
                    ma_user: {
                        required: true,
                        email:true
                    },
                    ma_pass: {
                        required: true
                    }
                },
                submitHandler:function(form){


                    $.blockUI({ message: '<h1><img src="img/busy.gif" /> 會員登入中，請稍候...</h1>' });

                    $.ajax({
                        url: "{{url('login_deal_with')}}",
                        data: $('#form1').serialize(),
                        type:"POST",
                        dataType:'text',

                        success: function(msg){

                            if(msg != 0) {

                                $.unblockUI();

                                $.blockUI({ message: '<h1><img src="img/busy.gif" /> 會員登入成功...</h1>' });
                                setTimeout(function() {
                                    $.unblockUI();
                                    document.location.href="{{url('admin/index/2')}}";
                                }, 2000);

                            }else {
                                $.unblockUI();

                                $.blockUI({ message: '<h1><img src="img/busy.gif" /> 會員登入失敗，請重新登入...</h1>' });
                                setTimeout(function() {
                                    $.unblockUI();
                                    location.reload();
                                }, 2000);
                            }
                        }
                    });
                }
            });

        });
    </script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="img/favicon.png">

</head>

<body>
<div class="ch-container">
    <div class="row">

        <div class="row">
            <div class="col-md-12 center login-header">
                <h2>ADWiFi後台管理系統</h2>
            </div>
            <!--/span-->
        </div><!--/row-->

        <div class="row">
            <div class="well col-md-5 center login-box">
                <div class="alert alert-info">
                    請輸入您的帳號密碼登入。
                </div>
                <form action="" method="post" class="form-horizontal" id="form1" name="form1">
                    {{csrf_field()}}
                    <fieldset>
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                            <input name="ma_user" type="text" class="form-control" id="ma_user" placeholder="帳號" value="{{\Illuminate\Support\Facades\Cookie::get('ma_user')}}" style="width:90%;">
                        </div>
                        <div class="clearfix"></div><br>

                        <div class="input-group input-group-lg">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                            <input name="ma_pass" type="password" class="form-control" id="ma_pass" placeholder="密碼" value="{{\Illuminate\Support\Facades\Cookie::get('ma_pass')}}" style="width:90%;">
                        </div>
                        <div class="clearfix"></div>

                        <div class="input-prepend">
                            <label class="remember" for="remember"><input name="remember" type="checkbox" id="remember" value="1">
                                記住我的帳號密碼</label>
                        </div>

                        <div class="clearfix"></div>

                        <input name="act" type="hidden" id="act" value="login">
                        <p class="center col-md-5">
                            <button type="submit" class="btn btn-primary">登入</button>
                        </p>
                        <p class="center col-md-5">
                            <span class="btn btn-danger"><a href="send_pass.php" title="忘記密碼">忘記密碼?</a></span>
                        </p>
                    </fieldset>
                </form>
            </div>
            <!--/span-->
        </div><!--/row-->
    </div><!--/fluid-row-->

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

