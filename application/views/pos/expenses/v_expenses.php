<div ng-controller="expenseCtrl" ng-init="getAllExpenses();">
<input type="hidden" ng-model="home_currency_symbol" ng-init="home_currency_symbol='<?php echo @$_SESSION['home_currency_symbol']; ?>'" />

<div class='row'>

    <div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'>
        <table class="table table-bordered table-hover">
            
            <thead>
             <tr>
                <td colspan="2"><input type="search" ng:model="search" placeholder="Search Expenses" class="form-control" /></td>
            </tr>   
             <tr>
                <th>Expense Accounts</th>
                <th></th>
                
            </tr>
            </thead>
            <tbody>
            
            <tr ng:repeat="item in allExpenses | filter:search">
                <td ng-click='addItem(item.id)' style="cursor: pointer;">{{item.title}}</td>
                
                <td ng-click='addItem(item.id)' style="cursor: pointer;"> <i class="fa fa-plus fa-1x" style="color:green;"></i></td>
            </tr>
            </tbody>
        </table>
    </div>
    
	<div class='col-xs-9 col-sm-9 col-md-9 col-lg-9'>

<div class="row">
   <div class="form-group">
     
        <label class="control-label col-sm-2" for="">Cash Account
        <div class="small" style="color:#999;">Please Select Cash Account</div></label>
         <div class="col-sm-4">
             
              <select class="form-control select2me" ng:model="cash_account" ng-change="get_ref_accounts(cash_account)" ng:init="cash_account='1001'">
                <?php 
                    foreach($cash_account as $key=>$values):
                        echo '<option value="'.$key.'">';
                        echo $values;
                        echo '</option>';
                    endforeach;
                ?>
             </select>
         </div> 
        
        <label class="control-label col-sm-2" for="">Ref Account <br><br> Date</label>
         <div class="col-sm-4">
                <select class="form-control select2me" id="ref_id" ng-model="ref_id" ng-change="getCustomerCurrency(ref_id)">
                    <option value="">--Select Reference Accounts--</option>
                    <option ng-repeat="ref in ref_accounts" value="{{ref.id}}">{{ref.store_name}}{{ref.name}}{{ref.bank_name}}</option>
                </select>
             <input type="date" ng-model="exp_date" class="form-control" />
         </div>
    </div>
</div>
<div class="row">
        <label class="control-label col-sm-2" for="">Tax Account
        <div class="small" style="color:#999;">Please Select Tax Account</div></label>
         <div class="col-sm-4">
             
              <select class="form-control select2me" ng:model="tax_account" ng:init="tax_account='2002'">
                <?php 
                    foreach($cash_account as $key=>$values):
                        echo '<option value="'.$key.'">';
                        echo $values;
                        echo '</option>';
                    endforeach;
                ?>
             </select>
         </div> 
        
    <div class="form-group">
        <label class="control-label col-sm-2" for="">Supplier Invoice #</label>
         <div class="col-sm-4">
             <input type="text" ng-model="supplier_invoice_no" class="form-control" />
         </div>
    </div>
</div>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th width="38%">Expense Account</th>
                    <th width="15%">Amount</th>
                    <th>Tax</th>
                    <th>Description</th>
                    <th width="15%">Total</th>
                    <th width="5%"><a href ng:click="clearCart()"><i class="fa fa-trash-o fa-1x" style="color:red;"></i></a></th>
				</tr>
			</thead>
			<tbody>
            
			 <tr ng:repeat="item in expense.items">
                <td><input type="text" ng:model="item.title" class="form-control" readonly="" /></td>
                 <input type="hidden" id=""  ng:model="item.id"  class="form-control"  />           
                <td><input type="number" id=""  ng:model="item.amount"  class="form-control"  /></td>
                <td><?php echo form_dropdown('item.tax_id',$taxesDDL,'','ng:model="item.tax_id" class="form-control select2me"'); ?></td>
                <td><textarea ng:model="item.description" class="form-control"></textarea></td>
                <td>{{item.amount + (item.amount*item.tax_id/100)}}</td>
                <td>
                    <a href ng:click="removeItem($index)"><i class="fa fa-trash-o fa-1x" style="color:red;"></i></a>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Total:</strong></td>
                <td class="lead">{{total() | currency:home_currency_symbol}}</td>
                <td></td> 
            </tr>
              <tr>
                <td colspan="5"><button ng-click="saveExpenses();" ng-disabled="cart_loader" class="btn btn-success">Save</button>
              <img src="<?php echo base_url('images/wait.gif'); ?>" ng-show="cart_loader" width="30" height="30" title="Loading" alt="Loading" />
            </td>
            </tr>  
                
               
			</tbody>
		</table>
	</div>
</div>
  
</div><!-- /. ng-controller = 'product ctrl' -->