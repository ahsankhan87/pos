<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header lead"><?php echo $main; ?></h1>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-sm-6">
        <h3>Assets</h3>
        <table class="table table-striped">
                 <thead>
                    <tr>
                        <th>Account</th>
                        <th>Amount</th>
                        <th>Total</th> 
                    </tr>
                </thead>  
                <tbody>
            <?php 
            $assets_total =0.00;
            
            $group = $this->M_reports->get_GroupIDForBalanceSheet($_SESSION['company_id'],'asset',FY_START_DATE,FY_END_DATE);
            //var_dump($groupParentID);
            echo '<tr><td colspan="3"><h4><strong>'.@$group[0]['group_name'].'</strong></h4></td></tr>';
                
                foreach($group as $key => $list)
                {            
                    echo '<tr><td>';
                    echo $list['ledger_name'];
                    echo '</td>';
                    
                    echo '<td>';
                    echo $list['amt'];
                    echo '</td>';
                    
                    echo '<td>';
                    echo $assets_total += $list['amt'];
                    echo '</td></tr>';
            
                }
                
                ?>
            </tbody>
        </table>
    </div>
    <!-- /.col-sm-6 -->

<div class="col-sm-6">
        <h3>Liability + Owner Equity</h3>
        <table class="table table-striped">
                 <thead>
                    <tr>
                        <th>Account</th>
                        <th>Amount</th>
                        <th>Total</th> 
                    </tr>
                </thead>  
        <tbody>
            <?php 
            $libility_total =0.00;
            
            $group = $this->M_reports->get_GroupIDForBalanceSheet($_SESSION['company_id'],'liability',FY_START_DATE,FY_END_DATE);
            //var_dump($groupParentID);
            echo '<tr><td colspan="3"><h4><strong>'.@$group[0]['group_name'].'</strong></h4></td></tr>';
                
                foreach($group as $key => $list)
                {            
                    echo '<tr><td>';
                    echo $list['ledger_name'];
                    echo '</td>';
                    
                    echo '<td>';
                    echo $list['amt'];
                    echo '</td>';
                    
                    echo '<td>';
                    echo $libility_total += $list['amt'];
                    echo '</td></tr>';
            
                }
                
            
            $group = $this->M_reports->get_GroupIDForBalanceSheet($_SESSION['company_id'],'equity',FY_START_DATE,FY_END_DATE);
            //var_dump($groupParentID);
            echo '<tr><td colspan="3"><h4><strong>'.@$group[0]['group_name'].'</strong></h4></td></tr>';
                
                foreach($group as $key => $list)
                {            
                    echo '<tr><td>';
                    echo $list['ledger_name'];
                    echo '</td>';
                    
                    echo '<td>';
                    echo $list['amt'];
                    echo '</td>';
                    
                    echo '<td>';
                    echo $libility_total += $list['amt'];
                    echo '</td></tr>';
            
                }
                
                echo '<tr><td>';
                    echo 'Net Income';
                    echo '</td>';
                    
                    echo '<td>';
                    echo $net_income;
                    echo '</td>';
                    
                    echo '<td>';
                    echo $libility_total += $net_income;
                    echo '</td></tr>';
                ?>
                </tbody>
        </table>
    </div>
    <!-- /.col-sm-6 -->
</div>

<div class="row">
    <div class="col-sm-6">
        <table class="table table-striped">
            <tr>
                <td>Total</td><td></td>
                <td><strong><?php echo $assets_total; ?></strong></td>
            </tr>
        </table>
    
    </div>
    <div class="col-sm-6">
        <table class="table table-striped">
            <tr>
                <td>Total</td><td></td>
                <td><strong><?php echo $libility_total; ?></strong></td>
            </tr>
        </table>
    
    </div>
</div>
<!-- /.row -->
