<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_expenses extends MY_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
        
    }
    
    public function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        //$this->output->enable_profiler();
        
        $data['title'] = lang('expenses').' / '.lang('payments');
        $data['main'] = lang('expenses').' / '.lang('payments');
        
        $data['cash_account'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);
        $data['taxesDDL'] = $this->M_taxes->gettaxDropDownWithRate();
            
        $this->load->view('templates/header',$data);
        $this->load->view('pos/expenses/v_expenses',$data);
        $this->load->view('templates/footer');
    }
    
    public function get_allExpenses()
    {
        $data['expenses'] = $this->M_groups->get_ExpensesAcc('operative_expenses');
        
        echo json_encode($data['expenses']);
    }
    
    public function get_expenses_JSON()
    {
        echo json_encode($this->M_payments->get_payments());
    }

    public function saveExpenses()
    {
        // get posted data from angularjs purchases 
        $data_posted = json_decode(file_get_contents("php://input",true)); 
        
            //GET PREVIOISE INVOICE NO  
           @$prev_invoice_no = $this->M_payments->getMAXPaymentInvoiceNo();
           //$number = (int) substr($prev_invoice_no,1)+1; // EXTRACT THE LAST NO AND INCREMENT BY 1
           $number = (int) $prev_invoice_no+1; // EXTRACT THE LAST NO AND INCREMENT BY 1
           $new_invoice_no = 'P'.$number;
           
        //extract JSON array items from posted data.
        if(count($data_posted) > 0)
        {
            $this->db->trans_start();
            
            $cr_ledger = $data_posted->cash_account;
            $isCust=$data_posted->isCust;
            $isSupp=$data_posted->isSupp;
            $isBank=$data_posted->isBank;
            $ref_id=$data_posted->ref_id;
            
            //$narration = $data_posted->narration;
            $exp_date = $data_posted->exp_date;
            
            foreach($data_posted->items as $posted_values):
               
               $dr_ledger = $posted_values->account_code;
               $desc = ($posted_values->description == '' ? ' ' : $posted_values->description);
               $tax_amount = ($posted_values->amount*$posted_values->tax_id/100);
               $dr = $posted_values->amount;
               $cr = $posted_values->amount;
                
               $this->M_entries->addEntries($dr_ledger,$cr_ledger,$dr,$cr,$desc,$new_invoice_no,$exp_date,'',$ref_id);
               $entry_id = $this->db->insert_id();
               
               if($tax_amount > 0)
               {
                $dr_tax_ledger = $data_posted->tax_account;
                $this->M_entries->addEntries($dr_tax_ledger,$cr_ledger,$tax_amount,$tax_amount,$desc,$new_invoice_no,$exp_date,'',$ref_id);
                
               }
               
               $data = array(
                    'company_id'=> $_SESSION['company_id'],
                    'invoice_no' => $new_invoice_no,
                    //'name' => $data_posted->name,
                    'amount'=>$posted_values->amount,
                    'employee_id'=>$_SESSION['user_id'],
                    'payment_date' => $exp_date,
                    'account_code'=>$dr_ledger,
                    'description'=>$desc,
                    'tax_rate'=>$posted_values->tax_id,
                    'tax_amount'=>$tax_amount,
                    'supplier_invoice_no'=>$data_posted->supplier_invoice_no,
                    'entry_id' => $entry_id,
                    );
                    
               $this->db->insert('acc_payments', $data);
                 
               

               if(isset($isCust) && !empty($ref_id))
               {
                //POST IN cusmoter payment table
               //$this->M_customers->addCustomerPaymentEntry($account,$account,$dr_amount,$cr_amount,$ref_id,$narration,$new_invoice_no,$exp_date,0,$entry_id);
               
                        $data = array(
                        'customer_id' => $ref_id,
                        'account_code' => $cr_ledger,
                        'dueTo_acc_code' => $cr_ledger,
                        'date' => ($exp_date == null ? date('Y-m-d') : $exp_date),
                        'debit'=>0,
                        'credit'=>$cr,
                        'invoice_no' => $new_invoice_no,
                        'entry_id' => $entry_id,
                        'narration' => $desc,
                        'exchange_rate'=>($exchange_rate == null ? 0 : $exchange_rate),
                        'company_id'=> $_SESSION['company_id']
                        );
                $this->db->insert('pos_customer_payments', $data); 
                
               ///
               }
               if(isset($isSupp) && !empty($ref_id))
               {
                //POST IN cusmoter payment table
               //$this->M_suppliers->addsupplierPaymentEntry($account,$account,$dr_amount,$cr_amount,$ref_id,$narration,$new_invoice_no,$exp_date,0,$entry_id);
                       
                        $data = array(
                        'supplier_id' => $ref_id,
                        'account_code' => $cr_ledger,
                        'dueTo_acc_code' => $cr_ledger,
                        'date' => ($exp_date == null ? date('Y-m-d') : $exp_date),
                        'debit'=>0,
                        'credit'=>$cr,
                        'invoice_no' => $new_invoice_no,
                        'entry_id' => $entry_id,
                        'narration' => $desc,
                        'exchange_rate'=>($exchange_rate == null ? 0 : $exchange_rate),
                        'company_id'=>$_SESSION['company_id'],
                
                        );
                $this->db->insert('pos_supplier_payments', $data);  
               
               ///
               }
               if(isset($isBank) && !empty($ref_id))
               {
                //POST IN cusmoter payment table
                //$this->M_banking->addBankPaymentEntry($account,$account,$dr_amount,$cr_amount,$ref_id,$narration,$new_invoice_no,$exp_date,$entry_id);
                //addBankPaymentEntry($account,$account,$dr_amount,$cr_amount,$ref_id='',$narration='',$new_invoice_no='',$exp_date=null,$entry_id=0)
                    $data = array(
                            'bank_id' => $ref_id,
                            'account_code' => $cr_ledger,
                            'dueTo_acc_code' => $cr_ledger,
                            'date' => ($exp_date == null ? date('Y-m-d') : $exp_date),
                            'debit'=>0,
                            'credit'=>$cr,
                            'invoice_no' => $new_invoice_no,
                            'entry_id' => $entry_id,
                            'narration' => $desc,
                            'company_id'=> $_SESSION['company_id']
                            );
                    $this->db->insert('pos_bank_payments', $data); 
               ///
               }
            endforeach;
            
            $this->db->trans_complete();
            
              //for logging
                    $msg = 'Paid';
                    $this->M_logs->add_log($msg,"Expense","Trans","Accounts");
                    // end logging
                    
              echo '{"invoice_no":"'.$new_invoice_no.'"}';
        }
        else
        {
            echo 'No Data';
        }
        
    }
    
    public function receipt($invoice_no=NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('invoice');
        $data['main'] = '';
        $data['invoice_no'] = $invoice_no;
        
        $data['payment'] = $this->M_payments->get_paymentByInvoice(false,$invoice_no,$_SESSION['company_id']);
       
        $company_id = $_SESSION['company_id'];
        $data['Company'] = $this->M_companies->get_companies($company_id);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/expenses/v_receipt',$data);
        $this->load->view('templates/footer');
        
    }
    
    public function allPayments()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('all'). ' ' . lang('payment');
        $data['main'] = lang('all'). ' ' . lang('payment');
        
        $data['Payments'] = $this->M_payments->get_payments();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/expenses/v_allpayments',$data);
        $this->load->view('templates/footer');
    }
    
    public function delete($invoice_no)
    {
        $this->db->trans_start();
        $this->M_payments->delete($invoice_no);
        $this->db->trans_complete();
        
        $this->session->set_flashdata('message','Entry Deleted');
        redirect('trans/C_expenses/allPayments','refresh');
    }
}