<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_reports extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        
    }
    
    function get_trial_balance($company_id,$fy_start_date,$fy_end_date)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $this->db->select('(ei.debit-ei.credit) as balance,g.op_balance_dr,g.op_balance_cr, g.title,g.title_ur, g.account_code');
        $this->db->join('acc_entry_items ei','ei.account_code=g.account_code','INNER');
        $this->db->where('ei.date >=', $fy_start_date);
        $this->db->where('ei.date <=', $fy_end_date);
        $this->db->group_by('g.title');
        $this->db->where('ei.company_id', $company_id);
        $this->db->where('g.company_id', $company_id);
        
        $query = $this->db->get('acc_groups g');
        
        $data = $query->result_array();
        
        return $data;
    }
    
    public function get_parentGroups4pl($company_id)
    {
        $this->db->order_by('g.account_code','asc');
        $this->db->select('g.title,g.title_ur,g.account_code,g.parent_code');
        $this->db->join('account_types at','at.id=g.account_type_id');
        $this->db->where('g.company_id', $company_id);
        $this->db->where('g.level', 2);
        $this->db->where_in('at.name',array("expense",'cos',"revenue"));
        
        $query = $this->db->get('acc_groups g');
        $data = $query->result_array();
        return $data;
   
    }
    public function get_parentGroups4Assets($company_id) //for balance sheet Assets
    {
        //$this->db->order_by('sort','asc');
        $this->db->select('g.title,g.title_ur,g.account_code,g.parent_code');
        $this->db->join('account_types at','at.id=g.account_type_id');
        $this->db->where('g.company_id', $company_id);
        $this->db->where('g.level', 2);
        $this->db->where_in('at.name',array("asset"));
        
        $query = $this->db->get('acc_groups g');
        $data = $query->result_array();
        return $data;
   
    }
    
    public function get_parentGroups4Liability($company_id) //for balance sheet Liability
    {
        //$this->db->order_by('sort','asc');
        $this->db->select('g.title,g.title_ur,g.account_code,g.parent_code');
        $this->db->join('account_types at','at.id=g.account_type_id');
        $this->db->where('g.company_id', $company_id);
        $this->db->where('g.level', 2);
        $this->db->where_in('at.name',array("liability",'equity'));
        
        $query = $this->db->get('acc_groups g');
        $data = $query->result_array();
        return $data;
   
    }
    function get_profit_loss($company_id,$parent_code,$fy_start_date,$fy_end_date)
    {
        $this->db->select('SUM(credit) as credit, SUM(debit) as debit,g.parent_code, g.title,g.title_ur, g.account_code');
        $this->db->join('acc_entry_items ei','ei.account_code=g.account_code');
        //$this->db->join('acc_entries e','ei.entry_id=e.id');
        $this->db->where('ei.date >=', $fy_start_date);
        $this->db->where('ei.date <=', $fy_end_date);
        $this->db->where('ei.company_id', $company_id);
        $this->db->where('g.parent_code', $parent_code);
        $this->db->where('g.company_id', $company_id);
        
        $this->db->order_by('g.account_code','asc');
        $this->db->group_by('g.title');
        $query = $this->db->get('acc_groups g');
        //$query = $this->db->query($query_string);
        $data = $query->result_array();
        return $data;
    }
    
    function get_Assets4BalanceSheet($company_id,$parent_code,$fy_start_date,$fy_end_date)
    {
        $this->db->select('SUM(debit-credit) as balance, (g.op_balance_dr-g.op_balance_cr) as op_balance,g.parent_code, g.title,g.title_ur, g.account_code');
        $this->db->join('acc_entry_items ei','ei.account_code=g.account_code');
        $this->db->where('ei.date >=', $fy_start_date);
        $this->db->where('ei.date <=', $fy_end_date);
        $this->db->where('g.parent_code', $parent_code);
        
        $this->db->order_by('g.account_code','asc');
        $this->db->where('ei.company_id', $company_id);
        //$this->db->where('g.company_id', $company_id);
        
        $this->db->group_by('g.title');
        
        $query = $this->db->get('acc_groups g');
        //$query = $this->db->query($query_string);
        $data = $query->result_array();
        return $data;
    }
    
    function get_Liability4BalanceSheet($company_id,$parent_code,$fy_start_date,$fy_end_date)
    {
        $this->db->select('SUM(credit-debit) as balance, (g.op_balance_dr-g.op_balance_cr) as op_balance,g.parent_code, g.title,g.title_ur, g.account_code');
        $this->db->join('acc_entry_items ei','ei.account_code=g.account_code');
        $this->db->where('ei.date >=', $fy_start_date);
        $this->db->where('ei.date <=', $fy_end_date);
        $this->db->where('ei.company_id', $company_id);
        $this->db->where('g.parent_code', $parent_code);
        //$this->db->where('g.company_id', $company_id);
        
        $this->db->order_by('g.account_code','asc');
         $this->db->group_by('g.title');
        $query = $this->db->get('acc_groups g');
        //$query = $this->db->query($query_string);
        $data = $query->result_array();
        return $data;
    }
    
    function get_net_income()
    {
        $query_string = 
        'SELECT sum(debit-credit) AS net_income
        FROM account_types at join acc_groups g ON at.id=g.account_type_id JOIN acc_entry_items ei ON ei.account_code=g.account_code
        WHERE ei.company_id = '.$_SESSION['company_id'].' AND g.company_id = '.$_SESSION['company_id'].' AND ei.date BETWEEN "'.FY_START_DATE.'" AND "'.FY_END_DATE.'" AND at.name in ("expense","cos","revenue")';
        
        $query = $this->db->query($query_string);
        
        if($row = $query->row())
        {
            return $row->net_income;
        }
    }
    
    function year_report($company_id,$month,$year,$account_code)
    {
        if($this->db->dbdriver === 'sqlite3')
        {
            //FOR DESKTOP APP ONLY
            $this->db->select('strftime("%m",ei.date) as month,SUM(debit-credit) as balance');
            $this->db->group_by('g.account_code,strftime("%m",ei.date)');
            $this->db->where(array('ei.company_id'=>$company_id,'g.company_id'=>$company_id,'strftime("%m",ei.date)'=>$month,
            'strftime("%Y",ei.date)'=>$year,'ei.account_code'=>$account_code));
            $this->db->join('acc_entry_items ei','ei.account_code=g.account_code');
        
        }else if($this->db->dbdriver === 'mysqli')
        {
            //FOR WEB APP ONLY
            $this->db->select('MONTH(ei.date) as month,SUM(debit-credit) as balance');
            $this->db->group_by('g.account_code,MONTH(ei.date)');
            $this->db->where(array('ei.company_id'=>$company_id,'g.company_id'=>$company_id,'MONTH(ei.date)'=>$month,
            'YEAR(ei.date)'=>$year,'ei.account_code'=>$account_code));
            $this->db->join('acc_entry_items ei','ei.account_code=g.account_code');
        
        }
        
        $query = $this->db->get('acc_groups g');
        if($data = $query->row())
        {
            return $data->balance;    
        }else{
            return 0;
        }
        
    }
}
?>