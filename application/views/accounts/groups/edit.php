<?php foreach($groups as $row): ?>
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
				<form action="#" id="account_form" class="form-horizontal">
                    <input type="hidden" id="url" value="<?php echo site_url($langs.'/accounts/C_groups/edit') ?>" />
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                    
					<div class="form-body">
						<div class="alert alert-danger display-hide">
							<button class="close" data-close="alert"></button>
							<?php echo lang('error_msg'); ?>
						</div>
						<div class="alert alert-success display-hide">
							<button class="close" data-close="alert"></button>
							<?php echo lang('account').' '.lang('edited'); ?>
						</div>
                        
                        <div class="form-group">
							<label class="control-label col-md-3">Account Code <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<input type="text" name="account_code" data-required="1" value="<?php echo $row['account_code']; ?>" class="form-control"/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<input type="text" name="title" data-required="1" value="<?php echo $row['title']; ?>" class="form-control"/>
							</div>
						</div>
                        <div class="form-group">
							<label class="control-label col-md-3">Urdu Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<input type="text" name="title_ur" value="<?php echo $row['title_ur']; ?>" class="form-control"/>
							</div>
						</div>
                        <div class="form-group">
							<label class="control-label col-md-3">Name <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<input type="text" name="name" value="<?php echo $row['name']; ?>" class="form-control"/>
							</div>
						</div>
                        <div class="form-group">
							<label class="control-label col-md-3">Opening Debit Amount</label>
							<div class="col-md-4">
                                <input type="number" name="op_balance_dr"  value="<?php echo $row['op_balance_dr']; ?>" class="form-control"/>
							</div>
						</div>
                        <div class="form-group">
							<label class="control-label col-md-3">Opening Credit Amount</label>
							<div class="col-md-4">
                                <input type="number" name="op_balance_cr"  value="<?php echo $row['op_balance_cr']; ?>" class="form-control"/>
							</div>
						</div>
                        <div class="form-group">
							<label class="control-label col-md-3">Type <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php $data = array(''=>'Please Select','group'=>'Group','detail'=>'Detail / Ledger');
                                        echo form_dropdown('type',$data,$row['type'],'class="form-control" class="select2me"'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Parent Account <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo form_dropdown('parent_code',$grpDDL,$row['parent_code'],'class="form-control" class="select2me"'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Account Type <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo form_dropdown('account_type_id',$accTypesDDL,$row['account_type_id'],'class="form-control"'); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Level <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php $data = array(''=>'Please Select',1=>1,2=>2,3=>3,4=>4);
                                      echo form_dropdown('level',$data,$row['level'],'class="form-control" class="select2me"');
                                ?>
							</div>
						</div>
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<button type="submit" class="btn btn-success">Update</button>
							<button type="button" onclick="window.history.back();" class="btn btn-default">Cancel</button>
						</div>
					</div>
				</form>
				<!-- END FORM-->
                <?php endforeach; ?>

			</div>
		</div>
		<!-- END VALIDATION STATES-->
	</div>
</div>