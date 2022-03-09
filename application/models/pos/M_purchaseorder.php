<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_purchaseorder extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        
    }
    
    function get_purchaseorders($receiving_id = FALSE, $from_date = null, $to_date=null)
    {
        if($from_date != null)
        {
            $this->db->where('receiving_date >=',$from_date);
        }
        
        if($to_date != null)
        {
            $this->db->where('receiving_date <=',$to_date);
        }
        
        if($receiving_id == FALSE)
        {
            $query = $this->db->get_where('pos_purchase_orders',array('company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_purchase_orders',array('receiving_id'=>$receiving_id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function get_selected_purchaseorder($from_date = null, $to_date=null)
    {
        if($from_date != null)
        {
            $this->db->where('receiving_date >=',$from_date);
        }
        
        if($to_date != null)
        {
            $this->db->where('receiving_date <=',$to_date);
        }
        
        $this->db->select('r.receiving_id,r.invoice_no,r.receiving_date,(r.total_amount+r.total_tax) AS net_amount,
        r.supplier_id,r.employee_id,e.first_name as emp,s.name as supplier');
        $this->db->join('pos_supplier as s','s.id = r.supplier_id','left');
        $this->db->join('pos_employees as e','e.id = r.employee_id','left');
        
        $query = $this->db->get_where('pos_purchase_orders as r',array('r.company_id'=> $_SESSION['company_id']));
        return $query->result_array();
        
    }
    
    function get_creditPurchases($supplier_id)
    {
       $this->db->where('total_amount > paid');
       $this->db->where('(total_amount-paid) >',0);
       
       $query = $this->db->get_where('pos_purchase_orders',array('account'=>'credit','register_mode'=>'receive',
       'supplier_id'=>$supplier_id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function updatePaidAmount($invoice_no,$data)
    {
       
       $this->db->update('pos_purchase_orders',$data,array('invoice_no'=>$invoice_no,'company_id'=> $_SESSION['company_id']));
       
    }
    
    
    function get_purchaseorder_items($new_invoice_no)//for receipt
    {
       $this->db->select('A.receiving_date,A.amount_due,A.description,A.register_mode,A.employee_id,A.supplier_id,
       A.currency_id,A.discount_value,B.tax_id,B.tax_rate,B.service,
       B.unit_id,B.item_id,B.item_cost_price,B.item_unit_price,B.size_id,B.quantity_purchased,B.discount_percent');
       $this->db->join('pos_purchase_orders_items as B','A.receiving_id = B.receiving_id');
       $query = $this->db->get_where('pos_purchase_orders as A',array('A.invoice_no'=>$new_invoice_no,'A.company_id'=> $_SESSION['company_id']));
       return $query->result_array();
       
    }
    
    function getMAXPurchaseInvoiceNo()
    {   
        $this->db->order_by('receiving_id','desc');
        $this->db->where('company_id', $_SESSION['company_id']);
        $query = $this->db->get('pos_purchase_orders',1);
        return $query->row()->invoice_no;
    }
    
    public function get_totalCostByReceivingID($invoice_no)
    {
        $data = 0;
       $this->db->select('SUM(item_cost_price*quantity_purchased) as price');   
       $query = $this->db->get_where('pos_purchase_orders_items',array('invoice_no'=>$invoice_no));
       $rows = $query->row();
       
       if($rows)
       {
        return floatval($rows->price);
       }
    }
    
    function get_receiving_by_invoice($invoice_no)
    {   
        $this->db->where(array('invoice_no'=>$invoice_no,'company_id'=>$_SESSION['company_id']));
        $query = $this->db->get('pos_purchase_orders');
        return $query->result_array();
       
    }
    
   function delete($invoice_no)
    {
        $this->db->delete('pos_purchase_orders',array('invoice_no'=>$invoice_no));
        
        $this->db->delete('pos_purchase_orders_items',array('invoice_no'=>$invoice_no));
        
        $this->db->delete('acc_entries',array('invoice_no'=>$invoice_no));
        $this->db->delete('acc_entry_items',array('invoice_no'=>$invoice_no));
        
        $this->db->delete('pos_supplier_payments',array('invoice_no'=>$invoice_no));
        
        //for logging
        $msg = $invoice_no;
        $this->M_logs->add_log($msg,"purchaseorder","Deleted","POS");
        // end logging
    }
}
    