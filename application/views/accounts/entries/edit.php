<div ng-controller="editEntriesCtrl" ng-init="getAllProduct(); editEntryList('<?php echo @$invoice_no; ?>','1');">
<input type="hidden" ng-model="invoice_no" ng-init="invoice_no='<?php echo @$invoice_no; ?>'" >
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-reorder"></i><?php echo $main; ?>
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
					<a href="#portlet-config" data-toggle="modal" class="config"></a>
					<a href="javascript:;" class="reload"></a>
					<a href="javascript:;" class="remove"></a>
				</div>
			</div>
            <div class="portlet-body form" ng-init="getAllDetailAccounts()">
				<!-- BEGIN FORM-->
				<form action="#" id="entry_form" class="form-horizontal" >
                    <input type="hidden" id="url" value="<?php echo site_url($langs.'/accounts/C_entries/create') ?>" />
                    <input type="hidden" id="receipt_url" value="<?php echo site_url($langs.'/accounts/C_entries/receipt') ?>" />
                    
					<div class="form-body">
						<div class="alert alert-danger display-hide">
							<button class="close" data-close="alert"></button>
							<?php echo lang('error_msg'); ?>
						</div>
						<div class="alert alert-success display-hide">
							<button class="close" data-close="alert"></button>
							<?php echo lang('account').' '.lang('created'); ?>
						</div>
                        <div class="form-group">
							<label class="control-label col-md-2"><?php echo lang('date'); ?> </span></label>
							<div class="col-md-4">
								 <input type="date" name="tran_date" value="<?php echo date('Y-m-d'); ?>" ng-model="tran_date" class="form-control" placeholder="<?php echo lang('date'); ?>"/>
                            </div>
                            
                           <label class="control-label col-md-2">Entry No.</label>
							<div class="col-md-4">
								 <input type="text" name="entry_no" class="form-control" ng-model="entry_no" placeholder="<?php echo lang('entry_no'); ?>"/>
                            </div>
                            
						</div>
                        <!--
                        <div class="form-group">
							<label class="control-label col-md-3"><?php echo lang('name'); ?> </span></label>
							<div class="col-md-4">
								 <input type="text" name="name" class="form-control" placeholder="<?php echo lang('name'); ?>"/>
                            </div>
						</div>
                        
                        <div class="form-group">
							
						</div>
                        
						<div class="form-group" ng-init="getAllDetailAccounts()">
							<label class="control-label col-md-3"><?php echo lang('debit'); ?> <?php echo lang('entry'); ?> <span class="required">* </span></label>
							<div class="col-md-4">
                                <select class="form-control" ng-init="dr_ledger=0">
                                    <option value="0">Select Debit Account</option>
                                    <option ng-repeat="acc in detail_accounts" value="{{acc.account_code}}">{{acc.title}}</option>
                                </select>
								<?php //echo form_dropdown('dr_ledger',$accountDDL,'','class="form-control" class="select2me"'); ?>
     							
                            </div>
						</div>
                        
                        <div class="form-group">
							<label class="control-label col-md-3"><?php echo lang('debit'); ?> <?php echo lang('entry'); ?> <span class="required">* </span></label>
							<div class="col-md-4">
                                <?php echo form_dropdown('dr_ledger',$accountDDL,'','ng-model="dr_ledger" class="form-control" class="select2me"'); ?>
     							
                            </div>
						</div>
                        -->
                        
                        <div class="form-group">
						      <label class="control-label col-md-2"><?php echo lang('account'); ?><span class="required">* </span></label>
							<div class="col-md-4">
								<?php echo form_dropdown('account',$accountDDL,'','ng-model="account" class="form-control select2me" ng-change="get_ref_accounts(account)"'); ?>
							     
                            </div>
                            
                             <label class="control-label col-md-2">Reference Account<span class="required">* </span></label>
							<div class="col-md-4">
								<?php //echo form_dropdown('customer_id',$customersDDL,'','ng-model="customer_id" class="form-control"  ng-change="getCustomerCurrency(customer_id)"'); ?>
							     <select class="form-control select2me" id="ref_id" ng-model="ref_id" ng-change="getCustomerCurrency(ref_id)">
                                    <option value="">--Select Reference Accounts--</option>
                                    <option ng-repeat="ref in ref_accounts" value="{{ref.id}}">{{ref.store_name}}{{ref.name}}{{ref.bank_name}}</option>
                                 </select>
                            </div>
                            
                            
						</div>
                        
                        <div class="form-group">
							
                            <label class="control-label col-md-2"><?php echo lang('description'); ?> </label>
							<div class="col-md-4">
								<textarea name="narration" ng-model="narration" ng-init="narration=''" class="form-control" rows='3' cols='40'></textarea>
							</div>
						</div>
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<button type="button" ng-click="addItem1(account)" class="btn btn-success"><?php echo lang('add'); ?> entry</button>
						</div>
					</div>
				</form>
				<!-- END FORM-->
			</div>
		</div>
		<!-- END VALIDATION STATES-->
	</div>
</div>
	<h4><strong> Invoice No: {{invoice_no}}</strong></h4>
    <form name="entryFrom" novalidate="">
        <table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th width="38%">Account Name</th>
                    <th width="15%">Debit</th>
                    <!--<th width="15%">Unit</th>-->
                    <th width="15%">Credit</th>
                    <th width="15%">Description</th>
                    <th width="5%"><a href ng:click="clearCart()" title="Clear All"><i class="fa fa-trash-o fa-1x" style="color:red;"></th>
				</tr>
			</thead>
			<tbody>
            
			 <tr ng:repeat="item in entries.items">
                <td>{{item.title}}
                    <small ng-if="item.ref_id != 0 || item.isCust == 1">({{item.ref_name}}) </small>
                </td>
                <td><input type="number" ng:model="item.dr_amount"  min="0" class="form-control" autocomplete="off" /></td>
                    
                <td><input type="number" ng:model="item.cr_amount" min="0" class="form-control" autocomplete="off" /></td>
                    
                <td>{{item.narration}}</td>
                <td>
                    <a href ng:click="removeItem($index)"><i class="fa fa-trash-o fa-1x" style="color:red;"></i></a>
                </td>
                
             </tr>
             <tfoot>
                <tr>
                    <td>Total</td>
                    <td>{{total_dr()}}</td>
                    <td>{{total_cr()}}</td>
                    <td></td>
                    <td></td>
                </tr>
             
                <tr>
                    <td colspan="5"><button type="submit" ng-click="saleEntries();" ng-disabled="cart_loader" class="btn btn-success">Update</button>
                    <img src="<?php echo base_url('images/wait.gif'); ?>" ng-show="cart_loader" width="30" height="30" title="Loading" alt="Loading" />
                    </td>
                </tr>
            </tfoot>
            </tbody>
         </table>
      </form>   
</div><!-- Entries CTRL -->