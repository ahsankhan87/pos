<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-reorder"></i><?php echo $main; ?>
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
					<a href="#portlet-config" data-toggle="modal" class="config"></a>
					<a href="javascript:;" class="reload"></a>
					<a href="javascript:;" class="remove"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
                <?php echo validation_errors();?>
				<form action="#" id="account_form" class="form-horizontal">
                    <input type="hidden" id="url" value="<?php echo site_url('accounts/C_groups/create') ?>"/>
                    
                    
					<div class="form-body">
						<div class="alert alert-danger display-hide">
							<button class="close" data-close="alert"></button>
							<?php echo lang('error_msg'); ?>
						</div>
						<div class="alert alert-success display-hide">
							<button class="close" data-close="alert"></button>
							<?php echo lang('account').' '.lang('created'); ?>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<input type="text" name="title" data-required="1" class="form-control"/>
							</div>
						</div>
                        <div class="form-group">
							<label class="control-label col-md-3">Urdu Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<input type="text" name="title_ur" class="form-control"/>
							</div>
						</div>
                        <div class="form-group">
							<label class="control-label col-md-3">Name <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<input type="text" name="name" class="form-control"/>
							</div>
						</div>
                        <div class="form-group">
							<label class="control-label col-md-3">Opening Debit Amount</label>
							<div class="col-md-4">
                                <input type="number" name="op_balance_dr" class="form-control"/>
							</div>
						</div>
                        <div class="form-group">
							<label class="control-label col-md-3">Opening Credit Amount</label>
							<div class="col-md-4">
                                <input type="number" name="op_balance_cr" class="form-control"/>
							</div>
						</div>
                        <div class="form-group">
							<label class="control-label col-md-3">Type <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<select class="form-control" name="type" class="select2me">
									<option value="">Select...</option>
									<option value="detail">Detail / Ledger</option>
									<option value="group">Group</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Parent Account</label>
							<div class="col-md-4">
								<?php echo form_dropdown('parent_code',$grpDDL,'','class="form-control" class="select2me"'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Account Type <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo form_dropdown('account_type_id',$accTypesDDL,'','class="form-control"'); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Level <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<select class="form-control" name="level" class="select2me">
									<option value="">Select...</option>
									<option value="1">Level 1</option>
									<option value="2">Level 2</option>
									<option value="3">Level 3</option>
									
								</select>
							</div>
						</div>
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<button type="submit" class="btn btn-success">Submit</button>
							<button type="button" onclick="window.history.back();" class="btn btn-default">Cancel</button>
						</div>
					</div>
				</form>
				<!-- END FORM-->
			</div>
		</div>
		<!-- END VALIDATION STATES-->
	</div>
</div>