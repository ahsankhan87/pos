<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_colors extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_color($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('pos_colors',array('company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_colors',array('id'=>$id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function get_colorName($color_id)
    {
       $query = $this->db->get_where('pos_colors',array('id'=>$color_id));
       
       if($colorName = $query->row())
        {
            return $colorName->name;
        }
    }
    
    function get_activeColors($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('pos_colors',array('status'=>'active','company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_colors',array('id'=>$id,'status'=>'active','company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function add_color()
    {
        $data = array(  'company_id'=> $_SESSION['company_id'],
                        'name'=>$_POST['name'],
                        'status'=>$_POST['status']
                     );
                  
        $this->db->insert('pos_colors',$data);                  
    }
    
    function update_color()
    {
        $data = array(  
                        'company_id'=> $_SESSION['company_id'],
                        'name'=>$_POST['name'],
                        'status'=>$_POST['status']
                        
                      );
                  
        $this->db->update('pos_colors',$data,array('id'=>$_POST['id']));                  
    }
    
    function delete_color($id)
    {
        $query = $this->db->update('pos_colors',array('status'=>'inactive'),array('id'=>$id));
    }
    
    function get_activeColorsDDL()
    {
        $data = array();
        $data[0] = "--Please Select--";
        $this->db->select('id,name');
        
        $query = $this->db->get_where('pos_colors',array('status'=>'active','company_id'=> $_SESSION['company_id']));
        
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