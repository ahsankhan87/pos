<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_currencies extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    //get all currencies and also only one currency and active and inactive too.
    public function get_currencies($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            
            $this->db->order_by('id','desc');
            $query = $this->db->get('pos_currencies');
            $data = $query->result_array();
            return $data;
        }
        
        $this->db->order_by('id','desc');
        $options = array('id'=> $id);
        
        $query = $this->db->get_where('pos_currencies',$options);
        $data = $query->result_array();
        return $data;
    }
    
    // Call the function to get the currency converted
    function get_currency_rate($from_Currency = '', $to_Currency='', $amount=1) {
        
        return 1;
        
        if($from_Currency != '' && $to_Currency != '')
        {
            if($from_Currency == $to_Currency)
            {
                return 1;
            }else{
                $amount = urlencode($amount);
                $from_Currency = urlencode($from_Currency);
                $to_Currency = urlencode($to_Currency);
            
                $url = "http://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency";
            
                $ch = curl_init();
                $timeout = 0;
                curl_setopt ($ch, CURLOPT_URL, $url);
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            
                curl_setopt ($ch, CURLOPT_USERAGENT,
                             "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
                curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $rawdata = curl_exec($ch);
                curl_close($ch);
                $data = explode('bld>', $rawdata);
                $data = explode($to_Currency, $data[1]);
            
                return round($data[0], 4);
            }
            
        }
        
    }
             
    //get all currencies and also only one currency and active and inactive too.
    public function get_activecurrencies($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            
            $options = array('status'=>1);
        
            $this->db->order_by('id','desc');
            $query = $this->db->get_where('pos_currencies',$options);
            $data = $query->result_array();
            return $data;
        }
        
        $this->db->order_by('id','desc');
        $options = array('id'=> $id,'status'=>1);
        
        $query = $this->db->get_where('pos_currencies',$options);
        $data = $query->result_array();
        return $data;
    }
    
    function getcurrencyDropDown()
    {
        $data = array();
        $data['']= 'Select Currency Account';
        
        $query = $this->db->get_where('pos_currencies',array('status'=>1));
        
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                 $data[$row['id']] = $row['country'] .' - '.$row['code'];
            }
        }
        $query->free_result();
        return $data;
    }
    
   
    function addcurrency()
        {
            $data = array(
            'company_id'=> $_SESSION['company_id'],
            'posting_type_id' => $this->input->post('posting_type_id'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'store_name' => $this->input->post('store_name'),
            'city' => $this->input->post('city'),
            'country' => $this->input->post('country'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'contact' => $this->input->post('contact'),
            'status' => $this->input->post('status')
            );
            $this->db->insert('pos_currencies', $data);
            
            //for logging
            $msg = $this->input->post('posting_type_id',true);
            $this->M_logs->add_log($msg,"currency","added","POS");
            // end logging
        }
        
     function updatecurrency()
        {
            //$file_name = $this->upload->data();
            
            $data = array(
            'company_id'=> $_SESSION['company_id'],
            'posting_type_id' => $this->input->post('posting_type_id'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'store_name' => $this->input->post('store_name'),
            'city' => $this->input->post('city'),
            'country' => $this->input->post('country'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'contact' => $this->input->post('contact'),
            'status' => $this->input->post('status')
            );
            $this->db->update('pos_currencies', $data, array('id'=>$_POST['id']));
            
            
           
        }
    
    public function get_currencyName($currency_id)
    {
        $options = array('id'=> $currency_id);
        
        $query = $this->db->get_where('pos_currencies',$options);
        if($row = $query->row())
        {
            return $row->name .' - '.$row->code;
        }
        
        return '';
    }
    
    function deletecurrency($id)
    {
        $query = $this->db->delete('pos_currencies',array('id'=>$id));
        
        //for logging
            $msg = 'Currency ID '. $id;
            $this->M_logs->add_log($msg,"Currency","Deleted","POS");
            // end logging
    }
    
    function inactivate($id)
    {
        $query = $this->db->update('pos_currencies',array('status'=>0),array('id'=>$id));
          //for logging
            $msg = 'Currency ID '. $id;
            $this->M_logs->add_log($msg,"Currency","Inactivated","POS");
            // end logging
    }
    
    function activate($id)
    {
        $query = $this->db->update('pos_currencies',array('status'=>1),array('id'=>$id));
         //for logging
            $msg = 'Currency ID '. $id;
            $this->M_logs->add_log($msg,"Currency","Activated","POS");
            // end logging
    }
}


?>