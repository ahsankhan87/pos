<div class="row hidden-print" >
    <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
        <!-- <a href="<?php echo site_url('trans/C_sales') ?>" class="btn btn-primary"><i class="fa fa-arrow-left fa-fw"></i>estimate</a>
        <a href="javascript:window.print()" class="btn btn-info"><i class="fa fa-print fa-fw"></i>Print</a>
         -->
    </div>
    <!-- <button class="hidden-print"><a href="<?php echo site_url('trans/C_estimate/editestimate/'.$invoice_no) ?>" title="edit" >Edit</a></button> -->
    <button class="hidden-print"><a href="#" onclick="window.print()" title="print" >Print</a></button>
    <button class="hidden-print"><a href="<?php echo site_url('trans/C_estimate/allestimate') ?>"><?php echo lang('estimate')?></a></button>

</div>
<script>
//auto load print screen when page load
//window.onload = function() { window.print(); }
</script>
<style>
@media print{
    body{
        margin-top:0px;
	
    }
    #invoice-POS {
	width: 60mm;
  }
    #invoice-POS table {
	width: 100%;
	border-collapse: collapse;
    	padding:0px;
    	margin:0;
	
  }
    #invoice-POS th {
	font-size: 12px;
	padding:2px;

    margin:0;
  }
  #invoice-POS td {
	font-size: 12px;
	padding:2px;
    margin:0;
  }
 .col-xs-6 .col-sm-6{
     width:0% !important;
     
 }
}
</style>
<section id="invoice-POS">
<div class="row">
    <div class="col-sm-6 col-sm-offset-3  text-center">
    
        <div class="lead text-capitalize" style="margin: 0;font-weight: bold;"><?php echo $Company[0]['name'];?></div>
        
        <span class="lead text-capitalize" style="font-weight: bold;"><?php echo $Company[0]['address'];?></span><br />
        <span class=""><?php echo $Company[0]['contact_no'];?></span>
        
        <?php

            if(count($estimate_items))
            {
            ?>
            <div class="lead text-uppercase"><?php echo lang('estimate'); ?> </div>
            
            <div class="row"  style="font-weight: 900;">
                <div class="col-sm-6 col-xs-6">
                    <div class="text-left m0" style="margin: 0;">
                        <?php echo 'Inv #'; ?>:
                        <?php echo date('ymd',strtotime($estimate_items[0]['sale_date'])).'-'.$invoice_no; ?><br>
                        
                        <?php echo lang('name'); ?>:
                        <?php echo @$this->M_customers->get_CustomerName($estimate_items[0]['customer_id']); ?>
                    
                    </div>
                    
                </div>
                <div class="col-sm-6 col-xs-6" style="margin: 0;">
                    <div class="text-right">
                        <?php echo lang('user'); ?>:
                        <?php echo @$this->M_users->get_activeUsers($estimate_items[0]['user_id'])[0]['name']; ?><br />
                        
                        <?php echo lang('date'); ?>:
                        <?php echo date('d-m-Y g:ia',strtotime($estimate_items[0]['sale_time'])); ?>
                   
                    </div>
                   
                </div>
            </div>

            <div class="row"  style="font-weight: 900;">
                <div class="col-sm-12 col-xs-12">
                    <div class="text-left m0" style="margin: 0;">
                        <?php echo 'Delivery Date'; ?>:
                        <?php echo date('d-m-Y g:ia',strtotime($estimate_items[0]['delivery_date'])); ?><br>
                       
                    </div>
                    
                </div>
                
            </div>
            
            <table class="table table-striped table-hover table-condensed" >
            
            <thead>
                <tr>
                    <th><?php echo lang('product');?></th>
                    <th><?php echo lang('quantity');?></th>
                    <!--<th>Unit</th>-->
                    <th class="text-right"><?php echo lang('price');?></th>
                    
                </tr>
            </thead>
            <tbody style="font-weight: bold;">
            <?php
            $counter = 0;
            $total = 0;
            $discount =0;
            $discount_total =0;
            $total_tax_amount=0;
            $advance = $estimate_items[0]['advance'];
            
            foreach($estimate_items as $key => $list)
            {
                $counter++;
                $discount_total += $list['discount_value'];
                $total_cost = ($list['item_unit_price']*$list['quantity_sold']);
                $tax_amount = $total_cost*$list['tax_rate']/100;
                $total_tax_amount += $tax_amount;
                 //$discount = ($list['item_unit_price']*$list['quantity_sold'])*$list['discount_percent']/100;
                
                echo '<tr>';
                //echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                echo '<td>'.$this->M_items->get_ItemName($list['item_id']).' '.$this->M_sizes->get_sizeName($list['size_id']).'</td>';
                echo '<td>'.round($list['quantity_sold'],2).' '.$this->M_units->get_unitName($list['unit_id']).'</td>';
                //echo '<td>'.$list['unit'].'</td>';
                echo '<td class="text-right">'.round($list['item_unit_price'],2).'</td>';
                // echo '<td>'.$total_cost.'</td>';
                echo '</tr>';
                
                $total += ($list['item_unit_price']*$list['quantity_sold']);
                //$discount_total += (($list['item_unit_price']*$list['quantity_sold'])*$list['discount_percent']/100);
                
            }
            echo '</tbody>';
            echo '</table>';
            ?>

            <table class="table"  style="font-weight: bold;">
                <tr>
                    <td class="text-small">
                        <?php echo lang('products');?>: <?php echo $counter; ?>
                        
                    </td>
                    <td class="text-<?php echo ($langs == "ar" || $langs == 'ur' ? 'left' : 'right')?>">
                        <?php echo lang('sub_total');?>&nbsp;:<br>
                        <span><?php echo lang('disc');?>&nbsp;:<br>
                        <span><?php echo lang('taxes');?>&nbsp;:<br>
                        <span>Advance&nbsp;:<br>
                        <span><?php echo lang('total');?>&nbsp;:
                    </td>
                    <td class="text-<?php echo ($langs == "ar" || $langs == 'ur' ? 'right' : 'left')?>">
                        &nbsp;<?php echo $total; ?><br>
                        &nbsp;<?php echo round($discount_total,2); ?></span><br>
                        &nbsp;<?php echo round($total_tax_amount,2); ?></span><br>
                        &nbsp;<?php echo round($advance,2); ?></span><br>
                        &nbsp;<?php echo round(($total-$discount_total+$total_tax_amount)-$advance,2); ?></span><br>
                    
                    </td>
                </tr>
                
            </table>
           
            <div class="row">
                <div class="col-sm-12">
                    <span><?php echo $estimate_items[0]['description']; ?></span>
                </div>
            </div>
            
            <?php
            }
            ?>
        <div>
        <?php
            $data = $Company[0]['name']."                                                                    ".
                    //$Company[0]['address']."                                                                    ".
                    // $Company[0]['contact_no']."                                                                    ".
                    lang('date')." : ".date('d-m-Y g:ia',strtotime($estimate_items[0]['sale_time'])). "                                                        ".
                    // lang('sub_total'). " : ".$total."                                                                         ".
                    // lang('disc')." : ".round($discount_total,2)."                                                                   ".
                    lang('tax')." : ".round($total_tax_amount,2)."                                                               ".
                    lang('grand').' '.lang('total')." : ".round(($total-$discount_total+$total_tax_amount)-$estimate_items[0]['amount_due'],2);

            $params['data'] = $data;
            $params['level'] = 'H';
            $params['size'] = 3;
            $params['savename'] = FCPATH.'tes.png';
            $this->ciqrcode->generate($params);
            
            echo '<img src="'.base_url().'tes.png" />';
            ?>
            <!-- <?php echo $qr_code; ?> -->
        </div>
        <div  style="font-weight: bold;"><?php echo lang('thanks_for_purchasing'); ?></div>
        <div style="font-weight: bold;">Developed by: <i>khybersoft.com</i></div>
        <!-- <div>*item once purchased will not return/changed.</div>
        <div>*Double check your items afterwards the shop will not responsible.</div> -->
    </div>
</div>
</section>