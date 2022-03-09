<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_banking extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    } 

    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('listof').' '.lang('banks');
        $data['main'] = lang('listof').' '.lang('banks');
        
        //$data['cities'] = $this->M_city->get_city();
        $data['banking']= $this->M_banking->get_activeBanking();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/banking/v_banking',$data);
        $this->load->view('templates/footer');
    }
    
    function get_banks_JSON($acc_code)
    {
        print_r(json_encode($this->M_banking->get_activeBankByAccCode($acc_code)));
    }
    
    function withDrawCash()
    {
        $bank_id = $this->input->post('bank_id',true);
        $cash_acc_code = $this->input->post('cash_acc_code',true);
        $bank_acc_code = $this->input->post('bank_acc_code',true);
        $is_bank=1;
        
        //GET ALL ACCOUNT CODE WHICH IS TO BE POSTED AMOUNT
        if($bank_id && $this->input->post('amount') && $cash_acc_code && $bank_acc_code)
        {
           $this->db->trans_start();
           
           //GET PREVIOISE INVOICE NO  
           @$prev_invoice_no = $this->M_banking->getMAXBankInvoiceNo();
           $number = (int) substr($prev_invoice_no,1)+1; // EXTRACT THE LAST NO AND INCREMENT BY 1
           $new_invoice_no = 'W'.$number;
           
           $dr_amount = $this->input->post('amount',true);
           $cr_amount = $this->input->post('amount',true);
           $narration = $this->input->post('narration',true);
           
           //PAY CASH TO SUPPLIER AND REDUCE PAYABLES
           $cr_account = $bank_acc_code;//bank ledger id
           $dr_account = $cash_acc_code;
           $this->M_entries->addEntries($dr_account,$cr_account,$dr_amount,$cr_amount,$narration,$new_invoice_no,null,null,$bank_id,0,0,$is_bank);
           
           $this->M_banking->addBankPaymentEntry($cr_account,$dr_account,0,$cr_amount,$bank_id,$narration,$new_invoice_no);
           
           $this->db->trans_complete();   
           
           $this->session->set_flashdata('message','Payment Received Successfully');
           redirect('pos/C_banking/bankDetail/'.$bank_id,'refresh');
        }
        else
        {
            $this->session->set_flashdata('error','Payment Not Received. It seem that you did not assign posting account type to bank.');
            redirect('pos/C_banking/bankDetail/'.$bank_id,'refresh');
        }
         
    }
    
  
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            
            //form Validation
            $this->form_validation->set_rules('cash_acc_code', 'Cash Account Code', 'required');
            $this->form_validation->set_rules('bank_acc_code', 'Bank Account Code', 'required');
            $this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
            //$this->form_validation->set_rules('acc_holder_name', 'Acc Holder Name', 'required');
            //$this->form_validation->set_rules('bank_account_no', 'bank_account_no', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
           
           $this->db->trans_start();
            
            //after form Validation run
            if($this->form_validation->run())
            {
                $data = array(
                'company_id'=> $_SESSION['company_id'],
                'bank_acc_code' => $this->input->post('bank_acc_code', true),
                'cash_acc_code' => $this->input->post('cash_acc_code', true),
                'bank_account_no' => $this->input->post('bank_account_no', true),
                'bank_name' => $this->input->post('bank_name', true),
                'acc_holder_name' => $this->input->post('acc_holder_name', true),
                'bank_branch' => $this->input->post('bank_branch', true),
                'status' => 1,
                'op_balance_dr' => $this->input->post('op_balance_dr', true),
                'op_balance_cr' => $this->input->post('op_balance_cr', true),
                "exchange_rate" => $this->input->post('exchange_rate', true),
                'currency_id' => $this->input->post('currency_id', true),
                
                );
            
                if($this->db->insert('pos_banking', $data)) {
                    
                    //$bank_id = $this->db->insert_id();
                    $bank_acc_code = $this->input->post('bank_acc_code', true);
                    $exchange_rate = ($this->input->post('exchange_rate', true) == 0 ? 1 : $this->input->post('exchange_rate', true));
                    
                    $op_balance_dr = $this->input->post('op_balance_dr', true)/$exchange_rate;
                    $op_balance_cr = $this->input->post('op_balance_cr', true)/$exchange_rate;
                    
                    $bank_account = $this->M_groups->get_groups($bank_acc_code,$_SESSION['company_id']);
                       $bank_dr_balance = abs($bank_account[0]['op_balance_dr']);
                       $bank_cr_balance = abs($bank_account[0]['op_balance_cr']);
                       
                       $dr_balance = ($bank_dr_balance+$op_balance_dr);
                       $cr_balance = ($bank_cr_balance+$op_balance_cr);
                       
                       $this->M_groups->editGroupOPBalance($bank_acc_code,$dr_balance,$cr_balance);
                       
                    $this->session->set_flashdata('message','Bank Created');
                }else{
                    $data['flash_message'] = false;
                }
                
                $this->db->trans_complete();   
                
                redirect('pos/C_banking/index','refresh');
            
           }
        }
            $data['title'] = 'Add New Bank';
            $data['main'] = 'Add New Bank';
            
            $data['salesPostingTypeDDL'] = $this->M_postingTypes->get_SalesPostingTypesDDL();
            $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);//search for legder account
            $data['currencyDropDown'] = $this->M_currencies->getcurrencyDropDown();
            
               
            $this->load->view('templates/header',$data);
            $this->load->view('pos/banking/create',$data);
            $this->load->view('templates/footer');
        
    }
    //edit category
    public function edit($id=NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form Validation
            $this->form_validation->set_rules('cash_acc_code', 'cash_acc_code', 'required');
            $this->form_validation->set_rules('bank_acc_code', 'bank_acc_code', 'required');
            $this->form_validation->set_rules('bank_name', 'bank_name', 'required');
            //$this->form_validation->set_rules('acc_holder_name', 'acc_holder_name', 'required');
            //$this->form_validation->set_rules('bank_account_no', 'bank_account_no', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            $this->db->trans_start();
           
           //after form Validation run
            if($this->form_validation->run())
            {
                $data = array(
                'company_id'=> $_SESSION['company_id'],
                'bank_acc_code' => $this->input->post('bank_acc_code', true),
                'cash_acc_code' => $this->input->post('cash_acc_code', true),
                'bank_account_no' => $this->input->post('bank_account_no', true),
                'bank_name' => $this->input->post('bank_name', true),
                'acc_holder_name' => $this->input->post('acc_holder_name', true),
                'bank_branch' => $this->input->post('bank_branch', true),
                'op_balance_dr' => $this->input->post('op_balance_dr', true),
                'op_balance_cr' => $this->input->post('op_balance_cr', true),
                "exchange_rate" => $this->input->post('exchange_rate', true),
                'currency_id' => $this->input->post('currency_id', true),
                    
                );
            //$this->db->update('pos_banking', $data, array('id'=>$_POST['id']));
            
                if($this->db->update('pos_banking', $data, array('id'=>$_POST['id']))) {
                    
                    $bank_acc_code = $this->input->post('bank_acc_code', true);
                    $exchange_rate = ($this->input->post('exchange_rate', true) == 0 ? 1 : $this->input->post('exchange_rate', true));
                    
                    $op_balance_dr = $this->input->post('op_balance_dr', true)/$exchange_rate;
                    $op_balance_cr = $this->input->post('op_balance_cr', true)/$exchange_rate;
                    
                    $op_balance_dr_old = $this->input->post('op_balance_dr_old', true)/$exchange_rate;
                    $op_balance_cr_old = $this->input->post('op_balance_cr_old', true)/$exchange_rate;
                    
                    $bank_account = $this->M_groups->get_groups($bank_acc_code,$_SESSION['company_id']);
                       $bank_dr_balance = abs($bank_account[0]['op_balance_dr']);
                       $bank_cr_balance = abs($bank_account[0]['op_balance_cr']);
                       
                       $dr_balance = $bank_dr_balance-$op_balance_dr_old;
                       $cr_balance = $bank_cr_balance-$op_balance_cr_old;
                       
                       $dr_balance = ($dr_balance+$op_balance_dr);
                       $cr_balance = ($cr_balance+$op_balance_cr);
                       
                       $this->M_groups->editGroupOPBalance($bank_acc_code,$dr_balance,$cr_balance);
                       
                    
                    $this->session->set_flashdata('message','bank Updated');
                }else{
                    $data['flash_message'] = false;
                }
             $this->db->trans_complete();   
            //$this->M_banking->updatebank();
            //$this->session->set_flashdata('message','bank Updated');
            redirect('pos/C_banking/index','refresh');
            }
        }
       
            $data['title'] = 'Update Bank';
            $data['main'] = 'Update Bank';
            
           
            $data['bank'] = $this->M_banking->get_banking($id);
            $data['salesPostingTypeDDL'] = $this->M_postingTypes->get_SalesPostingTypesDDL();
            $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);//search for legder account
            $data['currencyDropDown'] = $this->M_currencies->getcurrencyDropDown();
            
            
            $this->load->view('templates/header',$data);
            $this->load->view('pos/banking/edit',$data);
            $this->load->view('templates/footer');
        
    }
    
    function bankDetail($bank_id)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Bank Detail';
        $data['main'] = 'Bank Detail';
       
        $data['bank'] = $this->M_banking->get_banking($bank_id);
        $data['bank_entries']= $this->M_banking->get_bank_Entries($bank_id,FY_START_DATE,FY_END_DATE);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/banking/v_bankDetail',$data);
        $this->load->view('templates/footer');
    }
    function delete($id,$op_balance_dr,$op_balance_cr,$bank_acc_code)
    {
        $this->db->trans_start();
           
        $this->M_banking->deletebank($id,$op_balance_dr,$op_balance_cr,$bank_acc_code);
        
        $this->db->trans_complete();   
            
        $this->session->set_flashdata('message','bank Deleted');
        redirect('pos/C_banking/index','refresh');
    }
    
    function inactivate($id,$op_balance_dr,$op_balance_cr,$bank_acc_code) // it will inactive the page
    {
        $this->db->trans_start();
        $this->M_banking->inactivate($id,$op_balance_dr,$op_balance_cr,$bank_acc_code);
        $this->db->trans_complete();   
        
        $this->session->set_flashdata('message','Bank in-activated');
        redirect('pos/C_banking/index','refresh');
    }
    
    function activate($id) // it will active 
    {
        $this->M_banking->activate($id);
        $this->session->set_flashdata('message','bank Activated');
        redirect('pos/C_banking/index','refresh');
    }
    
    
}