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
                <form class="form-inline" method="post" action="<?php echo site_url('reports/C_profitloss') ?>" role="form">
                    <div class="form-group">
                        <label for="exampleInputEmail2"><?php echo lang('from') . ' ' . lang('date') ?></label>
                        <input type="date" class="form-control" name="from_date" placeholder="From Date">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword2"><?php echo lang('to') . ' ' . lang('date') ?></label>
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

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th><?php echo lang('account') ?></th>
            <th><?php echo lang('amount') ?></th>
            <th><?php echo lang('total') ?></th>

        </tr>
    </thead>
    <tbody>

        <?php
        $total = 0;
        foreach ($proft_loss as $key => $list) {
            echo '<tr><td colspan="3">';
            echo '<strong>' . ($langs == 'en' ? $list['title'] : $list['title_ur']) . '</strong>';
            echo '</td></tr>';

            ///////
            $pl_report = $this->M_reports->get_profit_loss($_SESSION['company_id'], $list['account_code'], $from_date, $to_date);
            foreach ($pl_report as $key => $values) :

                echo '<tr><td>';
                echo '&nbsp;&nbsp;--';
                echo ($langs == 'en' ? $values['title'] : $values['title_ur']);
                echo '</td>';

                echo '<td>';
                echo $balance = $values['credit'] - $values['debit'];
                echo '</td>';

                echo '<td>';
                echo $total += $balance;
                echo '</td></tr>';
            endforeach;
            /////
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td><strong>NET PROFIT/(-)LOSS</strong></td>
            <td></td>
            <td><?php echo '<small>' . $_SESSION['home_currency_symbol'] . '</small>'; ?><strong><?php echo $total; ?></strong></td>
        </tr>
    </tfoot>

</table>