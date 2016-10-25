<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tp_stockmovement extends CI_Controller {

function __construct()
{
    parent::__construct();
    $this->load->model('tp_warehouse_model','',TRUE);
    $this->load->model('tp_warehouse_transfer_model','',TRUE);
    $this->load->library('form_validation');
    if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');

    if ($this->session->userdata('sessrolex') == 0) $this->no_rolex = "br_id != 888";
    else $this->no_rolex = "br_id = 888";
}

function index()
{

}

function form_stockmovement()
{
    $sql = "";
    $data['warehouse_array'] = $this->tp_warehouse_model->getWarehouse($sql);

    $data['title'] = "NGG| Nerd - Stock Movement";
    $this->load->view('TP/warehouse/manage_view',$data);
}


}
?>
