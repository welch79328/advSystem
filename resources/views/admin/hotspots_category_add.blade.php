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
$(function () {
    $("#search_hotspots").on("keyup", function () {
        var condition = {
            aliasName: $(this).val()
        }
        var sort = {
            aliasName: "ASC"
        }
        $.ajax({
            method: "POST",
            dataType: "json",
            url: "{{url('admin/get_hotspots_array')}}",
            data: {
                "_token": "{{csrf_token()}}",
                "condition": JSON.stringify(condition),
                "sort": JSON.stringify(sort)
            }
        }).done(function (response) {
            $("#checkbox_list").empty();//先清空 
            if (response.length === 0) {
                $("#checkbox_list").html("查無資料！");
                return;
            }

            //建立 全部勾選/取消 的 checkbox
            var div = $('<div />');
            var checbox_all = $('<input />', {
                type: 'checkbox',
                id: "checkbox_all"
            });
            var label = $('<label />', {
                for : "checkbox_all",
                text: "全部勾選/取消"
            });
            checbox_all.on("change", function () {
                if ($(this).is(':checked')) {
                    $("input[type='checkbox'][name='checkbox[]']").prop('checked', true).change();
                } else {
                    $("input[type='checkbox'][name='checkbox[]']").prop('checked', false).change();
                }
            });
            div.appendTo($("#checkbox_list"));
            checbox_all.appendTo(div);
            label.appendTo(div);

            $.each(response, function (index, hotspot) {
                var isChecked = false;
                if ($("#" + hotspot.rid).length) {
                    isChecked = true;
                }
                createCheckboxDiv(hotspot, isChecked);
            })
        });
    });
});

function createCheckboxDiv(hotspot, isChecked) {
    var div = $('<div />');
    var checkbox = $('<input />', {
        type: 'checkbox',
        id: "checkbox" + hotspot.rid,
        name: "checkbox[]",
        checked: isChecked
    });
    var label = $('<label />', {
        for : "checkbox" + hotspot.rid,
        text: hotspot.aliasName
    });
    checkbox.on("change", function () {
        if ($(this).is(':checked') && $("#" + hotspot.rid).length == 0) {
            createCheckedHotspots(hotspot);
        } else if (!$(this).is(':checked') && $("#" + hotspot.rid).length > 0) {
            removeCheckedHotspots(hotspot)
        }
    });
    div.appendTo($("#checkbox_list"));
    checkbox.appendTo(div);
    label.appendTo(div);
}

function createCheckedHotspots(hotspot) {
    var span = $('<span />', {
        id: "span" + hotspot.rid,
        text: hotspot.aliasName,
        css: {
            "padding-right": "10px"
        }
    });
    var input = $('<input />', {
        id: hotspot.rid,
        type: 'hidden',
        name: "rids[]",
        value: hotspot.rid,
    });
    span.appendTo($("#checked_hotspots"));
    input.appendTo($("#checked_hotspots"));
}

function removeCheckedHotspots(hotspot) {
    $("#span" + hotspot.rid).remove();
    $("#" + hotspot.rid).remove();
}
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
                <a href="{{url('admin/hotspots_category/4')}}">熱點分類列表 (Hotspots Category List)</a>
            </li>
            <li>
                <a href="javascript:;">新增熱點分類 (Add Hotspot Category)</a>
            </li>
        </ul>
    </div>

    <!--/row-->

    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-edit"></i>新增熱點分類(Add Hotspot Category)</h2>
                </div>
                <div class="box-content">
                    <form action="{{url('admin/add_hotspots_category')}}" method="post" enctype="multipart/form-data" role="form">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="swarmName">熱點分類名稱 (Hotspot Category Name)</label>
                            <input name="swarmName" type="text" class="form-control" id="swarmName" placeholder="熱點分類名稱 (Hotspot Category Name)" required>
                        </div>
                        <div class="form-group">
                            <label for="checked_hotspots">已勾選的熱點 (Checked Hotspots)</label>
                            <div id="checked_hotspots" class="form-control4" style="min-height: 100px;  height: auto; word-wrap: break-word"></div>
                        </div>
                        <div class="form-group">
                            <label for="search_hotspots">搜尋熱點 (Search Hotspots)</label>
                            <input name="search_hotspots" type="text" class="form-control" id="search_hotspots" placeholder="熱點名稱(Hotspot Name)">
                            <div id="checkbox_list" ></div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-default">新增熱點分類 (Add Hotspot Category)</button>
                            <button type="button" class="btn btn-default" style="margin-left:10px;" onclick="history.back()">回上一頁 (Back)</button>
                        </div>
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