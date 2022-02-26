<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_reports extends MY_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    public function trial_balance()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Trial Balance';
        $data['main'] = 'Trial Balance';
        
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : FY_START_DATE);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : FY_END_DATE);
        
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        if($data['from_date'] && $data['to_date'])
        {
          $data['trialBalance']= $this->M_groups->get_detail_accounts(FALSE,$_SESSION['company_id']);
          //$data['trialBalance']= $this->M_reports->get_trial_balance($_SESSION['company_id'],$data['from_date'],$data['to_date']);
        }
        
        //for logging
                    $msg = '';
                    $this->M_logs->add_log($msg,"Trail Balance Report","Retrieved","Accounts");
                    // end logging
                    
        $this->load->view('templates/header',$data);
        $this->load->view('reports/trial_balance',$data);
        $this->load->view('templates/footer');
        
    }
    
    public function pl()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        //$this->output->enable_profiler(TRUE);
        $data['title'] = 'Profit &amp; Loss';
        $data['main'] = 'Profit &amp; Loss';
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
            redirect('reports/C_reports/run_pl_report/','refresh');
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
    
    public function balanceSheet()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        //$this->output->enable_profiler(TRUE);
        $data['title'] = 'Balance Sheet';
        $data['main'] = 'Balance Sheet';
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
    
    public function yearReport()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
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
    
    public function salesReport(){
        //$this->output->enable_profiler(TRUE);
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Sales Report';
        $data['main'] = 'Sales Report';
        
        $data['active_tab_0'] = 'active';
        $data['active_tab_1'] = '';
        $data['active_tab_2'] = '';
        
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : 0);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : 0);
        
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        $customer_id= $this->input->post('customer_id');
        $product_id=$this->input->post('item_id');
        $emp_id=$this->input->post('emp_id');
        $register_mode=$this->input->post('register_mode');
        
        $data['CustomerDDL'] = $this->M_customers->getCustomerDropDown();
        $data['productsDDL'] = $this->M_items->getItemDropDown();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        
        if($data['from_date'] && $data['to_date'])
        {
        $data['sales_report'] = $this->M_pos_reports->sales_reports($data['from_date'],$data['to_date'],$_SESSION['company_id'],$customer_id,$product_id,$emp_id,$register_mode);
        }
                    //for logging
                    $msg = '';
                    $this->M_logs->add_log($msg,"Sales Report","Retrieved","Accounts");
                    // end logging
                    
        $this->load->view('templates/header',$data);
        $this->load->view('reports/sales/sales_report',$data);
        $this->load->view('templates/footer');
    }
    
    public function customerWiseSales(){
        //$this->output->enable_profiler(TRUE);
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Customer Wise Sales Report';
        $data['main'] = 'Customer Wise Sales Report';
        
        $data['active_tab_0'] = '';
        $data['active_tab_1'] = 'active';
        $data['active_tab_2'] = '';
        
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : 0);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : 0);
        
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        //$customer_id= $this->input->post('customer_id');
        //$product_id=$this->input->post('item_id');
        $emp_id=$this->input->post('emp_id');
        
        $data['CustomerDDL'] = $this->M_customers->getCustomerDropDown();
        $data['productsDDL'] = $this->M_items->getItemDropDown();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        
        if($data['from_date'] && $data['to_date'])
        {
        $data['customerWise_sales_report'] = $this->M_pos_reports->customer_wise_sales($data['from_date'],$data['to_date'],$_SESSION['company_id'],$emp_id);
        }
                    //for logging
                    $msg = '';
                    $this->M_logs->add_log($msg,"customer_wise Sales Report","Retrieved","Accounts");
                    // end logging
                    
        $this->load->view('templates/header',$data);
        $this->load->view('reports/sales/sales_report',$data);
        $this->load->view('templates/footer');
    }
    
    public function productWiseSales(){
        //$this->output->enable_profiler(TRUE);
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Product Wise Sales Report';
        $data['main'] = 'Product Wise Sales Report';
        
        $data['active_tab_0'] = '';
        $data['active_tab_1'] = '';
        $data['active_tab_2'] = 'active';
        
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : 0);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : 0);
        
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        //$customer_id= $this->input->post('customer_id');
        //$product_id=$this->input->post('item_id');
        $emp_id=$this->input->post('emp_id');
        
        $data['CustomerDDL'] = $this->M_customers->getCustomerDropDown();
        $data['productsDDL'] = $this->M_items->getItemDropDown();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        
        if($data['from_date'] && $data['to_date'])
        {
        $data['productWise_sales_report'] = $this->M_pos_reports->product_wise_sales($data['from_date'],$data['to_date'],$_SESSION['company_id'],$emp_id);
        }
                    //for logging
                    $msg = '';
                    $this->M_logs->add_log($msg,"product_wise Sales Report","Retrieved","Accounts");
                    // end logging
                    
        $this->load->view('templates/header',$data);
        $this->load->view('reports/sales/sales_report',$data);
        $this->load->view('templates/footer');
    }
    
    public function receivingsReport(){
        
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Receivings Report';
        $data['main'] = 'Receivings Report';
        
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : 0);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : 0);
        
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        $supplier_id= $this->input->post('supplier_id');
        $product_id=$this->input->post('item_id');
        $emp_id=$this->input->post('emp_id');
        
        $data['supplierDDL'] = $this->M_suppliers->getSupplierDropDown();
        $data['productsDDL'] = $this->M_items->getItemDropDown();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        
        if($data['from_date'] && $data['to_date'])
        {
        $data['receivings'] = $this->M_pos_reports->receivings_report($data['from_date'],$data['to_date'],$_SESSION['company_id'],$supplier_id,$product_id,$emp_id);    
        }
                    //for logging
                    $msg = '';
                    $this->M_logs->add_log($msg,"Purchase Report","Retrieved","Accounts");
                    // end logging
                    
        $this->load->view('templates/header',$data);
        $this->load->view('reports/receivings/receivings_report',$data);
        $this->load->view('templates/footer');
    }
}