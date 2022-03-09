<!-- BEGIN PAGE CONTENT-->
			<div class="invoice">
				<div class="row invoice-logo">
					<div class="col-sm-2 col-xs-2 invoice-logo-space">
						<?php if(!empty($Company[0]['image']) || $Company[0]['image'] != '')
                        {
                            echo '<img src="'.base_url('images/company/thumb/'.$Company[0]['image']).'" width="100" height="100" class="img-rounded" alt="picture"/>';    
                        }
                        ?>
                        
					</div>
                    <div class="col-sm-4 col-xs-4 text-capitalize">
                        
                            <h3><?php echo $Company[0]['name'];?></h3>
                            <span class="text-capitalize"><?php echo $Company[0]['address'];?></span><br />
                            <span class=""><?php echo $Company[0]['contact_no'];?></span>
                    </div>
					<div class="col-sm-6 col-xs-6">
						<p>
							 #<?php echo $invoice_no; ?> / <?php echo date('d, M Y',strtotime(@$receivings_items[0]['receiving_date'])); ?>
                             <span>User: <?php echo @$this->M_users->get_activeUsers(@$receivings_items[0]['user_id'])[0]['name']; ?><br />
						      <?php echo lang('name'); ?>:&nbsp;<?php echo @$this->M_suppliers->get_supplierName(@$receivings_items[0]['supplier_id']); ?>
                    </span> 
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
							<th class="hidden-480">
								 Quantity
							</th>
							<th class="hidden-480">
								 Unit Cost
							</th>
							<th>
								 Total
							</th>
						</tr>
						</thead>
						<tbody>
                        <?php 
                        $counter = 1;
                        $total = 0;
                        $discount =0;
                        $discount_total =0;
                        if($receivings_items)
                        {
                        foreach($receivings_items as $key => $list)
                        {
                            
                            $total_cost = ($list['item_cost_price']*$list['quantity_purchased']);
                            $discount = ($list['item_cost_price']*$list['quantity_purchased'])*$list['discount_percent']/100;
                            $item = $this->M_items->get_items($list['item_id']);
                            $size = $this->M_sizes->get_sizeName($list['size_id']);
                            if(@$_SESSION['multi_currency'] == 1){
                                $currency = $this->M_currencies->get_currencies($receivings_items[0]['currency_id']);
                                $symbol = $currency[0]['symbol'];
					        }else
                            {
                                $symbol = $_SESSION['home_currency_symbol'];
                            }
                            echo '<tr>';
                            echo '<td style="text-align:center;" >'.$counter++.'</td>';
                            echo '<td>'.$item[0]['name']. (isset($size) ? "-".$size : '').'</td>';
                            echo '<td style="text-align:left;" class="hidden-480">'.$item[0]['description'].'</td>';
                            echo '<td style="text-align:center;" class="hidden-480">'.$list['quantity_purchased'].'</td>';
                            echo '<td style="text-align:center;" class="hidden-480">'.$symbol.$list['item_cost_price'].'</td>';
                            echo '<td style="text-align:center;" >'.$symbol.$total_cost.'</td>';
                            
                            echo '</tr>';
                            
                            $total += ($list['item_cost_price']*$list['quantity_purchased']);
                            //$discount_total += (($list['item_cost_price']*$list['quantity_purchased'])*$list['discount_percent']/100);
                            
                        }
                        }
                        ?>
						
						</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-8">
                        <?php if(@$receivings_items[0]['description']){ ?>
						<div class="well">
                            <?php echo @$receivings_items[0]['description']; ?>
                        </div>
                        <?php } ?>
					</div>
					<div class="col-xs-4 invoice-block">
						<ul class="list-unstyled amounts">
							<li>
								<strong>Sub - Total amount:</strong> <?php echo @$currency[0]['symbol'].round($total,2); ?>
							</li>
							<li>
								<strong>Discount:</strong> <?php echo $discount_total=@$receivings_items[0]['discount_value']; ?>
							</li>
							
							<li>
								<strong>Grand Total:</strong> <?php echo @$currency[0]['symbol'].round($total-$discount_total,2); ?>
							</li>
						</ul>
					</div>
				</div>
                
                
			</div>
			<!-- END PAGE CONTENT-->