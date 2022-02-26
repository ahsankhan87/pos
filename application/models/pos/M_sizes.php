<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_sizes extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_size($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('pos_sizes',array('company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_sizes',array('id'=>$id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function get_sizeName($size_id)
    {
       $query = $this->db->get_where('pos_sizes',array('id'=>$size_id,'company_id'=> $_SESSION['company_id']));
      
       if($sizeName = $query->row())
        {
            return $sizeName->name;
        }
        return '';
    }
    
    function get_activeSizes($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('pos_sizes',array('status'=>'active','company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_sizes',array('id'=>$id,'status'=>'active','company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function add_size()
    {
        $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                      'company_id'=> $_SESSION['company_id']
                     );
                  
        $this->db->insert('pos_sizes',$data);
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"Size","added","POS");
            // end logging                    
    }
    
    function update_size()
    {
        $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                      'company_id'=> $_SESSION['company_id']
                        
                      );
                  
        $this->db->update('pos_sizes',$data,array('id'=>$_POST['id'])); 
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"Size","updated","POS");
            // end logging                     
    }
    
    function delete_size($id)
    {
        $query = $this->db->update('pos_sizes',array('status'=>'inactive'),array('id'=>$id));
        
        //for logging
            $msg = $this->input->post('id',true);
            $this->M_logs->add_log($msg,"Size","inactivated","POS");
            // end logging    
    }
    
    function get_activeSizesDDL()
    {
        $data = array();
        $data[0] = "--Please Select--";
        $this->db->select('id,name');
        
        $query = $this->db->get_where('pos_sizes',array('status'=>'active','company_id'=> $_SESSION['company_id']));
        
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