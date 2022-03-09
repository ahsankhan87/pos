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
            echo $this->session->flashdata('message');
            echo '</div>';
        }
        ?> 
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group">
					<button type="button" class="btn btn-success">Add New <i class="fa fa-plus"></i></button>
					<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
					<ul class="dropdown-menu" role="menu">
						<li>
							<?php echo anchor('pos/Items/create','Product'); ?>
						</li>
						<li>
							<?php echo anchor('pos/Items/createService','Services'); ?>
						</li>
						
					</ul>
				</div>
				<!-- /btn-group -->
                <?php //echo anchor('pos/C_items_import','Import Products','class="btn btn-success"'); ?>
                
                <?php echo anchor('pos/Categories','Categories','class="btn btn-primary"'); ?>
                <!-- Trigger the modal with a button 
                 <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#create-Product-Modal">Add New Product</button>
                -->
            </div>
            <!-- /.col-sm-12 -->
        </div>
        <!-- /.row -->
        
        <div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i><span id="print_title"><?php echo $main; ?></span>
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
					<a href="#portlet-config" data-toggle="modal" class="config"></a>
					<a href="javascript:;" class="reload"></a>
					<a href="javascript:;" class="remove"></a>
				</div>
			</div>
        <div class="portlet-body flip-scroll">
                
<?php
if(count($items))
{
?>
<table class="table table-striped table-condensed table-hover flip-content" id="sample_2">
            <thead class="flip-content">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Cost Price(avg)</th>
                    <th>Unit Price</th> 
                    <th>Action</th>
                </tr>
            </thead>
            
    <tbody>
<?php
 $sno = 1;
foreach($items as $key => $list)
{
    // echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
    echo '<td>'.$list['item_id'].'</td>';
    //echo '<td>'.$sno++.'</td>';
    //echo '<td>'.$list['barcode'].'</td>';
    echo '<td>'.anchor('pos/Items/item_transactions/'.$list['item_id'],$list['name']).' '.$list['size'].'</td>';
    //echo '<td>'.$list['name'].'</td>';
    //echo '<td>'..'</td>';
    echo '<td>';
    if($list['service'] == 1)
    {
        echo 'Service';
    }else { 
        echo 'Product'; 
        }
    echo '</td>';
    echo '<td>'.$list['quantity'].'</td>';
    echo '<td>'.$this->M_units->get_unitName($list['unit_id']).'</td>';
    echo '<td>'.$list['avg_cost'].'</td>';
    echo '<td>'.$list['unit_price'].'</td>';
   $total_cost = ($list['quantity']*$list['avg_cost']);
    echo '<td>';
?>
<?php 
        if($list['service'] == 1)
        {
        ?> 
            <a href="<?php echo site_url('pos/Items/editService/'.$list['item_id']) ?>" title="Edit"><i class="fa fa-pencil fa-fw"></i></a> |
        
        <?php
        }else { 
        ?>
            <a href="<?php echo site_url('pos/Items/edit/'.$list['item_id'].'/'.$list['size_id']) ?>" title="Edit"><i class="fa fa-pencil fa-fw"></i></a> |
        <?php
            }
        ?>
        <a href="<?php echo site_url('pos/Items/delete/'.$list['item_id'].'/'.$list['inventory_acc_code'].'/'.$total_cost.'/'.$list['size_id']) ?>" title="Make Inactive" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash-o fa-fw"></i></a>
        
<?php
    echo  '</td>';
   // echo  anchor(site_url('up_property_images/upload_images/'.$list['id']),' upload Images'). '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

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
