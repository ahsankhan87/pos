<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_employees extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
       $this->lang->load('index');
    } 
    

    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('listof').' ' .lang('employees');
        $data['main'] = lang('listof').' ' .lang('employees');
        
        $data['employees']= $this->M_employees->get_activeEmployees();
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/employees/v_employees',$data);
        $this->load->view('templates/footer');
    }
    
    function empDetail($emp_id)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('employee').' ' .lang('detail');
        $data['main'] = lang('employee').' ' .lang('detail');
        
        $data['emp_detail']= $this->M_employees->get_employees($emp_id);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/employees/v_empDetail',$data);
        $this->load->view('templates/footer');
    }
    
    function empSalesReport($emp_id)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('employee').' ' .lang('detail');
        $data['main'] = lang('employee').' ' .lang('detail');
        
        $data['emp_detail']= $this->M_employees->get_employees($emp_id);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/employees/v_emp_sales_report',$data);
        $this->load->view('templates/footer');
    }
    
    function makePayment()
    {
        $employee_id = $this->input->post('employee_id');
           
       //PAY CASH TO SUPPLIER AND REDUCE PAYABLES
       $cr_account = $this->input->post('cash_acc_code');
       $dr_account = $this->input->post('salary_acc_code');
       
        if($cr_account && $dr_account && $this->input->post('amount'))
        {
            $this->db->trans_start();
            
           //GET PREVIOISE INVOICE NO  
           @$prev_invoice_no = $this->M_employees->getMAXEmpInvoiceNo();
           $number = (int) substr($prev_invoice_no,2)+1; // EXTRACT THE LAST NO AND INCREMENT BY 1
           $new_invoice_no = 'SP'.$number;

           $dr_amount = $this->input->post('amount', true);
           $cr_amount = $this->input->post('amount', true);
           $narration = $this->input->post('narration', true);
           
           $this->M_entries->addEntries($dr_account,$cr_account,$dr_amount,$cr_amount,$narration,$new_invoice_no);
           
           //for cusmoter payment table
           $this->M_employees->addEmployeePaymentEntry($dr_account,$cr_account,0,$cr_amount,$employee_id,$narration,$new_invoice_no,null);
           $this->db->trans_complete();        
           ///
           
           $this->session->set_flashdata('message','Salary Paid Successfully');
           redirect('pos/C_employees/paymentModal/'.$employee_id,'refresh');
        }
        else
        {
            $this->session->set_flashdata('error','Salary Not Paid. It seem that you did not assign account code to employee.');
            redirect('pos/C_employees/paymentModal/'.$employee_id,'refresh');
        }
         
    }
    
    function paymentModal($emp_id)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = lang('listof').' ' .lang('employees');
        $data['main'] = lang('listof').' ' .lang('employees');
        
        //$data['cities'] = $this->M_city->get_city();
        $data['employee']= $this->M_employees->get_employees($emp_id);
        //$data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id']);//search for legder account
        $data['employee_entries']= $this->M_employees->get_employee_Entries($emp_id,FY_START_DATE,FY_END_DATE);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/employees/paymentModal',$data);
        $this->load->view('templates/footer');
    }
    
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            
            //form Validation
            $this->form_validation->set_rules('salary_acc_code', 'Salary Account', 'required');
            $this->form_validation->set_rules('cash_acc_code', 'Cash Account', 'required');
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
                $data = array(
                'company_id'=> $_SESSION['company_id'],
                'salary_acc_code' => $this->input->post('salary_acc_code', true),
                'cash_acc_code' => $this->input->post('cash_acc_code', true),
                'first_name' => $this->input->post('first_name', true),
                'last_name' => $this->input->post('last_name', true),
                //'username' => $this->input->post('username', true),
                //'password' => $this->input->post('password', true),
                'city' => $this->input->post('city', true),
                'country' => $this->input->post('country', true),
                'email' => $this->input->post('email', true),
                'address' => $this->input->post('address', true),
                'contact' => $this->input->post('contact', true),
                'job_type' => $this->input->post('job_type', true),
                'hire_date' => $this->input->post('hire_date', true),
                'father_name' => $this->input->post('father_name', true),
                'cnic' => $this->input->post('cnic', true),
                'status' => 'active',
                'area_id' => $this->input->post('area_id', true)
                
                );
                //$this->db->insert('pos_employees', $data);
            
                if($this->db->insert('pos_employees', $data)){
                    
                    //for logging
                    $msg = $this->input->post('first_name'). ' '. $this->input->post('last_name');
                    $this->M_logs->add_log($msg,"Employee","Added","POS");
                    // end logging
                    
                    $this->session->set_flashdata('message','Employee Created');
                }else{
                    $this->session->set_flashdata('error','Employee Not Created');
                }
                 //$this->M_employees->addEmployee();
            
            redirect('pos/C_employees/index','refresh');
            //////////////////////////////////
            //upload images of the employee..
            //$config['upload_path'] = './images/employee-images';
//            $config['allowed_types'] = 'gif|jpg|png|jpeg';
//            $config['max_size']	= '2000';
//            $config['max_width'] = '2048';
//            $config['max_height'] = '1024';
//            $config['file_name'] = 'img'. time();
//            
//            $this->upload->initialize($config);
//            
//            //if not uploaded then display error
//            if(!$this->upload->do_upload('employee_image'))
//            {
//               
//                $data['errors'] = $this->upload->display_errors();
//                $this->session->set_flashdata('message',$data['errors']);
//                redirect('pos/C_employees/create','refresh');
//            }
//            else
//            {
//                $data['upload_data'] = $this->upload->data();
//                $file_name = $this->upload->data();
//                
//              //creating thumbnail image of the uploaded image.
//                        $config['image_library'] = 'gd2';
//                        $config['source_image']	= './images/employee-images/'.$file_name['file_name'];
//                        $config['new_image'] = './images/employee-images/thumbs';
//                        //$config['create_thumb'] = TRUE;
//                        $config['maintain_ratio'] = false;
//                        $config['width']	= 300;
//                        $config['height']	= 200;
//                        
//                        //$this->load->library('image_lib', $config); 
//                        $this->image_lib->initialize($config); 
//                        $this->image_lib->resize();
            ////////////////////////////////////
            
            }
        }
        //else
        //{
            $data['title'] = lang('add_new').' ' .lang('employee');
            $data['main'] = lang('add_new').' ' .lang('employee');
            
            //$data['areaDDL'] = $this->M_areas->get_activeareasDDL();
            $data['categoryDDL'] = $this->M_category->getCategoriesDropDown();
            $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);//search for legder account
            $data['activeModules'] = $this->M_modules->get_modulesByParent();
        
               
            $this->load->view('templates/header',$data);
            $this->load->view('pos/employees/create',$data);
            $this->load->view('templates/footer');
        //}
    }
    //edit category
    public function edit($id=NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form Validation
            $this->form_validation->set_rules('salary_acc_code', 'Salary Account', 'required');
            $this->form_validation->set_rules('cash_acc_code', 'Cash Account', 'required');
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
                $file_name = $this->upload->data();
            
                $data = array(
                'company_id'=> $_SESSION['company_id'],
                'salary_acc_code' => $this->input->post('salary_acc_code'),
                'cash_acc_code' => $this->input->post('cash_acc_code'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                //'username' => $this->input->post('username'),
                //'password' => $this->input->post('password'),
                'city' => $this->input->post('city'),
                'country' => $this->input->post('country'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'contact' => $this->input->post('contact'),
                'job_type' => $this->input->post('job_type', true),
                'hire_date' => $this->input->post('hire_date', true),
                'father_name' => $this->input->post('father_name', true),
                'cnic' => $this->input->post('cnic', true),
                'area_id' => $this->input->post('area_id', true),
                
                );
                //$this->db->update('pos_employees', $data, array('id'=>$_POST['id']));
            
                if($this->db->update('pos_employees', $data, array('id'=>$_POST['id']))){
                    
                     //for logging
                    $msg = $this->input->post('first_name'). ' '. $this->input->post('last_name');
                    $this->M_logs->add_log($msg,"Employee","Updated","POS");
                    // end logging
                    
                    $this->session->set_flashdata('message','Employee Updated');
                }else{
                    $this->session->set_flashdata('message','Employee Not Updated');
                }
            //////////////////////////////////
            //upload images of the employee..
            //$config['upload_path'] = './images/employee-images';
//            $config['allowed_types'] = 'gif|jpg|png|jpeg';
//            $config['max_size']	= '2000';
//            $config['max_width'] = '2048';
//            $config['max_height'] = '1024';
//            $config['file_name'] = 'img'. time();
//            
//            $this->upload->initialize($config);
//            
//            //if not uploaded then display error
//            if(!$this->upload->do_upload('employee_image'))
//            {
//               
//                $data['errors'] = $this->upload->display_errors();
//                $this->session->set_flashdata('message',$data['errors']);
//                redirect('pos/employees/edit','refresh');
//            }
//            else
//            {
//                $data['upload_data'] = $this->upload->data();
//                $file_name = $this->upload->data();
//                
//              //creating thumbnail image of the uploaded image.
//                        $config['image_library'] = 'gd2';
//                        $config['source_image']	= './images/employee-images/'.$file_name['file_name'];
//                        $config['new_image'] = './images/employee-images/thumbs/';
//                        //$config['create_thumb'] = TRUE;
//                        $config['maintain_ratio'] = false;
//                        $config['width']	= 280;
//                        $config['height']	= 200;
//                        
//                        //$this->load->library('image_lib', $config); 
//                        $this->image_lib->initialize($config); 
//                        $this->image_lib->resize();
            ////////////////////////////////////
            
            
            //$this->M_employees->updateEmployee();
            //$this->session->set_flashdata('message','Employee Updated');
            redirect('pos/C_employees/index','refresh');
            }
        }
        //else
        //{
            $data['title'] = lang('update').' ' .lang('employee');
            $data['main'] = lang('update').' ' .lang('employee');
            
            //$data['areaDDL'] = $this->M_areas->get_activeareasDDL();
            $data['employee'] = $this->M_employees->get_employees($id);
            $data['categoryDDL'] = $this->M_category->getCategoriesDropDown();
            $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);//search for legder account
            
            
            $this->load->view('templates/header',$data);
            $this->load->view('pos/employees/edit',$data);
            $this->load->view('templates/footer');
        //}
    }
    
    function delete($id)
    {
        $this->M_employees->deleteEmployee($id);
        $this->session->set_flashdata('message','Employee Deleted');
        
                    //for logging
                    $msg = 'Emp id '.$id;
                    $this->M_logs->add_log($msg,"Employee","Deleted","POS");
                    // end logging
                    
        redirect('pos/C_employees/index','refresh');
    }
    
    function inactivate($id) // it will inactive the page
    {
        $this->M_employees->inactivate($id);
        $this->session->set_flashdata('message','Employee Deleted');
        
        //for logging
                    $msg = 'Emp id '.$id;
                    $this->M_logs->add_log($msg,"Employee","Deleted","POS");
                    // end logging
                    
        redirect('pos/C_employees/index','refresh');
    }
    
    function activate($id) // it will active 
    {
        $this->M_employees->activate($id);
        $this->session->set_flashdata('message','Employee Activated');
        
                    //for logging
                    $msg = 'Emp id '.$id;
                    $this->M_logs->add_log($msg,"Employee","activated","POS");
                    // end logging
                    
        redirect('pos/C_employees/index','refresh');
    }
    
    
}