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
				<form class="form-inline" method="post" action="<?php echo site_url('pos/C_customers/customerDetail/'.$customer[0]['id'])?>" role="form">
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
						<i class="icon-bell"></i><span id="print_title"><?php echo ucwords($customer[0]['store_name']); ?> </span>
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
							<a href="#tab_1_1" data-toggle="tab">Transaction List</a>
						</li>
						<li>
							<a href="#tab_1_2" data-toggle="tab">Customer Details</a>
						</li>
						
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1_1">
                            <p>
                                <a href="<?php echo site_url('pos/C_customers/receivePayment/'.$customer[0]['id']); ?>"  class="btn btn-success">Receive Payment</a>
                                <a href="<?php echo site_url('pos/C_customers/emailCustLedger/'.$customer[0]['id'].'/'.$from_date.'/'.$to_date); ?>" onclick="return confirm('Are you sure you want to email ledger?')" class="btn btn-warning">Email Ledger</a>
                                            
                            </p>
                            
						      <?php
                                
                                
                                echo '<table class="table table-bordered table-striped table-condensed flip-content" id="sample_customer">
                                <thead class="flip-content">
                                    <tr>
                                        
                                        <th>Invoice #</th>
                                        <th>Date</th>
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
                                $exchange_rate = $customer[0]['exchange_rate'] == 0 ? 1 : $customer[0]['exchange_rate'];
                                
                                echo '<tbody>';
                                
                                echo '<tr>';
                                    // echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    
                                    echo '<td>Opening Balance</td>';
                                    echo '<td>'.round($customer[0]['op_balance_dr']/$exchange_rate,2).'</td>';
                                    echo '<td>'.round($customer[0]['op_balance_cr']/$exchange_rate,2).'</td>';
                            
                                    $dr_amount += $customer[0]['op_balance_dr']/$exchange_rate;
                                    $cr_amount += $customer[0]['op_balance_cr']/$exchange_rate;
                                    
                                    $balance = ($dr_amount - $cr_amount);
                                    
                                    //if($dr_amount > $cr_amount){
//                                        $account = 'Dr'; 
//                                    }
//                                    elseif($dr_amount < $cr_amount)
//                                    {
//                                        $account = 'Cr';
//                                    }
//                                    else{ $account = '';}
                                    
                                    echo '<td>'.round($balance,2).'</td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    //echo '<td>'.anchor('accounts/C_ledgers/edit/'.$list['id'],'Edit'). ' | ';
                                    //echo  anchor('accounts/C_ledgers/delete/'.$list['id'],' Delete'). '</td>';
                                    echo '</tr>';
                                
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
                                    
                                    $account_name = $this->M_groups->get_groups($list['dueTo_acc_code'],$_SESSION['company_id']);
                                    echo '<td>'.($langs == 'en' ? $account_name[0]['title'] : $account_name[0]['title_ur']).'</td>';
                                    echo '<td>'.round($list['debit'],2).'</td>';
                                    echo '<td>'.round($list['credit'],2).'</td>';
                            
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
                                    echo '<td>'.round($balance,2).'</td>';
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
                                <th></th><th></th>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
								<th></th>
                                </tr>
                                </tfoot>
                                </table>';
                                
                                ?>
                                
                        </div> <!-- END tab_1_1-->
                        
						<div class="tab-pane" id="tab_1_2">
							<!-- BEGIN FORM-->
            				<form class="form-horizontal" role="form">
                            <?php foreach($customer as $values): ?>
            					<div class="form-body">
            						<h2 class="margin-bottom-20"> View Customer Info - <?php echo $values['store_name']; ?></h2>
            						<h3 class="form-section">Person Info</h3>
            						<div class="row">
            							<div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">Title:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['title']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            							<!--/span-->
            							<div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">First Name:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['first_name']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            							<!--/span-->
            						</div>
            						<!--/row-->
                                    <div class="row">
            							<div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">Middle Name:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['middle_name']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            							<!--/span-->
            							<div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">Last Name:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['last_name']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            							<!--/span-->
            						</div>
            						<!--/row-->
            						<div class="row">
                                        <div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">Company Name:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['store_name']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            							<!--/span-->
            							<div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">Email:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['email']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            							<!--/span-->
            							
            						</div>
            						
            						<h3 class="form-section">Address</h3>
            						<div class="row">
            							<div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">Address:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['address']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            						</div>
            						<div class="row">
            							<div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">City:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['city']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
                                        <div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">Country:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['country']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            							<!--/span-->
            							
            						</div>
                                    <!--/row-->
            						<div class="row">
            							<!--/span-->
            							<div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">Phone No:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['phone_no']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            							<!--/span-->
                                        <div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">Fax No:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['fax_no']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            							<!--/span-->
            						</div>
                                    
            						<!--/row-->
            						<div class="row">
            							<!--/span-->
            							<div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">Mobile No:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['mobile_no']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            							<!--/span-->
                                        <div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">Website:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['website']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            							<!--/span-->
            						</div>
                                    <?php endforeach; ?>
            					</div>
            					
            				</form>
            				<!-- END FORM-->
                        			
						</div><!-- END tab2-->
						
					</div>
					<!--END TABS-->
				</div>
			</div> <!-- End Portlet -->
				
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->

<!-- Modal -->
<div id="paymentModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Receive Payment From Customer</h4>
      </div>
      <div class="modal-body">
        <!-- BEGIN FORM-->
         <?php foreach($customer as $list): ?>
			<form action="<?php echo site_url('pos/C_customers/makePayment'); ?>" method="post" class="form-horizontal">
				<div class="form-body">
                    <input type="hidden" name="customer_id" value="<?php echo $list['id']; ?>" />
                     
                    <div class="form-group">
						<label class="col-md-3 control-label">Customer Store Name</label>
						<div class="col-md-6">
							<p class="form-control-static">
								 <?php echo $list['store_name']; ?>
							</p>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label">Customer Name</label>
						<div class="col-md-6">
							<p class="form-control-static">
								 <?php echo $list['first_name'] . ' '. $list['last_name']; ?>
							</p>
						</div>
					</div>
                    <?php if(@$_SESSION['multi_currency'] == 1)
                    {
                    ?>
                    <div class="form-group">
						<label class="col-md-3 control-label">Customer Currency</label>
						<div class="col-md-6">
							<p class="form-control-static">
								 <?php echo $this->M_currencies->get_currencyName($list['currency_id']); ?>
                                 <input type="number" class="form-control" name="exchange_rate" placeholder="Enter Exchange Rate">
							
							</p>
						</div>
					</div>
                    <?php } ?>
                    
                    <div class="form-group">
     
                         <label class="control-label col-sm-3" for="">Payment Type</label>
                             <div class="col-sm-6">
                                 <div class="checkbox">
                                 <label class="control-label" for="cash">Cash: </label><input type="radio" checked="" id="cash" name="payment_type" value="cash" class="form-control" />
                                 <label class="control-label" for="bank">Cheque: </label><input type="radio" id="bank" name="payment_type" value="bank" class="form-control" />
                                </div> 
                             </div>
                    </div>
                    
                    <div class="form-group" id="bank_accounts" style="display: none;">
     
                        <label class="control-label col-sm-3" for="">Bank Accounts</label>
                         <div class="col-sm-6">
                             <?php echo form_dropdown('bank_id',$activeBanks,'','id="bank_id" class="form-control"') ?>
                            
                         </div> 
       
                    </div>
                    
					<div class="form-group">
						<label class="col-md-3 control-label">Amount</label>
						<div class="col-md-6">
							
								<input type="number" class="form-control" name="amount" placeholder="Enter Amount">
							
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Discount Amount</label>
						<div class="col-md-6">
							
								<input type="number" class="form-control" name="discount_amount" placeholder="Enter Discount Amount">
							
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label">Comment</label>
						<div class="col-md-6">
							
								<textarea name="narration" name="comment" class="form-control"></textarea>
							
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-info">Receive</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      
      </form>
			<!-- END FORM-->
    </div>

  </div>
</div>