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
            <?php echo anchor('pos/C_customers/create', lang('add_new') . ' <i class="fa fa-plus"></i>', 'class="btn btn-success"'); ?>
            <?php echo anchor('pos/C_customers/CustomerImport', 'Import Customers', 'class="btn btn-success"'); ?>
            <?php echo anchor('pos/C_customers/cheque_list', 'List of Cheques', 'class="btn btn-success"'); ?>

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

                <table class="table table-striped table-condensed flip-content" id="sample_2">
                    <thead>
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
                            <th><?php echo lang('employee'); ?></th>
                            <th><?php echo lang('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($customers as $values) {
                            echo '<tr>';
                            echo '<td>' . $values['id'] . '</td>';
                            echo '<td>' . $values['first_name'] . '</td>';
                            echo '<td>' . $values['store_name'] . '</td>';
                            echo '<td>' . $values['address'] . '</td>';
                            echo '<td>' . $values['city'] . '</td>';
                            echo '<td>' . $values['mobile_no'] . '</td>';
                            echo '<td>' . $this->M_employees->get_empName($values['emp_id']) . '</td>';

                            echo '<td>';
                        ?>
                            <?php echo anchor('pos/C_customers/edit/' . $values['id'], '<i class="fa fa-pencil-square-o fa-fw"></i>', 'title="Edit"'); ?> |
                            <a href="<?php echo site_url('pos/C_customers/delete/' . $values['id']) ?>" onclick="return confirm('Are you sure you want to permanent delete supplier and his account transactions?')" title="Permanent Delete"><i class="fa fa-trash-o fa-fw"></i></a>

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