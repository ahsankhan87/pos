<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_workorders extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_workorder($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('mfg_workorders',array('company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('mfg_workorders',array('id'=>$id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function get_workorder_requirements($workorder_id)
    {
       $query = $this->db->get_where('mfg_wo_requirements',array('workorder_id'=>$workorder_id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function get_workorder_costing($workorder_id)
    {
       $query = $this->db->get_where('mfg_wo_costing',array('workorder_id'=>$workorder_id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function get_workorderName($workorder_id)
    {
       $query = $this->db->get_where('mfg_workorders',array('id'=>$workorder_id,'company_id'=> $_SESSION['company_id']));
      
       if($workorderName = $query->row())
        {
            return $workorderName->name;
        }
        return '';
    }
    
    function get_activeworkorders($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('mfg_workorders',array('status'=>'active','company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('mfg_workorders',array('id'=>$id,'status'=>'active','company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function add_workorder()
    {
        $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                      'company_id'=> $_SESSION['company_id']
                     );
                  
        $this->db->insert('mfg_workorders',$data);
        
            //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"workorder","added","MFG");
            // end logging                    
    }
    
    function update_workorder()
    {
        $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                      'company_id'=> $_SESSION['company_id']
                        
                      );
                  
        $this->db->update('mfg_workorders',$data,array('id'=>$_POST['id'])); 
        
        //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"workorder","updated","MFG");
            // end logging                     
    }
    
    function inactivate_workorder($id)
    {
        $query = $this->db->update('mfg_workorders',array('status'=>'0'),array('id'=>$id));
        
        //for logging
            $msg = $this->input->post('id',true);
            $this->M_logs->add_log($msg,"workorder","inactivated","MFG");
            // end logging    
    }
    
    function delete_workorder($id)
    {
        $this->db->trans_start();
        $workorder = $this->get_workorder($id);
        //var_dump($workorder);
            /////////
            $item_detail1 = $this->M_items->getItemsOptions($workorder[0]['item_id']);
            $data_qty1 = array(  
                'quantity'=>($item_detail1[0]['quantity']+(-$workorder[0]['units_issued']))//TYPE 0=ASSEMBLE, 1=UNASSMBLE
            );
            $this->db->update('pos_items_detail',$data_qty1,array('item_id' => $workorder[0]['item_id']));
                //ADD ITEM DETAIL IN INVENTORY TABLE    
                $data1= array(
                    'trans_item'=>$workorder[0]['item_id'],
                    'trans_comment'=>'KSMFG',
                    'trans_inventory'=> (-$workorder[0]['units_issued']),
                    'company_id'=> $_SESSION['company_id'],
                    'trans_user'=> $_SESSION['user_id'],
                    'invoice_no'=> '',
                    'cost_price'=>0,//actually its avg cost comming from sale from
                    'unit_price'=>0,
                    
                    );
                    
                $this->db->insert('pos_inventory', $data1);
                //////////////
            ///////////////////////
        
            /////////////////
            $wo_mfg = $this->get_workorder_requirements($id);
            foreach ($wo_mfg as $value) {
                /////////
                $item_detail = $this->M_items->getItemsOptions($value['item_id']);
                $data_qty = array( 
                    //ADD / SUBTRACT THE BOM QUANTITY FROM ITEM QUANTITY
                    'quantity'=>($item_detail[0]['quantity']+$value['units_issued'])
                );
                $this->db->update('pos_items_detail',$data_qty,array('item_id' => $value['item_id']));
                ///////////////////////
                
                //ADD ITEM DETAIL IN INVENTORY TABLE    
                $data1= array(
                    'trans_item'=>$value['item_id'],
                    'trans_comment'=>'KSMFG',
                    'trans_inventory'=> $value['units_issued'],
                    'company_id'=> $_SESSION['company_id'],
                    'trans_user'=> $_SESSION['user_id'],
                    'invoice_no'=> '',
                    'cost_price'=>0,//actually its avg cost comming from sale from
                    'unit_price'=>0,
                    
                    );
                    
                $this->db->insert('pos_inventory', $data1);
                //////////////
            }
            $this->db->delete('mfg_wo_requirements',array('workorder_id'=>$id));
            /////////////////////
            
            $wo_cost = $this->get_workorder_costing($id);
            foreach ($wo_cost as $value) {
                $this->db->delete('acc_entries',array('id'=>$value['entry_id']));
                $this->db->delete('acc_entry_items',array('entry_id'=>$value['entry_id']));
            }
            $query = $this->db->delete('mfg_wo_costing',array('workorder_id'=>$id));
            ////////////////////////
        
            $this->db->delete('mfg_wo_manufacture',array('workorder_id'=>$id));
        $this->db->delete('mfg_workorders',array('id'=>$id));
            
        $this->db->trans_complete();
            //for logging
            $msg = $id;
            $this->M_logs->add_log($msg,"workorder","Deleted","MFG");
            // end logging    
    }
    
    function get_activeworkordersDDL()
    {
        $data = array();
        $data[0] = "--Please Select--";
        $this->db->select('id,name');
        
        $query = $this->db->get_where('mfg_workorders',array('status'=>'active','company_id'=> $_SESSION['company_id']));
        
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $row)
            {
                $data[$row['id']] = $row['name'];
            }
        }
        return $data;
    }

    function getMAXReferenceNo()
    {   
        $this->db->order_by('CAST(SUBSTR(wo_ref,9) AS UNSIGNED) DESC');
        $this->db->select('SUBSTR(wo_ref,9) as wo_ref');
        $this->db->where('company_id', $_SESSION['company_id']);
        $query = $this->db->get('mfg_workorders',1);
        
        if($query->num_rows() > 0)
        {
            return $query->row()->wo_ref;
        }
        return '';
        
    }
    
    public function check_bom_stock($item_id,$qty)
    {
        $query1 = $this->db->get_where('mfg_bom',array('item_id'=>$item_id));
        $bom_qty = $query1->result_array();
        
        $check_qty = array();
        foreach ($bom_qty as $value) {
            $this->db->select_sum('quantity');
        
            $query = $this->db->get_where('pos_items_detail',array('item_id'=>$value['component']));
            $total = $query->row();
            if($qty <= $total->quantity)
            {
                $check_qty[$value['component']] = 'true';
                
            }else {
                $check_qty[$value['component']] = 'false';
            }
        }
        
        if (in_array('false', $check_qty))
        {
            return false;
        }
        else
        {
            return true;
        }
        
    }
} 