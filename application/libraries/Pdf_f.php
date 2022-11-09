<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/fpdf184/fpdf.php';
class Pdf_f extends FPDF
{ function __construct() { parent::__construct(); }
}
/*Author:ahsan khan */
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */