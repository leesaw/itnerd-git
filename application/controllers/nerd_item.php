<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nerd_item extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->model('nerd_item_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function salereport_graph()
{   
    
}

}
?>