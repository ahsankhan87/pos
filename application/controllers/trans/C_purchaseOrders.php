<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_purchaseOrders extends MY_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    public function index($purchaseType = '')
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        //$this->output->enable_profiler();
        
        $data['title'] = $purchaseType.' Purchases';
        $data['main'] = $purchaseType.' Purchases';
        
        $data['purchaseType'] = $purchaseType;
        //when click on sale manu clear the cart first if exist
       // $this->destroyCart();
        
        //$data['itemDDL'] = $this->M_items->getItemDropDown();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        $data['sizesDDL'] = $this->M_sizes->get_activeSizesDDL();
        $data['supplierDDL'] = $this->M_suppliers->getSupplierDropDown();//search for legder account
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/purchaseorders/v_purchaseorder',$data);
        $this->load->view('templates/footer');
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
           @$prev_invoice_no = $this->M_purchaseorder->getMAXPurchaseInvoiceNo();
           //$number = (int) substr($prev_invoice_no,11)+1; // EXTRACT THE LAST NO AND INCREMENT BY 1
           //$new_invoice_no = 'REC'.date("Ymd").$number;
           $number = (int) substr($prev_invoice_no,1)+1; // EXTRACT THE LAST NO AND INCREMENT BY 1
           $new_invoice_no = 'O'.$number;
           
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
        
        
         $data = array(
            'company_id'=> $_SESSION['company_id'],
            'invoice_no' => $new_invoice_no,
            'supplier_id' => $data_posted->supplier_id,
            'supplier_invoice_no' => $data_posted->supplier_invoice_no,
            'employee_id'=>$emp_id,
            'user_id'=>$_SESSION['user_id'],
            'receiving_date' => $sale_date,
            'register_mode'=>$data_posted->register_mode,
            'account'=>$data_posted->purchaseType,
            'amount_due'=>$data_posted->amount_due,
            'description'=>$narration,
            'discount_value'=>$discount,
            'currency_id'=>$currency_id,
            'exchange_rate'=>$exchange_rate,
            'total_amount'=>$total_amount,
            'total_tax'=>$total_tax_amount,
            );
            
        $this->db->insert('pos_purchase_orders', $data);
        
        $purchaseorder_id = $this->db->insert_id();
        
        
        //extract JSON array items from posted data.
        foreach($data_posted->items as $posted_values):
        
            $service = ($posted_values->service == null ? 0 : $posted_values->service);
        //$posted_exp_date = strftime('%Y-%m-%d', strtotime($posted_values->expiry_date));//get only date remove time
            
            //insert in purchaseorders items
            $data = array(
                'receiving_id'=>$purchaseorder_id,
                'invoice_no' => $new_invoice_no,
                'item_id'=>$posted_values->item_id,
                'quantity_purchased'=>$posted_values->quantity,//if purchase return then insert amount in negative
                'item_cost_price'=>$posted_values->cost_price,//actually its avg cost comming from sale from
                'item_unit_price'=>$posted_values->unit_price,//if purchase return then insert amount in negative
                //'discount_percent'=>$posted_values->discount,
                'color_id'=>$posted_values->color_id,
                'size_id'=>$posted_values->size_id,
                'company_id'=> $_SESSION['company_id'],
                'unit_id'=>$posted_values->unit_id,
                'tax_id'=>$posted_values->tax_id,
                'tax_rate'=>$posted_values->tax_rate,
                'service'=>$service,
            );
                
            $this->db->insert('pos_purchase_orders_items', $data);
            // purchaseorder itmes
            
                    //for logging
                    $msg = 'invoice no '. $new_invoice_no;
                    $this->M_logs->add_log($msg,"purchase order transaction","created","trans");
                    // end logging
                    
            
         
            $amount += ($posted_values->quantity * $posted_values->cost_price);
         
              
        endforeach;
        
        
               
               echo '{"invoice_no":"'.$new_invoice_no.'"}';//redirect to receipt page using this $new_invoice_no 
         
         $this->db->trans_complete();
                 
         ////////////////////////////
         //      ACCOUNTS CLOSED ..///
         
        
        }///$data_posted if close
        else{
            echo 'No Data';
        }
    }
    
    public function receipt($new_invoice_no)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        $data['purchaseorders_items'] = $this->M_purchaseorder->get_purchaseorder_items($new_invoice_no);
        $purchaseorders_items = $data['purchaseorders_items'];
        
        $data['title'] = strtoupper($purchaseorders_items[0]['register_mode']).' Invoice # '.$new_invoice_no;
        $data['main'] = '';//($purchaseorders_items[0]['register_mode'] == 'receive' ? '' : 'Return ').'Purchase Invoice';
        $data['invoice_no'] = $new_invoice_no;
        
        
        $company_id = $_SESSION['company_id'];
        $data['Company'] = $this->M_companies->get_companies($company_id);
            
        $this->load->view('templates/header',$data);
        $this->load->view('pos/purchaseorders/v_receipt',$data);
        $this->load->view('templates/footer');
    }
    
    public function purchase()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        //$this->output->enable_profiler();
        
        $data['title'] = lang('purchase').' ' . lang('orders');
        $data['main'] = lang('purchase').' ' . lang('orders');
        
        $data['supplierDL'] = $this->M_suppliers->getSupplierPostingTypes(2);//search for legder account
        
        
        $data['itemDDL'] = $this->M_items->getItemDropDown();
        //$data['colorsDDL'] = $this->M_colors->get_activeColorsDDL();
        $data['sizesDDL'] = $this->M_sizes->get_activeSizesDDL();
        $data['supplierDDL'] = $this->M_suppliers->getSupplierDropDown();//search for legder account
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/purchaseorders/v_purchases',$data);
        $this->load->view('templates/footer');
    }
    
    public function allPurchaseorders()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('purchase').' ' . lang('orders');
        $data['main'] = lang('purchase').' ' . lang('orders');
        
        $start_date = FY_START_DATE; //date("Y-m-d", strtotime("last year"));
        $to_date = FY_END_DATE; //date("Y-m-d");
        
        $data['main_small'] = "(From: ".date('d-m-Y',strtotime($start_date)) ." To:" .date('d-m-Y',strtotime($to_date)).")";
        
        $data['purchaseorders'] = $this->M_purchaseorder->get_purchaseorders(false,$start_date,$to_date);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/purchaseorders/v_allPurchaseorder',$data);
        $this->load->view('templates/footer');
    }
    
    function get_purchases_JSON()
    {
        $start_date = FY_START_DATE; //date("Y-m-d", strtotime("last year"));
        $to_date = FY_END_DATE; //date("Y-m-d");
        
        print_r(json_encode($this->M_purchaseorder->get_selected_purchaseorder($start_date,$to_date)));
    }
    
    
    public function getSupplierCurrencyJSON($supplier_id)
    {
        $suppliersCurrency = $this->M_suppliers->get_supplierCurrency($supplier_id);
        echo json_encode($suppliersCurrency);
    }
    
    public function delete($invoice_no)
    {
        //if entry deleted then all item qty will be reversed
        $this->db->trans_start();
        
        
        $this->M_purchaseorder->delete($invoice_no);
        $this->db->trans_complete();
        
        $this->session->set_flashdata('message','Entry Deleted');
        redirect('trans/C_purchaseOrders/allPurchaseorders','refresh');
    }
}