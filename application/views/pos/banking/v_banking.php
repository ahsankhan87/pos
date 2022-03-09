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
        <p><?php echo anchor('pos/C_banking/create', lang('add_new') . ' <i class="fa fa-plus"></i>', 'class="btn btn-success"'); ?></p>

        <?php
        if (count($banking)) {
        ?>
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

                    <table class="table table-striped table-condensed table-bordered flip-content" id="sample_customer">
                        <thead class="flip-content">
                            <tr>
                                <th><?php echo lang('bank') . ' ' . lang('name'); ?></th>
                                <th>A/C Holder Name</th>
                                <th>Bank Branch</th>
                                <th>Dr Bal</th>
                                <th>Cr Bal</th>
                                <th><?php echo lang('total') . ' ' . lang('balance'); ?></th>
                                <th><?php echo lang('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody class="flip-content">
                            <?php
                            $sno = 1;
                            foreach ($banking as $key => $list) {
                                $exchange_rate = ($list['exchange_rate'] == 0 ? 1 : $list['exchange_rate']);

                                echo '<tr valign="top">';
                                // echo '<td>'.$sno++.'</td>';
                                echo '<td><a href="' . site_url('pos/C_banking/bankDetail/' . $list['id']) . '">' . $list['bank_name'] . '</a></td>';
                                echo '<td>' . $list['acc_holder_name'] . '</td>';
                                //echo '<td>'.$list['bank_account_no'].'</td>';
                                echo '<td>' . $list['bank_branch'] . '</td>';
                                //echo '<td><a href="'.site_url('pos/C_banking/paymentModal/'. $list['id']).'" class="btn btn-warning btn-sm" >Receive Payment</a></td>';
                                // echo '<td><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#bank-payment-Modal">Receive Payment</button></td>';

                                //OPENING BALANCES
                                $op_balance_dr = round($list['op_balance_dr'] / $exchange_rate, 2);
                                $op_balance_cr = round($list['op_balance_cr'] / $exchange_rate, 2);
                                $op_balance = round(($op_balance_dr - $op_balance_cr) / $exchange_rate, 2);

                                //CURRENT BALANCES
                                $cur_balance = $this->M_banking->get_bank_total_balance($list['id'], FY_START_DATE, FY_END_DATE);
                                $balance_dr = round($cur_balance[0]['dr_balance'] / $exchange_rate, 2);
                                $balance_cr = round($cur_balance[0]['cr_balance'] / $exchange_rate, 2);

                                echo '<td>' . round($op_balance_dr + $balance_dr, 2) . '</td>';
                                echo '<td>' . round($op_balance_cr + $balance_cr, 2) . '</td>';
                                echo '<td>' . (($op_balance_dr + $balance_dr) - ($op_balance_cr + $balance_cr)) . '</td>';


                                echo '<td>';
                                //echo  anchor(site_url('up_bank_images/upload_images/'.$list['id']),' upload Images');
                                ?>
                                <?php echo anchor('pos/C_banking/edit/' . $list['id'], '<i class="fa fa-pencil-square-o fa-fw"></i> |', 'title="Edit"'); ?>
                                <a href="<?php echo site_url('pos/C_banking/inactivate/' . $list['id'] . '/' . $op_balance_dr . '/' . $op_balance_cr . '/' . $list['bank_acc_code']) ?>" title="Make Inactive" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash-o fa-fw"></i></a>
   
                           <?php 
                                 echo '</td>';
                                 echo '</tr>';
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th><th></th>
                                <th>Total</th><th></th><th></th>
                                <th></th><th></th>
                                
                            </tr>
                        </tfoot>
                    </table>
                      
                </div>
                <!-- /.portlet body -->
            </div>
            <!-- /.portlet -->
        <?php 
        }
        ?>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->