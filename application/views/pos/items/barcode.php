
  <div style="margin: 10%;">
  	<h2 class="text-center">BARCODE GENERATOR</h2>
  	<form class="form-horizontal" method="post" action="<?php echo site_url('pos/items/print_barcode'); ?>" target="_blank">
  	<div class="form-group">
      <label class="control-label col-sm-2" for="product">Product:</label>
      <div class="col-sm-10">
        <?php echo form_dropdown('item_id',$productsDDL,'','class="form-control select2me" required="required"'); ?>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="print_qty">Barcode Print Quantity</label>
      <div class="col-sm-10">          
        <input autocomplete="OFF" type="print_qty" value="1" class="form-control" id="print_qty"  name="print_qty">
      </div>
    </div>

    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Print Barcode</button>
      </div>
    </div>
  </form>
  </div>
