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
        <?php echo anchor('trans/C_recurring_invoices/index/credit', 'Schedule a recurring invoice', 'class="btn btn-primary"'); ?>

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

                <table class="table table-striped table-bordered table-condensed flip-content" id="sample_1">
                    <thead class="flip-content">
                        <tr>
                            <th>S.No</th>
                            <th>Inv #</th>
                            <th><?php echo lang('date') ?></th>
                            <th><?php echo lang('customer') ?></th>
                            <th class="text-right"><?php echo lang('amount') ?></th>
                            <th>Start Date</th>
                            <th>Next Shipment</th>
                            <th>Recurrence</th>
                            <!-- <th class="hidden-print"><?php echo lang('action') ?></th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sno = 1;
                               foreach($sales as $key => $list)
                               {
                                   echo '<tr>';
                                   //echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                                   //echo '<td><a href="'.site_url('trans/C_sales/receipt/'.$list['invoice_no']).'" class="hidden-print">'.$list['invoice_no'].'</a></td>';
                                   echo '<td>'.$sno++.'</td>';
                                   echo '<td>'.$list['invoice_no'].'</td>';
                                   echo '<td>'.date('d-m-Y',strtotime($list['sale_date'])).'</td>';
                                   $name = $this->M_customers->get_CustomerName($list['customer_id']);
                                   echo '<td>'.@$name.'</td>';
                                   echo '<td class="text-right">'.number_format($list['total_amount']+$list['total_tax']-$list['discount_value'],2).'</td>';
                                   
                                   echo '<td>'.date('d-m-Y',strtotime($list['period_start_date'])).'</td>';
                                   echo '<td>'.$list['next_shipment'].'</td>';
                                   echo '<td>'.$list['send_every_day'].' '.strtoupper($list['send_every_month']).'</td>';
                                   
                                   //echo  anchor(site_url('up_supplier_images/upload_images/'.$list['id']),' upload Images');
                                   echo '</tr>';
                                
                                } 
                                
                        ?>           
                    </tbody>
                    
                </table>
            </div>
        </div>

    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->