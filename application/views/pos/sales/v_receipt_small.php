<div class="row hidden-print">
    <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
        <!-- <a href="<?php echo site_url('trans/C_sales') ?>" class="btn btn-primary"><i class="fa fa-arrow-left fa-fw"></i>Sales</a>
        <a href="javascript:window.print()" class="btn btn-info"><i class="fa fa-print fa-fw"></i>Print</a>
         -->
    </div>
    <button class="hidden-print"><a href="<?php echo site_url('trans/C_sales/editSales/' . $invoice_no) ?>" title="edit">Edit</a></button>
    <button class="hidden-print"><a href="#" onclick="window.print()" title="print">Print</a></button>
    <button class="hidden-print"><a href="<?php echo site_url('trans/C_sales/allSales') ?>">Sales</a></button>

</div>
<script>
    //auto load print screen when page load
    window.onload = function() {
        window.print();
    }

    window.onafterprint = function(e) {
        //window.location = '<?php echo site_url('trans/C_sales/index/cash') ?>';
    };
</script>
<style>
    @media print {
        body {
            margin-top: 0px;

        }

        #invoice-POS {
            width: 60mm;
        }

        #invoice-POS table {
            width: 100%;
            border-collapse: collapse;
            padding: 0px;
            margin: 0;

        }

        #invoice-POS th {
            font-size: 12px;
            padding: 2px;

            margin: 0;
        }

        #invoice-POS td {
            font-size: 12px;
            padding: 2px;
            margin: 0;
        }

        .col-xs-6 .col-sm-6 {
            width: 0% !important;

        }
    }
</style>
<section id="invoice-POS">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3  text-center">

            <div class="lead text-capitalize" style="margin: 0;font-weight: bold;"><?php echo $Company[0]['name']; ?></div>

            <span class="lead text-capitalize" style="font-weight: bold;"><?php echo $Company[0]['address']; ?></span><br />
            <span class=""><?php echo $Company[0]['contact_no']; ?></span>

            <?php

            if (count($sales_items)) {
            ?>
                <div class="lead text-uppercase"><?php echo ($sales_items[0]['register_mode'] == 'sale' ? '' : 'return'); ?> sale invoice</div>

                <div class="row" style="font-weight: 900;">
                    <div class="col-sm-6 col-xs-6">
                        <div class="text-left m0" style="margin: 0;">
                            <?php echo 'Inv #'; ?>:
                            <?php echo date('ymd', strtotime($sales_items[0]['sale_date'])) . '-' . $invoice_no; ?><br>

                            <?php echo lang('name'); ?>:
                            <?php echo @$this->M_customers->get_CustomerName($sales_items[0]['customer_id']); ?>

                        </div>

                    </div>
                    <div class="col-sm-6 col-xs-6" style="margin: 0;">
                        <div class="text-right">
                            <?php echo lang('user'); ?>:
                            <?php echo @$this->M_users->get_activeUsers($sales_items[0]['user_id'])[0]['name']; ?><br />

                            <?php echo lang('date'); ?>:
                            <?php echo date('d-m-Y g:ia', strtotime($sales_items[0]['sale_time'])); ?>

                        </div>

                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="text-left">
                            <?php echo 'Pkd by'; ?>:

                            <?php echo @$this->M_employees->get_empName($sales_items[0]['employee_id']); ?>

                        </div>

                    </div>
                </div>

                <table class="table table-striped table-hover table-condensed">

                    <thead>
                        <tr>
                            <th><?php echo lang('product'); ?></th>
                            <th><?php echo lang('quantity'); ?></th>
                            <!--<th>Unit</th>-->
                            <th class="text-right"><?php echo lang('price'); ?></th>

                        </tr>
                    </thead>
                    <tbody style="font-weight: bold;">
                        <?php
                        $counter = 0;
                        $total = 0;
                        $discount = 0;
                        $discount_total = 0;
                        $total_tax_amount = 0;

                        foreach ($sales_items as $key => $list) {
                            $counter++;
                            $discount_total += $list['discount_value'];
                            $total_cost = ($list['item_unit_price'] * $list['quantity_sold']);
                            $tax_amount = $total_cost * $list['tax_rate'] / 100;
                            $total_tax_amount += $tax_amount;
                            //$discount = ($list['item_unit_price']*$list['quantity_sold'])*$list['discount_percent']/100;

                            echo '<tr>';
                            //echo '<td>'.form_checkbox('p_id[]',$list['id'],false).'</td>';
                            echo '<td>' . $this->M_items->get_ItemName($list['item_id']) . ' ' . $this->M_sizes->get_sizeName($list['size_id']) . '</td>';
                            echo '<td>' . round($list['quantity_sold'], 2) . ' ' . $this->M_units->get_unitName($list['unit_id']) . '</td>';
                            //echo '<td>'.$list['unit'].'</td>';
                            echo '<td class="text-right">' . round($list['item_unit_price'], 2) . '</td>';
                            // echo '<td>'.$total_cost.'</td>';
                            echo '</tr>';

                            $total += ($list['item_unit_price'] * $list['quantity_sold']);
                            //$discount_total += (($list['item_unit_price']*$list['quantity_sold'])*$list['discount_percent']/100);

                        }
                        echo '</tbody>';
                        echo '</table>';
                        ?>

                        <table class="table" style="font-weight: bold;">
                            <tr>
                                <td class="text-small">
                                    <?php echo lang('products'); ?>: <?php echo $counter; ?>

                                </td>
                                <td class="text-<?php echo ($langs == "ar" || $langs == 'ur' ? 'left' : 'right') ?>">
                                    <?php echo lang('sub_total'); ?>&nbsp;:<br>
                                    <span><?php echo lang('disc'); ?>&nbsp;:<br>
                                        <span><?php echo lang('taxes'); ?>&nbsp;:<br>
                                            <span><?php echo lang('total'); ?>&nbsp;:
                                </td>
                                <td class="text-<?php echo ($langs == "ar" || $langs == 'ur' ? 'right' : 'left') ?>">
                                    &nbsp;<?php echo $total; ?><br>
                                    &nbsp;<?php echo round($discount_total, 2); ?></span><br>
                                    &nbsp;<?php echo round($total_tax_amount, 2); ?></span><br>
                                    &nbsp;<?php echo round(($total - $discount_total + $total_tax_amount) - $sales_items[0]['amount_due'], 2); ?></span><br>

                                </td>
                            </tr>

                        </table>

                        <div class="row">
                            <div class="col-sm-12">
                                <span><?php echo $sales_items[0]['description']; ?></span>
                            </div>
                        </div>

                    <?php
                }
                    ?>
                    <div>
                        <?php


                        //Qrcode for SEPA Payment Euruopean Uninion 
                        $service_tag = "BCD";
                        $character_set = "1"; //1=UTF-8, 2=ISO 8859-1, 3=ISO 8859-2, 4=ISO 8859-4, 5=ISO 8859-5, 6=ISO 8859-7, 7=ISO 8859-10, 8=ISO 8859-15
                        $identification = "SCT"; //SEPA credit transfer
                        $version = "002"; //V1: 001  V2: 002
                        $BIC = "BPOTBEB1"; //BIC of the Beneficiary Bank
                        $beneficiary_name = $Company[0]['name']; //Name of the Beneficiary.
                        $beneficiary_IBAN = $Company[0]['tax_no']; //Account number of the Beneficiary Only IBAN is allowed
                        $amount = $_SESSION['home_currency_code'] . (float)round(($total - $discount_total + $total_tax_amount) - $sales_items[0]['amount_due'], 2); //Amount of the Credit Transfer in Euro Amount must be 0.01 or more and 999999999.99 or less
                        $payment_reference = $invoice_no; //Ppayment_reference / INvoice No.
                        $creditor_reference = ""; //Remittance Information (Structured) Creditor Reference (ISO 11649 RF Creditor Reference may be used).

                        $data = $this->M_sales->generate_sepa_qrcode($service_tag, $version, $character_set, $identification, $BIC, $beneficiary_name, $beneficiary_IBAN, $amount, $payment_reference, $creditor_reference);
                        /////

                        //QRcode for ZATCA Saudi Arabia
                        $seller_name = $Company[0]['name'];
                        $vat_registration_number = $Company[0]['tax_no'];
                        $invoice_datetimez = $sales_items[0]['sale_time'];
                        $invoice_amount = round(($total - $discount_total + $total_tax_amount) - $sales_items[0]['amount_due'], 2);
                        $invoice_tax_amount = round($total_tax_amount, 2);

                        //$data = $this->M_sales->zatca_base64_tlv_encode_qrcode($seller_name, $vat_registration_number, $invoice_datetimez, $invoice_amount, $invoice_tax_amount);
                        /////

                        $params['data'] = $data;
                        $params['level'] = 'H';
                        $params['size'] = 3;
                        $params['savename'] = FCPATH . 'tes.png';
                        $this->ciqrcode->generate($params);

                        echo '<img src="' . base_url() . 'tes.png" />';
                        ?>
                        <!-- <?php echo $qr_code; ?> -->
                    </div>
                    <div style="font-weight: bold;"><?php echo lang('thanks_for_purchasing'); ?></div>
                    <div style="font-weight: bold;">Developed by: <i>khybersoft.com</i></div>
                    <!-- <div>*item once purchased will not return/changed.</div>
        <div>*Double check your items afterwards the shop will not responsible.</div> -->
        </div>
    </div>
</section>