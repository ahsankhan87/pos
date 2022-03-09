<p>
    <?php echo anchor('accounts/C_entries/create', lang('add_new') . ' <i class="fa fa-plus"></i>', 'class="btn btn-success"'); ?>&nbsp;
    <?php echo anchor('accounts/C_entries/allEntries', lang('view_all'), 'class="btn btn-primary"'); ?>
</p>
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
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i><span id="print_title"><?php echo trim($main); ?></span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>
            <div class="portlet-body flip-scroll">
                <div class="col-sm-4">
                    <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control cur_date" />
                </div>
                </br>
                <table class="table table-striped table-condensed table-bordered flip-content" id="">
                    <thead class="flip-content">
                        <tr>
                            <th><?php echo lang('date'); ?></th>
                            <th><?php echo lang('entry'); ?> #</th>
                            <th><?php echo lang('invoice'); ?></th>
                            <!-- <th><?php echo lang('acc_code'); ?></th> -->
                            <th><?php echo lang('account'); ?></th>
                            <th class="text-right"><?php echo lang('debit'); ?></th>
                            <th class="text-right"><?php echo lang('credit'); ?></th>
                            <th width="20%"><?php echo lang('description'); ?></th>
                            <th><?php echo lang('action'); ?></th>
                        </tr>
                    </thead>

                    <tbody id="daybook_data">
                    </tbody>
                    <tfoot id="total_balance">
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
<script>
    $(document).ready(function() {

        const site_url = '<?php echo site_url($langs); ?>';
        const path = '<?php echo base_url(); ?>';

        loadDaybook($('.cur_date').val());
        $('.cur_date').on('change', function() {

            loadDaybook($(this).val());
        });

        function loadDaybook(cur_date = '') {

            let view_journal = '';
            let debit = 0;
            let credit = 0;
            let total_balance = '';
            $.ajax({
                url: site_url + "/accounts/C_entries/get_entries_date/" + cur_date,
                type: 'POST',
                data: {
                    'cur_date': cur_date
                },
                dataType: 'json', // added data type
                success: function(data) {
                    console.log(data);
                    let i = 0;
                    var invoice_no = '';
                    var inv_prefix = '';
                    $.each(data, function(index, value) {
                        view_journal += '<tr>' +
                            '<td>' + value.date + '</td>' +
                            '<td>' + value.entry_id + '</td>';

                        invoice_no = value.invoice_no;
                        inv_prefix = invoice_no.substring(0, 1);
                        console.log(inv_prefix);
                        if (inv_prefix.toUpperCase() === 'S') {
                            view_journal += '<td><a href="' + site_url + '/trans/C_sales/receipt/' + invoice_no + '" title="Print Invoice" target="_blank" >' + invoice_no + '</a></td>';
                        } else if (inv_prefix.toUpperCase() === 'R') {
                            view_journal += '<td><a href="' + site_url + '/trans/C_receivings/receipt/' + invoice_no + '" title="Print Invoice" target="_blank" >' + invoice_no + '</a></td>';
                        } else if (inv_prefix.toUpperCase() === 'J') {
                            view_journal += '<td><a href="' + site_url + '/accounts/C_entries/receipt/' + invoice_no + '" title="Print Invoice" target="_blank" >' + invoice_no + '</a></td>';

                        } else {
                            view_journal += '<td>' + invoice_no + '</td>';
                        }

                        view_journal += '<td><a href="' + site_url + '/accounts/C_groups/accountDetail/' + value.account_code + '" title="Account Detail" target="_blank" >' + value.title + '</a>';
                          
                                if (value.is_cust == 1 && value.ref_account_id != 0) {
                                    view_journal += ' <small><a href="' + site_url + '/pos/C_customers/customerDetail/' + value.ref_account_id+ '">(' + value.customer_store_name + ')</a></small>';
                                }
                                if (value.is_supp == 1 && value.ref_account_id != 0) {
                                    view_journal += ' <small><a href="'+ site_url + '/pos/Suppliers/supplierDetail/' + value.ref_account_id + '">(' + value.supplier_name + ')</a></small>';
                                }
                                if (value.is_bank == 1 && value.ref_account_id != 0) {
                                    view_journal += ' <small><a href="'+ site_url + '/pos/C_banking/bankDetail/' + value.ref_account_id + '">(' + value.bank_name + ')</a></small>';
                                }

                        view_journal +=    '</td><td style="text-align: right;">' + (value.debit == '0' ? '' : parseFloat(value.debit).toFixed(2)) + '</td>' +
                            '<td style="text-align: right;">' + (value.credit == '0' ? '' : parseFloat(value.credit).toFixed(2)) + '</td>' +
                            '<td>' + value.narration + '</td>';


                        view_journal += '<td><a href="' + site_url + '/accounts/C_entries/edit/' + invoice_no+ '" title="Edit"><i class="fa fa-pencil fa-fw"></i></a> |';
                        view_journal += '<a href="' + site_url + '/accounts/C_entries/delete/' + value.id + '/' + value.entry_id + '" title="Delete" onclick="return confirm(\'Are you sure you want to permanent delete? All entries associated with this entry will be deleted.\')"><i class="fa fa-trash-o fa-fw"></i></a></td>';
                        view_journal += '</tr>';
                        credit += parseFloat(value.debit);
                        debit += parseFloat(value.credit);
                    });
                    total_balance = '<tr><th></th><th></th><th></th>' +
                        '<th>Total</th>' +
                        '<th style="text-align: right;">' + Math.abs(debit).toFixed(2) + '</th>' +
                        '<th style="text-align: right;">' + Math.abs(credit).toFixed(2) + '</th>' +
                        '<th></th><th></th>' +
                        '</tr>';

                    $('#daybook_data').html(view_journal);
                    $('#total_balance').html(total_balance);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
            //   ///////////////////
        }
    });
</script>