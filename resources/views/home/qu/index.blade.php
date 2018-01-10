<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('css/qu/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/qu/home.css')}}">
    <script src="{{asset('js/qu/jquery-3.1.1.slim.min.js')}}"></script>
    <script src="{{asset('js/qu/tether.min.js')}}"></script>
    <script src="{{asset('js/qu/bootstrap.min.js')}}"></script>
    <style>
        body{
            @if($layout['background_type'] == 'plain') background-color: {{$layout['background']}};
            @elseif($layout['background_type'] == 'custom') background-image: url({{asset($layout['background'])}}); background-size:cover;
            @endif
        }
        .list-group-item{
            @if($layout['background_type'] == 'plain') background-color: {{$layout['background']}};
            @endif
            font-size:{{$layout['option_size']}}px; color:{{$layout['option_colour']}};
        }
    </style>
</head>
<body >
    <header><h1 style="font-size:{{$layout['title_size']}}px; color:{{$layout['title_colour']}};">{{$layout['title_name']}}</h1><h4 style="font-size:{{$layout['subtitle_size']}}px; color:{{$layout['subtitle_colour']}};">{{$layout['subtitle_name']}}</h4></header>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <form action="{{url('qu/submit')}}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="rid" value="{{$input['rid']}}">
                <input type="hidden" name="mac" value="{{$input['mac']}}">
                {{--<input type="hidden" name="ad_type" value="{{$portalCache['ad_type']}}">--}}
                <input type="hidden" name="linkloginonly" value="{{$input['linkloginonly']}}">
                <input type="hidden" name="chapchallenge" value="{{$input['chapchallenge']}}">
                <input type="hidden" name="router_version" value="{{$input['router_version']}}">
                <input type="hidden" name="ip" value="{{$input['ip']}}">
                <input type="hidden" name="link_login" value="{{$input['link_login']}}">
                <input type="hidden" name="gi_id" value="{{$data['gi_id']}}">
                <?php
                $subject_amount = $qu['subject_amount']; //
                for($r=1;$r<=$subject_amount;$r++){
                ?>
                    <div id="topic_group">
                        @if($data['topic_name_'.$r] == 'text')
                            <h4 id="topic" style="font-size:{{$layout['topic_size']}}px; color:{{$layout['topic_colour']}};">{{$r}}. {{$data['option_topic_value_'.$r]}}</h4>
                        @elseif($data['topic_name_'.$r] == 'img')

                        @endif
                            {{--@if($data['topic_need_'.$r] == 'important')--}}
                                {{--<input type="hidden" name="index_type{{$r}}_important[]">--}}
                            {{--@endif--}}
                        <ul class="list-group">
                            <?php
                            $advI = $data['option_amount_'.$r]; //
                            for($i=1;$i<=$advI;$i++){
                            ?>
                            @if($data['option_name_'.$r] == 'text')
                                <li id="option_li" class="list-group-item"><input type="{{$data['topic_select_'.$r]}}" class="option" name="index_type{{$r}}@if($data['topic_need_'.$r] == 'important')_important[]@else[]@endif" onclick="showTr()" value="{{$data['option_option_value_'.$r.'_'.$i]}}">{{$data['option_option_value_'.$r.'_'.$i]}}</li>
                            @elseif($data['option_name_'.$r] == 'img')

                            @endif
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>


                <div id="topic_group_bottom">
                    <h4 id="topic_email" style="font-size:{{$layout['topic_size']}}px; color:{{$layout['topic_colour']}};">5. 請輸入您的email</h4><h6 style="font-size:{{$layout['option_size']}}px; color:{{$layout['option_colour']}};">輸入您的電子信箱,兌換卷立刻寄給您</h6>
                    <input type="text" name="qu_email" style="background-color:transparent;border:none;border-bottom:1px solid #9e9e9e;border-radius:0;outline:none; width: 100%;">
                </div>

                <div id="topic_group_bottom">
                    <div class="row">
                        <div class="col-6"><input type="submit" style="position:absolute;  right: 10%; width: 50%;" class="btn btn-primary" value="問卷送出"></div>
                        <div class="col-6"> <input type="button" style="position:absolute;  left:  10%; width: 50%;"  class="btn btn-primary" onclick="adv_redirect()" value="略過看廣告"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-2"></div>
    </div>
    <footer></footer>
    <script>
        <?php
         $location = Config::get('qu.default.qu_location_adv');
        ?>

        function adv_redirect() {
            location.href = "{{$location}}?rid={{$input['rid']}}&mac={{$input['mac']}}&ip={{$input['ip']}}&linkloginonly={{$input['linkloginonly']}}&chapchallenge={{$input['chapchallenge']}}&router_version={{$input['router_version']}}&link_login={{$input['link_login']}}";
        }
    </script>
</body>
