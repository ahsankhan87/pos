<!-- <div class="row"> -->
    <div class="col-sm-12">
        <?php
        if ($this->session->flashdata('message')) {
            echo "<div class='alert alert-success fade in'>";
            echo $this->session->flashdata('message');
            echo '</div>';
        }
        if ($this->session->flashdata('error')) {
            echo "<div class='alert alert-danger fade in'>";
            echo $this->session->flashdata('error');
            echo '</div>';
        }
        ?>
        <p>
            <?php echo anchor('pos/C_customers/create', lang('add_new') . ' <i class="fa fa-plus"></i>', 'class="btn btn-success"'); ?>
            <?php echo anchor('pos/C_customers/CustomerImport', 'Import Customers', 'class="btn btn-success"'); ?>
            <?php //echo anchor('pos/C_customers/cheque_list', 'List of Cheques', 'class="btn btn-success"'); ?>

        </p>

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

                <table class="table table-striped table-condensed table-bordered flip-content" id="getAllCustomer">
                    <thead class="flip-content">
                        <tr>
                            <th>Id</th>
                            <th><?php echo lang('name'); ?></th>
                            <th><?php echo lang('store'); ?></th>
                            <?php if (@$_SESSION['multi_currency'] == 1) {
                                echo '<th>Currency</th>';
                            }
                            ?>
                            <th><?php echo lang('address'); ?></th>
                            <th><?php echo lang('city'); ?></th>
                            <th><?php echo lang('contact'); ?></th>
                            <th><?php echo lang('action'); ?></th>
                        </tr>
                    </thead>

                </table>
            </div>
            <!-- /.portlet body -->
        </div>
        <!-- /.portlet -->
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->