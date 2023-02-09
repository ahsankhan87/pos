<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_salesreport extends MY_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    
    public function index(){
        //$this->output->enable_profiler(TRUE);
        $data = array('langs' => $this->session->userdata('lang'));
        
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','10240M');

        $data['title'] = 'Daily '.lang('sales').' '.lang('report');
        $data['main'] = 'Daily '.lang('sales').' '.lang('report');
        
        $data['active_tab_0'] = 'active';
        $data['active_tab_1'] = '';
        $data['active_tab_2'] = '';
        $data['active_tab_3'] = '';
        $data['active_tab_4'] ='';
        $data['active_tab_5'] ='';

        $data['from_date'] = date('Y-m-d');
        $data['to_date'] = date('Y-m-d');
        
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        $customer_id= 0;
        $product_id=0;
        $emp_id=0;
        $register_mode='all';
        $sale_type='all';
        $data['CustomerDDL'] = $this->M_customers->getCustomerDropDown();
        $data['productsDDL'] = $this->M_items->getItemDropDown();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        
        
        $data['daily_sales_report'] = $this->M_pos_reports->sales_reports($data['from_date'],$data['to_date'],$_SESSION['company_id'],$customer_id,$product_id,$emp_id,$register_mode,$sale_type);
            
            //for logging
            $msg = '';
            $this->M_logs->add_log($msg,"Daily Sales Report","Retrieved","Accounts");
            // end logging
                    
        $this->load->view('templates/header',$data);
        $this->load->view('reports/sales/sales_report',$data);
        $this->load->view('templates/footer');
    }

    public function sales_report(){
        //$this->output->enable_profiler(TRUE);
        $data = array('langs' => $this->session->userdata('lang'));
        
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','10240M');

        $data['title'] = lang('sales').' '.lang('report');
        $data['main'] = lang('sales').' '.lang('report');
        
        $data['active_tab_0'] = '';
        $data['active_tab_1'] = 'active';
        $data['active_tab_2'] = '';
        $data['active_tab_3'] = '';
        $data['active_tab_4'] ='';
        $data['active_tab_5'] ='';
        
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : 0);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : 0);
        
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        $customer_id= $this->input->post('customer_id');
        $product_id=$this->input->post('item_id');
        $emp_id=$this->input->post('emp_id');
        $register_mode=$this->input->post('register_mode');
        $sale_type=$this->input->post('sale_type');
        $data['register_mode']=$register_mode;
        $data['sale_type']=$sale_type;
        
        $data['CustomerDDL'] = $this->M_customers->getCustomerDropDown();
        $data['productsDDL'] = $this->M_items->getItemDropDown();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        
        if($data['from_date'] && $data['to_date'])
        {
        $data['sales_report'] = $this->M_pos_reports->sales_reports($data['from_date'],$data['to_date'],$_SESSION['company_id'],$customer_id,$product_id,$emp_id,$register_mode,$sale_type);
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
        
        $data['title'] = lang('customer').' '.lang('wise').' '.lang('sales').' '.lang('report');
        $data['main'] = lang('customer').' '.lang('wise').' '.lang('sales').' '.lang('report');
        
        $data['active_tab_0'] = '';
        $data['active_tab_1'] = '';
        $data['active_tab_2'] = 'active';
        $data['active_tab_3'] = '';
        $data['active_tab_4'] ='';
        $data['active_tab_5'] ='';
        
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : 0);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : 0);
        
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        //$customer_id= $this->input->post('customer_id');
        //$product_id=$this->input->post('item_id');
        $emp_id=$this->input->post('emp_id');
        $register_mode=$this->input->post('register_mode');
        $sale_type=$this->input->post('sale_type');
        $data['register_mode']=$register_mode;
        $data['sale_type']=$sale_type;
        
        $data['CustomerDDL'] = $this->M_customers->getCustomerDropDown();
        $data['productsDDL'] = $this->M_items->getItemDropDown();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        
        if($data['from_date'] && $data['to_date'])
        {
        $data['customerWise_sales_report'] = $this->M_pos_reports->customer_wise_sales($data['from_date'],$data['to_date'],$_SESSION['company_id'],$emp_id,$register_mode,$sale_type);
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
        
        $data['title'] = lang('product').' '.lang('wise').' '.lang('sales').' '.lang('report');
        $data['main'] = lang('product').' '.lang('wise').' '.lang('sales').' '.lang('report');
        
        $data['active_tab_0'] = '';
        $data['active_tab_1'] = '';
        $data['active_tab_2'] = '';
        $data['active_tab_3'] = 'active';
        $data['active_tab_4'] ='';
        $data['active_tab_5'] ='';
        
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : 0);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : 0);
        
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        //$customer_id= $this->input->post('customer_id');
        //$product_id=$this->input->post('item_id');
        $emp_id=$this->input->post('emp_id');
        $register_mode=$this->input->post('register_mode');
        $sale_type=$this->input->post('sale_type');
        $data['register_mode']=$register_mode;
        $data['sale_type']=$sale_type;
        
        $data['CustomerDDL'] = $this->M_customers->getCustomerDropDown();
        $data['productsDDL'] = $this->M_items->getItemDropDown();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        
        if($data['from_date'] && $data['to_date'])
        {
        $data['productWise_sales_report'] = $this->M_pos_reports->product_wise_sales($data['from_date'],$data['to_date'],$_SESSION['company_id'],$emp_id,$register_mode,$sale_type);
        }
                    //for logging
                    $msg = '';
                    $this->M_logs->add_log($msg,"product_wise Sales Report","Retrieved","Accounts");
                    // end logging
                    
        $this->load->view('templates/header',$data);
        $this->load->view('reports/sales/sales_report',$data);
        $this->load->view('templates/footer');
    }
    
    public function categoryWiseSales(){
        //$this->output->enable_profiler(TRUE);
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('category').' '.lang('wise').' '.lang('sales').' '.lang('report');
        $data['main'] = lang('category').' '.lang('wise').' '.lang('sales').' '.lang('report');
        
        $data['active_tab_0'] = '';
        $data['active_tab_1'] = '';
        $data['active_tab_2'] = '';
        $data['active_tab_3'] = '';
        $data['active_tab_4'] = '';
        $data['active_tab_5'] = 'active';
        
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : 0);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : 0);
        
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        //$customer_id= $this->input->post('customer_id');
        //$product_id=$this->input->post('item_id');
        $emp_id=($this->input->post('emp_id') == '' ? 0 : $this->input->post('emp_id'));
        $register_mode=$this->input->post('register_mode');
        $sale_type=$this->input->post('sale_type');
        $data['register_mode']=$register_mode;
        $data['sale_type']=$sale_type;
        
        $data['CustomerDDL'] = $this->M_customers->getCustomerDropDown();
        $data['categoryDDL'] = $this->M_items->getItemDropDown();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        
        if($data['from_date'] && $data['to_date'])
        {
        $data['categoryWise_sales_report'] = $this->M_pos_reports->category_wise_sales($data['from_date'],$data['to_date'],$_SESSION['company_id'],$emp_id,$register_mode,$sale_type);
        }
                    //for logging
                    $msg = '';
                    $this->M_logs->add_log($msg,"product_wise Sales Report","Retrieved","Accounts");
                    // end logging
                    
        $this->load->view('templates/header',$data);
        $this->load->view('reports/sales/sales_report',$data);
        $this->load->view('templates/footer');
    }
    
    public function customerLastSales(){
        //$this->output->enable_profiler(TRUE);
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('customer').' '.lang('last').' '.lang('sales').' '.lang('report');
        $data['main'] = lang('customer').' '.lang('last').' '.lang('sales').' '.lang('report');
        
        $data['active_tab_0'] = '';
        $data['active_tab_1'] = '';
        $data['active_tab_2'] = '';
        $data['active_tab_3'] = '';
        $data['active_tab_4'] ='active';
        $data['active_tab_5'] ='';
        
        $data['customerLastSales_report'] = $this->M_pos_reports->customer_last_sales();
        
        //$data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : 0);
//        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : 0);
//        
//        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
//        
//        //$customer_id= $this->input->post('customer_id');
//        //$product_id=$this->input->post('item_id');
//        $emp_id=$this->input->post('emp_id');
//        
//        $data['CustomerDDL'] = $this->M_customers->getCustomerDropDown();
//        $data['productsDDL'] = $this->M_items->getItemDropDown();
//        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
//        
//        if($data['from_date'] && $data['to_date'])
//        {
//        $data['productWise_sales_report'] = $this->M_pos_reports->product_wise_sales($data['from_date'],$data['to_date'],$_SESSION['company_id'],$emp_id);
//        }
                    //for logging
                    $msg = '';
                    $this->M_logs->add_log($msg,"product_wise Sales Report","Retrieved","Accounts");
                    // end logging
                    
        $this->load->view('templates/header',$data);
        $this->load->view('reports/sales/customer_last_sale',$data);
        $this->load->view('templates/footer');
    }
}