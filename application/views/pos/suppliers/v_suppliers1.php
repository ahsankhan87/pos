
<div class="row">
    <div class="col-sm-12">
        <h1 class="page-header lead"><?php echo $main; ?></h1>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->


<div class="row">
    <div class="col-sm-12">
    <?php echo anchor('pos/items/create','Create New Item','class="btn btn-info btn-sm"'); ?>
    <!-- Trigger the modal with a button 
     <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#create-Product-Modal">Add New Product</button>
    -->
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
<div ng-controller="supplierCtrl as myCrtl">
<div class="row"  >
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-bar-chart-o fa-fw"></i> <?php echo $main; ?>
        </div>  
      <!-- /.panel-heading -->
    <div class="panel-body"  >
    <div class="col-sm-4">
    <input type="search" ng-model="itemSearch" class="form-control" placeholder="Search Supplier" />
    </div>
<table class="table table-striped table-bordered table-hover" >
    <thead >
        <tr>
            <th>ID</th>
            <th>Size</th>
            <th>Name</th>
            <th>Qty</th>
            <th>Cost Price</th>
            <th>Unit Price</th> 
            <th>Action</th>
        </tr>
    </thead>
    
    <tbody ng-init="getAllSuppliers()">
    <tr ng-repeat="product in AllSuppliers | orderBy:'-name' | filter:itemSearch">
       
        <td>{{product.item_id}}</td>
        <td>{{product.size_id}}</td>
        <td>{{product.name}}</td>
        <td>{{product.quantity}}</td>
        <td>{{product.avg_cost}}</td>
        <td>{{product.unit_price}}</td>
    <td>
    <div class="btn-group">
      <a class="btn btn-primary btn-sm" href="#">Options</a>
      <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
        <span class="fa fa-caret-down"></span></a>
      <ul class="dropdown-menu">
        
        <li><a href="#" data-toggle="modal" ng-click="editItem(product.item_id,product.size_id)" data-target="#myModal"><i class="fa fa-pencil fa-fw"></i> Edit</a></li>
        <li><a href="<?php //echo site_url('pos/items/delete/'.$list['item_id']) ?>" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash-o fa-fw"></i> Delete</a></li>
        
      </ul>
    </div>

   </td>
  
    </tr>


 </tbody>
 </table>
</div>
<!-- /.panel-body -->
</div>
<!-- /.panel -->
</div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->


<!-- Create Product Modal -->
<div id="create-Product-Modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create New Product</h4>
      </div>
      <div class="modal-body">
        <p><?php echo  $this->load->view('pos/items/create'); ?></p>
      </div>
     
    </div>
</div>
</div>

<!-- Create / Update Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Product</h4>
      </div>
      <div class="modal-body">
            <form class="form-horizontal" role="form">
            <div class="form-group">
                <label class="control-label col-sm-3" for="cost">Item Id:</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" ng-model="item_id" readonly="" id="cost" placeholder="Item Id" />
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="cost">Size Id:</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" ng-model="size_id" readonly="" id="cost" placeholder="Size Id" />
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="cost">Cost Price:</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" ng-model="cost_price" id="cost" placeholder="Cost Price" />
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="unit">Unit Price:</label>
                <div class="col-sm-9"> 
                  <input type="number" class="form-control" ng-model="unit_price" id="unit" placeholder="Unit Price" />
                </div>
              </div>
              
              
      </div>
      <div class="modal-footer">
            <div class="form-group"> 
                <div class="col-sm-offset-4 col-sm-8">
                  <button type="submit" data-dismiss="modal" ng-click="createProduct('update')" class="btn btn-default">Update</button>
                  <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
                </div>
              </div>
            </form>
        
      </div>
    </div>

  </div>
</div>
</div><!-- /. ng-controller -->
