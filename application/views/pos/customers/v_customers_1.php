<div class="row">
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
                <form class="form-inline" method="post" action="<?php echo site_url('pos/C_customers/index') ?>" role="form">
                    <div class="form-group">
                        <label for="exampleInputEmail2">From Date</label>
                        <input type="date" class="form-control" name="from_date" value="<?php echo date('Y-m-d'); ?>" placeholder="From Date">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword2">To Date</label>
                        <input type="date" class="form-control" name="to_date" value="<?php echo date('Y-m-d'); ?>" placeholder="To Date">
                    </div>

                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>

    <!-- END PAGE CONTENT-->

    <div class="col-sm-12">
        <?php
        if ($this->session->flashdata('message')) {
            echo "<div class='alert alert-success fade in'>";
            echo $this->session->flashdata('message');
            echo '</div>';
        }
        if ($this->session->flashdata('error')) {
            echo "<div class='alert alert-danger fade in'>";
            echo $this->session->flashdata('error');
            echo '</div>';
        }
        ?>
        <p>
            <?php echo anchor('pos/C_customers/create', lang('add_new') . ' <i class="fa fa-plus"></i>', 'class="btn btn-success"'); ?>
            <?php echo anchor('pos/C_customers/CustomerImport', 'Import Customers', 'class="btn btn-success"'); ?>
            <?php echo anchor('pos/C_customers/cheque_list', 'List of Cheques', 'class="btn btn-success"'); ?>

        </p>

        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i><span id="print_title"><?php echo $main . ' ' . $main_small; ?></span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>
            <div class="portlet-body flip-scroll">

                <table class="table table-striped table-condensed flip-content" id="sample_customer">
                    <thead>
                        <tr>
                            <th><?php echo lang('name'); ?></th>
                            <th><?php echo lang('store'); ?></th>
                            <th><?php echo lang('address'); ?></th>
                            <th><?php echo lang('debit'); ?></th>
                            <th><?php echo lang('credit'); ?></th>
                            <th><?php echo lang('balance'); ?></th>
                            <th><?php echo lang('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($customers as $list) {
                            $exchange_rate = ($list['exchange_rate'] == 0 ? 1 : $list['exchange_rate']);

                            echo '<tr>';
                            //echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                            //echo '<td>'.$list['id'].'</td>';
                            //echo '<td>'.$sno++.'</td>';
                            // echo '<td><img src="'.base_url('images/supplier-images/thumbs/'.$list['supplier_image']).'" width="40" height="40"/></td>';
                            //echo '<td>'.$list['account_code'].'</td>';
                            //echo '<td><a href="'.site_url('accounts/C_ledgers/ledgerDetail/'. $ledger_id).'">'.$name.'</a> </td>';
                            // echo '<td><a href="' . site_url('pos/C_customers/customerDetail/' . $list['id']) . '">' . $list['first_name'] . ' </a></td>';

                            echo '<td>' . $list['first_name'] .  ' ' . $list['last_name'] . '</td>';
                            echo '<td>' . $list['store_name'] . '</td>';
                            echo '<td>' . $list['address'] . '</td>';

                            //OPENING BALANCES
                            $op_balance_dr = ($list['op_balance_dr'] / $exchange_rate);
                            $op_balance_cr = ($list['op_balance_cr'] / $exchange_rate);
                            $op_balance = (($op_balance_dr - $op_balance_cr) / $exchange_rate);

                            //CURRENT BALANCES
                            $cur_balance = $this->M_customers->get_customer_total_balance($list['id'], $from_date, $to_date);
                            $balance_dr = ($cur_balance[0]['dr_balance'] / $exchange_rate);
                            $balance_cr = ($cur_balance[0]['cr_balance'] / $exchange_rate);

                            echo '<td>' . round($op_balance_dr + $balance_dr, 2) . '</td>';
                            echo '<td>' . round($op_balance_cr + $balance_cr, 2) . '</td>';
                            echo '<td>' . round(($op_balance_dr + $balance_dr) - ($op_balance_cr + $balance_cr), 2) . '</td>';

                            //echo '<td><a href="'.site_url('pos/Suppliers/paymentModal/'. $list['id']).'" class="btn btn-warning btn-sm">Make Payment</a></td>';
                            // echo '<td><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#supplier-payment-Modal">Make Payment</button></td>';

                            echo '<td>';
                            //echo  anchor(site_url('up_supplier_images/upload_images/'.$list['id']),' upload Images');

                        ?>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Action </button>
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
                                <ul class="dropdown-menu" role="menu">

                                    <li>
                                        <?php echo anchor('pos/C_customers/customerDetail/' . $list['id'], 'View Ledger'); ?>
                                    </li>
                                    <li>
                                        <?php echo anchor('pos/C_customers/edit/' . $list['id'], 'Edit'); ?>
                                    </li>
                                    <?php if ($this->session->userdata('role') == 'admin') { ?>
                                        <li>
                                            <?php echo anchor('pos/C_customers/delete/' . $list['id'], 'Delete', array('onclick' => "return confirm('Are you sure you want to permanent delete supplier and his account transactions?')")); ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>

                        <?php

                            echo '</td>';
                            echo '</tr>';
                        }

                        ?>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Total</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                    </tbody>
                </table>
            </div>
            <!-- /.col-sm-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->