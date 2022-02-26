<div ng-controller="suppliersCtrl">
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
						<i class="icon-bell"></i><?php echo ucwords($supplier[0]['name']); ?>
					</div>
					<div class="tools">
						<a href="" class="collapse"></a>
						<a href="#portlet-config" data-toggle="modal" class="config"></a>
						<a href="" class="reload"></a>
						<a href="" class="remove"></a>
					</div>
				</div>
				<div class="portlet-body">
                    <?php foreach($supplier as $list): ?>
        			
                    <form action="<?php echo site_url('pos/Suppliers/makePayment'); ?>" method="post" class="form-horizontal">
        			
                    	<div class="form-body" >
                            <input type="hidden" name="supplier_id" ng-model="supplier_id" ng-init="supplier_id=<?php echo $list['id']; ?>" value="<?php echo $list['id']; ?>" />
                           
                            <div class="form-group">
        						<label class="col-md-2 control-label">Supplier Name</label>
        						<div class="col-md-4">
        							<p class="form-control-static">
        								 <?php echo ucwords($list['name']); ?>
        							</p>
                                      <?php if(@$_SESSION['multi_currency'] == 1)
                                        {
                                            echo '<small>';
            								$currency = $this->M_currencies->get_currencies($list['currency_id']); 
                                                 echo @$currency[0]['name'].' - '.@$currency[0]['code'];
                                                 
                							echo '</small>';
                                        }
                					 ?>
        						</div>
                                
        					   <label class="col-md-2 control-label">Payment Date</label>
        						<div class="col-md-4">
        							<p class="form-control-static">
        								 <input type="date" class="form-control" ng-model="payment_date" name="payment_date" />
        							</p>
        						</div>
                            
                            </div>
                            
                            <div class="form-group">
             
                                 <label class="control-label col-sm-2" for="">Payment Type</label>
                                     <div class="col-sm-4">
                                         <div class="checkbox">
                                         <label class="control-label" for="cash">Cash: </label><input type="radio" checked="" id="cash" ng-model="payment_type" ng-init="payment_type='cash'" name="payment_type" value="cash" class="form-control" />
                                         <label class="control-label" for="bank">Cheque: </label><input type="radio" id="bank" ng-model="payment_type" name="payment_type"  value="bank" class="form-control" />
                                        </div> 
                                     </div>
                            
                            <div id="bank_accounts" style="display: none;">
             
                                <label class="control-label col-sm-2" for="">Bank Accounts</label>
                                 <div class="col-sm-4">
                                     <?php echo form_dropdown('bank_id',$activeBanks,'','ng-model="bank_id" id="bank_id" class="form-control"') ?>
                                    
                                 </div> 
               
                            </div>
                            </div>
                            
        					<div class="form-group">
                            		
        						<label class="col-md-2 control-label">Total Amount</label>
        						<div class="col-md-4">
        							
        							<input type="text" class="form-control" required="" ng-model="amount" ng-change="update()"  ng-init="amount=''" name="amount" autocomplete="off" placeholder="Enter Amount" autocomplete="off">
        							
        						</div>
        					<?php if(@$_SESSION['multi_currency'] == 1)
                            {
                            ?>
                            
                            
        						<label class="col-md-2 control-label">Exchange Rate</label>
        						<div class="col-md-4">
        							<input type="text" class="form-control" required="" ng-model="exchange_rate" ng-init="exchange_rate='<?php echo $this->M_currencies->get_currency_rate($_SESSION['home_currency_code'], @$currency[0]['code'], 1);?>'" name="exchange_rate" value="<?php echo $this->M_currencies->get_currency_rate($_SESSION['home_currency_code'], @$currency[0]['code'], 1);?>" placeholder="Enter Exchange Rate">
        					
        						</div>
                                <input type="hidden" class="form-control" ng-model="multi_currency" ng-init="multi_currency=<?php echo @$_SESSION['multi_currency'] ?>" >
                            
                            <?php }else{ ?> 
                            <input type="hidden" class="form-control" ng-model="multi_currency" ng-init="multi_currency=<?php echo @$_SESSION['multi_currency'] ?>" >
                            
                            <?php } ?>
                            
        					</div>
                            <div class="form-group">
                            
                                <label class="col-md-2 control-label">Discount Amount</label>
        						<div class="col-md-4">
        							
        								<input type="number" class="form-control" ng-model="discount_amount" ng-init="discount_amount=''" name="discount_amount" placeholder="Enter Discount Amount">
        							
        						</div>
                                
        						<label class="col-md-2 control-label">Comment</label>
        						<div class="col-md-4">
        							
        								<textarea name="narration" name="comment" ng-model="comment" ng-init="comment=''" class="form-control"></textarea>
        							
        						</div>
        					</div>
        				</div>
        				
                        
        			<?php endforeach; ?>
                   
                   <!-- breakup amount by invoice wise like Quick book     
                        <br />
                        <h3>Outstanding Transactions</h3>
                        <table class="table table-striped table-hover" ng-init="GetCreditPurchase(<?php echo $supplier[0]['id']; ?>)" id="sample_">
                                <thead>
                                    <tr>
                                        <th>Invoice No.</th>
                                        <th>Date</th>
                                        <th>Original Amount</th>
                                        <th>Balance</th>
                                        <th>Payment</th>
                                    </tr>
                                </thead>
                                <tr ng-repeat="credit in CreditPurchase">
                                    
                                    <td>{{credit.invoice_no}}</td>
                                    <td>{{credit.sale_date}}</td>
                                    <?php if(@$_SESSION['multi_currency'] == 1)
                                    {
                                    ?>
                                    <td>{{(credit.total_amount*credit.exchange_rate | currency:"<?php echo @$currency[0]['symbol'] ?>")}}</td>
                                    <td>{{(credit.total_amount-credit.paid)*credit.exchange_rate | currency:"<?php echo @$currency[0]['symbol'] ?>"}}<br />
                                    <small>{{(credit.total_amount-credit.paid) | currency:"PRs"}}</small>
                                    </td>
                                    <td>
                                        <input type="text" ng-model="cr_amount" ng-init="cr_amount=credit.balance | currency" name="cr_amount[]" class="form-control" />
                                        <input type="hidden" ng-model="invoice_no" ng-init="invoice_no=credit.invoice_no" name="invoice_no[]"  value="{{credit.invoice_no}}"class="form-control" />
                                        <input type="hidden" ng-model="paid" ng-init="paid=credit.paid" name="paid[]"  value="{{credit.paid}}"class="form-control" />
                                        <input type="hidden" ng-model="prev_exchange_rate" ng-init="prev_exchange_rate=credit.exchange_rate" name="prev_exchange_rate[]"  value="{{credit.exchange_rate}}"class="form-control" />
                                    
                                    </td>  
                                    <?php }else { ?>
                                    <td>{{(credit.total_amount | currency:"<?php echo @$_SESSION['home_currency_symbol'] ?>")}}</td>
                                    <td>{{(credit.total_amount-credit.paid | currency:"<?php echo @$_SESSION['home_currency_symbol'] ?>")}}</small>
                                    </td>
                                    <td>
                                        <input type="text" ng-model="cr_amount" ng-init="cr_amount=credit.balance" name="cr_amount[]" class="form-control" />
                                        <input type="hidden" ng-model="invoice_no" ng-init="invoice_no=credit.invoice_no" name="invoice_no[]"  value="{{credit.invoice_no}}"class="form-control" />
                                        <input type="hidden" ng-model="paid" ng-init="paid=credit.paid" name="paid[]"  value="{{credit.paid}}"class="form-control" />
                                        <input type="hidden" ng-model="prev_exchange_rate" ng-init="prev_exchange_rate=credit.exchange_rate" name="prev_exchange_rate[]"  value="{{credit.exchange_rate}}"class="form-control" />
                                    
                                    </td>
                                    <?php } ?>
                                </tr>
                        -->
                                <?php
                                //initialize
                                //$dr_amount = 0.00;
//                                $cr_amount = 0.00;
//                                $balance = 0.00;
//                                
//                                foreach($creditSales as $key => $list)
//                                {
//                                    $balance = round(($list['total_amount']-$list['paid'])*$list['exchange_rate'],2);
//                                    
//                                    echo '<tr>';
//                                    echo '<td>'.$list['invoice_no'].'</td>';
//                                    echo '<td>'.date('d-m-Y',strtotime($list['sale_date'])).'</td>';
//                                    echo '<td>'.round($list['total_amount']*$list['exchange_rate'],2).'</td>';
//                                    echo '<td>'.$balance.'</td>';
//                                    echo '<td><input type="text" ng-model="amount_'.$key.'" ng-init="amount_'.$key.'='.$balance.'" class="form-control" ></td>';
//                                    echo '</tr>';
//                                }
//                                echo '</tbody>';
//                                echo '</tfoot>';
//                                echo '<tr><th></th>';
//                                echo '<th>Total</th>';
//                                echo '<th>'.$dr_amount.'</th>';
//                                echo '<th>'.$cr_amount.'</th>';
//                                
//                                echo '</tr>';
//                                echo '</tfoot>';
                                
                                ?>
                                
                                </table>
                                
                                <div class="form-group">
        						<label class="col-md-2 control-label"></label>
        						<div class="col-md-4">
        							
        							<button type="submit" class="btn btn-info" ng-disabled="disable"  onclick="return confirm('Are you sure you want to save?')">Save</button>
                                    <button type="button" class="btn btn-default" onclick="window.history.back()">Back</button>
                    
        						</div>
        					</div>
              </div><!-- fomr panel -->
              
              </form>
        			<!-- END FORM-->
                </div>
			</div> <!-- End Portlet -->
				
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
</div><!-- /.supplierCTRL -->