<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_units extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_unit($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('pos_units',array('company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_units',array('id'=>$id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function get_unitName($unit_id)
    {
       $query = $this->db->get_where('pos_units',array('id'=>$unit_id,'company_id'=> $_SESSION['company_id']));
      
       if($unitName = $query->row())
        {
            return $unitName->name;
        }
        return '';
    }
    
    function get_activeunits($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('pos_units',array('status'=>'active','company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_units',array('id'=>$id,'status'=>'active','company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function add_unit()
    {
        $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                      'company_id'=> $_SESSION['company_id']
                     );
                  
        $this->db->insert('pos_units',$data);
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"unit","added","POS");
            // end logging                    
    }
    
    function update_unit()
    {
        $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                      'company_id'=> $_SESSION['company_id']
                        
                      );
                  
        $this->db->update('pos_units',$data,array('id'=>$_POST['id'])); 
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"unit","updated","POS");
            // end logging                     
    }
    
    function delete_unit($id)
    {
        $query = $this->db->update('pos_units',array('status'=>'inactive'),array('id'=>$id));
        
        //for logging
            $msg = $this->input->post('id',true);
            $this->M_logs->add_log($msg,"unit","inactivated","POS");
            // end logging    
    }
    
    function get_activeunitsDDL()
    {
        $data = array();
        $data[0] = "--Please Select--";
        $this->db->select('id,name');
        
        $query = $this->db->get_where('pos_units',array('status'=>'active','company_id'=> $_SESSION['company_id']));
        
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