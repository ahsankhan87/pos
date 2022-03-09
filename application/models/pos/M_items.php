<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_items extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        
    }
    
    //get all products and also only one product and active and inactive too.
    public function get_items($id = FALSE, $limit = 1000000, $offset = 0)
    {
        if($id === FALSE)
        {
            if($limit)
            {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }
            
            //$this->db->order_by('item_id','asc');
            $option = array('deleted'=>0,'company_id'=> $_SESSION['company_id']);
            $query = $this->db->get_where('pos_items',$option);
            $data = $query->result_array();
            return $data;
        }
        
        //$this->db->order_by('item_id','asc');
        $options = array('item_id'=> $id,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_items',$options);
        $data = $query->result_array();
        return $data;
    }
    
    //get all products and also only one product and active and inactive too.
    public function get_low_stock_items()
    {
        
        $this->db->select('A.item_id,A.service,A.category_id, A.name,B.inventory_acc_code,B.barcode,B.size_id,B.unit_id,
        C.name as size,B.color_id,B.quantity,B.cost_price, B.avg_cost,B.unit_price,B.re_stock_level');
        $this->db->join('pos_items_detail AS B','A.item_id = B.item_id','left');
        $this->db->join('pos_sizes as C','B.size_id = C.id','left');
        
        $this->db->where('B.quantity <= B.re_stock_level');
        
        $query = $this->db->get_where('pos_items AS A', array('A.deleted'=>0,'B.deleted'=>0,'A.company_id'=> $_SESSION['company_id']));
        $data = $query->result_array();
        return $data;
    }
    
    function getItemDropDown($item_type=null)
    {
        $data = array();;
        $data[0] = "--Please Select--";
        //$query = $this->db->get_where('pos_items',array('company_id'=> $_SESSION['company_id'],'deleted'=>0));
        if($item_type != null)
        {
            $this->db->where('A.item_type',$item_type);
        }
        
        $this->db->join('pos_items AS B','A.item_id = B.item_id','left');
        
        $query = $this->db->get_where('pos_items_detail AS A', array('B.deleted'=>0,'A.deleted'=>0,
        'B.company_id'=> $_SESSION['company_id']));
        
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                // $category = $this->M_category->get_CatNameByItem($row['item_id']);//get the category of single item
                // $data[$row['item_id']] = $row['name'] . ($category == '' ? '' : ' - '.$category);//and if category is not empty it will add it with item i.e used in purchases and sales product DDL
                $data[$row['item_id']] = $row['name'];//and if category is not empty it will add it with item i.e used in purchases and sales product DDL
            }
        }
        $query->free_result();
        return $data;
    }
        
    //get active property if id is provided then one record will be loaded.
    //this property will show on front page.
    public function get_activeItems($item_id = FALSE)
    {
        if($item_id === FALSE)
        {
            $this->db->order_by('item_id','desc');
            $query = $this->db->get_where('pos_items', array('deleted'=>0,'company_id'=> $_SESSION['company_id']));
            $data = $query->result_array();
            return $data;
        }
        
        $options = array('item_id'=> $item_id, 'deleted'=>0,'company_id'=> $_SESSION['company_id']);
        $query = $this->db->get_where('pos_items',$options);
        $data = $query->result_array();
        return $data;
    }
    
    public function get_allItemsforJSON()
    {
        //$this->db->order_by('B.item_id','desc');
        $this->db->select('B.item_id,B.category_id, B.name,B.service,A.barcode,A.inventory_acc_code,A.picture,
        A.size_id,A.color_id,A.item_type,A.unit_id,A.quantity,A.avg_cost,A.cost_price,A.unit_price,A.re_stock_level,
        A.inventory_acc_code,A.wip_acc_code,
        A.tax_id,T.name as tax_name,T.rate as tax_rate, U.name as unit_name');
        $this->db->join('pos_items AS B','A.item_id = B.item_id','left');
        $this->db->join('pos_taxes AS T','T.id = A.tax_id','left');
        // $this->db->join('pos_sizes as C','A.size_id = C.id','left');
        $this->db->join('pos_units as U','A.unit_id = U.id','left');
        // $this->db->join('pos_locations as L','A.location_id = L.id','left');
        
        $query = $this->db->get_where('pos_items_detail AS A', array('B.deleted'=>0,'A.deleted'=>0,'B.company_id'=> $_SESSION['company_id']));
        $data = $query->result_array();
        return $data;
    
    }
    
    //get item and item detail for purchase
    public function get_allItems()
    {
        //$this->db->order_by('A.item_id','desc');
        $this->db->select('A.item_id,A.service,A.category_id, A.name,B.inventory_acc_code,B.barcode,B.size_id,B.unit_id,
        C.name as size,B.color_id,B.quantity,B.cost_price, B.avg_cost,B.unit_price,B.re_stock_level,
        B.tax_id,T.name as tax_name,T.rate as tax_rate,B.inventory_acc_code,B.wip_acc_code');
        $this->db->join('pos_items_detail AS B','A.item_id = B.item_id','left');
        $this->db->join('pos_taxes AS T','T.id = B.tax_id','left');
        $this->db->join('pos_sizes as C','B.size_id = C.id','left');
        
        $query = $this->db->get_where('pos_items AS A', array('A.deleted'=>0,'B.deleted'=>0,'A.company_id'=> $_SESSION['company_id']));
        $data = $query->result_array();
        return $data;
    
    }
    
    public function get_ItemName($item_id)
    {
        $options = array('item_id'=> $item_id, 'deleted'=>0,'company_id'=> $_SESSION['company_id']);
        $query = $this->db->get_where('pos_items',$options);
        
        if($item_name = $query->row())
        {
            return $item_name->name;
        }
    }
    
    public function get_itemDetail($item_id,$size_id = null)
    {
        if($size_id !== null)
        {
            $this->db->where('id.size_id',$size_id);
        }
        $this->db->where(array('id.item_id'=>$item_id));
        $this->db->join('pos_items_detail id','i.item_id=id.item_id','LEFT');
        $query = $this->db->get('pos_items i');
        $data = $query->result_array();
        return $data;  
    }
    
    public function getItemsOptions($item_id)
    {
        $query = $this->db->get_where('pos_items_detail',array('item_id'=>$item_id));
        
        $data = $query->result_array();
        return $data;
    }
    
    //get product by search 
    public function search($search){
        
        $this->db->like('name',$search);
        $options = array('deleted'=>0,'company_id'=> $_SESSION['company_id']);
        $query = $this->db->get_where('pos_items',$options);
        $data = $query->result_array();
        return $data;
    }
    
    function addItems()
        {
            $this->db->trans_start(); 
            
            $service = $this->input->post('service',true);
            $brand = $this->input->post('brand',true);
            $desc = $this->input->post('description',true);
            $unit_id = ($this->input->post('unit_id',true) == '' ? 0 : $this->input->post('unit_id',true));
            $tax_id = $this->input->post('tax_id',true);
            $item_type = $this->input->post('item_type',true);
             
            //$capital_acc_code = $this->input->post('capital_acc_code',true);
            $inventory_acc_code = $this->input->post('inventory_acc_code',true);
            $wip_acc_code = ($this->input->post('wip_acc_code',true) == '' ? 0 : $this->input->post('wip_acc_code',true));
            $initial_qty_single = ($this->input->post('initial_qty_single',true) == '' ? 0 : $this->input->post('initial_qty_single',true));
            $cost_price = ($this->input->post('cost_price',true) == '' ? 0 : $this->input->post('cost_price',true));
            $unit_price = ($this->input->post('unit_price',true) == '' ? 0 : $this->input->post('unit_price',true));
            
            //this qty is for sizes
            $initial_qty = ($this->input->post('initial_qty',true) == '' ? array() : $this->input->post('initial_qty',true));
            $size_cost_price = ($this->input->post('size_cost_price',true) == '' ? array() : $this->input->post('size_cost_price',true));
            $size_unit_price = ($this->input->post('size_unit_price',true) == '' ? array() : $this->input->post('size_unit_price',true));
            
            $data = array(
            'company_id'=> $_SESSION['company_id'],
            'name' => $this->input->post('name',true),
            //'item_number' => $this->input->post('item_number',true),
            'category_id' => $this->input->post('category_id',true),
            //'item_type' => $this->input->post('item_type',true),
            'service' => (isset($service) ? 1 : 0),
            //'brand' => (isset($brand) ? $brand : ''),
            'description' => (isset($desc) ? $desc : ''),
            //'unit_price' => $this->input->post('unit_price',true),
            //'quantity' => $this->input->post('quantity',true),
            
            );
            
            $query_item_insert = $this->db->insert('pos_items', $data);
            $new_item_id = $this->db->insert_id();
            $item_code = 'it'.$new_item_id;
            
            $data1 = array(
            'company_id'=> $_SESSION['company_id'],
            'item_id' => $new_item_id,
            
            );
            $this->db->insert('pos_items_company', $data1);
            
            $sizes = $this->input->post('sizes',true);
            $barcode = ($this->input->post('barcode',true) == '' ? $new_item_id : $this->input->post('barcode',true));
            
            $filter_initial_qty = array_filter($initial_qty);//remove empty value from array
            $filter_size_cost_price = array_filter($size_cost_price);//remove empty value from array
            $filter_size_unit_price = array_filter($size_unit_price);//remove empty value from array
            
            unset($initial_qty);
            unset($size_cost_price);
            unset($size_unit_price);
            
            $initial_qty = array_values($filter_initial_qty);//then reindex array
            $size_cost_price = array_values($filter_size_cost_price);//then reindex array
            $size_unit_price = array_values($filter_size_unit_price);//then reindex array
            //var_dump($sizes);
            //var_dump($size_cost_price);
            
            if($service ==1)
            {
            ///IF SERVICES
            $option_data = array(
                'item_id'=>$new_item_id,
                'unit_price' =>$this->input->post('unit_price',true),
                'tax_id' => $tax_id,
                'unit_id' => $unit_id,
                'barcode'=>$new_item_id,
                'item_type'=>'service'
                );
            $this->db->insert('pos_items_detail', $option_data);
                    
                     //for logging
                    $msg = $this->input->post('name'). ' Service';
                    $this->M_logs->add_log($msg,"Product","Added","POS");
                    // end logging
                    
            ////
            ///IF PRODUCT HAVE SIZES, QTY AND BARCODE THEN INSERT
            }elseif($sizes > 0)
            {
                $total_cost =0;
                
                $i = 0;
                foreach($sizes as $size=>$values)
                {
                    $cost_price = (isset($size_cost_price[$i]) ? $size_cost_price[$i] : 0);
                    $unit_price = (isset($size_unit_price[$i]) ? $size_unit_price[$i] : 0);
                    $qty = (isset($initial_qty[$i]) ? $initial_qty[$i] : 0);
                    
                    $option_data = array(
                    'item_id'=>$new_item_id,
                    'item_code'=>$item_code,
                    'barcode'=>$barcode[$i],
                    'quantity'=>$qty,
                    'color_id' =>0,
                    'unit_id' =>$unit_id,
                    'size_id' =>$values,
                    'cost_price' =>$cost_price, //actually this price is NEW cost price
                    'unit_price' => $unit_price,
                    'tax_id' => $tax_id,
                    'location_id' =>$this->input->post('location_id',true),
                    'avg_cost'=>$cost_price,
                    're_stock_level' => $this->input->post('reorder_level',true),
                    "picture" =>$_FILES['upload_pic']['name'],
                    'inventory_acc_code'=>$inventory_acc_code,
                    'wip_acc_code'=>$wip_acc_code,
                    'item_type'=>$item_type
                    );
                    $this->db->insert('pos_items_detail', $option_data);
                    
                    $total_cost +=$cost_price*$qty;
                    
                    //ADD ITEM DETAIL IN INVENTORY TABLE    
                      $data1= array(
                        'trans_item'=>$new_item_id,
                        'trans_comment'=>'Initial Quantity',
                        'trans_inventory' => $qty,
                        'company_id'=> $_SESSION['company_id'],
                        'trans_user'=>$_SESSION['user_id'],
                        'cost_price'=>$cost_price,
                        'unit_price'=>$unit_price,
                        );
                        
                      $this->db->insert('pos_inventory', $data1);
                      //////////////
          
                    //for logging
                    $msg = $this->input->post('name'). ' Qty('. $qty.')';
                    $this->M_logs->add_log($msg,"Product","Added","POS");
                    // end logging
                    
                    $i++;
                }
            }else{ //IF NO SIZE IS GIVEN THEN INSERT 0 SIZE
                $option_data = array(
                    'item_id'=>$new_item_id,
                    'barcode'=>$barcode,
                    'item_code'=>$item_code,
                    'quantity'=>$initial_qty_single,
                    'color_id' =>0,
                    'unit_id' =>$unit_id,
                    'size_id' =>0,
                    'cost_price' =>$cost_price, //actually this price is NEW cost price
                    'unit_price' =>$unit_price,
                    'tax_id' => $tax_id,
                    'location_id' =>$this->input->post('location_id',true),
                    'avg_cost'=>$cost_price,
                    're_stock_level' => $this->input->post('reorder_level',true),
                    "picture" =>$_FILES['upload_pic']['name'],
                    'inventory_acc_code'=>$inventory_acc_code,
                    'wip_acc_code'=>$wip_acc_code,
                    'item_type'=>$item_type
                    );
                    $this->db->insert('pos_items_detail', $option_data);
                    
                    $total_cost = $cost_price*$initial_qty_single;
                    
                    //ADD ITEM DETAIL IN INVENTORY TABLE    
                      $data1= array(
                        'trans_item'=>$new_item_id,
                        'trans_comment'=>'Initial Quantity',
                        'trans_inventory' => $initial_qty_single,
                        'company_id'=> $_SESSION['company_id'],
                        'trans_user'=>$_SESSION['user_id'],
                        'cost_price'=>$cost_price,
                        'unit_price'=>$unit_price,
                        );
                        
                      $this->db->insert('pos_inventory', $data1);
                      //////////////
          
                    //for logging
                    $msg = $this->input->post('name'). ' Qty('.$initial_qty_single.')';
                    $this->M_logs->add_log($msg,"Product","Added","POS");
                    // end logging
            }
            
            
           if(isset($inventory_acc_code))
           {
               $inventory_account = $this->M_groups->get_groups($inventory_acc_code,$_SESSION['company_id']);
               $inventory_dr_balance = abs($inventory_account[0]['op_balance_dr']);
               $dr_balance = ($inventory_dr_balance+$total_cost);
               $cr_balance = 0;
               $this->M_groups->editGroupOPBalance($inventory_acc_code,$dr_balance,$cr_balance);
                     
           }
           
           $this->db->trans_complete();
            return $query_item_insert;
        }
        
     function updateItems($new_picture = null)
     {
            
            $service = $this->input->post('service',true);
            
            $data = array(
            'company_id'=> $_SESSION['company_id'],
            'name' => $this->input->post('name',true),
            //'brand' => $this->input->post('brand',true),
            'item_number' => $this->input->post('item_number',true),
            'category_id' => $this->input->post('category_id',true),
            //'item_type' => $this->input->post('item_type',true),
            'description' => $this->input->post('description',true),
            );
            $this->db->update('pos_items', $data, array('item_id'=>$this->input->post('item_id')));
            
            if($service == 1)
            {
                ///IF SERVICES
                $option_data = array(
                    'unit_price' =>$this->input->post('unit_price',true),
                    'cost_price' =>$this->input->post('cost_price',true),
                    'tax_id' => $this->input->post('tax_id',true),
                    'unit_id' =>$this->input->post('unit_id',true),
                    'barcode'=>$this->input->post('item_id'),
                    );
                $this->db->update('pos_items_detail',$option_data,array('id'=>$this->input->post('id')));
                ////
                
                    //for logging
                    $msg = $this->input->post('name'). ' Service';
                    $this->M_logs->add_log($msg,"Product","Updated","POS");
                    // end logging
            }else
            {
                $option_data = array(
                //'barcode'=>$this->input->post('barcode',true),
                //'quantity'=>$qty[$i],
                'unit_id' =>$this->input->post('unit_id',true),
                'barcode'=>$this->input->post('barcode',true),
                //'size_id' =>$this->input->post('size_id',true),
                'unit_price' =>$this->input->post('unit_price',true),
                'tax_id' => $this->input->post('tax_id',true),
                //'avg_cost' =>$this->input->post('avg_cost',true),
                'location_id' =>$this->input->post('location_id',true),
                're_stock_level' => $this->input->post('reorder_level',true),
                "picture" =>$new_picture,
                );
                $this->db->update('pos_items_detail',$option_data,array('id'=>$this->input->post('id')));
                
                    //for logging
                    $msg = $this->input->post('name'). ' ID('.$this->input->post('id').')';
                    $this->M_logs->add_log($msg,"Product","Updated","POS");
                    // end logging
            }
     }
     
    function deleteItem($id,$inventory_acc_code,$total_cost,$size_id)
    {
        //$query = $this->db->update('pos_items',array('deleted'=>1),array('item_id'=>$id));
        $query = $this->db->update('pos_items_detail',array('deleted'=>1,'barcode'=>$id),array('item_id'=>$id,'size_id'=>$size_id));
        
       $inventory_account = $this->M_groups->get_groups($inventory_acc_code,$_SESSION['company_id']);
       $inventory_dr_balance = abs(@$inventory_account[0]['op_balance_dr']);
       $dr_balance = ($inventory_dr_balance-$total_cost);
       $cr_balance = 0;
       $this->M_groups->editGroupOPBalance($inventory_acc_code,$dr_balance,$cr_balance);
                       
                    //for logging
                    $msg = ' Product id('. $id.')';
                    $this->M_logs->add_log($msg,"Product","inactivated","POS");
                    // end logging
    }
    
    //it will reassign products to a category.
    function reasign_items()
    {
        $data = array('category_id'=>$this->input->post('categories'));
        $id_list = implode(',',array_keys($this->session->userdata('orphan')));
        
        $where = 'item_id in ('.$id_list.')';
        
        return $this->db->update('pos_items',$data,$where);
    }
    
    //items options mean i.e size and colors etc
    function get_itemOptions($id)
    {
        $data = array();
        //$this->db->select('colors_id');
        $query = $this->db->get_where('pos_items_detail',array('id'=>$id));
        
        foreach($query->result_array() as $values)
        {
            if($values['color_id'] == 0 AND $values['size_id'] == 0)
            {
                $data['Color'] = 0;
                $data['Size'] = 0;
            }
            else
            {
                $data['Color'] = $values['color_id'];
                $data['Size'] = $values['size_id'];
            }
            
            
        }        
        return $data;
    }
    
    //get the total qty of all the colors and sizes of single item.
    //if you want to get total stock only against item then give only item id and leave color and size id.
    public function total_stock($item_id =0, $color_id  = -1, $size_id=-1)
    {
        $this->db->select_sum('quantity');
        
        if($color_id != -1)
        {
            $this->db->where('color_id',$color_id);
        }
        
        if($size_id != -1)
        {
            $this->db->where('size_id',$size_id);
        }
        
        $query = $this->db->get_where('pos_items_detail',array('item_id'=>$item_id));
        if($total = $query->row())
        {
            return $total->quantity;
        }

        return 0;
        
    }
     //check the item option i.e item_id, color and size if exist
    public function checkItemOptions($item_id = 0, $color_id =0, $size_id=0)
    {
        $query = $this->db->get_where('pos_items_detail',array('color_id'=>$color_id,'size_id'=>$size_id,'item_id'=>$item_id));
        
        if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
            
    }
    
    //get avg cost of the product using below formula
    function getAvgCost($item_id,$new_costPrice,$new_qty,$color_id=0, $size_id=0,$type='receive')
    {
        //get old item cost price and qty.
        $options = array('item_id'=> $item_id,'color_id'=>$color_id,'size_id'=>$size_id);
        
        $query = $this->db->get_where('pos_items_detail',$options);
        if($row = $query->row())
        {
            $oldCost_price = $row->avg_cost;
            //$old_qty = $this->total_stock($item_id,$color_id, $size_id);
            $old_qty = $row->quantity;
        }
        else
        {  
            //if old cost and qty is no available then set value to zero
            $oldCost_price = 0;
            $old_qty = 0;
            //////
        }   
        
        //IF SERVICE THEN RETUEN ZERO
        $options = array('item_id'=> $item_id);
        $this->db->select('service');
        $query = $this->db->get_where('pos_items',$options);
        $row = $query->row();
        if($row->service)
        {
            return 0;
        }
        ////////////
        
            $old_cost = ($oldCost_price*$old_qty);
            
            $new_cost = ($new_costPrice*$new_qty);
            
            if($type == 'return'){
                
                if($old_cost != $new_cost)
                {
                    $total_cost = ($old_cost-$new_cost);
                }else{
                    $total_cost = $old_cost;
                }
                
                $total_qty = (($old_qty-$new_qty) == 0 ? 1 : ($old_qty-$new_qty));
               
            }
            elseif($type == 'receive')
            {
                $total_cost = ($old_cost+$new_cost);
                $total_qty = ($old_qty+$new_qty);
            }        
            
            
            $avg_cost = ($total_cost/$total_qty);
            
            return ($avg_cost); //get absolute number i.e if negative value it will convert it to positive
        
    }
    
    function get_item_history($item_id)
    {
        $options = array('trans_item'=> $item_id,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('pos_inventory',$options);
        $data = $query->result_array();
        return $data;
    }
    
    
    function get_assignedColor($id)
    {
        $data = array();
        $this->db->select('colors_id');
        $query = $this->db->get_where('pos_item_colors',array('item_id'=>$id));
        
        foreach($query->result_array() as $values)
        {
            $data[] = $values['colors_id'];
        }        
        return $data;
    }
    
    function get_assignedSize($id)
    {
        $data= array();
        $this->db->select('size_id');
        $query = $this->db->get_where('pos_item_sizes',array('item_id'=>$id));
        
        foreach($query->result_array() as $values)
        {
            $data[] = $values['size_id'];
        }        
        return $data;
    }
    
    function barcode_exist($barcode)
     {
        $this->db->where('barcode',$barcode);
        $query = $this->db->get('pos_items_detail'); 
        
        if($query->num_rows() > 0)
        {
            return true;
        }else
        {
            return false;
        }
     }
     
}


?>