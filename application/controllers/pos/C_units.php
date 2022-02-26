<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class C_units extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('listof').' ' .lang('unit');
        $data['main'] = lang('listof').' ' .lang('unit');
        
        $data['units'] = $this->M_units->get_unit();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/units/v_units',$data);
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
                  $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                      'company_id'=> $_SESSION['company_id']
                     );
                  
                  if($this->db->insert('pos_units',$data)) {
                    $this->session->set_flashdata('message','units Added');
                    }else{
                    $data['flash_message'] = false;
                    }
                  
                
            //$this->M_units->add_unit();
            
            redirect('pos/C_units/index','refresh');
        }
        }
        
        $data['title'] = lang('add_new').' ' .lang('unit');
        $data['main'] = lang('add_new').' ' .lang('unit');
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/units/create',$data);
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
                  $data = array(  'name'=>$_POST['name'],
                        'status'=>$_POST['status'],
                      'company_id'=> $_SESSION['company_id']
                     );
                  
                  if($this->db->update('pos_units',$data,array('id'=>$_POST['id']))) {
                    $this->session->set_flashdata('message','units Updated');
                    }else{
                    $data['flash_message'] = false;
                    }
                    
            //$this->M_units->update_unit();
            //$this->session->set_flashdata('message','unit Updated');
            redirect('pos/C_units/index','refresh');
        }
        }
        $data['title'] = lang('update').' ' .lang('unit');
        $data['main'] = lang('update').' ' .lang('unit');
        
        $data['update_unit'] = $this->M_units->get_unit($id);      
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/units/edit',$data);
        $this->load->view('templates/footer');
    }
    
    function delete($id)
    {
        $this->M_units->delete_unit($id);
        $this->session->set_flashdata('message','Units Deleted / Inactivated');
        redirect('pos/C_units/index','refresh');
    }
}