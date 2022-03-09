<?php
class M_login extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->database();
    }
    
    public function verify($username, $pass)
    {
        //if($role == 'emp')
//        {
//            $_SESSION['role'] = $role;
//            
//            //GET EMPLOYEE ACCOUNT
//            $emp_query = $this->db->get_where('pos_employees',array('username'=>$username, 'password'=>$pass));
//            $row = $emp_query->row();
//                
//                if(isset($row) && $row->status == 'inactive')
//                {
//                    $this->session->set_flashdata('error','Your Account has de-activated. Please contact your Administrator!.');
//                    redirect('C_login','refresh');
//                }
//                else if(isset($row))
//                {
//                    //AND GET COMPANY RECORD VIA EMPLOYEE ID
//                    $this->db->join('pos_currencies cur','cur.id=com.currency_id');
//                    $this->db->select('com.id, username, password,com.name,locked,expire,is_multi_currency,time_zone,cur.code,cur.symbol');
//                    $admin_query = $this->db->get_where('companies com',array('id'=>$row->company_id));
//                }else
//                {
//                    $this->session->set_flashdata('error','Please check role, username and password and try again!.');
//                    redirect('C_login','refresh');
//                }
//            
//        }
        //else if($role == 'admin')
//        {
//            $_SESSION['role'] = $role;
//            
//            //GET COMPANY INFO BY ADMINISTRATOR WITHOUT EMPLOYEE
//            $this->db->join('pos_currencies cur','cur.id=com.currency_id');
//            $this->db->select('com.id, username, password,com.name,locked,expire,is_multi_currency,time_zone,cur.code,cur.symbol');
//            $admin_query = $this->db->get_where('companies com',array('username'=>$username, 'password'=>$pass));
//        }
        
        
       
            //GET EMPLOYEE ACCOUNT
            $emp_query = $this->db->get_where('users',array('username'=>$username, 'password'=>$pass));
            $row = $emp_query->row();
                
                //var_dump($row);
                $admin_query = array();
                
                if(isset($row) && $row->status == 0)
                {
                    $this->session->set_flashdata('error','Your Account has de-activated. Please contact your Administrator!.');
                    redirect('C_login','refresh');
                }
                else if(isset($row))
                {
                    $_SESSION['username'] = $row->username;
                    $_SESSION['user_id'] = $row->id;
                    $_SESSION['full_name'] = $row->name;
                    $_SESSION['role'] = $row->role;
                    
                    //AND GET COMPANY RECORD VIA EMPLOYEE ID
                    //$this->db->join('pos_currencies cur','cur.id=com.currency_id');
                    //$this->db->select('com.id,com.name,locked,expire,is_multi_currency,time_zone,cur.code,cur.symbol');
                    $admin_query = $this->db->get_where('companies com',array('com.id'=>$row->company_id));
                    
                    if($admin_query->num_rows() > 0)
                        {
                            $rows = $admin_query->row_array();
                            
                            //time()+(60*60*24*30); 
                            //$expire_days = ceil(($rows['expire']-time())/60/60/24); 
                            
                            if($rows['locked'] == 1)
                            {
                                
                               if($rows['expire'] < time())
                               {
                                  $this->updateAppLock($rows['id']); //if expire time is less than cur time than set locked = 0
                                  $this->session->set_flashdata('error','Your account has suspended. Please contact your vendor i.e. khybersoft.com');
                                  redirect('C_login','refresh');
                               }
                               else
                               {
                                    //GET CURRENCY CODE AND SYMBOL
                                    $currency_query = $this->db->get_where('pos_currencies',array('id'=>$rows['currency_id']));
                                    $currency = $currency_query->row_array();
                                    /////
                                    
                                    $_SESSION['company_id'] = $rows['id'];
                                    $_SESSION['company_name'] = $rows['name'];
                                    $_SESSION['time_zone'] = $rows['time_zone'];
                                    date_default_timezone_set($_SESSION['time_zone']);
                                    $_SESSION['multi_currency'] = $rows['is_multi_currency'];
                                    $_SESSION['home_currency_code'] = $currency['code'];
                                    $_SESSION['home_currency_symbol'] = $currency['symbol'];
                                   
                                   
                                   //GIVE FINANCIAL YEARS TO SESSION AND THEN 
                                   //ASSIGN IT TO CONSTANT VARIABLES IN MY_CONTROLLER 
                                   $fyear = $this->M_fyear->get_ActiveFyear($_SESSION['company_id']);
                                   $_SESSION['fy_year'] = $fyear[0]['fy_year'];
                                   $_SESSION['fy_start_date'] =$fyear[0]['fy_start_date'];
                                   $_SESSION['fy_end_date'] = $fyear[0]['fy_end_date'];
                                   //////////////////////
                                    
                                    if(isset($_SESSION['company_id']) && isset($_SESSION['user_id']))
                                    {
                                        //for logging
                                        $msg = $this->input->post('username',true);
                                        $this->M_logs->add_log($msg,"User","logged in","Admin");
                                        // end logging    
                            
                                        redirect('Dashboard/C_dashboard','refresh');
                                    }
                               }     
                            }
                            elseif($rows['locked'] == 0)
                            {
                                $this->session->set_flashdata('error','Your trial version has expired. Please contact your vendor.');
                                redirect('C_login','refresh');
                            }
                        }
                        else
                        {
                            $this->session->set_flashdata('error','The user has not assinged company yet');
                            redirect('C_login','refresh');
                        }
                }else
                {
                    $this->session->set_flashdata('error','Please username and password and try again!.');
                    //redirect('C_login','refresh');
                    echo 'Please username and password and try again!.';
                }
            
        
             
    }
    
    private function updateAppLock($id)
    {
        $data = array(
            'locked' => 0
        );
        
        $this->db->update('companies',$data,array('id'=>$id));
    }
    
    
}