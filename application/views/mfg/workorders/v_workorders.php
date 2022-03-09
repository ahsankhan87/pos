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
        
        <p><?php echo anchor('mfg/C_workorders/create',lang('add_new').' <i class="fa fa-plus"></i>','class="btn btn-success"'); ?></p>
        
        <?php
        if(count($workorders))
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
        
        <table class="table table-bordered table-striped table-condensed flip-content"  id="sample_2">
        <thead class="flip-content">
            <tr>
                <th>ID</th>
                <th><?php echo lang('reference'); ?></th>
                <th><?php echo lang('type'); ?></th>
                <th><?php echo lang('name'); ?></th>
                <th><?php echo lang('required'); ?></th>
                <th><?php echo lang('manufactured'); ?></th>
                <th><?php echo lang('date'); ?></th>
                <th><?php echo lang('required') .' by'; ?></th>
            </tr>
        </thead>
        
        <tbody>
        <?php
        foreach($workorders as $key => $list)
        {
            echo '<tr valign="top">';
            echo '<td>'.$list['id'].'</td>';
            echo '<td>'.anchor('mfg/C_workorders/workorderDetail/'.$list['id'].'/'.$list['wo_ref'],$list['wo_ref']).'</td>';
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
            echo '<td>'.$list['units_reqd'].'</td>';
            echo '<td>'.$list['units_issued'].'</td>';
            echo '<td>'.$list['date'].'</td>';
            echo '<td>'.$list['required_by'].'</td>';
            
            // echo '<td>'.anchor('mfg/C_workorders/edit/'.$list['id'],'Edit'). ' | ';
            echo  '<td>'.anchor('mfg/C_workorders/delete/'.$list['id'],' <i class="fa fa-trash text-danger"></i>','onclick="return confirm(\'Are you sure you want to delete?\')"'). '</td>';
            echo '</tr>';
        }
        
        }
        ?>
        </tbody> 
        </table>
        </div>
        <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
