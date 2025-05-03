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
                <form class="form-inline" method="post" action="<?php echo site_url('reports/C_accountPayable') ?>" role="form">
                    <div class="form-group">
                        <label for="exampleInputEmail2">From Date</label>
                        <input type="date" class="form-control" name="from_date" value="<?php echo date("Y-m-d"); ?>" placeholder="From Date">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword2">To Date</label>
                        <input type="date" class="form-control" name="to_date" value="<?php echo date("Y-m-d"); ?>" placeholder="To Date">
                    </div>

                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<!-- END PAGE CONTENT-->

<div class="row">
    <div class="col-sm-8 col-sm-offset-2 border">
        <div class="text-center">
            <?php echo anchor('reports/C_accountPayable/printPDF/' . $from_date . '/' . $to_date, "<i class='fa fa-print'></i> Print", "target='_blank'"); ?>
            <h3><?php echo ucfirst($this->session->userdata("company_name")); ?></h3>
            <h4 style="margin-bottom:2px;"><?php echo $main; ?></h4>
            <p><?php echo date('d-m-Y', strtotime($from_date)) . ' to ' . date('d-m-Y', strtotime($to_date)); ?></p>
        </div>

        <table class="table table-condensed">
            <thead>
                <tr>
                    <th><?php echo lang('supplier') ?></th>
                    <th><?php echo lang('') ?></th>
                    <!-- <th><?php echo lang('employee') ?></th> -->
                    <th class="text-right"><?php echo lang('amount') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $net_total = 0; ?>
                <?php foreach ($payable as $row): ?>
                    <tr>
                        <td><?= $row['supplier_name'] ?></td>
                        <td>Bill</td>
                        <!-- <td><?= $row['emp_id'] ?></td> -->
                        <td class="text-right"><?= number_format($row['net_balance'], 2) ?></td>
                    </tr>
                    <?php $net_total += $row['net_balance']; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>Total</strong></td>
                    <td class="text-right"><strong><?= $_SESSION['home_currency_symbol'] . number_format($net_total, 2) ?></strong></td>
                </tr>
            </tfoot>
        </table>


    </div>
    <!-- /.col-sm-12 -->
</div>