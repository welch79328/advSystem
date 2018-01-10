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
                        <a href="javascript:;">點數列表 (Points List)</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">
                        <div class="box-header well" data-original-title="">&nbsp;</div>
                        <div class="box-content">
                            <table class="table table-bordered table-striped responsive">
                                <tbody>
                                <tr align="center">
                                    <td width="20%"><h3>時間 (Time)</h3></td>
                                    <td width="15%"><h3>會員帳號 (Member Account)</h3></td>
                                    <td width="15%"><h3>動作 (Action)</h3></td>
                                    <td width="15%"><h3>點數 (Points)</h3></td>
                                    <td width="15%"><h3>帳戶總額 (Total)</h3></td>
                                    <td width="20%"><h3>儲值者 (Admin)</h3></td>
                                </tr>
                                @foreach($rs as $v)
                                <tr id="m{{$v->m_id}}">
                                    <td class="td" style="vertical-align:middle;">{{$v->p_date}}</td>
                                    <td class="td" style="vertical-align:middle;">{{$v->ma_user}}</td>
                                    <td class="td" style="vertical-align:middle;">{{$v->p_name}}</td>
                                    <td class="td" style="vertical-align:middle;">{{$v->p_quantity}}</td>
                                    <td class="td" style="vertical-align: middle;">{{$v->p_sum}}</td>
                                    <td class="td" style="vertical-align: middle;">{{$v->ma_a_user}}</td>
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