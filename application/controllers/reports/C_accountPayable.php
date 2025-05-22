<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class C_accountPayable extends MY_Controller
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

        $data['title'] = lang('account_payable');
        $data['main'] = lang('account_payable');

        $from_date = $this->input->post('from_date') ? $this->input->post('from_date') : FY_START_DATE;
        $to_date = $this->input->post('to_date') ? $this->input->post('to_date') : FY_END_DATE;

        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;

        $data['main_small'] = '<br />' . date('d-m-Y', strtotime($data['from_date'])) . ' To ' . date('d-m-Y', strtotime($data['to_date']));

        $data['payable'] = $this->M_suppliers->get_accounts_payable($from_date, $to_date);


        //for logging
        $msg = '';
        $this->M_logs->add_log($msg, "Account Payable Report", "Retrieved", "Accounts");
        // end logging

        $this->load->view('templates/header', $data);
        $this->load->view('reports/v_account_payable', $data);
        $this->load->view('templates/footer');
    }

    //Print Invoice in PDF
    function printPDF($from_date, $to_date)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '10240M');

        //for logging
        $msg = '';
        $this->M_logs->add_log($msg, "Account Payable Report", "Printed", "Reports");
        // end logging

        $company_name = ucfirst($this->session->userdata("company_name"));
        $payable = $this->M_suppliers->get_accounts_payable($from_date, $to_date);

        $this->load->library('Pdf_f');
        $pdf = new Pdf_f("P", 'mm', 'A4');

        $pdf->AddPage();
        //Display Company Info
        $pdf->SetY(10);
        $pdf->SetX(80);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(50, 10, $company_name, 0, 1, "C");

        $pdf->SetY(17);
        $pdf->SetX(80);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 10, "Account Payable Report", 0, 1, "C");

        $pdf->SetY(23);
        $pdf->SetX(80);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 7, date('d-m-Y', strtotime($from_date)) . " to " . date('d-m-Y', strtotime($to_date)), 0, 1, "C");
        //$pdf->Cell(50, 7, "Salem 636002.", 0, 1);
        //$pdf->Cell(50, 7, "To ".$to_date, 0, 1);

        //Display Table headings
        $pdf->SetY(32);
        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(80, 9, "Suppliers", 1, 0);
        $pdf->Cell(40, 9, "TYPE", 1, 0, "C");
        $pdf->Cell(30, 9, "", 1, 0, "C");
        $pdf->Cell(40, 9, "TOTAL", 1, 1, "C");
        $pdf->SetFont('Arial', '', 9);

        $net_total = 0;
        $total_cost = 0;
        $total = 0;
        //Display table product rows

        foreach ($payable as $key => $list) {

            $supplier_name = $list['supplier_name'] ? $list['supplier_name'] : "N/A";
            $balance = $list['net_balance'];
            $net_total += $balance;

            $pdf->Cell(80, 5, $supplier_name, "LR", 0);
            $pdf->Cell(40, 5, "Bill", "R", 0, "C");
            $pdf->Cell(30, 5, "", "R", 0, "C");
            $pdf->Cell(40, 5, number_format($balance, 2), "R", 1, "R");
        }

        //Display table empty rows
        for ($i = 0; $i < 20 - count($payable); $i++) {
            $pdf->Cell(80, 5, "", "LR", 0);
            $pdf->Cell(40, 5, "", "R", 0, "L");
            $pdf->Cell(30, 5, "", "R", 0, "C");
            $pdf->Cell(40, 5, "", "R", 1, "R");
        }

        //Display table total row
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(150, 9, "TOTAL", 1, 0, "R");
        $pdf->Cell(40, 9, number_format($net_total, 2), 1, 1, "R");

        ///body

        //set footer position
        $pdf->SetY(-60);
        //$pdf->SetFont('helvetica', 'B', 12);
        //$pdf->Cell(0, 10, "for ABC COMPUTERS", 0, 1, "R");
        $pdf->Ln(15);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(0, 10, "Authorized Signature", 0, 1, "R");
        $pdf->SetFont('helvetica', '', 9);

        //Display Footer Text
        $pdf->Cell(0, 10, "This is a computer generated report", 0, 1, "C");
        ///////////////

        $pdf->Output();
    }
}
