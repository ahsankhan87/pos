<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_pos extends MY_Controller{
    
    public function __construct()
    {
        parent::__construct();
        
    }
    
    public function index()
    {
        
    }
    
    public function salesReport(){
        
        $data['title'] = 'Sales Report';
        $data['main'] = 'Sales Report';
        
        $data['froM_date'] = $this->input->post('froM_date');
        $data['to_date'] = $this->input->post('to_date');
        
        if($data['froM_date'] && $data['to_date'])
        {
        $data['sales_report'] = $this->M_pos_reports->sales_reports($data['froM_date'],$data['to_date'],$_SESSION['company_id']);
        }
        
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/reports/sales/sales_report',$data);
        $this->load->view('templates/footer');
    }
    
    public function receivingsReport(){
        
        $data['title'] = 'Purchase Report';
        $data['main'] = 'Purchase Report';
        
         $data['froM_date'] = $this->input->post('froM_date');
         $data['to_date'] = $this->input->post('to_date');
        
        if($data['froM_date'] && $data['to_date'])
        {
            
            $data['receivings'] = $this->M_pos_reports->receivings_report($data['froM_date'],$data['to_date']);    
        }
        
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/reports/receivings/receivings_report',$data);
        $this->load->view('templates/footer');
    }
}