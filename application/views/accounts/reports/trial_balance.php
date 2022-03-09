<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header lead"><?php echo $main; ?></h1>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->

<?php

if(count($trialBalance))
{
?>
<table class="table table-striped">
 <thead>
    <tr>
        <th>Ledger ID</th>
        <th>Ledger A/C</th>
        <th>Dr Amount</th>
        <th>Cr Amount</th>
        
    </tr>
 </thead>  
 
 <tbody>
<?php
//initialize
$dr_total = 0.00;
$cr_total = 0.00;
$balance = 0.00;
$dr_amount = 0.00;
$cr_amount = 0.00;

foreach($trialBalance as $key => $list)
{
    echo '<tr>';
    echo '<td>'.$list['date'].'</td>';
    
    echo '<td><a href="'.site_url('accounts/c_ledgers/ledgerDetail/'. $list['ledger_id']).'">'.$list['ledger_name'].'</a></td>';
   
    
    //if balance is greater than zero it will be debit. else will be credit balance
    if($list['balance'] > 0){
        echo '<td>'.abs($list['balance']).'</td>';
        echo '<td>--</td>';
        $dr_amount += $list['balance'];
    }
    elseif($list['balance'] < 0){
        echo '<td>--</td>';
        echo '<td>'.abs($list['balance']) .'</td>';
        $cr_amount +=  $list['balance'];
    }
   
    
    echo '</tr>';
}
echo '</tbody>';


echo '<tr><th></th>';
echo '<th>Total</th>';
echo '<th>'.abs($dr_amount).'</th>';
echo '<th>'.abs($cr_amount).'</th>';

echo '</tr>';
echo '</table>';
}
?>