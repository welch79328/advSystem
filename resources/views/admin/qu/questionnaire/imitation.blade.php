<html>
<head>
    <meta charset="utf-8">
    <meta name="author" content="http://www.adwifi.com.tw"/>
</head>
<body>
<form name  = "redirect" method = "post" action = "{{url('wifi/auto/web/index.php')}}">
    <input type="hidden" name="index-page" value="start">
    <input type="hidden" name="mac" value="08:00:20:0A:8C:6F">
    <input type="hidden" name="client_mac" value="08:00:20:0A:8C:6F">
    <input type="hidden" name="ip" value="192.168.50.25">
    <input type="hidden" name="link-login-only" value="final.php">
    <input type="hidden" name="server-name" value="{{$serverName}}">
</form>
<script>
    window.redirect.submit();
</script>
</body>
</html>