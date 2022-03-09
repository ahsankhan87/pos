<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_company extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
       $this->lang->load('index');
    } 
    

    function index($company_id=NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
         if($this->input->post('name'))
        {
            //////////////////////////////////
            //upload upload_pics of the Company..
              if($_FILES['upload_pic']['name'] !== ''){
                      $errors= array();
                      $file_name = $_FILES['upload_pic']['name'];
                      $file_size =$_FILES['upload_pic']['size'];
                      $file_tmp =$_FILES['upload_pic']['tmp_name'];
                      $file_type=$_FILES['upload_pic']['type'];
                      //$file_ext=strtolower(end(explode('.',$_FILES['upload_pic']['name'])));
                      $file_ext=pathinfo($_FILES['upload_pic']['name']); 
                      $expensions= array("jpeg","jpg","png","gif");
                      
                      if(in_array($file_ext['extension'],$expensions)=== false){
                         $this->session->set_flashdata('error', 'extension not allowed, please choose a JPEG or PNG file.');
                         redirect('companies/C_company/', 'refresh');
                      }
                      
                      if($file_size > 2097152){
                        $this->session->set_flashdata('error', 'File size must be excately 2 MB');
                         redirect('companies/C_company/', 'refresh');
                      }
                      
                      if(empty($errors)==true){
                        //FIRST delete picture from folders
                         $picture = $this->input->post('image');
                         @unlink(FCPATH.'images/company/thumb/'.$picture);
                         
                         move_uploaded_file($file_tmp,"images/company/thumb/".$file_name);
                        // echo "Success";
                         //return true;
                      }else{
                         //print_r($errors);
                         //return $errors;
                         $this->session->set_flashdata('error', 'You did not select a file to upload.');
                         redirect('companies/C_company/', 'refresh');
                      }
                   }
                //upload an image options
                 ////////////////////////
            
            $this->M_companies->updateCompany();
            $this->session->set_flashdata('message','Company Updated');
            redirect('C_login/logout','refresh');
           
        }
        else
        {
            $data['title'] = 'Update Company';
            $data['main'] = 'Update Company Profile';
            
            $company_id = $_SESSION['company_id'];
            $data['Company'] = $this->M_companies->get_companies($company_id);
            $data['currencyDropDown'] = $this->M_currencies->getcurrencyDropDown();
             
            $this->load->view('templates/header',$data);
            $this->load->view('companies/company/edit',$data);
            $this->load->view('templates/footer');
        }
    }
}