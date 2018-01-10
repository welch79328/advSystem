@extends('layouts.admin')

@section('js')
    <script type="text/javascript">
        var deletePostUri = "{{url('admin/class_del')}}";
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
                        <a href="javascript:;">廣告類型列表 (Ad Type List)</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">
                        <div class="box-header well" data-original-title="">
                            <h2><i class="glyphicon glyphicon-plus"></i> <a href="{{url('admin/class_add/4')}}">新增廣告類型 (New Ad Categories)</a></h2>
                        </div>
                        <div class="box-content">
                            <table class="table table-bordered table-striped responsive">
                                <tbody>
                                <tr align="center">
                                    <td width="30%"><h3>廣告類型名稱 (Ad Type Name)</h3></td>
                                    <td width="30%"><h3>廣告類型名稱 (Ad Type Code)</h3></td>
                                    <td width="15%"><h3>狀態 (Status)</h3></td>
                                    <td width="25%"><h3>編輯 (Edit) | 刪除 (Del)</h3></td>
                                </tr>
                                @foreach($rs as $v)
                                <tr id="s{{$v->s_id}}">
                                    <td class="td" style="vertical-align:middle;">{{$v->s_name}}</td>
                                    <td class="td" style="vertical-align:middle;">{{$v->s_type}}</td>
                                    <td class="td" style="vertical-align:middle;">
                                        @if($v->s_status == 1) 上架 @else 下架 @endif
                                    </td>
                                    <td class="td" style="vertical-align: middle;">
                                        <a href="{{url('admin/class_up/'.$v->s_id.'/3')}}">編輯 (Edit)</a> |
                                        <a href="javascript:;" onclick="removeUser2('{{$v->s_id}}');"> 刪除 (Del)</a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div style="width:100%; text-align:center;">
                                <nav>
                                    <ul class="pagination">
                                        {{$rs->links()}}
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