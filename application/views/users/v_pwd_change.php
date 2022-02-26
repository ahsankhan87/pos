<div class="row">
    <div class="col-sm-12">
        <div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-reorder"></i>User Form
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
				<?php 
                    $attributes = array('class' => 'horizontal-form','enctype'=>"multipart/form-data");
                    echo validation_errors();
                    echo form_open('setting/users/C_users/change_password',$attributes);
                    foreach($users as $user):
                    echo form_hidden("id",$user['id']);
                    ?>
					<div class="form-body">
						<h3 class="form-section">User Password Change</h3>
                        
                        
                        <div class="row">
							
							<div class="col-md-6">
								<div class="form-group">
									<label>Password</label>
									<input type="password" name="password" class="form-control" value="<?php echo $user['password'] ?>"  required="" />
								</div>
							</div>
							<!--/span-->
                            <div class="col-md-6">
								<div class="form-group">
									<label>Confirm Password</label>
									<input type="password" name="confirm_password" value="<?php echo $user['password'] ?>" class="form-control" required="" />
								</div>
							</div>
							<!--/span-->
							
						</div>
						<!--/row-->
                        
                        
                        
					</div>
					<div class="form-actions right">
                        <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Confirm Change</button>                    
						<button type="button" onclick="window.history.back()" class="btn btn-default">Back</button>
						
					</div>
				<?php 
                endforeach;
                echo form_close(); ?>
				<!-- END FORM-->
			</div>
		</div>

    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->