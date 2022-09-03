<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_groups extends MY_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    public function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','10240M');

        $data['title'] = lang('coa');
        $data['main'] = lang('coa');
        $data['main_small'] = lang('coa_small');
        
        //$data['groups']= $this->M_groups->get_groups(false,$_SESSION['company_id']);
        $data['groups']= $this->M_groups->get_GroupsByParent();
        
        $this->load->view('templates/header',$data);
        $this->load->view('accounts/groups/v_groups',$data);
        $this->load->view('templates/footer');
        
    }
    
    public function accountDetail($account_code = false)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        //selecting ledger id
        (empty($account_code) ? $account_code=$this->input->post('account_code') : $account_code);
        
        $data['title'] = 'Account Detail';
        $data['main'] = 'Account Detail';
        
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : FY_START_DATE);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : FY_END_DATE);
        
        $data['main_small'] = '<br />'.$data['from_date'].' To '.$data['to_date'];
        
        $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);
        $data['accounts']= $this->M_groups->get_groups($account_code,$_SESSION['company_id']);
        $data['entries']= $this->M_groups->entriesByAccount($account_code,$data['from_date'],$data['to_date']);
        
        $this->load->view('templates/header',$data);
        $this->load->view('accounts/groups/accountDetail',$data);
        $this->load->view('templates/footer');
        
    }
    
    function get_detailAccountsJSON()
    {
        print_r(json_encode($this->M_groups->get_detail_accounts(FALSE,$_SESSION['company_id'])));
    }
    
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('title_ur', 'Title UR', 'required');
            $this->form_validation->set_rules('parent_code', 'Parent Code', 'required');
            //$this->form_validation->set_rules('account_code', 'Account Code', 'required');
            $this->form_validation->set_rules('type', 'type', 'required');
            $this->form_validation->set_rules('level', 'Level', 'required');
            $this->form_validation->set_rules('account_type_id', 'Account Type', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
                //GET NEW ACCOUNT CODE
                //SELECT MAX OF PREV ACCOUNT CODE AND PLUS 1
                $parent_code = $this->input->post('parent_code',true);
                $max_acc_code = $this->M_groups->GetMaxAccCode($parent_code,$_SESSION['company_id']);
                //
                
                
                $dr_amount = $this->input->post('type',true);
                $data = array(
                'company_id'=> $_SESSION['company_id'],
                'name' => $this->input->post('name',true),
                'title' => $this->input->post('title',true),
                'title_ur' => $this->input->post('title_ur',true),
                'parent_code' => $this->input->post('parent_code',true),
                'account_code' => $max_acc_code,
                'type' => $this->input->post('type',true),
                'op_balance_dr' => $this->input->post('op_balance_dr',true),
                'op_balance_cr' => $this->input->post('op_balance_cr',true),
                'level' => $this->input->post('level',true),
                'account_type_id' => $this->input->post('account_type_id',true),
                'date_created' => date('Y-m-d H:i:s')
                );
                if($this->db->insert('acc_groups', $data)) {
                    
                    //for logging
                    $msg = $this->input->post('title',true);
                    $this->M_logs->add_log($msg,"group","Added","Accounts");
                    // end logging
                    
                    $this->session->set_flashdata('message','Group created');
                
                }else{
                    $this->session->set_flashdata('error','Group not created');
                
                }
                redirect('accounts/C_groups/index','refresh');
            }
            return true;
        }
        else
        {
            $data['title'] = lang('create').' '.lang('account');
            $data['main'] = lang('create').' '.lang('account');
            
            $data['grpDDL'] = $this->M_groups->getAllGroupsDDL($_SESSION['company_id'],$data['langs']);
            $data['accTypesDDL'] = $this->M_groups->getAccTypesDropDown();
               
            $this->load->view('templates/header',$data);
            $this->load->view('accounts/groups/create',$data);
            $this->load->view('templates/footer');
        }
    }
    
     public function edit($id=NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        if($this->session->userdata('role') != 'admin')
        {
            redirect('No_access','refresh');    
        }

        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('title_ur', 'Title UR', 'required');
            $this->form_validation->set_rules('parent_code', 'Parent Code', 'required');
            //$this->form_validation->set_rules('account_code', 'Account Code', 'required');
            $this->form_validation->set_rules('type', 'type', 'required');
            $this->form_validation->set_rules('level', 'Level', 'required');
            $this->form_validation->set_rules('account_type_id', 'Account Type', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
               
                $data = array(
                'company_id'=> $_SESSION['company_id'],
                'name' => $this->input->post('name',true),
                'title' => $this->input->post('title',true),
                'title_ur' => $this->input->post('title_ur',true),
                'parent_code' => $this->input->post('parent_code',true),
                'account_code' => $this->input->post('account_code',true),
                'op_balance_dr' => $this->input->post('op_balance_dr',true),
                'op_balance_cr' => $this->input->post('op_balance_cr',true),
                'type' => $this->input->post('type',true),
                'level' => $this->input->post('level',true),
                'account_type_id' => $this->input->post('account_type_id',true),
                
                );
                if($this->db->update('acc_groups', $data, array('id'=>$this->input->post('id')))) {
                    //for logging
                    $msg = $this->input->post('title',true);
                    $this->M_logs->add_log($msg,"group","updated","Accounts");
                    // end logging
                    $this->session->set_flashdata('message','Group updated');
                
                }else{
                    $this->session->set_flashdata('error','Group not updated');
                
                }
                redirect('accounts/C_groups/index','refresh');
        
            }
            //$this->M_groups->editGroups();
            //$this->session->set_flashdata('message','Group  Updated');
            //redirect('accounts/C_groups/index','refresh');
            return true;
        }
        else
        {
            $data['title'] = lang('edit').' '.lang('account');
            $data['main'] = lang('edit').' '.lang('account');
            
            $data['grpDDL'] = $this->M_groups->getAllGroupsDDL($_SESSION['company_id'],$data['langs']);
            $data['groups']= $this->M_groups->get_groupsByID($id,$_SESSION['company_id']);
            $data['accTypesDDL'] = $this->M_groups->getAccTypesDropDown();
            
            $this->load->view('templates/header',$data);
            $this->load->view('accounts/groups/edit',$data);
            $this->load->view('templates/footer');
        }
    }
    
    function delete($account_code)
    {
        if($this->session->userdata('role') != 'admin')
        {
            redirect('No_access','refresh');    
        }

        $chk_entry = $this->M_groups->account_has_entry($account_code);
        
        if(!$chk_entry)
        {
            $this->M_groups->deleteGroup($account_code);
            $this->session->set_flashdata('message',lang('account').' '.lang('deleted'));
                    
                    //for logging
                    $msg = 'account code '.$account_code;
                    $this->M_logs->add_log($msg,"group","deleted","Accounts");
                    // end logging
                    
        }else
        {
            $this->session->set_flashdata('error','Account not deleted because it has entries');
        }
        
        redirect('accounts/C_groups/index','refresh');
        
    }
}