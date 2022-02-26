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
                    echo form_open('setting/users/C_users/editUser',$attributes);
                    foreach($users as $user):
                    echo form_hidden("id",$user['id']);
                    ?>
					<div class="form-body">
						<h3 class="form-section">User Information</h3>
                        
                        <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Role</label>
                                    <?php $data = array(''=>'Please Select','admin'=>'Admin','user'=>'User');
                                    
                                    echo form_dropdown('role',$data,$user['role'],'class="form-control"'); ?>
									
								</div>
							</div>
							<!--/span-->
                            
                        </div>
                        
                        <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Full Name</label>
									<input type="text" name="name" value="<?php echo $user['name'] ?>" class="form-control" />
								</div>
							</div>
							<!--/span-->
                            <div class="col-md-6">
								<div class="form-group">
									<label>Username</label>
									<input type="text" name="username" value="<?php echo $user['username'] ?>" required="" class="form-control" />
								</div>
							</div>
							<!--/span-->
                        </div>
                        
                        <h3 class="form-section">Module Permission</h3>
                        
                        <div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>All Modules</label>
									<div class="checkbox-list">
                                    <?php 
                                                                        
                                    foreach($activeModules as $j => $values): 
                                     $userModule = $this->M_modules->get_moduleByUserID($user['id'],$values['id']);
                                     //$userModule = $this->M_modules->get_activeModules();
                                     
                                     //var_dump($userModule);
                                      
                                    ?>
										<label>
										<div class="col-sm-12">
                                            <span>
                                            
                                            <input name="modules[]" value="<?php echo $values['id'] ?>" <?php echo (@$userModule[0]['module_id'] == $values['id'] ? 'checked=""' : '') ?>  type="checkbox">&nbsp;<?php echo $values['title'] ?>
                                                                                                                                    
                                            
                                            </span>
                                        </div>
                                        </label>
                                        
                                        <?php  $sub_modules = $this->M_modules->get_modulesByParent($values['id']); 
                                        //var_dump($sub_modules);
                                        $i = 0;
                                        foreach($sub_modules as $sub_module): 
                                        
                                            $user_subModule = $this->M_modules->get_sub_moduleByUserID($user['id'],$sub_module['id']);
                                            //var_dump($user_subModule);
                                        ?>
                                        <label>
                                        <div class="col-sm-offset-1 col-sm-4">
                                            <span>
                                            
                                            <input name="sub_module[<?php echo $j; ?>][<?php echo $i; ?>]" value="<?php echo $sub_module['id'] ?>" <?php echo (@$user_subModule[0]['sub_module'] == $sub_module['id'] ? 'checked=""' : '') ?>  type="checkbox">&nbsp;<?php echo $sub_module['title'] ?>
                                                                                                                                    
                                            
                                            </span>
                                        </div>
                                        <!--
                                        <div class="col-sm-7">    
                                            <span>
                                            <input name="can_create[<?php echo $j; ?>][<?php echo $i; ?>]" <?php echo (@$user_subModule[0]['can_create'] == 1 ? 'checked=""' : '') ?> value="1" type="checkbox" id="can_create[]">&nbsp;<label for="can_create">can create</label>
                                            </span>
                                            
                                            <span>
                                            <input name="can_update[<?php echo $j; ?>][<?php echo $i; ?>]" <?php echo (@$user_subModule[0]['can_update'] == 1 ? 'checked=""' : '') ?> value="1" type="checkbox" id="can_update[]">&nbsp;<label for="can_update">can update</label>
                                            </span>
                                            
                                            <span>
                                            <input name="can_delete[<?php echo $j; ?>][<?php echo $i; ?>]" <?php echo (@$user_subModule[0]['can_delete'] == 1 ? 'checked=""' : '') ?> value="1" type="checkbox" id="can_delete[]">&nbsp;<label for="can_delete">can delete</label>
                                            </span>
                                        </div>  
                                        -->
                                        </label>
									<?php $i++;
                                            endforeach; // end sub module loop
                                            
                                            
                                          endforeach; 
                                    ?>	
									</div>
								</div>
							</div>
							<!--/span-->
						</div>
						<!--/row-->
                        
					</div>
					<div class="form-actions right">
                        <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Update</button>                    
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