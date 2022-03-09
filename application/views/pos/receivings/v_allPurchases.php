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
        <div class="btn-group">
            <button type="button" class="btn btn-success"><?php echo lang('new') . ' ' . lang('transaction') ?></button>
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <?php echo anchor('trans/C_receivings/index/cash', lang('cash') . ' ' . lang('purchases'), 'class="hidden-print"'); ?>
                </li>
                <li>
                    <?php echo anchor('trans/C_receivings/index/credit', lang('credit') . ' ' . lang('purchases'), 'class="hidden-print"'); ?>
                </li>
                <li>
                    <?php echo anchor('trans/C_receivings/index/cashReturn', lang('cash') . ' ' . lang('purchases') . ' ' . lang('return'), 'class="hidden-print"'); ?>
                </li>
                <li>
                    <?php echo anchor('trans/C_receivings/index/creditReturn', lang('credit') . ' ' . lang('purchases') . ' ' . lang('return'), 'class="hidden-print"'); ?>
                </li>
            </ul>
        </div>
        <!-- /btn-group -->

        </p>


        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i><span id="print_title"><?php echo $title; ?></span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>
            <div class="portlet-body flip-scroll">

                <table class="table table-striped table-bordered table-condensed flip-content" id="sample_receivings">
                    <thead class="flip-content">
                        <tr>
                            <!-- <th>S.No</th> -->
                            <th>Inv #</th>
                            <th><?php echo lang('date'); ?></th>
                            <th><?php echo lang('supplier'); ?> Inv #</th>
                            <th><?php echo lang('supplier'); ?></th>
                            <th><?php echo lang('account'); ?></th>
                            <th class="text-right"><?php echo lang('amount'); ?></th>
                            <th class="text-right"><?php echo lang('taxes'); ?></th>
                            <th class="text-right"><?php echo lang('grand') . ' ' . lang('total'); ?></th>
                            <th class="hidden-print"><?php echo lang('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //$sno = 1;
                        //        foreach($receivings as $key => $list)
                        //        {
                        //            echo '<tr>';
                        //            //echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                        //            //echo '<td><a href="'.site_url('trans/C_receivings/receipt/'.$list['invoice_no']).'">'.$list['invoice_no'].'</a></td>';
                        //            echo '<td>'.$sno++.'</td>';
                        //            echo '<td>'.$list['invoice_no'].'</td>';
                        //            echo '<td>'.date('d-m-Y',strtotime($list['receiving_date'])).'</td>';
                        //            //echo '<td><img src="'.base_url('images/supplier-images/thumbs/'.$list['supplier_image']).'" width="40" height="40"/></td>';
                        //            $supplier_name = $this->M_suppliers->get_supplierName($list['supplier_id']);
                        //            echo '<td>'.@$supplier_name.'</td>';
                        //            //echo '<td>'.$list['supplier_invoice_no'].'</td>';
                        //            echo '<td>'.@$this->M_employees->get_empName($list['employee_id']).'</td>';
                        //            echo '<td>'. $this->M_receivings->get_totalCostByReceivingID($list['invoice_no']). '</td>';
                        //            
                        //             } 
                        //            
                        //            echo '</tbody>';
                        //            echo '<tfoot>
                        //                    <tr>
                        //                        <th></th><th></th><th></th>
                        //                        <th></th><th>Total</th><th></th>
                        //                        <th></th>
                        //                    </tr>
                        //                </tfoot>';

                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->