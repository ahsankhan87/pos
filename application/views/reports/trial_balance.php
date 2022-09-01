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
                <h4>Select From and To Dates</h4>
                <form class="form-inline" method="post" action="<?php echo site_url('reports/C_trial_balance') ?>" role="form">
                    <div class="form-group">
                        <label for="exampleInputEmail2">From Date</label>
                        <input type="date" class="form-control" name="from_date" placeholder="From Date">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword2">To Date</label>
                        <input type="date" class="form-control" name="to_date" placeholder="To Date">
                    </div>

                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<!-- END PAGE CONTENT-->

<?php
if (count(@$trialBalance)) {
?>

    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 border">
            <div class="text-center">
                <h3><?php echo ucfirst($this->session->userdata("company_name")); ?></h3>
                <h4 style="margin-bottom:2px;"><?php echo $main; ?></h4>
                <p><?php echo date('d-m-Y', strtotime($from_date)) . ' to ' . date('d-m-Y', strtotime($to_date)); ?></p>
            </div>

            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th><?php echo lang('account') . ' ' . lang('code') ?></th>
                        <th><?php echo lang('title') ?></th>
                        <th class="text-right"><?php echo lang('debit') . ' ' . lang('amount') ?></th>
                        <th class="text-right"><?php echo lang('credit') . ' ' . lang('amount') ?></th>
                    </tr>
                </thead>

                <tbody>
                <?php
                //initialize
                $dr_total = 0.00;
                $cr_total = 0.00;
                $balance = 0.00;
                $dr_amount = 0.00;
                $cr_amount = 0.00;

                //var_dump($trialBalance);
                foreach ($trialBalance as $key => $list) {
                    $dr = $this->M_entries->balanceByAccount($list['account_code'], $from_date, $to_date)[0]['debit'];
                    $cr = $this->M_entries->balanceByAccount($list['account_code'], $from_date, $to_date)[0]['credit'];

                    $balance = ($dr + $list['op_balance_dr']) - ($list['op_balance_cr'] + $cr);
                    //if($balance != 0)
                    //{
                    echo '<tr>';
                    echo '<td>' . $list['account_code'] . '</td>';

                    //echo '<td><a href="'.site_url('accounts/C_groups/accountDetail/'. $list['account_code']).'">'.($langs == 'en' ? $list['title'] : $list['title_ur']).'</a></td>';
                    echo '<td>' . ($langs == 'en' ? $list['title'] : $list['title_ur']) . '</td>';
                    //echo '<td><a href="' . site_url('accounts/C_groups/accountDetail/' . $list['account_code']) . '">' . ($langs == 'en' ? $list['title'] : $list['title_ur']) . '</a></td>';

                    //if balance is greater than zero it will be debit. else will be credit balance
                    if ($balance > 0) {
                        echo '<td class="text-right">' . number_format(abs($balance), 2) . '</td>';
                        echo '<td class="text-right">0.00</td>';
                        $dr_amount += $balance;
                    } elseif ($balance < 0) {
                        echo '<td class="text-right">0.00</td>';
                        echo '<td class="text-right">' . number_format(abs($balance), 2) . '</td>';
                        $cr_amount +=  $balance;
                    } else {
                        echo '<td class="text-right">0.00</td>';
                        echo '<td class="text-right">0.00</td>';
                    }


                    echo '</tr>';
                    //}
                }
                echo '<tr><td></td>';
                echo '<td><strong>Total</strong></td>';
                echo '<td class="text-right">' . '<strong><small>' . $_SESSION['home_currency_symbol'] . '</small>' .  number_format(abs($dr_amount), 2) . '</strong></td>';
                echo '<td class="text-right">' . '<strong><small>' . $_SESSION['home_currency_symbol'] . '</small>' .  number_format(abs($cr_amount), 2) . '</strong></td>';

                echo '</tr>';
                echo '</tbody>';
                echo '</table>';
            }
                ?>

        </div>
        <!-- /.col-sm-12 -->
    </div>