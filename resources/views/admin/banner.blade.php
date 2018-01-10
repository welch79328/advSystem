@extends('layouts.admin')

@section('js')
    <script type="text/javascript">
        var deletebannerUri = "{{url('admin/banner_del')}}";
        var token = "{{csrf_token()}}";
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
                    <a href="javascript:;">廣告列表 (Ad List)</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="box col-md-12">
                <div class="box-inner">
                    <div class="box-header well" data-original-title="">
                        @if(session('ma_level')=='root')
                        <h2><i class="glyphicon glyphicon-plus"></i> <a href="{{url('admin/banner_add/4')}}">新增廣告 (New Ad)</a></h2>
                        @endif
                    </div>
                    <div class="box-content">
                        <table class="table table-bordered table-striped responsive">
                            <tbody>
                            <tr align="center">
                                <td width="30%"><h3>廣告名稱 (Ad Name)</h3></td>
                                <td width="15%"><h3>類型 (Type)</h3></td>
                                <td width="20%"><h3>樣式 (Style)</h3></td>
                                <td width="15%"><h3>狀態 (Status)</h3></td>
                                <td width="20%"><h3>編輯 (Edit) | 刪除 (Del)</h3></td>
                            </tr>
                            @foreach($data as $v)
                            <tr id="a{{$v->a_id}}">
                                <td class="td">{{$v->a_name}}</td>
                                <td class="td" style="vertical-align:middle;">@if($v->a_type == 1) 圖片 @else 影片 @endif</td>
                                <td class="td" style="vertical-align:middle;">{{$v->s_name}}</td>
                                <td class="td" style="vertical-align:middle;">
                                    @if($v->a_status == 1) 上架 @else 下架 @endif
                                </td>
                                <td class="td" style="vertical-align: middle;">
                                    <a href="{{url('admin/banner_up/'.$v->a_id.'/4')}}">編輯 (Edit)</a>

                                    <!-- 只會會員帳號才能刪除 //-->
                                    @if(session('ma_level') == 'root')
                                        @if($v->a_pq == 0)
                                            <a href="javascript:;" onclick="removeUser3({{$v->a_id}});">刪除 (Del)</a>
                                        @else
                                            <a href="javascript:;" onclick="removeUser4({{$v->a_id}});">刪除 (Del)</a>
                                         @endif
                                    @endif
                                <!-- 只會會員帳號才能刪除 //-->
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div style="width:100%; text-align:center;">
                            <nav>
                                <ul class="pagination">
                                    {{$data->links()}}
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
