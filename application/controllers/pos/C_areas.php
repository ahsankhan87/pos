<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class C_areas extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'List of Areas';
        $data['main'] = 'List of Areas';
        
        $data['areas'] = $this->M_areas->get_area();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/employees/areas/v_areas',$data);
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
                        'description'=>$_POST['description'],
                      'company_id'=> $_SESSION['company_id']
                     );
                  
                  if($this->db->insert('pos_emp_area',$data)) {
                    $this->session->set_flashdata('message','areas Added');
                    }else{
                    $data['flash_message'] = false;
                    }
                  
                
            //$this->M_areas->add_area();
            
            redirect('pos/C_areas/index','refresh');
        }
        }
        
        $data['title'] = 'Add New Area';
        $data['main'] = 'Add New Area';
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/employees/areas/create',$data);
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
                        'description'=>$_POST['description'],
                      'company_id'=> $_SESSION['company_id']
                     );
                  
                  if($this->db->update('pos_emp_area',$data,array('id'=>$_POST['id']))) {
                    $this->session->set_flashdata('message','areas Updated');
                    }else{
                    $data['flash_message'] = false;
                    }
                    
            //$this->M_areas->update_area();
            //$this->session->set_flashdata('message','area Updated');
            redirect('pos/C_areas/index','refresh');
        }
        }
        $data['title'] = 'Update Area';
        $data['main'] = 'Update Area';
        
        $data['update_area'] = $this->M_areas->get_area($id);      
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/employees/areas/edit',$data);
        $this->load->view('templates/footer');
    }
    
    function delete($id)
    {
        $this->M_areas->delete_area($id);
        $this->session->set_flashdata('message','Area Deleted / Inactivated');
        redirect('pos/C_areas/index','refresh');
    }
}