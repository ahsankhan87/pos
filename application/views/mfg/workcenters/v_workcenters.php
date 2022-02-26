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
        
        <p><?php echo anchor('mfg/C_workcenters/create',lang('add_new').' <i class="fa fa-plus"></i>','class="btn btn-success"'); ?></p>
        
        <?php
        if(count($workcenters))
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
                <th><?php echo lang('name'); ?></th>
                <th><?php echo lang('description'); ?></th>
                <th><?php echo lang('status'); ?></th>
                <th><?php echo lang('action'); ?></th>
            </tr>
        </thead>
        
        <tbody>
        <?php
        foreach($workcenters as $key => $list)
        {
            echo '<tr valign="top">';
            echo '<td>'.$list['id'].'</td>';
            echo '<td>'.$list['name'].'</td>';
            echo '<td>'.$list['description'].'</td>';
            echo '<td>'.$list['status'].'</td>';
            
            echo '<td>'.anchor('mfg/C_workcenters/edit/'.$list['id'],'Edit'). ' | ';
            echo  anchor('mfg/C_workcenters/delete/'.$list['id'],' Delete','onclick="return confirm(\'Are you sure you want to delete?\')"'). '</td>';
            echo '</tr>';
        }
        echo '</tbody> </table>';
        }
        ?>
        
        </div>
        <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
