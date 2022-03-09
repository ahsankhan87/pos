<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_category extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    // get all category e.g active and inactive.
    public function get_category($id = FALSE, $limit = 10000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            $options = array('company_id'=> $_SESSION['company_id']);
            $query = $this->db->get_where('pos_categories',$options);
            return $query->result_array();
        }
        
        $options = array('id'=> $id,'company_id'=> $_SESSION['company_id']);
        $query = $this->db->get_where('pos_categories',$options);
        
                
        return $query->result_array();
        
    }
    
    public function get_CatNameByItem($category_id)
    {
        
        $options = array('id'=> $category_id,'company_id'=> $_SESSION['company_id']);
        $query = $this->db->get_where('pos_categories',$options);
        
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->name;
        }
        return '';
        
    }
    
    //get all active category but if id is provided then one result will be retrieved.
    public function get_activeCategory($id = FALSE, $limit = 10000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            $query = $this->db->get_where('pos_categories',array('status' =>'active','company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
        $options = array('id'=> $id,'status'=>'active','company_id'=> $_SESSION['company_id']);
        $query = $this->db->get_where('pos_categories',$options);
        
                
        return $query->result_array();
        
    }
    
    function addCategory()
        {
            $data = array(
                'company_id'=> $_SESSION['company_id'],
            'name' => $this->input->post('name',true),
            'short_desc' => $this->input->post('short_desc',true),
            'long_desc' => $this->input->post('long_desc',true),
            'status' => $this->input->post('status',true),
            'parent_id' => $this->input->post('parent_id',true)
            );
            $this->db->insert('pos_categories', $data);
            
            //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"Category","Added","POS");
            // end logging
        }
        
    function updateCategory()
        {
            $data = array(
                'company_id'=> $_SESSION['company_id'],
             'name' => $this->input->post('name',true),
            'short_desc' => $this->input->post('short_desc',true),
            'long_desc' => $this->input->post('long_desc',true),
            'status' => $this->input->post('status',true),
            'parent_id' => $this->input->post('parent_id',true)
            );
            
            $this->db->update('pos_categories', $data,array('id'=>  $this->input->post('id')));
            
            //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"Category","Updated","POS");
            // end logging
        }
    
    function deleteCategory($id)
    {
        $query = $this->db->delete('pos_categories',array('id'=>$id));
        
           //for logging
            $msg = 'Category id: '.$id;
            $this->M_logs->add_log($msg,"Category","Deleted","POS");
            // end logging
    }
        
    function getTopCategories()
        {
            $data[0] = 'root';
            //$this->db->where('parent_id',0);
            $this->db->where('company_id', $_SESSION['company_id']);
            $query = $this->db->get('pos_categories');
            
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
    
    //for drop down list in creating new product.
    function getCategoriesDropDown()
        {
            $data = array();
            $data[0] = '--Please Select--';
            
            $this->db->where('company_id', $_SESSION['company_id']);
            $query = $this->db->get('pos_categories');
            
            
            if ($query->num_rows() > 0)
            {
                foreach ($query->result_array() as $row)
                {
                     $data[$row['id']] = $row['name'];
                }
            }
            
            //$query->free_result();
            return $data;
        }
        
    function checkOrphanProducts($id)
    {
        $data = array();
        $this->db->select('item_id,name');
        $query = $this->db->get_where('pos_items',array('category_id'=>$id));
        
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $rows)
            {
                $data[$rows['item_id']] = $rows['name'];
            }
        }
        return $data;
    }
}


?>