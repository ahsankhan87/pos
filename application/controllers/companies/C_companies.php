<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_companies extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
       $this->lang->load('index');
    } 
    

    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Manage companies';
        $data['main'] = 'Manage companies';
        
        $data['companies']= $this->M_companies->get_companies();
        
        $this->load->view('templates/header',$data);
        $this->load->view('companies/v_companies',$data);
        $this->load->view('templates/footer');
    }
    
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->post('name'))
        {
            //////////////////////////////////
            //upload images of the Company..
            //$config['upload_path'] = './images/Company-images';
//            $config['allowed_types'] = 'gif|jpg|png|jpeg';
//            $config['max_size']	= '2000';
//            $config['max_width'] = '2048';
//            $config['max_height'] = '1024';
//            $config['file_name'] = 'img'. time();
//            
//            $this->upload->initialize($config);
//            
//            //if not uploaded then display error
//            if(!$this->upload->do_upload('Company_image'))
//            {
//               
//                $data['errors'] = $this->upload->display_errors();
//                $this->session->set_flashdata('message',$data['errors']);
//                redirect('pos/C_companies/create','refresh');
//            }
//            else
//            {
//                $data['upload_data'] = $this->upload->data();
//                $file_name = $this->upload->data();
//                
//              //creating thumbnail image of the uploaded image.
//                        $config['image_library'] = 'gd2';
//                        $config['source_image']	= './images/Company-images/'.$file_name['file_name'];
//                        $config['new_image'] = './images/Company-images/thumbs';
//                        //$config['create_thumb'] = TRUE;
//                        $config['maintain_ratio'] = false;
//                        $config['width']	= 300;
//                        $config['height']	= 200;
//                        
//                        //$this->load->library('image_lib', $config); 
//                        $this->image_lib->initialize($config); 
//                        $this->image_lib->resize();
            ////////////////////////////////////
                 
                
            $this->M_companies->addCompany();
            $this->session->set_flashdata('message','Company Created');
            redirect('companies/C_companies/index','refresh');
            
          //  }
        }
        else
        {
            $data['title'] = 'Create Company';
            $data['main'] = 'Create New Company';
            
            $this->load->view('templates/header',$data);
            $this->load->view('companies/create',$data);
            $this->load->view('templates/footer');
        }
    }
    //edit category
    public function edit($id=NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->post('name'))
        {
            //////////////////////////////////
            //upload images of the Company..
            //$config['upload_path'] = './images/Company-images';
//            $config['allowed_types'] = 'gif|jpg|png|jpeg';
//            $config['max_size']	= '2000';
//            $config['max_width'] = '2048';
//            $config['max_height'] = '1024';
//            $config['file_name'] = 'img'. time();
//            
//            $this->upload->initialize($config);
//            
//            //if not uploaded then display error
//            if(!$this->upload->do_upload('Company_image'))
//            {
//               
//                $data['errors'] = $this->upload->display_errors();
//                $this->session->set_flashdata('message',$data['errors']);
//                redirect('pos/companies/edit','refresh');
//            }
//            else
//            {
//                $data['upload_data'] = $this->upload->data();
//                $file_name = $this->upload->data();
//                
//              //creating thumbnail image of the uploaded image.
//                        $config['image_library'] = 'gd2';
//                        $config['source_image']	= './images/Company-images/'.$file_name['file_name'];
//                        $config['new_image'] = './images/Company-images/thumbs/';
//                        //$config['create_thumb'] = TRUE;
//                        $config['maintain_ratio'] = false;
//                        $config['width']	= 280;
//                        $config['height']	= 200;
//                        
//                        //$this->load->library('image_lib', $config); 
//                        $this->image_lib->initialize($config); 
//                        $this->image_lib->resize();
            ////////////////////////////////////
            
            
            $this->M_companies->updateCompany();
            $this->session->set_flashdata('message','Company Updated');
            redirect('companies/C_companies/edit','refresh');
           // }
        }
        else
        {
            $data['title'] = 'Update Company';
            $data['main'] = 'Update Company Profile';
            
           
            $data['Company'] = $this->M_companies->get_companies($id);
            
            $this->load->view('templates/header',$data);
            $this->load->view('companies/edit',$data);
            $this->load->view('templates/footer');
        }
    }
    
    //FOR REGISTER ACCOUNT PAGE
    function hasLoginUsername()
    {
        $username = $this->input->post('u_name');
        return 'ahsan';
        if($this->M_companies->checkUsername($username))
        {
            //echo json_encode('This username is already taken! Try another.');
            echo 'true';
        }else
        {
            echo 'false';
        }
        
    }
    
    function delete($id)
    {
        $this->M_companies->deleteCompany($id);
        $this->session->set_flashdata('message','Company Deleted');
        redirect('companies/C_companies/index','refresh');
    }
    
    function inactivate($id) // it will inactive the page
    {
        $this->M_companies->inactivate($id);
        $this->session->set_flashdata('message','Company Inactivated');
        redirect('companies/C_companies/index','refresh');
    }
    
    function activate($id) // it will active 
    {
        $this->M_companies->activate($id);
        $this->session->set_flashdata('message','Company Activated');
        redirect('companies/C_companies/index','refresh');
    }
    
    
}