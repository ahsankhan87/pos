<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pos_reports extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        
    }
    
    function fill_calendar($start_date, $end_date,$company_id)
    {
        //$unixtime = strtotime($start_date);
//        $month = date('m', $unixtime); //month
//        $day = date('d', $unixtime); 
//        $year = date('y', $unixtime );
    
        while($start_date <= $end_date)
        {
            $unixtime = strtotime($start_date); //convert to UNIX timestamp
            $month = date('m', $unixtime); //month
            //$day = date('d', $unixtime); 
            $year = date('Y', $unixtime );
        
            $data = array(
                'company_id'=> $company_id,
                'day' => $start_date,
                'month' => $month,
                'year' => $year,
                'quarter' => (($month / 4) + 1)
                
                );
                
           $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
            
           $this->db->insert('calendar_days',$data);     
        }
    }
    
    public function sales_reports($from_date=null,$to_date=null,$company_id=0,$customer_id=null,$product_id=null,$emp_id=null,$register_mode='sale',$sale_type='cash'){
    
        if($customer_id != null && $customer_id != 0){
            $this->db->where('A.customer_id',$customer_id);
        }
        
        if($product_id != null && $product_id != 0){
            $this->db->where('B.item_id',$product_id);
        }
        
        if($emp_id != null && $emp_id != 0){
            $this->db->where('A.employee_id',$emp_id);
        }
        
        if($from_date != null && $to_date != null){
            $this->db->where("A.sale_date BETWEEN '$from_date' AND '$to_date'");
        }
       if($register_mode != 'all')
       {
            $this->db->where('A.register_mode',$register_mode); 
       } 
       if($sale_type != 'all')
       {
            $this->db->where('A.account',$sale_type); 
       } 
       
       $this->db->join('pos_sales_items AS B','A.sale_id = B.sale_id');
       $this->db->where('A.company_id',$company_id);
       $query = $this->db->get('pos_sales AS A');
       
       $data = $query->result_array();
       return $data;
       
    }
    
    public function customer_wise_sales($from_date=null,$to_date=null,$company_id=0,$emp_id=null,$register_mode='sale',$sale_type='cash'){
    
        if($from_date != null && $to_date != null){
            $this->db->where("A.sale_date BETWEEN '$from_date' AND '$to_date'");
            }
        
        if($emp_id != null && $emp_id != 0){
            $this->db->where('A.employee_id',$emp_id);
            }
        
       if($register_mode != 'all')
           {
                $this->db->where('A.register_mode',$register_mode); 
           } 
       if($sale_type != 'all')
           {
                $this->db->where('A.account',$sale_type); 
           } 
       
       $this->db->select('A.sale_date, A.sale_id,A.employee_id, A.customer_id,A.invoice_no,SUM(B.quantity_sold*B.item_unit_price) as price, SUM(B.discount_value) as discount_value');
       $this->db->join('pos_sales_items AS B','A.sale_id = B.sale_id');
       $this->db->where('A.company_id',$company_id);
       $this->db->group_by('A.customer_id');
       
       $query = $this->db->get('pos_sales AS A');
       
       $data = $query->result_array();
       return $data;
       
    }
    
    public function product_wise_sales($from_date=null,$to_date=null,$company_id=0,$emp_id=null,$register_mode='sale',$sale_type='cash'){
    
        if($from_date != null && $to_date != null){
            $this->db->where("A.sale_date BETWEEN '$from_date' AND '$to_date'");
        }
        
        if($emp_id != null && $emp_id != 0){
            $this->db->where('A.employee_id',$emp_id);
        }
         
       if($register_mode != 'all')
        {
            $this->db->where('A.register_mode',$register_mode); 
        } 
       if($sale_type != 'all')
        {
            $this->db->where('A.account',$sale_type); 
        } 
       
       $this->db->select('A.sale_date, A.sale_id,A.employee_id,B.size_id, B.item_id,A.invoice_no,SUM(B.quantity_sold) as qty');
       $this->db->join('pos_sales_items AS B','A.sale_id = B.sale_id');
       //$this->db->join('pos_sizes AS C','B.size_id = C.size_id');
       $this->db->where('A.company_id',$company_id);
       $this->db->group_by('B.item_id');
       
       $query = $this->db->get('pos_sales AS A');
       
       $data = $query->result_array();
       return $data;
       
    }
    
    
    public function category_wise_sales($from_date=null,$to_date=null,$company_id=0,$emp_id=null,$register_mode='sale',$sale_type='cash'){
    
        if($from_date != null && $to_date != null){
            $this->db->where("A.sale_date BETWEEN '$from_date' AND '$to_date'");
        }
        
        if($emp_id != null && $emp_id != 0){
            $this->db->where('A.employee_id',$emp_id);
        }
         
       if($register_mode != 'all')
           {
                $this->db->where('A.register_mode',$register_mode); 
           } 
       if($sale_type != 'all')
           {
                $this->db->where('A.account',$sale_type); 
           } 
       
       $this->db->select('SUM(B.item_unit_price*B.quantity_sold-B.discount_value) as amount,A.sale_date,A.employee_id,A.invoice_no,
       B.item_id,SUM(B.quantity_sold) as qty,
       C.name as category');
       $this->db->join('pos_sales AS A','A.sale_id = B.sale_id','left');
       $this->db->join('pos_items AS P','P.item_id = B.item_id','left');
       $this->db->join('pos_categories AS C','C.id = P.category_id','left');
       $this->db->where('A.company_id',$company_id);
       $this->db->group_by('C.id');
    //    $this->db->having('B.item_id > 0');
       $query = $this->db->get('pos_sales_items AS B');

       $data = $query->result_array();
       return $data;
       
    }
    public function receivings_report($from_date=null,$to_date=null,$company_id=0,$supplier_id=null,$product_id=null,$emp_id=null,$register_mode='receive',$sale_type='cash'){
    
        if($supplier_id != null && $supplier_id != 0){
            $this->db->where('A.supplier_id',$supplier_id);
        }
        
        if($product_id != null && $product_id != 0){
            $this->db->where('B.item_id',$product_id);
        }
        
        if($emp_id != null && $emp_id != 0){
            $this->db->where('A.employee_id',$emp_id);
        }
        
       if($register_mode != 'all')
       {
            $this->db->where('A.register_mode',$register_mode); 
       } 
       if($sale_type != 'all')
       {
            $this->db->where('A.account',$sale_type); 
       } 

        if($from_date != null && $to_date != null){
            $this->db->where("A.receiving_date BETWEEN '$from_date' AND '$to_date'");
        }
        
       $this->db->join('pos_receivings_items AS B','A.receiving_id = B.receiving_id');
       $this->db->where('A.company_id', $company_id);
       $query = $this->db->get('pos_receivings AS A');
       
       $data = $query->result_array();
       return $data;
       
    }
    
    public function receivings_reports_by_invoice_no($from_date=null,$to_date=null,$company_id=0,$invoice_no=''){
    
        $this->db->where('A.invoice_no',$invoice_no);
        
       if($from_date != null && $to_date != null){
            $this->db->where("A.receiving_date BETWEEN '$from_date' AND '$to_date'");
        }
        
       $this->db->join('pos_receivings_items AS B','A.receiving_id = B.receiving_id');
       $this->db->where('A.company_id', $company_id);
       $query = $this->db->get('pos_receivings AS A');
       
       $data = $query->result_array();
       return $data;
       
    }
    
    public function sales_reports_by_invoice_no($from_date=null,$to_date=null,$company_id=0,$invoice_no=''){
    
        $this->db->where('A.invoice_no',$invoice_no);
        
       if($from_date != null && $to_date != null){
            $this->db->where("A.sale_date BETWEEN '$from_date' AND '$to_date'");
        }
        
        //$this->db->order_by('A.sale_date','desc');
       $this->db->join('pos_sales_items AS B','A.sale_id = B.sale_id');
       $this->db->where('A.company_id',$company_id);
       $query = $this->db->get('pos_sales AS A');
       
       $data = $query->result_array();
       return $data;
       
    }
    
    function get_totalCostPurchaseProducts()
    {
        $comp_id = $_SESSION["company_id"];
        
        $query_string = 
        'SELECT DATE_FORMAT(A.sale_date, "%d-%m") AS date, SUM(B.item_unit_price) AS price 
        FROM pos_sales AS A JOIN pos_sales_items AS B 
        ON A.sale_id = B.sale_id 
        WHERE company_id = '.$comp_id.'
        GROUP BY DATE_FORMAT(A.sale_date, "$d-%m-%Y")';
                        
        $query = $this->db->query($query_string);
        $data = $query->result_array();
        return $data;
    }
    
    public function customer_last_sales(){
    
       if($this->db->dbdriver === 'sqlite3')
        {
            //THIS QUERY WILL BE USED FOR DESKTOP APPLICATION SQLITE
            $query_string = 
            "SELECT id,first_name,store_name,address,city,mobile_no FROM pos_customers WHERE id NOT IN
            (SELECT customer_id FROM `pos_sales` WHERE sale_date BETWEEN date('now','-1 month') 
            AND date('now') AND register_mode = 'sale') 
            AND status = 'active'
            AND company_id = ".$_SESSION['company_id']."";
         
            
        }else if($this->db->dbdriver === 'mysqli')
        {
            $query_string = 
            "SELECT id,first_name,store_name,address,city,mobile_no FROM pos_customers WHERE id NOT IN
            (SELECT customer_id FROM `pos_sales` WHERE sale_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) 
            AND CURDATE() AND register_mode = 'sale') 
            AND status = 'active'
            AND company_id = ".$_SESSION['company_id']."";
             
        }
                              
       $query = $this->db->query($query_string);
        
       
       $data = $query->result_array();
       return $data;
       
    }
}