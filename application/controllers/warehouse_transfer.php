<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warehouse_transfer extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->model('tp_warehouse_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function importstock() 
{
	$data['currentdate'] = date("d/m/Y");

    $data['title'] = "Nerd - Import Stock";
    $this->load->view("TP/warehouse/addstock_view", $data);
}
    

    
}
?>