<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_ledgers extends MY_Controller{
    
    public function __construct()
    {
        parent::__construct();
        
    }
    
    public function index()
    {
        
        $data['title'] = 'List of ledgers';
        $data['main'] = 'List of ledgers';
        
        
        //$data['cities'] = $this->M_city->get_city();
        $data['ledgers']= $this->M_ledgers->getLedgerWithOPBalance($_SESSION['company_id']);
        
        $this->load->view('templates/header',$data);
        $this->load->view('accounts/ledger/v_ledger',$data);
        $this->load->view('templates/footer');
        
    }
    
    public function ledgerDetail($ledger_id = false)
    {
        //selecting ledger id
        (empty($ledger_id) ? $ledger_id=$this->input->post('ledger_id') : $ledger_id);
        
        $data['title'] = 'List of ledgers';
        $data['main'] = 'List of ledgers';
        
        $data['LedgerDDL'] = $this->M_ledgers->getLedgerDropDown();
        $data['ledgers']= $this->M_ledgers->get_ledgers($ledger_id);
        $data['entries']= $this->M_ledgers->entriesByLedger($ledger_id,FY_START_DATE,FY_END_DATE);
        
        
        $this->load->view('templates/header',$data);
        $this->load->view('accounts/ledger/ledgerDetail',$data);
        $this->load->view('templates/footer');
        
    }
    function create()
    {
        if($this->input->post('name'))
        {
            $this->M_ledgers->addledgers();
            $this->session->set_flashdata('message','ledger Created');
            redirect('accounts/C_ledgers/index','refresh');
        }
        else
        {
            $data['title'] = 'Create ledger';
            $data['main'] = 'Create New ledger';
            
            $data['grpDDL'] = $this->M_groups->getGrpDropDown();
               
            $this->load->view('templates/header',$data);
            $this->load->view('accounts/ledger/create',$data);
            $this->load->view('templates/footer');
        }
    }
    
     public function edit($id=NULL)
    {
        if($this->input->post('name'))
        {
            $this->M_ledgers->editledgers();
            $this->session->set_flashdata('message','ledger  Updated');
            redirect('accounts/C_ledgers/index','refresh');
        }
        else
        {
            $data['title'] = 'Update ledger';
            $data['main'] = 'Update ledger';
            
            $data['grpDDL'] = $this->M_groups->getGrpDropDown();
            $data['ledgers']= $this->M_ledgers->get_ledgers($id);
        
            $this->load->view('templates/header',$data);
            $this->load->view('accounts/ledger/edit',$data);
            $this->load->view('templates/footer');
        }
    }
    
    function delete($id)
    {
        $this->M_ledgers->deleteledger($id);
        $this->session->set_flashdata('message','ledger  Deleted / inactive');
        redirect('accounts/C_ledgers/index','refresh');
    }
}