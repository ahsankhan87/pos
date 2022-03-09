
<div class="row">
    <div class="col-sm-12">
   
<?php 
$attributes = array('class' => 'form-horizontal', 'role' => 'form','enctype'=>"multipart/form-data");
echo form_open('pos/Categories/create',$attributes);
?>

<div class="form-group">
  <label class="control-label col-sm-2" for="Name">Category Name:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="name" name="name" placeholder="Category Name"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="short_desc">Short Description:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="short_desc" name="short_desc" placeholder="Short Description"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="long_desc">Long Description:</label>
  <div class="col-sm-10">
    <textarea name="long_desc" class="form-control">
    </textarea>
    
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="Parent">Parent/Root:</label>
  <div class="col-sm-10">
    <?php echo form_dropdown('parent_id',$categories,'','class="form-control select2me"'); ?>
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