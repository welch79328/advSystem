@extends('layouts.admin')

@section('content')


    <div id="content" class="col-lg-9 col-sm-9">
            <!-- content starts -->
            <div>
                <ul class="breadcrumb">
                    <li>
                        <a href="index.php?act=2">帳號管理 (Account Management)</a>
                    </li>
                    <li>
                        <a href="javascript:;">登入記錄 (Sign Recorded)</a>
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
                                    <td width="50%"><h3>登入帳號 (Login Username)</h3></td>
                                    <td width="30%"><h3>登入時間 (Login Time)</h3></td>
                                    <td width="20%"><h3>IP Address</h3></td>
                                </tr>
                                @foreach($rs as $v)
                                <tr id="m{{$v->m_id}}">
                                    <td class="td" style="vertical-align:middle;">{{$v->ma_user}}</td>
                                    <td class="td" style="vertical-align:middle;">{{$v->l_date}}</td>
                                    <td class="td" style="vertical-align: middle;">{{$v->l_ip}}</td>
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

