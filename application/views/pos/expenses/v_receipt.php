<div class="row hidden-print">
    <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
        <a href="javascript:window.print()" class="btn btn-info"><i class="fa fa-print fa-fw"></i>Print</a>
    </div>
</div>
<script>
//auto load print screen when page load
//window.onload = function() { window.print(); }
</script>

<section id="purchase_payment" >
<div class="row">
    <div class="col-sm-offset-3 col-sm-6">
        
        <div class="row">
            <div class="col-sm-4 col-xs-4 text-left">
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
            <div class="col-sm-4 col-xs-4 text-right">
                
            </div>
        </div>
        <br />
        <?php
            if(count($payment))
            {
            ?>
            
            <table class="table table-default-header table-noborder" >
            
            <thead>
                <tr>
                    <th>
                    <?php echo lang('invoice').' '.lang('number'); ?> &nbsp;&nbsp;:&nbsp;&nbsp; <?php echo $invoice_no; ?> <br />
                    <?php echo lang('name'); ?> &nbsp;&nbsp;:&nbsp;&nbsp; <?php echo $payment[0]['name']; ?>
                    </th>
                    <th></th>
                   <th>
                   <?php echo lang('user'); ?>&nbsp;&nbsp;:&nbsp;&nbsp; <?php echo @$this->M_employees->get_emp_name($payment[0]['employee_id'])->first_name; ?><br />
                   <?php echo lang('date'); ?>&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo date('Y-m-d',strtotime($payment[0]['payment_date'])); ?>
                   </th> 
                </tr>
            </thead>
            </table>
            
            <table class="table table-default-header table-condensed" >
            <thead>
                <tr>
                    <th><?php echo lang('account'); ?></th>
                    <th><?php echo lang('description'); ?></th>
                    <th><?php echo lang('amount'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            $counter = 0;
            $total = 0;
            $discount =0;
            $discount_total =0;
            
            foreach($payment as $key => $list)
            {
                $counter++;
        
                echo '<tr>';
                $account = $this->M_groups->get_groups($list['account_code'],$_SESSION['company_id']);
                echo '<td>'.($langs=='en'?@$account[0]['title']:@$account[0]['title_ur']).'</td>';
                
                //echo '<td>'.$list['name'].'</td>';
                echo '<td>'.$list['description'].'</td>';
                echo '<td>'.$list['amount'].'</td>';
                $total +=$list['amount'];
                echo '</tr>';
                
            }
            
            echo '<tr>';
                echo '<td></td>';
                //echo '<td></td>';
                echo '<td><strong>'.lang("total").': </strong></td>';
                echo '<td><strong>'.$total.'</strong></td>';
            echo '</tr>';
            echo '</tbody>';
            
            
            }
            ?>
        </table>
        <!-- <br /><br /><br />
        <div>
            <p>
                <span><?php echo lang('signature'); ?> <?php echo lang('receiver'); ?>. __________________</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="pull-right"><?php echo lang('signature'); ?> <?php echo lang('supdt'); ?>. __________________</span>
            </p>
        </div> -->
        <br />
        <div class="text-center">Developed by: <i>khybersoft.com</i></div>
        
        
    </div>
</div>
</section>