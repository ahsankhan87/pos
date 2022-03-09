<div class="row">
  <div class="col-sm-12">

    <?php
    if ($this->session->flashdata('message')) {
      echo "<div class='alert alert-success fade in'>";
      echo $this->session->flashdata('message');
      echo '</div>';
    }
    if ($this->session->flashdata('error')) {
      echo "<div class='alert alert-danger fade in'>";
      echo $this->session->flashdata('error');
      echo '</div>';
    }
    ?>
    <p><?php echo anchor('pos/C_employees/create', lang('add_new') . ' <i class="fa fa-plus"></i>', 'class="btn btn-success"'); ?></p>

    <?php
    if (count($employees)) {

    ?>
      <div class="portlet">
        <div class="portlet-title">
          <div class="caption">
            <i class="fa fa-cogs"></i><span id="print_title"><?php echo $main; ?></span>
          </div>
          <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="#portlet-config" data-toggle="modal" class="config"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
          </div>
        </div>
        <div class="portlet-body flip-scroll">

          <table class="table table-striped table-bordered table-condensed flip-content" id="sample_2">
            <thead class="flip-content">
              <tr>
                <th>ID</th>
                <th><?php echo lang('name'); ?></th>
                <th><?php echo lang('email'); ?></th>
                <th><?php echo lang('address'); ?></th>
                <th><?php echo lang('contact'); ?></th>
                <th><?php echo lang('payment'); ?></th>
                <th><?php echo lang('action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($employees as $key => $list) {
                echo '<tr>';
                //echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                echo '<td>' . $list['id'] . '</td>';

                //echo '<td>'.$list['account_code'].'</td>';  
                //echo '<td><a href="'.site_url('pos/C_employees/empSalesReport/'. $list['id']).'">'.$list['first_name'] . ' '. $list['last_name'].'</a></td>';
                echo '<td>' . $list['first_name'] . ' ' . $list['last_name'] . '</td>';

                echo '<td>' . $list['email'] . '</td>';
                //echo '<td>'.$this->M_areas->get_areaName($list['area_id']).'</td>';
                echo '<td>' . $list['address'] . '</td>';
                echo '<td>' . $list['contact'] . '</td>';

                //echo '<td>'.$list['status'].'</td>';
                //echo '<td><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#employee-payment-Modal">Pay Salary</button></td>';
                echo '<td><a href="' . site_url('pos/C_employees/paymentModal/' . $list['id']) . '" class="btn btn-warning btn-sm" >Pay Salary</a></td>';

                echo '<td>';
                //echo  anchor(site_url('up_employee_images/upload_images/'.$list['id']),' upload Images');
                echo anchor('pos/C_employees/edit/' . $list['id'], '<i class="fa fa-pencil-square-o fa-fw"></i>', ' title="Edit"'); ?> |
                <a href="<?php echo site_url('pos/C_employees/inactivate/' . $list['id']) ?>" onclick="return confirm('Are you sure you want to delete?')" title="Make Inactive"><i class="fa fa-trash-o fa-fw"></i></a>


            <?php
                echo '</td>';
                echo '</tr>';
              }
              echo '</tbody></table>';
            }
            ?>
        </div>
      </div>
  </div>
  <!-- /.col-sm-12 -->
</div>
<!-- /.row -->

<!-- C_employee-payment-Modal Modal -->
<div id="employee-payment-Modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Make Payment</h4>
      </div>
      <div class="modal-body">

        <form action="<?php echo site_url('pos/C_employees/makePayment'); ?>" method="post" class="form-inline" role="form">
          <div class="form-group">
            <input type="number" class="form-control" readonly="" style="width: 100px;" name="ledger_id" value="<?php echo $ledger_id ?>" />
          </div>
          <div class="form-group">
            <input type="text" class="form-control" readonly="" name="name" value="<?php echo $name ?>" />
          </div>
          <div class="form-group">
            <input type="number" class="form-control" name="amount" style="width: 200px;" placeholder="Amount" required="" />
          </div>

          <div class="form-group">
            <textarea class="form-control" placeholder="Narration" name="narration" rows="5" cols="65" id="comment"></textarea>
          </div>

      </div>
      <div class="modal-footer">
        <input type="submit" value="Save" class="btn btn-default" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

      </form>
    </div>

  </div>
</div>