<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/qu/sumbit.css')}}">
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
</head>
<body>
    <header><img src="{{asset('img/qu/banner-thankyou.jpg')}}" style="width: 100%;"></header>
    <div class="row">
        <div class="col-sm-2 col-2"></div>
        <div class="col-sm-8 col-8" id="main">
            <h1>感謝您的填寫,稍後即發送禮卷給您</h1>
            <div class="progress">
                <div class="progress-bar bg-danger progress-bar-striped" style="width:0%"></div>
            </div>
        </div>
        <div class="col-sm-2 col-2"></div>
    </div>
    <footer></footer>
    <form name="redirect"  action = "{{$location}}"   method ="POST">
        {{csrf_field()}}
        <input type="hidden" name="rid" value="{{$input['rid']}}">
        <input type="hidden" name="mac" value="{{$input['mac']}}">
        <input type="hidden" name="ip" value="{{$input['ip']}}">
        <input type="hidden" name="orig_url" value="" id="{{$input['orig_url']}}">
        <input type="hidden" name="advSystem" value="{{$input["advSystem"]}}">
        <input type="hidden" name="linkloginonly" value="{{$input['linkloginonly']}}">
        <input type="hidden" name="router_version" value="{{$input['router_version']}}">
        <input type="hidden" name="chapchallenge" value="{{$input['chapchallenge']}}">
        <input type="hidden" name="ad_sort" value="{{$input['ad_sort']}}">
        <input type="hidden" name="isreload" value="true">
        {{--<input type="hidden" name="action_array" value="{{$input['action_array']}}">--}}
    </form>
    <script>
        setTimeout("progress(20)",1000);
        setTimeout("progress(40)",2000);
        setTimeout("progress(60)",3000);
        setTimeout("progress(80)",4000);
        setTimeout("progress(100)",5000);
        setTimeout("window.redirect.submit()",5000);

        function progress(number) {
            $('.progress-bar-striped').attr('style','width:'+number+'%')
        }
//        window.redirect.submit();
    </script>
</body>
