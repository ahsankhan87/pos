<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_currencies extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    } 

    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Manage currencies';
        $data['main'] = 'Manage currencies';
        
        //$data['cities'] = $this->M_city->get_city();
        $data['currencies']= $this->M_currencies->get_activecurrencies();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/currencies/v_currencies',$data);
        $this->load->view('templates/footer');
    }
    
    function currency_rate($to_Currency, $amount=1) {
        //echo $_SESSION['home_currency_code'];
        print_r($this->M_currencies->get_currency_rate($_SESSION['home_currency_code'],$to_Currency,$amount));
    }
                            
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            
            //form Validation
            $this->form_validation->set_rules('name', 'Namw', 'required');
            $this->form_validation->set_rules('symbol', 'Currency Symbol', 'required');
            //$this->form_validation->set_rules('currency_account_no', 'currency_account_no', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
                $data = array(
                'company_id'=> $_SESSION['company_id'],
                'country' => $this->input->post('country', true),
                'name' => $this->input->post('name', true),
                'code' => $this->input->post('code', true),
                'symbol' => $this->input->post('symbol', true),
                'status' => 1
                );
            
                if($this->db->insert('pos_currencies', $data)) {
                    
                    //for logging
                    $msg = $this->input->post('name',true);
                    $this->M_logs->add_log($msg,"currency","added","POS");
                    // end logging
                    
                    $this->session->set_flashdata('message','currency Created');
                }else{
                   $this->session->set_flashdata('error','currency not updated');
                }
                
                redirect('pos/C_currencies/index','refresh');
            
           }
        }
            $data['title'] = 'Create currency';
            $data['main'] = 'Create New currency';
            
               
            $this->load->view('templates/header',$data);
            $this->load->view('pos/currencies/create',$data);
            $this->load->view('templates/footer');
        
    }
    //edit category
    public function edit($id=NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form Validation
            $this->form_validation->set_rules('name', 'Namw', 'required');
            $this->form_validation->set_rules('symbol', 'Currency Symbol', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
                $data = array(
                'country' => $this->input->post('country', true),
                'name' => $this->input->post('name', true),
                'code' => $this->input->post('code', true),
                'symbol' => $this->input->post('symbol', true),
                );
            //$this->db->update('pos_currencies', $data, array('id'=>$_POST['id']));
            
                if($this->db->update('pos_currencies', $data, array('id'=>$_POST['id']))) {
                    
                    //for logging
                    $msg = $this->input->post('name',true);
                    $this->M_logs->add_log($msg,"currency","updated","POS");
                    // end logging
                    
                    $this->session->set_flashdata('message','currency Updated');
                }else{
                    $this->session->set_flashdata('error','currency not updated');
                }
           
            //$this->M_currencies->updatecurrency();
            //$this->session->set_flashdata('message','currency Updated');
            redirect('pos/C_currencies/index','refresh');
            }
        }
       
            $data['title'] = 'Update currency';
            $data['main'] = 'Update currency';
            
            $data['currency'] = $this->M_currencies->get_currencies($id);
            
            $this->load->view('templates/header',$data);
            $this->load->view('pos/currencies/edit',$data);
            $this->load->view('templates/footer');
        
    }
    
    function currencyDetail($currency_id)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'currency Detail';
        $data['main'] = 'currency Detail';
       
        $data['currency'] = $this->M_currencies->get_currencies($currency_id);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/currencies/v_currencyDetail',$data);
        $this->load->view('templates/footer');
    }
    function delete($id)
    {
        $this->M_currencies->deletecurrency($id);
        $this->session->set_flashdata('message','currency Deleted');
        redirect('pos/C_currencies/index','refresh');
    }
    
    function inactivate($id) // it will inactive the page
    {
        $this->M_currencies->inactivate($id);
        $this->session->set_flashdata('message','currency in-activated');
        redirect('pos/C_currencies/index','refresh');
    }
    
    function activate($id) // it will active 
    {
        $this->M_currencies->activate($id);
        $this->session->set_flashdata('message','currency Activated');
        redirect('pos/C_currencies/index','refresh');
    }
    
    
}