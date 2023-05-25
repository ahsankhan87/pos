<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_receipts extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_receiptByInvoice($receipt_id = FALSE,$invoice_no='')
    {
        if($receipt_id == FALSE)
        {
            $query = $this->db->get_where('acc_receipts',array('company_id'=> $_SESSION['company_id'],'invoice_no'=>$invoice_no));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('acc_receipts',array('id'=>$receipt_id,'company_id'=> $_SESSION['company_id'],'invoice_no'=>$invoice_no));
       return $query->result_array();
    }
    
    function get_receipts($receipt_id = FALSE,$from_date=null,$to_date=null)
    {
        if($from_date != null && $to_date != null){
            $this->db->where("ap.payment_date BETWEEN '$from_date' AND '$to_date'");
        }
        
        if($receipt_id == FALSE)
        {
            $this->db->select('gp.title,gp.title_ur,ap.id,ap.invoice_no,ap.employee_id,ap.payment_date,
            ap.description,ap.amount,ap.tax_amount,(ap.amount+ap.tax_amount) as net_amount');
            $this->db->join('acc_groups gp','gp.account_code= ap.account_code','right');
            $query = $this->db->get_where('acc_receipts ap',array('ap.company_id'=> $_SESSION['company_id'],'gp.company_id'=> $_SESSION['company_id']));
            
            return $query->result_array();
        }
       
       $this->db->select('gp.title,gp.title_ur,ap.id,ap.invoice_no,ap.employee_id,ap.payment_date,
       ap.description,ap.amount,ap.tax_amount,(ap.amount+ap.tax_amount) as net_amount');
       $this->db->join('acc_groups gp','gp.account_code= ap.account_code','left');
       $query = $this->db->get_where('acc_receipts ap',array('ap.id'=>$receipt_id,'ap.company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }

    function getMAXreceiptInvoiceNo()
    {   
        $this->db->order_by('CAST(SUBSTR(invoice_no,2) AS UNSIGNED) DESC');
        $this->db->select('SUBSTR(invoice_no,2) as invoice_no');
        $this->db->where('company_id', $_SESSION['company_id']);
        $query = $this->db->get('acc_receipts',1);
        return $query->row()->invoice_no;
    }
    
    function delete($invoice_no)
    {
        $this->db->delete('acc_entries',array('invoice_no'=>$invoice_no,'company_id'=> $_SESSION['company_id']));
        $this->db->delete('acc_entry_items',array('invoice_no'=>$invoice_no,'company_id'=> $_SESSION['company_id']));
        
        $this->db->delete('acc_receipts',array('invoice_no'=>$invoice_no,'company_id'=> $_SESSION['company_id']));
        $this->db->delete('pos_customer_payments',array('invoice_no'=>$invoice_no,'company_id'=> $_SESSION['company_id']));
    }
}
    