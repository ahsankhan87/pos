
<div class="row">
    <div class="col-sm-12">
   
<?php 
$attributes = array('class' => 'form-horizontal', 'role' => 'form','enctype'=>"multipart/form-data");
echo validation_errors();
echo form_open('pos/C_areas/create',$attributes);

?>
<div class="form-group">
  <label class="control-label col-sm-2" for="Name">area Name:<span class="required">* </span></label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="name" name="name" placeholder="Area Name" />
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="description">Area Description:</label>
  <div class="col-sm-10">
    <textarea class="form-control" id="description" name="description" placeholder="description" ></textarea>
    
  </div>
</div>
<?php 
echo '<div class="form-group"><label class="control-label col-sm-2" for="status">Status</label>';
echo '<div class="col-sm-10">';
$option = array('active'=>'active','inactive'=>'inactive');
echo form_dropdown('status',$option,'','class="form-control"') . '</div></div>';
 

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