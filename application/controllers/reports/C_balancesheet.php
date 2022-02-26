<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_balancesheet extends MY_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
   
    public function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','10240M');

        //$this->output->enable_profiler(TRUE);
        $data['title'] = lang('balance_sheet');
        $data['main'] = lang('balance_sheet');
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : FY_START_DATE);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : FY_END_DATE);
        
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        $data['net_income']= $this->M_reports->get_net_income();
        $data['parentGroups4Assets']= $this->M_reports->get_parentGroups4Assets($_SESSION['company_id']);
        $data['Liability4BalanceSheet']= $this->M_reports->get_parentGroups4Liability($_SESSION['company_id']);
        
            //for logging
            $msg = '';
            $this->M_logs->add_log($msg,"Balance Sheet","Retrieved","Accounts");
            // end logging
                    
        $this->load->view('templates/header',$data);
        $this->load->view('reports/balance_sheet',$data);
        $this->load->view('templates/footer');
        
    }
    
    
}