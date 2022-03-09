<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header lead"><?php echo $main; ?></h1>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->

<table class="table table-striped">
     <thead>
        <tr>
            <th>Ledger A/C</th>
            <th>Amount</th>
            <th>Total</th> 
        </tr>
    </thead>  
    <tbody>
 
    <?php
    $total =0;
    $group = $this->M_reports->get_profit_loss($_SESSION['company_id'],'revenue',FY_START_DATE,FY_END_DATE);
    
    echo '<tr><td colspan="3"><h4><strong>'.@$group[0]['group_name'].'</strong></h4></td></tr>';
    $sales_total = 0.00;
    
    foreach($group as $key => $list)
    {            
        echo '<tr><td>';
        echo $list['ledger'];
        echo '</td>';
        
        echo '<td>';
        echo $list['amt'];
        echo '</td>';
        
        echo '<td>';
        echo $sales_total += $list['amt'];
        echo '</td></tr>';

    }
    echo '<tr><td><strong>Net Sales</strong></td><td><strong>'.$sales_total.'</strong></td><td>';
    echo '<strong>'.$sales_total.'</strong>';
    echo '</td></tr>';
    
    //$cos_total
    $cos_total = 0;
    $group = $this->M_reports->get_profit_loss($_SESSION['company_id'],'cos',FY_START_DATE,FY_END_DATE);
    echo '<tr><td colspan="3"><h4><strong>'.@$group[0]['group_name'].'</strong></h4></td></tr>';
    
    foreach($group as $key => $list)
    {            
        
            echo '<tr><td>';
            echo '&nbsp&nbsp'.$list['ledger'];
            echo '</td>';
            
            echo '<td>';
            echo $list['amt'];
            echo '</td>';
            
            echo '<td>';
             $cos_total += $list['amt'];
            echo '</td></tr>';

    }
    //end sales returns
        echo '<tr><td><strong>Cost of Goods Sold</strong></td><td><strong>'.$cos_total.'</strong></td><td>';
     echo '<strong>'.$total = $sales_total+$cos_total.'</strong>';
    echo '</td></tr>';
            
    //$expense_total
    $expense_total = 0;
    $group = $this->M_reports->get_profit_loss($_SESSION['company_id'],'expense',FY_START_DATE,FY_END_DATE);
    echo '<tr><td colspan="3"><h4><strong>'.@$group[0]['group_name'].'</strong></h4></td></tr>';
    
    foreach($group as $key => $list)
    {            
        
            echo '<tr><td>';
            echo '&nbsp&nbsp'.$list['ledger'];
            echo '</td>';
            
            echo '<td>';
            echo $list['amt'];
            echo '</td>';
            
            echo '<td>';
             $expense_total += $list['amt'];
            echo '</td></tr>';

    }
    //end sales returns
    
    echo '<tr><td><strong>Net Expenses</strong></td><td><strong>'.$expense_total.'</strong></td><td>';
    echo '<strong>'.$total = $total-$expense_total.'</strong>';
    echo '</td></tr>';
            
    ?>
     </tbody>
    <tfoot>
         <tr>
            <td><strong>NET PROFIT/LOSS</strong></td>
            <td></td>
            <td><strong><?php echo $total; ?></strong></td>
        </tr>
    </tfoot>
   
</table>
