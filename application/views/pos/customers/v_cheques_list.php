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
				<form class="form-inline" method="post" action="<?php echo site_url('pos/C_customers/cheque_list/')?>" role="form">
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
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-bell"></i><span id="print_title"><?php echo ucwords($main); ?> </span>
					</div>
					<div class="tools">
						<a href="" class="collapse"></a>
						<a href="#portlet-config" data-toggle="modal" class="config"></a>
						<a href="" class="reload"></a>
						<a href="" class="remove"></a>
					</div>
				</div>
				<div class="portlet-body">
					<!--BEGIN TABS-->
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_1_1" data-toggle="tab">List of Cheques</a>
						</li>
						
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1_1">
                            
						      <?php
                                
                                
                                echo '<table class="table table-bordered table-striped table-condensed flip-content" id="sample_1">
                                <thead class="flip-content">
                                    <tr>
                                        
                                        <th>Invoice #</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Account</th>
                                        <th>Dr Amount</th>
                                        <th>Cr Amount</th>
                                        <th>Balance</th>
                                        <th width="20%">Narration</th>
                                        <th></th>
                                    </tr>
                                </thead>';
                                
                                //initialize
                                $sno = 1;
                                $dr_amount = 0.00;
                                $cr_amount = 0.00;
                                $balance = 0.00;
                                
                                echo '<tbody>';
                                
                                
                                if(count($customer_entries))
                                {
                                    
                                foreach($customer_entries as $key => $list)
                                {
                                    echo '<tr>';
                                    // echo '<td>'.$sno++.'</td>';
                                    
                                    $inv_prefix = substr($list['invoice_no'],0,1);
                                    
                                    echo '<td>';
                                        $inv_prefix = substr($list['invoice_no'],0,1);
                                        if(ucwords($inv_prefix) === 'S'){
                                            echo '<a href="'.site_url('trans/C_sales/receipt/'.$list['invoice_no']).'" title="Print Invoice" target="_blank" >'.$list['invoice_no'].'</a>';  
                                        }elseif(ucwords($inv_prefix) === 'R')
                                        {
                                            echo '<a href="'.site_url('trans/C_receivings/receipt/'.$list['invoice_no']).'" title="Print Invoice" target="_blank" >'.$list['invoice_no'].'</a>';    
                                        }elseif(ucwords($inv_prefix) === 'C')
                                        {
                                            echo '<a href="'.site_url('accounts/C_entries/receipt/'.$list['invoice_no']).'" title="Print Invoice" target="_blank" >'.$list['invoice_no'].'</a>';
                                        
                                        }else
                                        {
                                            echo $list['invoice_no'];    
                                        }
                                    echo '</td>';
                                  
                                    // echo '<td>'.date('d-m-Y',strtotime($list['date'])).'</td>';
                                    echo '<td>'.$list['date'].'</td>';
                                    echo '<td>'.$this->M_customers->get_CustomerName($list['customer_id']).'</td>';
                                    
                                    $account_name = $this->M_groups->get_groups($list['dueTo_acc_code'],$_SESSION['company_id']);
                                    echo '<td>'.($langs == 'en' ? $account_name[0]['title'] : $account_name[0]['title_ur']).'</td>';
                                    echo '<td class="text-right">'.round($list['debit'],2).'</td>';
                                    echo '<td class="text-right">'.round($list['credit'],2).'</td>';
                            
                                    $dr_amount += $list['debit'];
                                    $cr_amount += $list['credit'];
                                    
                                    $balance = ($dr_amount - $cr_amount);
                                    
                                    //if($dr_amount > $cr_amount){
//                                        $account = 'Dr'; 
//                                    }
//                                    elseif($dr_amount < $cr_amount)
//                                    {
//                                        $account = 'Cr';
//                                    }
//                                    else{ $account = '';}
//                                    
                                    echo '<td class="text-right">'.round($balance,2).'</td>';
                                    echo '<td>'.$list['narration'].'</td>';
                                    echo '<td><a href="'. site_url($langs.'/accounts/C_entries/edit/' . $list['invoice_no']) .'" title="Edit"><i class="fa fa-pencil fa-fw"></i></a> </td>';
                        			//echo '<td>'.anchor('accounts/C_ledgers/edit/'.$list['id'],'Edit'). ' | ';
                                    //echo  anchor('accounts/C_ledgers/delete/'.$list['id'],' Delete'). '</td>';
                                    echo '</tr>';
                                }
                                }
                                echo '</tbody>
                                <tfoot>
                                <tr>
                                <th></th><th></th><th></th>
                                <th>Total</th>
                                <th class="text-right">'.round($dr_amount,2).'</th>
                                <th class="text-right">'.round($cr_amount,2).'</th>
                                <th class="text-right">'.round($balance,2).'</th>
                                <th></th><th></th>
                                </tr>
                                </tfoot>
                                </table>';
                                
                                ?>
                                
                        </div> <!-- END tab_1_1-->
                        
					</div>
					<!--END TABS-->
				</div>
			</div> <!-- End Portlet -->
				
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
