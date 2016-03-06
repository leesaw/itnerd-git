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
    $shop_id = $this->input->post("shop_id");
    
    $output = "";
    $sql = "itse_serial_number = '".$refcode."' and itse_enable = '1' and sh_id = '".$shop_id."'";
    
    $result = $this->tp_shop_model->getItem_serial($sql);
    
    if (count($result) >0) {
        foreach($result as $loop) {
            $output .= "<td><input type='hidden' name='stob_id' id='stob_id' value='".$loop->stob_id."'><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'><input type='hidden' name='it_srp' id='it_srp' value='".$loop->it_srp."'><input type='hidden' name='itse_id' id='itse_id' value='".$loop->itse_id."'>".$loop->it_refcode."</td><td>".$loop->itse_serial_number."</td><td>".$loop->it_short_description."</td><td>".$loop->it_model."</td><td>".$loop->it_remark."</td><td><input type='text' name='it_quantity' id='it_quantity' value='1 ".$loop->it_uom."' style='width: 50px;' readonly></td><td>".number_format($loop->it_srp)."</td>";
        }
    }
    
    
    echo $output;
}
    
function check_saleperson_rolex()
{
    $saleperson_id = $this->input->post("saleperson_id");
    $shop_id = $this->input->post("shop_id");
    
    $output = "";
    $sql = "sp_barcode = '".$saleperson_id."' and sp_shop_id = '".$shop_id."' and sp_enable = '1'";
    
    $this->load->model('tp_saleperson_model','',TRUE);
    $result = $this->tp_saleperson_model->getSalePerson($sql);
    
    if (count($result) >0) {
        foreach($result as $loop) {
            $output .= $loop->sp_firstname." ".$loop->sp_lastname;
            $saleperson_id = $loop->sp_id;
        }
    }
    
    $result = array("a" => $output, "b" => $saleperson_id);
    echo json_encode($result);
}
    
function saleorder_rolex_save()
{
    $cusname = $this->input->post("cusname");
    $cusaddress = $this->input->post("cusaddress");
    $custax_id = $this->input->post("custax_id");
    $custelephone = $this->input->post("custelephone");
    $payment = $this->input->post("payment");
    $payment_value = $this->input->post("payment_value");
    $remark = $this->input->post("remark");
    
    $shop_id = $this->input->post("shop_id");
    $saleperson_code = $this->input->post("saleperson_code");
    $it_array = $this->input->post("item");
    $datein = $this->input->post("datein");
    
    $currentdate = date("Y-m-d H:i:s");
    
    $datein = explode('/', $datein);
    $datein = $datein[2]."-".$datein[1]."-".$datein[0];
    $month = date("Y-m");
    $month_array = explode('-',date("y-m"));
    
    $number = $this->tp_saleorder_model->getMaxNumber_rolex_shop($month, $shop_id);
    $number++;
    
    $number = "NGGTP".$month_array[0].$month_array[1].str_pad($number, 3, '0', STR_PAD_LEFT);

    $sale = array( 'posro_number' => $number,
                    'posro_issuedate' => $datein,
                    'posro_dateadd' => $currentdate,
                    'posro_shop_id' => $shop_id,
                    'posro_customer_name' => $cusname,
                    'posro_customer_address' => $cusaddress,
                    'posro_customer_taxid' => $custax_id,
                    'posro_customer_tel' => $custelephone,
                    'posro_sale_person_id' => $saleperson_code,
                    'posro_payment' => $payment,
                    'posro_payment_value' => $payment_value,
                    'posro_remark' => $remark,
                    'posro_dateadd_by' => $this->session->userdata('sessid')
            );
    $last_id = $this->tp_saleorder_model->addPOS_rolex($sale);
    $count = 0;
    for($i=0; $i<count($it_array); $i++){
        // add item to so
        $net = $it_array[$i]["it_srp"]-$it_array[$i]["dc_thb"];
        $sale = array(  'posroi_pos_rolex_id' => $last_id,
                        'posroi_item_id' => $it_array[$i]["id"],
                        'posroi_qty' => $it_array[$i]["qty"],
                        'posroi_item_serial_number_id' => $it_array[$i]["itse_id"],
                        'posroi_stock_balance_id' => $it_array[$i]["stob_id"],
                        'posroi_item_srp' => $it_array[$i]["it_srp"],
                        'posroi_dc_baht' => $it_array[$i]["dc_thb"],
                        'posroi_netprice' => $net
            );
        $query = $this->tp_saleorder_model->addPOS_rolex_item($sale);
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
        
        $serial = array("id" => $it_array[$i]["itse_id"], "itse_enable" => 0, "itse_dateadd" => $currentdate);
        
        $this->load->model('tp_item_model','',TRUE);
        $query = $this->tp_item_model->editItemSerial($serial);
    }

    $result = array("a" => $count, "b" => $last_id);
    echo json_encode($result);
    exit();
}
    
function saleorder_rolex_print()
{
    $id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th','A4','0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');
    $mpdf->SetWatermarkImage(base_url()."dist/img/logo-nggtp.jpg", 0.05, array(100,60), array(55,110));
    $mpdf->showWatermarkImage = true;

    $sql = "posro_id = '".$id."'";
    $query = $this->tp_saleorder_model->getPOS_rolex($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }

    $sql = "posroi_pos_rolex_id = '".$id."'";
    $query = $this->tp_saleorder_model->getPOS_rolex_item($sql);
    if($query){
        $data['item_array'] =  $query;
    }else{
        $data['item_array'] = array();
    }

    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/sale/bill_rolex_print", $data, TRUE));
    $mpdf->Output();
}
    
function saleorder_rolex_pos_last()
{
    $id = $this->uri->segment(3);

    $sql = "posro_id = '".$id."'";
    $query = $this->tp_saleorder_model->getPOS_rolex($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }

    $sql = "posroi_pos_rolex_id = '".$id."'";
    $query = $this->tp_saleorder_model->getPOS_rolex_item($sql);
    if($query){
        $data['item_array'] =  $query;
    }else{
        $data['item_array'] = array();
    }
    
    $data['pos_rolex_id'] = $id;
    $data['title'] = "Rolex - Sale Memo";
    $this->load->view("TP/sale/saleorder_pos_view", $data);
}
    
function saleorder_rolex_pos_history()
{
    $currentdate = date("Y-m");
    $currentdate = explode('-', $currentdate);
    $currentmonth = $currentdate[1]."/".$currentdate[0];
    $data['month'] = $currentmonth;
    
    $start = $currentdate[0]."-".$currentdate[1]."-01 00:00:00";
    $end = $currentdate[0]."-".$currentdate[1]."-31 23:59:59";
    
    $sql = "stoi_is_rolex = ".$this->session->userdata('sessrolex');
    $sql .= " and stoi_dateadd >= '".$start."' and stoi_dateadd <= '".$end."'";
    $data['final_array'] = $this->tp_warehouse_transfer_model->getWarehouse_stockin_list($sql);
    
    $data['title'] = "Nerd - Report Transfer In";
    $this->load->view("TP/warehouse/report_stockin_item", $data);
}
    
function saleorder_POS_today()
{
    $currentdate = date("Y-m-d");
    //$start = $currentdate." 00:00:00";
    //$end = $currentdate." 23:59:59";
    
    $sql = "posro_issuedate = '".$currentdate."' and posro_shop_id = '888'";
    $query = $this->tp_saleorder_model->getPOS_rolex($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }
    $currentdate = explode('-', $currentdate);
    $currentdate = $currentdate[2]."/".$currentdate[1]."/".$currentdate[0];
    $data["currentdate"] = $currentdate;
    $data['title'] = "Nerd - Report";
    $this->load->view("TP/sale/report_saleorder_POS_today", $data);
}
    
function saleorder_POS_temp()
{
    $datein = date("d/m/Y");
    
    // shop rolex
    $sql = "sh_id = '888'";
    $data['shop_array'] = $this->tp_shop_model->getShop($sql);

    $data['datein'] = $datein;
    $data['title'] = "Rolex - Sale Memo";
    $this->load->view("TP/sale/saleorder_pos_temp", $data);
}
    
function saleorder_rolex_temp_save()
{
    $cusname = $this->input->post("cusname");
    $cusaddress = $this->input->post("cusaddress");
    $custelephone = $this->input->post("custelephone");
    $payment = $this->input->post("payment");
    $payment_value = $this->input->post("payment_value");
    $remark = $this->input->post("remark");
    
    $shop_id = $this->input->post("shop_id");
    $saleperson_code = $this->input->post("saleperson_code");
    $it_array = $this->input->post("item");
    $datein = $this->input->post("datein");
    
    $currentdate = date("Y-m-d H:i:s");
    
    $datein = explode('/', $datein);
    $datein = $datein[2]."-".$datein[1]."-".$datein[0];
    $month = date("Y-m");
    $month_array = explode('-',date("y-m"));
    
    $number = $this->tp_saleorder_model->getMaxNumber_rolex_temp_shop($month, $shop_id);
    $number++;
    
    $number = "NGGTP-B".$month_array[0].$month_array[1].str_pad($number, 3, '0', STR_PAD_LEFT);

    $sale = array( 'posrot_number' => $number,
                    'posrot_issuedate' => $datein,
                    'posrot_dateadd' => $currentdate,
                    'posrot_shop_id' => $shop_id,
                    'posrot_customer_name' => $cusname,
                    'posrot_customer_address' => $cusaddress,
                    'posrot_customer_tel' => $custelephone,
                    'posrot_sale_person_id' => $saleperson_code,
                    'posrot_payment' => $payment,
                    'posrot_payment_value' => $payment_value,
                    'posrot_remark' => $remark,
                    'posrot_dateadd_by' => $this->session->userdata('sessid')
            );
    $last_id = $this->tp_saleorder_model->addPOS_rolex_temp($sale);
    $count = 0;
    for($i=0; $i<count($it_array); $i++){
        // add item to so
        $net = $it_array[$i]["it_srp"]-$it_array[$i]["dc_thb"];
        $sale = array(  'posroit_pos_rolex_temp_id' => $last_id,
                        'posroit_item_id' => $it_array[$i]["id"],
                        'posroit_qty' => $it_array[$i]["qty"],
                        'posroit_item_serial_number_id' => $it_array[$i]["itse_id"],
                        'posroit_stock_balance_id' => $it_array[$i]["stob_id"],
                        'posroit_item_srp' => $it_array[$i]["it_srp"],
                        'posroit_dc_baht' => $it_array[$i]["dc_thb"],
                        'posroit_netprice' => $net
            );
        $query = $this->tp_saleorder_model->addPOS_rolex_item_temp($sale);
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
        
        $serial = array("id" => $it_array[$i]["itse_id"], "itse_enable" => 0, "itse_dateadd" => $currentdate);
        
        $this->load->model('tp_item_model','',TRUE);
        $query = $this->tp_item_model->editItemSerial($serial);
    }

    $result = array("a" => $count, "b" => $last_id);
    echo json_encode($result);
    exit();
}
    
function saleorder_rolex_temp_print()
{
    $id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th','A4','0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');
    $mpdf->SetWatermarkImage(base_url()."dist/img/logo-nggtp.jpg", 0.05, array(100,60), array(55,110));
    $mpdf->showWatermarkImage = true;

    $sql = "posrot_id = '".$id."'";
    $query = $this->tp_saleorder_model->getPOS_rolex_temp($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }

    $sql = "posroit_pos_rolex_temp_id = '".$id."'";
    $query = $this->tp_saleorder_model->getPOS_rolex_temp_item($sql);
    if($query){
        $data['item_array'] =  $query;
    }else{
        $data['item_array'] = array();
    }

    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/sale/bill_temp_rolex_print", $data, TRUE));
    $mpdf->Output();
}
    
function saleorder_rolex_pos_temp_last()
{
    $id = $this->uri->segment(3);

    $sql = "posrot_id = '".$id."'";
    $query = $this->tp_saleorder_model->getPOS_rolex_temp($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }

    $sql = "posroit_pos_rolex_temp_id = '".$id."'";
    $query = $this->tp_saleorder_model->getPOS_rolex_temp_item($sql);
    if($query){
        $data['item_array'] =  $query;
    }else{
        $data['item_array'] = array();
    }
    
    $data['pos_rolex_id'] = $id;
    $data['title'] = "Rolex - Sale Memo";
    $this->load->view("TP/sale/saleorder_pos_temp_view", $data);
}
    
function saleorder_POS_temp_today()
{
    $currentdate = date("Y-m-d");
    $start = $currentdate." 00:00:00";
    $end = $currentdate." 23:59:59";
    
    $sql = "posrot_dateadd >= '".$start."' and posrot_dateadd <= '".$end."' and posrot_shop_id = '888'";
    $query = $this->tp_saleorder_model->getPOS_rolex_temp($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }
    $currentdate = explode('-', $currentdate);
    $currentdate = $currentdate[2]."/".$currentdate[1]."/".$currentdate[0];
    $data["currentdate"] = $currentdate;
    $data['title'] = "Nerd - Report";
    $this->load->view("TP/sale/report_saleorder_POS_temp_today", $data);
}
    
function saleorder_rolex_void_pos()
{
    $id = $this->uri->segment(3);
    
    $currentdate = date("Y-m-d H:i:s");
    
    $sql = "posro_id = '".$id."'";
    $query = $this->tp_saleorder_model->getPOS_rolex($sql);
    foreach($query as $loop) {
        $remark = $loop->posro_remark;
        $shop_id = $loop->posro_shop_id;
    }
    $remark .= "##VOID##".$this->input->post("remarkvoid");
    $pos = array("id" => $id, "posro_status" => 'V', "posro_remark" => $remark,
                "posro_dateadd" => $currentdate, "posro_dateadd_by" => $this->session->userdata('sessid')
                );
    $query = $this->tp_saleorder_model->editPOS_rolex($pos);
    
    $sql = "posroi_pos_rolex_id = '".$id."'";
    $query = $this->tp_saleorder_model->getPOS_rolex_item($sql);
    foreach($query as $loop) {
        // increase stock warehouse out
        $qty_update = $loop->posroi_qty;
        $itse_id = $loop->posroi_item_serial_number_id;
        $this->load->model('tp_warehouse_transfer_model','',TRUE);
        $sql = "stob_id = '".$loop->posroi_stock_balance_id."'";
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);

        if (!empty($query)) {
            foreach($query as $loop) {
                $qty_new = $loop->stob_qty + $qty_update;
                $stock = array( 'id' => $loop->stob_id,
                                'stob_qty' => $qty_new,
                                'stob_lastupdate' => $currentdate,
                                'stob_lastupdate_by' => $this->session->userdata('sessid')
                            );
                $query = $this->tp_warehouse_transfer_model->editWarehouse_transfer($stock);
                break;
            }
        }
        
        $serial = array("id" => $itse_id, "itse_enable" => 1, "itse_dateadd" => $currentdate);
        $this->load->model('tp_item_model','',TRUE);
        $query = $this->tp_item_model->editItemSerial($serial);
    }
		
    redirect('sale/saleorder_POS_today', 'refresh');
}
    
function saleorder_rolex_void_pos_temp()
{
    $id = $this->uri->segment(3);
    
    $currentdate = date("Y-m-d H:i:s");
    
    $sql = "posrot_id = '".$id."'";
    $query = $this->tp_saleorder_model->getPOS_rolex_temp($sql);
    foreach($query as $loop) {
        $remark = $loop->posrot_remark;
        $shop_id = $loop->posrot_shop_id;
    }
    $remark .= "##VOID##".$this->input->post("remarkvoid");
    $pos = array("id" => $id, "posrot_status" => 'V', "posrot_remark" => $remark,
                "posrot_dateadd" => $currentdate, "posrot_dateadd_by" => $this->session->userdata('sessid')
                );
    $query = $this->tp_saleorder_model->editPOS_rolex_temp($pos);
    
    $sql = "posroit_pos_rolex_temp_id = '".$id."'";
    $query = $this->tp_saleorder_model->getPOS_rolex_temp_item($sql);
    foreach($query as $loop) {
        // increase stock warehouse out
        $qty_update = $loop->posroit_qty;
        $itse_id = $loop->posroit_item_serial_number_id;
        $this->load->model('tp_warehouse_transfer_model','',TRUE);
        $sql = "stob_id = '".$loop->posroit_stock_balance_id."'";
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);

        if (!empty($query)) {
            foreach($query as $loop) {
                $qty_new = $loop->stob_qty + $qty_update;
                $stock = array( 'id' => $loop->stob_id,
                                'stob_qty' => $qty_new,
                                'stob_lastupdate' => $currentdate,
                                'stob_lastupdate_by' => $this->session->userdata('sessid')
                            );
                $query = $this->tp_warehouse_transfer_model->editWarehouse_transfer($stock);
                break;
            }
        }
        
        $serial = array("id" => $itse_id, "itse_enable" => 1, "itse_dateadd" => $currentdate);
        $this->load->model('tp_item_model','',TRUE);
        $query = $this->tp_item_model->editItemSerial($serial);
    }
		
    redirect('sale/saleorder_POS_temp_today', 'refresh');
}
    
}
?>