<div ng-controller="estimateProductCtrl" ng-init="getAllProduct();">
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
            <?php
            echo '<input type="hidden" name="saleType" ng-model="saleType" ng-init="saleType=\'estimate\'" value="estimate"/>';
            echo '<input type="hidden" name="register_mode" ng-model="register_mode" ng-init="register_mode=\'estimate\'" value="estimate"/>';

            ?>

            <div class="row">
                <div class="form-group">
                    <?php //var_dump($customersDDL); 
                    ?>

                    <label class="control-label col-sm-2" for="">Customer</label>
                    <div class="col-sm-4" ng-init="customer_id='<?php echo $customer_id; ?>'">
                        <select class="form-control <?php echo ($customer_id == '' ? 'select2me' : '') ?>" ng-change="getCustomerCurrency(customer_id)" ng:model="customer_id">
                            <?php
                            foreach ($customersDDL as $key => $values) :
                                echo '<option value="' . $key . '">';
                                echo $values;
                                echo '</option>';
                            endforeach;
                            ?>
                        </select>

                        <?php echo anchor('pos/C_customers/create', 'Add New <i class="fa fa-plus"></i>', ''); ?>
                    </div>

                    <label class="control-label col-sm-2" for="">Sale Date</label>
                    <div class="col-sm-4">
                        <input type="date" ng-model="sale_date" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="form-group">
                    <?php //var_dump($supplier_cust); 
                    ?>
                    <label class="control-label col-sm-2" for="">Employee</label>
                    <div class="col-sm-4" ng-init="emp_id=''">
                        <select class="form-control select2me" ng:model="emp_id">
                            <option value="">Select Employee</option>
                            <?php
                            foreach ($emp_DDL as $key => $values) :
                                echo '<option value="' . $key . '">';
                                echo $values;
                                echo '</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>

                    <label class="control-label col-sm-2" for="">Delivery Date</label>
                    <div class="col-sm-4">
                        <input type="date" ng-model="delivery_date" class="form-control" />
                    </div>

                </div>

                <?php if ($supplier_cust) { ?>
                    <div class="form-group">
                        <?php //var_dump($supplier_cust); 
                        ?>
                        <label class="control-label col-sm-2" for="">Supplier</label>
                        <div class="col-sm-4" ng-init="supplier_id=''">
                            <select class="form-control select2me" ng-change="getsupplierCurrency(supplier_id)" ng:model="supplier_id">
                                <option value="">Select Supplier</option>
                                <?php
                                foreach ($supplier_cust as $key => $values) :
                                    echo '<option value="' . $values['id'] . '" selected="selected">';
                                    echo $values['name'];
                                    echo '</option>';
                                endforeach;
                                ?>
                            </select>

                        </div>

                    </div>
                <?php } ?>

            </div>

            <table class="table table-bordered table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="38%">Item Name</th>
                        <th width="15%">Quantity</th>
                        <th width="15%">Sale Price</th>
                        <th width="15%">Disc</th>
                        <th width="15%">Tax</th>
                        <th width="15%">Total</th>
                        <th width="5%"><a href ng:click="clearCart()" title="Clear All"><i class="fa fa-trash-o fa-1x" style="color:red;"></th>
                    </tr>
                </thead>
                <tbody>

                    <tr ng:repeat="item in invoice.items" ng-init="subForm='cellForm'+$index">

                        <td>

                            <input type="text" ng:model="item.name" class="form-control" readonly="" />
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
                        <td>
                            <small>{{(((item.quantity * item.unit_price)- item.discount_value)*item.tax_rate/100)}}</small>
                            <br /><span style="font-size: 8px;">{{item.tax_name}}</span>
                        </td>
                        <td>{{(((item.quantity * item.unit_price) - item.discount_value) + (((item.quantity * item.unit_price)- item.discount_value)*item.tax_rate/100)) | currency:home_currency_symbol}}</td>
                        <td>
                            <a href ng:click="removeItem($index)"><i class="fa fa-trash-o fa-1x" style="color:red;"></i></a>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="4" rowspan="5" ng-init="description=''"><textarea ng:model="description" rows="6" class="form-control" placeholder="Comments" cols="5"></textarea> </td>
                        <td><small>
                                <!-- Sub Total: -->
                            </small></td>
                        <td class="">
                            <!-- {{total() | currency:home_currency_symbol}} -->
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><small>Total Disc:</small></td>
                        <td ng-init="discount=0">
                            <!--<input type="number" ng:model="discount" min="0" class="form-control" autocomplete="off" /> -->
                            {{Tdiscount_value() | currency:home_currency_symbol}}

                        </td>
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

                    <tr>
                        <td><small>Advance:</small></td>
                        <td ng-init="advance=0"><input type="number" ng:model="advance" class="form-control" autocomplete="off" /></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><small>Net:</small><br />

                        </td>
                        <td>
                            <!-- Total Value discount
                    {{(total()-discount) | currency:home_currency_symbol}} -->

                            <!-- Total discount percent -->
                            {{(total()-Tdiscount_value()-advance) | currency:home_currency_symbol}}

                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td colspan="6"><button type="submit" ng-click="saleProducts();" ng-disabled="cart_loader && SaleForm.$dirty && SaleForm.$invalid" class="btn btn-success">Save</button>
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