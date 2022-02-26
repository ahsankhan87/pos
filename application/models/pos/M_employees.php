<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_employees extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    //get all employees and also only one employee and active and inactive too.
    public function get_employees($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            
            $this->db->order_by('id','desc');
            $query = $this->db->get_where('pos_employees',array('company_id'=> $_SESSION['company_id']));
            $data = $query->result_array();
            return $data;
        }
        
        $this->db->order_by('id','desc');
        $options = array('id'=> $id,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_employees',$options);
        $data = $query->result_array();
        return $data;
    }
    
    public function get_employee_Entries($employee_id,$fy_start_date,$fy_end_date)
    {
        $this->db->group_by('sp.id');
        $this->db->join('acc_groups ac','ac.account_code=sp.account_code');
        $this->db->select('*')->from('pos_employee_payments sp')->where('sp.employee_id', $employee_id);
        $this->db->where('sp.company_id', $_SESSION['company_id']);
        $this->db->where('ac.company_id', $_SESSION['company_id']);
        $this->db->where('date >=', $fy_start_date);
        $this->db->where('date <=', $fy_end_date);

        $query = $this->db->get();
        $data = $query->result_array();
        
        return $data;
    }
    
    public function get_emp_name($id)
    {
        $options = array('id'=> $id,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_employees',$options);
        return $query->row();
    }
    
    public function get_empName($id)
    {
        $options = array('id'=> $id,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_employees',$options);
        if($row = $query->row())
        {
            return $row->first_name .' '.$row->last_name;
        }
        
        return '';
    }
    
    //get all employees and also only one employee and active and inactive too.
    public function get_activeEmployees($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            
            $options = array('status'=>'active','company_id'=> $_SESSION['company_id']);
        
            $this->db->order_by('id','desc');
            $query = $this->db->get_where('pos_employees',$options);
            $data = $query->result_array();
            return $data;
        }
        
        $this->db->order_by('id','desc');
        $options = array('id'=> $id,'status'=>'active','company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_employees',$options);
        $data = $query->result_array();
        return $data;
    }
    
    function addEmployeePaymentEntry($account_code,$dueTo_acc_code,$dr_amount,$cr_amount,$employee_id='',$narration='',$invoice_no='',$date=null)
    {
        $data = array(
                'employee_id' => $employee_id,
                'account_code' => $account_code,
                'dueTo_acc_code' => $dueTo_acc_code,
                'date' => ($date == null ? date('Y-m-d') : $date),
                'debit'=>$dr_amount,
                'credit'=>$cr_amount,
                'invoice_no' => $invoice_no,
                'narration' => $narration,
                'company_id'=> $_SESSION['company_id']
                );
                $this->db->insert('pos_employee_payments', $data);      
                     
    }
    
    function getMAXEmpInvoiceNo()
    {   
        $this->db->order_by('id','desc');
        $query = $this->db->get('pos_employee_payments',1);
        return $query->row()->invoice_no;
    }
    
    function getEmployeeDropDown()
    {
        $data = array();
        $data[0]= 'Select Employee';
        
        $query = $this->db->get_where('pos_employees',array('status'=>'active','company_id'=> $_SESSION['company_id']));
        
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                 $data[$row['id']] = $row['first_name']. ' ' .$row['last_name'];
            }
        }
        $query->free_result();
        return $data;
    }
    
    //get active employees if id is provided then one record will be loaded.
    //this employees images will show on front page.
    public function get_employees_images($id)
    {
        
        $this->db->select('id, url, fk_real_estate_id');
        $options = array('fk_real_estate_id'=> $id);
       
        $query = $this->db->get_where('pos_employees_images',$options);
        $data = $query->result_array();
       
        return $data;
    }
    
    //get employee by search 
    public function search($search){
        
        $this->db->like('name',$search);
        $options = array('status'=>'active','company_id'=> $_SESSION['company_id']);
        $query = $this->db->get_where('pos_employees',$options);
        $data = $query->result_array();
        return $data;
    }
    
    
    function addEmployee()
        {
             
            $data = array(
            'company_id'=> $_SESSION['company_id'],
            'salary_acc_code' => $this->input->post('salary_acc_code'),
            'cash_acc_code' => $this->input->post('cash_acc_code'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'city' => $this->input->post('city'),
            'country' => $this->input->post('country'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'contact' => $this->input->post('contact'),
            'status' => $this->input->post('status')
            );
            $this->db->insert('pos_employees', $data);
            $emp_id = $this->db->insert_id();
            
            //GIVE MODULE PERMISSION
            $modules = $this->input->post('modules');
            foreach($modules as $values)
            {
                $data1 = array(
                'emp_id' => $emp_id,
                'module_id' => $values
                );
                $this->db->insert('pos_emp_modules', $data1);
            }
        }
        
     function updatEemployee()
        {
            $file_name = $this->upload->data();
            
            $data = array(
            'company_id'=> $_SESSION['company_id'],
            'salary_acc_code' => $this->input->post('salary_acc_code'),
            'cash_acc_code' => $this->input->post('cash_acc_code'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'city' => $this->input->post('city'),
            'country' => $this->input->post('country'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'contact' => $this->input->post('contact'),
            'status' => $this->input->post('status')
            );
            $this->db->update('pos_employees', $data, array('id'=>$_POST['id']));
        }
     
     
    function deleteEmployee($id)
    {
        $query = $this->db->delete('pos_employees',array('id'=>$id));
    }
    
    function inactivate($id)
    {
        $query = $this->db->update('pos_employees',array('status'=>'inactive'),array('id'=>$id));
    }
    
    function activate($id)
    {
        $query = $this->db->update('pos_employees',array('status'=>'active'),array('id'=>$id));
    }
}
?>