<div class="row hidden-print">
    <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
        <a href="javascript:window.print()" class="btn btn-info"><i class="fa fa-print fa-fw"></i>Print</a>
    </div>
</div>
<script>
//auto load print screen when page load
//window.onload = function() { window.print(); }
</script>

<section id="purchase_receipt">
<div class="row">
    <div class="col-sm-12">
        
        <div class="row">
            <div class="col-sm-12 col-xs-12 text-center">
                <?php if(!empty($Company[0]['image']) || $Company[0]['image'] != '')
                {
                    echo '<img src="'.base_url('images/company/thumb/'.$Company[0]['image']).'" width="100" height="100" class="img-rounded" alt="picture"/>';    
                }
                ?>
                <div class="lead text-capitalize" style="margin: 0;"><?php echo $Company[0]['name'];?></div>
            
                <span class="text-capitalize"><?php echo $Company[0]['address'];?></span><br />
                <span class=""><?php echo $Company[0]['contact_no'];?></span>
        
            </div>
            <div class="col-sm-4 col-xs-4 text-center">
                
                
            </div>
            
        </div>
        
        <?php

            if(count($receipt))
            {
            ?>
            
            <div class="lead text-uppercase text-center">Journal invoice</div>
            <table class="table table-default-header table-noborder" >
            
            <thead>
                <tr>
                    <th>
                    <?php echo lang('invoice').' '.lang('number'); ?> &nbsp;&nbsp;:&nbsp;&nbsp; <?php echo $invoice_no; ?> <br />
                    <?php echo lang('name'); ?> &nbsp;&nbsp;:&nbsp;&nbsp; <?php echo @$receipt[0]['name']; ?>
                    </th>
                    <th></th>
                   <th>
                   <?php echo lang('user'); ?>&nbsp;&nbsp;:&nbsp;&nbsp; <?php echo @$this->M_users->get_activeUsers($receipt[0]['employee_id'])[0]['name']; ?><br />
                   <?php echo lang('date'); ?>&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo date('d, M Y',strtotime($receipt[0]['date'])); ?>
                   </th> 
                </tr>
            </thead>
            </table>
            
            <table class="table table-default-header table-condensed" >
            
            <thead>
                
                <tr>
                    <th><?php echo lang('acc_code'); ?></th>
                    <th><?php echo lang('account'); ?></th>
                    <!--<th><?php echo lang('name'); ?></th>-->
                    <th><?php echo lang('description'); ?></th>
                    <th><?php echo lang('debit'); ?></th>
                    <th><?php echo lang('credit'); ?></th>
                    
                </tr>
            </thead>
            <tbody>
            <?php
            $counter = 0;
            $total_cr = 0;
            $total_dr = 0;
            $discount =0;
            $discount_total =0;
            
            foreach($receipt as $key => $list)
            {
                $counter++;
        
                echo '<tr>';
                //echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                echo '<td>'.$list['account_code'].'</td>';
                $account = $this->M_groups->get_groups($list['account_code'],$_SESSION['company_id']);
                echo '<td>'.($langs=='en'?@$account[0]['title']:@$account[0]['title_ur']).'</td>';
                //echo '<td>'.$list['name'].'</td>';
                echo '<td>'.$list['narration'].'</td>';
                echo '<td>'.$list['debit'].'</td>';
                echo '<td >'.$list['credit']. '</td>';
                $total_cr +=$list['credit'];
                $total_dr +=$list['debit'];
                echo '</tr>';
                
            }
            
            echo '<tr>';
                echo '<td></td>';
                echo '<td></td>';
                //echo '<td></td>';
                echo '<td><strong>'.lang("total").': </strong></td>';
                echo '<td><strong>'.$total_dr.'</strong></td>';
                echo '<td><strong>'.$total_cr.'</strong></td>';
            echo '</tr>';
            echo '</tbody>';
            
            
            }
            ?>
        </table>
        
        <br /><br />
        <div class="text-center">Developed by:<i>kasbook.com</i></div>
        
    </div>
</div>
</section>