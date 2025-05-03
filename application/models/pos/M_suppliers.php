<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class M_suppliers extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //get all suppliers and also only one supplier and active and inactive too.
    public function get_suppliers($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if ($id === FALSE) {
            if ($limit) {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }

            $this->db->order_by('id', 'desc');
            $query = $this->db->get_where('pos_supplier', array('company_id' => $_SESSION['company_id']));
            $data = $query->result_array();
            return $data;
        }

        //$this->db->order_by('id','desc');
        $options = array('id' => $id, 'company_id' => $_SESSION['company_id']);

        $query = $this->db->get_where('pos_supplier', $options);
        $data = $query->result_array();
        return $data;
    }

    //get all suppliers and also only one supplier and active and inactive too.
    public function get_activeSuppliers($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if ($id === FALSE) {
            if ($limit) {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }

            $options = array('status' => 'active', 'company_id' => $_SESSION['company_id']);

            $this->db->order_by('id', 'desc');
            $query = $this->db->get_where('pos_supplier', $options);
            $data = $query->result_array();
            return $data;
        }

        $this->db->order_by('id', 'desc');
        $options = array('id' => $id, 'status' => 'active', 'company_id' => $_SESSION['company_id']);

        $query = $this->db->get_where('pos_supplier', $options);
        $data = $query->result_array();
        return $data;
    }

    public function get_activeSuppliersByAccCode($acc_code)
    {
        $options = array(
            'status' => 'active',
            'company_id' => $_SESSION['company_id'],
            'acc_code' => $acc_code
        );

        $query = $this->db->get_where('pos_supplier', $options);
        $data = $query->result_array();
        return $data;
    }

    //get all suppliers and also only one supplier and active and inactive too.
    public function get_supplierCurrency($id)
    {
        $this->db->select('cur.id,cur.name,cur.code,cur.symbol');
        $this->db->join('pos_currencies cur', 'cur.id = c.currency_id');
        $query = $this->db->get_where('pos_supplier c', array('c.id' => $id, 'c.status' => 'active', 'c.company_id' => $_SESSION['company_id']));
        $data = $query->result_array();
        return $data;
    }


    public function get_supplier_Entries($supplier_id, $fy_start_date, $fy_end_date)
    {
        $this->db->group_by('sp.id');
        //$this->db->join('acc_groups g','g.account_code=sp.account_code');
        $this->db->select('sp.*')->from('pos_supplier_payments sp')->where('sp.supplier_id', $supplier_id);
        $this->db->where('sp.company_id', $_SESSION['company_id']);
        //$this->db->where('g.company_id', $_SESSION['company_id']);
        $this->db->where('date >=', $fy_start_date);
        $this->db->where('date <=', $fy_end_date);

        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    public function get_accounts_payable($from_date, $to_date)
    {
        $sql = "
                    SELECT 
                        c.id AS supplier_id,
                        name AS supplier_name,
                        c.op_balance_dr,
                        c.op_balance_cr,
                        COALESCE(SUM(p.debit), 0) AS dr_balance,
                        COALESCE(SUM(p.credit), 0) AS cr_balance,
                        ((c.op_balance_cr + COALESCE(SUM(p.credit), 0)) + (c.op_balance_dr + COALESCE(SUM(p.debit), 0))) AS net_balance
                    FROM pos_supplier c
                    LEFT JOIN pos_supplier_payments p ON p.supplier_id = c.id AND p.date BETWEEN ? AND ? AND p.company_id = ?
                    WHERE 
                        c.company_id = ?
                        AND c.status = 'active'
                        AND c.issupplier = 1
                        
                    GROUP BY c.id
                    HAVING net_balance <> 0
                    ORDER BY supplier_name ASC
                    ";

        $bindings = [
            $from_date,
            $to_date,
            $_SESSION['company_id'],
            $_SESSION['company_id'],

        ];

        $query = $this->db->query($sql, $bindings);
        return $query->result_array();
    }

    public function get_supplier_total_balance($supplier_id, $fy_start_date, $fy_end_date)
    {
        $this->db->select('SUM(debit) as dr_balance, SUM(credit) as cr_balance')->from('pos_supplier_payments sp')->where('sp.supplier_id', $supplier_id);
        $this->db->where('sp.company_id', $_SESSION['company_id']);
        $this->db->where('date >=', $fy_start_date);
        $this->db->where('date <=', $fy_end_date);
        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    function addsupplierPaymentEntry(
        $account_code,
        $dueTo_acc_code,
        $dr_amount,
        $cr_amount,
        $supplier_id = '',
        $narration = '',
        $invoice_no = '',
        $date = null,
        $exchange_rate = 0,
        $entry_id = 0,
        $emp_id = 0
    ) {
        $data = array(
            'supplier_id' => $supplier_id,
            'account_code' => $account_code,
            'dueTo_acc_code' => $dueTo_acc_code,
            'date' => ($date == null ? date('Y-m-d') : $date),
            'debit' => $dr_amount,
            'credit' => $cr_amount,
            'invoice_no' => $invoice_no,
            'entry_id' => $entry_id,
            'narration' => $narration,
            'exchange_rate' => ($exchange_rate == null ? 1 : $exchange_rate),
            'company_id' => $_SESSION['company_id'],
            'employee_id' => $emp_id,
        );
        $this->db->insert('pos_supplier_payments', $data);
    }

    function getMAXSupInvoiceNo($invoice_prefix)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('company_id', $_SESSION['company_id']);
        $this->db->like('invoice_no', $invoice_prefix, 'after');
        $query = $this->db->get('pos_supplier_payments', 1);
        return $query->row()->invoice_no;
    }

    function getSupplierPostingTypes($supplier_id)
    {
        $this->db->select('ppt.*');
        $this->db->join('pos_supplier sp', 'sp.posting_type_id=ppt.id');
        $this->db->where('sp.id', $supplier_id);
        $query = $this->db->get('pos_purchasepostingtypes ppt', 1);
        return $query->result_array();
    }


    function getCustSuppPostingTypes($supplier_id)
    {
        $this->db->select('spt.*');
        $this->db->join('pos_supplier s', 's.sale_posting_type_id=spt.id');
        $this->db->where('s.id', $supplier_id);
        $query = $this->db->get('pos_salespostingtypes spt', 1);
        return $query->result_array();
    }

    public function get_supplierName($supplier_id)
    {
        $options = array('id' => $supplier_id,);

        $query = $this->db->get_where('pos_supplier', $options);
        if ($row = $query->row()) {
            return $row->name;
        }

        return '';
    }

    public function get_cust_supp()
    {
        $options = array('also_customer' => 1);

        $query = $this->db->get_where('pos_supplier', $options);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function getSupplierDropDown()
    {
        //$data = array();
        $data[0] = '--Select Supplier--';

        $query = $this->db->get_where('pos_supplier', array('status' => 'active', 'company_id' => $_SESSION['company_id']));

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['id']] = $row['name'];
            }
        }
        $query->free_result();
        return $data;
    }


    function addSupplier()
    {

        $data = array(
            'company_id' => $_SESSION['company_id'],
            'posting_type_id' => $this->input->post('posting_type_id', true),
            'name' => $this->input->post('name', true),
            'email' => $this->input->post('email', true),
            'address' => $this->input->post('address', true),
            'contact_no' => $this->input->post('contact_no', true),
            'status' => $this->input->post('status', true)
        );
        $this->db->insert('pos_supplier', $data);

        //for logging
        $msg = $this->input->post('name', true);
        $this->M_logs->add_log($msg, "Supplier", "added", "POS");
        // end logging      
    }

    function updateSupplier()
    {
        $file_name = $this->upload->data();

        $data = array(
            'company_id' => $_SESSION['company_id'],
            'posting_type_id' => $this->input->post('posting_type_id', true),
            'name' => $this->input->post('name', true),
            'email' => $this->input->post('email', true),
            'address' => $this->input->post('address', true),
            'contact_no' => $this->input->post('contact_no', true),
            'status' => $this->input->post('status', true)
        );
        $this->db->update('pos_supplier', $data, array('id' => $_POST['id']));

        //for logging
        $msg = $this->input->post('name', true);
        $this->M_logs->add_log($msg, "Supplier", "updated", "POS");
        // end logging  
    }

    function deleteSupplier($id, $op_balance_dr, $op_balance_cr)
    {
        $this->db->trans_start();
        $posting_type_code = $this->M_suppliers->getSupplierPostingTypes($id);

        if (!empty($posting_type_code)) {
            //OPENING BALANCE IN supplier ACCOUNT
            $payable_acc_code = $posting_type_code[0]['payable_acc_code']; //supplier ledger id
            $payable_account = $this->M_groups->get_groups($payable_acc_code, $_SESSION['company_id']);
            $payable_dr_balance = abs($payable_account[0]['op_balance_dr']);
            $payable_cr_balance = abs($payable_account[0]['op_balance_cr']);

            if ($payable_dr_balance !== 0 || $payable_cr_balance !== 0) {
                $dr_balance = ($payable_dr_balance - $op_balance_dr);
                $cr_balance = ($payable_cr_balance - $op_balance_cr);

                $this->M_groups->editGroupOPBalance($payable_acc_code, $dr_balance, $cr_balance);
            }
        }

        //GET receivings ITEMS AND DELETE receivings AND receivings ITEMS supplier PAYEENT 
        //AND ALSO JOURNAL ENTRIES
        $query = $this->db->get_where('pos_receivings', array('supplier_id' => $id, 'company_id' => $_SESSION['company_id']));
        if ($query->num_rows() > 0) //IF receivings EXIST THEN DELETE supplier receivings
        {
            $receivings = $query->result_array();

            //GET INVOICE NO BY supplier ID AND DELETE ALL BY INVOICE NO.
            foreach ($receivings as $receiving_item) {

                $this->db->delete('acc_entries', array('invoice_no' => $receiving_item['invoice_no'], 'company_id' => $_SESSION['company_id']));
                $this->db->delete('acc_entry_items', array('invoice_no' => $receiving_item['invoice_no'], 'company_id' => $_SESSION['company_id']));

                //WHEN supplier DELTED ITS receivings DELETED AND PRODUCT WILL BE REVERSED        
                //if entry deleted then all item qty will be reversed
                $receiving_items = $this->M_receivings->get_receiving_items($receiving_item['invoice_no']);
                //var_dump($receiving_items);

                foreach ($receiving_items as $values) {
                    $total_stock =  $this->M_items->total_stock($values['item_id'], -1, $values['size_id']);
                    $quantity = ($total_stock - $values['quantity_purchased']);

                    $option_data = array(
                        'quantity' => $quantity,
                        //'unit_price' =>$values['item_unit_price'],
                        'avg_cost' => $this->M_items->getAvgCost($values['item_id'], $values['item_cost_price'], $values['quantity_purchased'], 0, $values['size_id'], 'return') //calculate avg cost

                    );
                    $this->db->update('pos_items_detail', $option_data, array('size_id' => $values['size_id'], 'item_id' => $values['item_id']));

                    //insert item info into inventory table
                    $data1 = array(

                        'trans_item' => $values['item_id'],
                        'trans_comment' => 'KSRECV Deleted',
                        'trans_inventory' => $values['quantity_purchased'],
                        'company_id' => $_SESSION['company_id'],
                        'trans_user' => $_SESSION['user_id'],
                        'invoice_no' => $receiving_item['invoice_no']
                    );

                    $this->db->insert('pos_inventory', $data1);
                }
                $this->db->delete('pos_receivings_items', array('invoice_no' => $receiving_item['invoice_no'], 'company_id' => $_SESSION['company_id']));
                /////////////////////////////
                //WHEN supplier DELTED ITS receivings DELETED AND PRODUCT WILL BE REVERSED            
            }

            //DELETE ENTRIES BY supplier_ID NOT INVOICE NO.
            $this->db->delete('pos_supplier_payments', array('supplier_id' => $id, 'company_id' => $_SESSION['company_id']));
            $this->db->delete('pos_receivings', array('supplier_id' => $id, 'company_id' => $_SESSION['company_id']));
            ////////////////
            ///////ACCOUNTS ENDS
        }


        $query = $this->db->delete('pos_supplier', array('id' => $id));
        $this->db->trans_complete();

        //for logging
        $msg = $id;
        $this->M_logs->add_log($msg, "Supplier", "deleted", "POS");
        // end logging 
    }

    function inactivate($id, $op_balance_dr, $op_balance_cr)
    {
        $posting_type_code = $this->M_suppliers->getSupplierPostingTypes($id);

        //OPENING BALANCE IN supplier ACCOUNT
        $payable_acc_code = $posting_type_code[0]['payable_acc_code']; //supplier ledger id
        $payable_account = $this->M_groups->get_groups($payable_acc_code, $_SESSION['company_id']);
        $payable_dr_balance = abs($payable_account[0]['op_balance_dr']);
        $payable_cr_balance = abs($payable_account[0]['op_balance_cr']);

        if ($payable_dr_balance !== 0 || $payable_cr_balance !== 0) {
            $dr_balance = ($payable_dr_balance - $op_balance_dr);
            $cr_balance = ($payable_cr_balance - $op_balance_cr);

            $this->M_groups->editGroupOPBalance($payable_acc_code, $dr_balance, $cr_balance);
        }

        $query = $this->db->update('pos_supplier', array('status' => 'inactive'), array('id' => $id));

        //for logging
        $msg = $id;
        $this->M_logs->add_log($msg, "Supplier", "inactivated", "POS");
        // end logging 
    }

    function delete_entry_by_id($entry_id)
    {
        $query = $this->db->get_where('pos_supplier_payments', array(
            'entry_id' => $entry_id,
            'company_id' => $_SESSION['company_id']
        ));

        if ($query->num_rows() > 0) {
            $data = $query->result_array();

            $supplier_id = $data[0]['supplier_id'];
            $invoice_no = $data[0]['invoice_no'];
            //$total_amount = ($data[0]['debit']+$data[0]['credit']);
            //$cur_amount = 0;

            if ($supplier_id != 0) {
                /////////////////
                //REDUCE THE TOTAL AMOUNT IN SALES TO SHOW EXACT AMOUNT IN OUTSTANDING INVOICES
                $supplier_payment_hstry = $this->get_supplier_payment_history($supplier_id, $invoice_no);

                foreach ($supplier_payment_hstry as $values) {

                    $prev_receiving = $this->M_receivings->get_receiving_by_invoice($values['receiving_invoice_no']);
                    //var_dump($prev_sales);
                    $data = array(
                        'paid' => abs(@$prev_receiving[0]['paid'] - $values['amount']), //must be positive values
                    );
                    $this->db->update('pos_receivings', $data, array('invoice_no' => $values['receiving_invoice_no']));
                }

                //DELETE PAYMENT HISOTRY 
                $this->delete_supplier_payment_history($supplier_id, $invoice_no);


                // $credit_purchase = $this->M_receivings->get_creditPurchases($supplier_id);
                //                    
                //                        foreach($credit_purchase as $values){
                //                        $prev_bal = $values['paid'];
                //                        //$cur_amount = $total_amount;
                //                        
                //                        if($cur_amount > $prev_bal)
                //                        {
                //                            $cur_amount = $total_amount;
                //                        }
                //                        else if($cur_amount < $prev_bal)
                //                        {
                //                            $cur_amount = $prev_bal;
                //                        }
                //                    
                //                        $data = array(
                //                        'paid' => $prev_bal-$cur_amount,
                //                        );
                //                
                //                        $this->db->update('pos_receivings',$data,array('invoice_no'=>$values['invoice_no']));
                //                        
                //                        $cur_amount = ($total_amount-$prev_bal);
                //                        
                //                        if($cur_amount > 0)
                //                        {
                //                            $total_amount = $cur_amount;
                //                        }
                //                        else{
                //                            $total_amount = 0;
                //                        }
                //                    }
                ///////////////
            }
        }

        $query = $this->db->delete('pos_supplier_payments', array('entry_id' => $entry_id));
    }

    function delete_entry_by_invoice_no($invoice_no)
    {
        $query = $this->db->get_where('pos_supplier_payments', array(
            'invoice_no' => $invoice_no,
            'company_id' => $_SESSION['company_id']
        ));

        if ($query->num_rows() > 0) {
            $data = $query->result_array();

            $supplier_id = $data[0]['supplier_id'];
            $invoice_no = $data[0]['invoice_no'];
            //$total_amount = ($data[0]['debit']+$data[0]['credit']);
            //$cur_amount = 0;

            if ($supplier_id != 0) {
                /////////////////
                //REDUCE THE TOTAL AMOUNT IN SALES TO SHOW EXACT AMOUNT IN OUTSTANDING INVOICES
                $supplier_payment_hstry = $this->get_supplier_payment_history($supplier_id, $invoice_no);

                foreach ($supplier_payment_hstry as $values) {

                    $prev_receiving = $this->M_receivings->get_receiving_by_invoice($values['receiving_invoice_no']);
                    //var_dump($prev_sales);
                    $data = array(
                        'paid' => abs(@$prev_receiving[0]['paid'] - $values['amount']), //must be positive values
                    );
                    $this->db->update('pos_receivings', $data, array('invoice_no' => $values['receiving_invoice_no']));
                }

                //DELETE PAYMENT HISOTRY 
                $this->delete_supplier_payment_history($supplier_id, $invoice_no);
            }
        }

        $query = $this->db->delete('pos_supplier_payments', array('invoice_no' => $invoice_no));
    }

    function get_supplier_payment_history($supplier_id, $invoice_no)
    {

        $options = array('supplier_id' => $supplier_id, 'invoice_no' => $invoice_no, 'company_id' => $_SESSION['company_id']);

        $query = $this->db->get_where('pos_supplier_payment_history', $options);
        $data = $query->result_array();
        return $data;
    }

    function delete_supplier_payment_history($supplier_id, $invoice_no)
    {
        $options = array('supplier_id' => $supplier_id, 'invoice_no' => $invoice_no, 'company_id' => $_SESSION['company_id']);

        $query = $this->db->delete('pos_supplier_payment_history', $options);
    }

    function activate($id)
    {
        $query = $this->db->update('pos_supplier', array('status' => 'active'), array('id' => $id));

        //for logging
        $msg = $id;
        $this->M_logs->add_log($msg, "Supplier", "activated", "POS");
        // end logging 
    }
}
