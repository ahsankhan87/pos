<p><?php echo anchor('companies/C_companies/create','Create New Company','class="btn btn-primary"'); ?></p>
<?php
if($this->session->flashdata('message'))
{
    echo "<div class='alert alert-success fade in'>";
    echo $this->session->flashdata('message');
    echo '</div>';
}
?>

<?php
if(count($companies))
{
   
?>
<table class="table table-striped">
    <tr>
       
        <th>ID</th>
        <th>Name</th>
        <th>Username</th>
        <th>Email</th>
       
        <th>Address</th>
        
        <th>Status</th>
        <th>Action</th>
    </tr>
<?php
foreach($companies as $key => $list)
{
    echo '<tr valign="top">';
    //echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
    echo '<td>'.$list['id'].'</td>';
   // echo '<td><img src="'.base_url('images/Company-images/thumbs/'.$list['Company_image']).'" width="40" height="40"/></td>';
    echo '<td>'.$list['name'].'</td>';
    echo '<td>'.$list['username'].'</td>';
    echo '<td>'.$list['email'].'</td>';
    echo '<td>'.$list['address'].'</td>';
    echo '<td>'.$list['status'].'</td>';
    
    echo '<td>';
    //echo  anchor(site_url('up_Company_images/upload_images/'.$list['id']),' upload Images');
?>
 <div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">option
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><?php echo anchor('companies/C_companies/edit/'.$list['id'],'Edit'); ?></li>
    <li><?php //echo anchor('companies/C_companies/delete/'.$list['id'],'Delete'); ?></li>
    <li><?php echo anchor('companies/C_companies/activate/'.$list['id'],'Activate'); ?></li>
    <li><?php echo anchor('companies/C_companies/inactivate/'.$list['id'],'In-activate'); ?></li>
    
  </ul>
</div>

<?php
    echo '</td>';
    echo '</tr>';
}
echo '</table>';

}
?>
