<div class="row hidden-print">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Advance Search
                </div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                    <a href="" class="reload"></a>
                    <a href="" class="remove"></a>
                </div>
            </div>
            <div class="portlet-body">
                <form class="form-inline" method="post" action="<?php echo site_url('pos/C_customers/advance_search') ?>" role="form">
                    <div class="form-group">
                        <label for="city">City / Route</label>
                        <input type="text" class="form-control" name="city" placeholder="City / Route">
                    </div>

                    <button type="submit" class="btn btn-default">Search</button>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<!-- END PAGE CONTENT-->

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
            echo $this->session->flashdata('error');
            echo '</div>';
        }
        ?>
        <p>
            <?php echo anchor('pos/C_customers/create', 'Add New <i class="fa fa-plus"></i>', 'class="btn btn-success"'); ?>
            <?php echo anchor('pos/C_customers/CustomerImport', 'Import Customers', 'class="btn btn-success"'); ?>

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

                <table class="table table-striped table-condensed flip-content" id="sample_1">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Store</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>City/Route</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($customers as $values) {
                            echo '<tr>';
                            echo '<td>' . $values['id'] . '</td>';
                            echo '<td>' . $values['first_name'] . '</td>';
                            echo '<td>' . $values['store_name'] . '</td>';
                            echo '<td>' . $values['mobile_no'] . '</td>';
                            echo '<td>' . $values['address'] . '</td>';
                            echo '<td>' . $values['city'] . '</td>';
                            echo '<td>';
                            echo '<a href="' . site_url($langs) . '/trans/C_sales/index/cash/' . $values['id'] . '" class="btn btn-success btn-sm" target="_blank">Cash Sales</a>';

                            echo '</td>';
                            echo '<td>';
                            //echo  anchor(site_url('up_supplier_images/upload_images/'.$list['id']),' upload Images');

                        ?>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Action </button>
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
                                <ul class="dropdown-menu" role="menu">

                                    <li>
                                        <?php echo anchor('pos/C_customers/customerDetail/' . $values['id'], 'View Ledger'); ?>
                                    </li>
                                    <li>
                                        <?php echo anchor('pos/C_customers/edit/' . $values['id'], 'Edit'); ?>
                                    </li>
                                    <?php if ($this->session->userdata('role') == 'admin') { ?>
                                        <li>
                                            <?php echo anchor('pos/C_customers/delete/' . $values['id'], 'Delete', array('onclick' => "return confirm('Are you sure you want to permanent delete supplier and his account transactions?')")); ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>

                        <?php

                            echo '</td>';
                            echo '</tr>';
                        }

                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.col-sm-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->