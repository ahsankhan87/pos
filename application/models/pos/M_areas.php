<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_areas extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_area($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('pos_emp_area',array('company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_emp_area',array('id'=>$id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function get_areaName($area_id)
    {
       $query = $this->db->get_where('pos_emp_area',array('id'=>$area_id,'company_id'=> $_SESSION['company_id']));
      
       if($areaName = $query->row())
        {
            return $areaName->name;
        }
        return '';
    }
    
    function get_activeareas($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('pos_emp_area',array('status'=>'active','company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_emp_area',array('id'=>$id,'status'=>'active','company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function add_area()
    {
        $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                        'description'=>$_POST['description'],
                      'company_id'=> $_SESSION['company_id']
                     );
                  
        $this->db->insert('pos_emp_area',$data);
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"area","added","POS");
            // end logging                    
    }
    
    function update_area()
    {
        $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                        'description'=>$_POST['description'],
                        'company_id'=> $_SESSION['company_id']
                        
                      );
                  
        $this->db->update('pos_emp_area',$data,array('id'=>$_POST['id'])); 
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"area","updated","POS");
            // end logging                     
    }
    
    function delete_area($id)
    {
        $query = $this->db->update('pos_emp_area',array('status'=>'inactive'),array('id'=>$id));
        
        //for logging
            $msg = $this->input->post('id',true);
            $this->M_logs->add_log($msg,"area","inactivated","POS");
            // end logging    
    }
    
    function get_activeareasDDL()
    {
        $data = array();
        $data[0] = "--Please Select--";
        $this->db->select('id,name');
        
        $query = $this->db->get_where('pos_emp_area',array('status'=>'active','company_id'=> $_SESSION['company_id']));
        
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