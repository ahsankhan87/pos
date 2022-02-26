<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class C_workcenters extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'List of Workcenters';
        $data['main'] = 'List of Workcenters';
        
        $data['workcenters'] = $this->M_workcenters->get_workcenter();
        
        $this->load->view('templates/header',$data);
        $this->load->view('mfg/workcenters/v_workcenters',$data);
        $this->load->view('templates/footer');
    }
    
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            
            //form Validation
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
                  $data = array(  
                      'name'=>$this->input->post('name'),
                      'status'=>$this->input->post('status'),
                      'description'=>$this->input->post('description'),
                      'company_id'=> $_SESSION['company_id']
                     );
                  
                  if($this->db->insert('mfg_workcenters',$data)) {
                        
                        //for logging
                        $msg = $this->input->post('name',true);
                        $this->M_logs->add_log($msg,"workcenter","added","MFG");
                        // end logging     

                    $this->session->set_flashdata('message','Workcenter Added');
                    }else{
                    $data['flash_message'] = false;
                    }
                  
                
            //$this->M_workcenters->add_workcenter();
            
            redirect('mfg/C_workcenters/index','refresh');
        }
        }
        
        $data['title'] = 'Add New Workcenter';
        $data['main'] = 'Add New Workcenter';
        
        $this->load->view('templates/header',$data);
        $this->load->view('mfg/workcenters/create',$data);
        $this->load->view('templates/footer');
    }
    
    function edit($id = NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form Validation
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
                  $data = array(  
                        'name'=>$this->input->post('name'),
                        'status'=>$this->input->post('status'),
                        'description'=>$this->input->post('description'),
                        'company_id'=> $_SESSION['company_id'],
                        'date_updated'=>date("Y-m-d H:i:s"),
                     );
                  
                  if($this->db->update('mfg_workcenters',$data,array('id'=>$this->input->post('id')))) {
                    
                        //for logging
                        $msg = $this->input->post('name',true);
                        $this->M_logs->add_log($msg,"workcenter","updated","MFG");
                        // end logging     

                    $this->session->set_flashdata('message','Workcenter Updated');
                    }else{
                        $data['flash_message'] = false;
                    }
                    
            //$this->M_workcenters->update_workcenter();
            //$this->session->set_flashdata('message','workcenter Updated');
            redirect('mfg/C_workcenters/index','refresh');
        }
        }
        $data['title'] = 'Update workcenters';
        $data['main'] = 'Update workcenters';
        
        $data['update_workcenter'] = $this->M_workcenters->get_workcenter($id);      
        
        $this->load->view('templates/header',$data);
        $this->load->view('mfg/workcenters/edit',$data);
        $this->load->view('templates/footer');
    }
    
    function delete($id)
    {
        $this->M_workcenters->delete_workcenter($id);
        $this->session->set_flashdata('message','Workcenter Deleted');
        redirect('mfg/C_workcenters/index','refresh');
    }
}