<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header lead"><?php echo $main; ?></h1>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
<?php 
echo form_open('accounts/C_ledgers/edit');

foreach($ledgers as $row)
{
    
echo '<p><label for="name">Parent Group</label>';
echo form_dropdown('group_id',$grpDDL,$row['group_id']). '</p>';

echo '</p><label for="name">Title</label>';
$data = array('name'=>'title','id'=>'name','size'=>25, 'value'=>$row['title']);
echo form_input($data). '</p>';

echo '</p><label for="name">Name <div class="small">include dash b/w spaces</div></label>';
$data = array('name'=>'name','id'=>'name','size'=>25, 'value'=>$row['name']);
echo form_input($data). '</p>';

echo '<p><label for="Entry">Opening Balance: </label>';

$data = array('name'=>'op_dr_balance','id'=>'','type'=>'number', 'placeholder'=>'Debit');
echo form_input($data,$row['op_dr_balance']);
$data = array('name'=>'op_cr_balance','id'=>'','type'=>'number', 'placeholder'=>'Credit');
echo form_input($data,$row['op_cr_balance']). '</p>';


echo '<p><label for="name">Affects Gross</label>';
$data = array('type'=>'checkbox','name'=>'affects_gross');
echo form_checkbox($data,"1",$row['affects_gross']). '</p>';

echo form_hidden('id',$row['id']);

echo form_submit('submit','Update User');
}
echo form_close();

?>