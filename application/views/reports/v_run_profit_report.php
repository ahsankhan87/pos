<div class="note note-warning">
	<h4 class="block">Warning! Closing Revenue and Expense Accounts</h4>
	<p>
		 - When you run this report all Revenue and Expense accounts will be closed and amount will be posted to Retained Earning Accounts.<br />
         - Usually this report run at the end of Financial Year and then distribute the Retained Earning to Owner's Capital Account.
	</p>
</div>
<div class="row hidden-print">
	<div class="col-md-12">
     <?php
        if($this->session->flashdata('message'))
        {
            echo "<div class='alert alert-success fade in'>";
            echo $this->session->flashdata('message');
            echo '</div>';
        }
        if($this->session->flashdata('error'))
        {
            echo "<div class='alert alert-danger fade in'>";
            echo $this->session->flashdata('error');
            echo '</div>';
        }
        ?>
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-reorder"></i> Select Retained Earning Account
				</div>
				<div class="tools">
					<a href="" class="collapse"></a>
					<a href="#portlet-config" data-toggle="modal" class="config"></a>
					<a href="" class="reload"></a>
					<a href="" class="remove"></a>
				</div>
			</div>
			<div class="portlet-body">
				<form class="form-inline" method="post" action="<?php echo site_url('reports/C_profitloss/run_pl_report')?>" role="form">
        			<div class="form-group">
        				<label for="exampleInputEmail2">Select Retained Earning Account</label>
        				<?php echo form_dropdown('retained_earning_account',$accountDDL,'3001','class="form-control"'); ?>
							    
        			</div>
        			
        			<button type="submit" onclick="return confirm('Are you sure you want to close accounts?')" class="btn btn-default">Run</button>
        		</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->
	</div>
</div>
<!-- END PAGE CONTENT-->
