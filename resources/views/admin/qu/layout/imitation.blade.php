<html>
<head>
    <meta charset="utf-8">
    <meta name="author" content="http://www.adwifi.com.tw"/>
</head>
<body>
<form name  = "redirect" method = "post" action = "{{$location}}">
    <input type="hidden" name="index-page" value="start">
    <input type="hidden" name="mac" value="08:00:20:0A:8C:6F">
    <input type="hidden" name="linkloginonly" value="hotspot/login/final">
    <input type="hidden" name="ip" value="192.168.50.25">
    <input type="hidden" name="chapchallenge" value="">
    <input type="hidden" name="rid" value="{{$rid}}">
    <input type="hidden" name="router_version" value="0">
    <input type="hidden" name="link_login" value="link_login">
</form>
<script>
    window.redirect.submit();
</script>
</body>
</html>