<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class sizes extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'List of Sizes';
        $data['main'] = 'List of Sizes';
        
        $data['sizes'] = $this->M_sizes->get_size();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/sizes/v_sizes',$data);
        $this->load->view('templates/footer');
    }
    
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            
            //form Validation
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
                  $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                      'company_id'=> $_SESSION['company_id']
                     );
                  
                  if($this->db->insert('pos_sizes',$data)) {
                    $this->session->set_flashdata('message','Sizes Added');
                    }else{
                    $data['flash_message'] = false;
                    }
                  
                
            //$this->M_sizes->add_size();
            
            redirect('pos/Sizes/index','refresh');
        }
        }
        
        $data['title'] = 'Add New Size';
        $data['main'] = 'Add New Size';
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/sizes/create',$data);
        $this->load->view('templates/footer');
    }
    
    function edit($id = NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form Validation
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
                  $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                      'company_id'=> $_SESSION['company_id']
                     );
                  
                  if($this->db->update('pos_sizes',$data,array('id'=>$_POST['id']))) {
                    $this->session->set_flashdata('message','Sizes Updated');
                    }else{
                    $data['flash_message'] = false;
                    }
                    
            //$this->M_sizes->update_size();
            //$this->session->set_flashdata('message','Size Updated');
            redirect('pos/Sizes/index','refresh');
        }
        }
        $data['title'] = 'Update Sizes';
        $data['main'] = 'Update Sizes';
        
        $data['update_size'] = $this->M_sizes->get_size($id);      
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/sizes/edit',$data);
        $this->load->view('templates/footer');
    }
    
    function delete($id)
    {
        $this->M_sizes->delete_size($id);
        $this->session->set_flashdata('message','Sizes Deleted / Inactivated');
        redirect('pos/Sizes/index','refresh');
    }
}