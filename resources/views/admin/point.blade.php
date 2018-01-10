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
                                <td width="40%"><h3>動作 (Action)</h3></td>
                                <td width="20%"><h3>點數 (Points)</h3></td>
                                <td width="20%"><h3>帳戶總額 (Total)</h3></td>
                            </tr>
                            <?php
                            while($row = $rs2->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr id="m<?php echo $row['m_id']; ?>">
                                <td class="td" style="vertical-align:middle;"><?php echo $row['p_date']; ?></td>
                                <td class="td" style="vertical-align:middle;">
                                    <?php echo fun_point($row['p_name']); ?>
                                    <?php
                                    if(!empty($row['a_name'])) {
                                        echo '<br />（'.$row['a_name'].'；剩餘分配點數：'.$row['p_over'].'）';
                                    }
                                    ?>
                                </td>
                                <td class="td" style="vertical-align:middle;"><?php echo $row['p_quantity']; ?></td>
                                <td class="td" style="vertical-align: middle;"><?php echo $row['p_sum']; ?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                        <div style="width:100%; text-align:center;">
                            <nav>
                                <ul class="pagination">
                                    <?php echo $links; ?>
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