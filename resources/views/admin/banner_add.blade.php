@extends('layouts.admin')

@section('css')
    <link href="{{asset('css/other.css')}}" rel="stylesheet">
    <link href='{{asset('jquery-ui/jquery-ui.min.css')}}' rel='stylesheet'>
    <style>
        .ui-datepicker-month {
            color:#000;
        }
        .ui-datepicker-year {
            color:#000;
        }

        .form-control2 {
            display: block;
            width: 50%;
            height: 38px;
            padding: 8px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555555;
            background-color: #ffffff;
            background-image: none;
            border: 1px solid #cccccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
            box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
            -webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            float:left;
            margin-right: 10px;
        }


    </style>
@endsection

@section('js')
    <script type="text/javascript" src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('bower_components/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.validate.js')}}"></script>
    <script src="{{asset('js/additional-methods.min.js')}}"></script>
    <script src="{{asset('js/messages_zh_TW.js')}}"></script>
    <script src="{{asset('js/jquery.blockUI.js')}}"></script>
    <script src="{{asset('jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/input.js')}}"></script>
    <script src="{{asset('js/open_menu.js')}}"></script>
    <script src="{{asset('js/style.js')}}"></script>

    <script type="text/javascript">
        $(function(){


            $("#form1").submit(function(e){

                var ha = $("#ha").html();

                if(ha=='') {
                    $("#haer").html("必填");
                    return false;
                }else {
                    $("#haer").html("");
                }

                var hah;

                $(".hck").each(function(){

                    var name = $(this).attr('name');

                    if(typeof(name) !== 'undefined') {

                        hah += name+',';

                    }

                });

                $("#hah").val(hah);

            });


            $("#ckeditor").hide();

            $("#sh").click(function(){
                $("#ckeditor").toggle(1000);
            });


            //設定中文語系
            $.datepicker.regional['zh-TW']={
                dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
                dayNamesMin:["日","一","二","三","四","五","六"],
                monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
                monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
                prevText:"上月",
                nextText:"次月",
                weekHeader:"週"
            };

            $.datepicker.setDefaults({ dateFormat: 'yy-mm-dd' });
            $.datepicker.setDefaults($.datepicker.regional["zh-TW"]);

            var today = new Date();
            var tomorrow = new Date(today.getTime() + 24 * 60 * 60 * 1000);

            $('#a_e_period').datepicker();
            $('#a_s_period').datepicker({
//                minDate: 0, //從今天後日期才可選
//                minDate: tomorrow, //從明天日期才可選
                onSelect: function (dat, inst) {
                    $('#end').datepicker('option', 'minDate', dat);
                }
            });

//            $("#a_s_period").datepicker({
//                dateFormat: "yy-mm-dd",
//                changeYear : true,
//                changeMonth : true,
//                showOn: "button",
//                buttonImage: "img/calendar.gif",
//                buttonImageOnly: true,
//                buttonText: "選擇日期",
//                beforeShow:customerRange
//            }).attr("readonly", "readonly");
//
//
//            $("#a_e_period").datepicker({
//                dateFormat: "yy-mm-dd",
//                changeYear : true,
//                changeMonth : true,
//                showOn: "button",
//                buttonImage: "img/calendar.gif",
//                buttonImageOnly: true,
//                buttonText: "選擇日期",
//                beforeShow:customerRange
//            }).attr("readonly", "readonly");


            function customerRange(input){
                return {minDate:(input.id == "a_e_period" ? $("#a_s_period").datepicker("getDate") : 0),maxDate:(input.id == "a_s_period" ? $("#a_e_period").datepicker("getDate") : null)};
            }

            /* 檢查是否已存在 */
            jQuery.validator.addMethod("cn", function(value, element) {

                $.ajax({
                    url: "check_name.php",
                    data: $('#form1').serialize(),
                    type:"POST",
                    dataType:'text',

                    success: function(msg){

                        msg2 = Number(msg);

                    }

                });

                if(msg2==0) {
                    return true;
                }else {
                    return false;
                }

            }, "廣告名稱不可重複");


            $("#form1").validate({
                rules: {
                    a_pq: {
                        digits: true,
                        max: '{{$total}}'
                    },
                    a_name: {
                        required: true,
                        cn: '$("#a_name").val();'
                    },
                    a_img: {
                        required: true,
                        extension: "jpg|png|gif"
                    },
                    a_video: {
                        required: true
                    },
                    a_default: {
                        required: true,
                        url:true
                    },
                    a_add: {
                        required: true
                    }
                },
                submitHandler:function(form){

                    $.blockUI({ message: '<h1><img src="img/busy.gif" /> 新增中，請稍候...</h1>' });
                    setTimeout(function() {
                        form.submit();
                    }, 1000);

                }
            });
        });
    </script>
@endsection

@section('content')
    <div id="content" class="col-lg-9 col-sm-9">
        <!-- content starts -->
        <div>
            <ul class="breadcrumb">
                <li>
                    <a href="javascript:;">廣告管理 (Ad Manager) </a>
                </li>
                <li>
                    <a href="{{url('admin/banner/4')}}">廣告列表 (Ad List)</a>
                </li>
                <li>
                    <a href="javascript:;">新增廣告 (New Ad)</a>
                </li>
            </ul>
        </div>

        <!--/row-->

        <div class="row">
            <div class="box col-md-12">
                <div class="box-inner">
                    <div class="box-header well" data-original-title="">
                        <h2><i class="glyphicon glyphicon-edit"></i> 新增廣告 (New Ad)</h2>
                    </div>
                    <div class="box-content">
                        <form action="{{url('admin/banner_deal_with')}}" method="post" enctype="multipart/form-data" id="form1" name="form1" role="form">
                            {{csrf_field()}}
                            <input name="act" type="hidden" id="act" value="inst">
                            <div class="form-group">
                                <label for="s_id">前台頁面模版 (Front Page Template)</label><br />
                                <select name="s_id" id="s_id" class="form-control3">
                                    @foreach($style as $v)
                                    <option value="{{$v->s_id}}">{{$v->s_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br /><br />

                            <!-- 檢視帳號 //-->
                            @if(session('ma_level') == 'root')
                            <div class="form-group">
                                <label for="av">檢視帳號 (View Account)</label><br />
                                @foreach($myadmin as $v)
                                <input name="av[]" type="checkbox" value="{{$v->ma_user}}">
                                <label for="av[]">{{$v->ma_name}}</label>
                                @endforeach
                            </div>
                            @endif
                        <!-- 檢視帳號 //-->
                            <div class="form-group">
                                <label for="a_name">廣告名稱 (Ad Name)</label>
                                <input name="a_name" type="text" class="form-control" id="a_name" placeholder="廣告名稱 (Ad Name)">
                            </div>
                            <div class="form-group">
                                <label for="a_type">廣告類型 (Ad Type)</label><br />
                                <span id="at1">
                      <input type="radio" name="a_type" id="a_type1" class="tt" value="1" checked="CHECKED">圖片 (Image)</span>
                                <span id="at2">
                      <input type="radio" name="a_type" id="a_type2" class="tt" value="2">影片 (Video)
                      </span>
                            </div>
                            <div class="form-group">
                                <label for="a_type">廣告性別類型 (Ad gender Type)</label><br />
                                <span>
                      <input type="radio" name="gender_type"  value="public" checked>大眾 (public)</span>
                                <span>
                      <input type="radio" name="gender_type"  value="man">男生 (man)
                      </span>
                                <span>
                      <input type="radio" name="gender_type"  value="women">女生 (women)
                      </span>
                            </div>
                            <div class="form-group" id="tw_im">
                                <label for="a_img">圖片上傳 (Upload Picture)</label>
                                <input type="hidden" size="50" name="a_img" value="">
                                <input id="file_upload" name="file_upload" type="file">
                                {{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>--}}
                                <script src="{{asset('org/uploadifive/jquery.uploadifive.js')}}" type="text/javascript"></script>
                                <link rel="stylesheet" type="text/css" href="{{asset('org/uploadifive/uploadifive.css')}}">
                                <script type="text/javascript">
                                    <?php $timestamp = time();?>
                                    $(function() {
                                        $('#file_upload').uploadifive({
                                            'formData'     : {
                                                'timestamp' : '<?php echo $timestamp;?>',
                                                '_token'     : '{{csrf_token()}}'
                                            },
                                            'uploadScript' : '{{url('admin/upload')}}',
                                            'onUploadComplete' : function(file, data) {
                                                $('input[name = a_img]').val(data);
                                                $('#a_image_show').attr('src','/'.data);
                                            }
                                        });
                                    });
                                </script>
                                <style>
                                    .uploadifive{display:inline-block;}
                                    .uploadifive-button{border:none; border-radius:5px; margin-top:8px;}
                                    table.add_tab tr td span.uploadifive-button-text{color: #FFFFFF; margin: 0;}
                                </style>
                                <p class="help-block">僅支援JPG、PNG、GIF檔上傳。 (Support only JPG, PNG, GIF files to upload.)</p>
                            </div>
                            <div class="form-group" id="tw_yu">
                                <label for="a_video">Youtube分享網址 (Youtube URL)</label><br />
                                <textarea name="a_video" rows="6" CLASS="form-control" id="a_video" placeholder="例:https://www.youtube.com/watch?v=UvzlNVVyiNM"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="a_ad">廣告文稿 (Advertising Documents)</label>
                                <input type="button" name="sh" id="sh" value="顯示 / 隱藏">
                                <br />
                                <div id="ckeditor">
                                    <textarea name="a_ad" rows="6" CLASS="form-control ckeditor" id="a_ad"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="a_default">預設認證後網址 (Default URL After Authentication)</label>
                                <input name="a_default" type="text" class="form-control" id="a_default" placeholder="預設認證後網址 (Default URL After Authentication)">
                            </div>
                            <div class="form-group">
                                <label for="a_android">Android認證後網址 (Android URL After Authentication)</label>
                                <input name="a_android" type="text" class="form-control" id="a_android" placeholder="Android認證後網址 (Android URL After Authentication)">
                            </div>
                            <div class="form-group">
                                <label for="a_ios">IOS認證後網址 IOS URL After Authentication)</label>
                                <input name="a_ios" type="text" class="form-control" id="a_ios" placeholder="IOS認證後網址 (IOS URL After Authentication)">
                            </div>
                            <div class="form-group">
                                <label for="a_s_period">開始期間 (Start Date)</label><br />
                                <input name="a_s_period" type="text" class="form-control2" id="a_s_period" placeholder="YYYY-MM-DD" readonly>
                            </div>
                            <p>&nbsp;</p>
                            <div class="form-group">
                                <label for="a_e_period">結束期間 (End Date)</label><br />
                                <input name="a_e_period" type="text" class="form-control2" id="a_e_period" placeholder="YYYY-MM-DD" readonly>
                            </div>

                            <!-- 扣點方式類別 //-->
                            <p>&nbsp;</p>
                            <div class="form-group">
                                <label for="a_mode">扣點方式 (Mode)</label><br />
                                {{--<input type="radio" name="a_mode" id="a_mode" value="0" title="會扣點數本額">--}}
                                {{--<label for="a_mode">可用點數 (Points Available)</label>--}}
                                <input name="a_mode" type="radio" id="a_mode2" value="1" title="會扣廣告分配的點數配額"  checked="CHECKED">
                                <label for="a_mode2">點數配額 (Points Quota)</label>
                            </div>

                            <div class="form-group">
                                <label for="a_pq">點數配額 (Points Quota)</label>&nbsp;&nbsp;
                                <span class="red_str">已分配點數 (Assigned Points)：{{$allocation_total}}</span>&nbsp;&nbsp;
                                <span class="blue_str">可用點數 (Points Available)：{{$total}}</span>
                                <input name="a_pq" type="text" class="form-control2" id="a_pq" placeholder="點數配額 (Points Quota)">
                            </div>
                            <div class="form-group">
                                <label for="a_status">狀態 Status)</label><br />
                                <input type="radio" name="a_status" id="a_status" value="1">
                                <label for="a_status">上架 (Start)</label>
                                <input name="a_status" type="radio" id="a_status2" value="0" checked="CHECKED">
                                <label for="a_status2">下架 (Stop)</label>
                            </div>
                            <p>&nbsp;</p>
                            <div class="form-group" id="gadd">
                                <label for="a_add">播放地點 (Playback Locations)</label>
                                <input type="hidden" name="hah" id="hah">
                                <br />
                                <div id="ha" class="form-control4" style="min-height: 100px;  height: auto;"></div><span id="haer" class="error"></span>
                                @foreach($hotspots_swarm as $v)
                                <span id="{{$v->swarmId}}" class="open_menu">
                    <input name="a_add[]" type="checkbox" id="{{$v->swarmId}}" value="{{$v->swarmId}}">{{$v->swarmName}}
                    </span>

                                <!-- 選單載入的部分開始 //-->
                                <div id="rn{{$v->swarmId}}" class="rn">
                                    <p class="pop_close">
                                        <span class="pg">地點群族選單</span>
                                        <span class="pc" name="{{$v->swarmId}}">
                      <img src="{{asset('img/icon_close.gif')}}" />
                      </span>
                                    </p>

                                    <p class="pop_content">
                                        <?php
                                        $hotspots_swarmlist = \App\Http\Model\Hotspots_Swarmlist::join('hotspots','hotspots_swarmlist.rid','=','hotspots.rid')->where('hotspots_swarmlist.swarmId',$v->swarmId)->get();
                                        ?>
                                        @foreach($hotspots_swarmlist as $q)
                                        <input name="rid[{{$v->swarmId}}]" type="checkbox" class="rid{{$q->swarmId}} ridc" value="{{$q->rid}}" title="{{$q->aliasName}}">{{$q->aliasName}}&nbsp;&nbsp;
                                        @endforeach
                                    <!-- 選單載入的部分結束 //-->
                                    </p>
                                </div>
                                @endforeach

                            </div>


                            <!-- 單選區域開始 //-->
                            {{--<div class="form-group">--}}
                                {{--@foreach($hotspots as $v)--}}
                                {{--<span id="rid{{$v->rid}}">--}}
                                {{--<input name="rid2[{{$v->rid}}]" type="checkbox" class="rid{{$v->rid}} ridc2" value="{{$v->rid}}" title="{{$v->aliasName}}">{{$v->aliasName}}&nbsp;&nbsp;--}}
                                {{--</span>--}}
                                {{--@endforeach--}}
                            {{--</div>--}}
                            <!-- 單選區域開始 //-->




                            <button type="submit" class="btn btn-default">新增廣告 (New Ad)</button>
                            <button type="button" class="btn btn-default" style="margin-left:10px;" onclick="history.back()">回上一頁 ( Back)</button>

                        </form>

                    </div>
                </div>
            </div>
            <!--/span-->

        </div><!--/row-->

        <!-- content ends -->
    </div><!--/#content.col-md-0-->
    </div><!--/fluid-row-->

    <!-- Ad, you can remove it -->
    <div class="row"></div>
    <!-- Ad ends -->
@endsection