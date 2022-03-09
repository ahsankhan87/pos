<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class No_access extends CI_Controller {

	public function index()
	{
		$data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Access denied';
        $data['main'] = 'Access denied';
            
        $this->load->view('templates/header',$data);
        $this->load->view('v_no_access',$data);
        $this->load->view('templates/footer');
	}
}
