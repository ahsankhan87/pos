<div class="row hidden-print">
    <div class="col-sm-12">
    
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

<?php foreach($employee as $key => $list): ?>

	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-reorder"></i>Form Actions On Bottom
			</div>
			<div class="tools">
				<a href="javascript:;" class="collapse"></a>
				<a href="#portlet-config" data-toggle="modal" class="config"></a>
				<a href="javascript:;" class="reload"></a>
				<a href="javascript:;" class="remove"></a>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form action="<?php echo site_url('pos/C_employees/makePayment'); ?>" method="post" class="form-horizontal">
				<div class="form-body">
                    <input type="hidden" name="cash_acc_code" value="<?php echo $list['cash_acc_code']; ?>" />
                    <input type="hidden" name="salary_acc_code" value="<?php echo $list['salary_acc_code']; ?>" />
                    <input type="hidden" name="employee_id" value="<?php echo $list['id']; ?>" />
                    
                    <div class="form-group last">
						<label class="col-md-3 control-label">Employee Name</label>
						<div class="col-md-4">
							<p class="form-control-static">
								 <?php echo $list['first_name'] . ' '. $list['last_name']; ?>
							</p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Amount</label>
						<div class="col-md-4">
							<div class="input-group">
								<input type="number" class="form-control" name="amount" placeholder="Enter Amount">
							</div>
						</div>
					</div>
					
                    <div class="form-group">
						<label class="col-md-3 control-label">Narration</label>
						<div class="col-md-4">
							<div class="input-group">
								<textarea name="narration" name="comment" class="form-control"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="form-actions">
					<div class="row">
						<div class="col-md-offset-3 col-md-9">
							<button type="submit" onclick="return confirm('Are you sure to pay salary?')" class="btn btn-info">Pay</button>
							<button type="button" onclick="window.history.back();" class="btn btn-default">Cancel</button>
						</div>
					</div>
				</div>
			</form>
			<!-- END FORM-->
		</div>

<?php endforeach; ?>
    </div>
    </div><!-- /.col-sm-12 -->
</div><!-- /.row -->

<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i><?php echo $employee[0]['first_name'] . ' '. $employee[0]['last_name']; ?>
         <?php echo ($langs == 'en' ? @$employee_entries[0]['title'] : @$employee_entries[0]['title_ur']); ?> Account Detail
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <?php
        if(count($employee_entries))
        {
        ?>
        
        <table class="table table-striped table-bordered table-hover" id="sample_2">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Date</th>
                <th>Account</th>
                <th>Dr Amount</th>
                <th>Cr Amount</th>
                <th>Balance</th>
                <th>Narration</th>
            </tr>
        </thead>
        <?php
        echo '<tbody>';
        //initialize
        $dr_amount = 0.00;
        $cr_amount = 0.00;
        $balance = 0.00;
        
        foreach($employee_entries as $key => $list)
        {
            echo '<tr>';
            echo '<td>'.$list['invoice_no'].'</td>';
            echo '<td>'.$list['date'].'</td>';
            
            $account_name = $this->M_groups->get_groups($list['dueTo_acc_code'],$_SESSION['company_id']);
            echo '<td>'.($langs == 'en' ? $list['title'] : $list['title_ur']).'</td>';
            echo '<td class="text-right">'.number_format($list['debit'],2).'</td>';
            echo '<td class="text-right">'.number_format($list['credit'],2).'</td>';
    
            $dr_amount += $list['debit'];
            $cr_amount += $list['credit'];
            
            $balance = ($dr_amount - $cr_amount);
            
            if($dr_amount > $cr_amount){
                $account = 'Dr'; 
            }
            elseif($dr_amount < $cr_amount)
            {
                $account = 'Cr';
            }
            else{ $account = '';}
            
            echo '<td class="text-right">'.$account.' '.number_format(abs($balance),2).'</td>';
           echo '<td>'.$list['narration'].'</td>';
    
            //echo '<td>'.anchor('accounts/C_ledgers/edit/'.$list['id'],'Edit'). ' | ';
            //echo  anchor('accounts/C_ledgers/delete/'.$list['id'],' Delete'). '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</tfoot>';
        echo '<tr><th></th>';
        echo '<th>Total</th>';
        echo '<th class="text-right">'.number_format($dr_amount,2).'</th>';
        echo '<th class="text-right">'.number_format($cr_amount,2).'</th>';
        echo '<th class="text-right">'.@$account.' '.number_format(abs($balance),2).'</th>';
        echo '<th></th></tr>';
        echo '</tfoot>';
        echo '</table>';
        }
        ?>
    </div> <!-- /. panel body -->
</div> <!-- /. panel --> 
