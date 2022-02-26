<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class C_workorders extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }
    
    function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'List of work orders';
        $data['main'] = 'List of work orders';
        
        $data['workorders'] = $this->M_workorders->get_workorder();
        
        $this->load->view('templates/header',$data);
        $this->load->view('mfg/workorders/v_workorders',$data);
        $this->load->view('templates/footer');
    }
    
    function workorderDetail($id,$reference)
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Work Order # '.$reference;
        $data['main'] = '';// 'Work Order # '.$reference;
        $data['reference'] = $reference;
        $data['id'] = $id;
        
        $data['wo_detail'] = $this->M_workorders->get_workorder($id);
        
        $this->load->view('templates/header',$data);
        $this->load->view('mfg/workorders/v_wo_detail',$data);
        $this->load->view('templates/footer');
    }

    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));
        
        if($this->input->server('REQUEST_METHOD') === 'POST')
        {            
            //form Validation
            // $this->form_validation->set_rules('mfg_item_id', 'Item', 'required');
            // $this->form_validation->set_rules('type', 'Type', 'required');
            // $this->form_validation->set_rules('qty', 'Quantity', 'required');
            // $this->form_validation->set_rules('date', 'Date', 'required');
            // $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            
            //after form Validation run
            // if($this->form_validation->run())
            // {

            $this->db->trans_start();
                
                $qty = $this->input->post('qty');
                $mfg_item_id = $this->input->post('mfg_item_id');
                $date = $this->input->post('date');
                $reference = $this->input->post('reference');
                $description = $this->input->post('description');
                //type = 2 is Advanced Manufacture
                if ($this->input->post('type') == '2') {
                    $data = array(  
                        'wo_ref'=>$reference,
                        'item_id'=>$mfg_item_id,
                        'type'=>$this->input->post('type'),
                        'units_reqd'=>$qty,
                        'units_issued'=>($this->input->post('type') == '0' ? $qty : -$qty),//TYPE 0=ASSEMBLE, 1=UNASSMBLE
                        'date'=>$date,
                        'required_by'=>$date,
                        'released_date'=>$date,
                        'company_id'=> $_SESSION['company_id']
                       );
                    
                    if($this->db->insert('mfg_workorders',$data))
                        {
                            //for logging
                            $msg = $this->input->post('reference',true);
                            $this->M_logs->add_log($msg,"workorder","added","MFG");
                            // end logging     

                            $this->db->trans_complete();
                            return true;
                            // $this->session->set_flashdata('message','workorder Added');
                        }else{
                                $data['flash_message'] = false;
                                return false;
                        }
                
                }else {
                    
                $data = array(  
                      'wo_ref'=>$reference,
                      'item_id'=>$mfg_item_id,
                      'type'=>$this->input->post('type'),
                      'units_reqd'=>$qty,
                      'units_issued'=>($this->input->post('type') == '0' ? $qty : -$qty),//TYPE 0=ASSEMBLE, 1=UNASSMBLE
                      'date'=>$date,
                      'required_by'=>$date,
                      'released_date'=>$date,
                      'company_id'=> $_SESSION['company_id']
                     );
                $this->db->insert('mfg_workorders',$data);
                $workorder_id = $this->db->insert_id();

                //$item = $this->M_items->getItemsOptions($mfg_item_id);
                //bill of materials bom items
                $bom_item = $this->M_billofmaterial->get_billofmaterial($mfg_item_id);
                      
                $total_price = 0;
                foreach ($bom_item as $keys => $value) {
                    //////////////
                    //CHANGE QTY of BILL OF MATERIAL (BOM) IN POS_ITEMS_DETAILS TABLE
                    $item_detail = $this->M_items->getItemsOptions($value['component']);
                     
                    //mfg_wo_requirements insertion
                    $data1 = array(  
                        'item_id'=>$value['component'],
                        'workcenter_id'=>$value['workcentre_added'],
                        'units_req'=>$value['quantity'],
                        'unit_cost'=>$item_detail[0]['unit_price'],
                        'units_issued'=>($this->input->post('type') == '0' ? ($qty*$value['quantity']) : -($qty*$value['quantity'])),//TYPE 0=ASSEMBLE, 1=UNASSMBLE
                        'workorder_id'=>$workorder_id,
                        'company_id'=> $_SESSION['company_id']
                    );
                    $this->db->insert('mfg_wo_requirements',$data1);
                    ///////////////////////

                    $data_qty = array( 
                        //ADD / SUBTRACT THE BOM QUANTITY FROM ITEM QUANTITY
                        'quantity'=>($item_detail[0]['quantity']+($this->input->post('type') == '0' ? -($qty*$value['quantity']) : ($qty*$value['quantity'])))//TYPE 0=ASSEMBLE, 1=UNASSMBLE
                    );
                    $this->db->update('pos_items_detail',$data_qty,array('item_id' => $value['component']));
                    
                    $total_price += ($item_detail[0]['unit_price']*$value['quantity']);
                    ///////////////////////

                        //ADD ITEM DETAIL IN INVENTORY TABLE    
                        $data1= array(
                            'trans_item'=>$value['component'],
                            'trans_comment'=>'KSMFG',
                            'trans_inventory'=> ($this->input->post('type') == '0' ? -($qty*$value['quantity']) : ($qty*$value['quantity'])),
                            'company_id'=> $_SESSION['company_id'],
                            'trans_user'=> $_SESSION['user_id'],
                            'invoice_no'=> $reference,
                            'cost_price'=>0,//actually its avg cost comming from sale from
                            'unit_price'=>0,
                            
                            );
                            
                        $this->db->insert('pos_inventory', $data1);
                        //////////////
                }
                    //////////////
                    //ADD QTY of BILL OF MATERIAL (BOM) IN POS_ITEMS_DETAILS TABLE
                    $item_detail1 = $this->M_items->getItemsOptions($mfg_item_id);
                    
                        /////////////
                        //JOURNAL ENTRIES
                        $total_amount = $total_price;
                        $dr_ledger_id = ($this->input->post('type') == '0' ? $item_detail1[0]['wip_acc_code'] : $item_detail1[0]['inventory_acc_code']);
                        $cr_ledger_id = ($this->input->post('type') == '0' ? $item_detail1[0]['inventory_acc_code'] : $item_detail1[0]['wip_acc_code']);
                        $narration = $description;
                        $new_invoice_no = $reference;
                        $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$new_invoice_no,$date);
                        
                        if($this->input->post('labour_cost') != '')
                        {
                            $total_amount = $this->input->post('labour_cost');
                            $dr_ledger_id = $item_detail1[0]['wip_acc_code'];
                            $cr_ledger_id = $this->input->post('labour_cost_ac');
                            $narration = $description;
                            $new_invoice_no = $reference;
                            $entry_id = $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$new_invoice_no,$date);
                            
                                //mfg_wo_costing insertion
                                $data1 = array(  
                                    'workorder_id'=>$workorder_id,
                                    'amount'=>$this->input->post('labour_cost'),
                                    'entry_id'=>$entry_id,
                                    'date'=>$date,
                                    'cost_type'=>0,//type 0=labout cost 1=overhead cost
                                    'company_id'=> $_SESSION['company_id']
                                );
                                $this->db->insert('mfg_wo_costing',$data1);
                                ///////////////////////
                        }
                        
                        if($this->input->post('overhead_cost') != '')
                        {
                            $total_amount = $this->input->post('overhead_cost');
                            $dr_ledger_id = $item_detail1[0]['wip_acc_code'];
                            $cr_ledger_id =$this->input->post('overhead_cost_ac');
                            $narration = $description;
                            $new_invoice_no = $reference;
                            $entry_id = $this->M_entries->addEntries($dr_ledger_id,$cr_ledger_id,$total_amount,$total_amount,ucwords($narration),$new_invoice_no,$date);
                               
                                //mfg_wo_costing insertion
                                $data1 = array(  
                                    'workorder_id'=>$workorder_id,
                                    'amount'=>$this->input->post('overhead_cost'),
                                    'entry_id'=>$entry_id,
                                    'date'=>$date,
                                    'cost_type'=>1,//type 0=labout cost 1=overhead cost
                                    'company_id'=> $_SESSION['company_id']
                                );
                                $this->db->insert('mfg_wo_costing',$data1);
                                ///////////////////////
                        }
                        /////////////////////

                    $data_qty1 = array(  
                        'quantity'=>($item_detail1[0]['quantity']+($this->input->post('type') == '0' ? $qty : -$qty))
                    );
                    $this->db->update('pos_items_detail',$data_qty1,array('item_id' => $mfg_item_id));
                    ///////////////////////
                    
                    //ADD ITEM DETAIL IN INVENTORY TABLE    
                    $data1= array(
                        'trans_item'=>$mfg_item_id,
                        'trans_comment'=>'KSMFG',
                        'trans_inventory'=> ($this->input->post('type') == '0' ? $qty : -$qty),
                        'company_id'=> $_SESSION['company_id'],
                        'trans_user'=> $_SESSION['user_id'],
                        'invoice_no'=> $reference,
                        'cost_price'=>0,//actually its avg cost comming from sale from
                        'unit_price'=>0,
                        
                        );
                        
                    $this->db->insert('pos_inventory', $data1);
                    //////////////
                
                    //mfg_wo_manufacture insertion
                $data2 = array(
                        'reference'=>$reference,
                        'workorder_id'=>$workorder_id,
                        'quantity'=>($this->input->post('type') == '0' ? $qty : -$qty),
                        'date_'=>$date,
                        'company_id'=> $_SESSION['company_id']
                       );
                    
                if($this->db->insert('mfg_wo_manufacture',$data2))
                {
                        //for logging
                        $msg = $this->input->post('reference',true);
                        $this->M_logs->add_log($msg,"workorder","added","MFG");
                        // end logging     

                        $this->db->trans_complete();
                        return true;
                        // $this->session->set_flashdata('message','workorder Added');
                }else{
                        $data['flash_message'] = false;
                        return false;
                }
            }//type 2
                
            //$this->M_workorders->add_workorder();
            
            //redirect('mfg/C_workorders/index','refresh');
        // }
        }
        
        $data['title'] = 'Add New Workorder';
        $data['main'] = 'Add New Workorder';
        
        $data['mfg_items'] = $this->M_items->getItemDropDown('manufactured');
        $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'],$data['langs']);
            
        $this->load->view('templates/header',$data);
        $this->load->view('mfg/workorders/create',$data);
        $this->load->view('templates/footer');
    }
    
    
    function delete($id)
    {
        $this->M_workorders->delete_workorder($id);
        $this->session->set_flashdata('message','Workorder Deleted');
        redirect('mfg/C_workorders/index','refresh');
    }

    public function checkItemQty($item_id,$qty)
    {
        echo $this->M_workorders->check_bom_stock($item_id,$qty);    
    }

    public function getMAXReferenceNo()
    {
        echo $this->M_workorders->getMAXReferenceNo();
    }

    public function item_exist_in_bom($item_id)
    {
        if($this->M_billofmaterial->item_exist_in_bom($item_id))
        {
            echo true;
        }else {
            echo false;
        }
    }
}