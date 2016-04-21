<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sesto extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function main()
{
    $data['sessstatus'] = $this->session->userdata('sessstatus');
    $data['title'] = "NGG| NERD";
    $this->load->view('SS/main',$data);
}

}
?>