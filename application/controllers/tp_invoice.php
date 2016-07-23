<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tp_invoice extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->library('form_validation');
     $this->load->model('tp_invoice_model','',TRUE);
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function form_new_invoice()
{
    $data['datein'] = date("d/m/Y");

    $this->load->model('tp_warehouse_model','',TRUE);
    $sql = "wh_enable = 1";
    $data['wh_array'] = $this->tp_warehouse_model->getWarehouse($sql);
    
    $data['title'] = "NGG| Nerd - Create Invoice";
    $this->load->view("TP/invoice/form_new_invoice", $data);
}

function check_transfer_number()
{
    $tb_number = $this->input->post("tb_number");

    $output = array();
    $index = 0 ;
    $sql = "stot_number = '".$tb_number."' and stot_enable = '1'";
    $this->load->model('tp_warehouse_transfer_model','',TRUE);
    $result = $this->tp_warehouse_transfer_model->getItem_transfer($sql);
    
    if (count($result) >0) {
        foreach($result as $loop) {
            $output[$index] = "<td>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->log_stot_qty_final." ".$loop->it_uom."</td><td>".number_format($loop->it_srp)."</td><td><input type='text' name='it_discount' id='it_discount' value=''></td><td><input type='text' name='it_netprice' id='it_netprice' value='' readonly></td>";
            $index++;
        }
    }

    echo json_encode($output);
    exit();
}


}
?>