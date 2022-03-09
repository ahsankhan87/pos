<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_taxes extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    //get all taxes and also only one tax and active and inactive too.
    public function get_taxes($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            
            //$this->db->order_by('id','desc');
            $options = array('company_id'=> $_SESSION['company_id']);
        
            $query = $this->db->get_where('pos_taxes',$options);
            $data = $query->result_array();
            return $data;
        }
        
        //$this->db->order_by('id','desc');
        $options = array('id'=> $id,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_taxes',$options);
        $data = $query->result_array();
        return $data;
    }
             
    //get all taxes and also only one tax and active and inactive too.
    public function get_activetaxes($id = FALSE, $limit = 1000000, $offset = 0)
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
            $query = $this->db->get_where('pos_taxes',$options);
            $data = $query->result_array();
            return $data;
        }
        
        $this->db->order_by('id','desc');
        $options = array('id'=> $id,'status'=>1,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_taxes',$options);
        $data = $query->result_array();
        return $data;
    }
    
    function gettaxDropDown()
    {
        $data = array();
        $data['']= 'Select Tax Account';
        
        $query = $this->db->get_where('pos_taxes',array('status'=>1,'company_id'=> $_SESSION['company_id']));
        
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
    
    
    function gettaxDropDownWithRate()
    {
        $data = array();
        $data[0]= 'Select Tax Account';
        
        $query = $this->db->get_where('pos_taxes',array('status'=>1,'company_id'=> $_SESSION['company_id']));
        
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                 $data[$row['rate']] = $row['name'];
            }
        }
        $query->free_result();
        return $data;
    }
    
   
    function addtax($data = array())
        {
            $data = array(
            'company_id'=> $data['company_id'],
            'name' => $data['name'],
            'rate' => $data['rate'],
            'description' => $data['description'],
            'status' => $data['status']
            );
            $this->db->insert('pos_taxes', $data);
            
            return ($this->db->affected_rows() != 1) ? false : true;
        }
        
     function updatetax($data = array(),$id)
        {
            //$file_name = $this->upload->data();
            
            $data = array(
            'company_id'=> $_SESSION['company_id'],
            'name' => $data['name'],
            'rate' => $data['rate'],
            'description' => $data['description'],
            'status' => $data['status']
            );
             $this->db->update('pos_taxes', $data, array('id'=>$id));
            
            return ($this->db->affected_rows() != 1) ? false : true;
            
            
           
        }
    
    public function get_taxName($tax_id)
    {
        $options = array('id'=> $tax_id,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_taxes',$options);
        if($row = $query->row())
        {
            return $row->name;
        }
        
        return '';
    }
    
    function deletetax($id)
    {
        $query = $this->db->delete('pos_taxes',array('id'=>$id));
        
        //for logging
            $msg = 'tax ID '. $id;
            $this->M_logs->add_log($msg,"tax","Deleted","Setting");
            // end logging
    }
    
    function inactivate($id)
    {
        $query = $this->db->update('pos_taxes',array('status'=>0),array('id'=>$id));
          //for logging
            $msg = 'tax ID '. $id;
            $this->M_logs->add_log($msg,"tax","Inactivated","Setting");
            // end logging
    }
    
    function activate($id)
    {
        $query = $this->db->update('pos_taxes',array('status'=>1),array('id'=>$id));
         //for logging
            $msg = 'tax ID '. $id;
            $this->M_logs->add_log($msg,"tax","Activated","Setting");
            // end logging
    }
}


?>