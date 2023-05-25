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

        <p><?php echo anchor('trans/C_receipts', lang('add_new').' '.lang('receipt'), 'class="btn btn-primary"'); ?></p>

        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i><?php echo $main; ?>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>
            <div class="portlet-body flip-scroll">

                <table class="table table-bordered table-striped table-condensed flip-content" id="sample_1">
                    <thead class="flip-content">
                        <tr>
                            <!-- <th>S.No</th> -->
                            <th>id</th>
                            <th><?php echo lang('date'); ?></th>
                            <th><?php echo lang('invoice'); ?> #</th>
                            <!-- <th><?php echo lang('supplier'); ?> Inv #</th> -->
                            <th><?php echo lang('account'); ?></th>
                            <th class="text-right"><?php echo lang('amount'); ?></th>
                            <!-- <th class="text-right"><?php echo lang('taxes'); ?></th> -->
                            <!-- <th class="text-right"><?php echo lang('grand') . ' ' . lang('total'); ?></th> -->
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($receipts) {
                        ?>
                            <?php
                            foreach ($receipts as $key => $list) {
                                echo '<tr>';
                                echo '<td>' . $list['id'] . '</td>';
                                echo '<td>' . date('d-m-Y', strtotime($list['payment_date'])) . '</td>';
                                // echo '<td><a href="'.site_url('trans/C_receipts/receipt/'.$list['invoice_no']).'">'.$list['invoice_no'].'</a></td>';
                                echo '<td>' . $list['invoice_no'] . '</td>';
                                echo '<td>' . $list['title'] . '</td>';
                                echo '<td class="text-right">' . number_format($list['amount'], 2) . '</td>';
                                // $emp_name = $this->M_users->get_activeUsers($list['employee_id']);
                                // echo '<td>' . @$emp_name[0]['username'] . '</td>';
                                //echo  anchor(site_url('up_supplier_images/upload_images/'.$list['id']),' upload Images');
                            ?>
                                <td>
                                    <?php //echo '<a href="' . site_url('trans/C_receipts/receipt/' . $list['invoice_no']) . '"><i class="fa fa-print fa-fw"></i></a> |';  ?>
                                    <a href="<?php echo site_url('trans/C_receipts/delete/' . $list['invoice_no']) ?>" onclick="return confirm('Are you sure you want to delete? All entries will be deleted')"><i class="fa fa-trash-o fa-fw"></i></a>

                                </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->