<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tp_rolex extends CI_Controller {

public $no_rolex = "";

function __construct()
{
     parent::__construct();
     $this->load->model('tp_rolex_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');

     if ($this->session->userdata('sessrolex') != 1) redirect('login', 'refresh');
     else $this->no_rolex = "br_id = 888";
}

function index()
{

}

function view_customer()
{
  $sql = "";
  $query = $this->tp_rolex_model->getCustomerInfo($sql);
  if($query){
      $data['pos_array'] =  $query;
  }else{
      $data['pos_array'] = array();
  }
  $currentdate = explode('-', $currentdate);
  $currentdate = $currentdate[1]."/".$currentdate[0];
  $data["currentdate"] = $currentdate;
  $data['title'] = "Nerd - Report";
  $this->load->view("TP/sale/report_saleorder_POS_history", $data);
}


}
?>
