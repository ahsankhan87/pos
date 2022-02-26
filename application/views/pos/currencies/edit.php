
<?php
if($this->session->flashdata('message'))
{
    echo "<div class='alert alert-danger fade in'>";
    echo $this->session->flashdata('message');
    echo '</div>';
}
?>

<?php 
foreach($currency as $values):
$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'enctype'=>"multipart/form-data");
echo validation_errors();
echo form_open('setting/C_currencies/edit',$attributes);

echo form_hidden('id',$values['id']);
?>

<div class="form-group">
  <label class="control-label col-sm-2" for="Name">Name:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="Name" name="name" value="<?php echo $values['name']; ?>" placeholder="Name" />
  </div>
</div>
 
<div class="form-group">
  <label class="control-label col-sm-2" for="country">Country:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="country" name="country" value="<?php echo $values['country']; ?>"placeholder="country" />
  </div>
</div>
 
 <div class="form-group">
  <label class="control-label col-sm-2" for="code">Code:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="code" name="code" value="<?php echo $values['code']; ?>"placeholder="code" />
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="symbol">Symbol:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="symbol" name="symbol" value="<?php echo $values['symbol']; ?>" placeholder="symbol" />
  </div>
</div>

<?php

echo '<div class="form-group"><label class="control-label col-sm-2" for="submit"></label>';
echo '<div class="col-sm-10">';
echo form_submit('submit','Update','class="btn"');
echo '</div></div>';
endforeach;
?>