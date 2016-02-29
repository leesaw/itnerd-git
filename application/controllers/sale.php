<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sale extends CI_Controller {

public $no_rolex = "";
public $shop_rolex = "";
public $qty_limit = " and stob_qty > 0";
    
function __construct()
{
     parent::__construct();
     $this->load->model('tp_saleorder_model','',TRUE);
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
    
function saleorder_view()
{
    $sql = $this->shop_rolex;
	$data['shop_array'] = $this->tp_shop_model->getShop($sql);
	$data['currentdate'] = date("d/m/Y");

    //$data['sessrolex'] = $this->session->userdata('sessrolex');
    $data['title'] = "Nerd - Sale Order";
    $this->load->view("TP/sale/saleorder_view", $data);
}
    
function saleorder_select_item()
{
    $datein = $this->input->post("datein");
    $shop_id = $this->input->post("shopid");
    
    $shop_id = explode('#', $shop_id);
    $shop_name = $shop_id[1];
    $shop_id = $shop_id[0];
    
    $shop_code = explode("-", $shop_name);
    $shop_code = $shop_code[0];

    $data['datein'] = $datein;
    $data['shop_id'] = $shop_id;
    $data['shop_name'] = $shop_name;
    $data['shop_code'] = $shop_code;
    
    $data['title'] = "Nerd - Sale Order";
    $this->load->view("TP/sale/saleorder_select_item", $data);
}
    
function check_code()
{
    $refcode = $this->input->post("refcode");
    $shop_id = $this->input->post("shop_id");
    
    $output = "";
    $sql = "it_refcode = '".$refcode."' and sh_id = '".$shop_id."'".$qty_limit;
    $result = $this->tp_shop_model->getItem_refcode($sql);
    
    if (count($result) >0) {
        foreach($result as $loop) {
            $output .= "<td><input type='hidden' name='stob_id' id='stob_id' value='".$loop->stob_id."'><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td>".number_format($loop->it_srp)."</td>";
            $output .= "<td><input type='text' name='it_quantity' id='it_quantity' value='1' style='width: 50px;'></td><td>".$loop->it_uom."</td>";
            
            $sql = "sb_item_brand_id = '".$loop->br_id."' and sb_shop_group_id = '".$loop->sh_group_id."' and sb_enable = '1'";
            $barcode = $this->tp_shop_model->getBarcode_shop_group($sql);
            
            $output .= "<td>";
            if (count($barcode) > 0) {
                $output .= "<select name='barcode_id' id ='barcode_id'><option value='-1'>-- เลือกบาร์โค้ดห้าง --</option>";
                foreach($barcode as $loop_barcode) {
                    $output .= "<option value = '".$loop_barcode->sb_id."'>".$loop_barcode->sb_number."(ลด".$loop_barcode->sb_discount_percent."% GP".$loop_barcode->sb_gp."%)</option>";
                }
                $output .= "</select>";
            }
            $output .= "</td>";
        }
    }
    
    
    echo $output;
}
    
function saleorder_save()
{
    $it_array = $this->input->post("item");
    $shop_id = $this->input->post("shop_id");
    $shop_code = $this->input->post("shop_code");
    $datein = $this->input->post("datein");
    $currentdate = date("Y-m-d H:i:s");
    
    $datein = explode('/', $datein);
    $datein = $datein[2]."-".$datein[1]."-".$datein[0];
    
    $count = 0;
    $month = date("Y-m");
    $month_array = explode('-',date("y-m"));
    
    $number = $this->tp_saleorder_model->getMaxNumber_saleorder_shop($month, $shop_id);
    $number++;
    
    $number = "SO-".$shop_code.$month_array[0].$month_array[1].str_pad($number, 4, '0', STR_PAD_LEFT);

    
    $sale = array( 'so_number' => $number,
                    'so_issuedate' => $datein,
                    'so_dateadd' => $currentdate,
                    'so_shop_id' => $shop_id,
                    'so_dateadd_by' => $this->session->userdata('sessid')
            );
    $last_id = $this->tp_saleorder_model->addSaleOrder($sale);
    
    for($i=0; $i<count($it_array); $i++){
        // add item to so
        $sale = array(  'soi_saleorder_id' => $last_id,
                        'soi_item_id' => $it_array[$i]["id"],
                        'soi_qty' => $it_array[$i]["qty"],
                        'soi_sale_barcode_id' => $it_array[$i]["barcode_id"]
            );
        $query = $this->tp_saleorder_model->addSaleItem($sale);
        $count += $it_array[$i]["qty"];
        // decrease stock warehouse out
        $this->load->model('tp_warehouse_transfer_model','',TRUE);
        $sql = "stob_id = '".$it_array[$i]["stob_id"]."'";
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);

        $qty_update = $it_array[$i]["qty"];

        if (!empty($query)) {
            foreach($query as $loop) {
                $qty_new = $loop->stob_qty - $qty_update;
                $stock = array( 'id' => $loop->stob_id,
                                'stob_qty' => $qty_new,
                                'stob_lastupdate' => $currentdate,
                                'stob_lastupdate_by' => $this->session->userdata('sessid')
                            );
                $query = $this->tp_warehouse_transfer_model->editWarehouse_transfer($stock);
                break;
            }
        }
        
    }

    $result = array("a" => $count, "b" => $last_id);
    echo json_encode($result);
    exit();
}
    
function saleorder_print()
{
    $id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');                
    $mpdf= new mPDF('th','A4','0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');

    $sql = "so_id = '".$id."'";
    $query = $this->tp_saleorder_model->getSaleOrder($sql);
    if($query){
        $data['so_array'] =  $query;
    }else{
        $data['so_array'] = array();
    }

    $sql = "soi_saleorder_id = '".$id."'";
    $query = $this->tp_saleorder_model->getSaleItem($sql);
    if($query){
        $data['item_array'] =  $query;
    }else{
        $data['item_array'] = array();
    }

    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/sale/saleorder_print", $data, TRUE));
    $mpdf->Output();
}
    
function saleorder_POS()
{
    $datein = date("d/m/Y");
    
    // shop rolex
    $sql = "sh_id = '888'";
    $data['shop_array'] = $this->tp_shop_model->getShop($sql);

    $data['datein'] = $datein;
    $data['title'] = "Rolex - Sale Memo";
    $this->load->view("TP/sale/saleorder_pos", $data);
}
    
function check_rolex_serial()
{
    $refcode = $this->input->post("refcode");
    
    $output = "";
    $sql = "itse_serial_number = '".$refcode."' and itse_enable = '1'";
    
    $this->load->model('tp_warehouse_transfer_model','',TRUE);
    $result = $this->tp_warehouse_transfer_model->getItem_stock_caseback($sql);
    
    if (count($result) >0) {
        foreach($result as $loop) {
            $output .= "<td><input type='hidden' name='stob_id' id='stob_id' value='".$loop->stob_id."'><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'><input type='hidden' name='itse_id' id='itse_id' value='".$loop->itse_id."'>".$loop->it_refcode."</td><td>".$loop->itse_serial_number."</td><td>".$loop->it_short_description."</td><td>".$loop->it_model."</td><td>".$loop->it_remark."</td><td><input type='text' name='it_quantity' id='it_quantity' value='1 ".$loop->it_uom."' style='width: 50px;' readonly></td><td>".number_format($loop->it_srp)."</td>";
        }
    }
    
    
    echo $output;
}
    
function saleorder_rolex_payment()
{
    $cusname = $this->input->post("cusname");
    $cusaddress = $this->input->post("cusaddress");
    $custax_id = $this->input->post("custax_id");
    $custelephone = $this->input->post("custelephone");
    
    $dc_thb = $this->input->post("dc_thb");
    $itse_id = $this->input->post("itse_id");
    $stob_id = $this->input->post("stob_id");
    
    $shop_id = $this->input->post("shop_id");
    $shop_name = $this->input->post("shop_name");
    $datein = $this->input->post("datein");
    //$currentdate = date("Y-m-d H:i:s");
    
    //$datein = explode('/', $datein);
    //$datein = $datein[2]."-".$datein[1]."-".$datein[0];
    $month = date("Y-m");
    $month_array = explode('-',date("y-m"));
    
    $number = $this->tp_saleorder_model->getMaxNumber_saleorder_shop($month, $shop_id);
    $number++;
    
    $number = "NGGTP".$month_array[0].$month_array[1].str_pad($number, 3, '0', STR_PAD_LEFT);

    $item_array = array();
    for($i=0; $i<count($itse_id); $i++) {
        $sql = "itse_serial_number = '".$itse_id[$i]."' and itse_enable = '1'";
        $this->load->model('tp_warehouse_transfer_model','',TRUE);
        $result = $this->tp_warehouse_transfer_model->getItem_stock_caseback($sql);
        foreach($result as $loop) {
            $item_array[] = array("it_id" => $loop->it_id, "itse_id" => $itse_id[$i], "stob_id" => $loop->stob_id, "it_refcode" => $loop->it_refcode, "it_serial" => $loop->itse_serial_number, "it_short_description" => $loop->it_short_description, "it_model" => $loop->it_model, "it_remark" => $loop->it_remark, "it_srp" => $loop->it_srp, "it_uom" => $loop->it_uom, "discount" => $dc_thb[$i]);
        }
    }
    
    $data['item_array'] = $item_array;
    $data['number'] = $number;
    $data['datein'] = $datein;
    $data['cusname'] = $cusname;
    $data['cusaddress'] = $cusaddress;
    $data['custax_id'] = $custax_id;
    $data['custelephone'] = $custelephone;
    $data['shop_id'] = $shop_id;
    $data['shop_name'] = $shop_name;
    $data['title'] = "Rolex - Sale Memo";
    $this->load->view("TP/sale/saleorder_pos_payment", $data);
}
    
}
?>