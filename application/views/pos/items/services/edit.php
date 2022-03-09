<div class="row">
    <div class="col-md-12">
        <div class="portlet">
        	<div class="portlet-title">
        		<div class="caption">
        			<i class="fa fa-reorder"></i>Update Service
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
                foreach($Item as $keys => $values):
                $attributes = array('class' => 'form-horizontal', 'role' => 'form','enctype'=>"multipart/form-data");
                echo form_open('pos/Items/editService',$attributes);
				echo  form_hidden('item_id',$values['item_id']);
				echo  form_hidden('id',$values['id']);
                echo  form_hidden('service',1);
                ?>
        			<div class="form-body">
        				<h3 class="form-section">Service Info</h3>
        				<!--/row-->
        				<div class="row">
        					<div class="col-md-6">
        						<div class="form-group">
        							<label class="control-label col-md-3">Category</label>
        							<div class="col-md-9">
        								<?php echo form_dropdown('category_id',$categoryDDL,$values['category_id'],'class="form-control select2me"'); ?>
        								<span class="help-block">
        								Select your Category. </span>
        							</div>
        						</div>
        					</div>
        					<!--/span-->
        					<div class="col-md-6">
        						<div class="form-group">
                                  <label class="control-label col-sm-3">Tax:</label>
                                  <div class="col-sm-9">
                                    <?php echo form_dropdown('tax_id',$taxesDDL,$values['tax_id'],'class="form-control select2me"'); ?>
                                  </div>
                                </div>
                            </div>
        					<!--/span-->
        				</div>
        				<!--/row-->
                        
                        <div class="row">
        					<div class="col-md-6">
        						<div class="form-group">
        							<label class="control-label col-md-3">Service Name</label>
        							<div class="col-md-9">
        								<input type="text" name="name" value="<?php echo $values['name'] ?>" class="form-control" placeholder="Service Name">
        							
        							</div>
        						</div>
        					</div>
        					<!--/span-->
        					<div class="col-md-6">
        						<div class="form-group">
        							<label class="control-label col-md-3">Unit</label>
        							<div class="col-md-9">
        								<?php echo form_dropdown('unit_id',$unitsDDL,$values['unit_id'],'class="form-control select2me"'); ?>
                                  
        							</div>
        						</div>
        					</div>
        					<!--/span-->
        				</div>
        				<!--/row-->
        				<div class="row">
        					
        					<div class="col-md-6">
        						<div class="form-group">
        							<label class="control-label col-md-3">Sale Price</label>
        							<div class="col-md-9">
        								<input type="number" name="unit_price" value="<?php echo $values['unit_price'] ?>"  step="0.01" class="form-control">
        							</div>
        						</div>
        					</div>
                            
                            <div class="col-md-6">
        						<div class="form-group">
        							<label class="control-label col-md-3">Description</label>
        							<div class="col-md-9">
        								<textarea class="form-control" name="description"><?php echo $values['description'] ?></textarea>
        							</div>
        						</div>
        					</div>
        					
        				</div>
                        <!--/row-->
        				
        			</div>
        			<div class="form-actions">
        				<div class="row">
        					<div class="col-md-6">
        						<div class="row">
        							<div class="col-md-offset-3 col-md-9">
        								<button type="submit" class="btn btn-success">Update</button>
        								<button type="button" onclick="window.history.back();" class="btn btn-default">Cancel</button>
        							</div>
        						</div>
        					</div>
        					<div class="col-md-6">
        					</div>
        				</div>
        			</div>
        		<?php endforeach;
                echo form_close();?>
        		<!-- END FORM-->
        	</div>
        </div>
    </div>
</div>