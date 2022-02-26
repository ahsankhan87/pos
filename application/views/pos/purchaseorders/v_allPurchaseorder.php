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

            <!-- /btn-group -->
            <?php echo anchor('trans/C_purchaseOrders/', lang('add') . ' ' . lang('purchase') . ' ' . lang('order'), 'class="hidden-print btn btn-success"'); ?>
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

                <table class="table table-striped table-bordered table-condensed flip-content" id="sample_purchaseorders">
                    <thead class="flip-content">
                        <tr>
                            <!-- <th>S.No</th> -->
                            <th>Inv #</th>
                            <th><?php echo lang('date'); ?></th>
                            <th><?php echo lang('supplier') . ' ' . lang('name'); ?></th>
                            <th class="text-right"><?php echo lang('amount'); ?></th>

                            <th class="hidden-print"><?php echo lang('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //$sno = 1;
                        //        foreach($purchaseorders as $key => $list)
                        //        {
                        //            echo '<tr>';
                        //            //echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                        //            //echo '<td><a href="'.site_url('trans/C_purchaseorders/receipt/'.$list['invoice_no']).'">'.$list['invoice_no'].'</a></td>';
                        //            echo '<td>'.$sno++.'</td>';
                        //            echo '<td>'.$list['invoice_no'].'</td>';
                        //            echo '<td>'.date('d-m-Y',strtotime($list['purchaseorder_date'])).'</td>';
                        //            //echo '<td><img src="'.base_url('images/supplier-images/thumbs/'.$list['supplier_image']).'" width="40" height="40"/></td>';
                        //            $supplier_name = $this->M_suppliers->get_supplierName($list['supplier_id']);
                        //            echo '<td>'.@$supplier_name.'</td>';
                        //            //echo '<td>'.$list['supplier_invoice_no'].'</td>';
                        //            echo '<td>'.@$this->M_employees->get_empName($list['employee_id']).'</td>';
                        //            echo '<td>'. $this->M_purchaseorders->get_totalCostBypurchaseorderID($list['invoice_no']). '</td>';
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