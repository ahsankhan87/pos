<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_entries extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }

    public function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));

        $data['title'] = lang('entriesListToday');
        $data['main'] = lang('entriesListToday');

        // 
        //        $data['entry']= $this->M_entries->get_entries();
        //        
        //        $config['base_url'] = site_url('accounts/C_entries/index');
        //        $config['total_rows'] = count($data['entry']);
        //        $config['per_page'] = 15;
        //        $config['uri_segment'] = 4;
        //        $offset = $this->uri->segment(4);
        //        $this->pagination->initialize($config);
        //        
        //$data['cities'] = $this->M_city->get_city();
        $data['TodayEntries'] = $this->M_entries->get_TodayEntries($_SESSION['company_id'], date("Y-m-d"));


        $this->load->view('templates/header', $data);
        $this->load->view('accounts/entries/v_daybook', $data);
        $this->load->view('templates/footer');
    }

    public function allEntries()
    {
        $data = array('langs' => $this->session->userdata('lang'));

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10240M');

        $data['title'] = lang('entriesList');
        $data['main'] = lang('entriesList');

        //$data['cities'] = $this->M_city->get_city();
        $data['entries'] = $this->M_entries->get_allEntries($_SESSION['company_id'], FY_START_DATE, FY_END_DATE);


        $this->load->view('templates/header', $data);
        $this->load->view('accounts/entries/v_entries', $data);
        $this->load->view('templates/footer');
    }

    public function entriesByNo($entry_no)
    {
        $data = array('langs' => $this->session->userdata('lang'));

        $data['title'] = lang('entriesList');
        $data['main'] = lang('entriesList');

        //$data['cities'] = $this->M_city->get_city();
        $data['entries'] = $this->M_entries->get_EntriesByNo($_SESSION['company_id'], FY_START_DATE, FY_END_DATE, $entry_no);

        $this->load->view('templates/header', $data);
        $this->load->view('accounts/entries/v_entriesByNo', $data);
        $this->load->view('templates/footer');
    }
    public function all_entries_JSON()
    {
        $entries = $this->M_entries->get_entries();
        echo json_encode($entries);
    }

    public function get_entries_date($date)
    {
        $entries = $this->M_entries->get_entriesByDate($date);
        echo json_encode($entries);
    }
    public function get_entry_by_invoiceNo($invoice_no)
    {
        echo json_encode($this->M_entries->get_entry_by_invoiceNo_1($invoice_no, $_SESSION['company_id']));
    }

    function saveJournalEntries($is_edit = false, $invoice_no = null)
    {
        // get posted data
        $data_posted = json_decode(file_get_contents("php://input", true));

        if ($is_edit) {
            $this->delete_by_invoice_no($invoice_no);
        }
        // print_r($data_posted);
        if (count($data_posted) > 0) {
            $this->db->trans_start();

            if ($is_edit) {
                $new_invoice_no = $invoice_no;
            } else {
                //GET PREVIOISE INVOICE NO  
                @$prev_invoice_no = $this->M_entries->getMAXEntryInvoiceNo('JV');
                $number = (int) substr($prev_invoice_no, 2) + 1; // EXTRACT THE LAST NO AND INCREMENT BY 1
                $new_invoice_no = 'JV' . $number;
                //
            }

            $entry_no = ($data_posted->entry_no == null ? null : $data_posted->entry_no);
            $exchange_rate = 0;

            if ($entry_no == null) {
                $data = array(
                    'date' => ($data_posted->tran_date == null ? date('Y-m-d') : $data_posted->tran_date),
                    'company_id' => $_SESSION['company_id'],
                    'invoice_no' => $new_invoice_no,
                    'entry_no' => $entry_no,
                    'dr_total' => $data_posted->dr_total == null ? 0 : $data_posted->dr_total,
                    'cr_total' => $data_posted->cr_total == null ? 0 : $data_posted->cr_total,
                    //'narration' => $data_posted->description == null ? '' : $data_posted->description
                );

                $this->db->insert('acc_entries', $data);
                $entry_id = $this->db->insert_id();
            } else {
                $check_entryNo = $this->M_entries->get_entriesByEntryNo($entry_no);

                if ($check_entryNo) {
                    $db_entry_no = $check_entryNo[0]['entry_no'];
                } else {
                    $db_entry_no = null;
                }

                if ($db_entry_no !== $entry_no) {
                    $data = array(
                        'date' => ($data_posted->tran_date == null ? date('Y-m-d') : $data_posted->tran_date),
                        'company_id' => $_SESSION['company_id'],
                        'invoice_no' => $new_invoice_no,
                        'entry_no' => $entry_no,
                        'dr_total' => $data_posted->dr_total == null ? 0 : $data_posted->dr_total,
                        'cr_total' => $data_posted->cr_total == null ? 0 : $data_posted->cr_total,
                        //'narration' => $data_posted->description == null ? '' : $data_posted->description
                    );

                    $this->db->insert('acc_entries', $data);
                    $entry_id = $this->db->insert_id();
                } else {
                    $entry_id = $check_entryNo[0]['id'];
                }
            }

            //extract JSON array items from posted data.
            foreach ($data_posted->items as $posted_values) :

                $dr_amount = $posted_values->dr_amount == null ? 0 : $posted_values->dr_amount;
                $cr_amount = $posted_values->cr_amount == null ? 0 : $posted_values->cr_amount;
                $isCust = $posted_values->isCust;
                $isSupp = $posted_values->isSupp;
                $isBank = $posted_values->isBank;
                $ref_id = $posted_values->ref_id;
                $account = $posted_values->account;
                $narration = $posted_values->narration == null ? '' : $posted_values->narration;
                $tran_date = ($data_posted->tran_date == null ? date('Y-m-d') : $data_posted->tran_date);

                $data = array(
                    'entry_id' => $entry_id,
                    'employee_id' => $_SESSION['user_id'],
                    'entry_no' => $entry_no,
                    //'name' => $name,
                    'account_code' => ($dr_amount > 0 ? $account : $account),
                    'date' => $tran_date,
                    //'amount' => $dr_amount,
                    'dueTo_acc_code' => ($dr_amount > 0 ? $account : $account),
                    'ref_account_id' => $ref_id,
                    'debit' => $dr_amount,
                    'credit' => $cr_amount,
                    'invoice_no' => $new_invoice_no,
                    'narration' => $narration,
                    'company_id' => $_SESSION['company_id'],
                    'is_cust' => $isCust,
                    'is_bank' => $isBank,
                    'is_supp' => $isSupp,

                );
                $this->db->insert('acc_entry_items', $data);

                if ($isCust == 1 && $ref_id > 0) {
                    //POST IN cusmoter payment table
                    //$this->M_customers->addCustomerPaymentEntry($account,$account,$dr_amount,$cr_amount,$ref_id,$narration,$new_invoice_no,$tran_date,0,$entry_id);

                    $data = array(
                        'customer_id' => $ref_id,
                        'account_code' => $account,
                        'dueTo_acc_code' => $account,
                        'date' => ($tran_date == null ? date('Y-m-d') : $tran_date),
                        'debit' => $dr_amount,
                        'credit' => $cr_amount,
                        'invoice_no' => $new_invoice_no,
                        'entry_id' => $entry_id,
                        'narration' => $narration,
                        'exchange_rate' => ($exchange_rate == null ? 0 : $exchange_rate),
                        'company_id' => $_SESSION['company_id']
                    );
                    $this->db->insert('pos_customer_payments', $data);

                    ///
                }
                if ($isSupp == 1 && $ref_id > 0) {
                    //POST IN cusmoter payment table
                    //$this->M_suppliers->addsupplierPaymentEntry($account,$account,$dr_amount,$cr_amount,$ref_id,$narration,$new_invoice_no,$tran_date,0,$entry_id);

                    $data = array(
                        'supplier_id' => $ref_id,
                        'account_code' => $account,
                        'dueTo_acc_code' => $account,
                        'date' => ($tran_date == null ? date('Y-m-d') : $tran_date),
                        'debit' => $dr_amount,
                        'credit' => $cr_amount,
                        'invoice_no' => $new_invoice_no,
                        'entry_id' => $entry_id,
                        'narration' => $narration,
                        'exchange_rate' => ($exchange_rate == null ? 0 : $exchange_rate),
                        'company_id' => $_SESSION['company_id'],

                    );
                    $this->db->insert('pos_supplier_payments', $data);

                    ///
                }
                if ($isBank == 1 && $ref_id > 0) {
                    //POST IN cusmoter payment table
                    //$this->M_banking->addBankPaymentEntry($account,$account,$dr_amount,$cr_amount,$ref_id,$narration,$new_invoice_no,$tran_date,$entry_id);
                    //addBankPaymentEntry($account,$account,$dr_amount,$cr_amount,$ref_id='',$narration='',$new_invoice_no='',$tran_date=null,$entry_id=0)
                    $data = array(
                        'bank_id' => $ref_id,
                        'account_code' => $account,
                        'dueTo_acc_code' => $account,
                        'date' => ($tran_date == null ? date('Y-m-d') : $tran_date),
                        'debit' => $dr_amount,
                        'credit' => $cr_amount,
                        'invoice_no' => $new_invoice_no,
                        'entry_id' => $entry_id,
                        'narration' => $narration,
                        'company_id' => $_SESSION['company_id']
                    );
                    $this->db->insert('pos_bank_payments', $data);
                    ///
                }

            endforeach;

            $this->db->trans_complete();

            //for logging
            $msg = 'invoice no ' . $new_invoice_no;
            $this->M_logs->add_log($msg, "Journal Entry", "added", "Accounts");
            // end logging

        } //if close

    }

    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));

        if ($this->input->post('dr_ledger') || $this->input->post('amount')) {
            //GET PREVIOISE INVOICE NO  
            @$prev_invoice_no = $this->M_entries->getMAXEntryInvoiceNo('JV');
            $number = (int) substr($prev_invoice_no, 2) + 1; // EXTRACT THE LAST NO AND INCREMENT BY 1
            $new_invoice_no = 'JV' . $number;
            //
            $tran_date = $this->input->post('tran_date', true);
            $name = $this->input->post('name', true);
            $amount = $this->input->post('amount', true);
            $narration = $this->input->post('narration', true);

            $dr_ledger = $this->input->post('dr_ledger', true);
            $cr_ledger = $this->input->post('cr_ledger', true);
            $entry_no = $this->input->post('entry_no', true);

            $this->M_entries->addEntries($dr_ledger, $cr_ledger, $amount, $amount, $narration, $new_invoice_no, $tran_date, $entry_no);
            //$this->session->set_flashdata('message','Entries Added');
            //redirect('accounts/C_entries/create','refresh');
            echo $new_invoice_no;
        } else {
            $data['title'] = lang('add_entry');;
            $data['main'] = lang('add_entry');;

            $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'], $data['langs']);
            $data['customersDDL'] = $this->M_customers->getCustomerDropDown();

            $this->load->view('templates/header', $data);
            $this->load->view('accounts/entries/create1', $data);
            $this->load->view('templates/footer');
        }
    }

    function edit($invoice_no = null)
    {
        $data = array('langs' => $this->session->userdata('lang'));

        if ($this->input->post('dr_ledger') || $this->input->post('amount')) {
            //GET PREVIOISE INVOICE NO  
            //    @$prev_invoice_no = $this->M_entries->getMAXEntryInvoiceNo('JV');
            //    $number = (int) substr($prev_invoice_no,2)+1; // EXTRACT THE LAST NO AND INCREMENT BY 1
            //    $new_invoice_no = 'JV'.$number;
            //
            $this->delete_by_invoice_no($invoice_no);

            $tran_date = $this->input->post('tran_date', true);
            $name = $this->input->post('name', true);
            $amount = $this->input->post('amount', true);
            $narration = $this->input->post('narration', true);

            $dr_ledger = $this->input->post('dr_ledger', true);
            $cr_ledger = $this->input->post('cr_ledger', true);
            $entry_no = $this->input->post('entry_no', true);

            $this->M_entries->addEntries($dr_ledger, $cr_ledger, $amount, $amount, $narration, $invoice_no, $tran_date, $entry_no);
            //$this->session->set_flashdata('message','Entries Added');
            //redirect('accounts/C_entries/create','refresh');
            echo $invoice_no;
        } else {
            $data['title'] = lang('edit');
            $data['main'] = lang('edit');
            $data['invoice_no'] = $invoice_no;

            $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'], $data['langs']);
            $data['customersDDL'] = $this->M_customers->getCustomerDropDown();
            //$data['entry_items'] = $this->M_entries->get_entry_by_invoiceNo($invoice_no);

            $this->load->view('templates/header', $data);
            $this->load->view('accounts/entries/edit', $data);
            $this->load->view('templates/footer');
        }
    }

    public function receipt($invoice_no = NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));

        $data['title'] = 'Invoice';
        $data['main'] = '';
        $data['invoice_no'] = $invoice_no;

        $data['receipt'] = $this->M_entries->get_entry_by_invoiceNo($invoice_no, $_SESSION['company_id']);

        $company_id = $_SESSION['company_id'];
        $data['Company'] = $this->M_companies->get_companies($company_id);

        $this->load->view('templates/header', $data);
        $this->load->view('accounts/entries/v_receipt', $data);
        $this->load->view('templates/footer');
    }

    function delete($id, $entry_id)
    {
        $this->db->trans_start();

        $this->M_customers->delete_entry_by_id($entry_id);
        $this->M_suppliers->delete_entry_by_id($entry_id);
        $this->M_banking->delete_entry_by_id($entry_id);

        $this->db->trans_complete();

        $this->M_entries->deleteEntry($id);
        $this->session->set_flashdata('message', 'Journal Entries Deleted');
        redirect('accounts/C_entries/index', 'refresh');
    }

    function delete_by_invoice_no($invoice_no)
    {
        $this->db->trans_start();

        $this->M_customers->delete_entry_by_invoice_no($invoice_no);
        $this->M_suppliers->delete_entry_by_invoice_no($invoice_no);
        $this->M_banking->delete_entry_by_invoice_no($invoice_no);
        $this->M_entries->deleteEntry_invoice_no($invoice_no);

        $this->db->trans_complete();
    }
}
