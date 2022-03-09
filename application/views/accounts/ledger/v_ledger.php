<div class="row">
    <div class="col-sm-12">
        <?php
        if($this->session->flashdata('message'))
        {
           echo "<div class='alert alert-success fade in'>";
            echo $this->session->flashdata('message');
            echo '</div>';
        }
        ?>
        <p><?php echo anchor('accounts/C_ledgers/create','Add New <i class="fa fa-plus"></i>','class="btn btn-success"'); ?></p>
        <?php
        
        if(count($ledgers))
        {
        ?>
        <div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i><?php echo $main; ?>
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
					<a href="#portlet-config" data-toggle="modal" class="config"></a>
					<a href="javascript:;" class="reload"></a>
					<a href="javascript:;" class="remove"></a>
				</div>
			</div>
        <div class="portlet-body flip-scroll">
            
        <table class="table table-bordered table-striped table-condensed flip-content">
           <thead class="flip-content"> 
            <tr>
                <th>ID</th>
                <th>Group Id</th>
                <th>Name</th>
                <th>Opening Balance</th>
                <th>Balance</th>
                <th>Action</th>
            </tr>
           </thead>
           <tbody> 
        <?php
        foreach($ledgers as $key => $list)
        {
            echo '<tr>';
            echo '<td>'.$list['id'].'</td>';
            echo '<td>'.$list['group_id'].'</td>';
            echo '<td><a href="'.site_url('accounts/C_ledgers/ledgerDetail/'. $list['id']).'">'.$list['title'].'</a></td>';
            
            $LedgerBalance = $this->M_ledgers->get_ledgerTotalBalance($list['ledger_id'],FY_START_DATE,FY_END_DATE);
        
            if($LedgerBalance > 0){
                $account = 'Dr'; 
            }
            elseif($LedgerBalance < 0)
            {
                $account = 'Cr';
            }
            else{$account = '';}
            
            echo '<td>'.$account.' '.abs($list['op_balance']).'</td>';
           
            echo '<td>'.$account.' '.abs($LedgerBalance).'</td>';
            
            echo '<td>'.anchor('accounts/C_ledgers/edit/'.$list['id'],'Edit');
            //echo  anchor('accounts/C_ledgers/delete/'.$list['id'],' Delete'). '';
            echo '</td></tr>';
        }
        echo '</tbody></table>';
        }
        ?>
        </div>
            </div>
        </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->