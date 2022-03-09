
<?php
//flash messages
      if(isset($flash_message)){
        if($flash_message == TRUE)
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong> new supplier created with success.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
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
echo form_open('setting/C_taxes/create',$attributes);

?>

<div class="form-group">
  <label class="control-label col-sm-2" for="name">Name:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="name" name="name" placeholder="Name" />
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="rate">Rate (%):</label>
  <div class="col-sm-10">
    <input type="number" class="form-control" id="rate" name="rate" placeholder="Rate" />
  </div>
</div>
 
 <div class="form-group">
  <label class="control-label col-sm-2" for="Description">Description:</label>
  <div class="col-sm-10">
    <textarea name="description" class="form-control"></textarea>
  </div>
</div>

<?php 
 
echo '<div class="form-group"><label class="control-label col-sm-2" for="status">Status</label>';
echo '<div class="col-sm-10">';
$option = array('1'=>'active','0'=>'inactive');
echo form_dropdown('status',$option,'','class="form-control"') . '</div></div>';
 ?>
 
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