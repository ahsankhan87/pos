<div class="row">
    <div class="col-sm-12">
      
       <?php
        if($this->session->flashdata('message'))
        {
            echo "<div class='alert alert-success fade in'>";
            echo $this->session->flashdata('message');
            echo '</div>';
        }
        if($this->session->flashdata('error'))
        {
            echo "<div class='alert alert-danger fade in'>";
            echo $this->session->flashdata('message');
            echo '</div>';
        }
        ?> 
        
        <?php 
        $attributes = array('class' => 'form-horizontal', 'role' => 'form','enctype'=>"multipart/form-data");
        ///echo validation_errors();
        echo form_open('pos/C_items_import/items_import',$attributes);
        ?>
        
        <div class="form-body">
    		
            <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                   <?php
                    echo '<label for="import" class="control-label col-md-6">Select Excel File (xls format)</label>';
                   ?>
                    <div class="col-md-6">
                        <input type="file" class="form-control" name="upload_items_import" />
                    </div>
                  </div>
                </div>
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
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
