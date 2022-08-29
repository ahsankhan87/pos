<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Items extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('index');
    }

    public function index()
    {
        $data = array('langs' => $this->session->userdata('lang'));

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '100240M');

        $data['title'] = lang('listof') . ' ' . lang('products');
        $data['main'] = lang('listof') . ' ' . lang('products');


        $data['items'] = $this->M_items->get_allItems();
        //$data['categoryDDL'] = $this->M_category->getCategoriesDropDown();
        //$data['supplierDDL']= $this->M_suppliers->getSupplierDropDown();

        $this->load->view('templates/header', $data);
        $this->load->view('pos/items/view_items1', $data);
        $this->load->view('templates/footer');
    }

    public function LowStock()
    {
        $data = array('langs' => $this->session->userdata('lang'));

        $data['title'] = 'Low Stock Products';
        $data['main'] = 'Low Stock Products';

        $data['items'] = $this->M_items->get_low_stock_items();

        $this->load->view('templates/header', $data);
        $this->load->view('pos/items/v_low_stock', $data);
        $this->load->view('templates/footer');
    }

    public function barcode()
    {
        $data = array('langs' => $this->session->userdata('lang'));

        $data['title'] = 'Barcode';
        $data['main'] = 'Barcode';

        $data['productsDDL'] = $this->M_items->getItemDropDown();

        $this->load->view('templates/header', $data);
        $this->load->view('pos/items/barcode', $data);
        $this->load->view('templates/footer');
    }
    function print_pdf()
    {
        $item_id = $this->input->post('item_id');
        $print_qty = $this->input->post('print_qty');
        $Items = $this->M_items->get_itemDetail($item_id);
        $Company = $this->M_companies->get_companies($_SESSION['company_id']);
        //  var_dump($Company);
        $this->load->library('Pdf');
        // $pdf = new Pdf('P', 'mm', array(50.8, 20), true, 'UTF-8', false);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // $pdf->SetFont ('helvetica', '', $font_size , '', 'default', true );
        //$pdf->SetTitle('Pdf Example');
        //$pdf->SetHeaderMargin(30);
        // $pdf->SetTopMargin(20);
        //$pdf->setFooterMargin(20);
        //$pdf->SetAutoPageBreak(true);
        //$pdf->SetAuthor('Author');
        // $pdf->SetDisplayMode('real', 'default');
        // $pdf->Write(5, 'Product Barcode');
        // set font
        //$pdf->SetFont('helvetica', '', 10);
        $pdf->SetFont('aealarabiya', '', 10);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        for ($i = 1; $i <= $print_qty; $i++) {
            $pdf->AddPage('L', array(50.8, 21));
            $pdf->SetAutoPageBreak(true, 0);

            // Set some content to print
            $product = substr(@$Items[0]['name'], 0, 20);
            $product_id = @$Items[0]['id'];
            $rate = @$_SESSION['home_currency_code'] . ' ' . number_format(@$Items[0]['unit_price']);

            // Print text using writeHTMLCell()
            //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
            if (!empty($Company[0]['image']) || $Company[0]['image'] != '') {
                // $html= '<div style="text-align:top;padding-bottom:100px;background-color:black;">
                // <img src="' . base_url('images/company/thumb/' . $Company[0]['image']) . '" width="30" height="30" alt="picture"/>
                // </div>';
                //$pdf->writeHTML($html, true, false, true, false, '');
                $image = base_url('images/company/thumb/' . $Company[0]['image']);
            }
            $pdf->SetXY(2, 5);
            $pdf->Image($image, '', '', 40, 40, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
            $pdf->Text(25, 3, $product);

            $style = array(
                'border' => 2,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0, 0, 0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );
            $pdf->write1DBarcode($product_id, "C128", 25, 8, 20, 4, $style);
            $pdf->Text(30, 14, $rate);
            //ob_end_clean();
        }
        $pdf->Output('barcode.pdf', 'I');
    }
    public function print_barcode()
    {
        $data = array('langs' => $this->session->userdata('lang'));

        $data['title'] = 'Barcode';
        $data['main'] = '';
        $data['print_qty'] = $this->input->post('print_qty');
        $item_id = $this->input->post('item_id');

        $data['Items'] = $this->M_items->get_itemDetail($item_id);

        $this->load->view('templates/header', $data);
        $this->load->view('pos/items/print_barcode', $data);
        $this->load->view('templates/footer');
    }
    //get item for Drop down list for sale
    function get_items()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '100240M');
        $items = $this->M_items->get_allItemsforJSON();
        //var_dump($items);

        echo json_encode($items);
        // $this->load->view('pos/items/getItems',$data);
    }

    //get all items for purchases
    function get_allItems()
    {
        $data['items'] = $this->M_items->get_allItems();

        echo json_encode($data['items']);
        //$this->load->view('pos/items/getItems',$data);
    }

    function create()
    {
        $data = array('langs' => $this->session->userdata('lang'));

        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            //form Validation
            if ($this->input->post('barcode') != '') {
                $this->form_validation->set_rules('barcode', 'Barcode', 'trim|callback_barcode_check');
            }
            $this->form_validation->set_rules('name', 'Name', 'required');
            //$this->form_validation->set_rules('cost_price', 'Cost Price', 'required');
            //$this->form_validation->set_rules('unit_price', 'Sale Price', 'required');
            $this->form_validation->set_rules('inventory_acc_code', 'Inventory Account', 'required');
            //$this->form_validation->set_rules('brand', 'Brand', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">�</a><strong>', '</strong></div>');
            ///$this->form_validation->set_rules(')

            //after form Validation run
            if ($this->form_validation->run()) {

                if ($_FILES['upload_pic']['name'] != '') {
                    $errors = array();
                    $file_name = $_FILES['upload_pic']['name'];
                    $file_size = $_FILES['upload_pic']['size'];
                    $file_tmp = $_FILES['upload_pic']['tmp_name'];
                    $file_type = $_FILES['upload_pic']['type'];
                    //$file_ext=strtolower(end(explode('.',$_FILES['upload_pic']['name'])));
                    $file_ext = pathinfo($_FILES['upload_pic']['name']);
                    $expensions = array("jpeg", "jpg", "png", "gif");

                    if (in_array($file_ext['extension'], $expensions) === false) {
                        $this->session->set_flashdata('error', 'extension not allowed, please choose a JPEG or PNG file.');
                        redirect('pos/Items/index', 'refresh');
                    }

                    if ($file_size > 2097152) {
                        $this->session->set_flashdata('error', 'File size must be excately 2 MB');
                        redirect('pos/Items/index', 'refresh');
                    }

                    if (empty($errors) == true) {
                        move_uploaded_file($file_tmp, "images/items/thumb/" . $file_name);
                        // echo "Success";
                        //return true;
                    } else {
                        //sprint_r($errors);
                        //return $errors;
                        $this->session->set_flashdata('error', 'You did not select a file to upload.');
                        redirect('pos/Items/index', 'refresh');
                    }
                }
                //upload an image options
                ////////////////////////

                $this->db->trans_start();
                if ($this->M_items->addItems()) {
                    $this->session->set_flashdata('message', 'Product Created Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Product not created please try again');
                }
                $this->db->trans_complete();

                redirect('pos/Items/index', 'refresh');
            }
        }
        //else
        //{
        $data['title'] = lang('add_new') . ' ' . lang('product');
        $data['main'] = lang('add_new') . ' ' . lang('product');

        $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'], $data['langs']); //search for legder account

        $data['categoryDDL'] = $this->M_category->getCategoriesDropDown();
        $data['locationDDL'] = $this->M_locations->get_activelocationsDDL();
        //$data['supplierDDL']= $this->M_suppliers->getSupplierDropDown();
        $data['unitsDDL'] = $this->M_units->get_activeunitsDDL();
        $data['sizes'] = $this->M_sizes->get_activeSizes();
        $data['taxesDDL'] = $this->M_taxes->gettaxDropDown();

        $this->load->view('templates/header', $data);
        $this->load->view('pos/items/create', $data);
        $this->load->view('templates/footer');
        // }
    }

    function barcode_check($barcode)
    {
        if ($this->M_items->barcode_exist($barcode)) {
            $this->form_validation->set_message('barcode_check', 'The {field} already exists.');

            return false;
        } else {
            return true;
        }
    }

    function createService()
    {
        $data = array('langs' => $this->session->userdata('lang'));

        if ($this->input->post('name')) {
            $this->db->trans_start();
            $this->M_items->addItems();
            $this->db->trans_complete();

            $this->session->set_flashdata('message', 'Service Created Successfully');
            redirect('pos/Items/index', 'refresh');
        } else {
            $data['title'] = lang('add_new') . ' ' . lang('service');
            $data['main'] = lang('add_new') . ' ' . lang('service');

            $data['categoryDDL'] = $this->M_category->getCategoriesDropDown();
            $data['taxesDDL'] = $this->M_taxes->gettaxDropDown();
            $data['unitsDDL'] = $this->M_units->get_activeunitsDDL();

            $this->load->view('templates/header', $data);
            $this->load->view('pos/items/services/create', $data);
            $this->load->view('templates/footer');
        }
    }
    function ngCreate()
    {
        // get posted data from angularjs purchases 
        $data_posted = json_decode(file_get_contents("php://input", true));

        if (count($data_posted) > 0) {
            $name = $data_posted->name;
            $reorder_level = $data_posted->reorder_level;
            $iteM_number = $data_posted->iteM_number;
            $iteM_type = $data_posted->iteM_type;
            $cate_id = $data_posted->category_id;
            $company_id = $_SESSION['company_id'];
            // $min_stock = $data_posted->reorder_level;

            $this->M_items->addItems($name, $iteM_number, $reorder_level, $cate_id, $company_id, $iteM_type);
        } else {
            echo 'no data';
        }
    }

    public function ngEdit($id = NULL)
    {
        // get posted data from angularjs purchases 
        $data_posted = json_decode(file_get_contents("php://input", true));
        //print_r($data_posted);

        if (count($data_posted) > 0) {
            $option_data = array(
                'iteM_id' => $data_posted->iteM_id,
                'cost_price' => $data_posted->cost_price, //actually this price is NEW cost price
                'unit_price' => $data_posted->unit_price,
                'quantity' => $data_posted->quantity,
                'avg_cost' => $data_posted->cost_price
            );

            $this->db->update('pos_items_detail', $option_data, array('size_id' => $data_posted->size_id, 'iteM_id' => $data_posted->iteM_id));
        }
    }

    public function edit($id = NULL, $size_id = null)
    {
        $data = array('langs' => $this->session->userdata('lang'));

        if ($this->input->post('name')) {
            //upload an image options
            //var_dump($_FILES);
            //die;
            //IF PICTURE DIDNT SELECT THEN SAVE THE PREV PICTURE ALREADY IN DATABASE
            if ($_FILES['upload_pic']['name'] == '') {
                $new_picture = $this->input->post('picture');
            } else {
                $errors = array();
                $file_name = $_FILES['upload_pic']['name'];
                $file_size = $_FILES['upload_pic']['size'];
                $file_tmp = $_FILES['upload_pic']['tmp_name'];
                $file_type = $_FILES['upload_pic']['type'];
                //$file_ext=strtolower(end(explode('.',$_FILES['upload_pic']['name'])));
                $file_ext = pathinfo($_FILES['upload_pic']['name']);
                $expensions = array("jpeg", "jpg", "png", "gif");

                if (in_array($file_ext['extension'], $expensions) === false) {
                    //$errors[] = 'Extension not allowed, please choose a JPEG or PNG file.';
                    $this->session->set_flashdata('error', 'extension not allowed, please choose a JPEG or PNG file.');
                    redirect('pos/Items/index', 'refresh');
                }

                if ($file_size > 2097152) {
                    //$errors[] = 'File size must be excately 2 MB';
                    $this->session->set_flashdata('error', 'File size must be excately 2 MB');
                    redirect('pos/Items/index', 'refresh');
                }

                if ($_FILES['upload_pic']['error'] == 0) {
                    //FIRST delete picture from folders
                    $new_picture = $file_name;
                    $picture = $this->input->post('picture');
                    FCPATH . 'images/items/thumb/' . $picture;
                    @unlink(FCPATH . 'images/items/thumb/' . $picture);

                    move_uploaded_file($file_tmp, "images/items/thumb/" . $file_name);

                    // echo "Success";
                    //return true;
                } //else{
                //print_r($errors);
                //return $errors;
                //$this->session->set_flashdata('error', 'You did not select a file to upload.');
                // redirect('academics/C_students/', 'refresh');
                //}
            }
            //upload an image options
            ////////////////////////

            $this->M_items->updateItems($new_picture);
            $this->session->set_flashdata('message', 'Product Updated');
            redirect('pos/Items/index', 'refresh');
        } else {
            $data['title'] = lang('update') . ' ' . lang('product');
            $data['main'] = lang('update') . ' ' . lang('product');

            $data['accountDDL'] = $this->M_groups->getGrpDetailDropDown($_SESSION['company_id'], $data['langs']); //search for legder account

            $data['locationDDL'] = $this->M_locations->get_activelocationsDDL();
            $data['categoryDDL'] = $this->M_category->getCategoriesDropDown();
            //$data['sizesDDL'] = $this->M_sizes->get_activeSizesDDL();
            $data['Item'] = $this->M_items->get_itemDetail($id, $size_id);
            $data['unitsDDL'] = $this->M_units->get_activeunitsDDL();
            $data['taxesDDL'] = $this->M_taxes->gettaxDropDown();


            $this->load->view('templates/header', $data);
            $this->load->view('pos/items/edit', $data);
            $this->load->view('templates/footer');
        }
    }

    public function editService($id = NULL)
    {
        $data = array('langs' => $this->session->userdata('lang'));

        if ($this->input->post('name')) {
            $this->M_items->updateItems();
            $this->session->set_flashdata('message', 'Service Updated');
            redirect('pos/Items/index', 'refresh');
        } else {
            $data['title'] = lang('add_new') . ' ' . lang('service');
            $data['main'] = lang('add_new') . ' ' . lang('service');

            $data['categoryDDL'] = $this->M_category->getCategoriesDropDown();
            $data['Item'] = $this->M_items->get_itemDetail($id);
            $data['taxesDDL'] = $this->M_taxes->gettaxDropDown();
            $data['unitsDDL'] = $this->M_units->get_activeunitsDDL();

            $this->load->view('templates/header', $data);
            $this->load->view('pos/items/services/edit', $data);
            $this->load->view('templates/footer');
        }
    }

    public function item_transactions($item_id)
    {
        $data = array('langs' => $this->session->userdata('lang'));

        $data['title'] = 'Product Transactions History';
        $data['main'] = 'Product Transactions History';

        $data['items'] = $this->M_items->get_item_history($item_id);

        $this->load->view('templates/header', $data);
        $this->load->view('pos/items/v_item_transaction', $data);
        $this->load->view('templates/footer');
    }

    function delete($id, $inventory_acc_code, $total_cost = 0, $size_id = 0)
    {
        $this->db->trans_start();
        $this->M_items->deleteItem($id, $inventory_acc_code, $total_cost, $size_id);
        $this->db->trans_complete();

        $this->session->set_flashdata('message', 'Product Deleted / inactive');
        redirect('pos/Items/index', 'refresh');
    }

    function getProductsJSON()
    {
        //print_r(json_encode($this->M_customers->get_activeCustomers()));
        $lang = array('langs' => $this->session->userdata('lang'));

        $data = $this->M_items->get_allItems();

        $outp = "";
        foreach ($data as $rs) {
            //$tm =  json_decode($rs["teams_id"]);
            //print_r($tm);

            if ($outp != "") {
                $outp .= ",";
            }

            $outp .= '["'  . $rs["item_id"] . '",';
            $outp .= "\"<a href='" . site_url($lang['langs']) . "/pos/Items/item_transactions/" . $rs['item_id'] . "'>" . $rs['name'] . ' ' . $rs['size'] . "</a>\",";

            //$outp .= '"'   . trim($rs["name"]). '",';

            // if($rs['service'] == 1)
            // {
            //     $outp .= '"Service",';
            // }else { 
            //     $outp .= '"Product",'; 
            //     }
            $outp .= '"' . $rs["item_type"]     . '",';
            $outp .= '"'   . trim($rs["quantity"]) . '",';
            $outp .= '"'   . $this->M_units->get_unitName($rs['unit_id']) . '",';
            $outp .= '"' . $rs["avg_cost"]     . '",';
            $outp .= '"' . $rs["unit_price"]     . '",';

            $total_cost = ($rs['quantity'] * $rs['avg_cost']);

            if ($rs['service'] == 1) {
                $outp .= "\"<a href='" . site_url($lang['langs']) . "/pos/Items/editService/" . $rs['item_id'] . "'><i class='fa fa-pencil-square-o fa-fw'></i></a>";
            } else {

                $outp .= "\"<a href='" . site_url($lang['langs']) . "/pos/Items/edit/" . $rs['item_id'] . '/' . $rs['size_id'] . "'><i class='fa fa-pencil-square-o fa-fw'></i></a>";
            }

            $outp .= "<a href='" . site_url($lang['langs']) . "/pos/Items/delete/" . $rs['item_id'] . '/' . $rs['inventory_acc_code'] . '/' . $total_cost . '/' . $rs['size_id'] . "' title='Make Inactive'><i class='fa fa-trash-o fa-fw'></i></a>\"]";
        }

        $outp = '{"data": [' . $outp . ']}';
        echo $outp;
    }
}
