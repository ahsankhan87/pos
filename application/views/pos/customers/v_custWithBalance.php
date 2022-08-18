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
				<form class="form-inline" method="post" action="<?php echo site_url('pos/C_customers/')?>" role="form">
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

<div class="row">
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
            <?php echo anchor('pos/C_customers/create', 'Add New <i class="fa fa-plus"></i>', 'class="btn btn-success"'); ?>
            <?php echo anchor('pos/C_customers/CustomerImport', 'Import Customers', 'class="btn btn-success"'); ?>
            <?php echo anchor('pos/C_customers/cheque_list', 'List of Cheques', 'class="btn btn-success"'); ?>

        </p>

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

                <table class="table table-striped table-condensed table-bordered flip-content" id="getAllCustomerWithBalance">
                    <thead class="flip-content">
                        <tr>
                            <th>Id</th>
                            <th><?php echo lang('name'); ?></th>
                            <th><?php echo lang('store'); ?></th>
                            <?php if (@$_SESSION['multi_currency'] == 1) {
                                echo '<th>Currency</th>';
                            }
                            ?>
                            <th><?php echo lang('address'); ?></th>
                            <th><?php echo lang('debit'); ?></th>
                            <th><?php echo lang('credit'); ?></th>
                            <th><?php echo lang('balance'); ?></th>
                            <th><?php echo lang('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Total</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.portlet body -->
        </div>
        <!-- /.portlet -->
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->