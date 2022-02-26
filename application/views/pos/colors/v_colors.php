<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header lead"><?php echo $main; ?></h1>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
<?php
if($this->session->flashdata('message'))
{
    echo "<div class='alert alert-success fade in'>";
    echo $this->session->flashdata('message');
    echo '</div>';
}
?>

<p><?php echo anchor('pos/Colors/create','Create New Colors','class="btn btn-primary"'); ?></p>

<?php
if(count($colors))
{
?>
<table class="table table-striped">
<thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
</thead>

<tbody>
<?php
foreach($colors as $key => $list)
{
    echo '<tr>';
    echo '<td>'.$list['id'].'</td>';
    echo '<td>'.$list['name'].'</td>';
    echo '<td>'.$list['status'].'</td>';
    
    echo '<td>'.anchor('pos/Colors/edit/'.$list['id'],'Edit'). ' | ';
    echo  anchor('pos/Colors/delete/'.$list['id'],' Delete'). '</td>';
    echo '</tr>';
}
echo '</tbody></table>';
}
?>