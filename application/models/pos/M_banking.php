<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_banking extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    //get all banking and also only one bank and active and inactive too.
    public function get_banking($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            
            $this->db->order_by('id','desc');
            $query = $this->db->get_where('pos_banking',array('company_id'=> $_SESSION['company_id']));
            $data = $query->result_array();
            return $data;
        }
        
        $this->db->order_by('id','desc');
        $options = array('id'=> $id,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_banking',$options);
        $data = $query->result_array();
        return $data;
    }
    
    //get all banking and also only one bank and active and inactive too.
    public function get_activeBanking($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            
            $options = array('status'=>1,'company_id'=> $_SESSION['company_id']);
        
            $this->db->order_by('id','desc');
            $query = $this->db->get_where('pos_banking',$options);
            $data = $query->result_array();
            return $data;
        }
        
        $this->db->order_by('id','desc');
        $options = array('id'=> $id,'status'=>1,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_banking',$options);
        $data = $query->result_array();
        return $data;
    }
    
    public function get_activeBankByAccCode($acc_code)
    {
        $options = array('status'=>1,'company_id'=> $_SESSION['company_id'],
        'bank_acc_code'=> $acc_code);
        
        $query = $this->db->get_where('pos_banking',$options);
        $data = $query->result_array();
        return $data;
    }
    
    public function get_bank_Entries($bank_id,$fy_start_date,$fy_end_date)
    {
        $this->db->group_by('sp.id');
        //$this->db->join('acc_groups g','g.account_code=sp.account_code');
        $this->db->select('sp.*')->from('pos_bank_payments sp')->where('sp.bank_id', $bank_id);
        $this->db->where('sp.company_id', $_SESSION['company_id']);
        //$this->db->where('g.company_id', $_SESSION['company_id']);
        $this->db->where('date >=', $fy_start_date);
        $this->db->where('date <=', $fy_end_date);

        $query = $this->db->get();
        $data = $query->result_array();
        
        return $data;
    }
    
    public function get_bank_total_balance($bank_id,$fy_start_date,$fy_end_date)
    {
        $this->db->select('SUM(debit) as dr_balance, SUM(credit) as cr_balance')->from('pos_bank_payments sp')->where('sp.bank_id', $bank_id);
        $this->db->where('sp.company_id', $_SESSION['company_id']);
        $this->db->where('date >=', $fy_start_date);
        $this->db->where('date <=', $fy_end_date);
        $query = $this->db->get();
        $data = $query->result_array();
        
        return $data;
    }
    
    
    function getbankDropDown()
    {
        $data = array();
        $data[0]= 'Select Bank Account';
        
        $query = $this->db->get_where('pos_banking',array('status'=>1,'company_id'=> $_SESSION['company_id']));
        
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                 $data[$row['id']] = $row['bank_name'];
            }
        }
        $query->free_result();
        return $data;
    }
    
    //get active banking if id is provided then one record will be loaded.
    //this banking images will show on front page.
    public function get_banking_images($id)
    {
        
        $this->db->select('id, url, fk_real_estate_id');
        $options = array('fk_real_estate_id'=> $id);
       
        $query = $this->db->get_where('pos_banking_images',$options);
        $data = $query->result_array();
       
        return $data;
    }
    
    //get bank by search 
    public function search($search){
        
        $this->db->like('name',$search);
        $options = array('status'=>1,'company_id'=> $_SESSION['company_id']);
        $query = $this->db->get_where('pos_banking',$options);
        $data = $query->result_array();
        return $data;
    }
    
    
    function addbank()
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
            $this->db->insert('pos_banking', $data);
            
        
        }
        
     function updatebank()
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
            $this->db->update('pos_banking', $data, array('id'=>$_POST['id']));
            
           
        }
    function addBankPaymentEntry($account_code,$dueTo_acc_code,$dr_amount,$cr_amount,$bank_id='',$narration='',
    $invoice_no='',$date=null,$entry_id=0)
    {
        $data = array(
                'bank_id' => $bank_id,
                'account_code' => $account_code,
                'dueTo_acc_code' => $dueTo_acc_code,
                'date' => ($date == null ? date('Y-m-d') : $date),
                'debit'=>$dr_amount,
                'credit'=>$cr_amount,
                'invoice_no' => $invoice_no,
                'entry_id' => $entry_id,
                'narration' => $narration,
                'company_id'=> $_SESSION['company_id']
                );
                $this->db->insert('pos_bank_payments', $data);      
    }
    
    function getMAXBankInvoiceNo()
    {   
        $this->db->order_by('id','desc');
        $this->db->where('company_id', $_SESSION['company_id']);
        $query = $this->db->get('pos_bank_payments',1);
        return $query->row()->invoice_no;
    }
    
    function getbankPostingTypes($bank_id)
    {
        $this->db->select('spt.*');
        $this->db->join('pos_banking c','c.posting_type_id=spt.id');
        $this->db->where('c.id',$bank_id);
        $query =$this->db->get('pos_salespostingtypes spt',1);
        return $query->result_array();
    }
    
    public function get_bankName($bank_id)
    {
        $options = array('id'=> $bank_id);
        
        $query = $this->db->get_where('pos_banking',$options);
        if($row = $query->row())
        {
            return $row->bank_name;
        }
        
        return '';
    }
    

    function deletebank($id,$op_balance_dr,$op_balance_cr,$bank_acc_code)
    {
        
        $bank_account = $this->M_groups->get_groups($bank_acc_code,$_SESSION['company_id']);
           $bank_dr_balance = abs($bank_account[0]['op_balance_dr']);
           $bank_cr_balance = abs($bank_account[0]['op_balance_cr']);
                       
                       
                       
       if($bank_dr_balance !== 0 || $bank_cr_balance !== 0)
       {
          $dr_balance = ($bank_dr_balance-$op_balance_dr);
           $cr_balance = ($bank_cr_balance-$op_balance_cr);
           
           $this->M_groups->editGroupOPBalance($bank_acc_code,$dr_balance,$cr_balance);
       }
                      
       
        $query = $this->db->delete('pos_banking',array('id'=>$id));
        
        //for logging
            $msg = 'Bank id: '.$id;
            $this->M_logs->add_log($msg,"Banking","Deleted","POS");
            // end logging
        
    }
    
    
    function inactivate($id,$op_balance_dr,$op_balance_cr,$bank_acc_code)
    {
    
        $bank_account = $this->M_groups->get_groups($bank_acc_code,$_SESSION['company_id']);
           $bank_dr_balance = abs($bank_account[0]['op_balance_dr']);
           $bank_cr_balance = abs($bank_account[0]['op_balance_cr']);
                       
                       
                       
       if($bank_dr_balance !== 0 || $bank_cr_balance !== 0)
       {
          $dr_balance = ($bank_dr_balance-$op_balance_dr);
           $cr_balance = ($bank_cr_balance-$op_balance_cr);
           
           $this->M_groups->editGroupOPBalance($bank_acc_code,$dr_balance,$cr_balance);
       }
                
        $query = $this->db->update('pos_banking',array('status'=>'inactive'),array('id'=>$id));
            
            //for logging
            $msg = 'Bank id: '.$id;
            $this->M_logs->add_log($msg,"Banking","In-Activated","POS");
            // end logging
    }
    
    function delete_entry_by_id($entry_id)
    {
        $query = $this->db->delete('pos_bank_payments',array('entry_id'=>$entry_id));
        
    }
    
    function delete_entry_by_invoice_no($invoice_no)
    {
        $query = $this->db->delete('pos_bank_payments',array('invoice_no'=>$invoice_no));
        
    }
    
    function activate($id)
    {
        $query = $this->db->update('pos_banking',array('status'=>'active'),array('id'=>$id));
        
        
            //for logging
            $msg = 'Bank id: '.$id;
            $this->M_logs->add_log($msg,"Banking","Activated","POS");
            // end logging
    }
}


?>