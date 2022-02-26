<div class="row hidden-print">
    <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
        <a href="<?php echo site_url('trans/C_receivings') ?>" class="btn btn-primary"><i class="fa fa-arrow-left fa-fw"></i>Purchases</a>
        <a href="javascript:window.print()" class="btn btn-info"><i class="fa fa-print fa-fw"></i>Print</a>
    </div>
</div>
<script>
//auto load print screen when page load
//window.onload = function() { window.print(); }
</script>

<section id="purchase_receipt">
<div class="row">
            <div class="col-sm-2 col-sm-offset-2 text-left">
                <?php if(!empty($Company[0]['image']) || $Company[0]['image'] != '')
                {
                    echo '<img src="'.base_url('images/company/thumb/'.$Company[0]['image']).'" width="100" height="100" class="img-rounded" alt="picture"/>';    
                }
                ?>
            </div>
            <div class="col-sm-4 col-xs-4 text-center">
                
                <div class="lead text-capitalize" style="margin: 0;"><?php echo $Company[0]['name'];?></div>
            
                <span class="text-capitalize"><?php echo $Company[0]['address'];?></span><br />
                <span class=""><?php echo $Company[0]['contact_no'];?></span>
        
            </div>
            
</div>
        
        
<div class="row">
    <div class="col-sm-8 col-sm-offset-2  text-center">
    
        <?php

            if($receivings_items)
            {
            ?>
            
            <div class="lead text-uppercase"><?php echo ($receivings_items[0]['register_mode'] == 'receive' ? '' : 'return'); ?> purchase invoice</div>
            
            <table class="table table-default-header table-noborde" >
            
            <thead>
                <tr>
                    <th>
                    <?php echo lang('invoice').' '.lang('number'); ?> &nbsp;&nbsp;:&nbsp;&nbsp; <?php echo $invoice_no; ?> <br />
                    <?php echo lang('name'); ?> &nbsp;&nbsp;:&nbsp;&nbsp; <?php echo @$this->M_suppliers->get_supplierName($receivings_items[0]['supplier_id']); ?>
                    </th>
                    <th></th>
                   <th>
                   <?php echo lang('user'); ?>&nbsp;&nbsp;:&nbsp;&nbsp; <?php echo @$this->M_users->get_activeUsers($receivings_items[0]['user_id'])[0]['name']; ?><br />
                   <?php echo lang('date'); ?>&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo date('d, M Y',strtotime($receivings_items[0]['receiving_date'])); ?>
                   </th> 
                </tr>
            </thead>
            </table>
                        
            <table class="table table-default-header table-condensed" >
            
            <thead>
                
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody class="text-left">
            <?php
            $counter = 0;
            $total = 0;
            $discount =0;
            $discount_total =0;
            
            foreach($receivings_items as $key => $list)
            {
                $counter++;
                $total_cost = ($list['item_cost_price']*$list['quantity_purchased']);
                $discount = ($list['item_cost_price']*$list['quantity_purchased'])*$list['discount_percent']/100;
                
                echo '<tr>';
                //echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                echo '<td>'.$this->M_items->get_ItemName($list['item_id']).' - '.$this->M_sizes->get_sizeName($list['size_id']).'</td>';
                echo '<td>'.$list['quantity_purchased'].'</td>';
                echo '<td>'.$list['unit'].'</td>';
                echo '<td>'.$list['item_cost_price'].'</td>';
                echo '<td>'.$total_cost.'</td>';
                
                echo '</tr>';
                
                $total += ($list['item_cost_price']*$list['quantity_purchased']);
                //$discount_total += (($list['item_cost_price']*$list['quantity_purchased'])*$list['discount_percent']/100);
                
            }
            echo '</tbody>';
            echo '</table>';
            
            echo '<table class="table table-condensed" >';
            echo '<tbody class="text-left">';
            echo '<tr>';
                echo '<td>Total Item: '.$counter.'</td>';
                echo '<td></td>';
                 echo '<td></td>';
                echo '<td></td>';
                echo '<td><strong>Sub Total: </strong></td>';
                echo '<td><strong>'.$total.'</strong></td>';
            echo '</tr>';
            echo '<tr class="text-left">';
                echo '<td></td>';
                echo '<td></td>';
                 echo '<td></td>';
                echo '<td></td>';
                echo '<td><strong>Discount: </strong></td>';
                echo '<td><strong>'.$discount_total=$receivings_items[0]['discount_value'].'</strong></td>';
            echo '</tr>';
            echo '<tr class="text-left">';
                echo '<td></td>';
                echo '<td></td>';
                 echo '<td></td>';
                echo '<td></td>';
                echo '<td><strong>Amount Due: </strong></td>';
                echo '<td><strong>'.$receivings_items[0]['amount_due'].'</strong></td>';
            echo '</tr>';
            echo '<tr class="text-left">';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                 echo '<td></td>';
                echo '<td><strong>Net Total: </strong></td>';
                echo '<td><strong>'.(($total-$discount_total)-$receivings_items[0]['amount_due']).'</strong></td>';
            echo '</tr>';
            echo '</tbody>';
            
            
            }
            ?>
        </table>
        <div>Developed by: <i>kasbook.com</i></div>
        <div>*item once purchased will not return/changed.</div>
        <div>*Double check your items afterwards the shop will not responsible.</div>
    </div>
</div>
</section>