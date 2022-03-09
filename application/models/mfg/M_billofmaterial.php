<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_billofmaterial extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_billofmaterial($item_id = FALSE)
    {
        if($item_id == FALSE)
        {
            $query = $this->db->get_where('mfg_bom',array('company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('mfg_bom',array('item_id'=>$item_id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function get_billofmaterialByItemid($item_id)
    {
       $this->db->select("bom.*,wc.name as workcenter,it.name as item_name");
       $this->db->join('mfg_workcenters wc','wc.id=bom.workcentre_added','left');
       $this->db->join('pos_items it','it.item_id=bom.component','left');
       $query = $this->db->get_where('mfg_bom bom',array('bom.item_id'=>$item_id,'bom.company_id'=> $_SESSION['company_id']));
       
       return $query->result_array();
    }
    
    function get_billofmaterialName($billofmaterial_id)
    {
       $query = $this->db->get_where('mfg_bom',array('id'=>$billofmaterial_id,'company_id'=> $_SESSION['company_id']));
      
       if($billofmaterialName = $query->row())
        {
            return $billofmaterialName->name;
        }
        return '';
    }

    public function item_exist_in_bom($item_id)//bom = bill of material
    {
        $query = $this->db->get_where('mfg_bom',array('item_id'=>$item_id));
        $count = $query->num_rows(); //counting result from query
            
            if($count > 0)
            {
                return true;
            }
            
            return FALSE;      
        
    }
    
    function get_activebillofmaterial($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('mfg_bom',array('status'=>'active','company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('mfg_bom',array('id'=>$id,'status'=>'active','company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function add_billofmaterial()
    {
        $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                      'company_id'=> $_SESSION['company_id']
                     );
                  
        $this->db->insert('mfg_bom',$data);
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"billofmaterial","added","MFG");
            // end logging                    
    }
    
    function update_billofmaterial()
    {
        $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                      'company_id'=> $_SESSION['company_id']
                        
                      );
                  
        $this->db->update('mfg_bom',$data,array('id'=>$_POST['id'])); 
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"billofmaterial","updated","MFG");
            // end logging                     
    }
    
    function inactivate_billofmaterial($id)
    {
        $query = $this->db->update('mfg_bom',array('status'=>'0'),array('id'=>$id));
        
        //for logging
            $msg = $this->input->post('id',true);
            $this->M_logs->add_log($msg,"billofmaterial","inactivated","MFG");
            // end logging    
    }
    
    
    function delete_billofmaterial($id)
    {
        $query = $this->db->delete('mfg_bom',array('id'=>$id));
        
        //for logging
            $msg = $this->input->post('id',true);
            $this->M_logs->add_log($msg,"billofmaterial","Deleted","MFG");
            // end logging    
    }
    
    function get_activebillofmaterialDDL()
    {
        $data = array();
        $data[0] = "--Please Select--";
        $this->db->select('id,name');
        
        $query = $this->db->get_where('mfg_bom',array('status'=>'active','company_id'=> $_SESSION['company_id']));
        
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