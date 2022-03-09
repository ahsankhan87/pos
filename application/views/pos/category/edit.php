
<div class="row">
    <div class="col-sm-12">
    
   <?php 
foreach($category as $values):
$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'enctype'=>"multipart/form-data");
echo form_open('pos/Categories/edit',$attributes);

echo  form_hidden('id',$values['id']);

?>

<div class="form-group">
  <label class="control-label col-sm-2" for="Name">Category Name:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="name" value="<?php echo $values['name']; ?>" name="name" placeholder="Category Name"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="short_desc">Short Description:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="short_desc" value="<?php echo $values['short_desc']; ?>" name="short_desc" placeholder="Short Description"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="long_desc">Long Description:</label>
  <div class="col-sm-10">
    <textarea name="long_desc" class="form-control"><?php echo $values['long_desc']; ?></textarea>
    
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="Parent">Parent/Root:</label>
  <div class="col-sm-10">
    <?php echo form_dropdown('parent_id',$categories,$values['parent_id'],'class="form-control select2me"'); ?>
  </div>
</div>


<?php 
 
echo '<div class="form-group"><label class="control-label col-sm-2" for="status">Status</label>';
echo '<div class="col-sm-10">';
$option = array('active'=>'active','inactive'=>'inactive');
echo form_dropdown('status',$option,$values['status'],'class="form-control"') . '</div></div>';
 

echo '<div class="form-group"><label class="control-label col-sm-2" for="submit"></label>';
echo '<div class="col-sm-10">';
echo form_submit('submit','Update','class="btn btn-success"');
echo '</div></div>';

echo form_close();

endforeach;
?>
</div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->

