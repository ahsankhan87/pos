<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_fyear extends MY_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    public function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Fiscal Year';
        $data['main'] = 'Fiscal Year';
        
        //$data['cities'] = $this->M_city->get_city();
        $data['Fyear']= $this->M_fyear->get_Fyear(false,$_SESSION['company_id']);
        
                    //for logging
                    $msg = '';
                    $this->M_logs->add_log($msg,"Fiscal year","retrieved","Accounts");
                    // end logging
                    
                    
        $this->load->view('templates/header',$data);
        $this->load->view('accounts/settings/fy/v_fyear',$data);
        $this->load->view('templates/footer');
        
    }
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->post('fy_start_date'))
        {
            $this->M_fyear->addFyear();
            $this->session->set_flashdata('message','Fyear Created');
            redirect('setting/C_fyear/index','refresh');
        }
        else
        {
            $data['title'] = 'Create Fiscal Year';
            $data['main'] = 'Create Fiscal Year';
            
               
            $this->load->view('templates/header',$data);
            $this->load->view('accounts/settings/fy/create',$data);
            $this->load->view('templates/footer');
        }
    }
    
    public function edit($id=NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->post('fy_start_date'))
        {
            $this->M_fyear->editFyear();
            $this->session->set_flashdata('message','Fyear  Updated');
            redirect('setting/C_fyear/index','refresh');
        }
        else
        {
            $data['title'] = 'Update Fiscal Year';
            $data['main'] = 'Update Fiscal Year';
            
            $data['Fyear']= $this->M_fyear->get_Fyear($id,$_SESSION['company_id']);
            
            $this->load->view('templates/header',$data);
            $this->load->view('accounts/settings/fy/edit',$data);
            $this->load->view('templates/footer');
        }
    }
    
    function delete($id)
    {
        $this->M_fyear->deleteFyear($id);
        $this->session->set_flashdata('message','Fiscal Year  Deleted / inactive');
        redirect('setting/C_fyear/index','refresh');
    }
    
    function activateFY($id)
    {
        $this->M_fyear->activateFyear($id);
        $this->session->set_flashdata('message','Fiscal Year Activated');
        redirect('setting/C_fyear/index','refresh');
    }
}