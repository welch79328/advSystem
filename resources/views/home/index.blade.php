<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,
    user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="http://www.adwifi.com.tw/" />
    <script type="text/javascript" src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    {{--<script type="text/javascript" src="youtube.js"></script>--}}
    <title>API for ADWi-Fi</title>
    <script type="text/javascript">



        //================================================================
        function returnMessage(link, action){
            var msg = {
                'method'   : 'adwifi_EventTrigger',
                'url'      : link,
                'platform' : 'ADING',
                'key'      : 'fa06f943b12740bf60e15927265e40c2',
                'action'   : action
            };

            parent.postMessage(msg, "*");//Send message to parent page.
        }

        function displayLayout(obj) {

            var msg = {
                'method'   : 'adwifi_DispalyLayout',
                'height'   : obj.height | 3,
                'width'    : obj.width  | 2,
                'url'       :'{{$url}}',
                'type'     : '{{$ad_type}}',
                'platform' : 'ADING',
                'action'   : 'show',
                'key'      : 'fa06f943b12740bf60e15927265e40c2'
            };

            parent.postMessage(msg, "*");//Send message to parent page.
        }

        /* 傳點擊圖後參數 */

        function once(fn, context) {
            var result;

            return function() {
                if(fn) {
                    result = fn.apply(context || this, arguments);
                    fn = null;
                }

                return result;
            };
        }

        // Usage
        var returnPoint = once(function(ad_id, ad_mac, ad_site, ad_type, ad_rid, ad_action, ad_link) {
            canOnlyFireOnce(ad_id, ad_mac, ad_site, ad_type, ad_rid, ad_action, ad_link);
        });

        function canOnlyFireOnce(ad_id, ad_mac, ad_site, ad_type, ad_rid, ad_action, ad_link){

            $.get("{{url('point')}}", {'_token':"{{csrf_token()}}", 'a_id': ad_id, 'mac': ad_mac, 'site': ad_site, 'type': ad_type, 'rid': ad_rid, 'action': ad_action},
                function(data){

                    var msg = {
                        'method'   : 'adwifi_EventTrigger',
                        'url'      : ad_link,
                        'platform' : 'ADING',
                        'key'      : 'fa06f943b12740bf60e15927265e40c2',
                        'action'   : ad_action
                    };

                    parent.postMessage(msg, "*");//Send message to parent page.

                });

            /* 直接導連出去 */
            $.get("{{url('point')}}", {'_token':"{{csrf_token()}}", 'a_id': ad_id, 'mac': ad_mac, 'site': ad_site, 'type': ad_type, 'rid': ad_rid, 'action': 'redirect'},
                function(data){

                    var msg = {
                        'method'   : 'adwifi_EventTrigger',
                        'url'      : '{{$url}}',
                        'platform' : 'ADING',
                        'key'      : 'fa06f943b12740bf60e15927265e40c2',
                        'action'   : 'auth'
                    };

                    parent.postMessage(msg, "*");//Send message to parent page.

                    {{--location.href = '{{$url}}';--}}

                });

        }

    </script>
</head>
<body>
<div id="wrapper">

    {{--@if($ad_type=="youtube")--}}
    {{--<div id="youtube"></div><script>--}}
        {{--setTimeout('youtubestop();', 15000);--}}

        {{--function youtubestop(){--}}
            {{--//function (res) {--}}
            {{--$.get("{{url('point')}}", { a_id: "{{$ad_row->a_id}}", mac: "{{$input['ad_mac']}}", site: "{{$ad_hsname}}", type: "{{$input['ad_type']}}", rid: "{{$input['ad_rid']}}", action: "final-youtube" },--}}
                {{--function(data){--}}

                    {{--var msg = {--}}
                        {{--'method'   : 'adwifi_EventTrigger',--}}
                        {{--'url'      : '{{$url}}',--}}
                        {{--'platform' : 'ADING',--}}
                        {{--'key'      : 'fa06f943b12740bf60e15927265e40c2',--}}
                        {{--'action'   : 'final-youtube'--}}
                    {{--};--}}

                    {{--parent.postMessage(msg, "*");//Send message to parent page.--}}

                {{--});--}}

            {{--/* 直接導連出去 	*/--}}
            {{--$.get("{{url('point')}}", { a_id: "{{$ad_row->a_id}}", mac: "{{$input['ad_mac']}}", site: "{{$ad_hsname}}", type: "{{$input['ad_type']}}", rid: "{{$input['ad_rid']}}", action: 'redirect'},--}}

                {{--function(data){--}}

                    {{--var msg = {--}}
                        {{--'method'   : 'adwifi_EventTrigger',--}}
                        {{--'url'      : '{{$url}}',--}}
                        {{--'platform' : 'ADING',--}}
                        {{--'key'      : 'fa06f943b12740bf60e15927265e40c2',--}}
                        {{--'action'   : 'auth'--}}
                    {{--};--}}

                    {{--parent.postMessage(msg, "*");//Send message to parent page.--}}

                    {{--location.href = '{{$url}}';--}}

                {{--});--}}

            {{--//}--}}
        {{--}</script>--}}
    {{--@else--}}
    {!!$ad!!}
<!-- <div id="banner"></div> //-->
    {{--@endif--}}
</div>
</body>
</html>
<script>
    //Base parameter.
    var Info = {
        "server-name" : "{{$ad_hsname}}",
        "mac"         : "{{$input['ad_mac']}}",
        "type"        : "{{$ad_type}}"
    }//end

    //Get page Height and Width.
    function getHeight(id, type) {

        var wdth   = $(window).width();
        var height = $(window).height();

        if(type=="video") {
            height = 270;
        }

        var obj = {
            height : height,
            width  : wdth
        }
        return obj;
    }


    /* Onload event. */
    window.onload = function() {
        //Post message to parent iframe.
        var obj = getHeight("wrapper","{{$ad_type}}");
        displayLayout(obj);

        //Save record.
        switch (Info["type"]) {//From adversiting database.
            case "video":
                {{--var player = new youtube({--}}
                    {{--elementId : "youtube",--}}
                    {{--youtubeId : "{{$yad}}",//From database.--}}
                    {{--start     :--}}
                        {{--function (res) {--}}

                            {{--$.get("{{url('point')}}", { a_id: "{{$ad_row['a_id']}}", mac: "{{$input['ad_mac']}}", site: "{{$ad_hsname}}", type: "{{$input['ad_type']}}", rid: "{{$input['ad_rid']}}", action: "start-youtube" },--}}
                                {{--function(data){--}}

                                    {{--var msg = {--}}
                                        {{--'method'   : 'adwifi_EventTrigger',--}}
                                        {{--'url'      : '{{$url}}',--}}
                                        {{--'platform' : 'ADING',--}}
                                        {{--'key'      : 'fa06f943b12740bf60e15927265e40c2',--}}
                                        {{--'action'   : 'start-youtube'--}}
                                    {{--};--}}

                                    {{--parent.postMessage(msg, "*");//Send message to parent page.--}}

                                {{--});--}}

                        {{--},--}}
                    {{--ended     :--}}
                        {{--function (res) {--}}
                            {{--$.get("{{url('point')}}", { a_id: "{{$ad_row['a_id']}}", mac: "{{$input['ad_mac']}}", site: "{{$ad_hsname}}", type: "{{$input['ad_type']}}", rid: "{{$input['ad_rid']}}", action: "final-youtube" },--}}
                                {{--function(data){--}}

                                    {{--var msg = {--}}
                                        {{--'method'   : 'adwifi_EventTrigger',--}}
                                        {{--'url'      : '{{$url}}',--}}
                                        {{--'platform' : 'ADING',--}}
                                        {{--'key'      : 'fa06f943b12740bf60e15927265e40c2',--}}
                                        {{--'action'   : 'final-youtube'--}}
                                    {{--};--}}

                                    {{--parent.postMessage(msg, "*");//Send message to parent page.--}}

                                {{--});--}}

                            {{--/* 直接導連出去 */--}}
                            {{--$.get("{{url('point')}}", { a_id: "{{$ad_row['a_id']}}", mac: "{{$input['ad_mac']}}", site: "{{$ad_hsname}}", type: "{{$input['ad_type']}}", rid: "{{$input['ad_rid']}}", action: 'redirect'},--}}

                                {{--function(data){--}}

                                    {{--var msg = {--}}
                                        {{--'method'   : 'adwifi_EventTrigger',--}}
                                        {{--'url'      : '{{$url}}',--}}
                                        {{--'platform' : 'ADING',--}}
                                        {{--'key'      : 'fa06f943b12740bf60e15927265e40c2',--}}
                                        {{--'action'   : 'auth'--}}
                                    {{--};--}}

                                    {{--parent.postMessage(msg, "*");//Send message to parent page.--}}

                                    {{--location.href = '{{$url}}';--}}

                                {{--});--}}

                        {{--},--}}
                    {{--error     :--}}
                        {{--function() {--}}

                            {{--var msg = {--}}
                                {{--'method'   : 'adwifi_EventTrigger',--}}
                                {{--'url'      : '{{$url}}',--}}
                                {{--'platform' : 'ADING',--}}
                                {{--'key'      : 'fa06f943b12740bf60e15927265e40c2',--}}
                                {{--'action'   : 'error-youtube'--}}
                            {{--};--}}

                            {{--parent.postMessage(msg, "*");//Send message to parent page.--}}

                            {{--window.location.reload();--}}

                        {{--},--}}
                    {{--debugNor  : true//Show debug message.--}}
                {{--});--}}
                $.get("{{url('point')}}", {'_token':"{{csrf_token()}}", a_id: "{{$ad_row['a_id']}}", mac: "{{$input['ad_mac']}}", site: "{{$ad_hsname}}", type: "{{$input['ad_type']}}", rid: "{{$input['ad_rid']}}", action: "view-page" });
                break;

            case "2x3":
                $.get("{{url('point')}}", {'_token':"{{csrf_token()}}", a_id: "{{$ad_row['a_id']}}", mac: "{{$input['ad_mac']}}", site: "{{$ad_hsname}}", type: "{{$input['ad_type']}}", rid: "{{$input['ad_rid']}}", action: "view-page" });
                break;

            case "8x3":
                $.get("{{url('point')}}", {'_token':"{{csrf_token()}}", a_id: "{{$ad_row['a_id']}}", mac: "{{$input['ad_mac']}}", site: "{{$ad_hsname}}", type: "{{$input['ad_type']}}", rid: "{{$input['ad_rid']}}", action: "view-page" });
                break;

        }//endswitch

    }


    function skip(type) {
        returnMessage("", "skip");
    }//End of skip().

</script>