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
    <p><?php echo anchor('setting/PostingTypes/create','Add New <i class="fa fa-plus"></i>','class="btn btn-success"'); ?></p>
    
    <?php
    if(count($salespostingType))
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
            
    <table class="table table-bordered table-striped table-condensed flip-content" id="dataTables-example">
        <thead class="flip-content">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
    <?php
    foreach($salespostingType as $key => $list)
    {
        echo '<tr valign="top">';
        //echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
        echo '<td>'.$list['id'].'</td>';
        echo '<td>'.$list['name'].'</td>';
        //echo '<td>'.$list[''].'</td>';
        //echo '<td>'.$list['address'].'</td>';
        //echo '<td>'.$list['city'].'</td>';
        //echo '<td>'.$list['country'].'</td>';
        
        
       // echo '<td><a href="'.site_url('setting/C_customers/paymentModal/'. $list['id']).'" class="btn btn-warning btn-sm" >Receive Payment</a></td>';
       // echo '<td><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#customer-payment-Modal">Receive Payment</button></td>';
        
        echo '<td>';
        //echo  anchor(site_url('up_customer_images/upload_images/'.$list['id']),' upload Images');
        echo '<a href="'.site_url("setting/PostingTypes/edit/".$list['id']).'"  class="fa fa-edit" title="Edit"></a>  |
        <a href="'.site_url('setting/PostingTypes/delete/'.$list['id']).'" class="fa fa-trash-o" title="Delete" onclick="return confirm(\'Are you sure you want to delete?\')" class="btn btn-danger"></a>';
        
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
