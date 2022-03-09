<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class C_locations extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('listof').' ' .lang('location');
        $data['main'] = lang('listof').' ' .lang('location');
        
        $data['locations'] = $this->M_locations->get_location();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/locations/v_locations',$data);
        $this->load->view('templates/footer');
    }
    
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form Validation
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('status', 'status', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run()) 
            {
                $data = array(  'company_id'=> $_SESSION['company_id'],
                        'name'=>$_POST['name'],
                        'status'=>$_POST['status']
                     );
                
                if($this->db->insert('pos_locations',$data)) {
                    $this->session->set_flashdata('message','location Added');
                }else{
                    $data['flash_message'] = false;
                }
            
            //$this->M_locations->add_location();
            
            redirect('pos/C_locations/index','refresh');
            }
        }
        
        $data['title'] = lang('add_new').' ' .lang('location');
        $data['main'] = lang('add_new').' ' .lang('location');
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/locations/create',$data);
        $this->load->view('templates/footer');
    }
    
    function edit($id = NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form Validation
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run()) 
            {
                $data = array(  'company_id'=> $_SESSION['company_id'],
                        'name'=>$_POST['name'],
                        'status'=>$_POST['status']
                     );
                
                if($this->db->update('pos_locations',$data,array('id'=>$_POST['id']))) {
                    $this->session->set_flashdata('message','location Updated');
                }else{
                    $data['flash_message'] = false;
                }
                
            //$this->M_locations->update_location();
            //$this->session->set_flashdata('message','location Updated');
            redirect('pos/C_locations/index','refresh');
        }
        }
        
        $data['title'] = lang('update').' ' .lang('location');
        $data['main'] = lang('update').' ' .lang('location');
        
        $data['update_location'] = $this->M_locations->get_location($id);      
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/locations/edit',$data);
        $this->load->view('templates/footer');
    }
    
    function delete($id)
    {
        $this->M_locations->delete_location($id);
        $this->session->set_flashdata('message','location Deleted / Inactivated');
        redirect('pos/C_locations/index','refresh');
    }
}