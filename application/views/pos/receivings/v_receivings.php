<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header lead"><?php echo $main; ?></h1>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->

<?php
if($this->session->flashdata('success_msg'))
{
    echo "<div class='alert alert-success'>";
    echo $this->session->flashdata('success_msg');
    echo '</div>';
}
if($this->session->flashdata('error'))
{
    echo "<div class='alert alert-danger fade in'>";
    echo  $this->session->flashdata('error');
    echo "</div>";
}
?>

<div class="row">
    <div class="col-sm-12">
  
<?php 
$attributes = array('class' => 'form-horizontal', 'role' => 'form','enctype'=>"multipart/form-data");
    echo form_open('pos/C_receivings/addCart',$attributes); ?>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="">Select Product:</label>
      <div class="col-sm-4">
        <?php echo form_dropdown('item_id',$itemDDL,'','class="form-control"') ?>
      </div>
      </div>
      
    <div class="form-group">
      <label class="control-label col-sm-2" for="">Purchase Quantity:</label>
      <div class="col-sm-4">
          
       <input type="number" class="form-control" id="qty" name="quantity" placeholder="Quantity"/>
    
      </div>
    </div>
      
    <div class="form-group">
      <label class="control-label col-sm-2" for="">Discount in Percent:</label>
      <div class="col-sm-4">
         <input type="number" class="form-control" id="discount_percent" name="discount_percent" placeholder="Discount Percent"/>
    
      </div>
    </div>
    
    <div class="form-group" id="color-panel-btn">
      <label class="control-label col-sm-2" for=""> </label>
      <div class="col-sm-4">
        <div class="btn btn-primary" id="color-btn" title="If you have product color then select color otherwise add new color or leave empty">Select Product Color</div>
      </div>
    </div>
    
    <div class="form-group" id="color-panel" style="display:none">
      <label class="control-label col-sm-2" for="">Select Color:</label>
      <div class="col-sm-4">
        <?php echo form_dropdown('colorsDDL',$colors,'','class="form-control"'); ?>
        <?php echo anchor('pos/colors','Add New','class="btn btn-info btn-xs"'); ?>
      </div>
    </div>
    
    <div class="form-group" id="size-panel-btn">
      <label class="control-label col-sm-2" for=""> </label>
      <div class="col-sm-4">
        <div class="btn btn-primary" id="size-btn" title="If you have product size then select size otherwise add new size or leave empty">Select Product Size</div>
      </div>
    </div>
    
    <div class="form-group" id="size-panel"  style="display:none">
      <label class="control-label col-sm-2" for="">Select Size:</label>
      <div class="col-sm-4">
            <?php  echo form_dropdown('sizesDDL',$sizes,'','class="form-control"');?>
            <?php echo anchor('pos/sizes','Add New','class="btn btn-info btn-xs"'); ?>
      </div>
      </div>
    

<input type="submit" name="add_item" class="btn btn-success" value="Add Product" />
</form>

<?php echo form_close(); ?>

</div>
</div>

<hr />


<?php if($this->cart->contents()){ ?>

<div id="">
<?php echo form_open('pos/C_receivings/update_cart'); ?>

<table class="table table-striped">
<thead>
<tr>
  <th>Qty</th>
  <th>Product Description</th>
  <th>Cost Price</th>
  <th>Unit Price</th>
  <th>Discount</th>
  <th>Sub-Total</th>
  <th>Remove</th>
</tr>
</thead>
<?php $i = 1; ?>
<tbody>
<?php foreach ($this->cart->contents() as $items): ?>

	<?php echo form_hidden('rowid[]', $items['rowid']); ?>

	<tr>
	  <td><?php echo form_input(array('name' => 'qty[]','type'=>'number', 'value' => $items['qty'], 'id'=>'qty', 'style="width: 50px;"' => '')); ?></td>
	  <td>
		<strong><?php echo $items['name']; ?></strong>
      
        <?php echo '<br />'.(!isset($items['item_qty']) ? '<em style="color:red;">0' : '<em style="color:green;">'.$items['item_qty']) . " qty in stock</em>"; ?>
		
        	<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>

				<p>
					<?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>

						<?php 
                        
                       if($option_value != 0)//if item have no options i.e color and size then dont show below code
                        {  
                            if($option_name == 'color')
                            {
                                //get color and size name using option id's 
                                $color = $this->m_colors->get_color($option_value);
                                echo '<strong>'. $option_name . ':</strong> '. @$color[0]['name'] . '<br />'; 
                            }
                            if($option_name == 'size')
                            {
                                $size = $this->M_sizes->get_size($option_value);
                                echo '<strong>'. $option_name . ':</strong> '. @$size[0]['name'] . '<br />'; 
                            }
                         }
                        ?>

					<?php endforeach; ?>
				</p>

			<?php endif; ?>

	  </td>
      
      <td><?php echo forM_input(array('name' => 'cost_price[]', 'value' => $items['price'], 'type'=>'number', 'style="width: 100px;"' => '')); ?></td>
	  <td>$<?php echo $this->cart->format_number($items['unit_price']); ?></td>
      <td><?php echo $this->cart->format_number($items['discount_percent']); ?>%</td>
      <?php $discount = ($items['subtotal']*$items['discount_percent']/100); //calculate discount and subtract from subtotal amount ?>
      <td>$<?php echo $this->cart->format_number($items['subtotal']-$discount); ?></td>
      <td><?php echo anchor('pos/C_receivings/removeCart/'.$items['rowid'],'<i class="fa fa-trash-o fa-1x" style="color:red;"></i>'); ?></a></td>
	</tr>
    
<?php @$discount_total += $discount; //add total discount of the cart and subtract from total amount ?>

<?php $i++; ?>

<?php endforeach; ?>

<?php @$discount = $discount_total; ?>

<tr>
  <td colspan="4"></td>
  <td class="right"><strong>Total</strong></td>
  <td class="right">&dollar;<?php echo $this->cart->format_number($this->cart->total()-$discount); ?></td>
  <td><?php echo anchor('pos/C_receivings/destroyCart/','Destroy','class="btn btn-danger btn-xs"'); ?></td>
</tr>
</tbody>
</table>

<p><?php echo form_submit('', 'Update your Cart','class="btn btn-success" title="If you make any changes in cart the you MUST update you cart"'); ?></p>
<?php echo form_close(); ?>

<?php echo form_open('pos/C_receivings/checkout'); ?>


      
<p><?php echo form_submit('', 'Checkout','class="btn btn-primary"'); ?></p>

<?php echo form_close(); ?>
</div><!-- close main_div here -->
<?php } //cart centent if close ?>