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
    if ($this->session->userdata('sessrolex') == 1) {
        redirect('timepieces/main_rolex', 'refresh');
    }else if (($this->session->userdata('sessstatus') >= 50) && ($this->session->userdata('sessstatus') <= 59)) {
        redirect('sesto/main', 'refresh');
    }else if (($this->session->userdata('sessstatus') >= 60) && ($this->session->userdata('sessstatus') <= 69)) {
        redirect('ngg_gold/main', 'refresh');
    }
    $data['title'] = "NGG| NERD";
    $this->load->view('TP/main',$data);
}
  
function main_rolex()
{   
    $data['sessstatus'] = $this->session->userdata('sessstatus');
    $data['title'] = "NGG| Rolex";
    $this->load->view('TP/main_rolex',$data);
}
    
function main_certificate()
{
    $data['sessstatus'] = $this->session->userdata('sessstatus');
    $data['title'] = "NGG| NERD";
    $this->load->view('SS/main',$data);
}
    
}
?>