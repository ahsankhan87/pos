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
						<i class="icon-bell"></i><span id="print_title"><?php echo ucwords($bank[0]['bank_name']); ?></span>
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
							<a href="#tab_1_2" data-toggle="tab">Banking Details</a>
						</li>
						
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1_1">
                            <p>
                                <a href="" data-target="#paymentModal" data-toggle="modal" class="btn btn-warning">Cash Withdrawals</a>
                            </p>
                            
						     
                                <table class="table table-bordered table-striped table-condensed flip-content" id="sample_customer">
                                <thead>
                                    <tr>
                                        <th>Inv #</th>
                                        <th>Date</th>
                                        <th>Account</th>
                                        <th>Dr Amount</th>
                                        <th>Cr Amount</th>
                                        <th>Balance</th>
                                        <th width="20%">Narration</th>
                                    </tr>
                                </thead>
                                <?php
                                
                                //initialize
                                $dr_amount = 0.00;
                                $cr_amount = 0.00;
                                $balance = 0.00;
                                $exchange_rate = $bank[0]['exchange_rate'] == 0 ? 1 : $bank[0]['exchange_rate'];
                                echo '<tbody>';
                               
                                echo '<tr>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    
                                    echo '<td>Opening Balance</td>';
                                    echo '<td>'.round($bank[0]['op_balance_dr']/$exchange_rate,2).'</td>';
                                    echo '<td>'.round($bank[0]['op_balance_cr']/$exchange_rate,2).'</td>';
                            
                                    $dr_amount += $bank[0]['op_balance_dr']/$exchange_rate;
                                    $cr_amount += $bank[0]['op_balance_cr']/$exchange_rate;
                                    
                                    $balance = ($dr_amount - $cr_amount);
                                    
                                    
                                    echo '<td>'.round($balance,2).'</td>';
                                   echo '<td></td>';
                                    
                                    //echo '<td>'.anchor('accounts/C_ledgers/edit/'.$list['id'],'Edit'). ' | ';
                                    //echo  anchor('accounts/C_ledgers/delete/'.$list['id'],' Delete'). '</td>';
                                    echo '</tr>';
                                
                                if(count($bank_entries))
                                {
                                $sno = 1;
                                foreach($bank_entries as $key => $list)
                                {
                                    echo '<tr>';
                                    // echo '<td>'.$sno++ .'</td>';
                                    echo '<td>'.$list['invoice_no'].'</td>';
                                    echo '<td>'.$list['date'].'</td>';
                                    
                                    $account_name = $this->M_groups->get_groups($list['dueTo_acc_code'],$_SESSION['company_id']);
                                    echo '<td>'.($langs == 'en' ? $account_name[0]['title'] : $account_name[0]['title_ur']).'</td>';
                                    echo '<td>'.round($list['debit'],2).'</td>';
                                    echo '<td>'.round($list['credit'],2).'</td>';
                            
                                    $dr_amount += $list['debit'];
                                    $cr_amount += $list['credit'];
                                    
                                    $balance = ($dr_amount - $cr_amount);
                                    
                                    
                                    echo '<td>'.round($balance,2).'</td>';
                                    echo '<td>'.$list['narration'].'</td>';
                            
                                    //echo '<td>'.anchor('accounts/C_ledgers/edit/'.$list['id'],'Edit'). ' | ';
                                    //echo  anchor('accounts/C_ledgers/delete/'.$list['id'],' Delete'). '</td>';
                                    echo '</tr>';
                                }
                                }
                                echo '</tbody>';
                                echo '<tfoot>';
                                echo '<tr><th></th><th></th>';
                                echo '<th>Total</th>';
                                echo '<th></th>';
                                echo '<th></th>';
                                echo '<th></th>';
                                echo '<th></th>';
                                    
                                echo '</tr>';
                                echo '</tfoot>';
                                echo '</table>';
                                
                                
                                ?>
                        </div> <!-- END tab_1_1-->
                        
						<div class="tab-pane" id="tab_1_2">
							<!-- BEGIN FORM-->
            				<form class="form-horizontal" role="form">
                            <?php foreach($bank as $values): ?>
            					<div class="form-body">
            						<h2 class="margin-bottom-20"> View banking Info - <?php echo $values['bank_name']; ?></h2>
            						<h3 class="form-section">Person Info</h3>
            						<div class="row">
            							<div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">bank_name:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['bank_name']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            							<!--/span-->
            							<div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">acc_holder_name:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['acc_holder_name']; ?>
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
            									<label class="control-label col-md-3">bank_branch:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['bank_branch']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            							<!--/span-->
            							<div class="col-md-6">
            								<div class="form-group">
            									<label class="control-label col-md-3">bank_account No:</label>
            									<div class="col-md-9">
            										<p class="form-control-static">
            											 <?php echo $values['bank_account_no']; ?>
            										</p>
            									</div>
            								</div>
            							</div>
            							<!--/span-->
            						</div>
            						<!--/row-->
            						
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
        <h4 class="modal-title">Cash Withdrawal</h4>
      </div>
      <div class="modal-body">
        <!-- BEGIN FORM-->
         <?php foreach($bank as $list): ?>
			<form action="<?php echo site_url('pos/C_banking/withDrawCash'); ?>" method="post" class="form-horizontal">
				<div class="form-body">
                    <input type="hidden" name="bank_id" value="<?php echo $list['id']; ?>" />
                     <input type="hidden" name="cash_acc_code" value="<?php echo $list['cash_acc_code']; ?>" />
                     <input type="hidden" name="bank_acc_code" value="<?php echo $list['bank_acc_code']; ?>" />
                     
                    <div class="form-group">
						<label class="col-md-3 control-label">Bank Name</label>
						<div class="col-md-6">
							<p class="form-control-static">
								 <?php echo $list['bank_name']; ?>
							</p>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label">A/C Holder Name</label>
						<div class="col-md-6">
							<p class="form-control-static">
								 <?php echo $list['acc_holder_name']; ?>
							</p>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label">A/C No.</label>
						<div class="col-md-6">
							<p class="form-control-static">
								 <?php echo $list['bank_account_no']; ?>
							</p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Amount</label>
						<div class="col-md-6">
							
								<input type="number" class="form-control" name="amount" placeholder="Enter Amount">
							
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
        <button type="submit" class="btn btn-info">Withdraw Cash</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      
      </form>
			<!-- END FORM-->
    </div>

  </div>
</div>