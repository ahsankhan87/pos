
<?php
//flash messages
      if(isset($flash_message)){
        if($flash_message == TRUE)
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">�</a>';
            echo '<strong>Well done!</strong> new supplier created with success.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">�</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
          echo '</div>';          
        }
      }
?>
<div class="row">
    <div class="col-sm-12">
   
<?php 
$attributes = array('class' => 'form-horizontal', 'role' => 'form','enctype'=>"multipart/form-data");
echo validation_errors();
echo form_open('pos/C_banking/create',$attributes);

?>
<div class="form-group">
  <label class="control-label col-sm-2" for="cash_acc_code">Cash Account:</label>
  <div class="col-sm-10">
    <?php echo form_dropdown('cash_acc_code',$accountDDL,1001,'class="form-control select2me"'); ?>
    <?php echo anchor('accounts/C_groups','Add New <i class="fa fa-plus"></i>',''); ?>
    
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="bank_acc_code">Bank Account:</label>
  <div class="col-sm-10">
    <?php echo form_dropdown('bank_acc_code',$accountDDL,1002,'class="form-control select2me"'); ?>
    
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="opening">Opening Balance Debit:</label>
  <div class="col-sm-4">
    <input type="number" class="form-control" name="op_balance_dr" value="<?php echo set_value('op_balance_dr') ?>" min="0" step="0.01" placeholder="Opening Balance Amount" />
  </div>
  
  <label class="control-label col-sm-2" for="opening">Opening Balance Credit:</label>
  <div class="col-sm-4">
    <input type="number" class="form-control" name="op_balance_cr" value="<?php echo set_value('op_balance_cr') ?>" min="0" step="0.01" placeholder="Opening Balance Amount" />
  </div>
  
</div>

<?php if(@$_SESSION['multi_currency'] == 1)
{
?>
<div class="form-group">
  <label class="control-label col-sm-2" for="currency_id">Currency:</label>
  <div class="col-sm-4">
    <?php echo form_dropdown('currency_id',$currencyDropDown,set_value('currency_id'),'class="form-control select2me" required=""'); ?>
  </div>

<label class="col-md-2 control-label">Exchange Rate</label>
<div class="col-md-4">
	<input type="text" class="form-control" name="exchange_rate" value="<?php echo set_value('exchange_rate') ?>" placeholder="Enter Exchange Rate">

</div>
</div>
<?php } ?>

<div class="form-group">
  <label class="control-label col-sm-2" for="bank_name">Bank Name:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="bank_name" autofocus name="bank_name" value="<?php echo set_value('bank_name') ?>"  placeholder="Bank Name" />
  </div>
</div>
 
<div class="form-group">
  <label class="control-label col-sm-2" for="bank_account_no">Bank Account No:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="bank_account_no" name="bank_account_no" value="<?php echo set_value('bank_account_no') ?>"  placeholder="Bank Account No" />
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="acc_holder_name">Account Holder Name:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="acc_holder_name" name="acc_holder_name" value="<?php echo set_value('acc_holder_name') ?>"  placeholder="Account Holder Name" />
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="bank_branch">Bank Branch:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="bank_branch" name="bank_branch" value="<?php echo set_value('bank_branch') ?>"  placeholder="Bank Branch" />
  </div>
</div>

<?php 

echo '<div class="form-group"><label class="control-label col-sm-2" for="submit"></label>';
echo '<div class="col-sm-10">';
echo form_submit('submit','Submit','class="btn btn-success"');
echo '</div></div>';

echo form_close();
 
?>
</div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->