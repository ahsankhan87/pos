
<div class="row">
    <div class="col-sm-12">
   
<?php 
$attributes = array('class' => 'form-horizontal', 'role' => 'form','enctype'=>"multipart/form-data");
echo validation_errors();
echo form_open('mfg/C_workcenters/create',$attributes);

?>
<div class="form-group">
  <label class="control-label col-sm-2" for="Name">Workcenter Name:<span class="required text-danger">* </span></label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="name" name="name" placeholder="Workcenter Name" />
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="description">Description:</label>
  <div class="col-sm-10">
    <textarea name="description" class="form-control"></textarea>
    
  </div>
</div>

<?php 
echo '<div class="form-group"><label class="control-label col-sm-2" for="status">Status</label>';
echo '<div class="col-sm-10">';
$option = array('1'=>'Active','0'=>'Inactive');
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