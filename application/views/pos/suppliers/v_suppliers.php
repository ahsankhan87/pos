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
				<form class="form-inline" method="post" action="<?php echo site_url('pos/Suppliers/index')?>" role="form">
        			<div class="form-group">
        				<label for="exampleInputEmail2">From Date</label>
        				<input type="date" class="form-control" name="from_date" value="<?php echo date('Y-m-d');?>" placeholder="From Date">
        			</div>
        			<div class="form-group">
        				<label for="exampleInputPassword2">To Date</label>
        				<input type="date" class="form-control" name="to_date" value="<?php echo date('Y-m-d');?>" placeholder="To Date">
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
        <div class="row">
            <div class="col-md-6">
                <?php echo anchor('pos/Suppliers/create', lang('add_new') . ' <i class="fa fa-plus"></i>', 'class="btn btn-success" id="sample_editable_1_new"'); ?>
                <?php echo anchor('pos/Suppliers/SupplierImport', 'Import Suppliers', 'class="btn btn-success"'); ?>
            </div>
            
        </div>
        <br>
        <?php
        if (count($suppliers)) {
        ?>
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i><span id="print_title"><?php echo $main; ?></span>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="#portlet-config" data-toggle="modal" class="config"></a>
                        <a href="javascript:;" class="reload"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="portlet-body flip-scroll">

                    <table class="table table-striped table-bordered table-condensed flip-content" id="sample_customer">
                        <thead class="flip-content">
                            <tr>

                                <th><?php echo lang('name'); ?></th>
                                <?php if (@$_SESSION['multi_currency'] == 1) {
                                    echo '<th>Currency</th>';
                                }
                                ?>
                                <th><?php echo lang('email'); ?></th>
                                <th><?php echo lang('contact'); ?></th>
                                <th><?php echo lang('debit'); ?></th>
                                <th><?php echo lang('credit'); ?></th>
                                <th><?php echo lang('balance'); ?></th>
                                <th><?php echo lang('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sno = 1;
                            foreach ($suppliers as $key => $list) {
                                $exchange_rate = ($list['exchange_rate'] == 0 ? 1 : $list['exchange_rate']);

                                echo '<tr>';
                                //echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                                //echo '<td>'.$list['id'].'</td>';
                                //echo '<td>'.$sno++.'</td>';
                                // echo '<td><img src="'.base_url('images/supplier-images/thumbs/'.$list['supplier_image']).'" width="40" height="40"/></td>';
                                //echo '<td>'.$list['account_code'].'</td>';
                                //echo '<td><a href="'.site_url('accounts/C_ledgers/ledgerDetail/'. $ledger_id).'">'.$name.'</a> </td>';
                                echo '<td><a href="' . site_url('pos/Suppliers/supplierDetail/' . $list['id']) . '">' . $list['name'] . ' </a><a href="mailto:' . $list['email'] . '"><i class="fa fa-envelope-o fa-fw"></i></a></td>';
                                if (@$_SESSION['multi_currency'] == 1) {
                                    echo '<td>' . $this->M_currencies->get_currencyName($list['currency_id']) . '</td>';
                                }
                                echo '<td>' . $list['email'] . '</td>';
                                //echo '<td>'.$list['address'].'</td>';
                                echo '<td>' . $list['contact_no'] . '</td>';

                                //OPENING BALANCES
                                $op_balance_dr = ($list['op_balance_dr'] / $exchange_rate);
                                $op_balance_cr = ($list['op_balance_cr'] / $exchange_rate);
                                $op_balance = (($op_balance_dr - $op_balance_cr) / $exchange_rate);

                                //CURRENT BALANCES
                                $cur_balance = $this->M_suppliers->get_supplier_total_balance($list['id'], $from_date,$to_date);
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
                                <?php echo anchor('pos/Suppliers/edit/' . $list['id'], '<i class="fa fa-pencil-square-o fa-fw"></i>', 'title="Edit"'); ?> |
                                <a href="<?php echo site_url('pos/Suppliers/delete/' . $list['id'] . '/' . $op_balance_dr . '/' . $op_balance_cr) ?>" onclick="return confirm('Are you sure you want to permanent delete supplier and his account transactions?')" title="Permanent Delete"><i class="fa fa-trash-o fa-fw"></i></a>

                        <?php
                                echo '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>';
                            echo '<tfoot>
                <tr>
                    <th></th><th></th>
                    <th>Total</th><th></th><th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>';
                            echo '</table>';
                        }
                        ?>
                </div>
            </div>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->