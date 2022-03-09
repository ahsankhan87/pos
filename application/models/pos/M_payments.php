<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_payments extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_paymentByInvoice($payment_id = FALSE,$invoice_no)
    {
        if($payment_id == FALSE)
        {
            $query = $this->db->get_where('acc_payments',array('company_id'=> $_SESSION['company_id'],'invoice_no'=>$invoice_no));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('acc_payments',array('id'=>$payment_id,'company_id'=> $_SESSION['company_id'],'invoice_no'=>$invoice_no));
       return $query->result_array();
    }
    
    function get_payments($payment_id = FALSE)
    {
        if($payment_id == FALSE)
        {
            $this->db->select('gp.title,gp.title_ur,ap.invoice_no,ap.employee_id,ap.payment_date,
            ap.description,ap.amount,ap.tax_amount,(ap.amount+ap.tax_amount) as net_amount,ap.supplier_invoice_no');
            $this->db->join('acc_groups gp','gp.account_code= ap.account_code','right');
            $query = $this->db->get_where('acc_payments ap',array('ap.company_id'=> $_SESSION['company_id'],'gp.company_id'=> $_SESSION['company_id']));
            
            return $query->result_array();
        }
       
       $this->db->select('gp.title,gp.title_ur,ap.invoice_no,ap.employee_id,ap.payment_date,
       ap.description,ap.amount,ap.tax_amount,(ap.amount+ap.tax_amount) as net_amount,ap.supplier_invoice_no');
       $this->db->join('acc_groups gp','gp.account_code= ap.account_code','left');
       $query = $this->db->get_where('acc_payments ap',array('ap.id'=>$payment_id,'ap.company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    function getMAXPaymentInvoiceNo()
    {   
        $this->db->order_by('CAST(SUBSTR(invoice_no,2) AS UNSIGNED) DESC');
        $this->db->select('SUBSTR(invoice_no,2) as invoice_no');
        $this->db->where('company_id', $_SESSION['company_id']);
        $query = $this->db->get('acc_payments',1);
        return $query->row()->invoice_no;
    }
    
    function delete($invoice_no)
    {
        $this->db->delete('acc_entries',array('invoice_no'=>$invoice_no));
        $this->db->delete('acc_entry_items',array('invoice_no'=>$invoice_no));
        
        $this->db->delete('acc_payments',array('invoice_no'=>$invoice_no));
    }
}
    