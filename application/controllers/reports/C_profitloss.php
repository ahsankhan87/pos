<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_profitloss extends MY_Controller{
    
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
        $data['title'] = lang('income_exp');
        $data['main'] = lang('income_exp');
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : FY_START_DATE);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : FY_END_DATE);
        
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        $data['proft_loss']= $this->M_reports->get_parentGroups4pl($_SESSION['company_id']);
        
                    //for logging
                    $msg = '';
                    $this->M_logs->add_log($msg,"Pofit & Loss Report","Retrieved","Accounts");
                    // end logging
        
        $this->load->view('templates/header',$data);
        $this->load->view('reports/pl-2',$data);
        $this->load->view('templates/footer');
        
    }
    
    public function run_pl_report()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','10240M');

        //$this->output->enable_profiler(TRUE);
        $data['title'] = 'Retained Earning Account';
        $data['main'] = 'Retained Earning Account';
        $retained_earning_account = $this->input->post('retained_earning_account');
        
        if($retained_earning_account)
        {
            $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : FY_START_DATE);
            $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : FY_END_DATE);
            
            $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
            
            $proft_loss = $this->M_reports->get_parentGroups4pl($_SESSION['company_id']);
                
            foreach($proft_loss as $key => $list)
            {
                
                $pl_report = $this->M_reports->get_profit_loss($_SESSION['company_id'],$list['account_code'],$data['from_date'],$data['to_date']);
                foreach($pl_report as $key => $values):
                    
                    $balance=$values['debit']-$values['credit'];
                    
                    if($balance > 0)//debit balance
                    {
                        $this->M_entries->addEntries($retained_earning_account,$values['account_code'],$balance,$balance,'Closing Temporary Accounts');
                   
                    }
                    if($balance < 0){ // credit balance
                    
                        $this->M_entries->addEntries($values['account_code'],$retained_earning_account,abs($balance),abs($balance),'Closing Temporary Accounts');
                   
                    }
                    
                endforeach;
            }
            
                        //for logging
                    $msg = 'Temp Accounts closed';
                    $this->M_logs->add_log($msg,"Retained Earnings","Acounts Closed","Accounts");
                    // end logging
                    
            $this->session->set_flashdata('message','Temporary accounts closed successfully');
            redirect('reports/C_profitloss/run_pl_report/','refresh');
        }
        
        $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);
             
            //for logging
                    $msg = 'Temp Accounts closed';
                    $this->M_logs->add_log($msg,"Retained Earnings","Acounts Closed","Accounts");
                    // end logging
                    
        $this->load->view('templates/header',$data);
        $this->load->view('reports/v_run_profit_report',$data);
        $this->load->view('templates/footer');
        
    }
}