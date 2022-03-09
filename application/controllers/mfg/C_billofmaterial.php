<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class C_billofmaterial extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    function index()
    {   
        $this->create();
        // $data = array('langs' => $this->session->userdata('lang'));
        
        // $data['title'] = 'Bill of Material';
        // $data['main'] = 'Bill of Material';
        
        // //$data['billofmaterial'] = $this->M_billofmaterial->get_billofmaterial();
        
        // $this->load->view('templates/header',$data);
        // $this->load->view('mfg/billofmaterial/v_billofmaterial',$data);
        // $this->load->view('templates/footer');
    }

    function bom_JSON($item_id)
    {
        echo json_encode($this->M_billofmaterial->get_billofmaterialByItemid($item_id));
        
    }

    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            
            //form Validation
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            //after form Validation run
            //if($this->form_validation->run())
           // {
                  $data = array(  
                      'item_id'=>$this->input->post('mfg_item_id'),
                      'component'=>$this->input->post('item_id'),
                      'workcentre_added'=>$this->input->post('workcenter_id'),
                      'quantity'=>$this->input->post('qty'),
                      'company_id'=> $_SESSION['company_id']
                     );
                  
                  if($this->db->insert('mfg_bom',$data)) {
                        
                        //for logging
                        $msg = $this->input->post('name',true);
                        $this->M_logs->add_log($msg,"billofmaterial","added","MFG");
                        // end logging     
                        return true;
                    //$this->session->set_flashdata('message','billofmaterial Added');
                    }else{
                        $data['flash_message'] = false;
                        return false;
                    }
                  
                
            //$this->M_billofmaterial->add_billofmaterial();
            
            //redirect('mfg/C_billofmaterial/index','refresh');
           // }
        }
        
        $data['title'] = 'Add New Bill of Material';
        $data['main'] = 'Add New Bill of Material';
        
        $data['billofmaterial'] = $this->M_billofmaterial->get_billofmaterial();
        $data['items'] = $this->M_items->getItemDropDown();
        $data['mfg_items'] = $this->M_items->getItemDropDown('manufactured');
        $data['workcenter'] = $this->M_workcenters->get_activeworkcentersDDL();

        $this->load->view('templates/header',$data);
        $this->load->view('mfg/billofmaterial/create',$data);
        $this->load->view('templates/footer');
    }
    
    function edit($id = NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form Validation
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            //after form Validation run
            if($this->form_validation->run())
            {
                  $data = array(  
                        'name'=>$this->input->post('name'),
                        'status'=>$this->input->post('status'),
                        'description'=>$this->input->post('description'),
                        'company_id'=> $_SESSION['company_id'],
                        'date_updated'=>date("Y-m-d H:i:s"),
                     );
                  
                  if($this->db->update('mfg_billofmaterial',$data,array('id'=>$this->input->post('id')))) {
                    
                        //for logging
                        $msg = $this->input->post('name',true);
                        $this->M_logs->add_log($msg,"billofmaterial","updated","MFG");
                        // end logging     

                    $this->session->set_flashdata('message','billofmaterial Updated');
                    }else{
                        $data['flash_message'] = false;
                    }
                    
            //$this->M_billofmaterial->update_billofmaterial();
            //$this->session->set_flashdata('message','billofmaterial Updated');
            redirect('mfg/C_billofmaterial/index','refresh');
        }
        }
        $data['title'] = 'Update billofmaterial';
        $data['main'] = 'Update billofmaterial';
        
        $data['update_billofmaterial'] = $this->M_billofmaterial->get_billofmaterial($id);      
        
        $this->load->view('templates/header',$data);
        $this->load->view('mfg/billofmaterial/edit',$data);
        $this->load->view('templates/footer');
    }
    
    function delete($id)
    {
        echo $this->M_billofmaterial->delete_billofmaterial($id);
        //$this->session->set_flashdata('message','billofmaterial Deleted');
        //redirect('mfg/C_billofmaterial/index','refresh');
    }
}