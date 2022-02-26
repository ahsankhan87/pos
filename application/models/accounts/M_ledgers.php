<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ledgers extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        
    }
    
    //get all products and also only one product and active and inactive too.
    public function get_ledgers($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            
            //$this->db->order_by('item_id','asc');
            $option = array('company_id'=> $_SESSION['company_id']);
            $query = $this->db->get_where('acc_ledgers',$option);
            $data = $query->result_array();
            return $data;
        }
        
        //$this->db->order_by('item_id','asc');
        $options = array('id'=> $id,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('acc_ledgers',$options);
        $data = $query->result_array();
        return $data;
    }
    
    //retrieve journal entries against ledger account.
    public function entriesByLedger($ledger_id,$fy_start_date,$fy_end_date)
    {
       // $query = $this->db->query("Select * FROM acc_entry_items WHERE entry_id in (SELECT entry_id FROM acc_entry_items WHERE ledger_id = {$ledger_id})");
        $this->db->select('*')->from('acc_entry_items')->where('ledger_id', $ledger_id);
        $this->db->where('date >=', $fy_start_date);
        $this->db->where('date <=', $fy_end_date);

        $query = $this->db->get();
        $data = $query->result_array();
        
        return $data;
    }
    
    function getLedgerDropDown()
    {
        $data = array();
        $data[0] = '--Please Select Ledger A/C--';
        
        $option = array('company_id'=> $_SESSION['company_id']);
        $query = $this->db->get_where('acc_ledgers',$option);
            
        
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
    
    function addledgers()
    {
        $data = array(
        'company_id'=> $_SESSION['company_id'],
        'name' => $this->input->post('name',true),
        'title' => $this->input->post('title',true),
        //'affects_gross' => $this->input->post('affects_gross',true),
        'op_dr_balance' => $this->input->post('op_dr_balance',true),
        'op_cr_balance' => $this->input->post('op_cr_balance',true),
        'group_id' => $this->input->post('group_id',true),
         'date_created' => date('Y-m-d H:i:s')
         );
        
        $this->db->insert('acc_ledgers', $data);
        
    }
    
    function editledgers()
    {
        $data = array(
        'company_id'=> $_SESSION['company_id'],
        'name' => $this->input->post('name',true),
        'title' => $this->input->post('title',true),
        'op_dr_balance' => $this->input->post('op_dr_balance',true),
        'op_cr_balance' => $this->input->post('op_cr_balance',true),
       // 'affects_gross' => $this->input->post('affects_gross',true),
        'group_id' => $this->input->post('group_id',true)
        );
        
       $this->db->update('acc_ledgers', $data, array('id'=>$this->input->post('id')));
            
    }

    function getLedgerWithOPBalance($company_id)
    {
        $query_string = 
        'SELECT *,L.id as ledger_id,L.title as ledger_name,(L.op_dr_balance-L.op_cr_balance) as op_balance
        FROM acc_ledgers AS L
        WHERE L.company_id = '.$company_id.'
        GROUP BY L.id';
        
        $query = $this->db->query($query_string);
        $data = $query->result_array();
        return $data;
    }
    
    function get_ledgerTotalBalance($ledger_id,$fy_start_date,$fy_end_date)
    {
        $query_string = 'SELECT sum(debit-credit) AS balance
        FROM acc_entry_items AS ei
        WHERE ledger_id = '.$ledger_id.' AND ei.date BETWEEN "'.$fy_start_date.'" AND "'.$fy_end_date.'"';
        
        $query = $this->db->query($query_string);
        if($row = $query->row())
        {
            return $row->balance;
        }
    }
    function updateOPBalance($id,$op_dr_balance,$op_cr_balance)
    {
        $data = array(
        'op_dr_balance' => $op_dr_balance,
        'op_cr_balance' => $op_cr_balance,
        );
        
       $this->db->update('acc_ledgers', $data, array('id'=>$id));
            
    }
    
    function deleteledger($id)
    {
        $this->db->delete('acc_ledgers',array('id'=>$id));
    }
    
    /* Return debit total as positive value */
	function get_dr_total($ledger_id)
	{
		$this->db->select_sum('debit', 'drtotal')->from('acc_entry_items')->where('ledger_id', $ledger_id);
		$dr_total_q = $this->db->get();
		if ($dr_total = $dr_total_q->row())
			return $dr_total->drtotal;
		else
			return 0;
	}

	/* Return credit total as positive value */
	function get_cr_total($ledger_id)
	{
		$this->db->select_sum('credit', 'crtotal')->from('acc_entry_items')->join('acc_entries', 'acc_entries.id = acc_entry_items.entry_id')->where('acc_entry_items.ledger_id', $ledger_id)->where('company_id',$_SESSION['company_id']);
		$cr_total_q = $this->db->get();
		if ($cr_total = $cr_total_q->row())
			return $cr_total->crtotal;
		else
			return 0;
	}
    
    public function getLedgerByName()
    {
        $data = array();
        $options = array('company_id'=> $_SESSION['company_id']);
        $query = $this->db->get_where('acc_ledgers',$options);
        $query = $this->db->get('acc_ledgers');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                 $data[$row['name']] = $row['name'];
                 $data[$row['name'].'-balance'] = ($this->get_dr_total($row['id']) - $this->get_cr_total($row['id']));
                 //$data[$row['name'].'-cr_total'] = $this->get_cr_total($row['id']);
            }
        }
        $query->free_result();
        return $data;
        
    }
    
    public function getLedgerWithBalance($company_id,$fy_start_date,$fy_end_date,$ledger_id=false)
    {
       // $data = array();
       if($ledger_id !== false)
       {
        $this->db->where('l.id',$ledger_id);
       }
        $this->db->select('(l.op_dr_balance-l.op_cr_balance) as op_balance,sum(debit-credit)as balance, l.*');
        $this->db->join('acc_entry_items ei','ei.ledger_id=l.id','left');
        $options = array('company_id'=> $company_id);
        
        $this->db->where('ei.date >=', $fy_start_date);
        $this->db->where('ei.date <=', $fy_end_date);

        $this->db->group_by('l.id');
        
        $query = $this->db->get_where('acc_ledgers l',$options);
        $ledgers = $query->result_array();
        
        return $ledgers;
    }
    
    public function getLedgerByGroup($group_id,$company_id,$fy_start_date,$fy_end_date)
    {
       // $data = array();
        $this->db->select('(l.op_dr_balance-l.op_cr_balance) as op_balance,sum(debit-credit)as balance, l.*');
        $this->db->join('acc_entry_items ei','ei.ledger_id=l.id','left');
        $options = array('group_id'=> $group_id,'company_id'=> $company_id);
        $this->db->where('date >=', $fy_start_date);
        $this->db->where('date <=', $fy_end_date);

        $this->db->group_by('l.id');
        
        $query = $this->db->get_where('acc_ledgers l',$options);
        $ledgers = $query->result_array();
        
        return $ledgers;
    }
    
    //by affect gross is one
    public function getLedgerByGroupID($group_id,$company_id)
    {
       // $data = array();
        $options = array('group_id'=> $group_id,'company_id'=> $company_id);
        
        $query = $this->db->get_where('acc_ledgers',$options);
        $ledgers = $query->result_array();
        //foreach($ledgers as $ledger_values):
//             
//                $data[$ledger_values['id']] = $ledger_values['name'];
//               
//        endforeach;
        return $ledgers;
    }
   
}