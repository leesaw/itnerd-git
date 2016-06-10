<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tp_repair extends CI_Controller {

public $no_rolex = "";
public $shop_rolex = "";
    
function __construct()
{
     parent::__construct();
     $this->load->model('tp_repair_model','',TRUE);
     $this->load->model('tp_shop_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
    
     if ($this->session->userdata('sessrolex') == 0) {
         $this->no_rolex = "br_id != 888";
         $this->shop_rolex = "sh_id != 888";
     }else{
         $this->no_rolex = "br_id = 888";
         $this->shop_rolex = "sh_id = 888";
     }
}

function index()
{
    
}
 
function form_new_repair()
{
    $sql = $this->shop_rolex;
	$data['shop_array'] = $this->tp_shop_model->getShop($sql);
	$data['currentdate'] = date("d/m/Y");
    
    $data['title'] = "Nerd | New Repair";
    $this->load->view('TP/repair/form_new_repair',$data);
}
    

}
?>