<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header lead"><?php echo $main; ?></h1>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
<?php
if($this->session->flashdata('message'))
{
    echo "<div class='alert alert-success fade in'>";
    echo $this->session->flashdata('message');
    echo '</div>';
}
?>

<?php 
foreach($Company as $values):
$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'enctype'=>"multipart/form-data");
echo form_open('companies/C_companies/edit/'.$values['id'],$attributes);

echo form_hidden('id',$values['id']);


?>

<div class="form-group">
  <label class="control-label col-sm-2" for="Company Name">Company Name:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="name" value="<?php echo $values['name']; ?>" name="name" placeholder="Company Name"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="userName">Username:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="username" value="<?php echo $values['username']; ?>" name="username" placeholder="User Name"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="Password">Password:</label>
  <div class="col-sm-10">
    <input type="password" class="form-control" id="password" value="<?php echo $values['password']; ?>" name="password" />
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="Email">Email:</label>
  <div class="col-sm-10">
    <input type="email" class="form-control" id="Email" value="<?php echo $values['email']; ?>" name="email" placeholder="Email"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="Address">Address:</label>
  <div class="col-sm-10">
      <textarea  class="form-control" name="address"><?php echo $values['address']; ?></textarea>
   
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="fy_start">Fiscal Year Start:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="datepicker" value="<?php echo $values['fy_start']; ?>" name="fy_start" placeholder=""/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="fy_end">Fiscal Year End:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="Todatepicker" value="<?php echo $values['fy_end']; ?>" name="fy_end" placeholder=""/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="currency_symbol">Currency Symbol:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="currency_symbol" value="<?php echo $values['currency_symbol']; ?>" name="currency_symbol" placeholder="Currency Symbol"/>
  </div>
</div>
<div class="form-group">
  <label class="control-label col-sm-2" for="Contactno">Contact No:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="contact_no" value="<?php echo $values['contact_no']; ?>" name="contact_no" placeholder="Contact No"/>
  </div>
</div>


<?php 
 

echo '<div class="form-group"><label class="control-label col-sm-2" for="submit"></label>';
echo '<div class="col-sm-10">';
echo form_submit('submit','Submit','class="btn"');
echo '</div></div>';
endforeach;
?>
 

