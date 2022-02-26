
<?php 
echo form_open('setting/C_fyear/edit','class="form-horizontal"');
echo '<div class="form-body">';
foreach($Fyear as $row)
{

echo '<div class="form-group">';
echo '<label class="control-label col-md-3" for="fy_start_date">Fiscal Start Date</label>';
echo '<div class="col-md-4">';
$data = array('name'=>'fy_start_date','type'=>'date','class'=>'form-control');
echo form_input($data,$row['fy_start_date']);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo '<label class="control-label col-md-3" for="fy_start_date">Fiscal End Date</label>';
echo '<div class="col-md-4">';
$data = array('name'=>'fy_end_date','type'=>'date','class'=>'form-control','size'=>25);
echo form_input($data,$row['fy_end_date']);
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo '<label class="control-label col-md-3" for="fy_year">Fiscal Year Text</label>';
echo '<div class="col-md-4">';
$data = array('name'=>'fy_year','type'=>'text','class'=>'form-control','size'=>25);
echo form_input($data,$row['fy_year']);
echo '</div>';
echo '</div>';

//echo '<p><label for="types">Status</label>';
//$data = array('active'=>'active','inactive'=>'inactive');
//echo form_dropdown('status',$data,$row['status']). '</p>';

echo form_hidden('id',$row['id']);

echo '<div class="col-md-offset-3 col-md-9">';
echo form_submit('submit','Update','class="btn btn-success"');
echo '</div>';
}
echo '</div>';
echo form_close();

?>