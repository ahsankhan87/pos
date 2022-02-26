<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class PostingTypes extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'List of Customer Account Posting';
        $data['main'] = 'List of Customer Account Posting';
        
        $data['salespostingType'] = $this->M_postingTypes->get_salesPostingTypes();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/postingtypes/v_salesPostingTypes',$data);
        $this->load->view('templates/footer');
    }
    
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->post('name'))
        {
            $this->M_postingTypes->add_salespostingType();
            $this->session->set_flashdata('message','postingType Added');
            redirect('pos/PostingTypes/index','refresh');
        }
        
        $data['title'] = 'Add New Customer Account Posting';
        $data['main'] = 'Add New Customer Account Posting';
        
        $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/postingtypes/create',$data);
        $this->load->view('templates/footer');
    }
    
    function edit($id = NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->post('name'))
        {
            $this->M_postingTypes->update_salespostingType();
            $this->session->set_flashdata('message','PostingTypes Updated');
            redirect('pos/PostingTypes/index','refresh');
        }
        
        $data['title'] = 'Update Customer Account Posting';
        $data['main'] = 'Update Customer Account Posting';
        
        $data['salespostingType'] = $this->M_postingTypes->get_salesPostingTypes($id);      
        $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/postingtypes/edit',$data);
        $this->load->view('templates/footer');
    }
    
    function delete($id)
    {
        $this->M_postingTypes->delete_postingType($id);
        $this->session->set_flashdata('message','salespostingType Deleted');
        redirect('pos/PostingTypes/index','refresh');
    }
    
    function purchasePostingTypes()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Manage Supplier Account Posting';
        $data['main'] = 'Manage Supplier Account Posting';
        
        $data['salespostingType'] = $this->M_postingTypes->get_purchasePostingTypes();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/purchasepostingtypes/v_purchasePostingTypes',$data);
        $this->load->view('templates/footer');
    }
    
    function create_purchase()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->post('name'))
        {
            $this->M_postingTypes->add_purchasepostingType();
            $this->session->set_flashdata('message','purchasepostingType Added');
            redirect('pos/PostingTypes/purchasePostingTypes','refresh');
        }
        
        $data['title'] = 'Add New Supplier Account Posting';
        $data['main'] = 'Add New Supplier Account Posting';
        
        $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/purchasepostingtypes/create',$data);
        $this->load->view('templates/footer');
    }
    
    function edit_purchase($id = NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->post('name'))
        {
            $this->M_postingTypes->update_purchasepostingType();
            $this->session->set_flashdata('message','purchasePostingTypes Updated');
            redirect('pos/PostingTypes/purchasePostingTypes','refresh');
        }
        
        $data['title'] = 'Update Supplier Account Posting';
        $data['main'] = 'Update Supplier Account Posting';
        
        $data['purchasepostingType'] = $this->M_postingTypes->get_purchasePostingTypes($id);      
        $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/purchasepostingtypes/edit',$data);
        $this->load->view('templates/footer');
    }
    
    function delete_purchase($id)
    {
        $this->M_postingTypes->delete_purchasepostingType($id);
        $this->session->set_flashdata('message','purchasepostingType Deleted');
        redirect('pos/PostingTypes/purchasePostingTypes','refresh');
    }
}