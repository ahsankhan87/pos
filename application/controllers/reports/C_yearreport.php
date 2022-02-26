<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_yearreport extends MY_Controller{
    
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
        $data['title'] = 'Annual Report';
        $data['main'] = lang('all_acc_bal_cfy');
        
        $data['groups']= $this->M_groups->get_detail_accounts(false,$_SESSION['company_id']);
        
        //for logging
                    $msg = '';
                    $this->M_logs->add_log($msg,"Annual Report","Retrieved","Accounts");
                    // end logging
                    
        $this->load->view('templates/header',$data);
        $this->load->view('reports/v_year_report',$data);
        $this->load->view('templates/footer');
        
    }
}