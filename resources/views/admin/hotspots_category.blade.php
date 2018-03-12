@extends('layouts.admin')

@section('js')
<script type="text/javascript">
    var deleteHotspotCategoryUrl = "{{url('admin/delete_hotspots_category')}}";
    var getHotspotsCountUrl = "{{url('admin/get_hotspots_count')}}";
    var token = "{{csrf_token()}}";
    function deleteHotspotCategory(id) {
        $.post(getHotspotsCountUrl, {"_token":token, "id": id}, function (response) {
            var msg = "確定要刪除？";
            if(response > 0){
                msg = "此分類已有" + response + "筆資料，確定要刪除？";
            }
            $.prompt(msg,{ 
                buttons:{刪除:true, 取消:false},
                close: function(e,v){
                    if(v){
                        $.post(deleteHotspotCategoryUrl, {"_token":token, "id": id}, function (response) {
                            location.reload();
                        });
                    }
                }
			});
        });
    }
</script>
@endsection

@section('content')
<div id="content" class="col-lg-9 col-sm-9">
    <!-- content starts -->
    <div>
        <ul class="breadcrumb">
            <li>
                <a href="javascript:;">廣告管理 (Ad Manager)</a>
            </li>
            <li>
                <a href="javascript:;">熱點分類列表 (Hotspots Category List)</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    @if(session('ma_level')=='root')
                    <h2><i class="glyphicon glyphicon-plus"></i> <a href="{{url('admin/hotspots_category_show_add/4')}}">新增熱點分類 (Add Hotspot Category)</a></h2>
                    @endif
                </div>
                <div class="box-content">
                    <table class="table table-bordered table-striped responsive">
                        <tbody>
                            <tr align="center">
                                <td width="60%"><h3>熱點分類名稱 (Hotspot Category Name)</h3></td>
                                <td width="40%"><h3>編輯 (Edit) | 刪除 (Del)</h3></td>
                            </tr>
                            @foreach($infos as $info)
                            <tr>
                                <td class="td">{{$info->swarmName}}</td>
                                <td class="td" style="vertical-align: middle;">
                                    <!-- 只有 root 帳號才有權限//-->
                                    @if(session('ma_level') == 'root')
                                        <a href="{{url('admin/hotspots_category_show_update/' . $info->swarmId . '/4')}}">編輯 (Edit)</a>
                                        <a href="javascript:;" onclick="deleteHotspotCategory({{$info->swarmId}})">刪除 (Del)</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div style="width:100%; text-align:center;">
                        <nav>
                            <ul class="pagination">

                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
        <!--/span-->
    </div><!--/row-->

    <!-- content ends -->
</div><!--/#content.col-md-0-->
</div><!--/fluid-row-->
@endsection
