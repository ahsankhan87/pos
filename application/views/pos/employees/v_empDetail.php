<div class="row">
    <div class="col-sm-12">
        <div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-reorder"></i>View Employee Detail
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
				<form class="form-horizontal" role="form">
                <?php foreach($emp_detail as $values): ?>
					<div class="form-body">
						<h2 class="margin-bottom-20"> View Employee Info - <?php echo $values['first_name'] .' '.$values['last_name']; ?></h2>
						<h3 class="form-section">Person Info</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">First Name:</label>
									<div class="col-md-9">
										<p class="form-control-static">
											 <?php echo $values['first_name']; ?>
										</p>
									</div>
								</div>
							</div>
							<!--/span-->
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">Last Name:</label>
									<div class="col-md-9">
										<p class="form-control-static">
											 <?php echo $values['last_name']; ?>
										</p>
									</div>
								</div>
							</div>
							<!--/span-->
						</div>
						<!--/row-->
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">Gender:</label>
									<div class="col-md-9">
										<p class="form-control-static">
											 <?php echo $values['gender']; ?>
										</p>
									</div>
								</div>
							</div>
							<!--/span-->
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">Date of Birth:</label>
									<div class="col-md-9">
										<p class="form-control-static">
											 <?php echo $values['dob']; ?>
										</p>
									</div>
								</div>
							</div>
							<!--/span-->
						</div>
						<!--/row-->
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">Category:</label>
									<div class="col-md-9">
										<p class="form-control-static">
											 Category1
										</p>
									</div>
								</div>
							</div>
							<!--/span-->
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">Membership:</label>
									<div class="col-md-9">
										<p class="form-control-static">
											 Free
										</p>
									</div>
								</div>
							</div>
							<!--/span-->
						</div>
						<!--/row-->
						<h3 class="form-section">Address</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">Address:</label>
									<div class="col-md-9">
										<p class="form-control-static">
											 <?php echo $values['address']; ?>
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">City:</label>
									<div class="col-md-9">
										<p class="form-control-static">
											 <?php echo $values['city']; ?>
										</p>
									</div>
								</div>
							</div>
							<!--/span-->
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">State:</label>
									<div class="col-md-9">
										<p class="form-control-static">
											 New York
										</p>
									</div>
								</div>
							</div>
							<!--/span-->
						</div>
						<!--/row-->
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">Contact No:</label>
									<div class="col-md-9">
										<p class="form-control-static">
											 <?php echo $values['contact']; ?>
										</p>
									</div>
								</div>
							</div>
							<!--/span-->
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">Country:</label>
									<div class="col-md-9">
										<p class="form-control-static">
											 <?php echo $values['country']; ?>
										</p>
									</div>
								</div>
							</div>
							<!--/span-->
						</div>
                        <?php endforeach; ?>
					</div>
					
				</form>
				<!-- END FORM-->
			</div>
		</div>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->