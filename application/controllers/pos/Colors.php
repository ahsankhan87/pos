<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Colors extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    } 
    
    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Manage Colors';
        $data['main'] = 'Manage Colors';
        
        $data['colors'] = $this->M_colors->get_color();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/colors/v_colors',$data);
        $this->load->view('templates/footer');
    }
    
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->post('name'))
        {
            $this->M_colors->add_color();
            $this->session->set_flashdata('message','Colors Added');
            redirect('pos/Colors/index','refresh');
        }
        
        $data['title'] = 'Add New Color';
        $data['main'] = 'Add New Color';
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/colors/create',$data);
        $this->load->view('templates/footer');
    }
    
    function edit($id = NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->post('name'))
        {
            $this->M_colors->update_color();
            $this->session->set_flashdata('message','Color Updated');
            redirect('pos/Colors/index','refresh');
        }
        
        $data['title'] = 'Update Color';
        $data['main'] = 'Update Color';
        
        $data['update_color'] = $this->M_colors->get_color($id);      
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/colors/edit',$data);
        $this->load->view('templates/footer');
    }
    
    function delete($id)
    {
        $this->M_colors->delete_color($id);
        $this->session->set_flashdata('message','Color Deleted');
        redirect('pos/Colors/index','refresh');
    }
} 