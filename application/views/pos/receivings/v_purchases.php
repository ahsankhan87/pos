<div ng-controller="purchaseCtrl" ng-init="getAllProduct();">
<input type="hidden" ng-model="home_currency_symbol" ng-init="home_currency_symbol='<?php echo @$_SESSION['home_currency_symbol']; ?>'" />

<div class='row'>
    
    <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
        <table class="table table-bordered table-hover">
            
            <thead>
            <tr>
                <td colspan="4"><input ng-change="addItemByBarcode(barcode)" autofocus ng-trim="true" ng-model="barcode" type="text" placeholder="Paste Barcode" class="form-control">
                </td>
            </tr>
             <tr>
                <td colspan="4"><input type="search" ng:model="search" placeholder="Search Products" class="form-control" /></td>
            </tr>   
             <tr>
                <!-- <th>Sizes</th> -->
                <th>Products</th>
                <th>Qty</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-show="loader">
                <td colspan="4" class="text-center"><img src="<?php echo base_url('images/wait.gif'); ?>" width="50" height="50" title="Loading" alt="Loading" /></td>
            </tr>
            <!-- <tr ng:repeat="item in products | filter:search | filter:{service:0} | limitTo:30"> -->
            <tr ng:repeat="item in products | filter:search | limitTo:30">

                <!-- <td ng-click='addItem(item.item_id,item.size_id)' style="cursor: pointer;"><small>{{item.size}}</small></td> -->
                <td ng-click='addItem(item.item_id,item.size_id)' style="cursor: pointer;"><a href="#"><small>{{item.name}}</small></a></td>
                <td ng-click='addItem(item.item_id,item.size_id)' style="cursor: pointer;"><small>{{item.quantity}}</small></td>
                <td ng-click='addItem(item.item_id,item.size_id)' style="cursor: pointer;"> <i class="fa fa-plus fa-1x" style="color:green;"></i></td>
                
            </tr>
            </tbody>
        </table>
    </div>
    
<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>
   <div class="row">
  <form action="" method="post" id="purchase_form" enctype=multipart/form-data> 
   <?php if($purchaseType === ''){ ?>
   <div class="form-group">
     
      <label class="control-label col-sm-2" for="">Purchase Type</label>
         <div class="col-sm-4">
            <div class="form-group">
     
                <div class="radio-list">
        			<label class="radio-inline" ng-init="purchaseType='cash'">
        			<div class="radio" id="uniform-optionsRadios4">
                    <input type="radio" name="purchaseType" ng-model="purchaseType" id="optionsRadios4" value="cash" checked=""></div> Cash </label>
        			
                    <label class="radio-inline">
        			<div class="radio" id="uniform-optionsRadios5">
                    <input type="radio" name="purchaseType" ng-model="purchaseType" id="optionsRadios5" value="credit" ></div> Credit </label>
    			
    		    </div>
            </div>  
      </div>
      
       <label class="control-label col-sm-2" for="">Register Mode</label>
       <div class="col-sm-4" ng-init="register_mode='receive'">
             <div class="form-group">
                 <div class="radio-list">
        			<label class="radio-inline">
        			<div class="radio" id="uniform-optionsRadios4">
                    <input type="radio" name="register_mode" ng-model="register_mode" id="optionsRadios4" value="receive" checked=""></div> Receive </label>
        			
                    <label class="radio-inline">
        			<div class="radio" id="uniform-optionsRadios5">
                    <input type="radio" name="register_mode" ng-model="register_mode" id="optionsRadios5" value="return"></div> Return </label>
    			
    		    </div>
            </div> 
      </div>
    </div><!-- /. end row -->
   
   <?php }?>
    
    <?php 
        
          if($purchaseType === 'cash')
            {
                echo '<input type="hidden" name="purchaseType" ng-model="purchaseType" ng-init="purchaseType=\'cash\'" value="cash"/>';
                 echo '<input type="hidden" name="register_mode" ng-model="register_mode" ng-init="register_mode=\'receive\'" value="receive"/>';
            }
          if($purchaseType === 'credit')
            {
                echo '<input type="hidden" name="purchaseType" ng-model="purchaseType" ng-init="purchaseType=\'credit\'" value="credit"/>';
                echo '<input type="hidden" name="register_mode" ng-model="register_mode" ng-init="register_mode=\'receive\'" value="receive"/>';
            } 
          if($purchaseType === 'cashReturn')
            {
                echo '<input type="hidden" name="purchaseType" ng-model="purchaseType" ng-init="purchaseType=\'cash\'" value="cash"/>';
                echo '<input type="hidden" name="register_mode" ng-model="register_mode" ng-init="register_mode=\'return\'" value="return"/>';
            } 
          if($purchaseType === 'creditReturn')
            {
                echo '<input type="hidden" name="purchaseType" ng-model="purchaseType" ng-init="purchaseType=\'credit\'" value="credit"/>';
                echo '<input type="hidden" name="register_mode" ng-model="register_mode" ng-init="register_mode=\'return\'" value="return"/>';
            }  
    ?>
    
   <div class="row">     
    <div class="form-group">
     
    <label class="control-label col-sm-2" for="">Supplier Account</label>
     <div class="col-sm-4" ng-init="supplier_id=0">
        <select class="form-control select2me" ng:model="supplier_id"  ng-change="getsupplierCurrency(supplier_id)" >
            <?php 
                foreach($supplierDDL as $key=>$values):
                    echo '<option value="'.$key.'">';
                    echo $values;
                    echo '</option>';
                endforeach;
            ?>
         </select>
         <?php echo anchor('pos/Suppliers/create','Add New <i class="fa fa-plus"></i>',''); ?>
     </div> 
    
    <label class="control-label col-sm-2" for="">Supplier Inv #</label>
     <div class="col-sm-4" ng-init="supplier_invoice_no=0">
         <input type="text" class="form-control" id="" name="supplier_invoice_no" placeholder="Supplier Invoice No" ng:model="supplier_invoice_no"/>
     </div>
     
    </div>
    
    </div><!-- /. end row -->
    <?php if(@$_SESSION['multi_currency'] == 1)
    {
    ?>
    <div class="row">
        <div class="form-group">
            
             <label class="control-label col-sm-2" for="">Currency</label>
             <div class="col-sm-4">
                 {{supplier_currency_name}} - {{supplier_currency_code}} 
                 <input type="hidden" ng-model="supplier_currency_id" class="form-control" required=""  min="0" />
                <img src="<?php echo base_url('images/wait.gif'); ?>" width="20" height="20" ng-show="curr_loader" title="Loading" alt="Loading" />
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
            <?php //var_dump($supplier_cust); ?>
            <label class="control-label col-sm-2" for="">Employee</label>
             <div class="col-sm-4" ng-init="emp_id=''">
                <select class="form-control select2me" ng:model="emp_id">
                <option value="">Select Employee</option>
                <?php 
                    foreach($emp_DDL as $key=>$values):
                        echo '<option value="'.$key.'">';
                        echo $values;
                        echo '</option>';
                    endforeach;
                ?>
             </select>
            
            </div> 
             
        </div>
          
        <div class="form-group">
         
            <label class="control-label col-sm-2" for="">Date</label>
             <div class="col-sm-4">
                 <input type="date" ng-model="sale_date" class="form-control" />
             </div>
         
        </div>
    
    </div><!-- /. end row -->
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th width="30%">Item Name</th>
                    <!-- <th width="15%">Sizes</th> -->
                    <th width="15%">Qty</th>
                    <!--<th width="15%">Unit</th>-->
                    <th width="15%">Cost Price</th>
                    <th width="15%">Unit Price</th>
					<th width="15%">Tax</th>
                    <th width="15%">Total</th>
                    <th width="5%"><a href ng:click="clearCart()" title="Clear All"><i class="fa fa-trash-o fa-1x" style="color:red;"></th>
				</tr>
			</thead>
			<tbody>
            
			 <tr ng:repeat="item in invoice.items">
                <td><input type="text" ng:model="item.name" class="form-control" readonly="" /></td> 
                <!-- <td><?php  echo form_dropdown('sizes_ID',$sizesDDL,'ng:model="item.size_id"','class="form-control" ng:model="item.size_id" readonly=""');?></td>           -->
                <td><input type="number" ng:model="item.quantity" min="0" class="form-control" autocomplete="off" /></td>
                <!--<td><input type="text" ng:model="item.unit" class="form-control" autocomplete="off" /></td>-->
                <td><input type="number" ng:model="item.cost_price" min="0" class="form-control" autocomplete="off" /></td>
                <td><input type="number" ng:model="item.unit_price" min="0" class="form-control" autocomplete="off" /></td>
                
                <!-- IF SERVICE THEN PICK THE UNIT PRICE -->
                <td  ng-if="item.service">
                        <small>{{((item.quantity * item.unit_price)*item.tax_rate/100)}}</small>
                        <br /><span style="font-size: 8px;">{{item.tax_name}}</span>
                </td>
                <!-- IF NOT SERVICE THEN PICK THE COST PRICE -->
                <td  ng-if="!item.service">
                        <small>{{((item.quantity * item.cost_price)*item.tax_rate/100)}}</small>
                        <br /><span style="font-size: 8px;">{{item.tax_name}}</span>
                </td>

                <!-- IF SERVICE THEN PICK THE UNIT PRICE -->
                <td ng-if="item.service">{{((item.quantity * item.unit_price) + (item.quantity * item.unit_price)*item.tax_rate/100) | currency:home_currency_symbol:2}}</td>
                <!-- IF NOT SERVICE THEN PICK THE COST PRICE -->
                <td ng-if="!item.service">{{((item.quantity * item.cost_price) + (item.quantity * item.cost_price)*item.tax_rate/100) | currency:home_currency_symbol:2}}</td>
                
                <td>
                    <a href ng:click="removeItem($index)" title="Remove"><i class="fa fa-trash-o fa-1x" style="color:red;"></i></a>
                </td>
            </tr>
            <tr>
                <td colspan="4" rowspan="4" ng-init="description=''">
                <textarea ng:model="description" rows="6" class="form-control" placeholder="Comments" cols="5"> </textarea>
                </td>
                <td><strong>Sub Total:</strong></td>
                <td class="lead">{{total() | currency:home_currency_symbol:2}}</td>
                 <td></td>
            </tr>
            <tr>
                <td><strong>Total Discount:</strong></td>
                <td ng-init="discount=0"><input type="number" ng:model="discount" min="0" class="form-control" autocomplete="off" /></td>
                <td></td>
            </tr>
            <tr>
                <td><small>Total Tax:</small></td>
                <td>
                {{total_tax() | currency:home_currency_symbol}}
                <input type="hidden" name="total_tax" ng:model="total_tax" ng-value="{{total_tax()}}" />
                </td>
                 <td></td>
            </tr>
            <!--
            <tr>
                <td><strong>Amount Due:</strong></td>
                <td ng-init="amount_due=0"><input type="number" ng:model="amount_due" ng-disabled="purchaseType !='cash'" class="form-control" autocomplete="off" /></td>
                 <td></td>
            </tr>
            -->
            <tr>
                <td> <strong>Net Total:</strong></td>
                <td class="lead">{{(total()-discount)-amount_due | currency:home_currency_symbol:2}}
                <br />
                    {{(((total()-discount)-amount_due)/exchange_rate) | currency:"home_currency_symbol":2}}
                </td>
                    <td></td>
            </tr>
          <tr>
            <td colspan="8">
                <input type="file" name="file" id="file" ng:model="file" />
            </td>
          </tr>  
          <tr>
            <td colspan="8"><button ng-click="purchaseProducts();"  ng-disabled="cart_loader" class="btn btn-success">Save</button>
            <img src="<?php echo base_url('images/wait.gif'); ?>" ng-show="cart_loader" width="30" height="30" title="Loading" alt="Loading" />
            </td>
          </tr>  
                
			</tbody>
		</table>
	</div>
    </form>
</div>
  
</div><!-- /. ng-controller = 'product ctrl' -->