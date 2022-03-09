<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_logs extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    } 

    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'View All Logs';
        $data['main'] = 'View All Logs';
        
        $start_date = date("Y-m-d", strtotime("last year"));
        $to_date = date("Y-m-d");
        
        $data['main_small'] = "(From:".date('d-m-Y',strtotime($start_date)) ." To:" .date('d-m-Y',strtotime($to_date)).")";
        
        //$data['cities'] = $this->M_city->get_city();
        //$data['logs']= $this->M_logs->get_logs($start_date,$to_date);
        
        $this->load->view('templates/header',$data);
        $this->load->view('logs/v_logs',$data);
        $this->load->view('templates/footer');
    }
    
    function get_logs_JSON()
    {
        $start_date = date("Y-m-d", strtotime("last year"));
        $to_date = date("Y-m-d");
        
        print_r(json_encode($this->M_logs->get_logs($start_date,$to_date)));
    }
}