<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_employee extends CI_Controller{
    
    function __construct()
    {
        parent::__construct();
       
    } 
    function index()
    {
        
    }
    
    function empDetail()
    {
        $data['title'] = 'Employees Detail';
        $data['main'] = 'Employees Detail';
        
        $data['emp_detail']= $this->M_employees->get_employees($_SESSION['emp_id']);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/employees/v_empDetail',$data);
        $this->load->view('templates/footer');
    }
}