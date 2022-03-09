<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_groups extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
    }
    
    //get all products and also only one product and active and inactive too.
    public function get_groups($account_code = FALSE,$company_id)
    {
        if($account_code === FALSE)
        {
            $this->db->select("id,account_code,title,title_ur,op_balance_dr,op_balance_cr,type,level");
            $this->db->order_by('account_code','asc');
            $option = array('company_id'=> $company_id);
            $query = $this->db->get_where('acc_groups',$option);
            $data = $query->result_array();
            return $data;
        }
        
        $this->db->select("id,account_code,title,title_ur,op_balance_dr,op_balance_cr,type,level");
        
        $this->db->order_by('account_code','asc');
        $options = array('account_code'=> $account_code,'company_id'=> $company_id);
        
        $query = $this->db->get_where('acc_groups',$options);
        $data = $query->result_array();
        return $data;
    }
    
    public function get_groupsByID($id = FALSE,$company_id)
    {
        if($id  === FALSE)
        {
            $this->db->order_by('account_code','asc');
            $option = array('company_id'=> $company_id);
            $query = $this->db->get_where('acc_groups',$option);
            $data = $query->result_array();
            return $data;
        }
        
        $this->db->order_by('account_code','asc');
        $options = array('id '=> $id ,'company_id'=> $company_id);
        
        $query = $this->db->get_where('acc_groups',$options);
        $data = $query->result_array();
        return $data;
    }
    
    public function get_detail_accounts($account_code = FALSE,$company_id)
    {
        if($account_code != FALSE)
        {
            $this->db->where('account_code', $account_code);
        }
        
        $this->db->order_by('account_code','asc');
        $options = array('type'=>'detail','company_id'=> $company_id);
        
        $query = $this->db->get_where('acc_groups',$options);
        $data = $query->result_array();
        return $data;
    }
    
    //retrieve journal entries against ledger account.
    public function entriesByAccount($account_code,$fy_start_date,$fy_end_date)
    {
        //$query = $this->db->query("Select * FROM acc_entry_items WHERE entry_id in (SELECT entry_id FROM acc_entry_items WHERE ledger_id = {$ledger_id})");
        $this->db->select('*')->from('acc_entry_items')->where('account_code', $account_code);
        $this->db->where('company_id',$_SESSION['company_id']);
        $this->db->where('date >=', $fy_start_date);
        $this->db->where('date <=', $fy_end_date);

        $query = $this->db->get();
        $data = $query->result_array();
        
        return $data;
    }
    
    //get groups only for profit and loss whic affects gross
    public function get_GroupsByParent($parent_code=0)
    {
        $this->db->select("id,account_code,title,title_ur,op_balance_dr,op_balance_cr,type,level,parent_code");
        $this->db->order_by('account_code','asc');
        $option = array('parent_code'=>$parent_code,'company_id'=> $_SESSION['company_id']);
        $query = $this->db->get_where('acc_groups',$option);
        $data = $query->result_array();
        return $data;
   
    }
    
    //get groups only for profit and loss whic affects gross
    public function get_parentGroups4PL($company_id)
    {
        $this->db->order_by('sort','desc');
        $option = array('company_id'=> $company_id,'parent_code'=>0);
        $query = $this->db->get_where('acc_groups',$option);
        $data = $query->result_array();
        return $data;
   
    }
  
    public function get_accountByName($group_name = '')
    {
        $options = array('name'=> $group_name);
        
        $this->db->select('id, name, title');//select from ledgers
        $query = $this->db->get_where('acc_groups',$options);
        
        if($query->num_rows() > 0)
        {
            $ledgers = $query->result_array();
            
            return $ledgers;
        }
        
        return $ledgers = 'Not Found';
    }
    
    public function get_ExpensesAcc($group_name = '')
    {
        //$this->db->order_by('item_id','asc');
        $this->db->select('ge.account_code,ge.id, ge.name');//select from groups
        $options = array('ge.name'=> $group_name,'ge.company_id'=> $_SESSION['company_id']);
        
        $query1 = $this->db->get_where('acc_groups ge',$options);
        $grp_data = $query1->result_array();
        //var_dump($grp_data[0]['id']);
        $options1 = array('g.parent_code'=> $grp_data[0]['account_code'],'g.company_id'=> $_SESSION['company_id']);
        $query = $this->db->get_where('acc_groups g',$options1);
        
        if($query->num_rows() > 0)
        {
            $ledgers = $query->result_array();
            
            return $ledgers;
        }
        
        return $ledgers = 'Not Found';
    }
    function getAllGroupsDDL($company_id,$lang)
    {
        $data = array();
        $data[''] = '--Please Select--';
        
        $this->db->group_by('account_code','asc');
        $option = array('company_id'=> $company_id,'type'=>'group');
        $query = $this->db->get_where('acc_groups',$option);
            
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                 $data[$row['account_code']] = ($lang == 'en' ? $row['title'] : $row['title_ur']);
            }
        }
        $query->free_result();
        return $data;
    }
    
    function getGrpDetailDropDown($company_id,$lang)
    {
        $data = array();
        $data[''] = '--Please Select--';
        
        $this->db->group_by('account_code','asc');
        $option = array('company_id'=> $company_id,'type'=>'detail');
        $query = $this->db->get_where('acc_groups',$option);
            
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                 $data[$row['account_code']] = ($lang == 'en' ? $row['title'] : $row['title_ur']);
            }
        }
        $query->free_result();
        return $data;
    }
    
     function addGroups()
    {
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
                //GET NEW ACCOUNT CODE
                //SELECT MAX OF PREV ACCOUNT CODE AND PLUS 1
                $parent_code = $this->input->post('parent_code',true);
                $max_acc_code = $this->GetMaxAccCode($parent_code,$_SESSION['company_id']);
                //
        
                $data = array(
                'company_id'=> $_SESSION['company_id'],
                'name' => $this->input->post('name',true),
                'title' => $this->input->post('title',true),
                'title_ur' => $this->input->post('title_ur',true),
                'parent_code' => $this->input->post('parent_code',true),
                'account_code' => $max_acc_code,
                'type' => $this->input->post('type',true),
                'level' => $this->input->post('level',true),
                'account_type_id' => $this->input->post('account_type_id',true),
                'date_created' => date('Y-m-d H:i:s')
                );
                
    }
    //}
    }
    
    function GetMaxAccCode($parent_acc_code,$company_id)
    {
        //GET NEW ACCOUNT CODE
        //SELECT MAX OF PREV ACCOUNT CODE AND PLUS 1
          $this->db->select_max('account_code');
            $option = array('parent_code'=> $parent_acc_code,'company_id'=>$company_id);
            $query = $this->db->get_where('acc_groups',$option,1);
            if($query->row()->account_code || $parent_acc_code == 0 || $parent_acc_code == '')
            {
                $max_acc_code = $query->row()->account_code+1;            
            }else{
                $max_acc_code = $parent_acc_code.'00';
            }
            return $max_acc_code;
        
    }
    
    function editGroups()
    {
        $data = array(
        'company_id'=> $_SESSION['company_id'],
        'name' => $this->input->post('name',true),
        'title' => $this->input->post('title',true),
        'title_ur' => $this->input->post('title_ur',true),
        'parent_code' => $this->input->post('parent_code',true),
        'account_code' => $this->input->post('account_code',true),
        'type' => $this->input->post('type',true),
        'level' => $this->input->post('level',true),
        'account_type_id' => $this->input->post('account_type_id',true),
        'date_created' => date('Y-m-d H:i:s')
         );
        
       $this->db->update('acc_groups', $data, array('id'=>$this->input->post('id')));
            
    }
    
    function editGroupOPBalance($account_code,$op_balance_dr,$op_balance_cr)
    {
        $data = array(
        'op_balance_dr' => $op_balance_dr,
        'op_balance_cr' => $op_balance_cr,
         );
        
       $this->db->update('acc_groups', $data, array('account_code'=>$account_code,'company_id'=> $_SESSION['company_id']));
            
    }
    function get_account_balance($company_id,$fy_start_date,$fy_end_date,$account_code)
    {
        $this->db->select('SUM(debit-credit) as balance');
        $this->db->join('acc_entry_items ei','ei.account_code=g.account_code');
        //$this->db->join('acc_entries e','ei.entry_id=e.id');
        $this->db->where(array('ei.company_id'=>$company_id,'g.company_id'=> $company_id,'ei.account_code'=>$account_code));
        $this->db->where('ei.date >=', $fy_start_date);
        $this->db->where('ei.date <=', $fy_end_date);
        $this->db->group_by('g.account_code');
        
        $query =$this->db->get('acc_groups g');    
        if($query->row())
        {
            return $query->row()->balance;
        }else{
            return 0;
        }
    }
    
    function account_has_entry($account_code)
    {
        $this->db->where('account_code',$account_code);
        $query =$this->db->get('acc_entry_items');    
        if($query->num_rows() > 0)
        {
            return true;
        }else{
            return false;
        }
    }
    
    function deleteGroup($account_code)
    {
        $this->db->delete('acc_groups',array('account_code'=>$account_code));
    }
    
    //////////////////////////
    ////ACCOUNT TYPES///////////
    function getAccTypesDropDown()
    {
        $data = array();
        $data[''] = '--Please Select--';
        
        $query = $this->db->get('account_types');
            
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                 $data[$row['id']] = $row['title'];
            }
        }
        $query->free_result();
        return $data;
    }
}