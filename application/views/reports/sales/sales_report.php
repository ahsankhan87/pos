<div class="tabbable tabbable-custom">
    <ul class="nav nav-tabs">
        <li class="<?php echo $active_tab_0; ?>">
            <a href="#tab_0" data-toggle="tab"><?php echo 'Daily ' . lang('report'); ?></a>
        </li>
        <li class="<?php echo $active_tab_1; ?>">
            <a href="#tab_1" data-toggle="tab"><?php echo lang('sales') . ' ' . lang('report'); ?></a>
        </li>
        <li class="<?php echo $active_tab_2; ?>">
            <a href="#tab_2" data-toggle="tab"><?php echo lang('sales') . ' ' . lang('wise') . ' ' . lang('summary'); ?></a>
        </li>
        <li class="<?php echo $active_tab_3; ?>">
            <a href="#tab_3" data-toggle="tab"><?php echo lang('product') . ' ' . lang('wise') . ' ' . lang('summary'); ?></a>
        </li>
        <li class="<?php echo $active_tab_4; ?>">
            <a href="#tab_4" data-toggle="tab"><?php echo lang('customer') . ' ' . lang('last') . ' ' . lang('sales') . ' ' . lang('report'); ?></a>
        </li>
        <li class="<?php echo $active_tab_5; ?>">
            <a href="#tab_5" data-toggle="tab"><?php echo lang('category') . ' ' . lang('wise') . ' ' . lang('summary'); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane <?php echo $active_tab_0; ?>" id="tab_0">
            <div class='hide' id="print_title"><?php echo 'Daily Sale Report'; ?> <strong><?php echo date('d-m-Y', strtotime($from_date)); ?></strong></div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet-body flip-scroll">
                        <table class="table table-bordered table-striped table-condensed table-hover flip-content" id="sample_1"> <!----sample_sales_reports -->
                            <thead class="flip-content">
                                <tr>
                                    <th>ID</th>
                                    <th>Serial No.</th>
                                    <th><?php echo lang('product') . ' ' . lang('size') ?></th>
                                    <th><?php echo '' ?></th>
                                    <th><?php echo lang('amount') ?></th>
                                    <th><?php echo lang('price') ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $unit_price = 0;
                                $cost_price = 0;
                                $discount_value = 0;
                                $sno = 1;
                                $id = 1;
                                $total_price = 0;
                                $expense_total = 0;

                                foreach ($daily_sales_report as $key => $list) {

                                    echo '<td>' . $id++ . '</td>';
                                    echo '<td>' . $sno++ . '</td>';
                                    echo '<td>' . $this->M_items->get_ItemName($list['item_id']) . '</td>';
                                    echo '<td></td>';

                                    echo '<td class="text-right">' . round($list['item_unit_price'], 2) . '</td>';
                                    echo '<td class="text-right">';
                                    if ($list['register_mode'] == "sale") {
                                        echo (($list['item_unit_price']) * ($list['quantity_sold']) - $list['discount_value']);
                                    } else {
                                        echo (($list['item_unit_price']) * - ($list['quantity_sold']) - $list['discount_value']);
                                    }
                                    echo '</td>';

                                    $unit_price  += (($list['item_unit_price']) * ($list['quantity_sold']) - $list['discount_value']);

                                    echo '</tr>';
                                }
                                $total_price = $unit_price;
                                echo '<tr>';
                                echo   '<th></th>
                                            <th class="text-right"></th>
                                            <th class="text-right"></th>
                                            <th class="text-right"></th>
                                            <th class="text-right">Total</th>
                                            <th class="text-right">' . number_format($total_price, 2) . '</th>';
                                echo '</tr>';
                                $expenses = $this->M_payments->get_payments(FALSE, $from_date, $to_date);

                                foreach ($expenses as $list) {
                                    echo '<tr>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<th class="text-right">' . $list['title'] . '</th>';
                                    echo '<th class="text-right">' . number_format($list['net_amount'], 2) . '</th>';
                                    echo '</tr>';

                                    $expense_total += $list['net_amount'];
                                }

                                ?>

                            </tbody>

                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="text-right"></th>
                                    <th class="text-right"></th>
                                    <th class="text-right"></th>
                                    <th class="text-right">Balance</th>
                                    <th class="text-right"><?php echo number_format($total_price - $expense_total, 2); ?></th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
                <hr />
            </div>

        </div> <!-- /.tab 0 -->

        <div class="tab-pane <?php echo $active_tab_1; ?>" id="tab_1">

            <div class='row hidden-print'>
                <div class='col-md-12'>
                    <div class="well">
                        <form method="post" action="<?php echo site_url('reports/C_salesreport/sales_report') ?>" class="form-horizontal">

                            <div class="form-group">
                                <label class="control-label col-sm-2" for=""><?php echo lang('customer') ?></label>
                                <div class="col-sm-4">
                                    <?php echo form_dropdown('customer_id', $CustomerDDL, '', 'class="form-control select2me"') ?>

                                </div>

                                <label class="control-label col-sm-2" for=""><?php echo lang('products') ?></label>
                                <div class="col-sm-4">
                                    <?php echo form_dropdown('item_id', $productsDDL, '', 'class="form-control select2me"') ?>

                                </div>
                            </div>

                            <div class="form-group">

                                <label class="control-label col-sm-2" for=""><?php echo lang('from') . ' ' . lang('date') ?></label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="datepicker" name="from_date" value="<?php echo date('Y-m-d'); ?>" autocomplete="off" />
                                </div>

                                <label class="control-label col-sm-2" for=""><?php echo lang('to') . ' ' . lang('date') ?></label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="Todatepicker" value="<?php echo date('Y-m-d'); ?>" name="to_date" autocomplete="off" />
                                </div>

                            </div>

                            <div class="form-group">

                                <label class="control-label col-sm-2" for=""><?php echo lang('employee') ?></label>
                                <div class="col-sm-4">
                                    <?php echo form_dropdown('emp_id', $emp_DDL, '', 'class="form-control select2me"') ?>

                                </div>

                                <label class="control-label col-sm-2" for=""><?php echo lang('register') . ' ' . lang('mode') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="register_mode">
                                        <option value="all">All</option>
                                        <option value="sale">Sale</option>
                                        <option value="return">Return</option>p
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">

                                <label class="control-label col-sm-2" for="sale_type"><?php echo lang('sales') . ' ' . lang('type') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="sale_type">
                                        <option value="all">All</option>
                                        <option value="cash">Cash</option>
                                        <option value="credit">Credit</option>p
                                    </select>
                                </div>

                                <div class="col-sm-offset-2 col-sm-4">
                                    <button type="submit" class="btn btn-primary"><?php echo lang('search') ?></button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <?php
            if (count((array)@$sales_report)) {
            ?>
                <div class="row">
                    <div class="col-sm-12">
                        <h2 class="page-header lead"><span id="print_title"><?php echo ucfirst($sale_type) . ' Sale '; ?> Report From <strong><?php echo date('d-m-Y', strtotime($from_date)) . ' To ' . date('d-m-Y', strtotime($to_date)); ?></strong></h2></span>
                    </div>
                    <!-- /.col-sm-12 -->
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="portlet-body flip-scroll">
                            <table class="table table-bordered table-striped table-condensed table-hover flip-content" id="sample_sales_reports">
                                <thead class="flip-content">
                                    <tr>
                                        <th><?php echo lang('date') ?></th>
                                        <th>Inv#</th>
                                        <th><?php echo lang('customer') ?></th>
                                        <th>Emp</th>
                                        <th><?php echo lang('product') ?></th>
                                        <th>Qty <?php echo lang('sold') ?></th>
                                        <th><?php echo lang('sale') . '  ' . lang('price') ?></th>
                                        <th><?php echo lang('disc') ?></th>
                                        <th><?php echo lang('total') ?></th>
                                        <th><?php echo lang('profit') ?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $unit_price = 0;
                                    $cost_price = 0;
                                    $discount_value = 0;

                                    foreach ($sales_report as $key => $list) {
                                        // echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                                        echo '<td>' . date('d-m-Y', strtotime($list['sale_date'])) . '</td>';
                                        echo '<td>' . anchor('trans/C_sales/receipt/' . $list['invoice_no'], $list['invoice_no'], 'target="_blank"') . '</td>';
                                        echo '<td>' . $this->M_customers->get_CustomerName($list['customer_id']) . '</td>';
                                        echo '<td>' . $this->M_employees->get_empName($list['employee_id']) . '</td>';

                                        if ($list['size_id'] != 0) {
                                            $size_name = $this->M_sizes->get_sizeName($list['item_id']);
                                        }

                                        echo '<td>' . $this->M_items->get_ItemName($list['item_id']) . ' ' . @$size_name . '</td>';

                                        echo '<td class="text-right">' . $list['quantity_sold'] . '</td>';
                                        //echo '<td>'.$list['item_cost_price'].'</td>';
                                        echo '<td class="text-right">' . round($list['item_unit_price'], 2) . '</td>';
                                        echo '<td class="text-right">' . round($list['discount_value'], 2) . '</td>';
                                        echo '<td class="text-right">';
                                        if ($list['register_mode'] == "sale") {
                                            echo (($list['item_unit_price']) * ($list['quantity_sold']) - $list['discount_value']);
                                        } else {
                                            echo (($list['item_unit_price']) * - ($list['quantity_sold']) - $list['discount_value']);
                                        }
                                        echo '</td>';

                                        echo '<td class="text-right">';
                                        if ($_SESSION['role'] == 'admin') {
                                            if ($list['register_mode'] == "sale") {
                                                echo (($list['item_unit_price'] * $list['quantity_sold']) - ($list['item_cost_price'] * $list['quantity_sold']) - $list['discount_value']);
                                            } else {
                                                echo - (($list['item_unit_price'] * $list['quantity_sold']) - ($list['item_cost_price'] * $list['quantity_sold']) - $list['discount_value']);
                                                //add negative sign for subtration in grid from total amount.
                                            }
                                        }
                                        echo '</td>';
                                        //$cost_price += ($list['item_cost_price']*$list['quantity_sold']);
                                        //$unit_price  += ($list['item_unit_price']*$list['quantity_sold']);
                                        //$discount_value  += $list['discount_value'];


                                        //echo  anchor(site_url('up_property_images/upload_images/'.$list['id']),' upload Images'). '</td>';
                                        echo '</tr>';
                                    }
                                    //$u_price = $unit_price;
                                    //$c_price = $cost_price;
                                    //$discount_value = $discount_value;
                                    // $income = ($u_price-$c_price);
                                    ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total</th>
                                        <th class="text-right"></th>
                                        <th class="text-right"></th>
                                        <th class="text-right"></th>
                                        <th class="text-right"></th>
                                        <th class="text-right"></th>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                    <hr />
                </div>


            <?php } ?>
        </div> <!-- /.tab 1 -->

        <div class="tab-pane <?php echo $active_tab_2; ?>" id="tab_2">
            <div class='row hidden-print'>
                <div class='col-md-12'>
                    <div class="well">
                        <form method="post" action="<?php echo site_url('reports/C_salesreport/customerWiseSales') ?>" class="form-horizontal">

                            <div class="form-group">

                                <label class="control-label col-sm-2" for="">From Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="datepicker" name="from_date" value="<?php echo date('Y-m-d'); ?>" autocomplete="off" />
                                </div>

                                <label class="control-label col-sm-2" for="">To Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="Todatepicker" name="to_date" value="<?php echo date('Y-m-d'); ?>" autocomplete="off" />
                                </div>

                            </div>

                            <div class="form-group">

                                <label class="control-label col-sm-2" for="">Employee</label>
                                <div class="col-sm-4">
                                    <?php echo form_dropdown('emp_id', $emp_DDL, '', 'class="form-control select2me"') ?>

                                </div>

                                <label class="control-label col-sm-2" for="">Register Mode</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="register_mode">
                                        <option value="all">All</option>
                                        <option value="sale">Sale</option>
                                        <option value="return">Return</option>p
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">

                                <label class="control-label col-sm-2" for="sale_type">Sale Type</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="sale_type">
                                        <option value="all">All</option>
                                        <option value="cash">Cash</option>
                                        <option value="credit">Credit</option>p
                                    </select>
                                </div>

                                <div class="col-sm-offset-2 col-sm-4">
                                    <button type="submit" class="btn btn-default">Search</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <?php
            if (count((array)@$customerWise_sales_report)) {
            ?>
                <div class="row">
                    <div class="col-sm-12">
                        <h2 class="page-header lead"><span id="print_title">
                                <?php echo @$this->M_employees->get_empName($customerWise_sales_report[0]['employee_id']) ?>
                                Customer Wise Sales Summary From <strong><?php echo date('d-m-Y', strtotime($from_date)) . ' To ' . date('d-m-Y', strtotime($to_date)); ?></strong></h2></span>
                    </div>
                    <!-- /.col-sm-12 -->
                </div>

                <div class="row">
                    <div class="col-sm-12">

                        <table class="table table-bordered table-striped table-condensed table-hover" id="sales_summary">
                            <thead>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Customers</th>
                                    <th>Sale Price</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $total = 0;
                                $sno = 1;
                                foreach ($customerWise_sales_report as $key => $list) {
                                    // echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                                    echo '<td>' . $sno++ . '</td>';
                                    echo '<td>' . $this->M_customers->get_CustomerName($list['customer_id']) . '</td>';
                                    echo '<td>' . round(($list['price'] - $list['discount_value']), 2) . '</td>';

                                    //$total += $list['price']-$list['discount_value'];


                                    // echo  anchor(site_url('up_property_images/upload_images/'.$list['id']),' upload Images'). '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>

                            <tfoot>
                                <tr>

                                    <th></th>
                                    <th>Total</th>
                                    <th></th>

                                </tr>
                                </tr>
                            </tfoot>

                        </table>

                    </div>
                    <hr />
                </div>

            <?php } ?>
        </div> <!-- /.tab 2 -->

        <div class="tab-pane <?php echo $active_tab_3; ?>" id="tab_3">
            <div class='row hidden-print'>
                <div class='col-md-12'>
                    <div class="well">
                        <form method="post" action="<?php echo site_url('reports/C_salesreport/productWiseSales') ?>" class="form-horizontal">

                            <div class="form-group">

                                <label class="control-label col-sm-2" for="">From Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="datepicker" name="from_date" value="<?php echo date('Y-m-d'); ?>" autocomplete="off" />
                                </div>

                                <label class="control-label col-sm-2" for="">To Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="Todatepicker" name="to_date" value="<?php echo date('Y-m-d'); ?>" autocomplete="off" />
                                </div>

                            </div>

                            <div class="form-group">

                                <label class="control-label col-sm-2" for="">Employee</label>
                                <div class="col-sm-4">
                                    <?php echo form_dropdown('emp_id', $emp_DDL, '', 'class="form-control select2me"') ?>

                                </div>

                                <label class="control-label col-sm-2" for="">Register Mode</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="register_mode">
                                        <option value="all">All</option>
                                        <option value="sale">Sale</option>
                                        <option value="return">Return</option>p
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">

                                <label class="control-label col-sm-2" for="sale_type">Sale Type</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="sale_type">
                                        <option value="all">All</option>
                                        <option value="cash">Cash</option>
                                        <option value="credit">Credit</option>p
                                    </select>
                                </div>

                                <div class="col-sm-offset-2 col-sm-4">
                                    <button type="submit" class="btn btn-default">Search</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <?php
            if (count((array)@$productWise_sales_report)) {
            ?>
                <div class="row">
                    <div class="col-sm-12">
                        <h2 class="page-header lead">
                            <span id="print_title"><?php echo $this->M_employees->get_empName($productWise_sales_report[0]['employee_id']) ?>&nbsp;Product Wise Summary From <strong>
                                    <?php echo date('d-m-Y', strtotime($from_date)) . ' To ' . date('d-m-Y', strtotime($to_date)); ?>
                                </strong>
                            </span>
                        </h2>
                    </div>
                    <!-- /.col-sm-12 -->
                </div>

                <div class="row">
                    <div class="col-sm-12">

                        <table class="table table-bordered table-striped table-condensed table-hover flip-content" id="sales_summary">
                            <thead class="flip-content">
                                <tr>
                                    <th>Serial No</th>
                                    <th>Products</th>
                                    <th>Quantity</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $total = 0;
                                $sno = 1;
                                foreach ($productWise_sales_report as $key => $list) {
                                    // echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                                    echo '<td>' . $sno++ . '</td>';
                                    $size_name = $this->M_sizes->get_sizeName($list['item_id']);
                                    echo '<td>' . $this->M_items->get_itemName($list['item_id']) . ' ' . $size_name . '</td>';
                                    echo '<td>' . round($list['qty'], 2) . '</td>';

                                    //$total += $list['qty'];


                                    // echo  anchor(site_url('up_property_images/upload_images/'.$list['id']),' upload Images'). '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Total</th>
                                    <th></th>

                                </tr>
                            </tfoot>

                        </table>

                    </div>
                    <hr />
                </div>

            <?php } ?>
        </div> <!-- /.tab 3 -->

        <div class="tab-pane <?php echo $active_tab_4; ?>" id="tab_4">
            <div class='row hidden-print'>
                <div class='col-md-12'>
                    <div class="well">
                        <form method="post" action="<?php echo site_url('reports/C_salesreport/customerLastSales') ?>" class="form-horizontal">


                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">Search</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <?php
            if (count((array)@$customerLastSales_report)) {
            ?>
                <div class="row">
                    <div class="col-sm-12">
                        <h2 class="page-header lead">
                            <span id="print_title">
                                Customers who did not sale last 30 days
                            </span>
                        </h2>
                    </div>
                    <!-- /.col-sm-12 -->
                </div>

                <div class="row">
                    <div class="col-sm-12">

                        <table class="table table-bordered table-striped table-condensed table-hover flip-content" id="sales_summary">
                            <thead class="flip-content">
                                <tr>
                                    <th>Serial No</th>
                                    <th>Customers</th>
                                    <th>City</th>
                                    <th>Mobile No</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $total = 0;
                                $sno = 1;
                                foreach ($customerLastSales_report as $key => $list) {
                                    // echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                                    echo '<td>' . $sno++ . '</td>';
                                    // $size_name = $this->M_sizes->get_sizeName($list['item_id']);
                                    echo '<td>' . $list['first_name'] . '</td>';
                                    echo '<td>' . $list['city'] . '</td>';
                                    echo '<td>' . $list['mobile_no'] . '</td>';

                                    //$total += $list['qty'];


                                    // echo  anchor(site_url('up_property_images/upload_images/'.$list['id']),' upload Images'). '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>


                        </table>

                    </div>
                    <hr />
                </div>

            <?php } ?>
        </div> <!-- /.tab 4 -->

        <div class="tab-pane <?php echo $active_tab_5; ?>" id="tab_5">
            <div class='row hidden-print'>
                <div class='col-md-12'>
                    <div class="well">
                        <form method="post" action="<?php echo site_url('reports/C_salesreport/categoryWiseSales') ?>" class="form-horizontal">

                            <div class="form-group">

                                <label class="control-label col-sm-2" for="">From Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="datepicker" name="from_date" value="<?php echo date('Y-m-d'); ?>" autocomplete="off" />
                                </div>

                                <label class="control-label col-sm-2" for="">To Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="Todatepicker" name="to_date" value="<?php echo date('Y-m-d'); ?>" autocomplete="off" />
                                </div>

                            </div>

                            <div class="form-group">

                                <label class="control-label col-sm-2" for="">Employee</label>
                                <div class="col-sm-4">
                                    <?php echo form_dropdown('emp_id', $emp_DDL, '', 'class="form-control select2me"') ?>

                                </div>

                                <label class="control-label col-sm-2" for="">Register Mode</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="register_mode">
                                        <option value="all">All</option>
                                        <option value="sale">Sale</option>
                                        <option value="return">Return</option>p
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">

                                <label class="control-label col-sm-2" for="sale_type">Sale Type</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="sale_type">
                                        <option value="all">All</option>
                                        <option value="cash">Cash</option>
                                        <option value="credit">Credit</option>p
                                    </select>
                                </div>

                                <div class="col-sm-offset-2 col-sm-4">
                                    <button type="submit" class="btn btn-default">Search</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <?php
            if (count((array)@$categoryWise_sales_report)) {
            ?>
                <div class="row">
                    <div class="col-sm-12">
                        <h2 class="page-header lead">
                            <span id="print_title"><?php echo $this->M_employees->get_empName($categoryWise_sales_report[0]['employee_id']) ?>Category Wise Summary From <strong>
                                    <?php echo date('d-m-Y', strtotime($from_date)) . ' To ' . date('d-m-Y', strtotime($to_date)); ?>
                                </strong>
                            </span>
                        </h2>
                    </div>
                    <!-- /.col-sm-12 -->
                </div>

                <div class="row">
                    <div class="col-sm-12">

                        <table class="table table-bordered table-striped table-condensed table-hover flip-content" id="category_sales_summary">
                            <thead class="flip-content">
                                <tr>
                                    <th>Serial No</th>
                                    <th>Products</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $total = 0;
                                $sno = 1;
                                foreach ($categoryWise_sales_report as $key => $list) {
                                    // echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                                    echo '<td>' . $sno++ . '</td>';
                                    //$size_name = $this->M_sizes->get_sizeName($list['item_id']);
                                    //echo '<td>'.$this->M_items->get_itemName($list['item_id']).' '.$size_name.'</td>';
                                    echo '<td>' . $list['category'] . '</td>';
                                    echo '<td>' . round($list['qty']) . '</td>';
                                    echo '<td>' . round($list['amount'], 2) . '</td>';

                                    //$total += $list['qty'];


                                    // echo  anchor(site_url('up_property_images/upload_images/'.$list['id']),' upload Images'). '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>

                        </table>

                    </div>
                    <hr />
                </div>

            <?php } ?>
        </div> <!-- /.tab 5 -->

    </div>
    <!--Tabbable end -->