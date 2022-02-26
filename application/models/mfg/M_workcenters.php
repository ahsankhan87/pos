<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_workcenters extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_workcenter($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('mfg_workcenters',array('company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('mfg_workcenters',array('id'=>$id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function get_workcenterName($workcenter_id)
    {
       $query = $this->db->get_where('mfg_workcenters',array('id'=>$workcenter_id,'company_id'=> $_SESSION['company_id']));
      
       if($workcenterName = $query->row())
        {
            return $workcenterName->name;
        }
        return '';
    }
    
    function get_activeworkcenters($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('mfg_workcenters',array('status'=>'active','company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('mfg_workcenters',array('id'=>$id,'status'=>'active','company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function add_workcenter()
    {
        $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                      'company_id'=> $_SESSION['company_id']
                     );
                  
        $this->db->insert('mfg_workcenters',$data);
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"workcenter","added","MFG");
            // end logging                    
    }
    
    function update_workcenter()
    {
        $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                      'company_id'=> $_SESSION['company_id']
                        
                      );
                  
        $this->db->update('mfg_workcenters',$data,array('id'=>$_POST['id'])); 
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"workcenter","updated","MFG");
            // end logging                     
    }
    
    function inactivate_workcenter($id)
    {
        $query = $this->db->update('mfg_workcenters',array('status'=>'0'),array('id'=>$id));
        
        //for logging
            $msg = $this->input->post('id',true);
            $this->M_logs->add_log($msg,"workcenter","inactivated","MFG");
            // end logging    
    }
    
    
    function delete_workcenter($id)
    {
        $query = $this->db->delete('mfg_workcenters',array('id'=>$id));
        
        //for logging
            $msg = $this->input->post('id',true);
            $this->M_logs->add_log($msg,"workcenter","Deleted","MFG");
            // end logging    
    }
    
    function get_activeworkcentersDDL()
    {
        $data = array();
        //$data[0] = "--Please Select--";
        $this->db->select('id,name');
        
        $query = $this->db->get_where('mfg_workcenters',array('status'=>1,'company_id'=> $_SESSION['company_id']));
        
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