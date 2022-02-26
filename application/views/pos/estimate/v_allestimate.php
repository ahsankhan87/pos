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
            <?php echo anchor('trans/C_estimate/index/estimate', lang('add_new'), 'class="btn btn-success hidden-print"'); ?>
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

                <table class="table table-bordered table-striped table-condensed flip-content" id="sample_estimate">
                    <thead class="flip-content">
                        <tr>
                            <!-- <th>S.No</th> -->
                            <th>Inv #</th>
                            <th><?php echo lang('date'); ?></th>
                            <th><?php echo lang('customer'); ?></th>
                            <th class="text-right"><?php echo lang('amount'); ?></th>
                            <th class="hidden-print"><?php echo lang('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //$sno = 1;
                        //        foreach($estimate as $key => $list)
                        //        {
                        //            echo '<tr>';
                        //            //echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                        //            //echo '<td><a href="'.site_url('trans/C_estimate/receipt/'.$list['invoice_no']).'" class="hidden-print">'.$list['invoice_no'].'</a></td>';
                        //            echo '<td>'.$sno++.'</td>';
                        //            echo '<td>'.$list['invoice_no'].'</td>';
                        //            echo '<td>'.date('d-m-Y',strtotime($list['sale_date'])).'</td>';
                        //            $name = $this->M_customers->get_CustomerName($list['customer_id']);
                        //            echo '<td>'.@$name.'</td>';
                        //            echo '<td>'.@$this->M_employees->get_empName($list['employee_id']).'</td>';
                        //            
                        //            echo '<td>'. $this->M_estimate->get_totalCostBysaleID($list['invoice_no']). '</td>';
                        //            //echo  anchor(site_url('up_supplier_images/upload_images/'.$list['id']),' upload Images');
                        //         } 
                        //            
                        //            echo '</tbody>';
                        //echo '<tfoot>
                        //                    <tr>
                        //                        <th></th><th></th><th></th>
                        //                        <th></th><th></th>
                        //                        <th></th>
                        //                
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