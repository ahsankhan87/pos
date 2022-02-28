<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_entries extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        
    }
    
    //get all products and also only one product and active and inactive too.
    public function get_entries($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            //$this->db->select('id,date,invoice_no,dr_total,cr_total,narration');
            $this->db->order_by('id','desc');
        
            $options = array('company_id'=> $_SESSION['company_id']);
            $query = $this->db->get_where('acc_entries',$options);
        
            $data = $query->result_array();
            return $data;
        }
        
        $options = array('id'=> $id,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('acc_entries',$options);
        $data = $query->result_array();
        return $data;
    }
    
    //retrieve journal entries against ledger account.
    public function balanceByAccount($account_code,$fy_start_date,$fy_end_date)
    {
        //$query = $this->db->query("Select * FROM acc_entry_items WHERE entry_id in (SELECT entry_id FROM acc_entry_items WHERE ledger_id = {$ledger_id})");
        $this->db->select('SUM(ei.debit) as debit, SUM(ei.credit) as credit')->from('acc_entry_items ei')->where(array(
        'ei.account_code'=>$account_code,'e.company_id'=> $_SESSION['company_id'],'ei.company_id'=> $_SESSION['company_id']));
        $this->db->join('acc_entries e','e.id=ei.entry_id');
        
        $this->db->where('ei.date >=', $fy_start_date);
        $this->db->where('ei.date <=', $fy_end_date);
        
        $query = $this->db->get();
        
        $data = $query->result_array();
        
        return $data;
    }
    public function get_allEntries($company_id,$fy_start_date,$fy_end_date)
    {
        $this->db->group_by('ei.id');
        $this->db->select('g.title,g.title_ur, ei.*');
        $this->db->join('acc_groups g','ei.account_code=g.account_code');
        //$this->db->group_by('l.id');
        $this->db->join('acc_entries e','ei.entry_id=e.id');
        $options = array('e.company_id'=> $company_id,'g.company_id'=> $company_id);
        
        $this->db->where('ei.date >=', $fy_start_date);
        $this->db->where('ei.date <=', $fy_end_date);

        $query = $this->db->get_where('acc_entry_items ei',$options);
        $data = $query->result_array();
        return $data;
    }
    
    public function get_TodayEntries($company_id,$date)
    {
        $this->db->group_by('ei.id');
        $this->db->select('g.title,g.title_ur, ei.*,e.entry_no');
        $this->db->join('acc_entries e','ei.entry_id=e.id');
        $this->db->join('acc_groups g','ei.account_code=g.account_code');
        //$this->db->group_by('l.id');
        $options = array('ei.company_id'=> $company_id,'g.company_id'=> $company_id,'ei.date'=>$date);
        
        $query = $this->db->get_where('acc_entry_items ei',$options);
        $data = $query->result_array();
        return $data;
    }
    
    public function get_EntriesByNo($company_id,$fy_start_date,$fy_end_date,$entry_no)
    {
        $this->db->order_by('ei.id','asc');
        $this->db->select('g.title,g.title_ur, ei.*');
        $this->db->join('acc_groups g','ei.account_code=g.account_code');
        //$this->db->group_by('l.id');
        $options = array('ei.company_id'=> $company_id,'g.company_id'=> $company_id,'entry_no'=>$entry_no);
        
        $this->db->where('ei.date >=', $fy_start_date);
        $this->db->where('ei.date <=', $fy_end_date);

        $query = $this->db->get_where('acc_entry_items ei',$options);
        $data = $query->result_array();
        return $data;
    }
    
    function getEntryDropDown()
    {
        $data = array();
        $data[0] = '--Please Select--';
        
        $options = array('company_id'=> $_SESSION['company_id']);
        $query = $this->db->get_where('acc_entries',$options);
        
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                 $data[$row['id']] = $row['name'];
            }
        }
        $query->free_result();
        return $data;
    }
    
    function addEntries($dr_ledger,$cr_ledger,$dr_amount,$cr_amount,$narration='',$invoice_no='',
    $date=null,$entry_no=null,$ref_id=0,$is_cust=0,$is_supplier=0,$is_bank=0)
    {
        $data = array(
        'date' => ($date == null ? date('Y-m-d') : $date),
        'company_id'=> $_SESSION['company_id'],
        //'invoice_no' => $invoice_no,
        'entry_no' => $entry_no == null ? '' : $entry_no,
        'narration' => $narration
         );
        
        $this->db->insert('acc_entries', $data);
        $entry_id = $this->db->insert_id();
        
           $data = array(
                'entry_id' => $entry_id,
                'employee_id'=>$_SESSION['user_id'],
                'entry_no' => $entry_no == null ? '' : $entry_no,
                //'name' => $name,
                'account_code' => $dr_ledger,
                'date' => ($date == null ? date('Y-m-d') : $date),
                //'amount' => $dr_amount,
                'dueTo_acc_code' => $cr_ledger,
                'ref_account_id' => $ref_id,
                //'dc' => 'D',
                'debit'=>$dr_amount,
                'credit'=>0.00,
                'invoice_no' => $invoice_no,
                'narration' => $narration,
                'company_id'=> $_SESSION['company_id'],
                'is_cust' => $is_cust,
                'is_supp' => $is_supplier,
                'is_bank' => $is_bank,

                );
                $this->db->insert('acc_entry_items', $data);      
                     
            $data1 = array(
                'entry_id' => $entry_id,
                'employee_id'=>$_SESSION['user_id'],
                'entry_no' => $entry_no == null ? '' : $entry_no,
                //'name' => $name,
                'account_code' => $cr_ledger,
                'date' => ($date == null ? date('Y-m-d') : $date),
                //'amount' => $cr_amount,
                'dueTo_acc_code' => $dr_ledger,
                'ref_account_id' => $ref_id,
                //'dc' => 'C',
                'debit'=>0.00,
                'credit'=>$cr_amount,
                'invoice_no' => $invoice_no,
                'narration' => $narration,
                'company_id'=> $_SESSION['company_id'],
                'is_cust' => $is_cust,
                'is_supp' => $is_supplier,
                'is_bank' => $is_bank,

                );
                
                $this->db->insert('acc_entry_items', $data1);
                
               return $entry_id;
               
    }
    
    function addEntriesFromReference($dr_ledger,$cr_ledger,$dr_amount,$cr_amount,$narration='',$invoice_no='',
    $date=null,$entry_no=null,$ref_id=0,$is_cust=0,$is_supplier=0,$is_bank=0)
    {
        $data = array(
        'date' => ($date == null ? date('Y-m-d') : $date),
        'company_id'=> $_SESSION['company_id'],
        //'invoice_no' => $invoice_no,
        'entry_no' => $entry_no == null ? '' : $entry_no,
        'narration' => $narration
         );
        
        $this->db->insert('acc_entries', $data);
        $entry_id = $this->db->insert_id();
        
           $data = array(
                'entry_id' => $entry_id,
                'employee_id'=>$_SESSION['user_id'],
                'entry_no' => $entry_no == null ? '' : $entry_no,
                //'name' => $name,
                'account_code' => $dr_ledger,
                'date' => ($date == null ? date('Y-m-d') : $date),
                //'amount' => $dr_amount,
                'dueTo_acc_code' => $cr_ledger,
                'ref_account_id' => $ref_id,
                //'dc' => 'D',
                'debit'=>$dr_amount,
                'credit'=>0.00,
                'invoice_no' => $invoice_no,
                'narration' => $narration,
                'company_id'=> $_SESSION['company_id'],
                'is_cust' => $is_cust,
                'is_supp' => $is_supplier,
                'is_bank' => $is_bank,

                );
                $this->db->insert('acc_entry_items', $data);      
                     
            $data1 = array(
                'entry_id' => $entry_id,
                'employee_id'=>$_SESSION['user_id'],
                'entry_no' => $entry_no == null ? '' : $entry_no,
                //'name' => $name,
                'account_code' => $cr_ledger,
                'date' => ($date == null ? date('Y-m-d') : $date),
                //'amount' => $cr_amount,
                'dueTo_acc_code' => $dr_ledger,
                'ref_account_id' => $ref_id,
                //'dc' => 'C',
                'debit'=>0.00,
                'credit'=>$cr_amount,
                'invoice_no' => $invoice_no,
                'narration' => $narration,
                'company_id'=> $_SESSION['company_id'],
                'is_cust' => $is_cust,
                'is_supp' => $is_supplier,
                'is_bank' => $is_bank,

                );
                
                $this->db->insert('acc_entry_items', $data1);
                
               return $entry_id;
               
    }
    
    function getMAXEntryInvoiceNo($invoice_prefix)
    {   
        $this->db->order_by('id','desc');
        $this->db->where('company_id', $_SESSION['company_id']);
        $this->db->like('invoice_no',$invoice_prefix,'after');
        $query = $this->db->get('acc_entry_items',1);
        return $query->row()->invoice_no;
    }
    
    function get_entry_by_invoiceNo($invoiceNo,$company_id,$limit=null)
    {
        $this->db->order_by('id','desc');
        $this->db->select('ei.*');
        $this->db->join('acc_entries e','e.id=ei.entry_id');
        $options = array('ei.invoice_no'=> $invoiceNo,'e.company_id'=>$company_id);
        $query = $this->db->get_where('acc_entry_items ei',$options,$limit);
        $data = $query->result_array();
        return $data;
    }
    
    function get_entry_by_invoiceNo_1($invoiceNo,$company_id,$limit=null)
    {
        $this->db->order_by('id','desc');
        $this->db->select('ei.*,g.title,g.title_ur,g.title_ar, IFNULL(IF(ei.is_cust,c.store_name,NULL),"") as customer_store_name,IFNULL(IF(ei.is_supp,s.name,NULL),"") as supplier_name,IFNULL(IF(ei.is_bank,b.bank_name,NULL),"") as bank_name');
        $this->db->join('acc_entries e','e.id=ei.entry_id');
        $this->db->join('acc_groups g','g.account_code=ei.account_code','left');
        $this->db->join('pos_customers c','c.id=ei.ref_account_id','left');
        $this->db->join('pos_supplier s','s.id=ei.ref_account_id','left');
        $this->db->join('pos_banking b','b.id=ei.ref_account_id','left');
        $options = array('ei.invoice_no'=> $invoiceNo,'e.company_id'=>$company_id,'g.company_id'=>$company_id);
        $query = $this->db->get_where('acc_entry_items ei',$options,$limit);
        $data = $query->result_array();
        return $data;
    }
    
    function editEntries()
    {
        $data = array(
        'company_id'=> $_SESSION['company_id'],
        'name' => $this->input->post('name',true),
        'group_id' => $this->input->post('group_id',true)
        );
        
       $this->db->update('acc_entries', $data, array('id'=>$this->input->post('id')));
            
    }
    
    function check_entry_no($entry_no)
     {
        $this->db->where(array('entry_no'=> $entry_no,'company_id'=> $_SESSION['company_id']));
        $query = $this->db->get('acc_entries'); 
        
        if($query->num_rows() > 0)
        {
            return FALSE;
        }else
        {
            return TRUE;
        }
     }
     
    public function get_entriesByEntryNo($entry_no)
    {
        $options = array('entry_no'=> $entry_no,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('acc_entries',$options);
        $data = $query->result_array();
        return $data;
    }

    public function get_entriesByDate($date)
    {
        $this->db->select('g.title,g.title_ur,ei.*, IFNULL(c.store_name,"") as customer_store_name,IFNULL(s.name,"") as supplier_name,IFNULL(b.bank_name,"") as bank_name');
        $options = array('ei.date'=> $date,'ei.company_id'=> $_SESSION['company_id'],'g.company_id'=> $_SESSION['company_id']);
        
        $this->db->join('acc_groups g','g.account_code=ei.account_code','LEFT');
        $this->db->join('pos_customers c','c.id=ei.ref_account_id','LEFT');
        $this->db->join('pos_supplier s','s.id=ei.ref_account_id','LEFT');
        $this->db->join('pos_banking b','b.id=ei.ref_account_id','LEFT');
        $query = $this->db->get_where('acc_entry_items ei',$options);
        $data = $query->result_array();
        return $data;
    }

    function deleteEntry($id)
    {
        //$this->db->delete('acc_entries',array('invoice_no'=>$invoice_no));
        $this->db->delete('acc_entry_items',array('id'=>$id));
        
                    //for logging
                    $msg = 'entry id '.$id;
                    $this->M_logs->add_log($msg,"Journal Entry","deleted","Accounts");
                    // end logging
    }

    
    function deleteEntry_invoice_no($invoice_no)
    {
        $this->db->delete('acc_entries',array('invoice_no'=>$invoice_no));
        $this->db->delete('acc_entry_items',array('invoice_no'=>$invoice_no));
        
    }
}