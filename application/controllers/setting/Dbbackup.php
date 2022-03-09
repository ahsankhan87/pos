<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dbbackup extends MY_Controller{
  
  public function __construct()
    {
        parent::__construct();
        
        $this->load->helper('language');
        $this->lang->load('index');
    }
    
  function index()
  {
        $this->load->database();
        ini_set('memory_limit', '-1');
        
        $this->load->dbutil();

        $prefs = array(     
                'format'      => 'zip',             
                'filename'    => 'kasbook_db_backup.sql'
              );


        $backup = $this->dbutil->backup($prefs); 

        $db_name = 'backup-on-'. date("d-m-Y-H-i-s") .'.zip';
        $save = 'pathtobkfolder/'.$db_name;

        $this->load->helper('file');
        write_file($save, $backup); 


        $this->load->helper('download');
        force_download($db_name, $backup);  
        
        //for logging
                    $msg = '';
                    $this->M_logs->add_log($msg,"Database Backup","created","Admin");
                    // end logging
  }
  
  function sqlitedb_backup()
  {
    $this->load->helper('download');
    
    $data = file_get_contents(APPPATH.'/db/db.sqlite'); // Read the file's contents
    $db_name = 'kasbook-backup-'. date("d-m-Y-H-i-s") .'.sqlite';
    
    force_download($db_name, $data);
    
                    //for logging
                    $msg = '';
                    $this->M_logs->add_log($msg,"Database Backup","created","Admin");
                    // end logging
  }
}