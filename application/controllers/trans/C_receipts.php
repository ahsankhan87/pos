<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_receipts extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }

    public function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        //$this->output->enable_profiler();

        $data['title'] = lang('receipts') . ' / ' . lang('payments');
        $data['main'] = lang('receipts') . ' / ' . lang('payments');

        $data['cash_account'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'], $data['langs']);
        $data['taxesDDL'] = $this->M_taxes->gettaxDropDownWithRate();

        $this->load->view('templates/header', $data);
        $this->load->view('pos/receipts/v_receipts', $data);
        $this->load->view('templates/footer');
    }

    public function get_allreceipts()
    {
        $data['receipts'] = $this->M_groups->get_receiptsAcc('operative_receipts');

        echo json_encode($data['receipts']);
    }

    public function get_receipts_JSON()
    {
        echo json_encode($this->M_payments->get_payments());
    }

    public function savereceipts()
    {
        // get posted data from angularjs purchases 
        $data_posted = json_decode(file_get_contents("php://input", true));

        //GET PREVIOISE INVOICE NO  
        @$prev_invoice_no = $this->M_payments->getMAXPaymentInvoiceNo();
        //$number = (int) substr($prev_invoice_no,1)+1; // EXTRACT THE LAST NO AND INCREMENT BY 1
        $number = (int) $prev_invoice_no + 1; // EXTRACT THE LAST NO AND INCREMENT BY 1
        $new_invoice_no = 'P' . $number;

        // var_dump($data_posted);
        // die;
        //extract JSON array items from posted data.
        if (count((array)$data_posted) > 0) {
            $this->db->trans_start();

            $dr_account = $data_posted->cash_account;
            $cr_account = $data_posted->credit_account;
            $grand_total = 0;

            $isCust = $data_posted->isCust;
            $isSupp = $data_posted->isSupp;
            $isBank = $data_posted->isBank;
            $ref_id = $data_posted->ref_id;

            //$narration = $data_posted->narration;
            $trans_date = $data_posted->exp_date;
            foreach ($data_posted->items as $posted_values) :
                $grand_total += $posted_values->amount;
            endforeach;

            $this->M_entries->addEntries($dr_account, $cr_account, $grand_total, $grand_total, '', $new_invoice_no, $trans_date, '', '');
            $entry_id = $this->db->insert_id();

            foreach ($data_posted->items as $posted_values) :

                $desc = ($posted_values->description == '' ? ' ' : $posted_values->description);
                $amount = $posted_values->amount;
                $customer_id = $posted_values->id;
                //POST IN cusmoter payment table
                //$this->M_customers->addCustomerPaymentEntry($account,$account,$dr_amount,$cr_amount,$ref_id,$narration,$new_invoice_no,$exp_date,0,$entry_id);

                $data = array(
                    'customer_id' => $customer_id,
                    'account_code' => $cr_account,
                    'dueTo_acc_code' => $dr_account,
                    'date' => ($trans_date == null ? date('Y-m-d') : $trans_date),
                    'debit' => 0,
                    'credit' => $amount,
                    'invoice_no' => $new_invoice_no,
                    'entry_id' => $entry_id,
                    'narration' => $desc,
                    'exchange_rate' => 1,
                    'company_id' => $_SESSION['company_id']
                );
                $this->db->insert('pos_customer_payments', $data);

            ///

            endforeach;

            $this->db->trans_complete();

            //for logging
            $msg = 'Paid';
            $this->M_logs->add_log($msg, "receipt", "Trans", "Accounts");
            // end logging

            echo '{"invoice_no":"' . $new_invoice_no . '"}';
        } else {
            echo 'No Data';
        }
    }

    public function receipt($invoice_no = NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));

        $data['title'] = lang('invoice');
        $data['main'] = '';
        $data['invoice_no'] = $invoice_no;

        $data['payment'] = $this->M_payments->get_paymentByInvoice(false, $invoice_no, $_SESSION['company_id']);

        $company_id = $_SESSION['company_id'];
        $data['Company'] = $this->M_companies->get_companies($company_id);

        $this->load->view('templates/header', $data);
        $this->load->view('pos/receipts/v_receipt', $data);
        $this->load->view('templates/footer');
    }

    public function allPayments()
    {
        $data = array('langs' => $this->session->userdata('lang'));

        $data['title'] = lang('all') . ' ' . lang('payment');
        $data['main'] = lang('all') . ' ' . lang('payment');

        $data['Payments'] = $this->M_payments->get_payments();

        $this->load->view('templates/header', $data);
        $this->load->view('pos/receipts/v_allpayments', $data);
        $this->load->view('templates/footer');
    }

    public function delete($invoice_no)
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('No_access', 'refresh');
        }

        $this->db->trans_start();
        $this->M_payments->delete($invoice_no);
        $this->db->trans_complete();

        $this->session->set_flashdata('message', 'Entry Deleted');
        redirect('trans/C_receipts/allPayments', 'refresh');
    }
}
