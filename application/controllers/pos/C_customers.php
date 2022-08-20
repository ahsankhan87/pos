<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_customers extends MY_Controller{
    
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
        
        $data['customers']= $this->M_customers->get_activeCustomers();
        
        $this->load->view('templates/header',$data);
        //$this->load->view('pos/customers/v_custWithBalance',$data);
        $this->load->view('pos/customers/v_customers_1',$data);
        // $this->load->view('pos/customers/v_customers',$data);
        $this->load->view('templates/footer');
    }
    
    function advance_search()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('listof').' ' .lang('customers');
        $data['main'] = lang('listof').' ' .lang('customers');
        
        $city = $this->input->post('city');
        
        $data['customers']= $this->M_customers->customer_search($city);
        
        $this->load->view('templates/header',$data);
        //$this->load->view('pos/customers/v_custWithBalance',$data);
        $this->load->view('pos/customers/v_customers_search',$data);
        $this->load->view('templates/footer');
    }
    function customerDetail($customer_id)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('customer').' ' .lang('detail');
        $data['main'] = lang('customer').' ' .lang('detail');
        
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : FY_START_DATE);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : FY_END_DATE);
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        $data['customer'] = $this->M_customers->get_customers($customer_id);
        $data['customer_entries']= $this->M_customers->get_customer_Entries($customer_id,$data['from_date'],$data['to_date']);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/customers/v_customerDetail',$data);
        $this->load->view('templates/footer');
    }
    function receivePayment($customer_id)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Receive Payment Customers';
        $data['main'] = 'Receive Payment Customers';
        
        $data['activeBanks'] = $this->M_banking->getbankDropDown();
        //$data['creditSales'] = $this->M_sales->get_creditSales($customer_id);
        $data['customer'] = $this->M_customers->get_customers($customer_id);
        //$data['customer_entries']= $this->M_customers->get_customer_Entries($customer_id,FY_START_DATE,FY_END_DATE);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/customers/v_receivePayment',$data);
        $this->load->view('templates/footer');
    }
    
    function getCreditSalesJSON($customer_id)
    {
        $creditSales = $this->M_sales->get_creditSales($customer_id);
        echo json_encode($creditSales);
    }
    
    function get_customers_JSON($acc_code)
    {
        print_r(json_encode($this->M_customers->get_activeCustomersByAccCode($acc_code)));
    }
    
    function get_active_customers_JSON($id=FALSE)
    {
        print_r(json_encode($this->M_customers->get_activeCustomers($id)));
    }
    
    function get_act_customers_JSON()
    {
        print_r(json_encode($this->M_customers->get_actCustomers()));
    }
    
    function makePayment()
    {
        $customer_id = $this->input->post('customer_id',true);
        $is_customer = 1;
        
        //GET ALL ACCOUNT CODE WHICH IS TO BE POSTED AMOUNT
        $posting_type_code = $this->M_customers->getCustomerPostingTypes($customer_id);
           
        if($this->input->post('customer_id') && $this->input->post('amount') && $posting_type_code)
        {
           $this->db->trans_start();
           
           //GET PREVIOISE INVOICE NO  
           @$prev_invoice_no = $this->M_customers->getMAXCustInvoiceNo('C');
           $number = (int) substr($prev_invoice_no,1)+1; //EXTRACT THE LAST NO AND INCREMENT BY 1
           $new_invoice_no = 'C'.$number;
           
           $date = $this->input->post('payment_date', true);
           $payment_type = $this->input->post('payment_type', true);
           $discount_amount = $this->input->post('discount_amount', true);
           $narration = ($this->input->post('narration',true) == '' ? '' : $this->input->post('narration',true));
           $exchange_rate = ($this->input->post('exchange_rate',true) == '' ? 1 : $this->input->post('exchange_rate',true)); //Current Exchange Rate
           
           $total_amount = $this->input->post('amount', true);
           
           //$prev_exchange_rate = $this->input->post('prev_exchange_rate',true); //array. Previouse
           //$credit_amount = $this->input->post('cr_amount', true);
           //$paid = $this->input->post('paid', true);
          // $invoice_no = $this->input->post('invoice_no', true);
           
           //var_dump($credit_amount);
           //var_dump($paid);
           //var_dump($exchange_rate);
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
//                        $cr_amount1 = $cr_amount+(abs($cr_amount-$cr_amount_prev));
//                    }else{
//                        $cr_amount1 = $cr_amount;
//                    }
//                    
//                    $current_ExRate_total += round($cr_amount,4);
//                    $prev_ExRate_total += round($values/$prev_exchange_rate[$i],4);
//                
//                }else{
//                    $cr_amount1 = $values;
//                    $total_Not_ExRate += round($cr_amount1,4);//without exchange rate total amount
//                }
//                 
//                //echo '<br />';
//                 $paid1 = round($paid[$i]+$cr_amount1,4);
//                //echo '<br />';
//                
//                $data = array(
//                'paid' => ((float)$paid1+(float)$discount_amount),
//                );
//        
//                $this->M_sales->updatePaidAmount($invoice_no[$i],$data);
//               
//               //ADD PAYMENT HISTORY OF CUSTOMER IN SEPARATE TABLE 
//               if(!empty($cr_amount1))
//               {
//                    $data1 = array(
//                    'customer_id'=>$customer_id,
//                    'invoice_no'=>$new_invoice_no,
//                    'sales_invoice_no'=>$invoice_no[$i],
//                    'amount'=>((float)$cr_amount1+(float)$discount_amount),
//                    'company_id'=>$_SESSION['company_id']
//                    );
//                    $this->db->insert('pos_customer_payment_history',$data1);
//                    
//               } 
//               ///
//                
//            endforeach;
            
                //echo $current_ExRate_total;
//                echo'<br />';
//                echo $prev_ExRate_total;
            $current_ExRate_total = $total_amount/$exchange_rate;
            
           if(@$_SESSION['multi_currency'] == 1)
           {
                if($current_ExRate_total < $prev_ExRate_total)
                {
                    $forex_status = 'loss';
                    $forex_loss_amount = abs($current_ExRate_total-$prev_ExRate_total);
                    
                }elseif($current_ExRate_total > $prev_ExRate_total)
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
           
           //RECIV CASH FROM CUSTOMER AND REDUCE RECEVABLES
           $cr_account = $posting_type_code[0]['receivable_acc_code'];//customer ledger id
           $forex_gain_account = $posting_type_code[0]['forex_gain_acc_code'];//FOREX GAIN ACCOUNT
           $forex_loss_account = $posting_type_code[0]['forex_loss_acc_code'];//FOREX LOSS ACCOUNT
           $dr_account = $payment_acc_code;
           
           if(@$_SESSION['multi_currency'] == 1)
           {
                if($forex_status == 'loss')
                {
                    //ACTUAL AMOUNT MINUS LOSS JOURNAL ENTRY
                   $amount = $current_ExRate_total;
                   $entry_id = $this->M_entries->addEntries($dr_account,$cr_account,$amount,$amount,$narration,$new_invoice_no,$date);
                   
                   //FOREX LOSS JOURNAL ENTRY
                   $entry_id_fx = $this->M_entries->addEntries($forex_loss_account,$cr_account,$forex_loss_amount,$forex_loss_amount,$narration,$new_invoice_no,$date);
                   
                   //POST IN cusmoter payment table
                   $this->M_customers->addCustomerPaymentEntry($cr_account,$dr_account,0,$amount,$customer_id,$narration,$new_invoice_no,$date,$exchange_rate,$entry_id);
                   //FOREX LOSS ENTRY IN CUSTOMER 
                   $this->M_customers->addCustomerPaymentEntry($cr_account,$forex_loss_account,0,$forex_loss_amount,$customer_id,$narration,$new_invoice_no,$date,$exchange_rate,$entry_id_fx);
                   ///
                }
                elseif($forex_status == 'gain')
                {
                    //ACTUAL AMOUNT MINUS LOSS JOURNAL ENTRY
                   $amount = $current_ExRate_total;
                   $entry_id=$this->M_entries->addEntries($dr_account,$cr_account,$amount,$amount,$narration,$new_invoice_no,$date);
                   
                   //FOREX LOSS JOURNAL ENTRY
                  $entry_id_fx = $this->M_entries->addEntries($cr_account,$forex_gain_account,$forex_gain_amount,$forex_gain_amount,$narration,$new_invoice_no,$date);
                   
                   //POST IN cusmoter payment table
                   $this->M_customers->addCustomerPaymentEntry($cr_account,$dr_account,0,$amount,$customer_id,$narration,$new_invoice_no,$date,$exchange_rate,$entry_id);
                   //FOREX LOSS ENTRY IN CUSTOMER 
                   $this->M_customers->addCustomerPaymentEntry($cr_account,$forex_gain_account,$forex_gain_amount,0,$customer_id,$narration,$new_invoice_no,$date,$exchange_rate,$entry_id_fx);
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
                   $this->M_customers->addCustomerPaymentEntry($cr_account,$dr_account,0,$amount,$customer_id,$narration,$new_invoice_no,$date,$exchange_rate,$entry_id);
                   
                }
                    
               
           }else
           {
               
               //$entry_id = $this->M_entries->addEntries($dr_account,$cr_account,$amount,$amount,$narration,$new_invoice_no,$date,null,$customer_id,$is_customer);
               $this->M_entries->add_debit_entry($dr_account,$cr_account,$amount,$amount,$narration,$new_invoice_no,$date);
               $entry_id = $this->M_entries->add_credit_entry($dr_account,$cr_account,$amount,$amount,$narration,$new_invoice_no,$date,null,$customer_id,$is_customer);
               
               //POST IN cusmoter payment table
               $this->M_customers->addCustomerPaymentEntry($cr_account,$dr_account,0,$amount,$customer_id,$narration,$new_invoice_no,$date,1,$entry_id);
               ///
           }
           
           ///POST BANK ACCOUNT TABLE
           if($payment_type == 'bank'){
                $bank_id = $this->input->post('bank_id',true);
        
                $this->M_banking->addBankPaymentEntry($dr_account,$cr_account,$amount,0,$bank_id,$narration,$new_invoice_no,$date,$entry_id);
           
           }
           ////
           
           //IF DISCOUNT GIVEN
           if($discount_amount > 0)
           {
               $cr_dis_account = $posting_type_code[0]['receivable_acc_code'];//customer ledger id
               $dr_dis_account = $posting_type_code[0]['salesdis_acc_code'];//customer ledger id
               //$entry_id=$this->M_entries->addEntries($dr_dis_account,$cr_dis_account,$discount_amount,$discount_amount,$narration,$new_invoice_no,$date,null,$customer_id,$is_customer);
               
               $this->M_entries->add_debit_entry($dr_dis_account,$cr_dis_account,$discount_amount,$discount_amount,$narration,$new_invoice_no,$date);
               $entry_id = $this->M_entries->add_credit_entry($dr_dis_account,$cr_dis_account,$discount_amount,$discount_amount,$narration,$new_invoice_no,$date,null,$customer_id,$is_customer);
               
               //for cusmoter payment table
               $this->M_customers->addCustomerPaymentEntry($cr_dis_account,$dr_dis_account,0,$discount_amount,$customer_id,$narration,$new_invoice_no,$date,1,$entry_id);
               ///
           }
           
           $this->db->trans_complete();   
           
           $this->session->set_flashdata('message','Payment Received Successfully');
           redirect('pos/C_customers/customerDetail/'.$customer_id,'refresh');
        }
        else
        {
            $this->session->set_flashdata('error','Payment Not Received. It seem that you did not assign posting account type to customer.');
            redirect('pos/C_customers/customerDetail/'.$customer_id,'refresh');
        }
         
    }
    
    function ngMakePayment()
    {
        // get posted data from angularjs purchases 
        $data_posted = json_decode(file_get_contents("php://input",true)); 
        
        print_r($data_posted);
        die;
        
        if(count($data_posted) > 0)
        {
            $customer_id = $data_posted->customer_id;
            
            //GET ALL ACCOUNT CODE WHICH IS TO BE POSTED AMOUNT
            $posting_type_code = $this->M_customers->getCustomerPostingTypes($customer_id);
        
        if($customer_id && $data_posted->amount && $posting_type_code)
        {
          
            //GET PREVIOISE INVOICE NO  
           @$prev_invoice_no = $this->M_customers->getMAXCustInvoiceNo();
           $number = (int) substr($prev_invoice_no,1)+1; //EXTRACT THE LAST NO AND INCREMENT BY 1
           $new_invoice_no = 'C'.$number;
           
           
           $payment_type = $data_posted->payment_type;
           $discount_dr_amount =($data_posted->discount_amount == '' ? 0 : $data_posted->discount_amount);
           $disount_cr_amount = ($data_posted->discount_amount == '' ? 0 : $data_posted->discount_amount);
            
           $dr_amount = ($data_posted->amount == '' ? 0 : $data_posted->amount);
           $cr_amount = ($data_posted->amount == '' ? 0 : $data_posted->amount);
           $narration = ($data_posted->narration == '' ? '' : $data_posted->narration);
           
           if($payment_type == 'cash')
           {
                $payment_acc_code = $posting_type_code[0]['cash_acc_code'];
           }elseif($payment_type == 'bank'){
                $payment_acc_code = $posting_type_code[0]['bank_acc_code'];
           }
           
           //RECIV CASH FROM CUSTOMER AND REDUCE RECEVABLES
           $cr_account = $posting_type_code[0]['receivable_acc_code'];//customer ledger id
           $dr_account = $payment_acc_code;
           $this->M_entries->addEntries($dr_account,$cr_account,$dr_amount,$cr_amount,$narration,$new_invoice_no);
           
           //POST IN cusmoter payment table
           $this->M_customers->addCustomerPaymentEntry($cr_account,$dr_account,0,$cr_amount,$customer_id,$narration,$new_invoice_no);
           ///
           
           ///POST BANK ACCOUNT TABLE
           if($payment_type == 'bank'){
                $bank_id = $data_posted->bank_id;
        
                $this->M_banking->addBankPaymentEntry($dr_account,$cr_account,$dr_amount,0,$bank_id,$narration,$new_invoice_no);
           
           }
           ////
           
           //IF DISCOUNT GIVEN
           if($discount_dr_amount > 0)
           {
               $cr_dis_account = $posting_type_code[0]['receivable_acc_code'];//customer ledger id
               $dr_dis_account = $posting_type_code[0]['salesdis_acc_code'];//customer ledger id
               $this->M_entries->addEntries($dr_dis_account,$cr_dis_account,$discount_dr_amount,$disount_cr_amount,$narration,$new_invoice_no);
               
               //for cusmoter payment table
               $this->M_customers->addCustomerPaymentEntry($cr_dis_account,$dr_dis_account,0,$disount_cr_amount,$customer_id,$narration,$new_invoice_no);
               ///
           }
           
           //extract JSON array items from posted data.
            //foreach($data_posted->creditSales as $posted_values):
//            
//                $paid = ($posted_values->paid*$posted_values->exchange_rate)+$posted_values->credit_amount;
//                
//                $data = array(
//                'paid' => $paid,
//                );
//        
//                $this->M_sales->updatePaidAmount($posted_values->invoice,$data);
//            endforeach;
            
            
           $this->session->set_flashdata('message','Payment Received Successfully');
           redirect('pos/C_customers/customerDetail/'.$customer_id,'refresh');
        }
        else
        {
            $this->session->set_flashdata('error','Payment Not Received. It seem that you did not assign posting account type to customer.');
            redirect('pos/C_customers/customerDetail/'.$customer_id,'refresh');
        }
         
            
           
        }
        
           if(@$_SESSION['multi_currency'] == 1)
           {
                
           }
           /////
            
           
    }
    
    function cheque_list()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','10240M');

        $data['title'] = lang('listof').' Cheques';
        $data['main'] = lang('listof').' Cheques';
        
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : FY_START_DATE);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : FY_END_DATE);
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        $data['customer'] = $this->M_customers->get_customers();
        $data['customer_entries']= $this->M_customers->get_customer_entries_cheques_all($data['from_date'],$data['to_date']);
        
        $this->load->view('templates/header',$data);
        //$this->load->view('pos/customers/v_custWithBalance',$data);
        $this->load->view('pos/customers/v_cheques_list',$data);
        $this->load->view('templates/footer');
    }

    //function paymentModal($customer_id)
//    {
//        $data = array('langs' => $this->session->userdata('lang'));
//        
//        $data['title'] = 'Manage Customers';
//        $data['main'] = 'Manage Customers';
//        
//        //$data['cities'] = $this->M_city->get_city();
//        $data['customers']= $this->M_customers->get_customers($customer_id);
//        //$data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id']);//search for legder account
//        $data['customer_entries']= $this->M_customers->get_customer_Entries($customer_id,FY_START_DATE,FY_END_DATE);
//        
//        $this->load->view('templates/header',$data);
//        $this->load->view('pos/customers/paymentModal',$data);
//        $this->load->view('templates/footer');
//    }
    
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            
            //form Validation
            $this->form_validation->set_rules('posting_type_id', 'Posting Type', 'required');
            //$this->form_validation->set_rules('store_name', 'Company Name', 'required');
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            
            if(@$_SESSION['multi_currency'] == 1){
            $this->form_validation->set_rules('currency_id', 'Currency', 'required');
            }
            //$this->form_validation->set_rules('opening_balance_amount', 'Opening Balance Amount', 'required');
            //$this->form_validation->set_rules('capital_acc_code', 'Select Capital Account', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            $this->db->trans_start();
            
            //after form Validation run
            if($this->form_validation->run())
            {
                $data = array(
                'company_id'=> $_SESSION['company_id'],
                'posting_type_id' => $this->input->post('posting_type_id', true),
                'first_name' => $this->input->post('first_name', true),
                'last_name' => $this->input->post('last_name', true),
                'middle_name' => $this->input->post('middle_name', true),
                'title' => $this->input->post('title', true),
                'phone_no' => $this->input->post('phone_no', true),
                'fax_no' => $this->input->post('fax_no', true),
                'website' => $this->input->post('website', true),
                'store_name' => $this->input->post('store_name', true),
                'city' => $this->input->post('city', true),
                'country' => $this->input->post('country', true),
                'email' => $this->input->post('email', true),
                'address' => $this->input->post('address', true),
                'mobile_no' => $this->input->post('mobile_no', true),
                'currency_id' => $this->input->post('currency_id', true),
                'acc_code' => $this->input->post('acc_code', true),
                'status' => 'active',
                'op_balance_dr' => $this->input->post('op_balance_dr', true),
                'op_balance_cr' => $this->input->post('op_balance_cr', true),
                "exchange_rate" => $this->input->post('exchange_rate', true),
                // 'emp_id' => $this->input->post('emp_id', true),
                
                
                );
            
                if($this->db->insert('pos_customers', $data)) {
                    
                    $customer_id = $this->db->insert_id();
                    $exchange_rate = ($this->input->post('exchange_rate', true) == 0 ? 1 : $this->input->post('exchange_rate', true));
                    
                    $op_balance_dr = (float)$this->input->post('op_balance_dr', true)/$exchange_rate;
                    $op_balance_cr = (float)$this->input->post('op_balance_cr', true)/$exchange_rate;
                    
                       $posting_type_code = $this->M_customers->getCustomerPostingTypes($customer_id);
                       
                       //OPENING BALANCE IN CUSTOMER ACCOUNT
                       $receivable_account_code = $posting_type_code[0]['receivable_acc_code'];//customer ledger id
                       
                       $receivable_account = $this->M_groups->get_groups($receivable_account_code,$_SESSION['company_id']);
                       $receivable_dr_balance = abs($receivable_account[0]['op_balance_dr']);
                       $receivable_cr_balance = abs($receivable_account[0]['op_balance_cr']);
                       
                       $dr_balance = ($receivable_dr_balance+$op_balance_dr);
                       $cr_balance = ($receivable_cr_balance+$op_balance_cr);
                       
                       $this->M_groups->editGroupOPBalance($receivable_account_code,$dr_balance,$cr_balance);
                       
                       //POST IN cusmoter payment table
                       //$this->M_customers->addCustomerPaymentEntry($receivable_account_code,0,0,0,$customer_id,
                      //'Opening Balance-Debtor','',null,$exchange_rate,$op_balance_dr,$op_balance_cr);
                       ///
                    
                    
                    //for logging
                    $msg = $this->input->post('first_name'). ' '. $this->input->post('last_name');
                    $this->M_logs->add_log($msg,"Customer","Added","POS");
                    // end logging
            
                    $this->session->set_flashdata('message','Customer Created');
                }else{
                    $this->session->set_flashdata('error','Customer not updated');
                }
            
            $this->db->trans_complete();   
                
                redirect('pos/C_customers/index','refresh');
            
           }
        }
            $data['title'] = lang('add_new').' ' .lang('customer');
            $data['main'] = lang('add_new').' ' .lang('customer');
            
            $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);//search for legder account
            $data['currencyDropDown'] = $this->M_currencies->getcurrencyDropDown();
            $data['salesPostingTypeDDL'] = $this->M_postingTypes->get_SalesPostingTypesDDL();
            // $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        
            $this->load->view('templates/header',$data);
            //$this->load->view('pos/customers/travel_agency/create_travel',$data);//for travel agency only
            $this->load->view('pos/customers/create',$data);
            $this->load->view('templates/footer');
        
    }
    //edit category
    public function edit($id=NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form Validation
            $this->form_validation->set_rules('posting_type_id', 'Posting Type Id', 'required');
            //$this->form_validation->set_rules('store_name', 'Company Name', 'required');
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            if(@$_SESSION['multi_currency'] == 1){
            $this->form_validation->set_rules('currency_id', 'Currency', 'required');
            }
            //$this->form_validation->set_rules('opening_balance_amount', 'Opening Balance Amount', 'required');
            //$this->form_validation->set_rules('capital_acc_code', 'Select Capital Account', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            $this->db->trans_start();
            
            //after form Validation run
            if($this->form_validation->run())
            {
                $data = array(
                'posting_type_id' => $this->input->post('posting_type_id', true),
                'first_name' => $this->input->post('first_name', true),
                'last_name' => $this->input->post('last_name', true),
                'middle_name' => $this->input->post('middle_name', true),
                'title' => $this->input->post('title', true),
                'phone_no' => $this->input->post('phone_no', true),
                'fax_no' => $this->input->post('fax_no', true),
                'website' => $this->input->post('website', true),
                'store_name' => $this->input->post('store_name', true),
                'city' => $this->input->post('city', true),
                'country' => $this->input->post('country', true),
                'email' => $this->input->post('email', true),
                'address' => $this->input->post('address', true),
                'mobile_no' => $this->input->post('mobile_no', true),
                'currency_id' => $this->input->post('currency_id', true),
                'acc_code' => $this->input->post('acc_code', true),
                'op_balance_dr' => $this->input->post('op_balance_dr', true),
                'op_balance_cr' => $this->input->post('op_balance_cr', true),
                "exchange_rate" => $this->input->post('exchange_rate', true),
                // 'emp_id' => $this->input->post('emp_id', true),
                
                );
            //$this->db->update('pos_customers', $data, array('id'=>$_POST['id']));
            
                if($this->db->update('pos_customers', $data, array('id'=>$this->input->post('id')))) {
                    
                    //$customer_id = $this->input->post('id');
                    $exchange_rate = ($this->input->post('exchange_rate', true) == 0 ? 1 : $this->input->post('exchange_rate', true));
                    
                    $op_balance_dr = (float)$this->input->post('op_balance_dr', true)/$exchange_rate;
                    $op_balance_cr = (float)$this->input->post('op_balance_cr', true)/$exchange_rate;
                    
                    
                    $op_balance_dr_old = $this->input->post('op_balance_dr_old', true)/$exchange_rate;
                    
                    $op_balance_cr_old = $this->input->post('op_balance_cr_old', true)/$exchange_rate;
                    
                    
                    $posting_type_code = $this->M_postingTypes->get_salesPostingTypes($this->input->post('posting_type_id',true));
                       
                     //OPENING BALANCE IN CUSTOMER ACCOUNT
                       $receivable_account_code = $posting_type_code[0]['receivable_acc_code'];//customer ledger id
                       
                       $receivable_account = $this->M_groups->get_groups($receivable_account_code,$_SESSION['company_id']);
                       $receivable_dr_balance = abs($receivable_account[0]['op_balance_dr']);
                       
                       $receivable_cr_balance = abs($receivable_account[0]['op_balance_cr']);
                       
                       $dr_balance = $receivable_dr_balance-$op_balance_dr_old;
                       $cr_balance = $receivable_cr_balance-$op_balance_cr_old;
                       
                       $dr_balance = ($dr_balance+$op_balance_dr);
                       $cr_balance = ($cr_balance+$op_balance_cr);
                       
                       $this->M_groups->editGroupOPBalance($receivable_account_code,$dr_balance,$cr_balance);
                       
                       //POST IN cusmoter payment table
                       //$this->M_customers->addCustomerPaymentEntry($receivable_account_code,0,0,0,$customer_id,
                       //'Opening Balance-Debtor','',null,$exchange_rate,$op_balance_dr,$op_balance_cr);
                       ///
                    
                    
                    //for logging
                    $msg = $this->input->post('first_name'). ' '. $this->input->post('last_name');
                    $this->M_logs->add_log($msg,"Customer","Updated","POS");
                    // end logging
            
                    $this->session->set_flashdata('message','Customer Updated');
                }else{
                    $this->session->set_flashdata('error','Customer not updated');
                }
                $this->db->trans_complete();   
                
                redirect('pos/C_customers','refresh');
            }
        }
       //else
        //{
            $data['title'] = lang('update').' ' .lang('customer');
            $data['main'] = lang('update').' ' .lang('customer');
            
            $data['customer'] = $this->M_customers->get_customers($id);
            $data['salesPostingTypeDDL'] = $this->M_postingTypes->get_SalesPostingTypesDDL();
            $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);//search for legder account
            $data['currencyDropDown'] = $this->M_currencies->getcurrencyDropDown();
            // $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
            
            $this->load->view('templates/header',$data);
            $this->load->view('pos/customers/edit',$data);
            //$this->load->view('pos/customers/travel_agency/edit_travel',$data);//for travel agency only
            $this->load->view('templates/footer');
        //}
    }
    
    function emailCustLedger($customer_id,$from_date,$to_date)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $customer = $this->M_customers->get_customers($customer_id);
        $customer_name  = ucwords($customer[0]['title'].' '.$customer[0]['first_name'].' '.$customer[0]['middle_name'].' '.$customer[0]['last_name']);
        
        $customer_entries= $this->M_customers->get_customer_Entries($customer_id,$from_date,$to_date);
        
        $company_id = $_SESSION['company_id'];
        $Company = $this->M_companies->get_companies($company_id);
        
        if($customer[0]['email'] !== '')
        {
                if($Company[0]['email'] !== '')
                {
                    ///////////////////////////
                    // for email popuse only
                    ///////////////////////////
                    if(count($customer_entries))
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
                    
                    foreach($customer_entries as $key => $list)
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
                    }
                    
        
                $this->load->library('email');
                                
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                //$config['charset'] = 'iso-8859-1';
                $config['wordwrap'] = TRUE;
                
                $this->email->initialize($config);
                
                $this->email->from($Company[0]['email'], $Company[0]['name']);
                $this->email->to($customer[0]['email']);
                //$this->email->cc('another@another-example.com');
                //$this->email->bcc('them@their-example.com');
                
                $this->email->subject($customer_name.' Ledger Detail');
                $this->email->message($message);
                
                if(!$this->email->send())
                {
                    $this->session->set_flashdata('error',$this->email->print_debugger(array('headers')));
                    redirect('pos/C_customers/customerDetail/'.$customer_id,'refresh');
                }else{
                    $this->session->set_flashdata('message','email sent to '.$customer_name.' successfully.');
                    redirect('pos/C_customers/customerDetail/'.$customer_id,'refresh'); 
                }
        
            }else{//company email
                $this->session->set_flashdata('error','Company email not available');
                redirect('pos/C_customers/customerDetail/'.$customer_id,'refresh'); 
            }
        }else{//company email
            $this->session->set_flashdata('error','Customer email not available');
            redirect('pos/C_customers/customerDetail/'.$customer_id,'refresh'); 
        }
    }
    
    
    function delete($id,$op_balance_dr=0,$op_balance_cr=0)
    {
        $this->M_customers->deleteCustomer($id,$op_balance_dr,$op_balance_cr);
        
        $this->session->set_flashdata('message','Customer Deleted');
        redirect('pos/C_customers/index','refresh');
    }
    
    function inactivate($id,$op_balance_dr,$op_balance_cr) // it will inactive the page
    {
        $this->M_customers->inactivate($id,$op_balance_dr,$op_balance_cr);
        
        $this->session->set_flashdata('message','Customer Deleted');
        redirect('pos/C_customers/index','refresh');
    }
    
    function activate($id) // it will active 
    {
        $this->M_customers->activate($id);
        $this->session->set_flashdata('message','Customer Activated');
        redirect('pos/C_customers/index','refresh');
    }
    
    public function CustomerImport()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Customer Imports';
        $data['main'] = 'Customer Imports';
       
        $this->load->view('templates/header',$data);
        $this->load->view('pos/customers/v_import',$data);
        $this->load->view('templates/footer');
        
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
                                $data_excel[$row - 1]['posting_type_id']  = $worksheet->getCell('A'.$row)->getValue(),
                                //$data_excel[$row - 1]['op_balance_dr']  = $worksheet->getCell('B'.$row)->getValue(),
                                //$data_excel[$row - 1]['op_balance_cr']  = $worksheet->getCell('C'.$row)->getValue(),
                                $data_excel[$row - 1]['acc_code']  = $worksheet->getCell('B'.$row)->getValue(),
                                $data_excel[$row - 1]['title']  = $worksheet->getCell('C'.$row)->getValue(),
                                $data_excel[$row - 1]['first_name']  = $worksheet->getCell('D'.$row)->getValue(),
                                $data_excel[$row - 1]['middle_name']  = $worksheet->getCell('E'.$row)->getValue(),
                                $data_excel[$row - 1]['last_name']  = $worksheet->getCell('F'.$row)->getValue(),
                                $data_excel[$row - 1]['store_name']  = $worksheet->getCell('G'.$row)->getValue(),
                                $data_excel[$row - 1]['email']  = $worksheet->getCell('H'.$row)->getValue(),
                                $data_excel[$row - 1]['address']  = $worksheet->getCell('I'.$row)->getValue(),
                                $data_excel[$row - 1]['city']  = $worksheet->getCell('J'.$row)->getValue(),
                                $data_excel[$row - 1]['phone_no']  = $worksheet->getCell('K'.$row)->getValue(),
                                $data_excel[$row - 1]['mobile_no']  = $worksheet->getCell('L'.$row)->getValue(),
                                $data_excel[$row - 1]['fax_no']  = $worksheet->getCell('M'.$row)->getValue(),
                                $data_excel[$row - 1]['website']  = $worksheet->getCell('N'.$row)->getValue(),
                                $data_excel[$row - 1]['status']  = 'active'
                                );
                                
                                
                			 $uploads = true;
                		}
        		         if($uploads){
        		          
                          $this->db->insert_batch('pos_customers',$data_excel);
                           
        		          $this->session->set_flashdata('message','Customer uploaded successfully');
                          
                                    //for logging
                                    $msg = '';
                                    $this->M_logs->add_log($msg,"Customer","Imported","POS");
                                    // end logging
                        }else{
                            $this->session->set_flashdata('error','Customer not uploaded');
                        }
                        
                        @unlink($target_file);
                        redirect('pos/C_customers/index','refresh');
                        
                      }else{
                         //sprint_r($errors);
                         //return $errors;
                         $this->session->set_flashdata('error',$errors);
                         redirect('pos/C_customers/CustomerImport','refresh');
                      }
                   }
                   else
                   {
                        $this->session->set_flashdata('error','Please select excel file to upload');
                        redirect('pos/C_customers/CustomerImport','refresh');
                   }
                //upload an image options
                 ////////////////////////
       
    } 
    
    function getCustomersWithBalanceJSON()
    {
        //print_r(json_encode($this->M_customers->get_activeCustomers()));
        $lang = array('langs' => $this->session->userdata('lang'));
        
        $data = $this->M_customers->get_activeCustomers();
        
        $outp = "";
        foreach($data as $rs)
        {
            //$tm =  json_decode($rs["teams_id"]);
            //print_r($tm);
            
            if ($outp != "") {$outp .= ",";}
            
            $outp .= '["'  . $rs["id"] . '",';
            $outp .= '"'   . trim($rs["first_name"]). '",';
            $outp .= "\"<a href='".site_url($lang['langs'])."/pos/C_customers/customerDetail/".$rs['id']."'>".$rs['store_name']."</a>\",";
            
            
            if(@$_SESSION['multi_currency'] == 1){
            $outp .= '"'   . $this->M_currencies->get_currencyName($rs['currency_id']). '",';
            }
            
            $outp .= '"'   . trim($rs["address"]). '",';
            
            $exchange_rate = ($rs['exchange_rate'] == 0 ? 1 : $rs['exchange_rate']);
        
            //OPENING BALANCES
            $op_balance_dr = ($rs['op_balance_dr']/$exchange_rate);
            $op_balance_cr = ($rs['op_balance_cr']/$exchange_rate);
            $op_balance = round(($op_balance_dr-$op_balance_cr)/$exchange_rate,2);
            
            //CURRENT BALANCES
            $cur_balance = $this->M_customers->get_customer_total_balance($rs['id'],FY_START_DATE,FY_END_DATE);
            $balance_dr = ($cur_balance[0]['dr_balance']/$exchange_rate);
            $balance_cr = ($cur_balance[0]['cr_balance']/$exchange_rate);
            
            //echo '<td>'.round($op_balance_dr+$balance_dr,2).'</td>';
//            echo '<td>'.round($op_balance_cr+$balance_cr,2).'</td>';
//            echo '<td>'.round(($op_balance_dr+$balance_dr)-($op_balance_cr+$balance_cr),2).'</td>';
            
            $outp .= '"'   . round($op_balance_dr+$balance_dr,2). '",';
            $outp .= '"'   . round($op_balance_cr+$balance_cr,2). '",';
            $outp .= '"'. round(($op_balance_dr+$balance_dr)-($op_balance_cr+$balance_cr),2)     . '",';
            $outp .= "\"<a href='".site_url($lang['langs'])."/pos/C_customers/edit/".$rs['id']."'><i class='fa fa-pencil-square-o fa-fw'></i> | </a><a href='".site_url($lang['langs'])."/pos/C_customers/inactivate/".$rs['id']."' onclick='return confirm('Are you sure you want to delete?')'; title='Make Inactive'><i class='fa fa-trash-o fa-fw'></i></a>\"]";
             
        }
            
        $outp ='{"data": ['.$outp.']}';
        echo $outp;
    }
    
    function getCustomersJSON()
    {
        //print_r(json_encode($this->M_customers->get_activeCustomers()));
        $lang = array('langs' => $this->session->userdata('lang'));
        
        $data = $this->M_customers->get_activeCustomers();
        
        $outp = "";
        foreach($data as $rs)
        {
            //$tm =  json_decode($rs["teams_id"]);
            //print_r($tm);
            
            if ($outp != "") {$outp .= ",";}
            
            $outp .= '["'  . $rs["id"] . '",';
            $outp .= '"'   . trim($rs["first_name"]). '",';
            $outp .= "\"<a href='".site_url($lang['langs'])."/pos/C_customers/customerDetail/".$rs['id']."'>".$rs['store_name']."</a>\",";
            
            
            if(@$_SESSION['multi_currency'] == 1){
            $outp .= '"'   . $this->M_currencies->get_currencyName($rs['currency_id']). '",';
            }
            
            $outp .= '"'   . trim($rs["address"]). '",';
            
            $outp .= "\"<a href='".site_url($lang['langs'])."/pos/C_customers/edit/".$rs['id']."'><i class='fa fa-pencil-square-o fa-fw'></i> | </a><a href='".site_url($lang['langs'])."/pos/C_customers/inactivate/".$rs['id']."' onclick='return confirm('Are you sure you want to delete?')'; title='Make Inactive'><i class='fa fa-trash-o fa-fw'></i></a>\"]";
             
        }
            
        $outp ='{"data": ['.$outp.']}';
        echo $outp;
    }
}