<div ng-controller="salesProductCtrl" ng-init="getAllProduct(); clearCart('<?php echo @$estimate_no; ?>');">
    <input type="hidden" ng-model="home_currency_symbol" ng-init="home_currency_symbol='<?php echo @$_SESSION['home_currency_symbol']; ?>'" />

    <div class='row'>
        <div class='col-xs-12 col-sm-7 col-md-7 col-lg-7'>
            <table class="table table-bordered table-hover">

                <thead>
                    <tr>
                        <td colspan="2"><input ng-change="addItemByBarcode(barcode)" autofocus ng-trim="true" ng-model="barcode" type="text" placeholder="Paste Barcode" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="search" ng:model="search" placeholder="Search Products" class="form-control" /></td>
                    </tr>
                    
                </thead>
                
            </table>
           
            <style>
                .flex-container {
                    display: flex;
                    background-color: #ccc;
                    margin-top:-20;
                    padding-left: 20px;
                    flex-direction: box;
                    flex-wrap: wrap;
                }

                .flex-container > div {
                    display: inline-flex;
                    float: left;
                    background-color: #f1f1f1;
                    padding: 8px;
                    text-align: center;
                    font-size: 12px;
                    
                }
                .flex-container > div:hover{
                background: #0b7ac9; /* make this whatever you want */
                color:#ccc;
                }
                .flex-container > div > img {
                    text-align: center;
                }
                .flex-container > div > span {
                    font-size: 14px;
                    font-weight: bold;
                    cursor: pointer;
                }
                .thumbnail {
                    margin-bottom: 5px;
                    
                }
            </style>
            <div class="flex-container">
                <div ng-show="loader" style="text-align: center;">
                    <img src="<?php echo base_url('images/wait.gif'); ?>" width="30" height="30" title="Loading" alt="Loading" />
                </div>
                <div ng:repeat="item in products | filter:search | limitTo:40">
                    <span ng-click='addItem(item.item_id,item.size_id)' ng-if="item.picture.length > 0"><img src="<?php echo base_url('images/items/thumb/');?>{{item.picture}}" alt="items" class="thumbnail" width="150" height="150">{{item.name}}</span>
                    <span ng-click='addItem(item.item_id,item.size_id)' ng-show="item.picture.length == 0"><img src="<?php echo base_url('images/items/thumb/food-default.png');?>{{item.picture}}" alt="items" class="thumbnail" width="150" height="150">{{item.name}}</span>
                    <span ng-click='addItem(item.item_id,item.size_id)' ng-show="item.service == 1"><img src="<?php echo base_url('images/items/thumb/food-default.png');?>{{item.picture}}" alt="items" class="thumbnail" width="150" height="150">{{item.name}}</span>
                                
                </div>
                
            </div>
        </div>
        <div class='col-xs-12 col-sm-5 col-md-5 col-lg-5'>
            <?php //echo $this->M_sales->getMAXSaleInvoiceNo(); 
            ?>
            <?php if ($saleType === '') { ?>
                <div class="row">
                    <form name="SaleForm" novalidate>
                        <label class="control-label col-sm-2" for=""><?php echo lang('sale') . ' ' . lang('type'); ?></label>
                        <div class="col-sm-4">
                            <div class="form-group">

                                <div class="radio-list">
                                    <label class="radio-inline" ng-init="saleType='cash'">
                                        <div class="radio" id="uniform-optionsRadios4">
                                            <input type="radio" name="saleType" ng-model="saleType" id="optionsRadios4" value="cash" checked="">
                                        </div> Cash
                                    </label>

                                    <label class="radio-inline">
                                        <div class="radio" id="uniform-optionsRadios5">
                                            <input type="radio" name="saleType" ng-model="saleType" id="optionsRadios5" value="credit">
                                        </div> Credit
                                    </label>

                                </div>
                            </div>
                        </div>

                        <label class="control-label col-sm-2" for=""><?php echo lang('register') . ' ' . lang('mode'); ?></label>
                        <div class="col-sm-4" ng-init="register_mode='sale'">
                            <div class="form-group">
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <div class="radio" id="uniform-optionsRadios4">
                                            <input type="radio" name="register_mode" ng-model="register_mode" id="optionsRadios4" value="sale" checked="">
                                        </div> Sale
                                    </label>

                                    <label class="radio-inline">
                                        <div class="radio" id="uniform-optionsRadios5">
                                            <input type="radio" name="register_mode" ng-model="register_mode" id="optionsRadios5" value="return">
                                        </div> Return
                                    </label>

                                </div>
                            </div>
                        </div>
                </div><!-- /. end row -->
            <?php } ?>

            <?php

            if ($saleType === 'cash') {
                echo '<input type="hidden" name="saleType" ng-model="saleType" ng-init="saleType=\'cash\'" value="cash"/>';
                echo '<input type="hidden" name="register_mode" ng-model="register_mode" ng-init="register_mode=\'sale\'" value="sale"/>';
            }
            if ($saleType === 'credit') {
                echo '<input type="hidden" name="saleType" ng-model="saleType" ng-init="saleType=\'credit\'" value="credit"/>';
                echo '<input type="hidden" name="register_mode" ng-model="register_mode" ng-init="register_mode=\'sale\'" value="sale"/>';
            }
            if ($saleType === 'cashReturn') {
                echo '<input type="hidden" name="saleType" ng-model="saleType" ng-init="saleType=\'cash\'" value="cash"/>';
                echo '<input type="hidden" name="register_mode" ng-model="register_mode" ng-init="register_mode=\'return\'" value="return"/>';
            }
            if ($saleType === 'creditReturn') {
                echo '<input type="hidden" name="saleType" ng-model="saleType" ng-init="saleType=\'credit\'" value="credit"/>';
                echo '<input type="hidden" name="register_mode" ng-model="register_mode" ng-init="register_mode=\'return\'" value="return"/>';
            }
            ?>

            <input type="hidden" ng-model="sale_date" readonly="" class="form-control" />
            <input type="hidden" ng-model="customer_id" ng-init="customer_id='1'" readonly="" class="form-control" />
            <input type="hidden" ng-model="emp_id" ng-init="emp_id='1'" readonly="" class="form-control" />
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?php echo lang('product'); ?></th>
                        <th><?php echo lang('quantity'); ?></th>
                        <th><?php echo lang('sale') . ' ' . lang('price'); ?></th>
                        <th><?php echo lang('disc'); ?></th>
                        <!-- <th><?php echo lang('tax'); ?></th> -->
                        <th><?php echo lang('total'); ?></th>
                        <th><a href ng:click="clearCart()" title="Clear All"><i class="fa fa-trash-o fa-1x" style="color:red;"></th>
                    </tr>
                </thead>
                <tbody>

                    <tr ng:repeat="item in invoice.items" ng-init="subForm='cellForm'+$index">

                        <td>
                            <input type="hidden" ng:model="item.name" class="form-control" readonly="" />
                            <strong>
                                <?php echo anchor('pos/Items/item_transactions/' . "{{item.item_id}}", "{{item.name}}", 'target="_blank"'); ?>
                                <!-- <a href="<?php echo base_url('/pos/Items/item_transactions') ?>/{{item.item_id}}" target="_blank"></a></strong> -->
                        </td>
                        <!-- IF SERVICE PRODUCT THEN NO MAX QTY FILED-->
                        <td ng-form="cellForm" ng-if="item.service || register_mode == 'return'">

                            <input type="number" name="quantity" ng:model="item.quantity" min="0" max="" required="" class="form-control" autocomplete="off" />
                            <div ng-show="cellForm.$dirty && cellForm.$invalid">
                                <small class="has-error" ng-show="cellForm.$error.required" style="color:red">Required!</small>
                                <small class="has-error" ng-show="cellForm.$error.number" style="color:red">Not valid number!</small>
                                <small class="has-error" ng-show="cellForm.$error.max" style="color:red">Exceed Stock!</small>
                            </div>

                        </td>

                        <!-- IF NOT SERVICE PRODUCT THEN INCLUDE MAX QTY FILED-->
                        <td ng-form="cellForm" ng-if="!item.service && register_mode !== 'return'">

                            <input type="number" name="quantity" ng:model="item.quantity" min="0" max="{{item.item_qty}}" required="" class="form-control" autocomplete="off" />
                            <div ng-show="cellForm.$dirty && cellForm.$invalid">
                                <small class="has-error" ng-show="cellForm.$error.required" style="color:red">Required!</small>
                                <small class="has-error" ng-show="cellForm.$error.number" style="color:red">Not valid number!</small>
                                <small class="has-error" ng-show="cellForm.$error.max" style="color:red">Exceed Stock!</small>
                            </div>

                        </td>
                        <!--<td><input type="text" ng:model="item.unit" class="form-control" autocomplete="off" /></td>-->

                        <input type="hidden" ng:model="item.cost_price" min="0" class="form-control" autocomplete="off" />
                        <td><input type="number" ng:model="item.unit_price" min="0" class="form-control" autocomplete="off" /></td>
                        <td><input type="number" ng:model="item.discount_value" min="0" class="form-control" autocomplete="off" /></td>
                        <!-- <td>
                            <small>{{(((item.quantity * item.unit_price)- item.discount_value)*item.tax_rate/100)}}</small>
                            <br /><span style="font-size: 8px;">{{item.tax_name}}</span>
                        </td> -->
                        <td>{{(((item.quantity * item.unit_price) - item.discount_value) + (((item.quantity * item.unit_price)- item.discount_value)*item.tax_rate/100)) | currency:home_currency_symbol}}</td>
                        <td>
                            <a href ng:click="removeItem($index)"><i class="fa fa-trash-o fa-1x" style="color:red;"></i></a>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="3" rowspan="4" ng-init="description=''"><textarea ng:model="description" rows="6" class="form-control" placeholder="Comments" cols="5"></textarea> </td>
                        <td><small>
                                <!-- Sub Total: -->
                            </small></td>
                        <td class="">
                            <!-- {{total() | currency:home_currency_symbol}} -->
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><small><?php echo lang('total') . ' ' . lang('disc'); ?>:</small></td>
                        <td colspan="2" ng-init="discount=0">
                            <!--<input type="number" ng:model="discount" min="0" class="form-control" autocomplete="off" /> -->
                            {{Tdiscount_value() | currency:home_currency_symbol}}

                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" ng:model="is_taxable" ng-checked="1" name="is_taxable" id="is_taxable" />
                            <small><label for="is_taxable"><?php echo lang('total') . ' ' . lang('tax'); ?>:</label></small>
                        </td>
                        <td colspan="2">
                            {{is_taxable == true ? total_tax() : 0 | currency:home_currency_symbol}}
                            <input type="hidden" name="total_tax" ng:model="total_tax" ng-value="{{total_tax()}}" />
                        </td>
                        
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

                            <?php if (@$_SESSION['multi_currency'] == 1) { ?>
                                <small>Net (local):</small>
                            <?php } ?>

                        </td>
                        <td  colspan="2">
                            <strong style="font-size: 1.8em;">{{(total()-Tdiscount_value()) | currency:home_currency_symbol}}</strong>

                        </td>
                        
                    </tr>

                    <tr>
                        <td colspan="5"><button type="submit" ng-click="saleProducts();" ng-disabled="cart_loader && SaleForm.$dirty && SaleForm.$invalid" class="btn btn-success">Save</button>
                            <img src="<?php echo base_url('images/wait.gif'); ?>" ng-show="cart_loader" width="30" height="30" title="Loading" alt="Loading" />
                        </td>
                        
                    </tr>

                </tbody>
            </table>

            </form>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add new customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="customerForm" action="">
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="Posting">Posting Type:</label>
                            <div class="col-sm-9">
                                <?php
                                $salesPostingTypeDDL = $this->M_postingTypes->get_SalesPostingTypesDDL();
                                echo form_dropdown('posting_type_id', $salesPostingTypeDDL, '', 'id="posting_type_id" class="form-control" required=""'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">Name:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter Name" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">Store Name:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="store_name" id="store_name" placeholder="Enter Store Name" required="">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">Email:</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="phone_no">Phone No:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Enter phone no">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="website">Website:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="website" id="website" placeholder="Enter website">
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div><!-- /. ng-controller = 'product ctrl' -->
<script>
    $(document).ready(function() {

        var site_url = '<?php echo site_url($langs); ?>';
        var path = '<?php echo base_url(); ?>';

        $("#customerForm").submit(function(event) {
            // Stop form from submitting normally
            event.preventDefault();

            /* Serialize the submitted form control values to be sent to the web server with the request */
            var formValues = $(this).serialize();

            console.log($('#item_id').val());

            if ($('#posting_type_id').val() == 0) {
                toastr.error("Please select posting_type_id", 'Error!');
            } else if ($('#first_name').val() == 0) {
                toastr.error("Please enter name", 'Error!');
            } else {
                // Send the form data using post
                $.post(site_url + "/pos/C_customers/create/", formValues, function(data) {
                    // Display the returned data in browser
                    //$("#result").html(data);
                    toastr.success("Data saved successfully", 'Success');
                    console.log(data);

                    setTimeout(function() {
                        location.reload();
                    }, 2000);

                });
            }
        });

    });
</script>