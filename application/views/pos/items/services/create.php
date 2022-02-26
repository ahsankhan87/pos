<div class="row">
    <div class="col-md-12">
        <div class="portlet">
        	<div class="portlet-title">
        		<div class="caption">
        			<i class="fa fa-reorder"></i>New Service
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
                $attributes = array('class' => 'form-horizontal', 'role' => 'form','enctype'=>"multipart/form-data");
                echo form_open('pos/Items/createService',$attributes);
                echo validation_errors();
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
        								<?php echo form_dropdown('category_id',$categoryDDL,'','class="form-control  select2me" ng-model="category_id"  ng-init="category_id=0"'); ?>
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
									<?php echo form_dropdown('tax_id',$taxesDDL,set_value('tax_id'),'class="form-control select2me"'); ?>
								</div>
								</div>
							</div>
							<!--/span-->
                            
        				</div>
        				<!--/row-->
                        
                        <div class="row">
        					<div class="col-md-6">
        						<div class="form-group">
        							<label class="control-label col-md-3">Service Name<span class="required">* </span></label>
        							<div class="col-md-9">
        								<textarea name="name" class="form-control" placeholder="Service Name" required=""></textarea>
        							</div>
        						</div>
        					</div>
        					<!--/span-->
        					<div class="col-md-6">
        						<div class="form-group">
        							<label class="control-label col-md-3">Unit<span class="required">* </span></label>
        							<div class="col-md-9">
									<?php echo form_dropdown('unit_id',$unitsDDL,set_value('unit_id'),'class="form-control select2me"'); ?>
                                  
        							</div>
        						</div>
        					</div>
        					<!--/span-->
        				</div>
        				<!--/row-->
        				<div class="row">
        					
        					<div class="col-md-6">
        						<div class="form-group">
        							<label class="control-label col-md-3">Sale Price<span class="required">* </span></label>
        							<div class="col-md-9">
        								<input type="number" name="unit_price"  step="0.01" class="form-control" required>
        							</div>
        						</div>
        					</div>
                            
                            <div class="col-md-6">
        						<div class="form-group">
        							<label class="control-label col-md-3">Description</label>
        							<div class="col-md-9">
        								<textarea class="form-control" name="description"></textarea>
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
        								<button type="submit" class="btn btn-success">Submit</button>
        								<button type="button" onclick="window.history.back();" class="btn btn-default">Cancel</button>
        							</div>
        						</div>
        					</div>
        					<div class="col-md-6">
        					</div>
        				</div>
        			</div>
        		<?php echo form_close();?>
        		<!-- END FORM-->
        	</div>
        </div>
    </div>
</div>
