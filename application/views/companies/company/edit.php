<?php
if ($this->session->flashdata('message')) {
  echo "<div class='alert alert-success fade in'>";
  echo $this->session->flashdata('message');
  echo '</div>';
}
?>

<?php
foreach ($Company as $values) :

  $attributes = array('class' => 'form-horizontal', 'role' => 'form', 'enctype' => "multipart/form-data");
  echo form_open('companies/C_company/index/' . $values['id'], $attributes);

  echo form_hidden('id', $values['id']);


?>
  <?php
  //echo strtotime(date('2018-12-31 12:00:00'));
  //        echo '<br />';
  //        echo  time()+(60*60*24*90); //add 30 days to curent date
  //        echo '<br />';
  // echo   $expire_days = ceil(($values['expire']-time())/60/60/24); //total expire days
  //echo date('Y-m-d H:i:s',1546257600);
  ?>
  <div class="note note-warning hidden-print">
    <p>
      <?php $expire_days = ceil(($values['expire'] - time()) / 60 / 60 / 24); //total expire days 
      ?>
      <span class="strong"><strong>You have <?php echo $expire_days ?> days remaining.</strong></span>
      <br />This product will expire on <strong><?php echo date('F d, Y', $values['expire']) ?></strong>
      <!-- <a href="<?php echo site_url('reports/C_profitloss/run_pl_report') ?>" class="btn btn-success">Run Retained Earning Report</a> -->
    </p>

  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="Company Name">Company Name:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="name" value="<?php echo $values['name']; ?>" name="name" placeholder="Company Name" />
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="tax_no">Tax / VAT No.:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="tax_no" value="<?php echo $values['tax_no']; ?>" name="tax_no" placeholder="Tax / VAT No." />
    </div>
  </div>

  <!--
<div class="form-group">
  <label class="control-label col-sm-2" for="userName">Username:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="username" value="<?php echo $values['username']; ?>" name="username" placeholder="User Name"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="Password">Password:</label>
  <div class="col-sm-10">
    <input type="password" class="form-control" id="password" value="<?php echo $values['password']; ?>" name="password" />
  </div>
</div>
-->
  <div class="form-group">
    <label class="control-label col-sm-2" for="Email">Email:</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="Email" value="<?php echo $values['email']; ?>" name="email" placeholder="Email" />
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="Address">Address:</label>
    <div class="col-sm-10">
      <textarea class="form-control" name="address"><?php echo $values['address']; ?></textarea>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="fy_start">Fiscal Year:</label>
    <div class="col-sm-10">
      <?php echo FY_YEAR; ?>
    </div>
  </div>

  <!--
<div class="form-group">
  <label class="control-label col-sm-2" for="fy_start">Fiscal Year Start:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="datepicker" value="<?php echo $values['fy_start']; ?>" name="fy_start" placeholder=""/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="fy_end">Fiscal Year End:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="Todatepicker" value="<?php echo $values['fy_end']; ?>" name="fy_end" placeholder=""/>
  </div>
</div>
-->


  <!-- <div class="form-group">
  <label class="control-label col-sm-2" for="is_multi_currency">Multi Currency:</label>
  <div class="col-sm-10">
    <input type="checkbox" name="" value="1" <?php echo ($values['is_multi_currency'] == 1 ? 'disabled="" checked=""' : ''); ?>/>
    <small>If Multi Currency is enabled it will not change again.</small>
  </div>
</div> -->

  <div class="form-group">
    <label class="control-label col-sm-2" for="currency_name">Home Currency:</label>
    <div class="col-sm-10">
      <?php $currency = ($values['currency_id'] == 0 ? '' : $values['currency_id']); ?>
      <?php echo form_dropdown('currency_id', $currencyDropDown, $currency, 'class="form-control" required=""'); ?>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="Contactno">Contact No:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="contact_no" value="<?php echo $values['contact_no']; ?>" name="contact_no" placeholder="Contact No" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="logo">Select Logo:</label>
    <div class="col-sm-10">
      <?php if (!empty($values['image']) || $values['image'] != '') {
        echo '<img src="' . base_url('images/company/thumb/' . $values['image']) . '" width="100" height="100" class="img-rounded" alt="picture"/>';
      }
      ?>
      <input type="hidden" name="image" value="<?php echo $values['image']; ?>" />
      <input type="file" id="logo" class="form-control" name="upload_pic" />
    </div>
  </div>

<?php


  echo '<div class="form-group"><label class="control-label col-sm-2" for="submit"></label>';
  echo '<div class="col-sm-10">';
  echo form_submit('submit', 'Update', 'class="btn btn-success"');
  echo '</div></div>';
endforeach;
?>