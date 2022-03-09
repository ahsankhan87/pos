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
<table class="table table-striped table-condensed flip-content" id="sample_2">
            <thead class="flip-content">
                <tr>
                    <th>Trans ID</th>
                    <th>Invoice No</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Cost Price</th>
                    <th>Unit Price</th>
                    <th>Comments</th>
                    <th>Transaction Date</th>
                    <th>User</th>
                </tr>
            </thead>
            
    <tbody>
<?php
 $sno = 1;
foreach($items as $key => $list)
{
    // echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
    
    echo '<td>'.$list['trans_id'].'</td>';
    //echo '<td>'.$sno++.'</td>';
    echo '<td>';
    if($list['trans_inventory'] > 0 && $list['invoice_no'] != NULL)
    {
        echo '<a href="'.site_url('trans/C_receivings/receipt/'.$list['invoice_no']).'" target="_blank">'.$list['invoice_no'];
   
    }elseif($list['trans_inventory'] < 0 && $list['invoice_no'] != NULL)
    {
        echo anchor('trans/C_sales/receipt/'.$list['invoice_no'],$list['invoice_no'],'target="_blank"');
            
    }
    echo '</td>';
    echo '<td>'.$this->M_items->get_ItemName($list['trans_item']).'</td>';
    //echo '<td>'.anchor(''.$list['item_id'],$list['name']).'</td>';
    echo '<td>'.$list['trans_inventory'].'</td>';
    echo '<td>'.$list['cost_price'].'</td>';
    echo '<td>'.$list['unit_price'].'</td>';
    echo '<td>'.$list['trans_comment'].'</td>';
    
    echo '<td>'.$list['trans_date'].'</td>';
    $trans_user = $this->M_users->get_activeUsers($list['trans_user']);
    echo '<td>'.$trans_user[0]['name'].'</td>';
    
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
