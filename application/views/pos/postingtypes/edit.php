<div class="row">
    <div class="col-sm-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-reorder"></i>Form Actions On Bottom
			</div>
			<div class="tools">
				<a href="javascript:;" class="collapse"></a>
				<a href="#portlet-config" data-toggle="modal" class="config"></a>
				<a href="javascript:;" class="reload"></a>
				<a href="javascript:;" class="remove"></a>
			</div>
		</div>
		<div class="portlet-body form">
        <?php foreach($salespostingType as $values): ?>
			<!-- BEGIN FORM-->
			<form action="<?php echo site_url('setting/PostingTypes/edit'); ?>" method="post" class="form-horizontal">
				
                <input type="hidden" name="id" value="<?php echo $values['id']; ?>" />
                <div class="form-body">
                    <div class="form-group">
						<label class="col-md-3 control-label">Name</label>
						<div class="col-md-4">
							<div class="input-group">
								<input type="text" class="form-control" name="name" value="<?php echo $values['name']; ?>" placeholder="Enter Name">
							</div>
						</div>
					</div>
                     
                    <div class="form-group">
						<label class="col-md-3 control-label">Cash Account</label>
						<div class="col-md-4">
							<p class="form-control-static">
								 <?php echo form_dropdown('cash_acc_code',$accountDDL,$values['cash_acc_code'],'class="form-control select2me"'); ?>
							</p>
						</div>
					</div>
                    
                    <div class="form-group">
						<label class="col-md-3 control-label">Bank Account</label>
						<div class="col-md-4">
							<p class="form-control-static">
								 <?php echo form_dropdown('bank_acc_code',$accountDDL,$values['bank_acc_code'],'class="form-control select2me"'); ?>
							</p>
						</div>
					</div>
                    
                    <div class="form-group">
						<label class="col-md-3 control-label">Sales Account</label>
						<div class="col-md-4">
							<p class="form-control-static">
								 <?php echo form_dropdown('sales_acc_code',$accountDDL,$values['sales_acc_code'],'class="form-control select2me"'); ?>
							</p>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label">Receivable Account</label>
						<div class="col-md-4">
							<p class="form-control-static">
								 <?php echo form_dropdown('receivable_acc_code',$accountDDL,$values['receivable_acc_code'],'class="form-control select2me"'); ?>
							</p>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label">Inventory Account</label>
						<div class="col-md-4">
							<p class="form-control-static">
								 <?php echo form_dropdown('inventory_acc_code',$accountDDL,$values['inventory_acc_code'],'class="form-control select2me"'); ?>
							</p>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label">Cost of Sale Account</label>
						<div class="col-md-4">
							<p class="form-control-static">
								 <?php echo form_dropdown('cos_acc_code',$accountDDL,$values['cos_acc_code'],'class="form-control select2me"'); ?>
							</p>
						</div>
					</div>
                    
                    <div class="form-group">
						<label class="col-md-3 control-label">Sales Return Account</label>
						<div class="col-md-4">
							<p class="form-control-static">
								 <?php echo form_dropdown('salesreturn_acc_code',$accountDDL,$values['salesreturn_acc_code'],'class="form-control select2me"'); ?>
							</p>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label">Sales Discount Account</label>
						<div class="col-md-4">
							<p class="form-control-static">
								 <?php echo form_dropdown('salesdis_acc_code',$accountDDL,$values['salesdis_acc_code'],'class="form-control select2me"'); ?>
							</p>
						</div>
					</div>
                    
                    
                    <div class="form-group">
						<label class="col-md-3 control-label">Sales Tax Account</label>
						<div class="col-md-4">
							<p class="form-control-static">
								 <?php echo form_dropdown('salestax_acc_code',$accountDDL,$values['salestax_acc_code'],'class="form-control select2me"'); ?>
							</p>
						</div>
					</div>
                    
                    <?php if(@$_SESSION['multi_currency'] == 1)
                    {
                    ?>
                    <div class="form-group">
                      <label class="control-label col-sm-3" for="Gain">Forex Gain Account:</label>
                      <div class="col-sm-4">
                        <p class="form-control-static">
								 <?php echo form_dropdown('forex_gain_acc_code',$accountDDL,$values['forex_gain_acc_code'],'class="form-control select2me"'); ?>
							</p>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-sm-3" for="Loss">Forex Loss Account:</label>
                      <div class="col-sm-4">
                        <p class="form-control-static">
								 <?php echo form_dropdown('forex_loss_acc_code',$accountDDL,$values['forex_loss_acc_code'],'class="form-control select2me"'); ?>
							</p>
                      </div>
                    </div>
                    <?php } ?> 
				</div>
				<div class="form-actions">
					<div class="row">
						<div class="col-md-offset-3 col-md-9">
							<button type="submit" class="btn btn-info">Update</button>
							<button type="button" onclick="window.history.back();" class="btn btn-default">Cancel</button>
						</div>
					</div>
				</div>
			</form>
			<!-- END FORM-->
            <?php endforeach; ?>
		</div>
    </div><!-- /.col-sm-12 -->
</div><!-- /.row -->