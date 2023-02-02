<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter PHPMailer Class
 *
 * This class enables SMTP email with PHPMailer
 *
 * @category    Libraries
 * @author      CodexWorld
 * @link        https://www.codexworld.com
 */
require_once dirname(__FILE__) . '/PHPMailer/PHPMailer.php';
require_once dirname(__FILE__) . '/PHPMailer/Exception.php';
require_once dirname(__FILE__) . '/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailer_Lib extends PHPMailer
{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
        $mail = new PHPMailer;
        return $mail;
    }
}