
<?php
if($this->session->flashdata('message'))
{
    echo "<div class='alert alert-danger fade in'>";
    echo $this->session->flashdata('message');
    echo '</div>';
}
?>

<?php 
foreach($bank as $values):
$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'enctype'=>"multipart/form-data");
echo validation_errors();
echo form_open('pos/C_banking/edit',$attributes);

echo form_hidden('id',$values['id']);
?>
<div class="form-group">
  <label class="control-label col-sm-2" for="cash_acc_code">Cash Account:</label>
  <div class="col-sm-10">
    <?php echo form_dropdown('cash_acc_code',$accountDDL,$values['cash_acc_code'],'class="form-control select2me"'); ?>
    <?php echo anchor('accounts/C_groups','Add New <i class="fa fa-plus"></i>',''); ?>
    
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="bank_acc_code">Bank Account:</label>
  <div class="col-sm-10">
    <?php echo form_dropdown('bank_acc_code',$accountDDL,$values['bank_acc_code'],'class="form-control select2me"'); ?>
    
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="opening">Opening Balance Debit:</label>
  <div class="col-sm-4">
    <input type="number" class="form-control" name="op_balance_dr" value="<?php echo $values['op_balance_dr']; ?>" min="0" step="0.01" placeholder="Opening Balance Amount" />
    <input type="hidden" name="op_balance_dr_old" value="<?php echo $values['op_balance_dr']; ?>"/>
  </div>
  
  <label class="control-label col-sm-2" for="opening">Opening Balance Credit:</label>
  <div class="col-sm-4">
    <input type="number" class="form-control" name="op_balance_cr" value="<?php echo $values['op_balance_cr']; ?>" min="0" step="0.01" placeholder="Opening Balance Amount" />
    <input type="hidden" name="op_balance_cr_old" value="<?php echo $values['op_balance_cr']; ?>"/>
  </div>
  
</div>

<?php if(@$_SESSION['multi_currency'] == 1)
{
?>
<div class="form-group">
  <label class="control-label col-sm-2" for="currency_id">Currency:</label>
  <div class="col-sm-4">
    <?php echo form_dropdown('currency_id',$currencyDropDown,$values['currency_id'],'class="form-control select2me" required=""'); ?>
  </div>
  
    <label class="col-md-2 control-label">Exchange Rate</label>
    <div class="col-md-4">
    	<input type="text" class="form-control" name="exchange_rate" value="<?php echo $values['exchange_rate']; ?>" placeholder="Enter Exchange Rate">
    
    </div>
</div>
<?php } ?> 

<div class="form-group">
  <label class="control-label col-sm-2" for="bank_name">Bank Name:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="bank_name" name="bank_name" value="<?php echo $values['bank_name']; ?>" placeholder="Bank Name" />
  </div>
</div>
 
<div class="form-group">
  <label class="control-label col-sm-2" for="bank_account_no">Bank Account No:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="bank_account_no" name="bank_account_no" value="<?php echo $values['bank_account_no']; ?>" placeholder="Bank Account No" />
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="acc_holder_name">Account Holder Name:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="acc_holder_name" name="acc_holder_name" value="<?php echo $values['acc_holder_name']; ?>" placeholder="Account Holder Name" />
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="bank_branch">Bank Branch:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="bank_branch" name="bank_branch" value="<?php echo $values['bank_branch']; ?>" placeholder="Bank Branch" />
  </div>
</div>

<?php

echo '<div class="form-group"><label class="control-label col-sm-2" for="submit"></label>';
echo '<div class="col-sm-10">';
echo form_submit('submit','Submit','class="btn"');
echo '</div></div>';
endforeach;
?>
 

