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
				
				<form class="form-inline" method="post" action="<?php echo site_url('accounts/C_groups/accountDetail')?>" role="form">
        			<div class="form-group">
        				<label for="exampleInputEmail2">From Date</label>
        				<input type="date" class="form-control" name="from_date" placeholder="From Date">
        			</div>
        			<div class="form-group">
        				<label for="exampleInputPassword2">To Date</label>
        				<input type="date" class="form-control" name="to_date" placeholder="To Date">
        			</div>
        			<div class="form-group">
        				<label for="exampleInputPassword2">Account</label>
        				<?php echo form_dropdown('account_code',$accountDDL,'','class="form-control select2me"'); ?>
        			</div>
        			<button type="submit" class="btn btn-default">Search</button>
        		</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->
	</div>
</div>
<!-- END DAte Search-->

<?php
if($this->session->flashdata('message'))
{
    echo "<div class='message'>";
    echo $this->session->flashdata('message');
    echo '</div>';
}
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo ($langs == 'en' ? @$accounts[0]['title'] : @$accounts[0]['title_ur']); ?> Account Detail
        <a href="javascript:window.print()"><i class="fa fa-print pull-right"></i></a>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <?php ///var_dump($accounts);
        if(count($accounts))
        {
        ?>
        
        <table class="table table-bordered table-striped table-hover" id="account_detail">
        <thead>
            <tr>
                <th>Date</th>
                <th>Inv #</th>
                <th>Account</th>
                <th class="text-right">Debit</th>
                <th class="text-right">Credit</th>
                <th class="text-right">Balance</th>
                <th width="30%">Narration</th>
            </tr>
        </thead>
        
        
        <?php
        //initialize
        $dr_amount = 0.00;
        $cr_amount = 0.00;
        $balance = 0.00;
        $sno = 1;
        echo '<tbody>';
        echo '<tr>';
                //echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                
                echo '<td>Opening Balance</td>';
                echo '<td class="text-right">'.round(($accounts[0]['op_balance_dr']),2).'</td>';
                echo '<td class="text-right">'.round(($accounts[0]['op_balance_cr']),2).'</td>';

                $dr_amount += $accounts[0]['op_balance_dr'];
                $cr_amount += $accounts[0]['op_balance_cr'];
                
                $balance = ($dr_amount - $cr_amount);
                
                // if($dr_amount > $cr_amount){
                //     $account = 'Dr'; 
                // }
                // elseif($dr_amount < $cr_amount)
                // {
                //     $account = 'Cr';
                // }
                // else{ $account = '';}
                
                echo '<td class="text-right">'.round(abs($balance),2).'</td>';
                echo '<td></td>';
                //echo '<td>'.anchor('accounts/C_ledgers/edit/'.$list['id'],'Edit'). ' | ';
                //echo  anchor('accounts/C_ledgers/delete/'.$list['id'],' Delete'). '</td>';
        echo '</tr>';
            
                                
        foreach($entries as $key => $list)
        {
            echo '<tr>';
            //echo '<td>'.$sno++.'</td>';
            echo '<td>'.$list['date'].'</td>';
                        
                    echo '<td>';
                        $inv_prefix = substr($list['invoice_no'],0,1);
                        if(ucwords($inv_prefix) === 'S'){
                            echo '<a href="'.site_url('trans/C_sales/receipt/'.$list['invoice_no']).'" title="Print Invoice" target="_blank" >'.$list['invoice_no'].'</a>';  
                        }elseif(ucwords($inv_prefix) === 'R')
                        {
                            echo '<a href="'.site_url('trans/C_receivings/receipt/'.$list['invoice_no']).'" title="Print Invoice" target="_blank" >'.$list['invoice_no'].'</a>';    
                        }elseif(ucwords($inv_prefix) === 'J')
                        {
                            echo '<a href="'.site_url('accounts/C_entries/receipt/'.$list['invoice_no']).'" title="Print Invoice" target="_blank" >'.$list['invoice_no'].'</a>';
                        
                        }else
                        {
                            echo $list['invoice_no'];    
                        }
                    echo '</td>';
                    
            $account_name = $this->M_groups->get_groups($list['dueTo_acc_code'],$_SESSION['company_id']);
            echo '<td>';
            echo ($langs == 'en' ? @$account_name[0]['title'] : @$account_name[0]['title_ur']);
                    if($list['is_cust'] == 1 && $list['ref_account_id'] != 0)
                        {
                            echo ' <small><a href="'.site_url('pos/C_customers/customerDetail/'. $list['ref_account_id']).'">('.trim($this->M_customers->get_CustomerName($list['ref_account_id'])).')</a></small>';
                        }
                        if($list['is_supp'] == 1 && $list['ref_account_id'] != 0)
                        {
                            echo ' <small><a href="'.site_url('pos/Suppliers/supplierDetail/'. $list['ref_account_id']).'">('.trim($this->M_suppliers->get_supplierName($list['ref_account_id'])).')</a></small>';
                        }
                        if($list['is_bank'] == 1 && $list['ref_account_id'] != 0)
                        {
                            echo ' <small><a href="'.site_url('pos/C_banking/bankDetail/'. $list['ref_account_id']).'">('.trim($this->M_banking->get_bankName($list['ref_account_id'])).')</a></small>';
                        }
            echo '</td>';
            echo '<td class="text-right">'.round($list['debit'],2).'</td>';
            echo '<td class="text-right">'.round($list['credit'],2).'</td>';
    
            $dr_amount += $list['debit'];
            $cr_amount += $list['credit'];
            
            $balance = ($dr_amount - $cr_amount);
            
            //if($dr_amount > $cr_amount){
//                $account = 'Dr'; 
//            }
//            elseif($dr_amount < $cr_amount)
//            {
//                $account = 'Cr';
//            }
//            else{ $account = '';}
            
            echo '<td class="text-right">'.round($balance,2).'</td>';
            echo '<td>'.$list['narration'].'</td>';
            //echo '<td>'.anchor('accounts/C_ledgers/edit/'.$list['id'],'Edit'). ' | ';
            //echo  anchor('accounts/C_ledgers/delete/'.$list['id'],' Delete'). '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '<tfoot>';
        echo '<tr><th></th><th></th>';
        echo '<th>Total</th>';
        echo '<th class="text-right"></th>';
        echo '<th class="text-right"></th>';
        echo '<th class="text-right"></th>';
        echo '<th></th>';
        echo '</tr>';
        echo '</tfoot>';
        echo '</table>';
        }
        ?>
    </div> <!-- /. panel body -->
</div> <!-- /. panel --> 