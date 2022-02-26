<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_login extends CI_Controller{
    
    function __construct()
    {
        parent:: __construct();
        //session_start();
        
    }
    
    function index()
    {
        $data['title'] = "Login ";
        $data['main'] = 'Login';
        
        $data['currencyDropDown'] = $this->M_currencies->getcurrencyDropDown();
             
        $this->load->view('v_login',$data);
        //$this->load->view('templates/footer');
    }
    
    function logout()
    {
        //for logging
        $msg = $_SESSION['username'];
        $this->M_logs->add_log($msg,"User","logged out","Admin");
        // end logging 
        
        unset($_SESSION['company_id']);
        unset($_SESSION['username']);
        unset($_SESSION['company_name']);
        //unset($_SESSION['time_zone']);
        unset($_SESSION['emp_id']);
        unset($_SESSION['emp_name']);
        unset($_SESSION['multi_currency']);
        unset($_SESSION['home_currency_code']);
        unset($_SESSION['home_currency_symbol']);
        unset($_SESSION['role']);
        
        //session_destroy();
        $this->cart->destroy();//Destroy the cart if open.
       
       
                        
        $this->session->set_flashdata('error', 'You have been logged out.!');
        redirect('C_login','refresh');
    }
    
    //verify username and password
    public function verify()
    {
        $data['title'] = "Login ";
        //$data['nav_list'] = $this->M_category->get_category();
        $data['main'] = 'Login';
        
        if($this->input->post('username'))
        {
            $username = $this->input->post('username');
            $pass = md5($this->input->post('password',true));
            $this->M_login->verify($username,$pass);
            
            
       }
       //$this->load->view('admin/templates/header',$data);
        $this->load->view('v_login',$data);
        //$this->load->view('admin/templates/footer');
    }
}