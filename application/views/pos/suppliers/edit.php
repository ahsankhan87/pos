
<?php
if($this->session->flashdata('message'))
{
    echo "<div class='alert alert-danger fade in'>";
    echo $this->session->flashdata('message');
    echo '</div>';
}


?>
<div class="row">
    <div class="col-md-12">
    <div class="portlet">
    <div class="portlet-title">
				<div class="caption">
					<i class="fa fa-reorder"></i><?php echo $main; ?>
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
					<a href="#portlet-config" data-toggle="modal" class="config"></a>
					<a href="javascript:;" class="reload"></a>
					<a href="javascript:;" class="remove"></a>
				</div>
			</div>
            <div class="portlet-body form">
<?php 
foreach($supplier as $values):
$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'enctype'=>"multipart/form-data");
//form Validation errors
echo validation_errors();
echo form_open('pos/Suppliers/edit',$attributes);


echo form_hidden('id',$values['id']);
?>
<div class="form-body">

<div class="form-group">
  <label class="control-label col-md-3" for="store Name">Account Posting Type:<span class="required">* </span></label>
  <div class="col-md-4">
    <?php echo form_dropdown('posting_type_id',$purchasePostingTypeDDL,$values['posting_type_id'],'class="form-control"'); ?>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-3" for="opening">Opening Balance Debit:</label>
  <div class="col-sm-4">
    <input type="number" class="form-control" name="op_balance_dr" value="<?php echo $values['op_balance_dr']; ?>" min="0" step="0.01" placeholder="Opening Balance Amount" />
    <input type="hidden" name="op_balance_dr_old" value="<?php echo $values['op_balance_dr']; ?>"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-3" for="opening">Opening Balance Credit:</label>
  <div class="col-sm-4">
    <input type="number" class="form-control" name="op_balance_cr" value="<?php echo $values['op_balance_cr']; ?>" min="0" step="0.01" placeholder="Opening Balance Amount" />
    <input type="hidden" name="op_balance_cr_old" value="<?php echo $values['op_balance_cr']; ?>"/>
  </div>
  
</div>

<?php if(@$_SESSION['multi_currency'] == 1)
{
?>
<div class="form-group">
  <label class="control-label col-sm-3" for="currency_id">Currency:<span class="required">* </span></label>
  <div class="col-sm-4">
    <?php echo form_dropdown('currency_id',$currencyDropDown,$values['currency_id'],'class="form-control" required=""'); ?>
  </div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Exchange Rate</label>
    <div class="col-md-4">
    	<input type="text" class="form-control" name="exchange_rate" value="<?php echo $values['exchange_rate']; ?>" placeholder="Enter Exchange Rate">
    
    </div>
</div>
<?php } ?> 

<div class="form-group">
  <label class="control-label col-md-3" for="supplier Name">Supplier Name:<span class="required">* </span></label>
  <div class="col-md-4">
    <input type="text" class="form-control" id="name" name="name" value="<?php echo $values['name']; ?>" placeholder="Supplier Name"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-3" for="store Name">Account:</label>
  <div class="col-md-4">
    <?php echo form_dropdown('acc_code',$accountDDL,$values['acc_code'],'class="form-control select2me"'); ?>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-3" for="Email">Email:</label>
  <div class="col-md-4">
    <input type="email" class="form-control" id="Email" name="email" value="<?php echo $values['email']; ?>" placeholder="Supplier Email"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-3" for="Address">Address:</label>
  <div class="col-md-4">
    <textarea class="form-control" placeholder="Address" name="address"><?php echo $values['address']; ?></textarea>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-3" for="Contactno">Contact No:</label>
  <div class="col-md-4">
    <input type="number" class="form-control" id="" name="contact_no" value="<?php echo $values['contact_no']; ?>" placeholder="Contact No"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-3" for="also">Also Customer:</label>
  <div class="col-md-4">
    <?php echo form_checkbox('also_customer',1,$values['also_customer'],'class="form-control"') ?>
  </div>
</div>
<div class="form-group">
  <label class="control-label col-md-3" for="store Name">Sale Posting Type:<span class="required">* </span></label>
  <div class="col-md-4">
    <?php echo form_dropdown('sale_posting_type_id',$salesPostingTypeDDL,$values['sale_posting_type_id'],'class="form-control"'); ?>
  </div>
</div>

</div>


<?php

echo '<div class="form-actions fluid"><label class="control-label col-sm-3" for="submit"></label>';
echo '<div class="col-md-offset-3 col-md-9">';
echo form_submit('submit','Update','class="btn btn-default"');
echo '</div></div>';
endforeach;
?>
 </div>
 </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->

