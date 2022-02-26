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
    <p><?php echo anchor('setting/C_currencies/create','Add New <i class="fa fa-plus"></i>','class="btn btn-success"'); ?></p>
    
    <?php
    if(count($currencies))
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
            
    <table class="table table-bordered table-striped table-condensed flip-content" id="sample_2">
        <thead class="flip-content">
        <tr>
            <th>ID</th>
            <th>Country</th>
            <th>Name</th>
            <th>Code</th>
            <th>Symbol</th>
            
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
    <?php
    foreach($currencies as $key => $list)
    {
        echo '<tr valign="top">';
        echo '<td>'.$list['id'].'</td>';
        echo '<td>'.$list['country'].'</td>';
        echo '<td>'.$list['name'].'</td>';
        echo '<td>'.$list['code'].'</td>';
        echo '<td>'.$list['symbol'].'</td>';
        //echo '<td><a href="'.site_url('setting/C_currencies/paymentModal/'. $list['id']).'" class="btn btn-warning btn-sm" >Receive Payment</a></td>';
       // echo '<td><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#bank-payment-Modal">Receive Payment</button></td>';
            
        echo '<td>';
        //echo  anchor(site_url('up_bank_images/upload_images/'.$list['id']),' upload Images');
        
    ?>
    <?php echo anchor('setting/C_currencies/edit/'.$list['id'],'<i class="fa fa-pencil-square-o fa-fw"></i>'); ?> | 
    <a href="<?php echo site_url('setting/C_currencies/inactivate/'.$list['id']) ?>" onclick="return confirm('Are you sure you want to inactive?')"><i class="fa fa-trash-o fa-fw"></i></a>
     <!--
     <div class="dropdown">
      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">option
      <span class="caret"></span></button>
      <ul class="dropdown-menu">
        <li></li>
        
        <li><?php //echo anchor('setting/C_currencies/delete/'.$list['id'],'Delete'); ?></li>
        <li><?php //echo anchor('setting/C_currencies/activate/'.$list['id'],'Activate'); ?></li>
        <li><?php //echo anchor('setting/C_currencies/inactivate/'.$list['id'],'In-activate'); ?></li>
        
        <li></li>
      </ul>
    </div>
    -->
    <?php
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
