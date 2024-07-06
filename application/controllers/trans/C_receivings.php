<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_receivings extends MY_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    public function index($purchaseType = '')
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        //$this->output->enable_profiler();
        
        $data['title'] = ucfirst($purchaseType). ' '.lang('purchases');
        $data['main'] = ucfirst($purchaseType).' '.lang('purchases');
        
        $data['purchaseType'] = $purchaseType;
        //when click on sale manu clear the cart first if exist
        //$this->destroyCart();
        
        //$data['itemDDL'] = $this->M_items->getItemDropDown();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        //$data['sizesDDL'] = $this->M_sizes->get_activeSizesDDL();
        $data['supplierDDL'] = $this->M_suppliers->getSupplierDropDown();//search for legder account
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/receivings/v_purchases',$data);
        $this->load->view('templates/footer');
    }
    
    public function purchase_return($invoice_no)
    {
        $data = array('langs' => $this->session->userdata('lang'));

        $data['title'] = lang('return') . ' ' . lang('purchases'). ' INV # '. $invoice_no;
        $data['main'] = lang('return') . ' ' . lang('purchases'). ' INV # '. $invoice_no;

        $data['purchaseType'] = ''; //$saleType;//CASH, CREDIT, CASH RETURN AND CREDIT RETURN
        $data['invoice_no'] = $invoice_no;
        $data['edit'] = true;
        //$data['isEstimate'] = $isEstimate;

        //$data['itemDDL'] = $this->M_items->get_allItemsforJSON();
        $data['supplierDDL'] = $this->M_suppliers->getSupplierDropDown();//search for legder account
        //$data['supplier_cust'] = $this->M_suppliers->get_cust_supp();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();

        $this->load->view('templates/header', $data);
        $this->load->view('pos/receivings/v_return_purchases', $data);
        $this->load->view('templates/footer');
    }

    public function upload_purchase_file($invoice_no)
    { 
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            $config['upload_path']  = './images/purchases/';
            $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            // $this->upload->do_upload('purchase_file');
            // $uploaddata = $this->upload->data();
            
            if ( ! $this->upload->do_upload('purchase_file'))
                {
                        echo $this->upload->display_errors();
                }
                else
                {
                        $upload_data = $this->upload->data();

                        $data = array(
                            'file' => $upload_data['file_name'],
                           );
                        
                        echo $this->db->update('pos_receivings',$data,array('invoice_no'=>$invoice_no));
                }
            
        }
        else {
            
            $data = array('langs' => $this->session->userdata('lang'));

            $data['title'] = 'Purchase file';
            $data['main'] = 'Purchase file';
            $data['invoice_no'] = $invoice_no;

            $this->load->view('templates/header',$data);
            $this->load->view('pos/receivings/v_purchase_file',$data);
            $this->load->view('templates/footer');
        }
    }
    //purchase the projuct angularjs
    public function purchaseProducts()
    {
        //INITIALIZE
        $total_amount =0;
        $discount =0;
        $amount=0;
        
        // get posted data from angularjs purchases 
        $data_posted = json_decode(file_get_contents("php://input",true)); 
        //print_r($data_posted);
        
            //GET PREVIOISE INVOICE NO  
           @$prev_invoice_no = $this->M_receivings->getMAXPurchaseInvoiceNo();
           //$number = (int) substr($prev_invoice_no,11)+1; // EXTRACT THE LAST NO AND INCREMENT BY 1
           //$new_invoice_no = 'REC'.date("Ymd").$number;
           $number = (int) substr($prev_invoice_no,1)+1; // EXTRACT THE LAST NO AND INCREMENT BY 1
           $new_invoice_no = 'R'.$number;
           
        if(count((array)$data_posted) > 0)
        { 
            $this->db->trans_complete();  
            
            $narration = ($data_posted->description == '' ? '' : $data_posted->description);
            $sale_date = date('Y-m-d',strtotime($data_posted->sale_date));
            $discount = ($data_posted->discount == '' ? 0 : $data_posted->discount);
            $exchange_rate = ($data_posted->exchange_rate == '' ? 0 : $data_posted->exchange_rate);
            $currency_id = ($data_posted->currency_id == '' ? 0 : $data_posted->currency_id);
            $emp_id=$data_posted->emp_id;
            $total_tax_amount =  $data_posted->total_tax;
            $register_mode=$data_posted->register_mode;
            $narration = $data_posted->description;
        
            //GET ALL ACCOUNT CODE WHICH IS TO BE POSTED AMOUNT
            $supplier_id =$data_posted->supplier_id;
            $posting_type_code = $this->M_suppliers->getSupplierPostingTypes($supplier_id);
            
            //if multi currency is used then multiply $exchange_rate with amount
             if(@$_SESSION['multi_currency'] == 1)
             {
                //total net amount 
                $total_amount =  round(($data_posted->total_amount-$discount)/$exchange_rate,2)-$total_tax_amount;
                $total_return_amount =  round(($data_posted->total_amount-$discount)/$exchange_rate,2)-$total_tax_amount;//FOR RETURN PURSPOSE
             }else{
                $total_amount =  round(($data_posted->total_amount-$discount),2)-$total_tax_amount;
                $total_return_amount =  round(($data_posted->total_amount-$discount),2)-$total_tax_amount;//FOR RETURN PURSPOSE
             }
            /////
        
        if(count($posting_type_code) !== 0)
        {
         $data = array(
            'company_id'=> $_SESSION['company_id'],
            'invoice_no' => $new_invoice_no,
            'supplier_id' => $data_posted->supplier_id,
            'supplier_invoice_no' => $data_posted->supplier_invoice_no,
            'employee_id'=>$emp_id,
            'user_id'=>$_SESSION['user_id'],
            'receiving_date' => $sale_date,
            'receiving_time' => $sale_date . ' ' . date("H:i:s"),
            'register_mode'=>$data_posted->register_mode,
            'account'=>$data_posted->purchaseType,
            'amount_due'=>$data_posted->amount_due,
            'description'=>$narration,
            'discount_value'=>($register_mode == 'receive' ? $discount : -$discount),
            'currency_id'=>$currency_id,
            'exchange_rate'=>$exchange_rate,
            'total_amount'=>($register_mode == 'receive' ? $total_amount : -$total_amount),
            'total_tax'=>($register_mode == 'receive' ? $total_tax_amount : -$total_tax_amount),
            );
            
        $this->db->insert('pos_receivings', $data);
        
        $receiving_id = $this->db->insert_id();
        
        $inventory_acc_code = array();
        //extract JSON array items from posted data.
        foreach($data_posted->items as $posted_values):
        
            $service = ($posted_values->service == null ? 0 : $posted_values->service);
            //$posted_exp_date = strftime('%Y-%m-%d', strtotime($posted_values->expiry_date));//get only date remove time
            
            //insert in receivings items
            $data = array(
                'receiving_id'=>$receiving_id,
                'invoice_no' => $new_invoice_no,
                'item_id'=>$posted_values->item_id,
                'quantity_purchased'=>($register_mode == 'receive' ? $posted_values->quantity : -$posted_values->quantity),//if purchase return then insert amount in negative
                'item_cost_price'=>($register_mode == 'receive' ? $posted_values->cost_price : -$posted_values->cost_price),//actually its avg cost comming from sale from
                'item_unit_price'=>($register_mode == 'receive' ? $posted_values->unit_price : -$posted_values->unit_price),//if purchase return then insert amount in negative
                //'discount_percent'=>$posted_values->discount,
                'color_id'=>0,
                'size_id'=>0,
                'company_id'=> $_SESSION['company_id'],
                'unit_id'=>$posted_values->unit_id,
                'tax_id'=>$posted_values->tax_id,
                'tax_rate'=>$posted_values->tax_rate,
                'service'=>$service,
            );
                
            $this->db->insert('pos_receivings_items', $data);
            // receiving itmes
            
                    //for logging
                    $msg = 'invoice no '. $new_invoice_no;
                    $this->M_logs->add_log($msg,"purchase transaction","created","trans");
                    // end logging
                    
            //insert items details
            //if items already exist according to expiry then update qty.
            if($this->M_items->checkItemOptions($posted_values->item_id,0,0))
            {
                $total_stock =  $this->M_items->total_stock($posted_values->item_id,0,0);
                        
                        //if products is to be return then it will subtract from qty and the avg cost will be reverse to original cost
                        if($service != 1)
                        {
                            if($data_posted->register_mode == 'return')
                            {
                                $quantity = ($total_stock - $posted_values->quantity);
                                $avg_cost = $this->M_items->getAvgCost($posted_values->item_id,$posted_values->cost_price,$posted_values->quantity,0,0,'return');//calculate avg cost
                            }else {
                                $quantity=($total_stock + $posted_values->quantity); 
                                $avg_cost = $this->M_items->getAvgCost($posted_values->item_id,$posted_values->cost_price,$posted_values->quantity,0,0,$data_posted->register_mode);//calculate avg cost
                            }

                        }else{
                            $quantity = 0;
                        }
                        
                $option_data = array(
                'quantity'=>$quantity,
                'unit_price' =>$posted_values->unit_price,
                'avg_cost'=>$avg_cost,
                 
                );
              $this->db->update('pos_items_detail',$option_data,array('item_id'=>$posted_values->item_id));
         
            }
            //item details
            
            //insert item info into inventory table
            $data1= array(
                
                'trans_item'=>$posted_values->item_id,
                'trans_comment'=>'Purchase '.$register_mode,
                'company_id'=> $_SESSION['company_id'],
                'trans_user'=>$_SESSION['user_id'],
                'invoice_no' => $new_invoice_no,
                'trans_inventory'=>($register_mode == 'receive' ? $posted_values->quantity : -$posted_values->quantity),//if purchase return then insert amount in negative
                'cost_price'=>($register_mode == 'receive' ? $posted_values->cost_price : -$posted_values->cost_price),//actually its avg cost comming from sale from
                'unit_price'=>($register_mode == 'receive' ? $posted_values->unit_price : -$posted_values->unit_price),//if purchase return then insert amount in negative
                
                );
                
            $this->db->insert('pos_inventory', $data1);
            //insert item info into inventory table  
            
            $amount += ($posted_values->quantity * $posted_values->cost_price);
                
            //ADD INVENTORY AMOUNT WHICH IS SELECTED IN ITEM
            @$inventory_acc_code[$posted_values->inventory_acc_code] += $posted_values->cost_price;
          
          
        endforeach;
        
        //total net amount 
        //$total_amount =  round(($amount-$discount)-$data_posted->amount_due,2);
        
        /////////////////////////////////
        ////   ACCOUNT TRANSACTIONS  /////
        /////////////////////////////////       
                
        // inventory DEBIT AND
        // CASH CREDITED
        if($data_posted->purchaseType == 'cash' && $data_posted->register_mode == 'receive')
            {
                //Search for inventory and cash ledger account for account entry
                //if invoice is cash then entry will be purchase debit and cash credit and vice versa
                foreach ($inventory_acc_code as $inventory_code => $amount) {
                   
                    $dr_ledger_id = $inventory_code;
                    $cr_ledger_id = $posting_type_code[0]['cash_acc_code'];
                
                    $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$new_invoice_no,$sale_date);
                }

                // $dr_ledger_id = $posting_type_code[0]['inventory_acc_code'];
                // $cr_ledger_id = $posting_type_code[0]['cash_acc_code'];
            
                // $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$new_invoice_no,$sale_date);
                
                // $dr_ledger_id = $posting_type_code[0]['inventory_acc_code'];
                // $cr_ledger_id = $posting_type_code[0]['cash_acc_code'];
            
                // $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$new_invoice_no,$sale_date);
                
                    ///////////////
                    //TAX JOURNAL ENTRY
                    if($total_tax_amount > 0){
                        $tax_dr_ledger_id = $posting_type_code[0]['salestax_acc_code'];
                        $tax_cr_ledger_id = $posting_type_code[0]['cash_acc_code'];
                        
                        $this->M_entries->addEntries($tax_dr_ledger_id,$tax_cr_ledger_id,$total_tax_amount,$total_tax_amount,ucwords($narration),$new_invoice_no,$sale_date);
                    
                    }
                    ////////////////

                //////////////
                // AMOUNT DUE//
               // if($data_posted->amount_due > 0)
//                {
//                    $this->M_entries->addEntries($dr_ledger_id,$posting_type_code[0]['payable_acc_code'],$data_posted->amount_due,$data_posted->amount_due,$data_posted->description,$new_invoice_no,$sale_date);
//                    //for cusmoter payment table
//                    $this->M_suppliers->addsupplierPaymentEntry($posting_type_code[0]['payable_acc_code'],$dr_ledger_id,0,$data_posted->amount_due,$supplier_id,$narration,$new_invoice_no,$sale_date);
//                    ///
//                }
                ////////////
                //END AMOUNT DUE
            }
            
        //inventory DEBITED AND 
        //ACOUNT PAYABLE SUPPLIER ID IS CREDITED
         elseif($data_posted->purchaseType == 'credit' && $data_posted->register_mode == 'receive')
         {
            //Search for inventory and cash ledger account for account entry
            //if invoice is cash then entry will be purchase debit and cash credit and vice versa
            foreach ($inventory_acc_code as $inventory_code => $amount) {
                   
                $dr_ledger_id = $inventory_code;
                $cr_ledger_id = $posting_type_code[0]['payable_acc_code'];
            
                $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$new_invoice_no,$sale_date);
            }

            // $dr_ledger_id = $posting_type_code[0]['inventory_acc_code'];
            // $cr_ledger_id = $posting_type_code[0]['payable_acc_code'];
            // $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$new_invoice_no,$sale_date);
                 
                ///////////////
                //TAX JOURNAL ENTRY
                if($total_tax_amount > 0)
                {
                    $tax_dr_ledger_id = $posting_type_code[0]['salestax_acc_code'];
                    $tax_cr_ledger_id = $posting_type_code[0]['payable_acc_code'];
                    
                    $entry_id_tax = $this->M_entries->addEntries($tax_dr_ledger_id,$tax_cr_ledger_id,$total_tax_amount,$total_tax_amount,ucwords($narration),$new_invoice_no,$sale_date);
                    //M_suppliers SALES TAX PAYMENT ENTRY
                    $this->M_suppliers->addsupplierPaymentEntry($tax_cr_ledger_id,$tax_dr_ledger_id,0,$total_tax_amount,$supplier_id,$narration,$new_invoice_no,$sale_date,1,$entry_id_tax);
                }//////////////// tax

                ////////////

               //for customer payment table
               $this->M_suppliers->addsupplierPaymentEntry($cr_ledger_id,$dr_ledger_id,0,$total_amount,$supplier_id,$narration,$new_invoice_no,$sale_date);
               ///
         }
         //PURCHASE RETURN CREDITED AND
         elseif($data_posted->purchaseType == 'cash' && $data_posted->register_mode == 'return')
         {
            //Search for purchases returns and discount ledger account for account entry
            //if invoice is cash then entry will be purchase debit and cash credit and vice versa
            
                $dr_ledger_id = $posting_type_code[0]['cash_acc_code'];
                $cr_ledger_id = $posting_type_code[0]['purchasereturn_acc_code'];
                $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$new_invoice_no,$sale_date);
               
                    ///////////////
                    //TAX JOURNAL ENTRY
                    if($total_tax_amount > 0){
                        $tax_dr_ledger_id = $posting_type_code[0]['cash_acc_code'];
                        $tax_cr_ledger_id = $posting_type_code[0]['salestax_acc_code'];
                        
                        $this->M_entries->addEntries($tax_dr_ledger_id,$tax_cr_ledger_id,$total_tax_amount,$total_tax_amount,ucwords($narration),$new_invoice_no,$sale_date);
                    
                    }
                    ////////////////

                //////////////
                // AMOUNT DUE//
                //if($data_posted->amount_due > 0)
//                {
//                    $this->M_entries->addEntries($posting_type_code[0]['payable_acc_code'],$cr_ledger_id,$data_posted->amount_due,$data_posted->amount_due,$data_posted->description,$new_invoice_no,$sale_date);
//                    
//                    //for cusmoter payment table
//                   $this->M_suppliers->addsupplierPaymentEntry($posting_type_code[0]['payable_acc_code'],$cr_ledger_id,$data_posted->amount_due,0,$supplier_id,$narration,$new_invoice_no,$sale_date);
//                   ///
//                }
                ////////////
                //END AMOUNT DUE
         }
         ////PURCHASE RETURN CREDITED AND
         elseif($data_posted->purchaseType == 'credit' && $data_posted->register_mode == 'return')
         {
            //Search for purchases and cash ledger account for account entry
            //if invoice is cash then entry will be purchase debit and cash credit and vice versa
            //SUPPLIER IS DEBITED
            $dr_ledger_id = $posting_type_code[0]['payable_acc_code'];
            $cr_ledger_id = $posting_type_code[0]['purchasereturn_acc_code'];
            $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$new_invoice_no,$sale_date);
               
                    ///////////////
                    //TAX JOURNAL ENTRY
                    if($total_tax_amount > 0){
                        $tax_dr_ledger_id = $posting_type_code[0]['payable_acc_code'];
                        $tax_cr_ledger_id = $posting_type_code[0]['salestax_acc_code'];
                        
                        $entry_id_tax =  $this->M_entries->addEntries($tax_dr_ledger_id,$tax_cr_ledger_id,$total_tax_amount,$total_tax_amount,ucwords($narration),$new_invoice_no,$sale_date);
                    
                        //M_suppliers SALES TAX PAYMENT ENTRY
                        $this->M_suppliers->addsupplierPaymentEntry($tax_dr_ledger_id,$tax_cr_ledger_id,$total_tax_amount,0,$supplier_id,$narration,$new_invoice_no,$sale_date,1,$entry_id_tax);
                // //M_suppliers SALES TAX PAYMENT ENTRY
                // $this->M_suppliers->addsupplierPaymentEntry($tax_cr_ledger_id,$tax_dr_ledger_id,0,$total_tax_amount,$supplier_id,$narration,$new_invoice_no,$sale_date,1,$entry_id_tax);
                
                    }
                    ////////////////

            /////////////////
            //REDUCE THE TOTAL AMOUNT IN RECEINVING TO SHOW EXACT AMOUNT IN OUTSTANDING INVOICES
            $credit_purchase = $this->M_receivings->get_creditPurchases($supplier_id);
            foreach($credit_purchase as $values){
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
            
           //for cusmoter payment table
           $this->M_suppliers->addsupplierPaymentEntry($dr_ledger_id,$cr_ledger_id,$total_amount,0,$supplier_id,$narration,$new_invoice_no,$sale_date);
           ///
                
         }
                    //IF DISCOUNT RECEIVED FROM SUPPLIER
                    // PURCHASE DICOUNT CREDITED AND PURCHASES DEBITED
                    if($data_posted->register_mode == 'receive')
                    {
                        if($discount != 0)
                        {
                            //$data['purchase_discount'] = $this->M_groups->get_ledgersByGroupName('cos');//search for sales ledger
//                            foreach($data['purchase_discount'] as $ledger_value):
//                                if(strtolower($ledger_value['name']) == 'purchase-discount')
//                                {
//                                    $cr_ledger_discount_id = $ledger_value['id'];
//                                } 
//                            
//                            endforeach;
                            
                            $cr_ledger_discount_id = $posting_type_code[0]['purchasedis_acc_code'];
                            
                            //journal entries 
                            // PURCHASE DICOUNT CREDITED AND PURCHASES DEBITED
                            $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_discount_id,$discount,$discount,$data_posted->description,$new_invoice_no,$sale_date);
                        }
                    }
                    elseif($data_posted->register_mode == 'return')
                    {
                        if($discount != 0)
                        {
                            //$data['purchase_discount'] = $this->M_groups->get_ledgersByGroupName('cos');//search for sales ledger
//                            foreach($data['purchase_discount'] as $ledger_value):
//                                if(strtolower($ledger_value['name']) == 'purchase-discount')
//                                {
//                                    $dr_ledger_discount_id = $ledger_value['id'];
//                                } 
//                            
//                            endforeach;
                            
                            $dr_ledger_discount_id = $posting_type_code[0]['purchasedis_acc_code'];
                            
                            //journal entries 
                            // PURCHASE DICOUNT DEBITED AND PURCHASES OR AC/PAYABLE CREDITED
                            $this->M_entries->addEntries($dr_ledger_discount_id,$cr_ledger_id,$discount,$discount,$data_posted->description,$new_invoice_no,$sale_date);
                        }
                    }
                    
                //////
               
               $this->db->trans_complete();
               
               
               echo '{"invoice_no":"'.$new_invoice_no.'"}';//redirect to receipt page using this $new_invoice_no 
         
                 
         ////////////////////////////
         //      ACCOUNTS CLOSED ..///
         
        }// Posting type  end if 
        else{
            echo '{"invoice_no":"no-posting-type"}';
        }
        
        }///$data_posted if close
        else{
            echo 'No Data';
        }
    }
    
    public function receipt($new_invoice_no)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        $data['receivings_items'] = $this->M_receivings->get_receiving_items($new_invoice_no);
        $receivings_items = $data['receivings_items'];
        
        $data['title'] = ($receivings_items[0]['register_mode'] == 'receive' ? 'Purchase' : 'Return').' Invoice # '.$new_invoice_no;
        $data['main'] = '';//($receivings_items[0]['register_mode'] == 'receive' ? '' : 'Return ').'Purchase Invoice';
        $data['invoice_no'] = $new_invoice_no;
        
        
        $company_id = $_SESSION['company_id'];
        $data['Company'] = $this->M_companies->get_companies($company_id);
            
        $this->load->view('templates/header',$data);
        $this->load->view('pos/receivings/v_receipt',$data);
        $this->load->view('templates/footer');
    }
    
    public function purchase()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        //$this->output->enable_profiler();
        
        $data['title'] = lang('purchases');
        $data['main'] = lang('purchases');
        
        $data['supplierDL'] = $this->M_suppliers->getSupplierPostingTypes(2);//search for legder account
        
        
        $data['itemDDL'] = $this->M_items->getItemDropDown();
        //$data['colorsDDL'] = $this->M_colors->get_activeColorsDDL();
        $data['sizesDDL'] = $this->M_sizes->get_activeSizesDDL();
        $data['supplierDDL'] = $this->M_suppliers->getSupplierDropDown();//search for legder account
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/receivings/v_purchases',$data);
        $this->load->view('templates/footer');
    }
    
    public function allPurchases()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        $start_date = FY_START_DATE; //date("Y-m-d", strtotime("last year"));
        $to_date = FY_END_DATE; //date("Y-m-d");
        $fiscal_dates = "(From: ".date('d-m-Y',strtotime($start_date)) ." To:" .date('d-m-Y',strtotime($to_date)).")";
        
        $data['title'] = lang('purchases').' '.$fiscal_dates;
        $data['main'] = lang('purchases');
        
        
        $data['main_small'] = $fiscal_dates;
        
        $data['receivings'] = $this->M_receivings->get_receivings(false,$start_date,$to_date);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/receivings/v_allPurchases',$data);
        $this->load->view('templates/footer');
    }
    
    function get_purchases_JSON()
    {
        $start_date = FY_START_DATE; //date("Y-m-d", strtotime("last year"));
        $to_date = FY_END_DATE; //date("Y-m-d");
        
        print_r(json_encode($this->M_receivings->get_selected_receivings($start_date,$to_date)));
    }
    
    
    public function getSupplierCurrencyJSON($supplier_id)
    {
        $suppliersCurrency = $this->M_suppliers->get_supplierCurrency($supplier_id);
        echo json_encode($suppliersCurrency);
    }
    
    public function delete($invoice_no)
    {
        if($this->session->userdata('role') != 'admin')
        {
            redirect('No_access','refresh');    
        }

        //if entry deleted then all item qty will be reversed
        $this->db->trans_start();
        
        $receiving_items = $this->M_receivings->get_receiving_items($invoice_no);
        //var_dump($receiving_items);
        
        foreach($receiving_items as $values)
        {
            $total_stock =  $this->M_items->total_stock($values['item_id'],-1,$values['size_id']);
            $quantity = ($total_stock - $values['quantity_purchased']);
             
            $option_data = array(
            'quantity'=>$quantity,
            //'unit_price' =>$values['item_unit_price'],
            'avg_cost'=>$this->M_items->getAvgCost($values['item_id'],$values['item_cost_price'],$values['quantity_purchased'],0,$values['size_id'],'return')//calculate avg cost
             
            );
          $this->db->update('pos_items_detail',$option_data,array('size_id'=>$values['size_id'],'item_id'=>$values['item_id']));
         
         
            //insert item info into inventory table
            $data1= array(
                
                'trans_item'=>$values['item_id'],
                'trans_comment'=>'KSRECV Deleted',
                'trans_inventory'=>$values['quantity_purchased'],
                'company_id'=>$_SESSION['company_id'],
                'trans_user'=>$_SESSION['user_id'],
                'invoice_no'=>$invoice_no
                );
                
            $this->db->insert('pos_inventory', $data1);
        }
        
         
        $this->M_receivings->delete($invoice_no);
        $this->db->trans_complete();
        
        $this->session->set_flashdata('message','Entry Deleted');
        redirect('trans/C_receivings/allPurchases','refresh');
    }

    
    function getReceivingsItemsJSON($invoice_no)
    {
        $data = $this->M_receivings->get_receiving_items_by_invoice($invoice_no);

        $outp = "";
        foreach ($data as $rs) {
            //$tm =  json_decode($rs["teams_id"]);
            //print_r($tm);

            if ($outp != "") {
                $outp .= ",";
            }

            $outp .= '{"item_id":"'  . $rs["item_id"] . '",';
            $outp .= '"size_id":"'   . $rs["size_id"] . '",';
            $outp .= '"unit_id":"'   . $rs["unit_id"] . '",';
            $outp .= '"item_cost_price":"'   . $rs["item_cost_price"] . '",';
            $outp .= '"item_unit_price":"'   . $rs["item_unit_price"] . '",';
            $outp .= '"quantity_purchased":"'   . $rs["quantity_purchased"] . '",';
            $outp .= '"discount_percent":"'   . $rs["discount_percent"] . '",';
            //$outp .= '"discount_value":"'   . $rs["discount_value"] . '",';
            $outp .= '"tax_id":"'   . $rs["tax_id"] . '",';
            $outp .= '"tax_rate":"'   . $rs["tax_rate"] . '",';
            $outp .= '"tax_name":"",';
            //$outp .= '"inventory_acc_code":"'   . $rs["inventory_acc_code"] . '",';
            $outp .= '"service":"'   . $rs["service"] . '",';

            $item_name = $this->M_items->get_ItemName($rs["item_id"]);
            $outp .= '"name":"'   . @$item_name . '",';

            // $size_name = $this->M_sizes->get_sizeName($rs["size_id"]);
            // $outp .= '"size":"'   . @$size_name . '",';

            $outp .= '"invoice_no":"' . $rs["invoice_no"]     . '"}';
        }

        $outp = '[' . $outp . ']';
        echo $outp;
    }


    function getReceivingsJSON($invoice_no)
    {
        $data = $this->M_receivings->get_receiving_by_invoice($invoice_no);

        $outp = "";
        foreach ($data as $rs) {
            //$tm =  json_decode($rs["teams_id"]);
            //print_r($tm);

            if ($outp != "") {
                $outp .= ",";
            }

            $outp .= '{"receiving_time":"'  . $rs["receiving_time"] . '",';
            $outp .= '"receiving_date":"'   . $rs["receiving_date"] . '",';
            $outp .= '"supplier_id":"'   . $rs["supplier_id"] . '",';
            $outp .= '"supplier_invoice_no":"'   . $rs["supplier_invoice_no"] . '",';
            $outp .= '"employee_id":"'   . $rs["employee_id"] . '",';
            $outp .= '"user_id":"'   . $rs["user_id"] . '",';
            $outp .= '"register_mode":"'   . $rs["register_mode"] . '",';
            $outp .= '"account":"'   . $rs["account"] . '",';
            $outp .= '"description":"'   . $rs["description"] . '",';
            $outp .= '"discount_value":"'   . $rs["discount_value"] . '",';
            $outp .= '"total_amount":"'   . $rs["total_amount"] . '",';
            $outp .= '"total_tax":"'   . $rs["total_tax"] . '",';
            $outp .= '"paid":"'   . $rs["paid"] . '",';
            
            $outp .= '"exchange_rate":"'   . $rs["exchange_rate"] . '",';
            $outp .= '"currency_id":"'   . $rs["currency_id"] . '",';

            $outp .= '"invoice_no":"' . $rs["invoice_no"]     . '"}';
        }

        $outp = '[' . $outp . ']';
        echo $outp;
    }

}