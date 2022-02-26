<h1> <?php echo $title; ?> </h1>
<p> The following products are about to be orphaned. They used to belong to the
<b> <?php foreach ($category as $row)echo $row['name']; ?> </b> category, but now they need to be reassigned. </p>
<ul>
<?php
foreach ($this->session->userdata('orphan') as $id => $name)
{
echo " <li> $name </li> \n";
}
?>
</ul>
<?php
echo form_open('pos/Categories/reasign/'.$category_id);
unset($categories[$row['id']]);
echo form_dropdown('categories',$categories,'','class="select2me"');
echo form_submit('submit','reasign');
echo form_close();
?>