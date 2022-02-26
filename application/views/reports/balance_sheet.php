<div class="note note-warning">
    <p>
        - If you want to distribute the profit among multiple partners then press below button and run Retained Earning Report.<br />
        - All Profit or Loss will be credted or debited accordingly to Retained Earning Account.<br />
        - Then Distribute profit/loss through Journal Entry.
        <a href="<?php echo site_url('reports/C_profitloss/run_pl_report') ?>" class="btn btn-success">Run Retained Earning Report</a>
    </p>
</div>
<div class="row hidden-print">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Select From and To Dates
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                    <a href="" class="reload"></a>
                    <a href="" class="remove"></a>
                </div>
            </div>
            <div class="portlet-body">
                <form class="form-inline" method="post" action="<?php echo site_url('reports/C_balancesheet') ?>" role="form">
                    <div class="form-group">
                        <label for="exampleInputEmail2"><?php echo lang('from') . ' ' . lang('date') ?></label>
                        <input type="date" class="form-control" name="from_date" placeholder="From Date">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword2"><?php echo lang('to') . ' ' . lang('date') ?></label>
                        <input type="date" class="form-control" name="to_date" placeholder="To Date">
                    </div>

                    <button type="submit" class="btn btn-default"><?php echo lang('search') ?></button>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<!-- END PAGE CONTENT-->

<div class="row">
    <div class="col-sm-12">
        <h3>Assets</h3>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><?php echo lang('account') ?></th>
                    <th><?php echo lang('total') ?></th>
                </tr>
            </thead>
            <tbody>

                <?php
                $asset_total = 0;

                foreach ($parentGroups4Assets as $key => $list) {
                    echo '<tr><td colspan="2">';
                    echo '<strong>' . ($langs == 'en' ? $list['title'] : $list['title_ur']) . '</strong>';
                    echo '</td></tr>';

                    ///////
                    //$bl_report = $this->M_reports->get_Assets4BalanceSheet($_SESSION['company_id'],$list['account_code'],$from_date,$to_date);
                    $bl_report = $this->M_groups->get_GroupsByParent($list['account_code']);

                    foreach ($bl_report as $key => $values) :

                        $dr = $this->M_entries->balanceByAccount($values['account_code'], $from_date, $to_date)[0]['debit'];
                        $cr = $this->M_entries->balanceByAccount($values['account_code'], $from_date, $to_date)[0]['credit'];
                        $balance = ($dr + $values['op_balance_dr']) - ($values['op_balance_cr'] + $cr);

                        if ($balance != 0) {
                            echo '<tr><td>';
                            echo '&nbsp;&nbsp;--';
                            echo ($langs == 'en' ? $values['title'] : $values['title_ur']);
                            echo '</td>';

                            echo '<td>';
                            echo number_format($balance, 2);
                            echo '</td>';

                            //echo '<td>';
                            $asset_total += $balance;
                            //echo '</td>
                            echo '</tr>';
                        }
                    endforeach;
                    /////
                }
                ?>

            </tbody>
            <tfoot>
                <tr>
                    <td><strong>TOTAL</strong></td>

                    <td><?php echo '<small>' . $_SESSION['home_currency_symbol'] . '</small>'; ?><strong><?php echo number_format($asset_total, 2); ?></strong></td>
                </tr>
            </tfoot>

        </table>

    </div>
    <!-- /.col-sm-6 -->
    <div class="col-sm-12">
        <h3>Liability / Owner Equity</h3>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><?php echo lang('account') ?></th>
                    <th><?php echo lang('total') ?></th>
                </tr>
            </thead>
            <tbody>

                <?php
                $total = 0;

                foreach ($Liability4BalanceSheet as $key => $list) {
                    echo '<tr><td colspan="2">';
                    echo '<strong>' . ($langs == 'en' ? $list['title'] : $list['title_ur']) . '</strong>';
                    echo '</td></tr>';

                    ///////
                    //$bl_report = $this->M_reports->get_Liability4BalanceSheet($_SESSION['company_id'],$list['account_code'],$from_date,$to_date);
                    $bl_report = $this->M_groups->get_GroupsByParent($list['account_code']);
                    foreach ($bl_report as $key => $values) :

                        $dr = $this->M_entries->balanceByAccount($values['account_code'], $from_date, $to_date)[0]['debit'];
                        $cr = $this->M_entries->balanceByAccount($values['account_code'], $from_date, $to_date)[0]['credit'];
                        $balance = ($values['op_balance_cr'] + $cr) - ($dr + $values['op_balance_dr']);

                        if ($balance != 0) {
                            echo '<tr><td>';
                            echo '&nbsp;&nbsp;--';
                            echo ($langs == 'en' ? $values['title'] : $values['title_ur']);
                            echo '</td>';

                            echo '<td>';
                            echo number_format($balance, 2);
                            echo '</td>';

                            //echo '<td>';
                            $total += $balance;
                            //echo '</td>
                            echo '</tr>';
                        }
                    endforeach;
                    /////
                }

                echo '<tr><td>';
                echo 'Net Income / (-)Loss';
                echo '</td>';

                echo '<td>';
                echo -number_format($net_income);
                echo '</td>';

                //echo '<td>';
                $total += -$net_income;
                //echo '</td>';
                echo '</tr>';
                ?>

            </tbody>
            <tfoot>
                <tr>
                    <td><strong>TOTAL</strong></td>

                    <td><?php echo '<small>' . $_SESSION['home_currency_symbol'] . '</small>'; ?><strong><?php echo number_format($total, 2); ?></strong></td>
                </tr>
            </tfoot>

        </table>

    </div>
    <!-- /.col-sm-6 -->
</div>
<!-- /.row -->