<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_customers extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    //get all customers and also only one customer and active and inactive too.
    public function get_customers($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            
            $this->db->order_by('id','desc');
            $query = $this->db->get_where('pos_customers',array('company_id'=> $_SESSION['company_id']));
            $data = $query->result_array();
            return $data;
        }
        
        $this->db->order_by('id','desc');
        $options = array('id'=> $id,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_customers',$options);
        $data = $query->result_array();
        return $data;
    }
    
    //get all customers and also only one customer and active and inactive too.
    public function get_customerCurrency($id)
    {
        $this->db->select('cur.id,cur.name,cur.code,cur.symbol');
        $this->db->join('pos_currencies cur','cur.id = c.currency_id');
        $query = $this->db->get_where('pos_customers c',array('c.id'=> $id,'c.status'=>'active','c.company_id'=> $_SESSION['company_id']));
        $data = $query->result_array();
        return $data;
    }
    
    //get all customers and also only one customer and active and inactive too.
    public function get_activeCustomers($id = FALSE, $limit = 1000000, $offset = 0)
    {
       if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            
            $this->db->select('id,first_name,last_name,emp_id,city,address,mobile_no,store_name,email,
            address,op_balance_dr,op_balance_cr,exchange_rate,posting_type_id,acc_code,currency_id,vat_no');
            $options = array('status'=>'active','company_id'=> $_SESSION['company_id']);
        
            $this->db->order_by('id','desc');
            $query = $this->db->get_where('pos_customers',$options);
            $data = $query->result_array();
            return $data;
        }
        
        $this->db->select('id,first_name,last_name,emp_id,store_name,email,address,op_balance_dr,
        op_balance_cr,exchange_rate,posting_type_id,acc_code,currency_id,vat_no');
        $this->db->order_by('id','desc');
        $options = array('id'=> $id,'status'=>'active','company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_customers',$options);
        $data = $query->result_array();
        
        return $data;
    }
    
    public function get_actCustomers()
    {
      
        $this->db->select('id,first_name,store_name,address,city,mobile_no,op_balance_dr,op_balance_cr');
        $options = array('status'=>'active','company_id'=> $_SESSION['company_id']);
    
        $this->db->order_by('id','desc');
        $query = $this->db->get_where('pos_customers',$options);
        $data = $query->result_array();
        return $data;
    }
    
    public function customer_search($city)
    {
        $this->db->select('id,first_name,store_name,address,city,op_balance_dr,op_balance_cr');
        $this->db->like('city',$city);
        $options = array('status'=>'active','company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_customers',$options);
        $data = $query->result_array();
        
        return $data;
    }
    
    public function get_activeCustomersByAccCode($acc_code)
    {
        $options = array('status'=>'active','company_id'=> $_SESSION['company_id'],
        'acc_code'=> $acc_code);
        
        $query = $this->db->get_where('pos_customers',$options);
        $data = $query->result_array();
        return $data;
    }
    
    public function get_customer_Entries($customer_id,$fy_start_date,$fy_end_date)
    {
        $this->db->group_by('sp.id');
        //$this->db->join('acc_groups g','g.account_code=sp.account_code');
        $this->db->select('sp.*')->from('pos_customer_payments sp')->where('sp.customer_id', $customer_id);
        $this->db->where('sp.company_id', $_SESSION['company_id']);
        //$this->db->where('g.company_id', $_SESSION['company_id']);
        $this->db->where('date >=', $fy_start_date);
        $this->db->where('date <=', $fy_end_date);

        $query = $this->db->get();
        $data = $query->result_array();
        
        return $data;
    }
    
    public function get_customer_entries_cheques_all($fy_start_date,$fy_end_date)
    {
        $this->db->group_by('sp.id');
        //$this->db->join('acc_groups g','g.account_code=sp.account_code');
        $this->db->select('sp.*')->from('pos_customer_payments sp')->where('sp.dueTo_acc_code', '1002');
        $this->db->where('sp.company_id', $_SESSION['company_id']);
        //$this->db->where('g.company_id', $_SESSION['company_id']);
        $this->db->where('date >=', $fy_start_date);
        $this->db->where('date <=', $fy_end_date);

        $query = $this->db->get();
        $data = $query->result_array();
        
        return $data;
    }
    
    public function get_customer_total_balance($customer_id,$fy_start_date,$fy_end_date)
    {
        $this->db->select('SUM(debit) as dr_balance, SUM(credit) as cr_balance')->from('pos_customer_payments sp')->where('sp.customer_id', $customer_id);
        $this->db->where('sp.company_id', $_SESSION['company_id']);
        $this->db->where('date >=', $fy_start_date);
        $this->db->where('date <=', $fy_end_date);
        $query = $this->db->get();
        
        $data = $query->result_array();
        
        return $data;
    }
    
    public function get_customer_total_balance_e_op_balance($customer_id,$fy_start_date,$fy_end_date)
    {
        $total_op = 0;
        $balance=0;
        $total = 0;
        $options = array('id'=> $customer_id, 'company_id'=> $_SESSION['company_id']);
        $this->db->select('(op_balance_dr-op_balance_cr) as OP_balance');
        
        $query = $this->db->get_where('pos_customers',$options);
        
        if($data = $query->row() )
        {
            $total_op = $data->OP_balance;
        }

        $this->db->select('SUM(debit-credit) AS balance')->from('pos_customer_payments sp')->where('sp.customer_id', $customer_id);
        $this->db->where('sp.company_id', $_SESSION['company_id']);
        $this->db->where('date >=', $fy_start_date);
        $this->db->where('date <=', $fy_end_date);
        $query_1 = $this->db->get();
        
        if($data_1 = $query_1->row() )
        {
            $balance = $data_1->balance;
        }
        
        $total = ($total_op+$balance);
        return $total;
    }
    
    function getCustomerDropDown()
    {
        $data = array();
        $data['']= 'Select Customer';
        
        $this->db->order_by('id DESC');

        $query = $this->db->get_where('pos_customers',array('status'=>'active','company_id'=> $_SESSION['company_id']));
        
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                 $data[$row['id']] = ucfirst($row['store_name']);
            }
        }
        $query->free_result();
        return $data;
    }
    
    function getCustomerSupplierDropDown()
    {
        $data = array();
        $data[0]= 'Select Customer';
        
        $this->db->where('sp.also_customer',1);
        $this->db->join('pos_supplier sp','sp.company_id=cs.company_id','right');
        $query = $this->db->get_where('pos_customers cs',array('cs.status'=>'active','cs.company_id'=> $_SESSION['company_id']));
        
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                 $data[$row['id']] = $row['first_name'] .' ' .$row['last_name'] . ''.$row['name'];
            }
        }
        $query->free_result();
        return $data;
    }
    
   
    function addCustomer()
        {
            $data = array(
            'company_id'=> $_SESSION['company_id'],
            'posting_type_id' => $this->input->post('posting_type_id'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'store_name' => $this->input->post('store_name'),
            'city' => $this->input->post('city'),
            'country' => $this->input->post('country'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'contact' => $this->input->post('contact'),
            'status' => $this->input->post('status')
            );
            $this->db->insert('pos_customers', $data);
            
            //for logging
            $msg = $this->input->post('first_name'). ' '. $this->input->post('last_name');
            $this->M_logs->add_log($msg,"Customers","Added","POS");
            // end logging
        }
        
     function updateCustomer()
        {
            //$file_name = $this->upload->data();
            
            $data = array(
            'company_id'=> $_SESSION['company_id'],
            'posting_type_id' => $this->input->post('posting_type_id'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'store_name' => $this->input->post('store_name'),
            'city' => $this->input->post('city'),
            'country' => $this->input->post('country'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'contact' => $this->input->post('contact'),
            'status' => $this->input->post('status')
            );
            $this->db->update('pos_customers', $data, array('id'=>$_POST['id']));
            
            //for logging
            $msg = $this->input->post('first_name'). ' '. $this->input->post('last_name');
            $this->M_logs->add_log($msg,"Customers","Updated","POS");
            // end logging
        }
    function addCustomerPaymentEntry($account_code,$dueTo_acc_code,$dr=0,$cr=0,$customer_id='',
    $narration='',$invoice_no='',$date=null,$exchange_rate=0,$entry_id=0)
    {
        $data = array(
                'customer_id' => $customer_id,
                'account_code' => $account_code,
                'dueTo_acc_code' => $dueTo_acc_code,
                'date' => ($date == null ? date('Y-m-d') : $date),
                'debit'=>$dr,
                'credit'=>$cr,
                'invoice_no' => $invoice_no,
                'entry_id' => $entry_id,
                'narration' => $narration,
                'exchange_rate'=>($exchange_rate == null ? 0 : $exchange_rate),
                'company_id'=> $_SESSION['company_id']
                );
                $this->db->insert('pos_customer_payments', $data);      
    }
    
    function getMAXCustInvoiceNo($invoice_prefix)
    {   
        $this->db->order_by('id','desc');
        $this->db->like('invoice_no',$invoice_prefix,'after');
        $query = $this->db->get('pos_customer_payments',1);
        return $query->row()->invoice_no;
    }
    
    function getCustomerPostingTypes($customer_id)
    {
        $this->db->select('spt.*');
        $this->db->join('pos_customers c','c.posting_type_id=spt.id');
        $this->db->where('c.id',$customer_id);
        $query =$this->db->get('pos_salespostingtypes spt',1);
        return $query->result_array();
    }
    
    public function get_CustomerName($Customer_id)
    {
        $options = array('id'=> $Customer_id,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_customers',$options);
        if($row = $query->row())
        {
            return $row->first_name .' '.$row->last_name;
        }
        
        return '';
    }
    
    function deleteCustomer($id,$op_balance_dr,$op_balance_cr)
    {
       $this->db->trans_start();
       $posting_type_code = $this->M_customers->getCustomerPostingTypes($id);
       
       if(!empty($posting_type_code))
       {
            //OPENING BALANCE IN CUSTOMER ACCOUNT
           $receivable_account_code = $posting_type_code[0]['receivable_acc_code'];//customer ledger id
           
           $receivable_account = $this->M_groups->get_groups($receivable_account_code,$_SESSION['company_id']);
           $receivable_dr_balance = abs((empty($receivable_account[0]['op_balance_dr']) ? 0 : $receivable_account[0]['op_balance_dr']));//if empty post 0 
           $receivable_cr_balance = abs((empty($receivable_account[0]['op_balance_cr']) ? 0 : $receivable_account[0]['op_balance_cr']));//if empty post 0
           
           if($receivable_dr_balance !== 0 || $receivable_cr_balance !== 0)
           {
               $dr_balance = ($receivable_dr_balance-$op_balance_dr);
               $cr_balance = ($receivable_cr_balance-$op_balance_cr);
               
               $this->M_groups->editGroupOPBalance($receivable_account_code,$dr_balance,$cr_balance);
           }
       }
       
       //GET SALES ITEMS AND DELETE SALES AND SALES ITEMS CUSTOMER PAYEENT 
       //AND ALSO JOURNAL ENTRIES
       $query = $this->db->get_where('pos_sales',array('customer_id'=>$id,'company_id'=> $_SESSION['company_id']));
       if($query->num_rows() > 0)//IF SALES EXIST THEN DELETE CUSTOMER SALES
       {
           $sales = $query->result_array();
           
           //GET INVOICE NO BY CUSTOMER ID AND DELETE ALL BY INVOICE NO.
           foreach($sales as $sale_item)
           {
                
                $this->db->delete('acc_entries',array('invoice_no'=>$sale_item['invoice_no'],'company_id'=> $_SESSION['company_id']));
                $this->db->delete('acc_entry_items',array('invoice_no'=>$sale_item['invoice_no'],'company_id'=> $_SESSION['company_id']));
                
                             //WHEN CUSTOMER DELTED ITS SALES DELETED AND PRODUCT WILL BE REVERSED        
                             //if entry deleted then all item qty will be reversed
                            $sales_items = $this->M_sales->get_sales_items($sale_item['invoice_no']);
                            foreach($sales_items as $values)
                            {
                                $total_stock =  $this->M_items->total_stock($values['item_id'],-1,$values['size_id']);
                                            
                                //if products is to be return then it will add from qty and the avg cost will be reverse to original cost
                                $quantity = ($total_stock + $values['quantity_sold']);
                                            
                                    $option_data = array(
                                    'quantity'=>$quantity
                                    );
                                $this->db->update('pos_items_detail',$option_data,array('size_id'=>$values['size_id'],'item_id'=>$values['item_id']));
                                
                                //ADD ITEM DETAIL IN INVENTORY TABLE    
                                  $data1= array(
                                    'trans_item'=>$values['item_id'],
                                    'trans_comment'=>'KSPOS Deleted (Customer Delete)',
                                    'trans_inventory' => -$values['quantity_sold'],
                                    'company_id'=> $_SESSION['company_id'],
                                    'trans_user'=>$_SESSION['user_id'],
                                    'invoice_no'=>$sale_item['invoice_no']
                                    );
                                    
                                  $this->db->insert('pos_inventory', $data1);
                                  //////////////
                            }    
                $this->db->delete('pos_sales_items',array('invoice_no'=>$sale_item['invoice_no'],'company_id'=> $_SESSION['company_id']));
                            /////////////////////////////
                            //WHEN CUSTOMER DELTED ITS SALES DELETED AND PRODUCT WILL BE REVERSED            
           }
           
           //DELETE ENTRIES BY CUSTOMER_ID NOT INVOICE NO.
           $this->db->delete('pos_customer_payments',array('customer_id'=>$id,'company_id'=> $_SESSION['company_id']));
           $this->db->delete('pos_sales',array('customer_id'=>$id,'company_id'=> $_SESSION['company_id']));
          ////////////////
          ///////ACCOUNTS ENDS
       }
       
                     
      $query = $this->db->delete('pos_customers',array('id'=>$id));
      
      $this->db->trans_complete(); 
        
            //for logging
            $msg = 'Customer id: '.$id;
            $this->M_logs->add_log($msg,"Customers","Deleted","POS");
            // end logging
    }
    
    function inactivate($id,$op_balance_dr,$op_balance_cr)
    {
       $this->db->trans_start();
       $posting_type_code = $this->M_customers->getCustomerPostingTypes($id);
       
       if(!empty($posting_type_code))
       {             
           //OPENING BALANCE IN CUSTOMER ACCOUNT
           $receivable_account_code = $posting_type_code[0]['receivable_acc_code'];//customer ledger id
           
           $receivable_account = $this->M_groups->get_groups($receivable_account_code,$_SESSION['company_id']);
           $receivable_dr_balance = abs((empty($receivable_account[0]['op_balance_dr']) ? 0 : $receivable_account[0]['op_balance_dr']));//if empty post 0 
           $receivable_cr_balance = abs((empty($receivable_account[0]['op_balance_cr']) ? 0 : $receivable_account[0]['op_balance_cr']));//if empty post 0
               
           if($receivable_dr_balance !== 0 || $receivable_cr_balance !== 0)
           {
               $dr_balance = ($receivable_dr_balance-$op_balance_dr);
               $cr_balance = ($receivable_cr_balance-$op_balance_cr);
               
               $this->M_groups->editGroupOPBalance($receivable_account_code,$dr_balance,$cr_balance);
           }
       }              
       
       $query = $this->db->update('pos_customers',array('status'=>'inactive'),array('id'=>$id));
      
      $this->db->trans_complete(); 
        
            //for logging
            $msg = 'Customer id: '.$id;
            $this->M_logs->add_log($msg,"Customers","Inactivated","POS");
            // end logging
    }
    
    function delete_entry_by_id($entry_id)
    {
        $query = $this->db->get_where('pos_customer_payments',array('entry_id'=>$entry_id,
        'company_id'=> $_SESSION['company_id']));
        
        if ($query->num_rows() > 0)
        {
            $data = $query->result_array();
            
            $customer_id = $data[0]['customer_id'];
            $invoice_no = $data[0]['invoice_no'];
            //$total_amount = ($data[0]['debit']+$data[0]['credit']);
            //$cur_amount = 0;
                        
                 if($customer_id != 0)
                 {  
                    /////////////////
                    //REDUCE THE TOTAL AMOUNT IN SALES TO SHOW EXACT AMOUNT IN OUTSTANDING INVOICES
                    $cust_payment_hstry = $this->get_customer_payment_history($customer_id,$invoice_no);
                    
                    foreach($cust_payment_hstry as $values){
                            
                          $prev_sales = $this->M_sales->get_sales_by_invoice($values['sales_invoice_no']);
                          //var_dump($prev_sales);
                          $data = array(
                            'paid' => abs(@$prev_sales[0]['paid']-$values['amount']),//must be positive values
                            );
                          $this->db->update('pos_sales',$data,array('invoice_no'=>$values['sales_invoice_no']));
                        
                    }
                    
                    //DELETE PAYMENT HISOTRY 
                    $this->delete_customer_payment_history($customer_id,$invoice_no);
                    
                   }
        }        
       $this->db->delete('pos_customer_payments',array('entry_id'=>$entry_id));
        
    }
    
    function delete_entry_by_invoice_no($invoice_no)
    {
        $query = $this->db->get_where('pos_customer_payments',array('invoice_no'=>$invoice_no,
        'company_id'=> $_SESSION['company_id']));
        
        if ($query->num_rows() > 0)
        {
            $data = $query->result_array();
            
            $customer_id = $data[0]['customer_id'];
            $invoice_no = $data[0]['invoice_no'];
            //$total_amount = ($data[0]['debit']+$data[0]['credit']);
            //$cur_amount = 0;
                        
                 if($customer_id != 0)
                 {  
                    /////////////////
                    //REDUCE THE TOTAL AMOUNT IN SALES TO SHOW EXACT AMOUNT IN OUTSTANDING INVOICES
                    $cust_payment_hstry = $this->get_customer_payment_history($customer_id,$invoice_no);
                    
                    foreach($cust_payment_hstry as $values){
                            
                          $prev_sales = $this->M_sales->get_sales_by_invoice($values['sales_invoice_no']);
                          //var_dump($prev_sales);
                          $data = array(
                            'paid' => abs(@$prev_sales[0]['paid']-$values['amount']),//must be positive values
                            );
                          $this->db->update('pos_sales',$data,array('invoice_no'=>$values['sales_invoice_no']));
                        
                    }
                    
                    //DELETE PAYMENT HISOTRY 
                    $this->delete_customer_payment_history($customer_id,$invoice_no);
                    
                   }
        }        
       $this->db->delete('pos_customer_payments',array('invoice_no'=>$invoice_no));
        
    }
    
    function get_customer_payment_history($customer_id,$invoice_no){
        
        $options = array('customer_id'=> $customer_id,'invoice_no'=>$invoice_no,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_customer_payment_history',$options);
        $data = $query->result_array();
        return $data;    
    }
    
    function delete_customer_payment_history($customer_id,$invoice_no)
    {
        $options = array('customer_id'=> $customer_id,'invoice_no'=>$invoice_no,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->delete('pos_customer_payment_history',$options);
        
    }
    
    function activate($id)
    {
        $query = $this->db->update('pos_customers',array('status'=>'active'),array('id'=>$id));
        
            //for logging
            $msg = 'Customer id: '.$id;
            $this->M_logs->add_log($msg,"Customers","Activated","POS");
            // end logging
    }
    
    function get_cust_supp_Union()
    {
        
        $query = $this->db->query('
        SELECT id,store_name,acc_code FROM pos_customers  WHERE status= "active"
        UNION
        SELECT id,name,acc_code FROM pos_supplier 
        WHERE also_customer = 1 AND status="active"'
        );
         
        return $query->result_array(); 
    }    
}
?>