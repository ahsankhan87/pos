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
                <!-- <h4>Select From and To Dates</h4> -->
                <form class="form-inline" method="post" action="<?php echo site_url('reports/C_accountReceivable') ?>" role="form">
                    <div class="form-group">

                        <select class="form-control" id="report_period" name="report_period">
                            <option value="custom"><?php echo lang('custom'); ?></option>
                            <option value="this_month"><?php echo lang('this_month'); ?></option>
                            <option value="last_month"><?php echo lang('last_month'); ?></option>
                            <option value="last_week"><?php echo lang('last_week'); ?></option>
                            <option value="last_year"><?php echo lang('last_year'); ?></option>
                            <option value="this_year"><?php echo lang('this_year'); ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail2">From Date</label>
                        <input type="date" class="form-control" name="from_date" value="<?php echo $from_date ?>" id="from_date" placeholder="From Date">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword2">To Date</label>
                        <input type="date" class="form-control" name="to_date" value="<?php echo $to_date; ?>" id="to_date" placeholder="To Date">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword2">Emp:</label>
                        <select class="form-control select2me" name="emp_id" id="emp_id" data-placeholder="Select Employee">
                            <!-- <option value="">Select Employee</option> -->
                            <?php
                            foreach ($emp_DDL as $key => $values) :
                                echo '<option value="' . $key . '" ' . ($emp_id == $key ? 'selected' : '') . '>';
                                echo $values;
                                echo '</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword2">City</label>
                        <input type="text" class="form-control" name="city" value="<?php echo set_value('city') ?>" id="city" placeholder="City">
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
            <?php echo anchor('reports/C_accountReceivable/printPDF/' . $from_date . '/' . $to_date . '/' . $city . '/' . $emp_id, "<i class='fa fa-print'></i> Print", "target='_blank'"); ?>
            <h3><?php echo ucfirst($this->session->userdata("company_name")); ?></h3>
            <h4 style="margin-bottom:2px;"><?php echo $main; ?></h4>
            <p><?php echo date('d-m-Y', strtotime($from_date)) . ' to ' . date('d-m-Y', strtotime($to_date)); ?></p>
        </div>

        <table class="table table-condensed">
            <thead>
                <tr>
                    <th><?php echo lang('customer') ?></th>
                    <th><?php echo lang('city') ?></th>
                    <!-- <th><?php echo lang('employee') ?></th> -->
                    <th class="text-right"><?php echo lang('amount') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $net_total = 0; ?>
                <?php foreach ($receivables as $row): ?>
                    <tr>
                        <td><?= $row['customer_name'] ?></td>
                        <td><?= $row['city'] ?></td>
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
<script>
    $(document).ready(function() {

        const site_url = '<?php echo site_url($langs); ?>/';
        const path = '<?php echo base_url(); ?>';
        const current_date = '<?php echo date("Y-m-d") ?>';

        $('#report_period').on('change', function(event) {
            // event.preventDefault();
            if ($(this).val() == 'this_month') {
                var this_month = '<?php echo date("Y-m-01") ?>';
                $('#from_date').val(this_month);
                $('#to_date').val(current_date);

            } else if ($(this).val() == 'last_month') {
                const last_month_1_day = '<?php echo date("Y-m-01", strtotime('-1 month')) ?>';
                const last_month_last_day = '<?php echo date("Y-m-t", strtotime('-1 month')) ?>';
                $('#from_date').val(last_month_1_day);
                $('#to_date').val(last_month_last_day);
            } else if ($(this).val() == 'last_week') {
                const last_week_day = '<?php echo date("Y-m-d", strtotime('-1 week')) ?>';

                $('#from_date').val(last_week_day);
                $('#to_date').val(current_date);

            } else if ($(this).val() == 'last_year') {
                const last_year_1_day = '<?php echo date("Y-01-01", strtotime('-1 year')) ?>';
                const last_year_last_day = '<?php echo date("Y-12-t", strtotime('-1 year')) ?>';
                $('#from_date').val(last_year_1_day);
                $('#to_date').val(last_year_last_day);

            } else if ($(this).val() == 'this_year') {
                const last_year_1_day = '<?php echo date("Y-01-01") ?>';

                $('#from_date').val(last_year_1_day);
                $('#to_date').val(current_date);

            } else if ($(this).val() == 'custom') {

                $('#from_date').val(current_date)
                $('#to_date').val(current_date);

            }

        });
    });
</script>