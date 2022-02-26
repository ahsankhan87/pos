<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		//$this->ci =& get_instance();
        
        //check for language
		$this->session->set_userdata('lang',$this->lang->lang());	
        //$chk_admin = $this->uri->segment(2);
        
        //check the admin user or public website
        //if(strtolower($chk_admin) == 'admin')
        //{
        
        //-----------Check Admin User Authentication-------------------------
        //session_start();
        if(!isset($_SESSION['company_id']))
        {
            redirect('C_login','refresh');
        }
        //---------------End------------------------------------
        
        date_default_timezone_set($_SESSION['time_zone']);
        
        //get active financial year
        define('FY_YEAR', $_SESSION['fy_year']);
        define('FY_START_DATE', $_SESSION['fy_start_date']);
        define('FY_END_DATE', $_SESSION['fy_end_date']);
        
        //----------------Check Allowed Module------------------ 
        $module_name = $this->uri->segment(2);
        $sub_module_name = $this->uri->segment(3);
        
        if($module_name == 'C_login')
        {
            redirect('C_login/logout','refresh');     
        }                
        
        
        if($module_name !== 'companies')
        {
            if($module_name !== 'setting')
            {
                /////////////////////////////////////
                //get module id via module name.
                /////////////////////////////////////
                $module = $this->M_modules->get_moduleByName($module_name);

                $module_id =  @$module[0]['id'];

                //check user whether he got permisson of the module or not.
                $module_chk = $this->M_users->has_permission($module_id,$_SESSION['user_id']);
                //var_dump($module_chk);
                if(!$module_chk)
                {   
                    if($_SESSION['role'] !== 'admin')
                    {
                        redirect('No_access','refresh');    
                    }
                }

                //////////////////////////////////
                //get sub module id via module name.
                ////////////////////////////////////
                $sub_module = $this->M_modules->get_moduleByName($sub_module_name);
                $sub_module_id =  @$sub_module[0]['id'];
                //echo '<br/><br/>';
                //check user whether he got permisson of the sub module or not.
                $sub_module_chk = $this->M_users->has_sub_module_permission($sub_module_id,$_SESSION['user_id']);
                //var_dump($sub_module_chk);
                if(!$sub_module_chk)
                {   

                        redirect('No_access','refresh');    

                }
            }
            
        }
        
        //----------------End--------------------------------
       //}
	}
}