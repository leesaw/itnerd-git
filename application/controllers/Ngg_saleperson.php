<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ngg_saleperson extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->model('tp_saleperson_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function select_option_saleperson_shop()
{   
    $shopid = $this->input->post("shopid");

    $where = "sp_shop_id = '".$shopid."'";
    $query = $this->tp_saleperson_model->getSalePerson_sort_name($where);
    $result = "";
    foreach($query as $loop) {
    	$result .= "<option value='".$loop->sp_id."'>".$loop->sp_firstname." ".$loop->sp_lastname." (".$loop->sp_barcode.")"."</option>";
    }
    echo $result;
}

}
?>