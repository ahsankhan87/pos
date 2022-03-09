
<script src="<?php echo base_url(); ?>assets/scripts/jquery-simple-tree-table.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-simple-tree-table.css">

<div class="row">
    <div class="col-sm-12">
       <?php
        if($this->session->flashdata('message'))
        {
            echo "<div class='alert alert-success fade in'>";
            echo $this->session->flashdata('message');
            echo '</div>';
        }
        if($this->session->flashdata('error'))
        {
            echo "<div class='alert alert-danger fade in'>";
            echo $this->session->flashdata('error');
            echo '</div>';
        }
        ?>
    
        <p>
        <?php echo anchor('accounts/C_groups/create',lang('add_new').' <i class="fa fa-plus"></i>','class="btn btn-success"'); ?>
        <button type="button" id="expander" class="btn btn-sm">Expand</button>
        <button type="button" id="collapser" class="btn btn-sm">Collapse</button>
  
        </p>
        <?php
        if(count($groups))
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
            
        <table class="table table-bordered table-striped table-condensed flip-content" id="basic">
            <thead class="flip-content">
                <tr>
                    <th><?php echo lang('acc_code'); ?></th>
                    <th><?php echo lang('name'); ?></th>
                    <th><?php echo lang('balance'); ?></th>
                    <th><?php echo lang('type'); ?></th>
                    <th><?php echo lang('level'); ?></th>
                    <th><?php echo lang('action'); ?></th>
                </tr>
            </thead>
            <tbody>
        <?php
        $i=1;
        
        $k=1;
        foreach($groups as $key => $list)
        {
                ///////////////////
                /////FIRST LEVEL ACCOUNT GROUPS
                echo '<tr data-node-id="'.$i.'">';
                //echo '<td>'.$account_has_entry.'</td>';
                echo '<td>'.$list['account_code'].'</td>';
               
                $op_balance = ($list['op_balance_dr']-$list['op_balance_cr']);
                $cur_balance=0;//$this->M_groups->get_account_balance($_SESSION['company_id'],FY_START_DATE,FY_END_DATE,$list['account_code']);
                
                //echo '<td><a href="'.site_url('accounts/C_groups/accountDetail/'. $list['account_code']).'">'.($langs == 'en' ? $list['title'] : $list['title_ur']).'</a></td>';
                echo '<td>'.ucfirst($langs == 'en' ? $list['title'] : $list['title_ur']).'</td>';
                echo '<td>'.round($op_balance+$cur_balance,2).'</td>';
                echo '<td>'.ucfirst($list['type']).'</td>';
                echo '<td >'.$list['level']. '</td>';
                echo '<td>';
                echo '<a href="'.site_url('accounts/C_groups/edit/'.$list['id']).'" title="Edit"><i class="fa fa-pencil-square-o fa-fw"></i></a>';
                echo '</td>';
                echo '</tr>';
                ///////////////////
                
                    $j=1;
                    ///////////////////
                    /////SECOND LEVEL ACCOUNT GROUPS
                    $level_2_groups = $this->M_groups->get_GroupsByParent($list['account_code']);
                    if(count($level_2_groups) > 0){
                        foreach($level_2_groups as $key_2 => $list_2)
                        {
                            echo '<tr data-node-id="'.$i.'.'.$j.'"';
                            //////////////////////
                            //PARENT ID OF NODE
                            echo 'data-node-pid="'.$i.'">';
                            ///////////////
                            
                            echo '<td>'.$list_2['account_code'].'</td>';
                        
                            $op_balance = ($list_2['op_balance_dr']-$list_2['op_balance_cr']);
                            $cur_balance=0;//$this->M_groups->get_account_balance($_SESSION['company_id'],FY_START_DATE,FY_END_DATE,$list_2['account_code']);
                            
                            //echo '<td class="'.$text_style.'"><a href="'.site_url('accounts/C_groups/accountDetail/'. $list_2['account_code']).'">'.($langs == 'en' ? $list_2['title'] : $list_2['title_ur']).'</a></td>';
                            echo '<td class="text-warning">'.ucfirst($langs == 'en' ? $list_2['title'] : $list_2['title_ur']).'</td>';
                            echo '<td>'.round($op_balance+$cur_balance,2).'</td>';
                            echo '<td>'.ucfirst($list_2['type']).'</td>';
                            echo '<td >'.$list_2['level']. '</td>';
                            echo '<td>';
                            echo '<a href="'.site_url('accounts/C_groups/edit/'.$list_2['id']).'" title="Edit"><i class="fa fa-pencil-square-o fa-fw"></i></a>';
                            
                            echo '</td>';
                            echo '</tr>';
                                    
                            $k=1;
                    
                                    ///////////////////
                                    /////THIRD LEVEL ACCOUNT GROUPS
                                    $level_3_groups = $this->M_groups->get_GroupsByParent($list_2['account_code']);
                                    if(count($level_3_groups) > 0){
                                        foreach($level_3_groups as $key_3 => $list_3)
                                        {
                                            echo '<tr data-node-id="'.$i.'.'.$j.'.'.$k.'"';
                                            //////////////////////
                                            //PARENT ID OF NODE
                                            echo 'data-node-pid="'.$i.'.'.$j.'">';
                                            ///////////////
                                            
                                            echo '<td>'.$list_3['account_code'].'</td>';
                                        
                                            $op_balance = ($list_3['op_balance_dr']-$list_3['op_balance_cr']);
                                            $cur_balance=$this->M_groups->get_account_balance($_SESSION['company_id'],FY_START_DATE,FY_END_DATE,$list_3['account_code']);
                                            
                                            echo '<td><a href="'.site_url('accounts/C_groups/accountDetail/'. $list_3['account_code']).'">'.($langs == 'en' ? $list_3['title'] : $list_3['title_ur']).'</a></td>';
                                            //echo '<td class="text-success">'.ucfirst($langs == 'en' ? $list_3['title'] : $list_3['title_ur']).'</td>';
                                            echo '<td>'.round($op_balance+$cur_balance,2).'</td>';
                                            echo '<td>'.ucfirst($list_3['type']).'</td>';
                                            echo '<td >'.$list_3['level']. '</td>';
                                            echo '<td>';
                                            echo '<a href="'.site_url('accounts/C_groups/edit/'.$list_3['id']).'" title="Edit"><i class="fa fa-pencil-square-o fa-fw"></i></a> | ';
                                            echo '<a href="'.site_url('accounts/C_groups/delete/'.$list_3['account_code']) .'" title="Delete" onclick="return confirm(\'Are you sure you want to delete?\')"><i class="fa fa-trash-o fa-fw"></i></a>';
                                            
                                            echo '</td>';
                                            echo '</tr>';
                                            
                                            $k++;
                                        }
                                        ////////////////////
                                        ///THIRD LEVEL GROUP END
                                    }
                        $j++;
                      }
                    }//END SECOND IF
                    ////////////////////
                    ///SECOND LEVEL GROUP END
                
                $i++;
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
<script>
  $('#basic').simpleTreeTable({
    expander: $('#expander'),
    collapser: $('#collapser'),
    store: 'session',
    storeKey: 'simple-tree-table-basic'
  });
  $('#open1').on('click', function() {
    $('#basic').data('simple-tree-table').openByID("1");
  });
  $('#close1').on('click', function() {
    $('#basic').data('simple-tree-table').closeByID("1");
  });
  </script>