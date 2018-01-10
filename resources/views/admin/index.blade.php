@extends('layouts.admin')

@section('js')
    <script type="text/javascript">
        var deletePostUri = "{{url('admin/member_del')}}";
        var token = "{{csrf_token()}}";
    </script>
@endsection

@section('content')

        <div id="content" class="col-lg-9 col-sm-9">
            <!-- content starts -->
            <div>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{url('admin/index/2')}}">帳號管理 (Account Management)</a>
                    </li>
                    <li>
                        <a href="javascript:;">帳號列表 (Accoun List)</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">
                        <div class="box-header well" data-original-title="">&nbsp;
                            <h2><i class="glyphicon glyphicon-plus"></i> <a href="{{url('admin/member_add/2')}}">新增帳號 (Create an Account)</a></h2>
                        </div>
                        <div class="box-content">
                            <table class="table table-bordered table-striped responsive">
                                <tbody>
                                <tr align="center">
                                    <td width="15%"><h3>名稱 (Name)</h3></td>
                                    <td width="15%"><h3>帳號 (Account)</h3></td>
                                    <td width="15%"><h3>等級 (Level)</h3></td>
                                    <td width="20%"><h3>建立時間 (Time)</h3></td>
                                    <td width="15%"><h3>創建人 (Creator)</h3></td>
                                    <td width="25%"><h3>編輯 (Edit) | 刪除 (Del)</h3></td>
                                </tr>
                                @foreach($rs as $v)
                                <tr id="ma{{$v->ma_id}}">
                                    <td class="td" style="vertical-align:middle;">{{$v->ma_name}}</td>
                                    <td class="td" style="vertical-align:middle;">{{$v->ma_user}}</td>
                                    <td class="td" style="vertical-align:middle;">{{$v->ma_level}}</td>
                                    <td class="td" style="vertical-align:middle;">{{$v->ma_time}}</td>
                                    <td class="td" style="vertical-align:middle;">{{$v->ma_cm}}</td>
                                    <td class="td" style="vertical-align: middle;">
                                        <a href="{{url('admin/member_up/'.$v->ma_id.'/2 ')}}">編輯 (Edit)</a> |
                                        @if($v->ma_point == 0)
                                        <a href="javascript:;" onclick="removeUser1({{$v->ma_id}});"> 刪除 (Del)</a>
                                        @else
                                        <a href="javascript:;" onclick="alert('點數請先歸零!!');"> 刪除 (Del)</a>
                                        @endif
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


        {{--<script>--}}
            {{--function removeUser1(id){--}}

                {{--var txt = '是否確定刪除此筆資料?'+name+'<input type="hidden" id="userid" name="userid" value="'+ id +'" />';--}}

                {{--$.prompt(txt,{--}}
                    {{--buttons:{刪除:true, 取消:false},--}}
                    {{--close: function(e,v,m,f){--}}

                        {{--if(v){--}}

                            {{--var uid = f.userid;--}}

                            {{--$.ajax({--}}
                                {{--url: '{{url('admin/member_del')}}',--}}
                                {{--type:"GET",--}}
                                {{--dataType:'text',--}}

                                {{--success: function(msg){--}}

                                    {{--$('#ma'+uid).hide('slow', function(){--}}
                                        {{--$(this).remove();--}}
                                        {{--location.reload();--}}
                                    {{--});--}}
                                {{--}--}}
                            {{--});--}}

                        {{--}--}}

                    {{--}--}}
                {{--});--}}
            {{--}--}}
        {{--</script>--}}

@endsection

