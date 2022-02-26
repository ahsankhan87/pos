<div class="row">
    <div class="col-sm-12">
        <p><?php echo anchor('#',lang('print').' <i class="fa fa-print"></i>','class="btn btn-success hidden-print" onclick="window.print()"'); ?></p>
        
        <?php
        if(count($wo_detail))
        {
        ?>
        <h4 class="text-center"><?php echo lang('work').' '.lang('order') .' # '.$reference; ?></h4>
        <table class="table table-bordered table-striped table-condensed"  id="">
        <thead>
            <tr>
                <th>#</th>
                <th><?php echo lang('reference'); ?></th>
                <th><?php echo lang('type'); ?></th>
                <th><?php echo lang('manufactured').' '. lang('product'); ?></th>
                <th><?php echo lang('date'); ?></th>
                <th><?php echo lang('quantity'); ?></th>
                
            </tr>
        </thead>
        
        <tbody>
        <?php
        foreach($wo_detail as $key => $list)
        {
            echo '<tr valign="top">';
            echo '<td>'.$list['id'].'</td>';
            echo '<td>'.$list['wo_ref'].'</td>';
            echo '<td>';
                if($list['type'] == 0){
                    echo 'Assemble';
                }elseif ($list['type'] == 1) {
                    echo 'Unassemble';
                }elseif ($list['type'] == 2) {
                    echo 'Advanced Manufacture';
                }
            echo '</td>';
            echo '<td>'.$this->M_items->get_ItemName($list['item_id']).'</td>';
            echo '<td>'.$list['date'].'</td>';
            echo '<td>'.$list['units_reqd'].'</td>';
            
            // echo '<td>'.anchor('mfg/C_workorders/edit/'.$list['id'],'Edit'). ' | ';
            // echo  anchor('mfg/C_workorders/delete/'.$list['id'],' Delete','onclick="return confirm(\'Are you sure you want to delete?\')"'). '</td>';
            echo '</tr>';
        }
        
        
        ?>
        </tbody> 
        </table>
        
        <h4 class="text-center"><?php echo lang('work').' '.lang('order'); ?> Requirement</h4>
        <table class="table table-bordered table-striped table-condensed"  id="">
        <thead>
            <tr>
                <th>#</th>
                <th><?php echo lang('product'); ?></th>
                <th><?php echo lang('work').' '.lang('center'); ?></th>
                <th><?php echo lang('unit').' '. lang('quantity'); ?></th>
                <th><?php echo lang('total').' '. lang('quantity'); ?></th>
                <th><?php echo lang('unit').' '. lang(''); ?>issued</th>
                
                
            </tr>
        </thead>
        
        <tbody>
        <?php
        $wo_reqmnt = $this->M_workorders->get_workorder_requirements($id);
        foreach($wo_reqmnt as $key => $list)
        {
            echo '<tr valign="top">';
            echo '<td>'.$list['id'].'</td>';
            echo '<td>'.$this->M_items->get_ItemName($list['item_id']).'</td>';
            echo '<td>'.$this->M_workcenters->get_workcenterName($list['workcenter_id']).'</td>';
            echo '<td>'.$list['units_req'].'</td>';
            echo '<td>'.($list['units_req']*$wo_detail[0]['units_reqd']).'</td>';
            echo '<td>'.$list['units_issued'].'</td>';
            
            // echo '<td>'.anchor('mfg/C_workorders/edit/'.$list['id'],'Edit'). ' | ';
            // echo  anchor('mfg/C_workorders/delete/'.$list['id'],' Delete','onclick="return confirm(\'Are you sure you want to delete?\')"'). '</td>';
            echo '</tr>';
        }
        
        
        ?>
        </tbody> 
        </table>

        <h4 class="text-center">Additional Cost</h4>
        <table class="table table-bordered table-striped table-condensed"  id="">
        <thead>
            <tr>
                <th>#</th>
                <th><?php echo lang('type'); ?></th>
                <th><?php echo lang('date'); ?></th>
                <th><?php echo lang('amount'); ?></th>
                
            </tr>
        </thead>
        
        <tbody>
        <?php
        $wo_costing = $this->M_workorders->get_workorder_costing($id);
        foreach($wo_costing as $key => $list)
        {
            echo '<tr valign="top">';
            echo '<td>'.$list['id'].'</td>';
            echo '<td>';
                if($list['cost_type'] == 0){
                    echo 'Labour Cost';
                }elseif ($list['cost_type'] == 1) {
                    echo 'Overhead Cost';
                }
            echo '</td>';
            echo '<td>'.$list['date'].'</td>';
            echo '<td>'.$list['amount'].'</td>';
            
            // echo '<td>'.anchor('mfg/C_workorders/edit/'.$list['id'],'Edit'). ' | ';
            // echo  anchor('mfg/C_workorders/delete/'.$list['id'],' Delete','onclick="return confirm(\'Are you sure you want to delete?\')"'). '</td>';
            echo '</tr>';
        }
        
        }
        ?>
        </tbody> 
        </table>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
