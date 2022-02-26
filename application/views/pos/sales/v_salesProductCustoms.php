<div ng-controller="salesProductCtrl" ng-init="getAllProduct();">
<div class='row'>  
    <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
        <table class="table table-bordered table-hover">
            
            <thead>
            <tr>
                <td colspan="4"><input ng-paste="addItemByBarcode()" autofocus ng-trim="true" ng-model="barcode" type="text" placeholder="Paste Barcode" class="form-control">
                </td>
            </tr>
             <tr>
                <td colspan="4"><input type="search" ng:model="search" placeholder="Search Products" class="form-control" /></td>
            </tr> 
            <tr>
                <th>Size</th>
                <th>Products</th>
                <th>Qty</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            
            <tr ng-show="loader">
                <td colspan="4" class="text-center"><img src="<?php echo base_url('images/wait.gif'); ?>" width="30" height="30" title="Loading" alt="Loading" /></td>
            </tr>
            <tr ng:repeat="item in products | filter:search | limitTo:30">
                
                <td ng-click='addItem(item.item_id,item.size_id)' style="cursor: pointer;"><small>{{item.size}}</small></td>
                <td ng-click='addItem(item.item_id,item.size_id)' style="cursor: pointer;"><a href="#"><small>{{item.name}} {{item.expiry_date}}</small></a></td>
                <td ng-click='addItem(item.item_id,item.size_id)' style="cursor: pointer;"><small>{{item.quantity}}</small></td>
                <td ng-click='addItem(item.item_id,item.size_id)' style="cursor: pointer;"> <i class="fa fa-plus fa-1x" style="color:green;"></i></td>
                
            </tr>
            </tbody>
        </table>
    </div>
    
<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>
   
   <div class="row">
    <form name="SaleForm" novalidate>
       <label class="control-label col-sm-2" for="">Sale Type</label>
         <div class="col-sm-4">
            <div class="form-group">
     
                <div class="radio-list">
        			<label class="radio-inline" ng-init="saleType='cash'">
        			<div class="radio" id="uniform-optionsRadios4"> 
                    <input type="radio" name="saleType" ng-model="saleType" id="optionsRadios4" value="cash" checked=""> </div> Cash </label>
        			
                    <label class="radio-inline">
        			<div class="radio" id="uniform-optionsRadios5">
                    <input type="radio" name="saleType" ng-model="saleType" id="optionsRadios5" value="credit"  ></div> Credit </label>
    			
    		    </div>
            </div>  
      </div>
      
         <label class="control-label col-sm-2" for="">Register Mode</label>
         <div class="col-sm-4" ng-init="register_mode='sale'">
             <div class="form-group">
                 <div class="radio-list">
        			<label class="radio-inline">
        			<div class="radio" id="uniform-optionsRadios4">
                    <input type="radio" name="register_mode" ng-model="register_mode" id="optionsRadios4" value="sale" checked=""></div> Sale </label>
        			
                    <label class="radio-inline">
        			<div class="radio" id="uniform-optionsRadios5">
                    <input type="radio" name="register_mode" ng-model="register_mode" id="optionsRadios5" value="return"></div> Return </label>
    			
    		    </div>
            </div> 
      </div>
    </div><!-- /. end row -->
    
    <div class="row">
        <div class="form-group">
            <?php //var_dump($customersDDL); ?>
            <label class="control-label col-sm-2" for="">Customer</label>
             <div class="col-sm-4" ng-init="customer_id=''">
                <select class="form-control select2me" ng-change="getCustomerCurrency(customer_id)" ng:model="customer_id">
                <?php 
                    foreach($customersDDL as $key=>$values):
                        echo '<option value="'.$key.'">';
                        echo $values;
                        echo '</option>';
                    endforeach;
                ?>
             </select>
            
                <?php echo anchor('admin/pos/C_customers/create','Add New <i class="fa fa-plus"></i>',''); ?>
             </div> 
             
             <label class="control-label col-sm-2" for="">Sale Date</label>
             <div class="col-sm-4">
                 <input type="date" ng-model="sale_date" class="form-control" />
             </div>
        </div>
    </div>
    <?php if($supplier_cust) { ?>
    <div class="row">
        <div class="form-group">
            <?php //var_dump($supplier_cust); ?>
            <label class="control-label col-sm-2" for="">Supplier</label>
             <div class="col-sm-4" ng-init="supplier_id=''">
                <select class="form-control select2me" ng-change="getsupplierCurrency(supplier_id)" ng:model="supplier_id">
                <option value="">Select Supplier</option>
                <?php 
                    foreach($supplier_cust as $key=>$values):
                        echo '<option value="'.$values['id'].'" selected="selected">';
                        echo $values['name'];
                        echo '</option>';
                    endforeach;
                ?>
             </select>
            
            </div> 
             
        </div>
    </div>
    <?php } ?>
    
    <?php if(@$_SESSION['multi_currency'] == 1)
    {
    ?>
    <div class="row">
        
        
        <div class="form-group">
            
             <label class="control-label col-sm-2" for="">Currency</label>
             <div class="col-sm-4">
                 {{customer_currency_name}} - {{customer_currency_code}} 
                 <img src="<?php echo base_url('images/wait.gif'); ?>" width="20" height="20" ng-show="curr_loader" title="Loading" alt="Loading" />
                <input type="hidden" ng-model="customer_currency_id" class="form-control" required=""  min="0" />
                 
             </div>
             
             <label class="control-label col-sm-2" for="">Exchange Rate</label>
             <div class="col-sm-4">
                 <input type="number" ng-model="exchange_rate" class="form-control" required="" min="0" />
                       
             </div>
             <div ng-show="SaleForm.$dirty && SaleForm.$invalid">
                <small class="has-error" ng-show="exchange_rate.required" style="color:red">Required!</small>
                    
             </div>
        </div>
    </div>
    
    <?php } ?>
    
    <div class="row">
        <div class="form-group">
            <label class="control-label col-sm-2" for="">No of Pkg</label>
             <div class="col-sm-4">
                <input type="text" ng-model="no_of_pkg" class="form-control" />
             </div> 
             
             <label class="control-label col-sm-2" for="">Description</label>
             <div class="col-sm-4">
                 <input type="text" ng-model="pkg_desc" class="form-control" />
             </div>
        </div>
    </div>
   
    <div class="row">
        <div class="form-group">
            <label class="control-label col-sm-2" for="">GD#</label>
             <div class="col-sm-4">
                <input type="text" ng-model="gd_no" class="form-control" />
             </div> 
             
             <label class="control-label col-sm-2" for="">Date</label>
             <div class="col-sm-4">
                 <input type="date" ng-model="gd_date" class="form-control" />
             </div>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group">
            <label class="control-label col-sm-2" for="">AWB#</label>
             <div class="col-sm-4">
                <input type="text" ng-model="awb_no" class="form-control" />
             </div> 
             
             <label class="control-label col-sm-2" for="">Date</label>
             <div class="col-sm-4">
                 <input type="date" ng-model="awb_date" class="form-control" />
             </div>
        </div>
    </div>
   
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th width="38%">Item Name</th>
                    <th width="15%">Quantity</th>
                    <!--<th width="15%">Unit</th>-->
                    <th width="15%">Sale Price</th>
                    <th width="15%">Total</th>
                    <th width="5%"><a href ng:click="clearCart()" title="Clear All"><i class="fa fa-trash-o fa-1x" style="color:red;"></th>
				</tr>
			</thead>
			<tbody>
            
			 <tr ng:repeat="item in invoice.items" ng-init="subForm='cellForm'+$index">
                 
                   <td>
                   
                   <input type="text" ng:model="item.name" class="form-control" readonly="" /></td>           
                   
                   <!-- IF SERVICE PRODUCT THEN NO MAX QTY FILED-->
                   <td ng-form="cellForm" ng-if="item.service || register_mode == 'return'">
                    
                    <input type="number" name="quantity" ng:model="item.quantity" min="0" max=""  required="" class="form-control" autocomplete="off" />
                      <div ng-show="cellForm.$dirty && cellForm.$invalid">
                            <small class="has-error" ng-show="cellForm.$error.required" style="color:red">Required!</small>
                            <small class="has-error" ng-show="cellForm.$error.number" style="color:red">Not valid number!</small>
                            <small class="has-error" ng-show="cellForm.$error.max" style="color:red">Exceed Stock!</small>
                      </div>
                      
                    </td>  
                    
                    <!-- IF NOT SERVICE PRODUCT THEN INCLUDE MAX QTY FILED-->
                    <td ng-form="cellForm" ng-if="!item.service && register_mode !== 'return'">
                    
                    <input type="number" name="quantity" ng:model="item.quantity" min="0" max="{{item.item_qty}}"  required="" class="form-control" autocomplete="off" />
                      <div ng-show="cellForm.$dirty && cellForm.$invalid">
                            <small class="has-error" ng-show="cellForm.$error.required" style="color:red">Required!</small>
                            <small class="has-error" ng-show="cellForm.$error.number" style="color:red">Not valid number!</small>
                            <small class="has-error" ng-show="cellForm.$error.max" style="color:red">Exceed Stock!</small>
                      </div>
                      
                    </td>  
                    <!--<td><input type="text" ng:model="item.unit" class="form-control" autocomplete="off" /></td>-->
                    
                    <input type="hidden" ng:model="item.cost_price" min="0" class="form-control" autocomplete="off" />
                    <input type="hidden" ng:model="item.expiry_date" class="form-control" autocomplete="off" />
                    <td><input type="number" ng:model="item.unit_price" min="0" class="form-control" autocomplete="off" /></td>
                    <td>{{(item.quantity * item.unit_price) | currency:customer_currency_symbol}}</td>
                    <td>
                        <a href ng:click="removeItem($index)"><i class="fa fa-trash-o fa-1x" style="color:red;"></i></a>
                    </td>
                 
             </tr>
             <tr>
                <td colspan="2" rowspan="3" ng-init="description=''"><textarea ng:model="description" rows="6" class="form-control" placeholder="Comments" cols="5"></textarea> </td>
                <td><small>Sub Total:</small></td>
                <td class="">{{total() | currency:customer_currency_symbol}}</td>
                <td></td> 
            </tr>
            <tr>
                <td><small>Total Discount:</small></td>
                <td ng-init="discount=0"><input type="number" ng:model="discount" min="0" class="form-control" autocomplete="off" /></td>
                 <td></td>
            </tr>
            <!--
            <tr>
                <td><small>Amount Due:</small></td>
                <td ng-init="amount_due=0"><input type="number" ng:model="amount_due" ng-disabled="saleType !='cash'" class="form-control" autocomplete="off" /></td>
                 <td></td>
            </tr>
            -->
            <tr>
                <td><small>Net:</small><br />
                
                <?php if(@$_SESSION['multi_currency'] == 1){?>
                <small>Net (local):</small>
                <?php } ?>
                
                </td>
                <td>
                    {{(total()-discount)-amount_due | currency:customer_currency_symbol}}
                    
                    <?php if(@$_SESSION['multi_currency'] == 1){ ?>
                    <br />
                    {{((total()-discount)-amount_due)/exchange_rate | currency:"PRs"}}
                    <?php } ?>
                    
                </td>
                 <td></td>
            </tr>
            
            <tr>
                <td colspan="4"><button type="submit" ng-click="saleProducts();" ng-disabled="cart_loader && SaleForm.$dirty && SaleForm.$invalid" class="btn btn-success">Save</button>
                <img src="<?php echo base_url('images/wait.gif'); ?>" ng-show="cart_loader" width="30" height="30" title="Loading" alt="Loading" />
                </td>
                <td></td>
            </tr>
                
			</tbody>
		</table>
            
        </form>
	</div>
</div>
  
</div><!-- /. ng-controller = 'product ctrl' -->