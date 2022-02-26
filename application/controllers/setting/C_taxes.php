<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_taxes extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    } 

    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Manage taxes';
        $data['main'] = 'Manage taxes';
        
        //$data['cities'] = $this->M_city->get_city();
        $data['taxes']= $this->M_taxes->get_activetaxes();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/taxes/v_taxes',$data);
        $this->load->view('templates/footer');
    }
    
    function tax_rate($to_tax, $amount=1) {
        //echo $_SESSION['home_tax_code'];
        print_r($this->M_taxes->get_tax_rate($_SESSION['home_tax_code'],$to_tax,$amount));
    }
                            
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            
            //form Validation
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('rate', 'Rate', 'required');
            //$this->form_validation->set_rules('tax_account_no', 'tax_account_no', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
                $data = array(
                'company_id'=> $_SESSION['company_id'],
                'name' => $this->input->post('name', true),
                'rate' => $this->input->post('rate', true),
                'description' => $this->input->post('description', true),
                'status' => $this->input->post('status', true),
                
                );
            
                if($this->M_taxes->addtax($data)) {
                    //for logging
                        $msg = $this->input->post('name', true);
                        $this->M_logs->add_log($msg,"tax","added","Setting");
                        // end logging
            
                    $this->session->set_flashdata('message','Tax Created');
                }else{
                   $this->session->set_flashdata('error','Tax not created');
                }
                
                redirect('setting/C_taxes/index','refresh');
            
           }
        }
            $data['title'] = 'Create Tax';
            $data['main'] = 'Create New Tax';
            
               
            $this->load->view('templates/header',$data);
            $this->load->view('pos/taxes/create',$data);
            $this->load->view('templates/footer');
        
    }
    //edit category
    public function edit($id=NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form Validation
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('rate', 'Rate', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
                 $data = array(
                    'company_id'=> $_SESSION['company_id'],
                    'name' => $this->input->post('name', true),
                    'rate' => $this->input->post('rate', true),
                    'description' => $this->input->post('description', true),
                    'status' => $this->input->post('status', true),
                    
                );
                
                if($this->M_taxes->updatetax($data,$this->input->post('id',true))) {
                    
                    //for logging
                    $msg = $this->input->post('name', true);
                    $this->M_logs->add_log($msg,"tax","updated","Setting");
                    // end logging
                    
                    $this->session->set_flashdata('message','Tax Updated');
                }else{
                    $this->session->set_flashdata('error','Tax not updated');
                }
           
            //$this->M_taxes->updatetax();
            //$this->session->set_flashdata('message','tax Updated');
            redirect('setting/C_taxes/index','refresh');
            }
        }
       
            $data['title'] = 'Update Tax';
            $data['main'] = 'Update Tax';
            
            $data['tax'] = $this->M_taxes->get_taxes($id);
            
            $this->load->view('templates/header',$data);
            $this->load->view('pos/taxes/edit',$data);
            $this->load->view('templates/footer');
        
    }
    
    function taxDetail($tax_id)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'tax Detail';
        $data['main'] = 'tax Detail';
       
        $data['tax'] = $this->M_taxes->get_taxes($tax_id);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/taxes/v_taxDetail',$data);
        $this->load->view('templates/footer');
    }
    function delete($id)
    {
        $this->M_taxes->deletetax($id);
        $this->session->set_flashdata('message','tax Deleted');
        redirect('setting/C_taxes/index','refresh');
    }
    
    function inactivate($id) // it will inactive the page
    {
        $this->M_taxes->inactivate($id);
        $this->session->set_flashdata('message','Tax in-activated');
        redirect('setting/C_taxes/index','refresh');
    }
    
    function activate($id) // it will active 
    {
        $this->M_taxes->activate($id);
        $this->session->set_flashdata('message','Tax Activated');
        redirect('setting/C_taxes/index','refresh');
    }
    
    
}