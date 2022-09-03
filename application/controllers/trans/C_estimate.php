<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_estimate extends MY_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');        
    }
    
    public function index($saleType='',$customer_id='')
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('estimates');
        $data['main'] = lang('estimates');
        
        $data['customer_id'] = $customer_id;
        $data['saleType'] = $saleType;
        //when click on sale manu clear the cart first if exist
        //$this->cart->destroy();
        
        //$data['itemDDL'] = $this->M_items->get_allItemsforJSON();
        $data['customersDDL'] = $this->M_customers->getCustomerDropDown();
        $data['supplier_cust'] = $this->M_suppliers->get_cust_supp();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        $data['taxes'] = $this->M_taxes->get_activetaxes();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/estimate/v_estimate',$data);
        $this->load->view('templates/footer');
    }
    
    public function editestimate($invoice_no)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Edit Estimate';
        $data['main'] = 'Edit Estimate';
        
        $data['saleType'] = '';//$saleType;//CASH, CREDIT, CASH RETURN AND CREDIT RETURN
        $data['invoice_no'] = $invoice_no;
        $data['edit'] = true;
        
        //$data['itemDDL'] = $this->M_items->get_allItemsforJSON();
        $data['customersDDL'] = $this->M_customers->getCustomerDropDown();
        $data['supplier_cust'] = $this->M_suppliers->get_cust_supp();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/estimate/v_editestimateProduct',$data);
        $this->load->view('templates/footer');
    }
    
    //sale the projuct angularjs
    public function saleProducts()
    {
        $total_amount =0;
        $total_cost_amount=0;
        $discount =0;
        $unit_price=0;
        $cost_price=0;
        
        // get posted data
        $data_posted = json_decode(file_get_contents("php://input",true)); 
        
        //print_r($data_posted);
//        echo die;
        
       // print_r($data_posted);
       if(count((array)$data_posted) > 0)
        {
             //GET PREVIOISE INVOICE NO  
           @$prev_invoice_no = $this->M_estimate->getMAXSaleInvoiceNo();
           //$number = (int) substr($prev_invoice_no,11)+1; // EXTRACT THE LAST NO AND INCREMENT BY 1
           //$new_invoice_no = 'POS'.date("Ymd").$number;
           $number = (int) $prev_invoice_no+1; // EXTRACT THE LAST NO AND INCREMENT BY 1
           $new_invoice_no = 'E'.$number;

            $this->db->trans_start();
            
           //GET ALL ACCOUNT CODE WHICH IS TO BE POSTED AMOUNT
            $sale_date = date('Y-m-d',strtotime($data_posted->sale_date));
            $customer_id=$data_posted->customer_id;
            $emp_id=$data_posted->emp_id;
            $supplier_id=$data_posted->supplier_id;
            $posting_type_code = $this->M_customers->getCustomerPostingTypes($customer_id);
            $sale_supp_posting_type_code = $this->M_suppliers->getCustSuppPostingTypes($supplier_id);
            $exchange_rate = ($data_posted->exchange_rate == '' ? 0 : $data_posted->exchange_rate);
            $currency_id = ($data_posted->currency_id == '' ? 0 : $data_posted->currency_id);
            $discount = ($data_posted->discount == '' ? 0 : $data_posted->discount);
            $narration = ($data_posted->description == '' ? '' : $data_posted->description);
            $register_mode=$data_posted->register_mode;
            $total_tax_amount =  $data_posted->total_tax;
            $delivery_date = date('Y-m-d H:m:i',strtotime($data_posted->delivery_date));
            $advance=$data_posted->advance;
            
            //if multi currency is used then multiply $exchange_rate with amount
         
             if(@$_SESSION['multi_currency'] == 1)
             {
                //total net amount 
                $total_amount =  (($data_posted->total_amount-$discount)/$exchange_rate)-$total_tax_amount;
                $total_return_amount =  (($data_posted->total_amount-$discount)/$exchange_rate)-$total_tax_amount;//FOR RETURN PURSPOSE
             }else{
                $total_amount =  ($data_posted->total_amount-$discount)-$total_tax_amount;
                $total_return_amount =  ($data_posted->total_amount-$discount)-$total_tax_amount;//FOR RETURN PURSPOSE
             }
             //////
         
    //if(count($posting_type_code) !== 0 || count($sale_supp_posting_type_code) !== 0)
    //if(count($sale_supp_posting_type_code) !== 0)
    //{
            if($supplier_id)
            {
                $posting_type_code = $sale_supp_posting_type_code;    
            }
            
       $data = array(
            'company_id'=> $_SESSION['company_id'],
            'invoice_no' => $new_invoice_no,
            'customer_id' => $customer_id,
            'supplier_id' => $supplier_id,
            'employee_id'=>$emp_id,
            'user_id'=>$_SESSION['user_id'],
            'sale_date' => $sale_date,
            'register_mode'=>$data_posted->register_mode,
            'account'=>$data_posted->saleType,
            //'amount_due'=>$data_posted->amount_due,
            'description'=>$narration,
            'discount_value'=>$discount,
            'currency_id'=>$currency_id,
            'exchange_rate'=>$exchange_rate,
            'total_amount'=>$total_amount,
            'total_tax'=>$total_tax_amount,
            'delivery_date'=>$delivery_date,
            'advance'=>$advance,
            );
            
        $this->db->insert('pos_estimate', $data);
        
        $sale_id = $this->db->insert_id();
        
        //extract JSON array items from posted data.
        foreach($data_posted->items as $posted_values):
        
        $service = ($posted_values->service == null ? 0 : $posted_values->service);
        
        $data = array(
            'sale_id' => $sale_id,
            'invoice_no' => $new_invoice_no,
            'item_id'=>$posted_values->item_id,
            'description'=>$narration,
            'quantity_sold'=>$posted_values->quantity,//if estimate return then insert amount in negative
            'item_cost_price'=>$posted_values->cost_price,//actually its avg cost comming from sale from
            'item_unit_price'=>$posted_values->unit_price,//if estimate return then insert amount in negative
            'color_id'=>$posted_values->color_id,
            'currency_id'=>$currency_id,
            'exchange_rate'=>$exchange_rate,
            'size_id'=>$posted_values->size_id,
            'unit_id'=>$posted_values->unit_id,
            'company_id'=> $_SESSION['company_id'],
            //'discount_percent'=>($posted_values->discount_percent == null ? 0 : $posted_values->discount_percent),
            'discount_value'=>($posted_values->discount_value == null ? 0 : $posted_values->discount_value),
            'service'=>$service,
            'tax_id'=>$posted_values->tax_id,
            'tax_rate'=>$posted_values->tax_rate,
            );
            
        $this->db->insert('pos_estimate_items', $data);
        
                    //for logging
                    $msg = 'invoice no '. $new_invoice_no;
                    $this->M_logs->add_log($msg,"estimate transaction","created","trans");
                    // end logging
        
        //  $cost_price += ($posted_values->quantity * $posted_values->cost_price);
        //  $unit_price += ($posted_values->quantity * $posted_values->unit_price);
         
        //discount percent if percentage is used
        //$discount += ($posted_values->quantity * $posted_values->unit_price)*$posted_values->discount/100;
              
        endforeach;
        
           $this->db->trans_complete();   
                
           echo '{"invoice_no":"'.$new_invoice_no.'"}'; //redirect to receipt page using this $receiving_id
         
         /////////////////////////////
         //      ACCOUNTS CLOSED ..///
         /////////////////////////////
         
        // }// Posting type  end if 
        // else{
        //     echo '{"invoice_no":"no-posting-type"}';
        // }
        
        }//$data_posted if close
        else{
            echo 'No Data'; 
        }
    }
    
      //sale the projuct angularjs
    public function editSaleProducts()
    {
        if($this->session->userdata('role') != 'admin')
        {
            redirect('No_access','refresh');    
        }

        $total_amount =0;
        $total_cost_amount=0;
        $discount =0;
        $unit_price=0;
        $cost_price=0;
        
        // get posted data
        $data_posted = json_decode(file_get_contents("php://input",true)); 
        
//        print_r($data_posted);
//        echo die;
        
        if(count($data_posted) > 0)
        {
            $this->db->trans_start();
        
           //GET ALL ACCOUNT CODE WHICH IS TO BE POSTED AMOUNT
            $invoice_no=$data_posted->invoice_no;
            $sale_date = date('Y-m-d',strtotime($data_posted->sale_date));
            $delivery_date = date('Y-m-d H:m:i',strtotime($data_posted->delivery_date));
            $advance=$data_posted->advance;
            $customer_id=$data_posted->customer_id;
            $emp_id=$data_posted->emp_id;
            $supplier_id=$data_posted->supplier_id;
            $posting_type_code = $this->M_customers->getCustomerPostingTypes($customer_id);
            $sale_supp_posting_type_code = $this->M_suppliers->getCustSuppPostingTypes($supplier_id);
            $exchange_rate = ($data_posted->exchange_rate == '' ? 0 : $data_posted->exchange_rate);
            $currency_id = ($data_posted->currency_id == '' ? 0 : $data_posted->currency_id);
            $discount = ($data_posted->discount == '' ? 0 : $data_posted->discount);
            $narration = ($data_posted->description == '' ? '' : $data_posted->description);
            $total_tax_amount =  $data_posted->total_tax;
            //if multi currency is used then multiply $exchange_rate with amount
         
             if(@$_SESSION['multi_currency'] == 1)
             {
                //total net amount 
                $total_amount =  (($data_posted->total_amount-$discount)/$exchange_rate)-$total_tax_amount;
                $total_return_amount =  (($data_posted->total_amount-$discount)/$exchange_rate)-$total_tax_amount;//FOR RETURN PURSPOSE
             }else{
                $total_amount =  ($data_posted->total_amount-$discount)-$total_tax_amount;
                $total_return_amount =  ($data_posted->total_amount-$discount)-$total_tax_amount;//FOR RETURN PURSPOSE
             }
         //////
         
    if(count($posting_type_code) !== 0 || count($sale_supp_posting_type_code) !== 0)
    //if(count($sale_supp_posting_type_code) !== 0)
    {
           if($supplier_id)
            {
                $posting_type_code = $sale_supp_posting_type_code;    
            }
            
         //DELETE ALS estimate AND ITEMS AND ACCOUNT ENTRY AGAINST INVOICE NO
        //AND THEN INSERT NEW ENTRIES.
        $this->delete($invoice_no,false);
        //////
        
       $data = array(
            'company_id'=> $_SESSION['company_id'],
            'invoice_no' => $invoice_no,
            'customer_id' => $customer_id,
            'supplier_id' => $supplier_id,
            'employee_id'=>$emp_id,
            'user_id'=>$_SESSION['user_id'],
            'sale_date' => $sale_date,
            'register_mode'=>$data_posted->register_mode,
            'account'=>$data_posted->saleType,
            //'amount_due'=>$data_posted->amount_due,
            'description'=>$narration,
            'discount_value'=>$discount,
            'currency_id'=>$currency_id,
            'exchange_rate'=>$exchange_rate,
            'total_amount'=>$total_amount,
            'total_tax'=>$total_tax_amount,
            'delivery_date'=>$delivery_date,
            'advance'=>$advance,
            );
            
        $this->db->insert('pos_estimate', $data);
        
        $sale_id = $this->db->insert_id();
        
        //extract JSON array items from posted data.
        foreach($data_posted->items as $posted_values):
        
        $service = ($posted_values->service == null ? 0 : $posted_values->service);
        
        $data = array(
            'sale_id' => $sale_id,
            'invoice_no' => $invoice_no,
            'item_id'=>$posted_values->item_id,
            'description'=>'',
            'quantity_sold'=>$posted_values->quantity,
            'item_cost_price'=>$posted_values->cost_price,//actually its avg cost comming from sale from
            'item_unit_price'=>$posted_values->unit_price,
            'currency_id'=>$currency_id,
            'exchange_rate'=>$exchange_rate,
            'size_id'=>$posted_values->size_id,
            'company_id'=> $_SESSION['company_id'],
            //'discount_percent'=>($posted_values->discount_percent == null ? 0 : $posted_values->discount_percent),
            'discount_value'=>($posted_values->discount_value == null ? 0 : $posted_values->discount_value),
            'service'=>$service,
            'tax_id'=>$posted_values->tax_id,
            'tax_rate'=>$posted_values->tax_rate,
            );
            
        $this->db->insert('pos_estimate_items', $data);
        
                    //for logging
                    $msg = 'invoice no '. $invoice_no;
                    $this->M_logs->add_log($msg,"sale transaction","created","trans");
                    // end logging
                    
        //CHECK SERVICE IF SERVICE THEN DO NOT UPDATE QTY
        if($service !== 1)
        {
            if($this->M_items->checkItemOptions($posted_values->item_id,0,$posted_values->size_id))
            {
                $total_stock =  $this->M_items->total_stock($posted_values->item_id,0,$posted_values->size_id);
                        
                        //if products is to be return then it will add from qty and the avg cost will be reverse to original cost
                        if($data_posted->register_mode == 'return')
                         {
                            $quantity = ($total_stock + $posted_values->quantity);
                         }else { 
                            $quantity=($total_stock - $posted_values->quantity); 
                            }
                 
                $option_data = array(
                'quantity'=>$quantity
                );
              $this->db->update('pos_items_detail',$option_data,array('size_id'=>$posted_values->size_id,'item_id'=>$posted_values->item_id));
         
            }
        }
        
        
         //ADD ITEM DETAIL IN INVENTORY TABLE    
          $data1= array(
            'trans_item'=>$posted_values->item_id,
            'trans_comment'=>'KSPOS',
            'trans_inventory' => -$posted_values->quantity,
            'company_id'=> $_SESSION['company_id'],
            'trans_user'=>$_SESSION['user_id'],
            'invoice_no' => $invoice_no,
            'cost_price'=>$posted_values->cost_price,//actually its avg cost comming from sale from
            'unit_price'=>$posted_values->unit_price,
            
            );
            
          $this->db->insert('pos_inventory', $data1);
          //////////////
         
         $cost_price += ($posted_values->quantity * $posted_values->cost_price);
         $unit_price += ($posted_values->quantity * $posted_values->unit_price);
         
         //discount percent if percentage is used
         //$discount += ($posted_values->quantity * $posted_values->unit_price)*$posted_values->discount/100;
              
        endforeach;
        
        $service = $service; //again assing service to new variable bcuz of loop end 
        
        //if multi currency is used then multiply $exchange_rate with amount
         if(@$_SESSION['multi_currency'] == 1)
         {
            //Total Cost amount
            $total_cost_amount =  round(($cost_price)/$exchange_rate,2);
        
         }else{
            //Total Cost amount
            $total_cost_amount =  round(($cost_price),2);
         }
        
        //////////////////////////////////
        ////   ACCOUNT TRANSACTIONS  /////
        /////////////////////////////////
        
        //  Cash Debit and estimate Credit
        if($data_posted->saleType == 'cash' && $data_posted->register_mode == 'sale')
            {
                //Search for estimate and cash ledger account for account entry
                //if invoice is cash then entry will be cash debit and estimate credit and vice versa
                $dr_ledger_id = $posting_type_code[0]['cash_acc_code'];
                $cr_ledger_id = $posting_type_code[0]['estimate_acc_code'];
                
                $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$invoice_no,$sale_date);
                ////////////////
                
                ///////////////
                //TAX JOURNAL ENTRY
                if($total_tax_amount > 0){
                    $tax_dr_ledger_id = $posting_type_code[0]['cash_acc_code'];
                    $tax_cr_ledger_id = $posting_type_code[0]['estimatetax_acc_code'];
                
                    $this->M_entries->addEntries($tax_dr_ledger_id,$tax_cr_ledger_id,$total_tax_amount,$total_tax_amount,ucwords($narration),$invoice_no,$sale_date);
                }
                    ////////////////
                
                if($service !== 1)
                {
                    //INVENTORY WILL BE DEDUCTED(CREDITED) AND COST OF SALE WILL BE DEBITED
                    /////////////////
                    $inventory_dr_ledger_id = $posting_type_code[0]['cos_acc_code'];
                    $inventory_cr_ledger_id = $posting_type_code[0]['inventory_acc_code'];
                    //////////////
                   $this->M_entries->addEntries($inventory_dr_ledger_id,$inventory_cr_ledger_id,$total_cost_amount,$total_cost_amount,ucwords($narration),$invoice_no,$sale_date);
                }
             
            }
            
            //if estimate is on credit 
            //  AR - Customer Debit and estimate Credit
         elseif($data_posted->saleType == 'credit' && $data_posted->register_mode == 'sale')
         {
                //Search for purchases and cash ledger account for account entry
                //if invoice is cash then entry will be purchase debit and cash credit and vice versa
                $dr_ledger_id = $posting_type_code[0]['receivable_acc_code'];
                $cr_ledger_id = $posting_type_code[0]['estimate_acc_code'];
                
                if($service !== 1)
                {
                    ////////////////
                    //INVENTORY WILL BE DEDUCTED(CREDITED) AND COST OF SALE WILL BE DEBITED
                    $inventory_dr_ledger_id = $posting_type_code[0]['cos_acc_code'];
                    $inventory_cr_ledger_id = $posting_type_code[0]['inventory_acc_code'];  
                    
                    $this->M_entries->addEntries($inventory_dr_ledger_id,$inventory_cr_ledger_id,$total_cost_amount,$total_cost_amount,ucwords($narration),$invoice_no,$sale_date);  
                }
               
               //for cusmoter payment table
               if($supplier_id)
               {
                //JOURNAL ENTRY
               $entry_id = $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$invoice_no,$sale_date);
                
                //SUPPLIER PAYMENT ENTRY
                $this->M_suppliers->addsupplierPaymentEntry($dr_ledger_id,$cr_ledger_id,$total_amount,0,$supplier_id,$narration,$invoice_no,$sale_date,$exchange_rate,$entry_id);
                   
                    /////////////////
                    //REDUCE THE TOTAL AMOUNT IN RECEINVING TO SHOW EXACT AMOUNT IN OUTSTANDING INVOICES
                    $credit_purchase = $this->M_receivings->get_creditPurchases($supplier_id);
                    foreach($credit_purchase as $values){
                        $prev_bal = $values['paid'];
                        $cur_amount = $total_return_amount;//current amount
                        
                        if($cur_amount > $prev_bal)
                        {
                            $cur_amount = $total_return_amount;
                        }
                        else if($cur_amount < $prev_bal)
                        {
                            $cur_amount = $prev_bal;
                        }
                    
                        $data = array(
                        'paid' => ($cur_amount+$total_return_amount),
                        );
                
                        //$this->db->update('pos_receivings',$data,array('invoice_no'=>$values['invoice_no']));
                        $this->M_receivings->updatePaidAmount($values['invoice_no'],$data);
                
                        $cur_amount = ($total_return_amount+$prev_bal);
                        
                        if($cur_amount > 0)
                        {
                            $total_return_amount = $cur_amount;
                        }
                        else{
                            $total_return_amount = 0;
                        }
                    }
                    ///////////////
               }
               else{
                
                //JOURNAL ENTRY
                $entry_id=$this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$invoice_no,$sale_date);
                
                //CUSTOMER PAYMENT ENTRY
                $this->M_customers->addCustomerPaymentEntry($dr_ledger_id,$cr_ledger_id,$total_amount,0,$customer_id,$narration,$invoice_no,$sale_date,$exchange_rate,$entry_id);
                
                ///////////////
                //TAX JOURNAL ENTRY
                if($total_tax_amount > 0)
                {
                    $tax_dr_ledger_id = $posting_type_code[0]['receivable_acc_code'];
                    $tax_cr_ledger_id = $posting_type_code[0]['estimatetax_acc_code'];
                    
                    $this->M_entries->addEntries($tax_dr_ledger_id,$tax_cr_ledger_id,$total_tax_amount,$total_tax_amount,ucwords($narration),$invoice_no,$sale_date);
                    
                    //CUSTOMER estimate TAX PAYMENT ENTRY
                    $this->M_customers->addCustomerPaymentEntry($tax_dr_ledger_id,$tax_cr_ledger_id,$total_tax_amount,0,$customer_id,$narration,$invoice_no,$sale_date,$exchange_rate,$entry_id);
                    //////////////// tax
                }               
               }
               
               ///
         }
         //estimate RETURN DEBITED AND
         elseif($data_posted->saleType == 'cash' && $data_posted->register_mode == 'return')
         {
            //Search for estimate return and cash ledger account for account entry
            //if invoice is cash then entry will be estimate return debit and cash credit and vice versa
                $dr_ledger_id = $posting_type_code[0]['estimatereturn_acc_code'];
                $cr_ledger_id = $posting_type_code[0]['cash_acc_code'];
                
                //JOURNAL ENTRY
                $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$invoice_no,$sale_date);
                
                ///////////////
                //TAX REVERSE JOURNAL ENTRY
                if($total_tax_amount > 0)
                {
                    $tax_dr_ledger_id = $posting_type_code[0]['estimatetax_acc_code'];
                    $tax_cr_ledger_id = $posting_type_code[0]['cash_acc_code'];
                    
                    $this->M_entries->addEntries($tax_dr_ledger_id,$tax_cr_ledger_id,$total_tax_amount,$total_tax_amount,ucwords($narration),$invoice_no,$sale_date);
                }
                    ////////////////
                
                ////////////////
                //INVENTORY WILL BE DEDUCTED(CREDITED) AND COST OF SALE WILL BE DEBITED
                if($service !== 1)
                {
                    $inventory_cr_ledger_id = $posting_type_code[0]['cos_acc_code'];
                    $inventory_dr_ledger_id = $posting_type_code[0]['inventory_acc_code']; 
                    
                    $this->M_entries->addEntries($inventory_dr_ledger_id,$inventory_cr_ledger_id,$total_cost_amount,$total_cost_amount,ucwords($narration),$invoice_no,$sale_date);
                }
                
         }
         ////estimate RETURN DEBITED AND
         elseif($data_posted->saleType == 'credit' && $data_posted->register_mode == 'return')
         {
            //Search for estimate return and cash ledger account for account entry
            //if invoice is cash then entry will be estimate return debit and cash credit and vice versa
            
             $dr_ledger_id = $posting_type_code[0]['estimatereturn_acc_code'];
             $cr_ledger_id = $posting_type_code[0]['receivable_acc_code'];
             
                ////////////////
               if($service !== 1)
                {
                    //INVENTORY WILL BE DEDUCTED(CREDITED) AND COST OF SALE WILL BE DEBITED
                    $inventory_cr_ledger_id = $posting_type_code[0]['cos_acc_code'];
                    $inventory_dr_ledger_id = $posting_type_code[0]['inventory_acc_code']; 
                    
                    $this->M_entries->addEntries($inventory_dr_ledger_id,$inventory_cr_ledger_id,$total_cost_amount,$total_cost_amount,ucwords($narration),$invoice_no,$sale_date);
                }
               
               //for cusmoter payment table
               if($supplier_id)
               {
                //JOURNAL ENTRY
                $entry_id=$this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$invoice_no,$sale_date);
                
                $this->M_suppliers->addsupplierPaymentEntry($cr_ledger_id,$dr_ledger_id,0,$total_amount,$supplier_id,$narration,$invoice_no,$sale_date,$exchange_rate,$entry_id);
                
                    /////////////////
                    //REDUCE THE PAID AMOUNT IN RECEINVING TO SHOW EXACT AMOUNT IN OUTSTANDING INVOICES
                    $credit_purchase = $this->M_receivings->get_creditPurchases($supplier_id);
                    foreach($credit_purchase as $values){
                        $prev_bal = $values['paid'];
                        $cur_amount = $total_return_amount;
                        
                        if($cur_amount > $prev_bal)
                        {
                            $cur_amount = $prev_bal;
                        }
                        else if($cur_amount < $prev_bal)
                        {
                            $cur_amount = $total_return_amount;
                        }
                    
                        $data = array(
                        'paid' => ($prev_bal-$cur_amount),
                        );
                
                        $this->db->update('pos_receivings',$data,array('invoice_no'=>$values['invoice_no']));
                        
                        $cur_amount = ($total_return_amount-$prev_bal);
                        
                        if($cur_amount > 0)
                        {
                            $total_return_amount = $cur_amount;
                        }
                        else{
                            $total_return_amount = 0;
                        }
                    }
                    ///////////////
               }//supplier end
               else{
                //JOURNAL ENTRY
                $entry_id=$this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$invoice_no,$sale_date);
                
                //customer entry
                $this->M_customers->addCustomerPaymentEntry($cr_ledger_id,$dr_ledger_id,0,$total_amount,$customer_id,$narration,$invoice_no,$sale_date,$exchange_rate,$entry_id);
                
                 ///////////////
                //TAX REVERSE JOURNAL ENTRY
                if($total_tax_amount > 0)
                {
                    $tax_dr_ledger_id = $posting_type_code[0]['estimatetax_acc_code'];
                    $tax_cr_ledger_id = $posting_type_code[0]['cash_acc_code'];
                    
                    $this->M_entries->addEntries($tax_dr_ledger_id,$tax_cr_ledger_id,$total_tax_amount,$total_tax_amount,ucwords($narration),$invoice_no,$sale_date);
                    
                    //CUSTOMER estimate TAX PAYMENT ENTRY
                    $this->M_customers->addCustomerPaymentEntry($tax_cr_ledger_id,$tax_dr_ledger_id,0,$total_tax_amount,$customer_id,$narration,$invoice_no,$sale_date,$exchange_rate,$entry_id);
                }
                    ////////////////
                    //tax end
                
                     /////////////////
                    //REDUCE THE TOTAL AMOUNT IN estimate TO SHOW EXACT AMOUNT IN OUTSTANDING INVOICES
                    $creditestimate = $this->M_estimate->get_creditestimate($customer_id);
                        foreach($creditestimate as $values){
                        $prev_bal = $values['total_amount'];
                        $cur_amount = $total_return_amount;
                        
                        if($cur_amount > $prev_bal)
                        {
                            $cur_amount = $prev_bal;
                        }
                        else if($cur_amount < $prev_bal)
                        {
                            $cur_amount = $total_return_amount;
                        }
                    
                        $data = array(
                        'total_amount' => ($prev_bal-$cur_amount),
                        );
                
                        $this->db->update('pos_estimate',$data,array('invoice_no'=>$values['invoice_no']));
                        
                        $cur_amount = ($total_return_amount-$prev_bal);
                        
                        if($cur_amount > 0)
                        {
                            $total_return_amount = $cur_amount;
                        }
                        else{
                            $total_return_amount = 0;
                        }
                    }
                    ///////////////
               }//customer end
               
                    
         }
                     //IF DISCOUNT PAID
                    // estimate DICOUNT DEBIT AND estimate CREDIT
                    if($data_posted->register_mode == 'sale')
                    {
                        if($discount != 0)
                        {
                        
                        $dr_ledger_discount_id = $posting_type_code[0]['estimatedis_acc_code'];
                        //journal entries 
                        // estimate DICOUNT DEBIT AND estimate CREDIT
                        $this->M_entries->addEntries($dr_ledger_discount_id,$cr_ledger_id,$discount,$discount,$narration,$invoice_no,$sale_date);
                        }
                    }
                    elseif($data_posted->register_mode == 'return')
                    {
                        if($discount != 0)
                        {
                        
                        $cr_ledger_discount_id = $posting_type_code[0]['estimatedis_acc_code'];
                        //journal entries 
                        // estimate DICOUNT CREDIT AND estimate OR A/C RECEIVABLE DEBITED
                        $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_discount_id,$discount,$discount,$narration,$invoice_no,$sale_date);
                        }
                    }
              
               echo '{"invoice_no":"'.$invoice_no.'"}'; //redirect to receipt page using this $receiving_id
         
         $this->db->trans_complete();   
         
         /////////////////////////////
         //      ACCOUNTS CLOSED ..///
         /////////////////////////////
         
        }// Posting type  end if 
        else{
            echo '{"invoice_no":"no-posting-type"}';
        }
        
        }//$data_posted if close
        else{
            echo 'No Data'; 
        }
    }
    public function receipt($new_invoice_no)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        $data['estimate_items'] = $this->M_estimate->get_estimate_items($new_invoice_no);
        $estimate_items = $data['estimate_items'];
        
        //////////////////////////////
        // QR Code
        $this->load->library('ciqrcode');
        ///////////////////////

        $data['title'] = strtoupper($estimate_items[0]['register_mode']).' #'.$new_invoice_no;
        $data['main'] = '';//($estimate_items[0]['register_mode'] == 'sale' ? 'estimate' : 'Return').' Invoice #'.$new_invoice_no;
        $data['invoice_no'] = $new_invoice_no;
        
        $company_id = $_SESSION['company_id'];
        $data['Company'] = $this->M_companies->get_companies($company_id);
            
        $this->load->view('templates/header',$data);
        $this->load->view('pos/estimate/v_receipt_small',$data);
        //$this->load->view('pos/estimate/v_receipt',$data);
        $this->load->view('templates/footer');
    }
    
    public function allestimate()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('estimates');
        $data['main'] = lang('estimates');
        
        $start_date = FY_START_DATE;  //date("Y-m-d", strtotime("last month"));
        $to_date = FY_END_DATE; //date("Y-m-d");
        
        $data['main_small'] = "(From:".date('d-m-Y',strtotime($start_date)) ." To:" .date('d-m-Y',strtotime($to_date)).")";
        
        $data['estimate'] = $this->M_estimate->get_estimate(false,$start_date,$to_date);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/estimate/v_allestimate',$data);
        $this->load->view('templates/footer');
    }
    
    function get_estimate_JSON()
    {
        $start_date = FY_START_DATE;  //date("Y-m-d", strtotime("last year"));
        $to_date = FY_END_DATE; //date("Y-m-d");
        
        print_r(json_encode($this->M_estimate->get_selected_estimate($start_date,$to_date)));
    }
    
    public function getCustomerCurrencyJSON($customer_id)
    {
        $customersCurrency = $this->M_customers->get_customerCurrency($customer_id);
        echo json_encode($customersCurrency);
    }
    
    public function delete($invoice_no,$redirect = true)
    {
        if($this->session->userdata('role') != 'admin')
        {
            redirect('No_access','refresh');    
        }

        $this->db->trans_start();
          
        $this->M_estimate->delete($invoice_no);
        $this->db->trans_complete();   
        
        if($redirect === true)
        {
            $this->session->set_flashdata('message','Entry Deleted');
            redirect('trans/C_estimate/allestimate','refresh');
        }
        
    }
    
    function getEstimateItemsJSON($invoice_no)
    {
        $data = $this->M_estimate->get_estimate_items($invoice_no);
        
        $outp = "";
        foreach($data as $rs)
        {
            //$tm =  json_decode($rs["teams_id"]);
            //print_r($tm);
            
            if ($outp != "") {$outp .= ",";}
            
            $outp .= '{"item_id":"'  . $rs["item_id"] . '",';
            $outp .= '"size_id":"'   . $rs["size_id"]. '",';
            $outp .= '"unit_id":"'   . $rs["unit_id"]. '",';
            $outp .= '"item_cost_price":"'   . $rs["item_cost_price"]. '",';
            $outp .= '"item_unit_price":"'   . $rs["item_unit_price"]. '",';
            $outp .= '"quantity_sold":"'   . $rs["quantity_sold"]. '",';
            $outp .= '"discount_percent":"'   . $rs["discount_percent"]. '",';
            $outp .= '"discount_value":"'   . $rs["discount_value"]. '",';
            $outp .= '"sale_date":"'   . $rs["sale_date"]. '",';
            $outp .= '"register_mode":"'   . $rs["register_mode"]. '",';
            $outp .= '"discount_value":"'   . $rs["discount_value"]. '",';
            $outp .= '"customer_id":"'   . $rs["customer_id"]. '",';
            $outp .= '"employee_id":"'   . $rs["employee_id"]. '",';
            $outp .= '"description":"'   . $rs["description"]. '",';
            $outp .= '"account":"'   . $rs["account"]. '",';
            $outp .= '"tax_id":"'   . $rs["tax_id"]. '",';
            $outp .= '"tax_rate":"'   . $rs["tax_rate"]. '",';
            $outp .= '"tax_name":"",';
            $outp .= '"inventory_acc_code":"",';
            
            $outp .= '"exchange_rate":"'   . $rs["exchange_rate"]. '",';
            $outp .= '"currency_id":"'   . $rs["currency_id"]. '",';
            $outp .= '"service":"'   . $rs["service"]. '",';
            
            $item_name = $this->M_items->get_ItemName($rs["item_id"]);
            $outp .= '"name":"'   . @$item_name . '",';
            
            $size_name = $this->M_sizes->get_sizeName($rs["size_id"]);
            $outp .= '"size":"'   . @$size_name . '",';
            
            $outp .= '"invoice_no":"'. $rs["invoice_no"]     . '"}'; 
        }
            
        $outp ='['.$outp.']';
        echo $outp;
    }
}