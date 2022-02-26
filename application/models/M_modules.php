<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_modules extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    // get all category e.g active and inactive.
    public function get_modules($id = FALSE, $limit = 10000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
           // $options = array('company_id'=> $_SESSION['company_id']);
            $query = $this->db->get('modules');
            return $query->result_array();
        }
        
        $options = array('id'=> $id);
        $query = $this->db->get_where('modules',$options);
        
        return $query->result_array();
    }
    
    //get all active category but if id is provided then one result will be retrieved.
    public function get_activeModules($id = FALSE, $limit = 10000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            $query = $this->db->get_where('modules',array('status' =>'active'));
            return $query->result_array();
        }
        $this->db->order_by('sort','asc');
        $options = array('id'=> $id,'status'=>'active');
        $query = $this->db->get_where('modules',$options);
        
        return $query->result_array();    
    }
    
    //get all active category but if id is provided then one result will be retrieved.
    public function get_permittedModules($emp_id)
    {
        //if($_SESSION['role'] == 'admin')
//        {
//            $this->db->order_by('sort','asc');
//            $options = array('parent_id'=> 0,'status'=>'active');
//            $query = $this->db->get_where('modules',$options);
//            
//            return $query->result_array();
//        }else
        //{
            $this->db->select('m.id,m.parent_id,m.name,m.title,m.title_ur,m.title_ar,m.path,m.icon,m.status');
            $this->db->join('pos_emp_modules em','m.id=em.module_id');
            $options = array('em.emp_id'=> $emp_id,'m.status'=>'active','m.parent_id'=> 0);
            $this->db->order_by('m.sort','ASC');
            $query = $this->db->get_where('modules m',$options);
                    
            return $query->result_array();
        //}
    }
    
    
    public function get_permitted_SubModules($emp_id,$parent_id)
    {
        $this->db->select('m.id,m.parent_id,m.name,m.title,m.title_ur,m.title_ar,m.path,m.icon,m.status,em.can_create,
        em.can_update,em.can_delete');
            
        $this->db->join('pos_emp_modules em','m.id=em.sub_module');
        $this->db->order_by('m.sort','ASC');
        $options = array('em.emp_id'=> $emp_id,'m.parent_id'=> $parent_id,'m.status'=>'active');
        $query = $this->db->get_where('modules m',$options);
                    
        return $query->result_array();
        
    }
    
    public function get_modulesByParent($parent_id = 0)
    {
        $this->db->order_by('sort','asc');
        $options = array('parent_id'=> $parent_id,'status'=>'active');
        $query = $this->db->get_where('modules',$options);
        
        return $query->result_array();
    }
    
    function addEmpModules()
        {
            $data = array(
            'name' => $this->input->post('name',true),
            'emp_id' => $this->input->post('emp_id',true),
            'module_id' => $this->input->post('module_id',true),
            );
            $this->db->insert('modules', $data);
        }
   function get_moduleByName($module_name)
   {
        $options = array('name'=> $module_name);
        $query = $this->db->get_where('modules',$options);
        
        return $query->result_array();
   }   
   
   function get_moduleByUserID($user_id,$module_id)
   {
        $options = array('emp_id'=> $user_id,'module_id'=>$module_id);
        
        //$this->db->join('modules m','m.id=pm.module_id');
        $query = $this->db->get_where('pos_emp_modules pm',$options);
        
        return $query->result_array();
   }     
    
    function get_sub_moduleByUserID($user_id,$module_id)
   {
        $options = array('emp_id'=> $user_id,'sub_module'=>$module_id);
        
        //$this->db->join('modules m','m.id=pm.module_id');
        $query = $this->db->get_where('pos_emp_modules pm',$options);
        
        return $query->result_array();
   }  
}
?>