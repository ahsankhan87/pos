<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_dashboard extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function totalStock($company_id)
    {
        //SELECT sum(quantity*avg_cost) as stock FROM pos_items_detail as pid join  `pos_items` pi on pid.item_id=pi.item_id where company_id = 4 
        $this->db->select('SUM(quantity*avg_cost) as stock');
        $this->db->join('pos_items pi','pi.item_id=pid.item_id');
        $this->db->where('pi.company_id',$company_id);
        $this->db->where('pi.deleted',0);
        $this->db->where('pid.deleted',0);
        $query = $this->db->get('pos_items_detail pid');
        
        if($row = $query->row())
        {
            return $row->stock;
        }
        return 0;        
    }
    
    function monthlySaleReport($company_id,$year,$account_name ='sales')
    {
        if($this->db->dbdriver === 'sqlite3')
        {
            //THIS QUERY WILL BE USED FOR DESKTOP APPLICATION SQLITE
            $query_string = 
            'SELECT strftime("%m-%Y",ei.date) as month, sum(debit-credit) AS revenue
            FROM acc_groups AS G JOIN acc_entry_items AS ei ON G.account_code = ei.account_code
            WHERE ei.company_id = '.$company_id.' AND ei.date >= '.FY_START_DATE.' AND ei.date <= '.FY_END_DATE.' 
            AND G.company_id = '.$company_id.' AND G.name = "'.$account_name.'"
            GROUP BY strftime("%m-%Y",ei.date)';
         
            
        }else if($this->db->dbdriver === 'mysqli')
        {
            //THIS QUERY WILL BE USED FOR WEB APPLICATION
            $query_string = 
            'SELECT DATE_FORMAT(ei.date, "%M-%y") as month, sum(debit-credit) AS revenue
            FROM acc_groups AS g JOIN acc_entry_items AS ei ON g.account_code = ei.account_code 
            WHERE ei.company_id = '.$company_id.' AND ei.date >= '.FY_START_DATE.' AND ei.date <= '.FY_END_DATE.' 
            AND g.company_id = '.$company_id.' AND g.name = "'.$account_name.'"
            GROUP BY DATE_FORMAT(ei.date,"%m-%Y")';
        }
        $query = $this->db->query($query_string);
        $data = $query->result_array();
        return $data;
    }
    
    public function get_ExpensesAccounts($group_name = '',$fy_start_date='',$fy_end_date='',$LIMIT=null)
    {
        //$this->db->order_by('item_id','asc');
        $this->db->select('account_code,id, name');//select from groups
        $options = array('name'=> $group_name,'company_id'=> $_SESSION['company_id']);
        
        $query1 = $this->db->get_where('acc_groups',$options);
        $grp_data = $query1->result_array();
        //var_dump($grp_data[0]['id']);
        $this->db->where('ei.date >=', $fy_start_date);
        $this->db->where('ei.date <=', $fy_end_date);
        
        $options1 = array('g.parent_code'=> @$grp_data[0]['account_code'],'ei.company_id'=> $_SESSION['company_id'],
        'g.company_id'=> $_SESSION['company_id']);
        $this->db->select('g.title,g.name,sum(debit-credit)as balance');
        $this->db->join('acc_entry_items ei','ei.account_code=g.account_code');
        $this->db->group_by('ei.account_code');
        
        $query = $this->db->get_where('acc_groups g',$options1,$LIMIT);
        
        if($query->num_rows() > 0)
        {
            $ledgers = $query->result_array();
            
            return $ledgers;
        }
        
        return false;
    }
    
    public function get_level2_account_balance($group_name = '',$fy_start_date='',$fy_end_date='',$LIMIT=null)
    {
        $total=0;
        //$this->db->order_by('item_id','asc');
        $this->db->select('account_code,id, name');//select from groups
        $options = array('name'=> $group_name,'company_id'=> $_SESSION['company_id']);
        
        $query1 = $this->db->get_where('acc_groups',$options);
        $grp_data = $query1->result_array();
        //var_dump($grp_data[0]['id']);
        $this->db->where('ei.date >=', $fy_start_date);
        $this->db->where('ei.date <=', $fy_end_date);
        
        $options1 = array('g.parent_code'=> @$grp_data[0]['account_code'],'ei.company_id'=> $_SESSION['company_id'],
        'g.company_id'=> $_SESSION['company_id']);
        $this->db->select('sum(debit-credit)as balance');
        $this->db->join('acc_entry_items ei','ei.account_code=g.account_code');
        //$this->db->join('acc_entries e','ei.entry_id=e.id');
        //$this->db->group_by('ei.account_code');
        
        $query = $this->db->get_where('acc_groups g',$options1,$LIMIT);
        
        if($data = $query->row() )
        {
            return $data->balance;
            //foreach($query->result_array() as $values)
//            {
//                $total += $values['balance'];
//            }
//            return  abs($total);
        }
        
        return false;
    }
    
    public function get_level3_account_balance($group_name = '',$fy_start_date= null,$fy_end_date= null,$LIMIT=1)
    {
        if($fy_start_date != null)
        {
            $this->db->where('ei.date >=', $fy_start_date);
        
        }
        
        if($fy_end_date != null)
        {
            $this->db->where('ei.date <=', $fy_end_date);
        
        }
        
        $total_op = 0;
        $options = array('g.name'=> $group_name, 'g.company_id'=> $_SESSION['company_id']);
        $this->db->select('g.account_code,(g.op_balance_dr-g.op_balance_cr) as OP_balance');
        
        $query = $this->db->get_where('acc_groups g',$options);
        
        if($data = $query->row() )
        {
            $total_op = $data->OP_balance;
        }

        $total_balance =0;
        $options1 = array('ei.account_code'=> @$data->account_code, 'ei.company_id'=> $_SESSION['company_id']);
        $this->db->select('sum(ei.debit-ei.credit) as balance');
        //$this->db->join('acc_entry_items ei','ei.account_code=g.account_code','');
        //$this->db->group_by('ei.account_code');
        
        $query1 = $this->db->get_where('acc_entry_items ei',$options1);
        
        if($data1 = $query1->row() )
        {
            $total_balance = $data1->balance;
        }
        
        return ($total_op+$total_balance);
    }
    
    //get the month sale whatever month is given in parameter.
    public function today_sale($today = "yyyy-mm-dd",$company_id=0,$ledger_name='sales')
    {
        $total=0;
        $this->db->select('sum(debit-credit)as balance');
        $this->db->where('ei.date >=', FY_START_DATE);
        $this->db->where('ei.date <=', FY_END_DATE);
        
        $this->db->join('acc_entry_items ei','ei.account_code=g.account_code');
        $options = array('ei.company_id'=> $company_id,'g.company_id'=> $company_id,'g.name'=>$ledger_name,'ei.date'=>$today);
        
        // $this->db->where('l.name',$ledger_name);
        $this->db->group_by('g.account_code');
        
        $query = $this->db->get_where('acc_groups g',$options);
        $ledgers = $query->result_array();
        
        foreach($ledgers as $values)
        {
            $total = $values['balance'];
            //$month_sale += $total_unit_price;
        }
        return  abs($total);
    }

    public function today_sale_1($today = "yyyy-mm-dd",$company_id=0)
    {
        $total=0;
        $this->db->select('SUM(total_amount) as today_sale');
        $this->db->where('sale_date >=', FY_START_DATE);
        $this->db->where('sale_date <=', FY_END_DATE);
        
        $options = array('company_id'=> $company_id,'sale_date'=>$today);
        
        $query = $this->db->get_where('pos_sales',$options);
        // $ledgers = $query->result_array();
        
        if($data1 = $query->row())
        {
            return $data1->today_sale;
        }

        return 0;
    }
    
    public function cur_month_sale($month = "yyyy-mm",$company_id=0)
    {
        $total=0;
        $this->db->select('SUM(total_amount) as today_sale');
        $this->db->where('sale_date >=', FY_START_DATE);
        $this->db->where('sale_date <=', FY_END_DATE);
        $this->db->like('sale_date',$month,'right');
        
        $options = array('company_id'=> $company_id);
        
        $query = $this->db->get_where('pos_sales',$options);
        // $ledgers = $query->result_array();
        
        if($data1 = $query->row())
        {
            return $data1->today_sale;
        }

        return 0;
    }
    
    //get the month sale whatever month is given in parameter.
    public function month_sale($month = "yyyy-mm",$company_id=0,$ledger_name='sales')
    {
        $total=0;
        $this->db->select('sum(debit-credit)as balance');
        $this->db->join('acc_entry_items ei','ei.account_code=g.account_code');
        //$this->db->join('acc_entries e','e.id=ei.entry_id');        
        $options = array('ei.company_id'=> $company_id,'g.company_id'=> $company_id,'g.name'=>$ledger_name);
        $this->db->like('ei.date',$month,'right');
        $this->db->group_by('g.account_code');
        $this->db->where('ei.date >=', FY_START_DATE);
        $this->db->where('ei.date <=', FY_END_DATE);
        
        $query = $this->db->get_where('acc_groups g',$options);
        $ledgers = $query->result_array();
        
        foreach($ledgers as $values)
        {
            $total = $values['balance'];
            //$month_sale += $total_unit_price;
        }
        return  abs($total);
    }
    
    public function month_sales($company_id)
    {
        $this->db->select('date_format(sale_date,"%Y-%m") as month,sum(total_amount)as amount');
        //$this->db->join('acc_entry_items ei','ei.account_code=g.account_code');
        //$this->db->join('acc_entries e','e.id=ei.entry_id');        
        $options = array('company_id'=> $company_id);
        $this->db->group_by('date_format(sale_date,"%Y-%m")');
        $this->db->order_by('month','desc');
        $this->db->where('sale_date >=', FY_START_DATE);
        $this->db->where('sale_date <=', FY_END_DATE);
        
        $query = $this->db->get_where('pos_sales',$options,12);
        $ledgers = $query->result_array();
        
        return  $ledgers;
    }
    
    function top10_selled_products()
    {
        $this->db->select('p.name as product,sz.name as size,SUM(st.quantity_sold) as qty');
        $options = array('s.company_id'=> $_SESSION['company_id'],'p.company_id'=> $_SESSION['company_id'],'s.register_mode'=> 'sale');
        
        $this->db->join('pos_sales s','s.invoice_no=st.invoice_no');
        $this->db->join('pos_items p','st.item_id=p.item_id','LEFT');
        $this->db->join('pos_sizes sz','sz.id=st.size_id','LEFT');
        
        $this->db->group_by('st.item_id, st.size_id');
        $this->db->order_by('SUM(st.quantity_sold)','DESC');
        
        $query=$this->db->get_where('pos_sales_items st',$options,10);
        $data = $query->result_array();
        return $data;
    }

     
    public function total_ac_receivable_amount($company_id)
    {
        $total=0;
        $this->db->select('sum(debit-credit) as balance');
        $options = array('company_id'=> $company_id);
        $this->db->where('date >=', FY_START_DATE);
        $this->db->where('date <=', FY_END_DATE);
        
        $query = $this->db->get_where('pos_customer_payments',$options);
        $ledgers = $query->result_array();
        
        foreach($ledgers as $values)
        {
            $total = $values['balance'];
            //$month_sale += $total_unit_price;
        }
        return  abs($total);
    }
     
    public function total_ac_payable_amount($company_id)
    {
        $total=0;
        $this->db->select('sum(debit-credit) as balance');
        $options = array('company_id'=> $company_id);
        $this->db->where('date >=', FY_START_DATE);
        $this->db->where('date <=', FY_END_DATE);
        
        $query = $this->db->get_where('pos_supplier_payments',$options);
        $ledgers = $query->result_array();
        
        foreach($ledgers as $values)
        {
            $total = $values['balance'];
            //$month_sale += $total_unit_price;
        }
        return  abs($total);
    }
    
}