   
            <?php 
            if(count((array)@$customerLastSales_report))
            {
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="page-header lead">
                    <span id="print_title">
                        Customers who did not sale last 30 days
                    </span>
                    </h2>
                </div>
                <!-- /.col-sm-12 -->
            </div>
            
            <div class="row">
                <div class="col-sm-12">
                
                    <table class="table table-striped table-condensed table-hover flip-content" id="sales_summary">
                        <thead class="flip-content">
                            <tr>
                                <th>Serial No</th>
                                <th><?php echo lang('customers') ?></th>
                                <th><?php echo lang('address') ?></th>
                                <th><?php echo lang('city') ?></th>
                                <th>Mobile No</th>
                                
                            </tr>
                        </thead>
                        
                        <tbody>
                    <?php
                     $total =0;
                     $sno = 1;
                    foreach($customerLastSales_report as $key => $list)
                    {
                        // echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                        echo '<td>'.$sno++.'</td>';
                       // $size_name = $this->M_sizes->get_sizeName($list['item_id']);
                        echo '<td>'.$list['first_name'].'</td>';
                        echo '<td>'.$list['address'].'</td>';
                        echo '<td>'.$list['city'].'</td>';
                        echo '<td>'.$list['mobile_no'].'</td>';
                        
                        //$total += $list['qty'];
                        
                        
                       // echo  anchor(site_url('up_property_images/upload_images/'.$list['id']),' upload Images'). '</td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                    
                    
                    </table>
                    
                </div>
                <hr />
            </div>
            
            <?php } ?>
