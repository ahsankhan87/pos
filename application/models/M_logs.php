<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_logs extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        
    }
    public function get_logs($from_date= null,$to_date= null)
        {
            if($from_date != null)
            {
                $this->db->where('date >=',$from_date);
            }
            
            if($to_date != null)
            {
                $this->db->where('date <=',$to_date);
            }
            
            $this->db->select('id,date,user,module,message_desc,host_ip');
            $this->db->order_by('date','DESC');
            
            $query = $this->db->get_where('logs',array('company_id'=> $_SESSION['company_id']));
            $data = $query->result_array();
            return $data;
           
        }
        
     public function add_log($id='', $section='', $action='', $module_name)
     {
        date_default_timezone_set($_SESSION['time_zone']);
        
         //for logging
        $msg_desc = "$id $section $action by ". $_SESSION['username'];
         
         $data = array(
            "date"	=>date("Y-m-d G:i:s"),
            "module"=>	"$module_name",
            "user_agent"=>	$_SERVER['HTTP_USER_AGENT'],
            "host_ip"=>	$_SERVER['REMOTE_ADDR'],
            "user"=>	$_SESSION['username'],
            "message_desc"=>	$msg_desc,
            'company_id'=> $_SESSION['company_id'],
            );
            $this->db->insert('logs', $data);
        // end logging
     }
}