<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

// CodeIgniter i18n library by Jérôme Jaglale
// http://maestric.com/en/doc/php/codeigniter_i18n
// version 10 - May 10, 2012

class MY_LangController extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		//$this->ci =& get_instance();
		$this->session->set_userdata('lang',$this->lang->lang());
        
	}
    
     
}