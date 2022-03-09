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
    <a href="<?php echo site_url('setting/users/C_users/create/') ?>" title="Add" class="btn btn-success"><i class="fa fa-plus fa-fw"></i> Add New</a>
        
    </p>
    <?php
    if(count($users))
    {
    ?>
    <div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i><span id="print_title"><?php echo $main; ?></span>
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
					<a href="#portlet-config" data-toggle="modal" class="config"></a>
					<a href="javascript:;" class="reload"></a>
					
				</div>
			</div>
        <div class="portlet-body flip-scroll">
            
    <table class="table table-bordered table-striped table-condensed flip-content" id="sample_2">
        <thead class="flip-content">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Role</th>
            <th>Action</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
    <?php
    foreach($users as $key => $list)
    {
        echo '<tr>';
        echo '<td>'.$list['id'].'</td>';
        echo '<td>'.$list['username'].'</td>';
        echo '<td>'.$list['name'].'</td>';
        echo '<td>'.$list['role'].'</td>';
        echo '<td>';
        echo '<a href="'. site_url('setting/users/C_users/editUser/'.$list['id']) .'" title="Edit"><i class="fa fa-pencil fa-fw"></i></a>';
        if($_SESSION['username'] !== $list['username'])
        {
        echo ' | <a href="'. site_url('setting/users/C_users/delete/'.$list['id']) .'" title="Make Inactive" onclick="return confirm(\'Are you sure you want to delete?\')"><i class="fa fa-trash-o fa-fw"></i></a>';
            
        }
        echo '</td>';
        echo '<td>';
        echo '<a href="'. site_url('setting/users/C_users/change_password/'.$list['id']) .'" title="Edit">Change Password</a>';
        echo '</td>';
        
        echo '</tr>';
    }
    echo '</tbody></table>';
    
    }
    ?>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
