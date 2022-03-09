<?php 
echo form_open('accounts/C_ledgers/create');

echo '<p><label for="Parent Group">Group</label>';
echo form_dropdown('group_id',$grpDDL). '</p>';

echo '<p><label for="name">Title</label>';
$data = array('name'=>'title','id'=>'name','size'=>25);
echo form_input($data). '</p>';

echo '<p><label for="name">Name</label>';
$data = array('name'=>'name','id'=>'name','size'=>25);
echo form_input($data). '</p>';

echo '<p><label for="Entry">Opening Balance: </label>';

$data = array('name'=>'op_dr_balance','id'=>'','type'=>'number', 'placeholder'=>'Debit');
echo form_input($data);
$data = array('name'=>'op_cr_balance','id'=>'','type'=>'number', 'placeholder'=>'Credit');
echo form_input($data). '</p>';

echo form_submit('submit','Submit');
echo form_close();

?>