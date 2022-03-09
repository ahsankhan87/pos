<!-- BEGIN PAGE CONTENT-->
			<div class="invoice nohead">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h3 class="text-center">EXPENSES INVOICE</h3>
                    </div>
                </div>
				<div class="row">
					
					<div class="col-sm-6 col-xs-6 invoice-no">
						<p>
							 <strong>Invoice # </strong>&nbsp;<?php echo $invoice_no; ?>
                             
						</p>
					</div>
                    
                    <div class="col-sm-6 col-xs-6 invoice-right">
						<p>
							 <strong>Dated</strong>: <?php echo date('d-m-Y',strtotime(@$sales_items[0]['sale_date'])); ?>
                             <br /><strong><?php echo lang('user'); ?>:</strong>&nbsp;<?php echo @$this->M_users->get_activeUsers(@$sales_items[0]['user_id'])[0]['name']; ?>
                             
						</p>
					</div>
				</div>
				
                <div class="row">
					
					<div class="col-sm-6 col-xs-6">
						<p>
							 <strong>Bill to:-</strong>&nbsp; <?php echo @$this->M_customers->get_CustomerName(@$sales_items[0]['customer_id']); ?></span>
                             <br />
                             <strong>No of pkg:</strong>&nbsp;<?php echo @$sales_items[0]['no_of_pkg']; ?>
                             <br />
                             <strong>GD#:</strong>&nbsp;<?php echo @$sales_items[0]['gd_no']; ?>
                             <br />
                             <strong>AWB#:</strong>&nbsp;<?php echo @$sales_items[0]['awb_no']; ?>
						</p>
					</div>
                    
                    <div class="col-sm-6 col-xs-6">
						<p>
							 <br />
                             <strong>Description:</strong>&nbsp; <?php echo @$sales_items[0]['pkg_desc']; ?>
                             <br />
                             <strong>Dated:</strong>&nbsp;<?php echo date('d-m-Y',strtotime(@$sales_items[0]['gd_date'])); ?>
                             <br />
                             <strong>Dated:</strong>&nbsp;<?php echo date('d-m-Y',strtotime(@$sales_items[0]['awb_date'])); ?>
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<table class="table table-striped table-hover table-condensed">
						<thead>
						<tr>
							<th>
								 #
							</th>
							<th>
								 Item
							</th>
							<th class="hidden-480">
								 Description
							</th>
							<!--
                            <th class="hidden-480">
								 Quantity
							</th>
							
                            <th class="hidden-480">
								 Unit Cost
							</th>
							-->
                            <th>
								 Amount
							</th>
                            <!--<th class="hidden-480">IMPORT</th>
                            <th class="hidden-480">EXPORT</th>-->
						</tr>
						</thead>
						<tbody>
                        <?php 
                        $counter = 1;
                        $total = 0;
                        $discount =0;
                        $discount_total =0;
                        //var_dump($sales_items);
                        foreach($sales_items as $key => $list)
                        {
                            
                            $total_cost = ($list['item_unit_price']*$list['quantity_sold']);
                            $discount = ($list['item_unit_price']*$list['quantity_sold'])*$list['discount_percent']/100;
                            $item = $this->M_items->get_items($list['item_id']);
                            $size = $this->M_sizes->get_sizeName($list['size_id']);
                            if(@$_SESSION['multi_currency'] == 1){
                                $currency = $this->M_currencies->get_currencies($sales_items[0]['currency_id']);
                                $symbol = $currency[0]['symbol'];
					        }else
                            {
                                $symbol = $_SESSION['home_currency_symbol'];
                            }
                            
					
                            echo '<tr>';
                            echo '<td style="text-align:center;" >'.$counter++.'</td>';
                            echo '<td>'.$item[0]['name']. (isset($size) ? "-".$size : '').'</td>';
                            echo '<td style="text-align:left;" class="hidden-480">'.$item[0]['description'].'</td>';
                            //echo '<td style="text-align:center;" class="hidden-480">'.$list['quantity_sold'].'</td>';
                            //echo '<td style="text-align:center;" class="hidden-480">'.$symbol.$list['item_unit_price'].'</td>';
                            echo '<td style="text-align:center;" >'.$symbol.$total_cost.'</td>';
                            //echo '<td style="text-align:center;" class="hidden-480"></td>';
                            //echo '<td style="text-align:center;" class="hidden-480"></td>';
                            echo '</tr>';
                            
                            $total += ($list['item_unit_price']*$list['quantity_sold']);
                            //$discount_total += (($list['item_unit_price']*$list['quantity_sold'])*$list['discount_percent']/100);
                            
                        }
                        ?>
						
						</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-8">
                        <?php if(@$sales_items[0]['description']){ ?>
						<div class="well">
                            <?php echo @$sales_items[0]['description']; ?>
                        </div>
                        <?php } ?>
					</div>
					<div class="col-xs-4 invoice-block">
                   	<ul class="list-unstyled amounts">
							<li>
								<strong>Sub - Total amount:</strong> <?php echo $symbol.round($total,2); ?>
							</li>
							<li>
								<strong>Discount:</strong> <?php echo $discount_total=@$sales_items[0]['discount_value']; ?>
							</li>
							
							<li>
								<strong>Grand Total:</strong> <?php echo $symbol.round(@$total-$discount_total,2); ?>
							</li>
						</ul>
					</div>
				</div>
                <br />
                <div class="text-center">Developed by: <i>kasbook.com</i></div>
        
			</div>
			<!-- END PAGE CONTENT-->