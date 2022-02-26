<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends MY_Controller{
    
    function __construct()
    {
       parent::__construct();
       $this->lang->load('index');
    } 
    
    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        //$this->output->enable_profiler(true);
        
        $data['title'] = lang('listof').' ' .lang('categories');
        $data['main'] = lang('listof').' ' .lang('categories');
        
        //get all categories.
        $data['categories']= $this->M_category->get_category();
        
        //$data['check_cate'] = $this->M_category->get_category(16);
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/category/v_categories',$data);
        $this->load->view('templates/footer');
    }
    
    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->post('name'))
        {
            $this->M_category->addCategory();
            $this->session->set_flashdata('message','Category Created');
            redirect('pos/Categories/index','refresh');
        }
        else
        {
            $data['title'] = lang('add_new').' ' .lang('category');
            $data['main'] = lang('add_new').' ' .lang('category');
            
            $data['categories'] = $this->M_category->getTopCategories();
            
            $this->load->view('templates/header',$data);
            $this->load->view('pos/category/create',$data);
            $this->load->view('templates/footer');
        }
    }
    
    //edit category
    public function edit($id=NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->post('name'))
        {
            $this->M_category->updateCategory();
            $this->session->set_flashdata('message','Category Updated');
            redirect('pos/Categories/index','refresh');
        }
        else
        {
            $data['title'] = lang('update').' ' .lang('category');
            $data['main'] = lang('update').' ' .lang('category');
            
            $data['categories'] = $this->M_category->getTopCategories();
            $data['category'] = $this->M_category->get_category($id);
            
            $this->load->view('templates/header',$data);
            $this->load->view('pos/category/edit',$data);
            $this->load->view('templates/footer');
        }
    }
    
    function delete($id)
    {
       
        $orphan = $this->M_category->checkOrphanProducts($id);
        
        if(count($orphan))
        {
           $this->session->set_userdata('orphan',$orphan);
           redirect('pos/Categories/reasign/'.$id,'refresh'); 
        }
        else
        {
            $this->M_category->deleteCategory($id);
           $this->session->set_flashdata('message','Category Deleted');
           redirect('pos/categories/index','refresh'); 
        }
        
        
    }
    
    function reasign($id=0)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if ($this->input->post('categories',true))
        {
            $this->M_items->reasign_items();
            $this->M_category->deleteCategory($id);
            $this->session->set_flashdata('message','Category deleted and products reassigned');
            redirect('pos/Categories/index','refresh');
        }
            else{
            $data['category'] = $this->M_category->get_category($id);
            $data['title'] = 'Reassign Products';
            $data['main'] = 'Reassign Products';
            $data['category_id'] = $id;
            
            $data['categories'] = $this->M_category->getCategoriesDropDown();
            
            $this->load->view('templates/header',$data);
            $this->load->view('pos/category/reasign',$data);
            $this->load->view('templates/footer');
        }
    }
}