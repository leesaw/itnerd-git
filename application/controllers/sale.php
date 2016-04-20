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
    $caseback = $this->input->post("caseback");
    
    $shop_id = explode('#', $shop_id);
    $shop_name = $shop_id[1];
    $shop_id = $shop_id[0];
    
    $shop_code = explode("-", $shop_name);
    $shop_code = $shop_code[0];

    $data['datein'] = $datein;
    $data['shop_id'] = $shop_id;
    $data['shop_name'] = $shop_name;
    $data['shop_code'] = $shop_code;
    $data['caseback'] = $caseback;
    
    $data['title'] = "Nerd - Sale Order";
    $this->load->view("TP/sale/saleorder_select_item", $data);
}
    
function check_code()
{
    $refcode = $this->input->post("refcode");
    $shop_id = $this->input->post("shop_id");
    $caseback = $this->input->post("caseback");

    $output = "";
    
    if ($caseback == 0) {
        $sql = "it_enable = '1' and it_refcode = '".$refcode."' and sh_id = '".$shop_id."'".$this->qty_limit;
        $sql .= " and it_has_caseback = '".$caseback."'";
        $result = $this->tp_shop_model->getItem_refcode($sql);
    }else{
        $sql = "it_enable = '1' and itse_serial_number = '".$refcode."' and itse_enable = '1' and sh_id = '".$shop_id."'".$this->qty_limit;
        $result = $this->tp_shop_model->getItem_serial($sql);
    }
    
    

    if (count($result) >0) {
        foreach($result as $loop) {
            $output .= "<td><input type='hidden' name='stob_id' id='stob_id' value='".$loop->stob_id."'><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td>".number_format($loop->it_srp)."</td>";
            
            if ($loop->it_has_caseback != '1') {
                $output .= "<td><input type='text' name='it_quantity' id='it_quantity' value='1' style='width: 50px;'></td>";
            }else{
                $output .= "<td><input type='hidden' name='it_quantity' id='it_quantity' value='1'><input type='hidden' name='serial_id' id='serial_id' value='".$loop->itse_id."'><input type='text' name='it_serial' id='it_serial' value='".$loop->itse_serial_number."' style='width: 150px;' readonly></td>";
            }
            $output .= "<td>".$loop->it_uom."</td>";
            
            $sql = "sb_item_brand_id = '".$loop->br_id."' and sb_shop_group_id = '".$loop->sh_group_id."' and sb_enable = '1'";
            $barcode = $this->tp_shop_model->getBarcode_shop_group($sql);
            
            $output .= "<td>";
            if (count($barcode) > 0) {
                $output .= "<select name='barcode_id' id ='barcode_id'><option value='-10'>-- เลือกบาร์โค้ดห้าง --</option>";
                $output .= "<option value='0'>ไม่มีบาร์โค้ดห้าง</option>";
                foreach($barcode as $loop_barcode) {
                    $output .= "<option value = '".$loop_barcode->sb_id."'>".$loop_barcode->sb_number."(ลด".$loop_barcode->sb_discount_percent."% GP".$loop_barcode->sb_gp."%)</option>";
                }
                $output .= "</select>";
                $output .= "<input type='hidden' name='discount_value' id='discount_value' value='0'><input type='hidden' name='discount_baht' id='discount_baht' value='0'><input type='hidden' name='gp_value' id='gp_value' value='0'>";
            }else{
                $output .= "<label class='text-blue'>Discount(%) <input type='text' name='discount_value' id='discount_value' value='' style='width: 50px;'></label> <label class='text-green'>GP(%) <input type='text' name='gp_value' id='gp_value' value='' style='width: 50px;'></label> &nbsp;&nbsp;&nbsp;&nbsp;<label class='text-red'>Discount(บาท) <input type='text' name='discount_baht' id='discount_baht' value='0' style='width: 100px;'></label>";
                $output .= "<input type='hidden' name='barcode_id' id='barcode_id' value='-1'>";
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
    $serial_array = $this->input->post("serial");
    $caseback = $this->input->post("caseback");
    $saleorder_remark = $this->input->post("saleorder_remark");
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
                    'so_remark' => $saleorder_remark,
                    'so_dateadd_by' => $this->session->userdata('sessid')
            );
    $last_id = $this->tp_saleorder_model->addSaleOrder($sale);
    
    for($i=0; $i<count($it_array); $i++){
        // add item to so
        $sale = array(  'soi_saleorder_id' => $last_id,
                        'soi_item_id' => $it_array[$i]["id"],
                        'soi_qty' => $it_array[$i]["qty"],
                        'soi_sale_barcode_id' => $it_array[$i]["barcode_id"],
                        'soi_dc_percent' => $it_array[$i]["discount_value"],
                        'soi_dc_baht' => $it_array[$i]["discount_baht"],
                        'soi_gp' => $it_array[$i]["gp_value"]
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
    
    if ($caseback == 1) {
        for($i=0; $i<count($serial_array); $i++){
            $stock = array( 'sos_saleorder_id' => $last_id,
                            'sos_item_id' => $serial_array[$i]["id"],
                            'sos_item_serial_id' => $serial_array[$i]["serial"]
            );

            $query = $this->tp_saleorder_model->addSaleOrder_serial($stock);
            $this->load->model('tp_item_model','',TRUE);
            $serial_item = array( 'id' => $serial_array[$i]["serial"],
                                 'itse_enable' => 0
                            );
            $query = $this->tp_item_model->editItemSerial($serial_item);

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
    
    $sql = "sos_saleorder_id = '".$id."'";
    $query = $this->tp_saleorder_model->getSaleSerial($sql);
    if($query){
        $data['serial_array'] =  $query;
    }else{
        $data['serial_array'] = array();
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
    
function saleorder_POS_history()
{
    $datein = $this->input->post("datein");
    if ($datein !="") {
        $month = explode('/',$datein);
        $currentdate = $month[1]."-".$month[0];
    }else{
        $currentdate = date("Y-m");
    }
    
    $start = $currentdate."-01 00:00:00";
    $end = $currentdate."-31 23:59:59";
    
    $sql = "posro_issuedate >= '".$start."' and posro_issuedate <= '".$end."' and posro_shop_id = '888'";
    $query = $this->tp_saleorder_model->getPOS_rolex($sql);
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
    
function saleorder_POS_temp_history()
{
    $datein = $this->input->post("datein");
    if ($datein !="") {
        $month = explode('/',$datein);
        $currentdate = $month[1]."-".$month[0];
    }else{
        $currentdate = date("Y-m");
    }

    $start = $currentdate."-01 00:00:00";
    $end = $currentdate."-31 23:59:59";
    
    $sql = "posrot_dateadd >= '".$start."' and posrot_dateadd <= '".$end."' and posrot_shop_id = '888'";
    $query = $this->tp_saleorder_model->getPOS_rolex_temp($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }
    $currentdate = explode('-', $currentdate);
    $currentdate = $currentdate[1]."/".$currentdate[0];
    $data["currentdate"] = $currentdate;
    $data['title'] = "Nerd - Report";
    $this->load->view("TP/sale/report_saleorder_POS_temp_history", $data);
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
    
function saleorder_history()
{
    $datein = $this->input->post("datein");
    if ($datein !="") {
        $month = explode('/',$datein);
        $currentdate = $month[1]."-".$month[0];
    }else{
        $currentdate = date("Y-m");
    }
    
    $currentdate = explode('-', $currentdate);
    $currentmonth = $currentdate[1]."/".$currentdate[0];
    
    $data['month'] = $currentmonth;
    
    $start = $currentdate[0]."-".$currentdate[1]."-01 00:00:00";
    $end = $currentdate[0]."-".$currentdate[1]."-31 23:59:59";
    $sql = "so_enable = '1'";
    if ($this->session->userdata('sessstatus') != '88') {
        $sql .= " and ".$this->shop_rolex;
    }
    //$sql .= " and stoi_dateadd >= '".$start."' and stoi_dateadd <= '".$end."'";
    
    $data['final_array'] = $this->tp_saleorder_model->getSaleOrder($sql);
    
    $data['title'] = "Nerd - Report Sale Order";
    $this->load->view("TP/sale/report_sale_order_list", $data);
}
    
function report_sale_form()
{
    $this->load->model('tp_item_model','',TRUE);
    $this->load->model('tp_shop_model','',TRUE);
    
    $sql = "";
    
    if ($this->session->userdata('sessstatus') != '88') {
        $sql .= $this->no_rolex;
    }else{ $sql .= "br_id != 888"; }
    $data['brand_array'] = $this->tp_item_model->getBrand($sql);
    $sql = "sh_enable = '1'";
    $data['shop_array'] = $this->tp_shop_model->getShop($sql);

    $data['title'] = "Nerd - Search Sale Report";
    $this->load->view('TP/sale/search_salereport',$data);
}
    
function report_sale_filter()
{
    $refcode = $this->input->post("refcode");
    $brand = $this->input->post("brand");
    $shop = $this->input->post("shop");

    if ($refcode == "") $refcode = "NULL";
    $data['refcode'] = $refcode;
    
    $brand_array = explode("-", $brand);
    $brand_code = $brand_array[0];
    $brand_name = $brand_array[1];
    $data['brand_id'] = $brand_code;
    $data['brand_name'] = $brand_name;
    
    $shop_array = explode("-", $shop);
    $shop_code = $shop_array[0];
    $shop_name = $shop_array[1];
    $data['shop_id'] = $shop_code;
    $data['shop_name'] = $shop_name;

    
    
    $start = $this->input->post("startdate");
    if ($start != "") {
        $start = explode('/', $start);
        $start= $start[2]."-".$start[1]."-".$start[0];
    }else{
        $start = "1970-01-01";
    }
    $end = $this->input->post("enddate");
    if ($end != "") {
        $end = explode('/', $end);
        $end= $end[2]."-".$end[1]."-".$end[0];
    }else{
        $end = date('Y-m-d');
    }
    
    $data['startdate'] = $start;
    $data['enddate'] = $end;

    $data['title'] = "Nerd - Search Sale Report";
    $this->load->view('TP/sale/search_salereport_result',$data);
}
    
function ajaxViewSaleReport()
{
    $refcode = $this->uri->segment(3);
    $keyword = explode("%20", $refcode);
    $brand = $this->uri->segment(4);
    $shop = $this->uri->segment(5);
    $startdate = $this->uri->segment(6);
    $enddate = $this->uri->segment(7);
    
    $sql = "";
    if ($this->session->userdata('sessstatus') != '88') {
        $sql .= $this->no_rolex;
    }else{ $sql .= "br_id != 888"; }
    
    $sql .= " and so_issuedate >= '".$startdate."' and so_issuedate <= '".$enddate."'";
    
    if (($brand=="0") && ($shop=="0")){
        if ($keyword[0]!="NULL") {
            if (count($keyword) < 2) { 
                $sql .= " and (it_short_description like '%".$refcode."%' or it_refcode like '%".$refcode."%')";
            }else{
                for($i=0; $i<count($keyword); $i++) {
                    $sql .= " and (it_short_description like '%".$keyword[$i]."%' or it_refcode like '%".$keyword[$i]."%')";
                }
            }
        }
    }else {
        if ($keyword[0]!="NULL") {
            $keyword = explode(" ",$refcode);
            if (count($keyword) < 2) {
                $sql .= " and (it_short_description like '%".$refcode."%' or it_refcode like '%".$refcode."%')";
            }else{
                for($i=0; $i<count($keyword); $i++) {
                    $sql .= " and (it_short_description like '%".$keyword[$i]."%' or it_refcode like '%".$keyword[$i]."%')";
                }
            }
        }else{
            $sql .= " and it_refcode like '%%'";
        }
        
        if ($brand!="0") $sql .= " and br_id = '".$brand."'";
        else $sql .= " and br_id != '0'";
            
        if ($shop!="0") $sql .= " and sh_id = '".$shop."'";
        else $sql .= " and sh_id != '0'";

    }
    
    $this->load->library('Datatables');
    $this->datatables
    ->select("so_issuedate, sh_name, it_refcode, br_name, soi_qty, it_srp, sb_number, IF( soi_sale_barcode_id >0, sb_discount_percent, soi_dc_percent ) as dc, soi_dc_baht,IF( soi_sale_barcode_id >0, sb_gp, soi_gp ) as gp, (((it_srp*(100 - ( select dc ))/100) - soi_dc_baht )*(100 - ( select gp ))/100) as netprice")
    ->from('tp_saleorder_item')
    ->join('tp_saleorder', 'so_id = soi_saleorder_id','left')
    ->join('tp_shop', 'so_shop_id = sh_id','left')
    ->join('tp_sale_barcode', 'soi_sale_barcode_id = sb_id','left')
    ->join('tp_item', 'it_id = soi_item_id','left')
    ->join('tp_brand', 'br_id = it_brand_id','left')
    //->join('tp_item_serial', 'itse_item_id=stob_item_id and itse_warehouse_id=stob_warehouse_id','left')
    ->where('so_enable',1)
    ->where($sql);
    echo $this->datatables->generate(); 
}
    
function exportExcel_sale_report()
{
    $refcode = $this->input->post("refcode");
    $keyword = explode(" ", $refcode);
    $brand = $this->input->post("brand");
    $shop = $this->input->post("shop");
    $startdate = $this->input->post("startdate");
    $enddate = $this->input->post("enddate");
    
    $sql = $this->no_rolex;
    
    $sql .= " and so_enable = '1' and so_issuedate >= '".$startdate."' and so_issuedate <= '".$enddate."'";
    
    if (($brand=="0") && ($shop=="0")){
        if ($keyword[0]!="NULL") {
            if (count($keyword) < 2) { 
                $sql .= " and (it_short_description like '%".$refcode."%' or it_refcode like '%".$refcode."%')";
            }else{
                for($i=0; $i<count($keyword); $i++) {
                    $sql .= " and (it_short_description like '%".$keyword[$i]."%' or it_refcode like '%".$keyword[$i]."%')";
                }
            }
        }
    }else {
        if ($keyword[0]!="NULL") {
            $keyword = explode(" ",$refcode);
            if (count($keyword) < 2) {
                $sql .= " and (it_short_description like '%".$refcode."%' or it_refcode like '%".$refcode."%')";
            }else{
                for($i=0; $i<count($keyword); $i++) {
                    $sql .= " and (it_short_description like '%".$keyword[$i]."%' or it_refcode like '%".$keyword[$i]."%')";
                }
            }
        }else{
            $sql .= " and it_refcode like '%%'";
        }
        
        if ($brand!="0") $sql .= " and br_id = '".$brand."'";
        else $sql .= " and br_id != '0'";
            
        if ($shop!="0") $sql .= " and sh_id = '".$shop."'";
        else $sql .= " and sh_id != '0'";

    }
    
    $item_array = $this->tp_saleorder_model->getSaleOrder_Item($sql);
    
    //load our new PHPExcel library
    $this->load->library('excel');
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Sale Report');

    $this->excel->getActiveSheet()->setCellValue('A1', 'Sold Date');
    $this->excel->getActiveSheet()->setCellValue('B1', 'Shop');
    $this->excel->getActiveSheet()->setCellValue('C1', 'Ref. Number');
    $this->excel->getActiveSheet()->setCellValue('D1', 'Brand');
    $this->excel->getActiveSheet()->setCellValue('E1', 'Qty (Pcs.)');
    $this->excel->getActiveSheet()->setCellValue('F1', 'SRP');
    $this->excel->getActiveSheet()->setCellValue('G1', 'BAR');
    $this->excel->getActiveSheet()->setCellValue('H1', 'Discount (%)');
    $this->excel->getActiveSheet()->setCellValue('I1', 'On Top (บาท)');
    $this->excel->getActiveSheet()->setCellValue('J1', 'GP (%)');
    $this->excel->getActiveSheet()->setCellValue('K1', 'Receive on Inv.');
    
    $row = 2;
    foreach($item_array as $loop) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->so_issuedate);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->sh_name);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->it_refcode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->br_name);    
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->soi_qty);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, number_format($loop->it_srp, 2, '.', ','));
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $loop->sb_number);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->dc);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, number_format($loop->soi_dc_baht, 2, '.', ','));
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->gp);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, number_format($loop->netprice, 2, '.', ','));
        $row++;
    }
    

    $filename='sale_report.xlsx'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache

    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
}
    
}
?>