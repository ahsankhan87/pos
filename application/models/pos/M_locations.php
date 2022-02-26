<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_locations extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_location($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('pos_locations',array('company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_locations',array('id'=>$id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function get_locationName($location_id)
    {
       $query = $this->db->get_where('pos_locations',array('id'=>$location_id));
       
       if($locationName = $query->row())
        {
            return $locationName->name;
        }
    }
    
    function get_activelocations($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('pos_locations',array('status'=>'active','company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_locations',array('id'=>$id,'status'=>'active','company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function add_location()
    {
        $data = array(  'company_id'=> $_SESSION['company_id'],
                        'name'=>$_POST['name'],
                        'status'=>$_POST['status']
                     );
                  
        $this->db->insert('pos_locations',$data);      
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"Location","added","POS");
            // end logging            
    }
    
    function update_location()
    {
        $data = array(  
                        'company_id'=> $_SESSION['company_id'],
                        'name'=>$_POST['name'],
                        'status'=>$_POST['status']
                        
                      );
                  
        $this->db->update('pos_locations',$data,array('id'=>$_POST['id']));
        
         //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"Location","Updated","POS");
            // end logging                   
    }
    
    function delete_location($id)
    {
        $query = $this->db->update('pos_locations',array('status'=>'inactive'),array('id'=>$id));
        
         //for logging
            $msg = $this->input->post('id',true) . ' Location';
            $this->M_logs->add_log($msg,"Location","inactivated","POS");
            // end logging 
    }
    
    function get_activelocationsDDL()
    {
        $data = array();
        $data[0] = "--Please Select--";
        $this->db->select('id,name');
        
        $query = $this->db->get_where('pos_locations',array('status'=>'active','company_id'=> $_SESSION['company_id']));
        
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