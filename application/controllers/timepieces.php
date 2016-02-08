<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timepieces extends CI_Controller {

function __construct()
{
     parent::__construct();
     //$this->load->model('timepieces_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function main()
{   
    
    $data['title'] = "NGG| Nerd";
    $this->load->view('TP/main',$data);
}
  
    
}
?>