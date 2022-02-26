<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header lead"><?php echo $main; ?></h1>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->

<div id="cart_body">
<?php echo form_open('pos/C_receivings/receivings'); ?>

<table class="table table-striped">

<tr>
  <th>Qty</th>
  <th>Product Description</th>
  <th>Cost Price</th>
  <th>Unit Price</th>
  <th>Discount</th>
  <th>Sub-Total</th>
  <th>Remove</th>
</tr>

<?php $i = 1; ?>

<?php foreach ($this->cart->contents() as $items): ?>

	<?php echo form_hidden('rowid[]', $items['rowid']); ?>

	<tr>
	  <td><?php echo $items['qty']; ?></td>
	  <td>
		<?php echo $items['name']; ?>

			<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>

				<p>
					<?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>

<?php 
                if($option_value != 0)//if item have no options i.e color and size then dont show below code
                {                        
                        if($option_name == 'color')
                        {
                            //get color and size name using option id's 
                            $color = $this->M_colors->get_color($option_value);
                            echo '<strong>'. $option_name . ':</strong> '. $color[0]['name'] . '<br />'; 
                        }
                        if($option_name == 'size')
                        {
                            $size = $this->M_sizes->get_size($option_value);
                            echo '<strong>'. $option_name . ':</strong> '. $size[0]['name'] . '<br />'; 
                        }
                 }        
                        ?>

					<?php endforeach; ?>
				</p>

			<?php endif; ?>

	  </td>
	   <td>$<?php echo $this->cart->format_number($items['price']); ?></td>
       <td>$<?php echo $this->cart->format_number($items['unit_price']); ?></td>
      <td><?php echo $this->cart->format_number($items['discount_percent']); ?>%</td>
      <?php $discount = ($items['subtotal']*$items['discount_percent']/100); //calculate discount and subtract from subtotal amount ?>
      <td>$<?php echo $this->cart->format_number($items['subtotal']-$discount); ?></td>
      <td><?php echo anchor('pos/C_receivings/removeCart/'.$items['rowid'],'X'); ?></a></td>
	</tr>

<?php @$discount_total += $discount; //add total discount of the cart and subtract from total amount ?>

<?php $i++; ?>

<?php endforeach; ?>

<?php @$discount = $discount_total; ?>

<tr>
  <td colspan="4"></td>
  <td class="right"><strong>Total</strong></td>
  <td class="right">&dollar;<?php echo $this->cart->format_number($this->cart->total()-$discount); ?></td>
  <td><?php echo anchor('pos/C_receivings/destroyCart/','Destroy'); ?></td>
</tr>

</table>

<p><?php echo form_submit('', 'Receive','class="btn btn-success"'); ?></p>
<?php echo form_close(); ?>

</div><!-- close main_div here -->