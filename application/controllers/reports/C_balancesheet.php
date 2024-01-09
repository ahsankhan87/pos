<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_balancesheet extends MY_Controller
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
        $data['title'] = lang('balance_sheet');
        $data['main'] = lang('balance_sheet');
        $data['from_date'] = ($this->input->post('from_date') ? $this->input->post('from_date') : FY_START_DATE);
        $data['to_date'] = ($this->input->post('to_date') ? $this->input->post('to_date') : FY_END_DATE);

        $data['main_small'] = '<br />' . date('d-m-Y', strtotime($data['from_date'])) . ' To ' . date('d-m-Y', strtotime($data['to_date']));

        $data['net_income'] = $this->M_reports->get_net_income($data['from_date'], $data['to_date']);
        $data['parentGroups4Assets'] = $this->M_reports->get_parentGroups4Assets($_SESSION['company_id']);
        $data['Liability4BalanceSheet'] = $this->M_reports->get_parentGroups4Liability($_SESSION['company_id']);

        //for logging
        $msg = '';
        $this->M_logs->add_log($msg, "Balance Sheet", "Retrieved", "Accounts");
        // end logging

        $this->load->view('templates/header', $data);
        $this->load->view('reports/balance_sheet', $data);
        $this->load->view('templates/footer');
    }

    //Print Invoice in PDF
    function printPDF($from_date, $to_date)
    {
        $company_name = ucfirst($this->session->userdata("company_name"));
        $net_income = $this->M_reports->get_net_income();
        $parentGroups4Assets = $this->M_reports->get_parentGroups4Assets($_SESSION['company_id']);
        $Liability4BalanceSheet = $this->M_reports->get_parentGroups4Liability($_SESSION['company_id']);

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
        $pdf->Cell(50, 10, "Balance Sheet", 0, 1, "C");

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
        $pdf->Cell(150, 9, "ASSET ACCOUNT", 1, 0);
        // $pdf->Cell(40, 9, "", 1, 0, "C");
        // $pdf->Cell(30, 9, "", 1, 0, "C");
        $pdf->Cell(40, 9, "TOTAL", 1, 1, "C");
        $pdf->SetFont('Arial', '', 12);

        $asset_total = 0;
        $cr_net_total = 0;
        $total = 0;
        //Display table product rows

        foreach ($parentGroups4Assets as $key => $values) {
            $bl_report = $this->M_groups->get_GroupsByParent($values['account_code']);

            $account_title = (count($bl_report) > 0 ? ($langs == 'en' ? $values['title'] : $values['title_ur']) : '');
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(150, 9, $account_title, "LR", 0);
            $pdf->Cell(40, 9, '', "R", 1, "R");

            foreach ($bl_report as $key => $list) {
                $dr_amount = $this->M_entries->balanceByAccount($list['account_code'], $from_date, $to_date)[0]['debit'];
                $cr_amount = $this->M_entries->balanceByAccount($list['account_code'], $from_date, $to_date)[0]['credit'];

                $balance = ($dr_amount + $list['op_balance_dr']) - ($list['op_balance_cr'] + $cr_amount);

                $asset_total += $balance;
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(150, 9, ($langs == 'en' ? '   ' . $list['title'] : '   ' . $list['title_ur']), "LR", 0);
                //$pdf->Cell(40, 9, '', "R", 0, "C");
                //$pdf->Cell(30, 9, '', "R", 0, "R");
                $pdf->Cell(40, 9, ($balance > 0 ? number_format($balance, 2) : 0), "R", 1, "R");
            }
        }

        //Display table empty rows
        for ($i = 0; $i < 0 - count($parentGroups4Assets); $i++) {
            $pdf->Cell(150, 9, "", "LR", 0);
            //$pdf->Cell(40, 9, "", "R", 0, "L");
            //$pdf->Cell(30, 9, "", "R", 0, "R");
            $pdf->Cell(40, 9, "", "R", 1, "R");
        }

        //Display table total row
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(150, 9, "TOTAL", 1, 0, "");
        //$pdf->Cell(30, 9, '', 1, 0, "R");
        $pdf->Cell(40, 9, number_format($asset_total, 2), 1, 1, "R");

        //Display Table headings
        //Liabilities and owner equity
        //  $pdf->SetY(45);
        //  $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(150, 9, "LIABILITIES ACCOUNT", 1, 0);
        // $pdf->Cell(40, 9, "", 1, 0, "C");
        // $pdf->Cell(30, 9, "", 1, 0, "C");
        $pdf->Cell(40, 9, "", 1, 1, "C");

        foreach ($Liability4BalanceSheet as $key => $values) {
            $bl_report = $this->M_groups->get_GroupsByParent($values['account_code']);

            $account_title = (count($bl_report) > 0 ? ($langs == 'en' ? $list['title'] : $list['title_ur']) : '');
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(150, 9, $account_title, "LR", 0);
            $pdf->Cell(40, 9, '', "R", 1, "R");

            foreach ($bl_report as $key => $list) {
                $dr_amount = $this->M_entries->balanceByAccount($list['account_code'], $from_date, $to_date)[0]['debit'];
                $cr_amount = $this->M_entries->balanceByAccount($list['account_code'], $from_date, $to_date)[0]['credit'];

                $balance = ($list['op_balance_cr'] + $cr_amount) - ($dr_amount + $list['op_balance_dr']);

                $total += $balance;
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(150, 9, ($langs == 'en' ? '   ' . $list['title'] : '   ' . $list['title_ur']), "LR", 0);
                //$pdf->Cell(40, 9, '', "R", 0, "C");
                //$pdf->Cell(30, 9, '', "R", 0, "R");
                $pdf->Cell(40, 9, ($balance > 0 ? number_format($balance, 2) : 0), "R", 1, "R");
            }
        }
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(150, 9, 'Net Income', "LR", 0);
        $pdf->Cell(40, 9, number_format($net_income, 2), "R", 1, "R");


        //Display table empty rows
        for ($i = 0; $i < 0 - count($Liability4BalanceSheet); $i++) {
            $pdf->Cell(150, 9, "", "LR", 0);
            //$pdf->Cell(40, 9, "", "R", 0, "L");
            //$pdf->Cell(30, 9, "", "R", 0, "R");
            $pdf->Cell(40, 9, "", "R", 1, "R");
        }

        //Display table total row
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(150, 9, "TOTAL", 1, 0, "");
        //$pdf->Cell(30, 9, '', 1, 0, "R");
        $pdf->Cell(40, 9, number_format(($total + $net_income), 2), 1, 1, "R");

        ///body


        $pdf->Output();
    }
}
