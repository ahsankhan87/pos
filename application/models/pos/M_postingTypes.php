<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_postingTypes extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_salesPostingTypes($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('pos_salespostingtypes',array('company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_salespostingtypes',array('id'=>$id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function add_salespostingType()
    {
        $data = array(  
                    'name'=>$this->input->post('name'),
                    'inventory_acc_code'=>$this->input->post('inventory_acc_code'),
                    'cash_acc_code'=>$this->input->post('cash_acc_code'),
                    'bank_acc_code'=>$this->input->post('bank_acc_code'),
                    'sales_acc_code'=>$this->input->post('sales_acc_code'),
                    'receivable_acc_code'=>$this->input->post('receivable_acc_code'),
                    'cos_acc_code'=>$this->input->post('cos_acc_code'),
                    'salesreturn_acc_code'=>$this->input->post('salesreturn_acc_code'),
                    'salesdis_acc_code'=>$this->input->post('salesdis_acc_code'),
                    'forex_gain_acc_code'=>$this->input->post('forex_gain_acc_code'),
                    'forex_loss_acc_code'=>$this->input->post('forex_loss_acc_code'),
                    'salestax_acc_code'=>$this->input->post('salestax_acc_code'),
                    'company_id'=> $_SESSION['company_id']
                     );
                  
        $this->db->insert('pos_salespostingtypes',$data);        
        
         //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"salespostingType","added","POS");
            // end logging           
    }
    
    function update_salespostingType()
    {
        $data = array(  
                    'name'=>$this->input->post('name'),
                    'inventory_acc_code'=>$this->input->post('inventory_acc_code'),
                    'cash_acc_code'=>$this->input->post('cash_acc_code'),
                    'bank_acc_code'=>$this->input->post('bank_acc_code'),
                    'sales_acc_code'=>$this->input->post('sales_acc_code'),
                    'receivable_acc_code'=>$this->input->post('receivable_acc_code'),
                    'cos_acc_code'=>$this->input->post('cos_acc_code'),
                    'salesreturn_acc_code'=>$this->input->post('salesreturn_acc_code'),
                    'salesdis_acc_code'=>$this->input->post('salesdis_acc_code'),
                    'forex_gain_acc_code'=>$this->input->post('forex_gain_acc_code'),
                    'forex_loss_acc_code'=>$this->input->post('forex_loss_acc_code'),
                    'salestax_acc_code'=>$this->input->post('salestax_acc_code'),
                    'company_id'=> $_SESSION['company_id']
                      );
                  
        $this->db->update('pos_salespostingtypes',$data,array('id'=>$this->input->post('id')));  
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"salespostingType","updated","POS");
            // end logging                  
    }
    
    function delete_postingType($id)
    {
        $query = $this->db->delete('pos_salespostingtypes',array('id'=>$id));
        
        //for logging
            $msg = $id;
            $this->M_logs->add_log($msg,"salespostingType","delted","POS");
            // end logging  
    }
    
    function get_SalesPostingTypesDDL()
    {
        $data = array();
        $data[''] = "--Please Select--";
        
        $this->db->select('id,name');
        
        $query = $this->db->get_where('pos_salespostingtypes',array('company_id'=> $_SESSION['company_id']));
        
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $row)
            {
                $data[$row['id']] = $row['name'];
            }
        }
        return $data;
    }
    
    function get_purchasePostingTypes($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('pos_purchasepostingtypes',array('company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_purchasepostingtypes',array('id'=>$id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function add_purchasepostingType()
    {
        $data = array(  
                    'name'=>$this->input->post('name'),
                    'inventory_acc_code'=>$this->input->post('inventory_acc_code'),
                    'cash_acc_code'=>$this->input->post('cash_acc_code'),
                    'bank_acc_code'=>$this->input->post('bank_acc_code'),
                    'payable_acc_code'=>$this->input->post('payable_acc_code'),
                    'purchasereturn_acc_code'=>$this->input->post('purchasereturn_acc_code'),
                    //'purchase_acc_code'=>$this->input->post('purchase_acc_code'),
                    'purchasedis_acc_code'=>$this->input->post('purchasedis_acc_code'),
                    'forex_gain_acc_code'=>$this->input->post('forex_gain_acc_code'),
                    'forex_loss_acc_code'=>$this->input->post('forex_loss_acc_code'),
                    'salestax_acc_code'=>$this->input->post('salestax_acc_code'),
                    'company_id'=> $_SESSION['company_id']
                     );
                  
        $this->db->insert('pos_purchasepostingtypes',$data);         
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"purchasepostingtypes","added","POS");
            // end logging              
    }
    
    function update_purchasepostingType()
    {
        $data = array(  
                    'name'=>$this->input->post('name'),
                    'inventory_acc_code'=>$this->input->post('inventory_acc_code'),
                    'cash_acc_code'=>$this->input->post('cash_acc_code'),
                    'bank_acc_code'=>$this->input->post('bank_acc_code'),
                    'payable_acc_code'=>$this->input->post('payable_acc_code'),
                    //'purchase_acc_code'=>$this->input->post('purchase_acc_code'),
                    'purchasereturn_acc_code'=>$this->input->post('purchasereturn_acc_code'),
                    'purchasedis_acc_code'=>$this->input->post('purchasedis_acc_code'),
                    'forex_gain_acc_code'=>$this->input->post('forex_gain_acc_code'),
                    'forex_loss_acc_code'=>$this->input->post('forex_loss_acc_code'),
                    'salestax_acc_code'=>$this->input->post('salestax_acc_code'),
                    'company_id'=> $_SESSION['company_id']
                    );
                  
        $this->db->update('pos_purchasepostingtypes',$data,array('id'=>$this->input->post('id')));  
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"purchasepostingtypes","updated","POS");
            // end logging                  
    }
    
    function delete_purchasepostingType($id)
    {
        $query = $this->db->delete('pos_purchasepostingtypes',array('id'=>$id));
        
        //for logging
            $msg = $id;
            $this->M_logs->add_log($msg,"purchasepostingtypes","deleted","POS");
            // end logging 
    }
    
    function get_purchasePostingTypesDDL()
    {
        $data = array();
        $data[''] = "--Please Select--";
        $this->db->select('id,name');
        
        $query = $this->db->get_where('pos_purchasepostingtypes',array('company_id'=> $_SESSION['company_id']));
        
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $row)
            {
                $data[$row['id']] = $row['name'];
            }
        }
        return $data;
    }
} 