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
    $sql = "wh_group_id != 3 and wh_group_id != 6 and wh_enable = 1";
    $data['wh_array'] = $this->tp_warehouse_model->getWarehouse($sql);
    
    $data['title'] = "NGG| Nerd - Create Invoice";
    $this->load->view("TP/invoice/form_new_invoice", $data);
}

function check_transfer_number()
{
    $tb_number = $this->input->post("tb_number");

    $output = array();
    $warehouse = array();
    $index = 0 ;
    $sql = "stot_number = '".$tb_number."' and stot_enable = '1'";
    $this->load->model('tp_warehouse_transfer_model','',TRUE);
    $result = $this->tp_warehouse_transfer_model->getItem_transfer($sql);
    
    if (count($result) >0) {
        foreach($result as $loop) {
            if ($index == 0) {
                $sql = "wh_id = '".$loop->wh_in_id."'";
                $this->load->model('tp_warehouse_model','',TRUE);
                $query = $this->tp_warehouse_model->getWarehouse($sql);

                foreach($query as $loop2) {
                    $wh_id = $loop2->wh_id;
                    $wh_detail = $loop2->wh_detail;
                    $wh_address1 = $loop2->wh_address1;
                    $wh_address2 = $loop2->wh_address2;
                    $wh_taxid = $loop2->wh_taxid;
                    $wh_branch = $loop2->wh_branch;
                    $wh_vender = $loop2->wg_vender;
                }

                $warehouse = array("wh_id" => $wh_id, "wh_detail" => $wh_detail, "wh_address1" => $wh_address1, "wh_address2" => $wh_address2, "wh_taxid" => $wh_taxid, "wh_branch" => $wh_branch, "wh_vender" => $wh_vender);
            }

            $output[$index] = "<td>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td><input type='text' name='it_qty' id='it_qty' value='".$loop->log_stot_qty_final."' onChange='calculate();'></td><td><input type='hidden' name='it_srp' id='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp, 2, ".", ",")."</td><td><input type='text' name='it_discount' id='it_discount' value='' onChange='calDiscount();'></td><td><input type='text' name='it_netprice' id='it_netprice' value='".number_format($loop->it_srp, 2, ".", ",")."' onChange='calculate();'></td>";
            $index++;
        }
    }
    $final = array("item" => $output, "warehouse" => $warehouse);
    echo json_encode($final);
    exit();
}

function check_warehouse_detail()
{
    $whid = $this->input->post("whid");
    
    $sql = "wh_id = '".$whid."'";
    $this->load->model('tp_warehouse_model','',TRUE);
    $query = $this->tp_warehouse_model->getWarehouse($sql);

    $wh_id = "";
    $wh_detail = "";
    $wh_address1 = "";
    $wh_address2 = "";
    $wh_taxid = "";
    $wh_branch = -1;
    $wh_vender = "";

    foreach($query as $loop) {
        $wh_id = $loop->wh_id;
        $wh_detail = $loop->wh_detail;
        $wh_address1 = $loop->wh_address1;
        $wh_address2 = $loop->wh_address2;
        $wh_taxid = $loop->wh_taxid;
        $wh_branch = $loop->wh_branch;
        $wh_vender = $loop->wg_vender;
    }

    $result = array("wh_id" => $wh_id, "wh_detail" => $wh_detail, "wh_address1" => $wh_address1, "wh_address2" => $wh_address2, "wh_taxid" => $wh_taxid, "wh_branch" => $wh_branch, "wh_vender" => $wh_vender);

    echo json_encode($result);
    exit();
}

function check_item_refcode()
{
    $refcode = $this->input->post("refcode");

    $output = array();
    $index = 0 ;
    $sql = "it_refcode = '".$refcode."' and it_enable = '1'";
    $this->load->model('tp_item_model','',TRUE);
    $result = $this->tp_item_model->getItem($sql);
    
    if (count($result) >0) {
        foreach($result as $loop) {
            $output[$index] = "<td>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td><input type='text' name='it_qty' id='it_qty' value='1' onChange='calculate();'></td><td><input type='hidden' name='it_srp' id='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp, 2, ".", ",")."</td><td><input type='text' name='it_discount' id='it_discount' value='' onChange='calDiscount();'></td><td><input type='text' name='it_netprice' id='it_netprice' value='".number_format($loop->it_srp, 2, ".", ",")."' onChange='calculate();'></td>";
            $index++;
        }
    }

    echo json_encode($output);
    exit();
}

function check_sale_barcode()
{
    $barcode = $this->input->post("barcode");

    $output = "";
    $index = 0 ;
    $sql = "sb_number = '".$barcode."' and sb_enable = '1'";
    $this->load->model('tp_saleorder_model','',TRUE);
    $result = $this->tp_saleorder_model->getSaleBarcode($sql);
    
    if (count($result) >0) {
        foreach($result as $loop) {
            $output = $loop->sb_gp;
        }
    }

    echo $output;
    exit();
}


}
?>