<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_items_import extends MY_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    public function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Products Imports';
        $data['main'] = 'Products Imports';
       
        $this->load->view('templates/header',$data);
        $this->load->view('pos/items/items_import',$data);
        $this->load->view('templates/footer');
        
    }
    
    public function items_import()
    {
        $config = array();
        $config['upload_path'] = './images';
        $config['allowed_types'] = 'xlsx|xls|csv';
        
        $this->upload->initialize($config);
       
       //var_dump($_FILES);
       
        if(!$this->upload->do_upload('upload_items_import')){
            
                $this->session->set_flashdata('error',$this->upload->display_errors());
                redirect('pos/C_items_import','refresh');
            }
            else
            {
                $upload_data = $this->upload->data();
                @chmod($upload_data['full_path'],0777);
                
                $this->load->library('Excel');
                $this->load->library('IOFactory');
                $objPHPExcel= IOFactory::load($upload_data['full_path']);
                
               echo '<hr />';
                
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                //var_dump($sheetData);
                
                $worksheet = $objPHPExcel->getSheet(0);
        		$lastRow = $worksheet->getHighestRow();
        		
        		$data_excel = array();
                $data_excel_1 = array();
        		for ($row = 2; $row <= $lastRow; $row++) {
        			 echo $worksheet->getCell('A'.$row)->getValue();
        			 echo $worksheet->getCell('B'.$row)->getValue();
        			 
        		}
        		
                //$this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
//                $this->spreadsheet_excel_reader->read($upload_data['full_path']);
//                
//                $sheets = $this->spreadsheet_excel_reader->sheets[0];
//                //var_dump($sheets);
//                $data_excel = array();
//                $data_excel_1 = array();
//                for ($i = 2; $i <= $sheets['numRows']; $i++) {
//                	
//                    if($sheets['cells'][$i][1] == '') break;
//                    
//                    $data_excel[$i - 1]['company_id'] = $_SESSION['company_id'];
//                    $data_excel[$i - 1]['name'] = $sheets['cells'][$i][1];
//                    $data_excel[$i - 1]['item_type'] = $sheets['cells'][$i][2];
//                    $data_excel[$i - 1]['brand'] = $sheets['cells'][$i][3];
//                    $data_excel[$i - 1]['brand'] = $sheets['cells'][$i][6];
//                }
                
               // echo '<pre>';
//                print_r($data_excel);
//                echo '</pre>';
                //$this->db->insert_batch('pos_items',$data_excel);
                                
                @unlink($upload_data['full_path']);
                $die;
            }
    } 
}