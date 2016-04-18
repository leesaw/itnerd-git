<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sesto_certificate extends CI_Controller {

    
function __construct()
{
     parent::__construct();
     $this->load->model('rolex_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('catalog', 'refresh');
    
     if ($this->session->userdata('sessrolex') != 1) redirect('catalog/logout', 'refresh'); 
     else $this->no_rolex = "br_id = 888";
}

function index()
{
    
}
 
function main()
{

}
    

}
?>