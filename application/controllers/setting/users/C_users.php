<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_users extends MY_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
  
    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'List of Users';
        $data['main'] = 'List of Users';
        
        $data['users'] = $this->M_users->get_activeUsers();
            
        $this->load->view('templates/header',$data);
        $this->load->view('users/v_users',$data);
        $this->load->view('templates/footer');
    }
    
    
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            
            //form Validation
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('role', 'Role', 'required');
            $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[3]|max_length[12]|callback_username_check'
            );
            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[3]',array('required' => 'You must provide a %s.'));
            $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            ///$this->form_validation->set_rules(')
            
            //after form Validation run
            if($this->form_validation->run()){
                
                $this->M_users->addUser();//only update username and password in emp table
                $this->session->set_flashdata('message','User Credentails Created');
                redirect('setting/users/C_users','refresh');
            }else{
                echo 'error';
            }
              
        }
        
        $data['title'] = 'Add New User';
        $data['main'] = 'Add New User';
        
        $data['activeModules'] = $this->M_modules->get_modulesByParent();
     
        $this->load->view('templates/header',$data);
        $this->load->view('users/create',$data);
        $this->load->view('templates/footer');
        
    }
    
    //FOR INTERNAL USER CHECK
    function username_check($username)
    {
        if($this->M_users->username_exist($username))
        {
            $this->form_validation->set_message('username_check', 'The {field} already exists.');
                        
            return false;
        }else
        {
            return true;
        }
    }
    
    
     //edit 
    public function editUser($user_id=NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form Validation
            if($this->M_users->username_exist($this->input->post('username',true)))
            {
                $this->form_validation->set_rules('username', 'Username Exist', 'required');
            }
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('role', 'Role', 'required');
            $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[3]|max_length[12]'
            );
            //$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[3]',array('required' => 'You must provide a %s.'));
            //$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            ///$this->form_validation->set_rules(')
            
            //after form Validation run
            if($this->form_validation->run()){
          
            $this->M_users->updateUser();
            $this->session->set_flashdata('message','User Credentails Updated');
            redirect('setting/users/C_users','refresh');
            }
              
        }
          $data['title'] = 'Update User';
            $data['main'] = 'Update User';
            
            $data['activeModules'] = $this->M_modules->get_modulesByParent();
            $data['users'] = $this->M_users->get_activeUsers($user_id);
       
           // $data['cities'] = $this->M_city->getCitiesDropDown();
                
            $this->load->view('templates/header',$data);
            $this->load->view('users/edit',$data);
            $this->load->view('templates/footer');
        
    }

public function change_password($user_id=NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[3]',array('required' => 'You must provide a %s.'));
            $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            ///$this->form_validation->set_rules(')
            
            //after form Validation run
            if($this->form_validation->run()){
          
            $this->M_users->updateUser_password();
            $this->session->set_flashdata('message','User Password Updated');
            redirect('setting/users/C_users','refresh');
            }
              
        }
          $data['title'] = 'Change Password';
            $data['main'] = 'Change Password';
            
            //$data['activeModules'] = $this->M_modules->get_modulesByParent();
            $data['users'] = $this->M_users->get_activeUsers($user_id);
       
           // $data['cities'] = $this->M_city->getCitiesDropDown();
                
            $this->load->view('templates/header',$data);
            $this->load->view('users/v_pwd_change',$data);
            $this->load->view('templates/footer');
        
    }
    
    function delete($user_id)
    {
        $this->M_users->deleteUser($user_id);
        $this->session->set_flashdata('message','User Deleted');
        redirect('setting/users/C_users','refresh');
    }
}