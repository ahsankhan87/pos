<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_fyear extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        
    }
    
    //get all products and also only one product and active and inactive too.
    public function get_Fyear($id = FALSE,$company_id=0)
    {
        if($id === FALSE)
        {
           
            //$this->db->order_by('sort','asc');
            $option = array('company_id'=> $company_id);
            $query = $this->db->get_where('acc_fiscal_years',$option);
            $data = $query->result_array();
            return $data;
        }
        
        //$this->db->order_by('sort','asc');
        $options = array('id'=> $id,'company_id'=> $company_id);
        
        $query = $this->db->get_where('acc_fiscal_years',$options);
        $data = $query->result_array();
        return $data;
    }
    
    function get_ActiveFyear($company_id)
    {
        //$this->db->order_by('id','desc');
        $options = array('company_id'=> $company_id,'status'=>'active');
        
        $query = $this->db->get_where('acc_fiscal_years',$options,1);
        $data = $query->result_array();
        return $data;
    }
    
    function addFyear()
    {
        $data = array(
        'company_id'=> $_SESSION['company_id'],
        'fy_start_date' => $this->input->post('fy_start_date',true),
        'fy_end_date' => $this->input->post('fy_end_date',true),
        'fy_year' => $this->input->post('fy_year',true),
        'status' => $this->input->post('status',true),
        );
        
        $this->db->insert('acc_fiscal_years', $data);
        
                    //for logging
                    $msg = 'Fiscal Year '.$this->input->post('fy_year',true);
                    $this->M_logs->add_log($msg,"fyear","added","Accounts");
                    // end logging
                    
    }
    
    function editFyear()
    {
        $data = array(
        'company_id'=> $_SESSION['company_id'],
        'fy_start_date' => $this->input->post('fy_start_date',true),
        'fy_end_date' => $this->input->post('fy_end_date',true),
        'fy_year' => $this->input->post('fy_year',true),
        //'status' => $this->input->post('status',true),
        );
        
                    //for logging
                    $msg = 'Fiscal Year '.$this->input->post('fy_year',true);
                    $this->M_logs->add_log($msg,"fyear","updated","Accounts");
                    // end logging
                    
       $this->db->update('acc_fiscal_years', $data, array('id'=>$this->input->post('id')));
            
    }
    
    function activateFyear($id)
    {
        $this->db->update('acc_fiscal_years', array('status'=>'inactive'));
        
        $data = array(
        'status' => 'active',
        );
        
                    //for logging
                    $msg = 'Fiscal Year id '.$id;
                    $this->M_logs->add_log($msg,"fyear","activated","Accounts");
                    // end logging
                    
       $this->db->update('acc_fiscal_years', $data, array('id'=>$id));
       
       //ASSIGN IT TO CONSTANT VARIABLES IN MY_CONTROLLER 
       $fyear = $this->get_ActiveFyear($_SESSION['company_id']);
       $_SESSION['fy_year'] = $fyear[0]['fy_year'];
       $_SESSION['fy_start_date'] =$fyear[0]['fy_start_date'];
       $_SESSION['fy_end_date'] = $fyear[0]['fy_end_date'];
       //////////////////////
             
    }
    
    function getFyearDDL()
    {
        $data = array();
        $data[''] = '--Please Select--';
        
        //$this->db->group_by('account_code','asc');
        $option = array('company_id'=> $_SESSION['company_id']);
        $query = $this->db->get_where('acc_fiscal_years',$option);
            
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                 $data[$row['id']] = $row['fy_year'];
            }
        }
        $query->free_result();
        return $data;
    }
    
    function deleteFyear($id)
    {
        $this->db->delete('acc_fiscal_years',array('id'=>$id));
        
                    //for logging
                    $msg = 'Fiscal Year id '.$id;
                    $this->M_logs->add_log($msg,"fyear","deleted","Accounts");
                    // end logging
                    
    }
}