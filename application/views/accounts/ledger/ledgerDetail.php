<div class="row">
    <div class="col-sm-12">
        
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->

<div class="row" id="btn_print">

     <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
        <button type="button" class="btn btn-primary" onclick="window.history.back();"><i class="fa fa-arrow-left fa-fw"></i> Back</button>
        <a href="javascript:window.print()" class="btn btn-info"><i class="fa fa-print fa-fw"></i>Print</a>
    </div>
    
    <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
        <?php
        $attributes = array('class' => 'form-inline', 'role' => 'form','enctype'=>"multipart/form-data");
 
        echo form_open('accounts/C_ledgers/ledgerDetail',$attributes);
        echo '<div class="form-group"><label class="control-label" for="Account">Account</label>&nbsp;&nbsp;';
        //echo '<div class="col-sm-10">';
        echo form_dropdown('ledger_id',$LedgerDDL,'','class="form-control"'); 
        echo '</div>&nbsp;&nbsp;';
        
        //echo '<div class="form-group"><label class="control-label col-sm-2" for="submit"></label>';
        //echo '<div class="col-sm-10">';
        echo form_submit('submit','Submit','class="btn btn-success"');
        //echo '</div>';
        echo form_close();
    
        ?>
    </div>
  
</div>

<?php
if($this->session->flashdata('message'))
{
    echo "<div class='message'>";
    echo $this->session->flashdata('message');
    echo '</div>';
}
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo @$ledgers[0]['title']; ?> Account Detail
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <?php
        if(count($ledgers))
        {
        ?>
        
        <table class="table table-striped table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Ledger A/C</th>
                <th>Dr Amount</th>
                <th>Cr Amount</th>
                <th>Balance</th>
            </tr>
        </thead>
        
        
        <?php
        //initialize
        $dr_amount = 0.00;
        $cr_amount = 0.00;
        $balance = 0.00;
        
        //var_dump($ledgers);
        //opening balance of ledger account
        $op_balance = $ledgers[0]['op_dr_balance']-$ledgers[0]['op_cr_balance'];
           
            echo '<tbody>';
            echo '<tr>';
            echo '<td></td><td></td><td>Opening Balance</td>';
            if($op_balance > 0)
            {
                 $dr_amount = $op_balance;
                 echo '<td>'.$op_balance.'</td>';
                 echo '<td>--</td>';
            }
            elseif($op_balance < 0)
            {
                $cr_amount = $op_balance;
                echo '<td>--</td>';
                echo '<td>'.$op_balance.'</td>';
            }
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '</tr>';
            
        ////////////////
        ///////////////
        
        foreach($entries as $key => $list)
        {
            echo '<tr>';
            echo '<td>'.$list['id'].'</td>';
            echo '<td>'.$list['date'].'</td>';
            
            $ledger_name = $this->M_ledgers->get_ledgers($list['dueTo_ledger_id']);
            echo '<td>'.@$ledger_name[0]['title'] .'</td>';
            echo '<td>'.$list['debit'].'</td>';
            echo '<td>'.$list['credit'].'</td>';
    
            $dr_amount += $list['debit'];
            $cr_amount += $list['credit'];
            
            $balance = ($dr_amount - $cr_amount);
            
            if($dr_amount > $cr_amount){
                $account = 'Dr'; 
            }
            elseif($dr_amount < $cr_amount)
            {
                $account = 'Cr';
            }
            else{ $account = '';}
            
            echo '<td>'.$account.' '.abs($balance).'</td>';
           
            //echo '<td>'.anchor('accounts/C_ledgers/edit/'.$list['id'],'Edit'). ' | ';
            //echo  anchor('accounts/C_ledgers/delete/'.$list['id'],' Delete'). '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</tfoot>';
        echo '<tr><th></th><th></th>';
        echo '<th>Total</th>';
        echo '<th>'.$dr_amount.'</th>';
        echo '<th>'.$cr_amount.'</th>';
        echo '<th>'.@$account.' '.abs($balance).'</td>';
        echo '</tr>';
        echo '</tfoot>';
        echo '</table>';
        }
        ?>
    </div> <!-- /. panel body -->
</div> <!-- /. panel --> 