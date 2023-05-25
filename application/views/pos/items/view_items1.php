<div class="row">
    <div class="col-sm-12">

        <?php
        if ($this->session->flashdata('message')) {
            echo "<div class='alert alert-success fade in'>";
            echo $this->session->flashdata('message');
            echo '</div>';
        }
        if ($this->session->flashdata('error')) {
            echo "<div class='alert alert-danger fade in'>";
            echo $this->session->flashdata('message');
            echo '</div>';
        }
        ?>
        <div class="row">
            <div class="col-sm-12">

                <!-- /btn-group -->
                <?php //echo anchor('pos/C_items_import','Import Products','class="btn btn-success"'); 
                ?>

                <?php echo anchor('pos/Items/create', lang('add_new').' '.lang('product'),'class="btn btn-success"'); ?>
                <?php echo anchor('pos/Items/createService',  lang('add_new').' '.lang('service'),'class="btn btn-success"'); ?>
                <!-- /btn-group -->
                <?php echo anchor('pos/Items/lowStock', 'Low Stock', 'class="btn btn-warning"'); ?>
                <?php echo anchor('pos/Items/barcode', 'Barcodes', 'class="btn btn-info"'); ?>

                <!-- Trigger the modal with a button 
                 <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#create-Product-Modal">Add New Product</button>
                -->
            </div>
            <!-- /.col-sm-12 -->
        </div>
        <!-- /.row -->
        <br>
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i><span id="print_title"><?php echo $main; ?></span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>
            <div class="portlet-body flip-scroll">


                <table class="table table-striped table-condensed table-bordered table-hover flip-content" id="getAllProducts">
                    <thead class="flip-content">
                        <tr>
                            <th>ID</th>
                            <th><?php echo lang('name'); ?></th>
                            <th><?php echo lang('unit'); ?></th>
                            <th><?php echo lang('type'); ?></th>
                            <th class="text-right">Qty</th>
                            <th class="text-right"><?php echo lang('cost') . ' ' . lang('price'); ?>(avg)</th>
                            <th class="text-right"><?php echo lang('unit') . ' ' . lang('price'); ?></th>
                            <th></th>

                        </tr>
                    </thead>


                </table>



            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->