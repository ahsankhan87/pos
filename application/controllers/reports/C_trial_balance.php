<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class C_trial_balance extends MY_Controller
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

        $data['title'] = lang('trial_balance');
        $data['main'] = lang('trial_balance');

        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : FY_START_DATE);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : FY_END_DATE);

        $data['main_small'] = '<br />' . date('d-m-Y', strtotime($data['from_date'])) . ' To ' . date('d-m-Y', strtotime($data['to_date']));

        //if($data['from_date'] && $data['to_date'])
        //{
        $data['trialBalance'] = $this->M_groups->get_detail_accounts(FALSE, $_SESSION['company_id']);
        //$data['trialBalance']= $this->M_reports->get_trial_balance($_SESSION['company_id'],$data['from_date'],$data['to_date']);
        // }

        //for logging
        $msg = '';
        $this->M_logs->add_log($msg, "Trail Balance Report", "Retrieved", "Accounts");
        // end logging

        $this->load->view('templates/header', $data);
        $this->load->view('reports/trial_balance', $data);
        $this->load->view('templates/footer');
    }
    //Print Invoice in PDF
    function printPDF($from_date, $to_date)
    {
        $company_name = ucfirst($this->session->userdata("company_name"));
        $trialBalance = $this->M_groups->get_detail_accounts(FALSE, $_SESSION['company_id']);
        $langs = $this->session->userdata('lang');

        $this->load->library('Pdf_f');
        $pdf = new Pdf_f("P", 'mm', 'A4');

        $pdf->AddPage();
        //Display Company Info
        $pdf->SetY(10);
        $pdf->SetX(80);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(50, 10, $company_name, 0, 1, "C");

        $pdf->SetY(16);
        $pdf->SetX(80);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(50, 10, "Trial Balance", 0, 1, "C");

        $pdf->SetY(22);
        $pdf->SetX(80);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(50, 7, date('d-m-Y', strtotime($from_date)) . " to " . date('d-m-Y', strtotime($to_date)), 0, 1, "C");
        //$pdf->Cell(50, 7, "Salem 636002.", 0, 1);
        //$pdf->Cell(50, 7, "To ".$to_date, 0, 1);

        //Display Table headings
        $pdf->SetY(35);
        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(80, 9, "ACCOUNT", 1, 0);
        $pdf->Cell(40, 9, "", 1, 0, "C");
        $pdf->Cell(30, 9, "DEBIT", 1, 0, "C");
        $pdf->Cell(40, 9, "CREDIT", 1, 1, "C");
        $pdf->SetFont('Arial', '', 9);

        $dr_net_total = 0;
        $cr_net_total = 0;
        $total = 0;
        //Display table product rows

        foreach ($trialBalance as $key => $list) {

            $dr_amount = $this->M_entries->balanceByAccount($list['account_code'], $from_date, $to_date)[0]['debit'];
            $cr_amount = $this->M_entries->balanceByAccount($list['account_code'], $from_date, $to_date)[0]['credit'];

            $dr_balance = ($dr_amount + $list['op_balance_dr']) - ($list['op_balance_cr'] + $cr_amount);
            $cr_balance = ($list['op_balance_cr'] + $cr_amount) - ($dr_amount + $list['op_balance_dr']);

            //if ($dr_balance > 0) {
            $dr_net_total += ($dr_balance > 0 ? $dr_balance : 0);
            // } elseif ($balance < 0) {
            $cr_net_total += ($cr_balance > 0 ? $cr_balance : 0);

            // } 

            $pdf->Cell(80, 5, ($langs == 'en' ? $list['title'] : $list['title_ur']), "LR", 0);
            $pdf->Cell(40, 5, '', "R", 0, "C");
            $pdf->Cell(30, 5, ($dr_balance > 0 ? number_format($dr_balance, 2) : 0), "R", 0, "R");
            $pdf->Cell(40, 5, ($cr_balance > 0 ? number_format($cr_balance, 2) : 0), "R", 1, "R");
        }

        //Display table empty rows
        for ($i = 0; $i < 20 - count($trialBalance); $i++) {
            $pdf->Cell(80, 5, "", "LR", 0);
            $pdf->Cell(40, 5, "", "R", 0, "L");
            $pdf->Cell(30, 5, "", "R", 0, "R");
            $pdf->Cell(40, 5, "", "R", 1, "R");
        }

        //Display table total row
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(120, 9, "TOTAL", 1, 0, "");
        $pdf->Cell(30, 9, number_format($dr_net_total, 2), 1, 0, "R");
        $pdf->Cell(40, 9, number_format($cr_net_total, 2), 1, 1, "R");

        //$pdf->Cell(150, 9, "TOTAL", 1, 0, "R");

        ///body

        //set footer position
        $pdf->SetY(-60);
        //$pdf->SetFont('helvetica', 'B', 12);
        //$pdf->Cell(0, 10, "for ABC COMPUTERS", 0, 1, "R");
        // $pdf->Ln(15);
        // $pdf->SetFont('helvetica', '', 12);
        // $pdf->Cell(0, 10, "Authorized Signature", 0, 1, "R");
        // $pdf->SetFont('helvetica', '', 10);

        //Display Footer Text
        $pdf->Cell(0, 10, "This is a computer generated report", 0, 1, "C");
        ///////////////

        $pdf->Output();
    }
}
