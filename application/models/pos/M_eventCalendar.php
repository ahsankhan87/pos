<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_eventCalendar extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_eventCalendar($id = FALSE)
    {
        if($id == FALSE)
        {   
            $this->db->select('id,title,start,end,url');
            $query = $this->db->get_where('pos_eventcalendar',array('company_id'=> $_SESSION['company_id']));
            return $query->result_array();
        }
        
       $query = $this->db->get_where('pos_eventcalendar',array('id'=>$id,'company_id'=> $_SESSION['company_id']));
       return $query->result_array();
    }
     
    function get_activeEventCalendarDDL()
    {
        $data = array();
        $data[0] = "--Please Select--";
        $this->db->select('id,name');
        
        $query = $this->db->get_where('pos_eventCalendar',array('status'=>'active','company_id'=> $_SESSION['company_id']));
        
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $row)
            {
                $data[$row['id']] = $row['name'];
            }
        }
        return $data;
    }
} 