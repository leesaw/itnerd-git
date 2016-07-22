<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tp_invoice extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->library('form_validation');
     $this->load->model('tp_invoice_model','',TRUE);
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function form_new_invoice()
{
    
}


}
?>