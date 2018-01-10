@extends('layouts.admin')

@section('content')

        <div id="content" class="col-lg-9 col-sm-9">
            <!-- content starts -->
            <div>
                <ul class="breadcrumb">
                    <li>
                        <a href="javascript:;">帳號管理 (Account Management)</a>
                    </li>
                    <li>
                        <a href="javascript:;">點數儲值 (Points Gift)</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">
                        <div class="box-header well" data-original-title="">
                            <h2><i class="glyphicon glyphicon-plus"></i>
                                <a href="{{url('admin/point_add/3')}}">點數儲值 (Points Gift)</a>
                            </h2>
                        </div>
                        <div class="box-content">
                            <table class="table table-bordered table-striped responsive">
                                <tbody>
                                <tr align="center">
                                    <td width="20%"><h3>會員名稱 (Member Name)</h3></td>
                                    <td width="20%"><h3>會員帳號 (Member Account)</h3></td>
                                    <td width="15%"><h3>已分配點數 (Assigned)</h3></td>
                                    <td width="15%"><h3>帳戶總額 (Total)</h3></td>
                                    <td width="20%"><h3>儲值帳號 (Gift Account)</h3></td>
                                    <td width="15%"><h3>編輯 (Edit)</h3></td>
                                </tr>
                                @foreach($rs as $v)
                                <tr id="m{{$v->ma_id}}">
                                    <td class="td" style="vertical-align:middle;">{{$v->ma_name}}</td>
                                    <td class="td" style="vertical-align:middle;">{{$v->ma_user}}</td>
                                    <td class="td" style="vertical-align:middle;">{{$v->a_pq}}</td>
                                    <td class="td" style="vertical-align:middle;">{{$v->ma_point}}</td>
                                    <td class="td" style="vertical-align:middle;">{{$v->ma_a_user}}</td>
                                    <td class="td" style="vertical-align:middle;"><a href="{{url('admin/point_edit?act=3&ma_user='.$v->ma_user)}}">編輯</a></td>
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