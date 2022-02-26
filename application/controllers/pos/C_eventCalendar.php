<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class C_eventCalendar extends MY_Controller {
	   
   public function __construct()
   {
    parent::__construct();
    $this->lang->load('message');
    
   }
   
   public function index()
   {
        $data = array('langs' => $this->session->userdata('lang'));
        
        $data['title'] = 'Event Calendar';   
        $data['main'] = 'Event Calendar';   
        
        //$data['candidates'] = $this->M_candidates->get_candidates();
        //load the view
        //$data['main_content'] = 'pos/event_calendar/v_eventCalendar';
        
        $this->load->view('templates/header',$data);
        $this->load->view('pos/event_calendar/v_eventCalendar',$data);
        $this->load->view('templates/footer');
          
   }
   public function eventCalendarJSON()
   {
        $eventCalendar = $this->M_eventCalendar->get_eventCalendar();
        echo json_encode($eventCalendar);
   }
   
   public function saveEventCalendar()
   {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data = array(  'company_id'=> $_SESSION['company_id'],
                            'title'=>$this->input->post('title'),
                            'start'=>$this->input->post('start'),
                            'end'=>$this->input->post('end'),
                            'url'=>$this->input->post('url'),
                            
                         );
                      
            $this->db->insert('pos_eventcalendar',$data);     
        }
   }
   
   public function updateEventCalendar()
   {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data = array(  'company_id'=> $_SESSION['company_id'],
                            'title'=>$this->input->post('title'),
                            'start'=>$this->input->post('start'),
                            'end'=>$this->input->post('end'),
                            'url'=>$this->input->post('url'),
                            'event_id'=>$this->input->post('event_id'),
                         );
                      
            $this->db->update('pos_eventcalendar',$data,array('id'=>$this->input->post('id')));     
        }
   }
   public function deleteEventCalendar()
   {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            
            $this->db->delete('pos_eventcalendar',array('id'=>$this->input->post('id')));     
        }
   }
 }