<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suppliers extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','10240M');

        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : FY_START_DATE);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : FY_END_DATE);
        
        $from_date = date('d-m-Y',strtotime($data['from_date']));
        $to_date = date('d-m-Y',strtotime($data['to_date']));

        $data['title'] = lang('listof').' ' .lang('customers') .' ('.$from_date.' to '.$to_date.')';
        $data['main'] = lang('listof').' ' .lang('customers');
        $data['main_small']= ' ('.$from_date.' to '.$to_date.')';
        
        //$data['cities'] = $this->M_city->get_city();
        $data['suppliers']= $this->M_suppliers->get_activeSuppliers();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/suppliers/v_suppliers',$data);
        $this->load->view('templates/footer');
    }
    
    function supplierPayment($supplier_id)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('supplier').' ' .lang('payment');
        $data['main'] = lang('supplier').' ' .lang('payment');
        
        $data['activeBanks'] = $this->M_banking->getbankDropDown();
        //$data['creditSales'] = $this->M_sales->get_creditSales($supplier_id);
        $data['supplier'] = $this->M_suppliers->get_suppliers($supplier_id);
        //$data['supplier_entries']= $this->M_suppliers->get_supplier_Entries($supplier_id,FY_START_DATE,FY_END_DATE);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/suppliers/v_supplierPayment',$data);
        $this->load->view('templates/footer');
    }
    
    
    function getCreditPurchasesJSON($supplier_id)
    {
        $creditPurchases = $this->M_receivings->get_creditPurchases($supplier_id);
        echo json_encode($creditPurchases);
    }
    
    function get_suppliers_JSON($acc_code)
    {
        print_r(json_encode($this->M_suppliers->get_activeSuppliersByAccCode($acc_code)));
    }
    
    public function get_allSuppliers()
    {
        $data['suppliers']= $this->M_suppliers->get_suppliers();
        
        echo json_encode($data['suppliers']);
    }
    
    function makePayment()
    {
        $supplier_id = $this->input->post('supplier_id');
        $bank_id = $this->input->post('bank_id',true);
        $is_supplier = 1;
        //GET ALL ACCOUNT CODE WHICH IS TO BE POSTED AMOUNT
        $posting_type_code = $this->M_suppliers->getSupplierPostingTypes($supplier_id);
             
        if($supplier_id && $this->input->post('amount') && $posting_type_code)
        {
            $this->db->trans_start();
        
           //GET PREVIOISE INVOICE NO  
           @$prev_invoice_no = $this->M_suppliers->getMAXSupInvoiceNo('SP');
           $number = (int) substr($prev_invoice_no,2)+1; // EXTRACT THE LAST NO AND INCREMENT BY 1
           $new_invoice_no = 'SP'.$number;
           
           $date = $this->input->post('payment_date', true);
           $payment_type = $this->input->post('payment_type', true);
           $discount_amount = $this->input->post('discount_amount', true);
           $narration = ($this->input->post('narration',true) == '' ? '' : $this->input->post('narration',true));
           $exchange_rate = ($this->input->post('exchange_rate',true) == '' ? 1 : $this->input->post('exchange_rate',true)); //Current Exchange Rate //Current Exchange Rate
           
           $total_amount = $this->input->post('amount', true);
           
           //$prev_exchange_rate = $this->input->post('prev_exchange_rate',true); //array. Previouse
//           $credit_amount = $this->input->post('cr_amount', true);
//           $paid = $this->input->post('paid', true);
//           $invoice_no = $this->input->post('invoice_no', true);
           
           $current_ExRate_total = 0;
           $prev_ExRate_total = 0;
           $total_Not_ExRate = 0;
           //foreach($credit_amount as $i => $values):
//                
//                if(@$_SESSION['multi_currency'] == 1)
//                {
//                    $cr_amount = $values/$exchange_rate;
//                    //echo '<br />';
//                    $cr_amount_prev = $values/$prev_exchange_rate[$i];
//                    //echo '<br />';
//                    
//                    if($cr_amount < $cr_amount_prev)
//                    {
//                         $cr_amount1 = $cr_amount+(abs($cr_amount-$cr_amount_prev));
//                    }else{
//                        $cr_amount1 = $cr_amount;
//                    }
//                    
//                    $prev_ExRate_total += round($values/$prev_exchange_rate[$i],2);
//                    $current_ExRate_total += round($cr_amount,2);
//                
//                }else{
//                    $cr_amount1 = $values;
//                    $total_Not_ExRate += round($cr_amount1,2);//without exchange rate total amount
//                
//                }
//                 
//                //echo '<br />';
//                 $paid1 = round($paid[$i]+$cr_amount1,2);
//                //echo '<br />';
//                
//                $data = array(
//                'paid' => ((float)$paid1+(float)$discount_amount),
//                );
//        
//                $this->M_receivings->updatePaidAmount($invoice_no[$i],$data);
//                
//               //ADD PAYMENT HISTORY OF Supplier IN SEPARATE TABLE 
//               if(!empty($cr_amount1))
//               {
//                    $data1 = array(
//                    'supplier_id'=>$supplier_id,
//                    'invoice_no'=>$new_invoice_no,
//                    'receiving_invoice_no'=>$invoice_no[$i],
//                    'amount'=>((float)$cr_amount1+(float)$discount_amount),
//                    'company_id'=>$_SESSION['company_id']
//                    );
//                    $this->db->insert('pos_supplier_payment_history',$data1);
//                    
//               } 
//               ///
//               
//            endforeach;

            $current_ExRate_total = $total_amount/$exchange_rate;
           
            if(@$_SESSION['multi_currency'] == 1)
           {
                if($current_ExRate_total > $prev_ExRate_total)
                {
                    $forex_status = 'loss';
                    $forex_loss_amount = abs($current_ExRate_total-$prev_ExRate_total);
                    
                }elseif($current_ExRate_total < $prev_ExRate_total)
                {
                    $forex_status = 'gain';
                    $forex_gain_amount = abs($prev_ExRate_total-$current_ExRate_total);
                    
                }else//equal
                {
                    $forex_status = 'equal';
                }
                
                //$amount = $this->input->post('amount',true)/$exchange_rate; it will not use 
                
           }else
           {
                //$amount = $total_Not_ExRate; //total amount without ex rate
                $amount = $total_amount; //total amount excluding credit amount
           }
           /////
            
           if($payment_type == 'cash')
           {
                $payment_acc_code = $posting_type_code[0]['cash_acc_code'];
           }elseif($payment_type == 'bank'){
                $payment_acc_code = $posting_type_code[0]['bank_acc_code'];
           }
           
           //PAY CASH TO SUPPLIER AND REDUCE PAYABLES
           $cr_account = $payment_acc_code;//supplier ledger id
           $dr_account = $posting_type_code[0]['payable_acc_code'];//supplier ledger id
           $forex_gain_account = $posting_type_code[0]['forex_gain_acc_code'];//FOREX GAIN ACCOUNT
           $forex_loss_account = $posting_type_code[0]['forex_loss_acc_code'];//FOREX LOSS ACCOUNT
           
           
           if(@$_SESSION['multi_currency'] == 1)
           {
                if($forex_status == 'loss')
                {
                    //ACTUAL AMOUNT MINUS LOSS JOURNAL ENTRY
                   $amount = $current_ExRate_total;
                   $entry_id=$this->M_entries->addEntries($dr_account,$cr_account,$amount,$amount,$narration,$new_invoice_no,$date);
                   
                   //FOREX LOSS JOURNAL ENTRY
                   $entry_id_fx=$this->M_entries->addEntries($forex_loss_account,$dr_account,$forex_loss_amount,$forex_loss_amount,$narration,$new_invoice_no,$date);
                   
                   //POST IN cusmoter payment table
                   $this->M_suppliers->addsupplierPaymentEntry($dr_account,$cr_account,$amount,0,$supplier_id,$narration,$new_invoice_no,$date,$exchange_rate,$entry_id);
                   //FOREX LOSS ENTRY IN supplier 
                   $this->M_suppliers->addsupplierPaymentEntry($dr_account,$forex_loss_account,0,$forex_loss_amount,$supplier_id,$narration,$new_invoice_no,$date,$exchange_rate,$entry_id_fx);
                   ///
                }
                elseif($forex_status == 'gain')
                {
                    //ACTUAL AMOUNT MINUS LOSS JOURNAL ENTRY
                   $amount = $current_ExRate_total;
                   $entry_id=$this->M_entries->addEntries($dr_account,$cr_account,$amount,$amount,$narration,$new_invoice_no,$date);
                   
                   //FOREX LOSS JOURNAL ENTRY
                   $entry_id_fx=$this->M_entries->addEntries($dr_account,$forex_gain_account,$forex_gain_amount,$forex_gain_amount,$narration,$new_invoice_no,$date);
                   
                   //POST IN cusmoter payment table
                   $this->M_suppliers->addsupplierPaymentEntry($dr_account,$cr_account,$amount,0,$supplier_id,$narration,$new_invoice_no,$date,$exchange_rate,$entry_id);
                   //FOREX LOSS ENTRY IN supplier 
                   $this->M_suppliers->addsupplierPaymentEntry($dr_account,$forex_gain_account,$forex_gain_amount,0,$supplier_id,$narration,$new_invoice_no,$date,$exchange_rate,$entry_id_fx);
                   ///
                }
                elseif($forex_status == 'equal')
                {
                    //ACTUAL AMOUNT MINUS LOSS JOURNAL ENTRY
                   $amount = $current_ExRate_total;
                   $entry_id=$this->M_entries->addEntries($dr_account,$cr_account,$amount,$amount,$narration,$new_invoice_no,$date);
                   
                   //FOREX LOSS JOURNAL ENTRY
                   //$this->M_entries->addEntries($forex_gain_account,$cr_account,$forex_gain_amount,$forex_gain_amount,$narration,$new_invoice_no);
                   
                   //POST IN cusmoter payment table
                   $this->M_suppliers->addsupplierPaymentEntry($dr_account,$cr_account,$amount,0,$supplier_id,$narration,$new_invoice_no,$date,$exchange_rate,$entry_id);
                   //FOREX LOSS ENTRY IN supplier 
                  // $this->M_suppliers->addsupplierPaymentEntry($cr_account,$forex_loss_account,0,$forex_gain_amount,$supplier_id,$narration,$new_invoice_no,$date,$exchange_rate);
                   ///
                }
                    
               
           }else{
            
                $entry_id=$this->M_entries->addEntries($dr_account,$cr_account,$amount,$amount,$narration,$new_invoice_no,$date,null,$supplier_id,0,$is_supplier);
           
               //for cusmoter payment table
               $this->M_suppliers->addsupplierPaymentEntry($dr_account,$cr_account,$amount,0,$supplier_id,$narration,$new_invoice_no,$date,1,$entry_id);
               /// 
           }
           
           
           ///POST BANK ACCOUNT TABLE
           if($payment_type == 'bank'){
                $this->M_banking->addBankPaymentEntry($cr_account,$dr_account,0,$amount,$bank_id,$narration,$new_invoice_no,$date,$entry_id);
           
           }
           ////
           
           //IF DISCOUNT GIVEN
           $discount_amount = $this->input->post('discount_amount');
               
           if($discount_amount > 0)
           {
                if(@$_SESSION['multi_currency'] == 1)
                {
                
                   $cr_account = $posting_type_code[0]['purchasedis_acc_code'];//supplier ledger id
                   $dr_account = $posting_type_code[0]['payable_acc_code'];//supplier ledger id
                   $entry_id=$this->M_entries->addEntries($dr_account,$cr_account,$discount_amount/$exchange_rate,$discount_amount/$exchange_rate,$narration,$new_invoice_no,$date,null,$supplier_id,0,$is_supplier);
                   
                   //for cusmoter dicsount payment table
                   $this->M_suppliers->addsupplierPaymentEntry($dr_account,$cr_account,$discount_amount/$exchange_rate,0,$supplier_id,$narration,$new_invoice_no,$date,$exchange_rate,$entry_id);
                   ///  
                }
                else
                {
                   $cr_account = $posting_type_code[0]['purchasedis_acc_code'];//supplier ledger id
                   $dr_account = $posting_type_code[0]['payable_acc_code'];//supplier ledger id
                   $entry_id=$this->M_entries->addEntries($dr_account,$cr_account,$discount_amount,$discount_amount,$narration,$new_invoice_no,$date);
                   
                   //for cusmoter dicsount payment table
                   $this->M_suppliers->addsupplierPaymentEntry($dr_account,$cr_account,$discount_amount,0,$supplier_id,$narration,$new_invoice_no,$date,1,$entry_id);
                   ///
                }
               
           }
        
        $this->db->trans_complete();   
          
           $this->session->set_flashdata('message','Amount Paid Successfully');
           redirect('pos/Suppliers/supplierDetail/'.$supplier_id,'refresh');
        }
        else
        {
           $this->session->set_flashdata('error','Not Paid!. Please Enter Amount OR It seem that you did not assign posting account type to supplier');
           redirect('pos/Suppliers/supplierDetail/'.$supplier_id,'refresh');
        }
    }
    
    //function paymentModal($supplier_id)
//    {
//        $data = array('langs' => $this->session->userdata('lang'));
//        
//        $data['title'] = 'Manage Suppliers';
//        $data['main'] = 'Manage Suppliers';
//        
//        //GET ALL ACCOUNT CODE WHICH IS TO BE POSTED AMOUNT
//        $data['supplier']= $this->M_suppliers->get_suppliers($supplier_id);
//        $data['supplier_entries']= $this->M_suppliers->get_supplier_Entries($supplier_id,FY_START_DATE,FY_END_DATE);
//        
//        $this->load->view('templates/header',$data);
//        $this->load->view('pos/suppliers/paymentModal',$data);
//        $this->load->view('templates/footer');
//    }
    
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
        
            //form Validation
            $this->form_validation->set_rules('name', 'Full Name', 'required');
            if(@$_SESSION['multi_currency'] == 1){
            $this->form_validation->set_rules('currency_id', 'Currency', 'required');
            }
            $this->form_validation->set_rules('posting_type_id', 'Posting Type', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
                $this->db->trans_start();
                
                $data = array(
                'company_id'=> $_SESSION['company_id'],
                'sale_posting_type_id' => $this->input->post('sale_posting_type_id', true),
                'posting_type_id' => $this->input->post('posting_type_id', true),
                'name' => $this->input->post('name', true),
                'email' => $this->input->post('email', true),
                'address' => $this->input->post('address', true),
                'contact_no' => $this->input->post('contact_no',true),
                'status' => 'active',
                'currency_id' => $this->input->post('currency_id', true),
                'op_balance_dr' => $this->input->post('op_balance_dr', true),
                'op_balance_cr' => $this->input->post('op_balance_cr', true),
                "exchange_rate" => $this->input->post('exchange_rate', true),
                "acc_code" => $this->input->post('acc_code', true)
                );
                
                if($this->db->insert('pos_supplier', $data)) {
                    
                    $supplier_id = $this->db->insert_id();
                    $exchange_rate = ($this->input->post('exchange_rate', true) == 0 ? 1 : $this->input->post('exchange_rate', true));
                    
                    $op_balance_dr = (float)$this->input->post('op_balance_dr', true)/$exchange_rate;
                    $op_balance_cr = (float)$this->input->post('op_balance_cr', true)/$exchange_rate;
                    
                       $posting_type_code = $this->M_suppliers->getSupplierPostingTypes($supplier_id);
                       
                       //OPENING BALANCE IN supplier ACCOUNT
                       $payable_acc_code = $posting_type_code[0]['payable_acc_code'];//supplier ledger id
                       $payable_account = $this->M_groups->get_groups($payable_acc_code,$_SESSION['company_id']);
                       $payable_dr_balance = abs($payable_account[0]['op_balance_dr']);
                       $payable_cr_balance = abs($payable_account[0]['op_balance_cr']);
                       
                       $dr_balance = ($payable_dr_balance+$op_balance_dr);
                       $cr_balance = ($payable_cr_balance+$op_balance_cr);
                       
                       $this->M_groups->editGroupOPBalance($payable_acc_code,$dr_balance,$cr_balance);
                       
                       //for logging
                    $msg = $this->input->post('name');
                    $this->M_logs->add_log($msg,"Supplier","Added","POS");
                    // end logging
            
                    $this->session->set_flashdata('message','Supplier Created');
                }else{
                    $this->session->set_flashdata('error','Supplier not updated');
                }
                //$this->M_suppliers->addSupplier();
                
                $this->db->trans_complete();
                 
                redirect('pos/Suppliers/index','refresh');
            
            
            }
        }
        //else
        //{
            $data['title'] = lang('add_new').' ' .lang('supplier');
            $data['main'] = lang('add_new').' ' .lang('supplier');
            
            $data['salesPostingTypeDDL'] = $this->M_postingTypes->get_SalesPostingTypesDDL();
            $data['purchasePostingTypeDDL'] = $this->M_postingTypes->get_purchasePostingTypesDDL();
            $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);//search for legder account
            $data['currencyDropDown'] = $this->M_currencies->getcurrencyDropDown();
               
            $this->load->view('templates/header',$data);
            $this->load->view('pos/suppliers/create',$data);
            $this->load->view('templates/footer');
        //}
    
    }
    //edit category
    public function edit($id=NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
         {
        
            //form Validation
            $this->form_validation->set_rules('name', 'Full Name', 'required');
            if(@$_SESSION['multi_currency'] == 1){
                $this->form_validation->set_rules('currency_id', 'Currency', 'required');
            }
            $this->form_validation->set_rules('posting_type_id', 'Posting Type', 'required');
           //$this->form_validation->set_rules('address', 'Address', 'required');
            //$this->form_validation->set_rules('contact_no', 'Contact No', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
                $this->db->trans_start();
            
                $file_name = $this->upload->data();
                $data = array(
                'posting_type_id' => $this->input->post('posting_type_id', true),
                'sale_posting_type_id' => $this->input->post('sale_posting_type_id', true),
                'name' => $this->input->post('name', true),
                'email' => $this->input->post('email', true),
                'address' => $this->input->post('address', true),
                'contact_no' => $this->input->post('contact_no', true),
                'currency_id' => $this->input->post('currency_id', true),
                'op_balance_dr' => $this->input->post('op_balance_dr', true),
                'op_balance_cr' => $this->input->post('op_balance_cr', true),
                "exchange_rate" => $this->input->post('exchange_rate', true),
                "acc_code" => $this->input->post('acc_code', true),
                "also_customer" => $this->input->post('also_customer', true)
                );
                if($this->db->update('pos_supplier', $data, array('id'=>$this->input->post('id',true)))) {
                    
                    //$supplier_id = $this->input->post('id');
                    $exchange_rate = ($this->input->post('exchange_rate', true) == 0 ? 1 : $this->input->post('exchange_rate', true));
                    
                    $op_balance_dr = (float)$this->input->post('op_balance_dr', true)/$exchange_rate;
                    $op_balance_cr = (float)$this->input->post('op_balance_cr', true)/$exchange_rate;
                    
                    
                    $op_balance_dr_old = $this->input->post('op_balance_dr_old', true)/$exchange_rate;
                    
                    $op_balance_cr_old = $this->input->post('op_balance_cr_old', true)/$exchange_rate;
                    
                    
                    $posting_type_code =$this->M_postingTypes->get_purchasePostingTypes($this->input->post('posting_type_id',true));
                       
                     //OPENING BALANCE IN CUSTOMER ACCOUNT
                       $payable_acc_code = $posting_type_code[0]['payable_acc_code'];//supplier ledger id
                       
                       $payable_account = $this->M_groups->get_groups($payable_acc_code,$_SESSION['company_id']);
                       $payable_dr_balance = abs($payable_account[0]['op_balance_dr']);
                       
                       $payable_cr_balance = abs($payable_account[0]['op_balance_cr']);
                       
                       $dr_balance = $payable_dr_balance-$op_balance_dr_old;
                       $cr_balance = $payable_cr_balance-$op_balance_cr_old;
                       
                       $dr_balance = ($dr_balance+$op_balance_dr);
                       $cr_balance = ($cr_balance+$op_balance_cr);
                       
                       $this->M_groups->editGroupOPBalance($payable_acc_code,$dr_balance,$cr_balance);
                       
                    
                    //for logging
                    $msg = $this->input->post('name');
                    $this->M_logs->add_log($msg,"Supplier","Updated","POS");
                    // end logging
            
            
                    $this->session->set_flashdata('message','Supplier Updated');
                }else{
                    $this->session->set_flashdata('error','Supplier not updated');
                }
             
             $this->db->trans_complete();   
                
             redirect('pos/Suppliers/index','refresh');
            //////////////////////////////////
            
            }
        }
        else
        {
            $data['title'] = lang('update').' ' .lang('supplier');
            $data['main'] = lang('update').' ' .lang('supplier');
            
            $data['supplier'] = $this->M_suppliers->get_suppliers($id);
            $data['salesPostingTypeDDL'] = $this->M_postingTypes->get_SalesPostingTypesDDL();
            $data['purchasePostingTypeDDL'] = $this->M_postingTypes->get_purchasePostingTypesDDL();
            $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);//search for legder account
            $data['currencyDropDown'] = $this->M_currencies->getcurrencyDropDown();
            
            $this->load->view('templates/header',$data);
            $this->load->view('pos/suppliers/edit',$data);
            $this->load->view('templates/footer');
        }
    }
    
    function supplierDetail($supplier_id)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Supplier Detail';
        $data['main'] = 'Supplier Detail';
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : FY_START_DATE);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : FY_END_DATE);
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        $data['activeBanks'] = $this->M_banking->getbankDropDown();
        $data['supplier'] = $this->M_suppliers->get_suppliers($supplier_id);
        $data['supplier_entries']= $this->M_suppliers->get_supplier_Entries($supplier_id,$data['from_date'],$data['to_date']);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/suppliers/v_supplierDetail',$data);
        $this->load->view('templates/footer');
    }
    
    function emailSupplierLedger($supplier_id,$from_date,$to_date)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $supplier = $this->M_suppliers->get_suppliers($supplier_id);
        $supplier_name  = ucwords($supplier[0]['name']);
        
        $supplier_entries= $this->M_suppliers->get_supplier_Entries($supplier_id,$from_date,$to_date);
        
        $company_id = $_SESSION['company_id'];
        $Company = $this->M_companies->get_companies($company_id);
        
        if($supplier[0]['email'] !== '')
        {
                if($Company[0]['email'] !== '')
                {
                    $message = '';
                    ///////////////////////////
                    // for email popuse only
                    ///////////////////////////
                    if(count($supplier_entries))
                    {
                    
                    $message ='<table style="text-align:center;border-collapse: collapse;" border="1">
                    <thead>
                        <tr>
                            <th>Invoice No.</th><th>Date</th><th>Account</th><th>Dr Amount</th>
                            <th>Cr Amount</th><th>Balance</th>
                        </tr>
                    </thead><tbody>';
                    
                    //initialize
                    $dr_amount = 0.00; $cr_amount = 0.00; $balance = 0.00;
                    
                    foreach($supplier_entries as $key => $list)
                    {
                        $message .= '<tr>';
                        $message .= '<td>'.$list['invoice_no'].'</td>';
                        $message .= '<td>'.date('d-m-Y',strtotime($list['date'])).'</td>';
                        
                        $account_name = $this->M_groups->get_groups($list['dueTo_acc_code'],$_SESSION['company_id']);
                        $message .= '<td>'.($data['langs'] == 'en' ? $account_name[0]['title'] : $account_name[0]['title_ur']).'</td>';
                        $message .= '<td>'.$list['debit'].'</td>';
                        $message .= '<td>'.$list['credit'].'</td>';
                
                        $dr_amount += $list['debit'];
                        $cr_amount += $list['credit'];
                        
                        $balance = ($dr_amount - $cr_amount);
                        
                        if($dr_amount > $cr_amount){
                            $account = 'Dr'; 
                        }
                        elseif($dr_amount < $cr_amount)
                        {
                            $account = 'Cr';
                        }
                        else{ $account = '';}
                        
                        $message .= '<td>'.$account.' '.round(abs($balance),2).'</td>';
                       
                        //echo '<td>'.anchor('accounts/C_ledgers/edit/'.$list['id'],'Edit'). ' | ';
                        //echo  anchor('accounts/C_ledgers/delete/'.$list['id'],' Delete'). '</td>';
                        $message .= '</tr>';
                    }
                    $message .='</tbody>
                    </tfoot><tr><th></th><th></th>
                    <th>Total</th>
                    <th>'.$dr_amount.'</th>
                    <th>'.$cr_amount.'</th>
                    <th>'.@$account.' '.round(abs($balance)).'</td>
                    </tr>
                    </tfoot>
                    </table>';
                    
                    //echo $message;
                    }
                    
                
                
                $this->load->library('email');
                                
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                //$config['charset'] = 'iso-8859-1';
                $config['wordwrap'] = TRUE;
                
                $this->email->initialize($config);
                
                $this->email->from($Company[0]['email'], $Company[0]['name']);
                $this->email->to($supplier[0]['email']);
                //$this->email->cc('another@another-example.com');
                //$this->email->bcc('them@their-example.com');
                
                $this->email->subject($supplier_name.' Ledger Detail');
                $this->email->message($message);
                
                if(!$this->email->send())
                {
                    $this->session->set_flashdata('error',$this->email->print_debugger(array('headers')));
                    redirect('pos/Suppliers/supplierDetail/'.$supplier_id,'refresh');
                }else{
                    $this->session->set_flashdata('message','email sent to '.$supplier[0]['name'].' successfully.');
                    redirect('pos/Suppliers/supplierDetail/'.$supplier_id,'refresh'); 
                }
        
            }else{//company email
                $this->session->set_flashdata('error','Company email not available');
                redirect('pos/Suppliers/supplierDetail/'.$supplier_id,'refresh'); 
            }
        }else{//company email
            $this->session->set_flashdata('error','Supplier email not available');
            redirect('pos/Suppliers/supplierDetail/'.$supplier_id,'refresh'); 
        }
    }
    function delete($id,$op_balance_dr=0,$op_balance_cr=0)
    {
        
        $this->M_suppliers->deleteSupplier($id,$op_balance_dr,$op_balance_cr);
        
        $this->session->set_flashdata('message','Supplier Deleted');
        redirect('pos/Suppliers/index','refresh');
    }
    
    function inactivate($id,$op_balance_dr,$op_balance_cr) // it will inactive the page
    {
        $this->db->trans_start();
            $this->M_suppliers->inactivate($id,$op_balance_dr,$op_balance_cr);
        $this->db->trans_complete();   
        
        $this->session->set_flashdata('message','Supplier Deleted');
        redirect('pos/Suppliers/index','refresh');
    }
    
    function activate($id) // it will active 
    {
        $this->M_suppliers->activate($id);
        $this->session->set_flashdata('message','Supplier Activated');
        redirect('pos/Suppliers/index','refresh');
    }
    
    public function SupplierImport()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Suppliers Imports';
        $data['main'] = 'Suppliers Imports';
       
        $this->load->view('templates/header',$data);
        $this->load->view('pos/suppliers/v_import',$data);
        $this->load->view('templates/footer');
        
    }
    
    public function do_import1()
    {
        $config = array();
        $config['upload_path'] = './images';
        $config['allowed_types'] = 'xlsx|xls|csv';
        
        $this->upload->initialize($config);
       
       //var_dump($_FILES);
       
        if(!$this->upload->do_upload('upload_items_import')){
            
                $this->session->set_flashdata('error',$this->upload->display_errors());
                redirect('pos/Suppliers/SupplierImport','refresh');
            }
            else
            {
                $upload_data = $this->upload->data();
                @chmod($upload_data['full_path'],0777);
                
                $this->load->library('Excel');
                $this->load->library('IOFactory');
                $objPHPExcel= IOFactory::load($upload_data['full_path']);
                
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                //var_dump($sheetData);
                
                $worksheet = $objPHPExcel->getSheet(0);
        		$lastRow = $worksheet->getHighestRow();
        		
        		for ($row = 2; $row <= $lastRow; $row++) {
        		      
                      $data = array(
                            'company_id'=> $_SESSION['company_id'],
                            'posting_type_id' => $worksheet->getCell('A'.$row)->getValue(),
                            'op_balance_dr' => $worksheet->getCell('B'.$row)->getValue(),
                            'op_balance_cr' => $worksheet->getCell('C'.$row)->getValue(),
                            "acc_code" => $worksheet->getCell('D'.$row)->getValue(),
                            'name' => $worksheet->getCell('E'.$row)->getValue(),
                            'email' => $worksheet->getCell('F'.$row)->getValue(),
                            'address' => $worksheet->getCell('G'.$row)->getValue(),
                            'contact_no' => $worksheet->getCell('H'.$row)->getValue(),
                            'status' => 'active',
                            );
                            
                            if($this->db->insert('pos_supplier', $data)) {
                                
                                $supplier_id = $this->db->insert_id();
                                $exchange_rate = ($this->input->post('exchange_rate', true) == 0 ? 1 : $this->input->post('exchange_rate', true));
                                
                                $op_balance_dr = $this->input->post('op_balance_dr', true)/$exchange_rate;
                                $op_balance_cr = $this->input->post('op_balance_cr', true)/$exchange_rate;
                                
                                   $posting_type_code = $this->M_suppliers->getSupplierPostingTypes($supplier_id);
                                   
                                  if(count($posting_type_code) > 0)
                                  { //OPENING BALANCE IN supplier ACCOUNT
                                       $payable_acc_code = $posting_type_code[0]['payable_acc_code'];//supplier ledger id
                                       $payable_account = $this->M_groups->get_groups($payable_acc_code,$_SESSION['company_id']);
                                       $payable_dr_balance = abs($payable_account[0]['op_balance_dr']);
                                       $payable_cr_balance = abs($payable_account[0]['op_balance_cr']);
                                       
                                       $dr_balance = ($payable_dr_balance+$op_balance_dr);
                                       $cr_balance = ($payable_cr_balance+$op_balance_cr);
                                       
                                       $this->M_groups->editGroupOPBalance($payable_acc_code,$dr_balance,$cr_balance);
                                 }  
                                   //for logging
                                $msg = $this->input->post('name');
                                $this->M_logs->add_log($msg,"Supplier","Added","POS");
                                // end logging
                        
                            $uploads = true;
                                
                            }
        			 
        		}
        		         if($uploads){
        		          
        		          $this->session->set_flashdata('message','Supplier uploaded successfully');
                        }else{
                            $this->session->set_flashdata('error','Supplier not uploaded');
                        }
                        
                        @unlink($upload_data['full_path']); //DELETE FILE
                        redirect('pos/Suppliers/index','refresh');
              
            }
    }
    
    public function do_import()
    {
        
       if($_FILES['upload_items_import']['name'] != ''){
                      $errors= array();
                      $file_name = $_FILES['upload_items_import']['name'];
                      $file_size =$_FILES['upload_items_import']['size'];
                      $file_tmp =$_FILES['upload_items_import']['tmp_name'];
                      $file_type=$_FILES['upload_items_import']['type'];
                      //$file_ext=strtolower(end(explode('.',$_FILES['upload_items_import']['name'])));
                      $file_ext =pathinfo($_FILES['upload_items_import']['name']); 
                      $expensions= array("xlsx","xls","csv");
                      
                      if(in_array($file_ext['extension'],$expensions) === false){
                         $this->session->set_flashdata('error', 'extension not allowed, please choose a xlsx|xls|csv file.');
                         redirect('pos/C_customers/CustomerImport', 'refresh');
                      }
                      
                      if(empty($errors)==true){
                        
                        $target_dir = 'images/company/';
                        $target_file = $target_dir . basename($_FILES["upload_items_import"]["name"]);
                        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                        
                        move_uploaded_file($_FILES["upload_items_import"]["tmp_name"],$target_file);

                        //echo "Success";
                        $this->load->library('Excel');
                        $this->load->library('IOFactory');
                        
                        $inputFileType = PHPExcel_IOFactory::identify($target_file);

                        $objPHPExcel= IOFactory::load($target_file);
                        
                        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                        
                        $worksheet = $objPHPExcel->getSheet(0);
                		$lastRow = $worksheet->getHighestRow();
                		//var_dump($worksheet);
                        
                		$uploads = false;
                        $data_excel = array();
                		for ($row = 2; $row <= $lastRow; $row++) {
        		      
                             $data = array(
                                    $data_excel[$row - 1]['company_id'] = $_SESSION['company_id'],
                                    $data_excel[$row - 1]['posting_type_id'] = $worksheet->getCell('A'.$row)->getValue(),
                                    //'op_balance_dr' => $worksheet->getCell('B'.$row)->getValue(),
        //                            'op_balance_cr' => $worksheet->getCell('C'.$row)->getValue(),
                                    $data_excel[$row - 1]["acc_code"] = $worksheet->getCell('B'.$row)->getValue(),
                                    $data_excel[$row - 1]['name'] = $worksheet->getCell('C'.$row)->getValue(),
                                    $data_excel[$row - 1]['email'] = $worksheet->getCell('D'.$row)->getValue(),
                                    $data_excel[$row - 1]['address'] = $worksheet->getCell('E'.$row)->getValue(),
                                    $data_excel[$row - 1]['contact_no'] = $worksheet->getCell('F'.$row)->getValue(),
                                    $data_excel[$row - 1]['status'] = 'active',
                                    );
                                    
                                    $uploads = true;
                			 
                		}
        		         if($uploads){
        		          $this->db->insert_batch('pos_supplier',$data_excel);
                               //for logging
                                $msg = '';
                                $this->M_logs->add_log($msg,"Supplier","Imported","POS");
                                // end logging
                                
        		          $this->session->set_flashdata('message','Supplier uploaded successfully');
                        }else{
                            $this->session->set_flashdata('error','Supplier not uploaded');
                        }
                        
                        @unlink($target_file);
                        redirect('pos/Suppliers/index','refresh');
                        
                      }else{
                         //sprint_r($errors);
                         //return $errors;
                         $this->session->set_flashdata('error',$errors);
                         redirect('pos/Suppliers/SupplierImport','refresh');
                      }
                   }
                   else
                   {
                        $this->session->set_flashdata('error','Please select excel file to upload');
                        redirect('pos/Suppliers/SupplierImport','refresh');
                   }
                //upload an image options
                 ////////////////////////
       } 
}