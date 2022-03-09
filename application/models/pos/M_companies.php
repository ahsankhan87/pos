<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_companies extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    //get all companies and also only one companies and active and inactive too.
    public function get_companies($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            
            $this->db->order_by('id','desc');
            $query = $this->db->get('companies');
            $data = $query->result_array();
            return $data;
        }
        
        $this->db->order_by('id','desc');
        $options = array('id'=> $id);
        
        $query = $this->db->get_where('companies',$options);
        $data = $query->result_array();
        return $data;
    }
    
    //get all companies and also only one companies and active and inactive too.
    public function get_activeCompanies($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            
            $options = array('status'=>'active');
        
            $this->db->order_by('id','desc');
            $query = $this->db->get_where('companies',$options);
            $data = $query->result_array();
            return $data;
        }
        
        $this->db->order_by('id','desc');
        $options = array('id'=> $id,'status'=>'active');
        
        $query = $this->db->get_where('companies',$options);
        $data = $query->result_array();
        return $data;
    }
    
    function getCompaniesDropDown()
    {
        $data = array();
        $data[0]= 'Select companies';
        
        $query = $this->db->get('companies');
        
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                 $data[$row['id']] = $row['name'];
            }
        }
        $query->free_result();
        return $data;
    }
    
    //get active companies if id is provided then one record will be loaded.
    //this companies images will show on front page.
    public function get_companies_images($id)
    {
        
        $this->db->select('id, url, fk_real_estate_id');
        $options = array('fk_real_estate_id'=> $id);
       
        $query = $this->db->get_where('companies_images',$options);
        $data = $query->result_array();
       
        return $data;
    }
    
    //get companies by search 
    public function search($search){
        
        $this->db->like('name',$search);
        $options = array('status'=>'active');
        $query = $this->db->get_where('companies',$options);
        $data = $query->result_array();
        return $data;
    }
    
    
    function addCompany($data)
    {
        
        $this->db->insert('companies', $data);
    
        //$_SESSION['company_id'] = $this->db->insert_id();
        //create calendar for store
       // $this->M_pos_reports->fill_calendar($this->input->post('fy_start'), $this->input->post('fy_end'));
        
            //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"Company","Added","POS");
            // end logging
    }
            
    function updateCompany()
    {
    //$file_name = $this->upload->data();
    //$expire=time()+60*60*24*2; // 2 days
    
    $data = array(
    'name' => $this->input->post('name',true),
    'tax_no' => $this->input->post('tax_no'),
    //'password' => $this->input->post('password'),
    'email' => $this->input->post('email',true),
    'address' => $this->input->post('address',true),
    'contact_no' => $this->input->post('contact_no',true),
    //'status' => $this->input->post('status'),
    //'fy_start' => $this->input->post('fy_start'),
    //'fy_end' => $this->input->post('fy_end'),
    //'currency_symbol' => $this->input->post('currency_symbol'),
    'currency_id' => $this->input->post('currency_id',true),
    "image" =>	$_FILES['upload_pic']['name']
    //'is_multi_currency' => $this->input->post('is_multi_currency')
    //'expire' => $expire,
    //'locked' => 1
    );
    $this->db->update('companies', $data, array('id'=>$this->input->post('id',true)));
    
            //for logging
            $msg = $this->input->post('name',true);
            $this->M_logs->add_log($msg,"Company","Updated","POS");
            // end logging
    }
     
    function deleteCompany($id)
    {
        $query = $this->db->delete('companies',array('id'=>$id));
    }
    
    function inactivate($id)
    {
        $query = $this->db->update('companies',array('status'=>'inactive'),array('id'=>$id));
    }
    
    function activate($id)
    {
        $query = $this->db->update('companies',array('status'=>'active'),array('id'=>$id));
    }
    
    public function checkUsername($username)
    {
        $this->db->where('username',$username);
        $query = $this->db->get('users');
        
        if ($query->num_rows() > 0)
        {
            return true;
        }
            
            return false;
    }
}