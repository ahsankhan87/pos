<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_dashboard extends MY_Controller{
  
  public function __construct()
    {
        parent::__construct();
        
        $this->load->helper('language');
        $this->lang->load('index');
    }
  
  public function index()
    {
        //$this->output->enable_profiler(true);
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Dashboard';
        $data['main'] = lang('home_searchBox');
        
        $data['net_income']= $this->M_reports->get_net_income();
        //$data['totalStock']= $this->M_dashboard->totalStock($_SESSION["company_id"]);
        $data['totalStock'] = $this->M_dashboard->get_level3_account_balance('inventory',FY_START_DATE,FY_END_DATE);
        
        $data['monthlySaleReport']= $this->M_dashboard->monthlySaleReport($_SESSION["company_id"],FY_YEAR,'sales');
        $data['expenses'] = $this->M_dashboard->get_ExpensesAccounts('operative_expenses',FY_START_DATE,FY_END_DATE,10);
        
        $data['total_expenses'] = $this->M_dashboard->get_level2_account_balance('operative_expenses',FY_START_DATE,FY_END_DATE);
        //var_dump($data['total_expenses']);
        
        $today = date("Y-m-d");
        $data['today_sale'] = $this->M_dashboard->today_sale($today,$_SESSION["company_id"]); 
        
        $cur_month = date("Y-m");
        $data['cur_month'] = $this->M_dashboard->month_sale($cur_month,$_SESSION["company_id"]);
        
        //$ledgers= $this->M_ledgers->getLedgerByName('Revenue');
       
        $this->load->view('templates/header',$data);
        $this->load->view('v_dashboard',$data);
        $this->load->view('templates/footer');
    }
    
   function create_calendar()
   {
        //$this->output->enable_profiler();
        
        $start_date = '2016-01-01';
        $end_date = '2016-12-31';
        
        $this->M_pos_reports->fill_calendar($start_date, $end_date,$_SESSION['company_id']);
        
        //echo 'success';

   } 
}
 