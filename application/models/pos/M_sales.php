<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_sales extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        
    }
    
    function get_sales($sales_id = FALSE, $from_date = null, $to_date=null)
    {
        if($from_date != null)
        {
            $this->db->where('sale_date >=',$from_date);
        }
        
        if($to_date != null)
        {
            $this->db->where('sale_date <=',$to_date);
        }
        
        if($sales_id == FALSE)
        {
            $query = $this->db->get_where('pos_sales',array('company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_sales',array('sale_id'=>$sales_id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function get_selected_sales($from_date = null, $to_date=null)
    {
        if($from_date != null)
        {
            $this->db->where('sale_date >=',$from_date);
        }
        
        if($to_date != null)
        {
            $this->db->where('sale_date <=',$to_date);
        }
        
        $this->db->select('s.sale_id,s.invoice_no,s.sale_date,s.sale_time,(s.total_amount+s.total_tax) AS net_amount,
        s.customer_id,s.account,s.employee_id,e.first_name as emp,c.store_name as customer');
        $this->db->join('pos_customers as c','c.id = s.customer_id','left');
        $this->db->join('pos_employees as e','e.id = s.employee_id','left');
        
        $query = $this->db->get_where('pos_sales as s',array('s.company_id'=> $_SESSION['company_id']));
        return $query->result_array();
        
    }
    
    function get_creditSales($customer_id)
    {
       $this->db->where('total_amount > paid');
       $this->db->where('(total_amount-paid) >',0);
       
       $query = $this->db->get_where('pos_sales',array('account'=>'credit','register_mode'=>'sale',
       'customer_id'=>$customer_id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function updatePaidAmount($invoice_no,$data)
    {
       
       $this->db->update('pos_sales',$data,array('invoice_no'=>$invoice_no,'company_id'=> $_SESSION['company_id']));
       
    }
    
    
    //ITS SHARIF CUSTOM CLEARING AGENT 
    //THIS FUNCTION WILL USE FOR ONLY SHARIF CUSTOM CLEARING AGENT
    //function get_sales_items($new_invoice_no)//for receipt
//    {
//       $this->db->select('A.sale_date,A.amount_due,A.register_mode,A.employee_id,A.discount_value,A.customer_id,
//       A.currency_id,A.description,A.no_of_pkg,A.pkg_desc,A.gd_no,A.gd_date,A.awb_no,A.awb_date,
//       B.unit,B.item_id,B.size_id,B.color_id,B.item_unit_price,B.item_cost_price,B.quantity_sold,B.discount_percent');
//       $this->db->join('pos_sales_items as B','A.sale_id = B.sale_id');
//       $query = $this->db->get_where('pos_sales as A',array('A.invoice_no'=>$new_invoice_no,'A.company_id'=> $_SESSION['company_id']));
//       return $query->result_array();
//       
//    }
    
    function get_sales_items($new_invoice_no)//for receipt
    {
       $this->db->select('A.sale_date,A.sale_time,A.amount_due,A.register_mode,A.employee_id,A.discount_value as total_discount,A.customer_id,
       A.currency_id,A.description,A.invoice_no,A.account,A.is_taxable,
       B.unit_id,B.item_id,B.size_id,B.item_unit_price,B.item_cost_price,B.quantity_sold,B.exchange_rate,B.service,
       B.discount_percent,B.discount_value,B.tax_rate,B.tax_id,B.inventory_acc_code');
       $this->db->join('pos_sales_items as B','A.sale_id = B.sale_id');
       $query = $this->db->get_where('pos_sales as A',array('A.invoice_no'=>$new_invoice_no,'A.company_id'=> $_SESSION['company_id']));
       return $query->result_array();
       
    }
    
    function get_sales_by_invoice($invoice_no)
    {   
        $this->db->where(array('invoice_no'=>$invoice_no,'company_id'=>$_SESSION['company_id']));
        $query = $this->db->get('pos_sales');
        return $query->result_array();
       
    }
    
    function get_sales_items_only($invoice_no)//for receipt
    {
    //    $this->db->select('A.sale_date,A.sale_time,A.amount_due,A.register_mode,A.employee_id,A.discount_value as total_discount,A.customer_id,
    //    A.currency_id,A.description,A.invoice_no,A.account,A.is_taxable,
    //    B.unit_id,B.item_id,B.size_id,B.item_unit_price,B.item_cost_price,B.quantity_sold,B.exchange_rate,B.service,
    //    B.discount_percent,B.discount_value,B.tax_rate,B.tax_id,B.inventory_acc_code');
    //    $this->db->join('pos_sales_items as B','A.sale_id = B.sale_id');
       
       $this->db->where(array('invoice_no'=>$invoice_no,'company_id'=>$_SESSION['company_id']));
       $query = $this->db->get('pos_sales_items');
       return $query->result_array();
       
    }
    function getMAXSaleInvoiceNo()
    {   
        $this->db->order_by('CAST(SUBSTR(invoice_no,2) AS UNSIGNED) DESC');
        $this->db->select('SUBSTR(invoice_no,2) as invoice_no');
        $this->db->where('company_id', $_SESSION['company_id']);
        $query = $this->db->get('pos_sales',1);
        return $query->row()->invoice_no;
    }
    
    public function get_totalCostBysaleID($invoice_no)
    {
       $this->db->select('SUM(item_unit_price*quantity_sold) as price, SUM(discount_value) as discount_value');   
       $query = $this->db->get_where('pos_sales_items',array('invoice_no'=>$invoice_no));
       $rows = $query->row();
       if($rows)
       {
        return floatval($rows->price-$rows->discount_value);
       }
       
    }
    
    function delete($invoice_no)
    {
        $this->db->delete('pos_sales',array('invoice_no'=>$invoice_no,'company_id'=> $_SESSION['company_id']));
        
        $this->db->delete('pos_sales_items',array('invoice_no'=>$invoice_no,'company_id'=> $_SESSION['company_id']));
        
        $this->db->delete('acc_entries',array('invoice_no'=>$invoice_no,'company_id'=> $_SESSION['company_id']));
        $this->db->delete('acc_entry_items',array('invoice_no'=>$invoice_no,'company_id'=> $_SESSION['company_id']));
        
        $this->db->delete('pos_customer_payments',array('invoice_no'=>$invoice_no,'company_id'=> $_SESSION['company_id']));
    }

    public function get_totalSalesByCategory()
    {
        $data = 0;
        $this->db->select('SUM(rt.item_cost_price*rt.quantity_sold) as amount, r.currency_id,it.category_id');   
        $this->db->join('pos_sales_items as rt','rt.item_id = it.item_id','left');
        $this->db->join('pos_sales as r','r.sale_id = rt.sale_id','left');
        $this->db->group_by('it.category_id');
        $query = $this->db->get_where('pos_items it',array('r.company_id'=>$_SESSION['company_id']));
        
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        
        return array();
    }

}
    