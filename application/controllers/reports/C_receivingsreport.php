<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_receivingsreport extends MY_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    public function index(){
        
        $data = array('langs' => $this->session->userdata('lang'));
        
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','10240M');

        $data['title'] = lang('purchases'). ' '.lang('report');
        $data['main'] = lang('purchases'). ' '.lang('report');
        
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : 0);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : 0);
        
        $data['main_small'] = '<br />'.date('d-m-Y',strtotime($data['from_date'])).' To '.date('d-m-Y',strtotime($data['to_date']));
        
        $supplier_id= $this->input->post('supplier_id');
        $product_id=$this->input->post('item_id');
        $emp_id=$this->input->post('emp_id');
        $register_mode=$this->input->post('register_mode');
        $sale_type=$this->input->post('sale_type');
        $data['register_mode']=$register_mode;
        $data['sale_type']=$sale_type;
        
        $data['supplierDDL'] = $this->M_suppliers->getSupplierDropDown();
        $data['productsDDL'] = $this->M_items->getItemDropDown();
        $data['emp_DDL'] = $this->M_employees->getEmployeeDropDown();
        
        if($data['from_date'] && $data['to_date'])
        {
        $data['receivings'] = $this->M_pos_reports->receivings_report($data['from_date'],$data['to_date'],$_SESSION['company_id'],$supplier_id,$product_id,$emp_id,$register_mode,$sale_type);    
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