<?php
class M_users extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->database();
    }
    
    
    function get_activeUsers($id = FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->get_where('users',array('status'=>1,'company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('users',array('id'=>$id,'status'=>1,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
    
    function has_permission($module_id,$user_id)
     {
        $this->db->where('module_id',$module_id);
        $this->db->where('emp_id',$user_id);
        $query = $this->db->get('pos_emp_modules'); 
        
        if($query->num_rows() > 0)
        {
            return true;
        }else
        {
            return false;
        }
     }
     
     function has_sub_module_permission($module_id,$user_id)
     {
        $this->db->where('sub_module',$module_id);
        $this->db->where('emp_id',$user_id);
        $query = $this->db->get('pos_emp_modules'); 
        
        if($query->num_rows() > 0)
        {
            return true;
        }else
        {
            return false;
        }
     }
     
     function username_exist($username)
     {
        $this->db->where('username',$username);
        $this->db->where('company_id', $_SESSION['company_id']);
        $query = $this->db->get('users'); 
        
        if($query->num_rows() > 0)
        {
            return true;
        }else
        {
            return false;
        }
     }
     
     public function hasUsername($username)
    {
        $options = array('username'=> $username,'company_id'=> $_SESSION['company_id']);
        
        $query = $this->db->get_where('users',$options);
        
        if ($query->num_rows() > 0)
        {
            //echo "<span style='color:red;'>Taken</span>";
            return false;
        }
       
            return true;
        
    }
    function addUser()
    {
        $this->db->trans_start();
        
        $data = array(  'name'=>$this->input->post('name',true),
                        'password'=>md5($this->input->post('password',true)),
                        'status'=>1,
                        'role'=>$this->input->post('role',true),
                        'company_id'=> $_SESSION['company_id'],
                        'username'=>$this->input->post('username',true)
                      );
                  
        $this->db->insert('users',$data);   
        $user_id = $this->db->insert_id();
        
        //$can_create=$this->input->post('can_create',true);
//        $can_update =$this->input->post('can_update',true);
//        $can_delete=$this->input->post('can_delete',true);
        $modules = $this->input->post('modules');
        $sub_module = $this->input->post('sub_module');
        
            if(count((array)$modules))
            {
                    foreach($modules as $i =>$values)
                        {
                            $data1 = array(
                            'emp_id' => $user_id,
                            'module_id' => $values,
                            );
                            $this->db->insert('pos_emp_modules', $data1);
                        }
                    
                if(count((array)$sub_module))
                { //it insert sub modules
                    foreach($sub_module as  $i => $values)
                        {
                            $data1 = array(
                            //'module_id' => $values,
                            'sub_module' => $values,
                            'emp_id' => $user_id,
                            //'can_create'=>(!isset($can_create[$i]) ? 0 : $can_create[$i]),
//                            'can_update'=>(!isset($can_update[$i]) ? 0 : $can_update[$i]),
//                            'can_delete'=>(!isset($can_delete[$i]) ? 0 : $can_delete[$i])
                            );
                            $this->db->insert('pos_emp_modules', $data1);
                                                        
                        }
                }
            }   
        $this->db->trans_complete();
        
            //for logging
            $msg = 'username '.$this->input->post('username'). ', Full Name'. $this->input->post('name');
            $this->M_logs->add_log($msg,"User","Created","admin");
            // end logging        
    }
    
    function updateUser()
    {
        $this->db->trans_start();
        
        $data = array(  'name'=>$this->input->post('name',true),
                        //'password'=>md5($this->input->post('password',true)),
                        'username'=>$this->input->post('username',true),
                        'role'=>$this->input->post('role',true),
                      );
                  
        $this->db->update('users',$data,array('id'=>$this->input->post('id',true))); 
        
        $can_create=$this->input->post('can_create',true);
        $can_update =$this->input->post('can_update',true);
        $can_delete=$this->input->post('can_delete',true);
        $modules = $this->input->post('modules');
        $sub_module = $this->input->post('sub_module');
        
        //var_dump($modules);
        //echo '<br /><br /><br />';
        //var_dump($modules);
        
//        var_dump($sub_module);
//        var_dump($can_create);
//        var_dump($can_update);
//        var_dump($can_delete);
        //var_dump($sub_module[1]);
        
        $this->db->delete('pos_emp_modules',array('emp_id'=>$this->input->post('id',true)));
                        
                        //$j = 1;
                        if(count((array)$modules))
                        {
                            foreach($modules as $j => $values)
                            {   
                                $data1 = array(
                                'module_id' => $values,
                                'emp_id' => $this->input->post('id',true),
                                );
                                $this->db->insert('pos_emp_modules', $data1);
                                
                                if(count((array)@$sub_module[$j]))
                                {
                                    foreach($sub_module[$j] as $values1)
                                    {
                                        //var_dump($values1[$j]);
                                        
                                        $data2 = array(
                                        //'module_id' => $values,
                                        'sub_module' => $values1,
                                        'emp_id' => $this->input->post('id',true),
                                        //'can_create'=>(!isset($can_create[$j][$i]) ? 0 : $can_create[$j][$i]),
    //                                    'can_update'=>(!isset($can_update[$j][$i]) ? 0 : $can_update[$j][$i]),
    //                                    'can_delete'=>(!isset($can_delete[$j][$i]) ? 0 : $can_delete[$j][$i])
                                        );
                                        $this->db->insert('pos_emp_modules', $data2);
                                                                    
                                    }
                                }
                            }  
                            //$j++;
                        }   
                        
               
        
    $this->db->trans_complete();
        //for logging
            $msg = 'username '.$this->input->post('username'). ', Full Name'. $this->input->post('name');
            $this->M_logs->add_log($msg,"User","updated","admin");
            // end logging   
    }
    
    function updateUser_password()
    {
        $data = array(  'password'=>md5($this->input->post('password',true)),
                        
                      );
                  
        $this->db->update('users',$data,array('id'=>$this->input->post('id',true))); 
        
        //for logging
            $msg = 'user id '.$this->input->post('id',true);
            $this->M_logs->add_log($msg,"User","Password Updated","admin");
            // end logging  
       
    }
    
    function deleteUser($id)
    {
        $this->db->delete('pos_emp_modules',array('emp_id'=>$id));
        $query = $this->db->update('users',array('status'=>0),array('id'=>$id));
        
            //for logging
            $msg = 'user id '.$id;
            $this->M_logs->add_log($msg,"User","Deleted","admin");
            // end logging   
    }
}