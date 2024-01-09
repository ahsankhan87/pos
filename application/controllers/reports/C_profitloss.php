<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_profitloss extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }


    public function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10240M');

        //$this->output->enable_profiler(TRUE);
        $data['title'] = lang('income_exp');
        $data['main'] = lang('income_exp');
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : FY_START_DATE);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : FY_END_DATE);

        $data['main_small'] = '<br />' . date('d-m-Y', strtotime($data['from_date'])) . ' To ' . date('d-m-Y', strtotime($data['to_date']));

        $data['proft_loss'] = $this->M_reports->get_parentGroups4pl($_SESSION['company_id']);
        $data['expenses'] = $this->M_reports->get_parentGroups4Expense($_SESSION['company_id']);
        //for logging
        $msg = '';
        $this->M_logs->add_log($msg, "Pofit & Loss Report", "Retrieved", "Accounts");
        // end logging

        $this->load->view('templates/header', $data);
        $this->load->view('reports/pl-2', $data);
        $this->load->view('templates/footer');
    }

    public function run_pl_report()
    {
        $data = array('langs' => $this->session->userdata('lang'));

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10240M');

        //$this->output->enable_profiler(TRUE);
        $data['title'] = 'Retained Earning Account';
        $data['main'] = 'Retained Earning Account';
        $retained_earning_account = $this->input->post('retained_earning_account');

        if ($retained_earning_account) {
            $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : FY_START_DATE);
            $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : FY_END_DATE);

            $data['main_small'] = '<br />' . date('d-m-Y', strtotime($data['from_date'])) . ' To ' . date('d-m-Y', strtotime($data['to_date']));

            $proft_loss = $this->M_reports->get_parentGroups4pl($_SESSION['company_id']);

            foreach ($proft_loss as $key => $list) {

                $pl_report = $this->M_reports->get_profit_loss($_SESSION['company_id'], $list['account_code'], $data['from_date'], $data['to_date']);
                foreach ($pl_report as $key => $values) :

                    $balance = $values['debit'] - $values['credit'];

                    if ($balance > 0) //debit balance
                    {
                        $this->M_entries->addEntries($retained_earning_account, $values['account_code'], $balance, $balance, 'Closing Temporary Accounts');
                    }
                    if ($balance < 0) { // credit balance

                        $this->M_entries->addEntries($values['account_code'], $retained_earning_account, abs($balance), abs($balance), 'Closing Temporary Accounts');
                    }

                endforeach;
            }

            //for logging
            $msg = 'Temp Accounts closed';
            $this->M_logs->add_log($msg, "Retained Earnings", "Acounts Closed", "Accounts");
            // end logging

            $this->session->set_flashdata('message', 'Temporary accounts closed successfully');
            redirect('reports/C_profitloss/run_pl_report/', 'refresh');
        }

        $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'], $data['langs']);

        //for logging
        $msg = 'Temp Accounts closed';
        $this->M_logs->add_log($msg, "Retained Earnings", "Acounts Closed", "Accounts");
        // end logging

        $this->load->view('templates/header', $data);
        $this->load->view('reports/v_run_profit_report', $data);
        $this->load->view('templates/footer');
    }
    //Print Invoice in PDF
    function printPDF($from_date, $to_date)
    {
        $company_name = ucfirst($this->session->userdata("company_name"));
        $profit_loss = $this->M_reports->get_parentGroups4pl($_SESSION['company_id']);;
        $expenses = $this->M_reports->get_parentGroups4Expense($_SESSION['company_id']);

        $langs = $this->session->userdata('lang');

        $this->load->library('Pdf_f');
        $pdf = new Pdf_f("P", 'mm', 'A4');

        $pdf->AddPage();
        //Display Company Info
        $pdf->SetY(15);
        $pdf->SetX(80);
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->Cell(50, 10, $company_name, 0, 1, "C");

        $pdf->SetY(22);
        $pdf->SetX(80);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 10, "Profit & Loss", 0, 1, "C");

        $pdf->SetY(28);
        $pdf->SetX(80);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 7, date('d-m-Y', strtotime($from_date)) . " to " . date('d-m-Y', strtotime($to_date)), 0, 1, "C");
        //$pdf->Cell(50, 7, "Salem 636002.", 0, 1);
        //$pdf->Cell(50, 7, "To ".$to_date, 0, 1);

        //Display Table headings
        $pdf->SetY(45);
        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(150, 9, "ACCOUNT", 1, 0);
        // $pdf->Cell(40, 9, "", 1, 0, "C");
        // $pdf->Cell(30, 9, "", 1, 0, "C");
        $pdf->Cell(40, 9, "TOTAL", 1, 1, "C");
        $pdf->SetFont('Arial', '', 12);

        $gross_total = 0;
        //Display table product rows

        foreach ($profit_loss as $key => $values) {
            $pl_report = $this->M_reports->get_profit_loss($_SESSION['company_id'], $values['account_code'], $from_date, $to_date);

            $account_title = (count($pl_report) > 0 ? ($langs == 'en' ? $values['title'] : $values['title_ur']) : '');
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(150, 9, $account_title, "LR", 0);
            $pdf->Cell(40, 9, '', "R", 1, "R");

            foreach ($pl_report as $key => $list) {
                $balance = ($list['credit']) - ($list['debit']);

                $gross_total += $balance;
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(150, 9, ($langs == 'en' ? '   ' . $list['title'] : '   ' . $list['title_ur']), "LR", 0);
                //$pdf->Cell(40, 9, '', "R", 0, "C");
                //$pdf->Cell(30, 9, '', "R", 0, "R");
                $pdf->Cell(40, 9, number_format($balance, 2), "R", 1, "R");
            }
        }

        //Display table empty rows
        for ($i = 0; $i < 0 - count($profit_loss); $i++) {
            $pdf->Cell(150, 9, "", "LR", 0);
            //$pdf->Cell(40, 9, "", "R", 0, "L");
            //$pdf->Cell(30, 9, "", "R", 0, "R");
            $pdf->Cell(40, 9, "", "R", 1, "R");
        }

        //Display table total row
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(150, 9, "Gross Profit", 1, 0, "");
        //$pdf->Cell(30, 9, '', 1, 0, "R");
        $pdf->Cell(40, 9, number_format($gross_total, 2), 1, 1, "R");
        ///body

        $total_expense = 0;
        //Display table product rows

        foreach ($expenses as $key => $values) {
            $pl_report = $this->M_reports->get_profit_loss($_SESSION['company_id'], $values['account_code'], $from_date, $to_date);

            $account_title = (count($pl_report) > 0 ? ($langs == 'en' ? $values['title'] : $values['title_ur']) : '');
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(150, 9, $account_title, "LR", 0);
            $pdf->Cell(40, 9, '', "R", 1, "R");

            foreach ($pl_report as $key => $list) {
                $balance = ($list['debit']) - ($list['credit']);

                $total_expense += $balance;
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(150, 9, ($langs == 'en' ? '   ' . $list['title'] : '   ' . $list['title_ur']), "LR", 0);
                //$pdf->Cell(40, 9, '', "R", 0, "C");
                //$pdf->Cell(30, 9, '', "R", 0, "R");
                $pdf->Cell(40, 9, number_format($balance, 2), "R", 1, "R");
            }
        }

        //Display table empty rows
        for ($i = 0; $i < 0 - count($profit_loss); $i++) {
            $pdf->Cell(150, 9, "", "LR", 0);
            //$pdf->Cell(40, 9, "", "R", 0, "L");
            //$pdf->Cell(30, 9, "", "R", 0, "R");
            $pdf->Cell(40, 9, "", "R", 1, "R");
        }
        //Display table total row
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(150, 9, "Total Expenses", 1, 0, "");
        //$pdf->Cell(30, 9, '', 1, 0, "R");
        $pdf->Cell(40, 9, number_format($total_expense, 2), 1, 1, "R");

        //Display table total row
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(150, 9, lang("total"), 1, 0, "");
        //$pdf->Cell(30, 9, '', 1, 0, "R");
        $pdf->Cell(40, 9, number_format($gross_total - $total_expense, 2), 1, 1, "R");

        $pdf->Output();
    }

    function printPDFs($from_date, $to_date)
    {
        $company_name = ucfirst($this->session->userdata("company_name"));
        $profit_loss = $this->M_reports->get_parentGroups4pl($_SESSION['company_id']);;
        $expenses = $this->M_reports->get_parentGroups4Expense($_SESSION['company_id']);

        $langs = $this->session->userdata('lang');

        $this->load->library('Pdf_f');
        $pdf = new Pdf_f("P", 'mm', 'A4');
        // $this->load->library('tfpdf/TFPDF');
        // $pdf = new TFPDF();

        $pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $pdf->AddFont('DejaVuBold', 'B', 'DejaVuSansCondensed-Bold.ttf', true);

        $pdf->AddPage();
        //Display Company Info
        $pdf->SetY(15);
        $pdf->SetX(80);
        $pdf->SetFont('DejaVuBold', 'B', 18);
        $pdf->Cell(50, 10, $company_name, 0, 1, "C");

        $pdf->SetY(22);
        $pdf->SetX(80);
        $pdf->SetFont('DejaVu', '', 12);
        $pdf->Cell(50, 10, lang("profit_loss"), 0, 1, "C");

        $pdf->SetY(28);
        $pdf->SetX(80);
        $pdf->SetFont('DejaVu', '', 12);
        $pdf->Cell(50, 7, date('m/d/Y', strtotime($from_date)) . " to " . date('m/d/Y', strtotime($to_date)), 0, 1, "C");
        //$pdf->Cell(50, 7, "Salem 636002.", 0, 1);
        //$pdf->Cell(50, 7, "To ".$to_date, 0, 1);

        //Display Table headings
        $pdf->SetY(45);
        $pdf->SetX(10);
        $pdf->SetFont('DejaVuBold', 'B', 12);
        $pdf->Cell(150, 9, strtoupper(lang("account")), 1, 0);
        // $pdf->Cell(40, 9, "", 1, 0, "C");
        // $pdf->Cell(30, 9, "", 1, 0, "C");
        $pdf->Cell(40, 9, strtoupper(lang("total")), 1, 1, "C");
        $pdf->SetFont('DejaVu', '', 12);

        $gross_total = 0;
        //Display table product rows

        foreach ($profit_loss as $key => $values) {
            $pl_report = $this->M_reports->get_profit_loss($_SESSION['company_id'], $values['account_code'], $from_date, $to_date);

            $account_title = (count($pl_report) > 0 ? ($langs == 'en' ? $values['title'] : $values['title_ur']) : '');
            $pdf->SetFont('DejaVuBold', 'B', 12);
            $pdf->Cell(150, 9, $account_title, "LR", 0);
            $pdf->Cell(40, 9, '', "R", 1, "R");

            foreach ($pl_report as $key => $list) {
                $balance = ($list['credit']) - ($list['debit']);

                $gross_total += $balance;
                $pdf->SetFont('DejaVu', '', 12);
                $pdf->Cell(150, 9, ($langs == 'en' ? '   ' . $list['title'] : '   ' . $list['title_ur']), "LR", 0);
                //$pdf->Cell(40, 9, '', "R", 0, "C");
                //$pdf->Cell(30, 9, '', "R", 0, "R");
                $pdf->Cell(40, 9, number_format($balance, 2), "R", 1, "R");
            }
        }

        //Display table empty rows
        for ($i = 0; $i < 0 - count($profit_loss); $i++) {
            $pdf->Cell(150, 9, "", "LR", 0);
            //$pdf->Cell(40, 9, "", "R", 0, "L");
            //$pdf->Cell(30, 9, "", "R", 0, "R");
            $pdf->Cell(40, 9, "", "R", 1, "R");
        }

        //Display table total row
        $pdf->SetFont('DejaVuBold', 'B', 12);
        $pdf->Cell(150, 9, "Gross Profit", 1, 0, "");
        //$pdf->Cell(30, 9, '', 1, 0, "R");
        $pdf->Cell(40, 9, number_format($gross_total, 2), 1, 1, "R");
        ///body

        $total_expense = 0;
        //Display table product rows

        foreach ($expenses as $key => $values) {
            $pl_report = $this->M_reports->get_profit_loss($_SESSION['company_id'], $values['account_code'], $from_date, $to_date);

            $account_title = (count($pl_report) > 0 ? ($langs == 'en' ? $values['title'] : $values['title_ur']) : '');
            $pdf->SetFont('DejaVuBold', 'B', 12);
            $pdf->Cell(150, 9, $account_title, "LR", 0);
            $pdf->Cell(40, 9, '', "R", 1, "R");

            foreach ($pl_report as $key => $list) {
                $balance = ($list['debit']) - ($list['credit']);

                $total_expense += $balance;
                $pdf->SetFont('DejaVu', '', 12);
                $pdf->Cell(150, 9, ($langs == 'en' ? '   ' . $list['title'] : '   ' . $list['title_ur']), "LR", 0);
                //$pdf->Cell(40, 9, '', "R", 0, "C");
                //$pdf->Cell(30, 9, '', "R", 0, "R");
                $pdf->Cell(40, 9, number_format($balance, 2), "R", 1, "R");
            }
        }

        //Display table empty rows
        for ($i = 0; $i < 0 - count($profit_loss); $i++) {
            $pdf->Cell(150, 9, "", "LR", 0);
            //$pdf->Cell(40, 9, "", "R", 0, "L");
            //$pdf->Cell(30, 9, "", "R", 0, "R");
            $pdf->Cell(40, 9, "", "R", 1, "R");
        }
        //Display table total row
        $pdf->SetFont('DejaVuBold', 'B', 12);
        $pdf->Cell(150, 9, "Total Expenses", 1, 0, "");
        //$pdf->Cell(30, 9, '', 1, 0, "R");
        $pdf->Cell(40, 9, number_format($total_expense, 2), 1, 1, "R");

        //Display table total row
        $pdf->SetFont('DejaVuBold', 'B', 12);
        $pdf->Cell(150, 9, lang("net_income"), 1, 0, "");
        //$pdf->Cell(30, 9, '', 1, 0, "R");
        $pdf->Cell(40, 9, number_format($gross_total - $total_expense, 2), 1, 1, "R");

        $pdf->Output();
    }
}
