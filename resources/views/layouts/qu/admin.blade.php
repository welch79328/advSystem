<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('css/qu/ch-ui.admin.css')}}">
    <link rel="stylesheet" href="{{asset('css/qu/font/css/font-awesome.min.css')}}">


    {{--<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>--}}
    <script  src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <script type="text/javascript" src="{{asset('js/qu/ch-ui.admin.js')}}"></script>
    <script type="text/javascript" src="{{asset('org/layer/layer.js')}}"></script>

    @yield('include')
</head>
<body>
@yield('content')
</body>
</html>