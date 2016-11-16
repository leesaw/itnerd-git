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
    $sql .= " and sh_enable = '1'";
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
            $output .= "<td><input type='hidden' name='stob_id' id='stob_id' value='".$loop->stob_id."'><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' id='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td>";

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
                $output .= "<select name='barcode_id' id ='barcode_id'><option value='-10'>-- เลือกบาร์โค้ด --</option>";
                $output .= "<option value='0'>ไม่มีบาร์โค้ด</option>";
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
                        'soi_item_srp' => $it_array[$i]["srp"],
                        'soi_sale_barcode_id' => $it_array[$i]["barcode_id"],
                        'soi_dc_percent' => $it_array[$i]["discount_value"],
                        'soi_dc_baht' => $it_array[$i]["discount_baht"],
                        'soi_gp' => $it_array[$i]["gp_value"]
            );
        $last_soi_id = $this->tp_saleorder_model->addSaleItem($sale);
        $count += $it_array[$i]["qty"];

        // add serial
        if ($caseback == 1) {
            $serial = array( 'sos_saleorder_id' => $last_id,
                            'sos_soi_id' => $last_soi_id,
                            'sos_item_id' => $serial_array[$i]["id"],
                            'sos_item_serial_id' => $serial_array[$i]["serial"]
            );

            $query = $this->tp_saleorder_model->addSaleOrder_serial($serial);
            $this->load->model('tp_item_model','',TRUE);
            $serial_item = array( 'id' => $serial_array[$i]["serial"],
                                     'itse_enable' => 0
                                );
            $query = $this->tp_item_model->editItemSerial($serial_item);

        }

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
    $cuspassport = $this->input->post("cuspassport");
    $custelephone = $this->input->post("custelephone");
    $refund = $this->input->post("refund");
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
                    'posro_customer_passport' => $cuspassport,
                    'posro_customer_tel' => $custelephone,
                    'posro_refund' => $refund,
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
    //$mpdf->SetWatermarkImage(base_url()."dist/img/logo-nggtp.jpg", 0.05, array(100,60), array(55,110));
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
    if ($this->session->userdata('sessstatus')==8) {
        $this->load->view("TP/sale/saleorder_pos_view_only", $data);
    }else{
        $this->load->view("TP/sale/saleorder_pos_view", $data);
    }
}

function saleorder_rolex_pos_today()
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

    if (($shop_id == 0) && ($saleperson_code == 0)) {
        $number = "NGGTP-DS".$month_array[0].$month_array[1].str_pad($number, 3, '0', STR_PAD_LEFT);
        $sale_status = 'D';
    }else{
        $number = "NGGTP-B".$month_array[0].$month_array[1].str_pad($number, 3, '0', STR_PAD_LEFT);
        $sale_status = 'N';
    }

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
                    'posrot_dateadd_by' => $this->session->userdata('sessid'),
                    'posrot_status' => $sale_status
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

        if (($this->input->post("borrow_item_id") != "") && ($this->input->post("borrow_item_id")>0) ) {
            $sale = array(  'id' => $this->input->post("borrow_item_id"),
                        'posrobi_enable' => 0,
                        'posrobi_pos_temp_id' => $last_id
            );
            $query = $this->tp_shop_model->editPOS_rolex_borrow_item($sale);
        }
    }

    $result = array("a" => $count, "b" => $last_id);
    echo json_encode($result);
    exit();
}

function saleorder_rolex_temp_save_edit()
{
    $cusname = $this->input->post("cusname");
    $cusaddress = $this->input->post("cusaddress");
    $custelephone = $this->input->post("custelephone");

    $payment = $this->input->post("payment");
    $payment_value = $this->input->post("payment_value");
    $remark = $this->input->post("remark");

    $it_array = $this->input->post("item");
    $datein = $this->input->post("datein");

    $pos_id = $this->input->post("pos_id");

    $currentdate = date("Y-m-d H:i:s");

    $datein = explode('/', $datein);
    $datein = $datein[2]."-".$datein[1]."-".$datein[0];

    $sale = array( 'id' => $pos_id,
                    'posrot_issuedate' => $datein,
                    'posrot_customer_name' => $cusname,
                    'posrot_customer_address' => $cusaddress,
                    'posrot_customer_tel' => $custelephone,
                    'posrot_payment' => $payment,
                    'posrot_payment_value' => $payment_value,
                    'posrot_dateadd' => $currentdate,
                    'posrot_dateadd_by' => $this->session->userdata('sessid'),
                    'posrot_remark' => $remark
            );

    $query = $this->tp_saleorder_model->editPOS_rolex_temp($sale);

    $count = 0;
    for($i=0; $i<count($it_array); $i++){
        // edit item to so
        $net = $it_array[$i]["it_srp"]-$it_array[$i]["dc_thb"];
        $sale_item = array(  'id' => $it_array[$i]["posroit_id"],
                        'posroit_dc_baht' => $it_array[$i]["dc_thb"],
                        'posroit_netprice' => $net
            );
        $query = $this->tp_saleorder_model->editPOS_rolex_temp_item($sale_item);
        $count ++;
    }


    $result = array("a" => $count, "b" => $pos_id);
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
    //$mpdf->showWatermarkImage = true;

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


    foreach($query as $loop1) {
        if ($loop1->posrot_status == 'D' and $loop1->posrot_shop_id == 0) {
            $sql = "posroit_pos_rolex_temp_id = '".$id."'";
            $query = $this->tp_saleorder_model->getPOS_rolex_temp_item_borrow($sql);
            foreach($query as $loop2) {
                $data["posrob_borrower_name"] = $loop2->posrob_borrower_name;
                break;
            }
        }else{
            $sql = "posroit_pos_rolex_temp_id = '".$id."'";
            $query = $this->tp_saleorder_model->getPOS_rolex_temp_item($sql);
            $data["posrob_borrower_name"] = "";
        }
        break;
    }

    if($query){
        $data['item_array'] =  $query;
    }else{
        $data['item_array'] = array();
    }
    $data['pos_rolex_id'] = $id;
    $data['title'] = "Rolex - Sale Memo";

    if ($this->session->userdata('sessstatus')==8) {
        $this->load->view("TP/sale/saleorder_pos_temp_view_only", $data);
    }else{
        $this->load->view("TP/sale/saleorder_pos_temp_view", $data);
    }
}

function saleorder_rolex_pos_temp_today()
{
    $id = $this->uri->segment(3);

    $sql = "posrot_id = '".$id."'";
    $query = $this->tp_saleorder_model->getPOS_rolex_temp($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }


    foreach($query as $loop1) {
        if ($loop1->posrot_status == 'D' and $loop1->posrot_shop_id == 0) {
            $sql = "posroit_pos_rolex_temp_id = '".$id."'";
            $query = $this->tp_saleorder_model->getPOS_rolex_temp_item_borrow($sql);
            foreach($query as $loop2) {
                $data["posrob_borrower_name"] = $loop2->posrob_borrower_name;
                break;
            }
        }else{
            $sql = "posroit_pos_rolex_temp_id = '".$id."'";
            $query = $this->tp_saleorder_model->getPOS_rolex_temp_item($sql);
            $data["posrob_borrower_name"] = "";
        }
        break;
    }

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

function saleorder_rolex_temp_edit()
{
    $id = $this->uri->segment(3);

    $sql = "posrot_id = '".$id."'";
    $query = $this->tp_saleorder_model->getPOS_rolex_temp($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }


    foreach($query as $loop1) {
        if ($loop1->posrot_status == 'D' and $loop1->posrot_shop_id == 0) {
            $sql = "posroit_pos_rolex_temp_id = '".$id."'";
            $query = $this->tp_saleorder_model->getPOS_rolex_temp_item_borrow($sql);
            foreach($query as $loop2) {
                $data["posrob_borrower_name"] = $loop2->posrob_borrower_name;
                break;
            }
        }else{
            $sql = "posroit_pos_rolex_temp_id = '".$id."'";
            $query = $this->tp_saleorder_model->getPOS_rolex_temp_item($sql);
            $data["posrob_borrower_name"] = "";
        }
        break;
    }

    if($query){
        $data['item_array'] =  $query;
    }else{
        $data['item_array'] = array();
    }
    $data['pos_rolex_id'] = $id;
    $data['title'] = "Rolex - Sale Memo";
    $this->load->view("TP/sale/saleorder_pos_temp_edit", $data);
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

    $sql = "posrot_issuedate >= '".$start."' and posrot_issuedate <= '".$end."' and posrot_shop_id = '888'";
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
    $shop = $this->input->post("shop");
    $brand = $this->input->post("brand");
    $refcode = $this->input->post("refcode");

    $data['user_status'] = $this->session->userdata('sessstatus');

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

    $sql .= " and so_issuedate >= '".$start."' and so_issuedate <= '".$end."'";

    if (($brand==0) && ($shop==0)){
        if ($refcode!="") {
            $sql .= " and it_refcode like '%".$refcode."%'";
        }
    }else {
        if ($refcode!="") {
            $sql .= " and it_refcode like '%".$refcode."%'";
        }

        if ($brand!=0) $sql .= " and br_id = '".$brand."'";

        if ($shop!=0) $sql .= " and so_shop_id = '".$shop."'";
    }

    $query = $this->tp_saleorder_model->getSaleItem($sql);

    $sql = "so_enable = '1'";
    $count = 0;
    foreach ($query as $loop) {
        if ($count < 1)  $sql .= " and (so_id = ".$loop->soi_saleorder_id;
        else $sql .= " or so_id = ".$loop->soi_saleorder_id;
        $count++;
    }
    if ($count > 0) {
        $sql .= ")";
        $data['final_array'] = $this->tp_saleorder_model->getSaleOrder($sql);
    }else{
        $data['final_array'] = array();
    }



    $sql = $this->no_rolex;
    $this->load->model('tp_item_model','',TRUE);
    $data['brand_array'] = $this->tp_item_model->getBrand($sql);
    $sql = $this->shop_rolex;
    $data['shop_array'] = $this->tp_shop_model->getShop($sql);

    $data['shop_id'] = $shop;
    $data['brand_id'] = $brand;
    $data['refcode'] = $refcode;

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
    $query = $this->tp_item_model->getBrand($sql);
    $data['brand_array'] = $query;
    //$sql = "sh_enable = '1'";
    $sql = "";
    $data['shop_array'] = $this->tp_shop_model->getShop($sql);


    $data['title'] = "Nerd - Search Sale Report";
    $this->load->view('TP/sale/search_salereport',$data);
}

function report_sale_item_rank()
{
    $this->load->model('tp_item_model','',TRUE);

    $sql = "";

    if ($this->session->userdata('sessstatus') != '88') {
        $sql .= $this->no_rolex;
    }else{ $sql .= "br_id != 888"; }
    $query = $this->tp_item_model->getBrand($sql);
    $data['brand_array'] = $query;

    $startdate = $this->input->post("startdate");
    $enddate = $this->input->post("enddate");

    if ($startdate == "" and $enddate == "") {
        $currentdate = date("Y-m-d");

        $currentdate = explode('-', $currentdate);
        $data['startdate'] = "01/".$currentdate[1]."/".$currentdate[0];
        $data['enddate'] = $currentdate[2]."/".$currentdate[1]."/".$currentdate[0];

        $start = $currentdate[0]."-".$currentdate[1]."-01 00:00:00";
        $end = $currentdate[0]."-".$currentdate[1]."-".$currentdate[2]." 23:59:59";
    }else{
        if ($startdate != "") {
            $start = explode('/', $startdate);
            $start= $start[2]."-".$start[1]."-".$start[0]." 00:00:00";
        }else{
            $start = "1970-01-01 00:00:00";
        }

        if ($enddate != "") {
            $end = explode('/', $enddate);
            $end= $end[2]."-".$end[1]."-".$end[0]." 23:59:59";
        }else{
            $end = date('Y-m-d')." 23:59:59";
        }
        $data['startdate'] = $startdate;
        $data['enddate'] = $enddate;
    }



    foreach($query as $loop){
        $sql = "so_enable = 1 AND soi_dc_percent != 100";
        $sql .= " AND br_id = '".$loop->br_id."' AND so_issuedate >= '".$start."' AND so_issuedate <= '".$end."'";

        $data["rank_brand".$loop->br_id] = $this->tp_saleorder_model->getTop5_qty_sale_brand($sql);
    }

    $data['title'] = "Nerd - Sale Report Ranking";
    $this->load->view('TP/sale/report_sale_item_rank',$data);
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

    $data['viewby'] = 0;

    $data['title'] = "Nerd - Search Sale Report";
    $this->load->view('TP/sale/search_salereport_result',$data);
}

function report_sale_filter_byserial()
{

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
    ->select("so_issuedate, CONCAT('/', so_id, '\">', so_number, '</a>') as sale_id, CONCAT(sh_code,'-',sh_name) as shopname, it_refcode, IF( it_refcode=it_model, '', it_model ) as model, itse_serial_number, br_name, soi_qty, soi_item_srp, sb_number, IF( soi_sale_barcode_id >0, sb_discount_percent, soi_dc_percent ) as dc, soi_dc_baht,IF( soi_sale_barcode_id >0, sb_gp, soi_gp ) as gp, ((((it_srp*(100 - ( select dc ))/100) - soi_dc_baht )*(100 - ( select gp ))/100)*soi_qty) as netprice", FALSE)
    ->from('tp_saleorder_item')
    ->join('tp_saleorder', 'so_id = soi_saleorder_id','left')
    ->join('tp_saleorder_serial', 'sos_soi_id = soi_id', 'left')
    ->join('tp_shop', 'so_shop_id = sh_id','left')
    ->join('tp_sale_barcode', 'soi_sale_barcode_id = sb_id','left')
    ->join('tp_item', 'it_id = soi_item_id','left')
    ->join('tp_brand', 'br_id = it_brand_id','left')
    ->join('tp_item_serial', 'itse_id=sos_item_serial_id','left')
    ->where('so_enable',1)
    ->where($sql)
    ->edit_column("sale_id",'<a target="_blank"  href="'.site_url("sale/saleorder_print").'$1',"sale_id");
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

    $sql = "";
    if ($this->session->userdata('sessstatus') != '88') {
        $sql .= $this->no_rolex;
    }else{ $sql .= "br_id != 888"; }

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
    $this->excel->getActiveSheet()->setCellValue('B1', 'Shop Code');
    $this->excel->getActiveSheet()->setCellValue('C1', 'Shop');
    $this->excel->getActiveSheet()->setCellValue('D1', 'Ref. Number');
    $this->excel->getActiveSheet()->setCellValue('E1', 'Model');
    $this->excel->getActiveSheet()->setCellValue('F1', 'Caseback');
    $this->excel->getActiveSheet()->setCellValue('G1', 'Brand');
    $this->excel->getActiveSheet()->setCellValue('H1', 'Qty (Pcs.)');
    $this->excel->getActiveSheet()->setCellValue('I1', 'SRP');
    $this->excel->getActiveSheet()->setCellValue('J1', 'BAR');
    $this->excel->getActiveSheet()->setCellValue('K1', 'Discount (%)');
    $this->excel->getActiveSheet()->setCellValue('L1', 'On Top (บาท)');
    $this->excel->getActiveSheet()->setCellValue('M1', 'GP (%)');
    $this->excel->getActiveSheet()->setCellValue('N1', 'Receive on Inv.');

    $row = 2;
    foreach($item_array as $loop) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->so_issuedate);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->sh_code);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->sh_name);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->it_refcode);
        if($loop->it_refcode!=$loop->it_model) $model = $loop->it_model; else $model = "";
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $model);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->itse_serial_number);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $loop->br_name);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->soi_qty);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $loop->soi_item_srp);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->sb_number);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $loop->dc);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $loop->soi_dc_baht);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $loop->gp);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $loop->netprice);
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

function print_sale_report()
{
    $refcode = $this->input->post("refcode");
    $keyword = explode(" ", $refcode);
    $brand = $this->input->post("brand");
    $shop = $this->input->post("shop");
    $startdate = $this->input->post("startdate");
    $enddate = $this->input->post("enddate");

    $this->load->model('tp_item_model','',TRUE);
    $where = "br_id = ".$brand;
    $data['brand_array'] = $this->tp_item_model->getBrand($where);
    $data["refcode"] = $refcode;
    $data["brand"] = $brand;
    $data["shop"] = $shop;
    $where = "sh_id = ".$shop;
    $data['shop_array'] = $this->tp_shop_model->getShop($where);
    $data["startdate"] = $startdate;
    $data["enddate"] = $enddate;

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

    $data['item_array'] = $this->tp_saleorder_model->getSaleOrder_Item($sql);

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th','A4-L','0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');

    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/sale/print_sale_report_filter", $data, TRUE));
    $mpdf->Output();
}

function exportExcel_sale_report_caseback()
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
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->it_srp);
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

function report_rolex_sale_form()
{
    $this->load->model('tp_item_model','',TRUE);
    $this->load->model('tp_shop_model','',TRUE);

    $sql = "br_id = '888'";
    $data['brand_array'] = $this->tp_item_model->getBrand($sql);
    $sql = "sh_id = '888'";
    $data['shop_array'] = $this->tp_shop_model->getShop($sql);
    $sql = "";
    $this->load->model('tp_saleperson_model','',TRUE);
    $data['borrower_array'] = $this->tp_saleperson_model->getBorrowerName($sql);

    $data['title'] = "Nerd - Rolex Sale Report";
    $this->load->view('TP/sale/search_rolex_salereport',$data);
}

function report_rolex_sale_result()
{
    $brand = $this->input->post("brand");
    $shop = $this->input->post("shop");

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

    $data['title'] = "Nerd - Rolex Sale Report";
    $this->load->view('TP/sale/report_rolex_sale_result',$data);
}

function ajaxView_rolex_salereport()
{
    $brand = $this->uri->segment(3);
    $shop = $this->uri->segment(4);
    $startdate = $this->uri->segment(5);
    $enddate = $this->uri->segment(6);

    $table_join = " ";

    $sql_temp = "posrot_issuedate >= '".$startdate."' and posrot_issuedate <= '".$enddate."'";

    if ($shop=="0"){
        $sql_temp .= " and ( posrot_shop_id = '888' or posrot_shop_id = '0')";
    }else if ($shop < 888) {
        $table_join = " LEFT JOIN `tp_pos_rolex_borrow_item` on `tp_pos_rolex_borrow_item`.`posrobi_pos_temp_id` = `tp_pos_rolex_temp`.`posrot_id`
LEFT JOIN `tp_pos_rolex_borrow` on `tp_pos_rolex_borrow`.`posrob_id` = `tp_pos_rolex_borrow_item`.`posrobi_pos_rolex_borrow_id` LEFT JOIN `tp_pos_rolex_borrower` on `tp_pos_rolex_borrower`.`posbor_name`=`tp_pos_rolex_borrow`.`posrob_borrower_name` ";

        $sql_temp .= " and posrot_shop_id = '0' and `tp_pos_rolex_borrower`.`posbor_id` = '".$shop."'";
    }else{
        $sql_temp .= " and posrot_shop_id = '".$shop."'";
    }

    $sql_vat = "posro_issuedate >= '".$startdate."' and posro_issuedate <= '".$enddate."'";

    if ($shop=="0"){
        $sql_vat .= " ";
    }else {
        $sql_vat .= " and posro_shop_id = '".$shop."'";
    }

    $this->load->library('Datatables');
    $this->datatables
    ->select("solddate, it_refcode, it_model, it_short_description, itse_serial_number, it_srp, it_dc, it_netprice, cusname")
    ->from("((SELECT posrot_issuedate as solddate, it_refcode, it_model, it_short_description, itse_serial_number, posroit_item_srp as it_srp, posroit_dc_baht as it_dc, posroit_netprice as it_netprice, posrot_customer_name as cusname  FROM (`tp_pos_rolex_temp_item`) LEFT JOIN `tp_pos_rolex_temp` ON `tp_pos_rolex_temp`.`posrot_id` = `tp_pos_rolex_temp_item`.`posroit_pos_rolex_temp_id` LEFT JOIN `tp_item` ON `tp_pos_rolex_temp_item`.`posroit_item_id`=`tp_item`.`it_id` LEFT JOIN `tp_item_serial` ON  `tp_pos_rolex_temp_item`.`posroit_item_serial_number_id`=`tp_item_serial`.`itse_id`".$table_join."WHERE `posrot_status` != 'V' AND `posrot_enable` = 1 AND ".$sql_temp.") UNION (SELECT posro_issuedate as solddate, it_refcode, it_model, it_short_description, itse_serial_number, posroi_item_srp as it_srp, posroi_dc_baht as it_dc, posroi_netprice as it_netprice, posro_customer_name as cusname  FROM (`tp_pos_rolex_item`) LEFT JOIN `tp_pos_rolex` ON `tp_pos_rolex`.`posro_id` = `tp_pos_rolex_item`.`posroi_pos_rolex_id` LEFT JOIN `tp_item` ON `tp_pos_rolex_item`.`posroi_item_id`=`tp_item`.`it_id` LEFT JOIN `tp_item_serial` ON  `tp_pos_rolex_item`.`posroi_item_serial_number_id`=`tp_item_serial`.`itse_id` WHERE `posro_status` != 'V' AND `posro_enable` = 1 AND ".$sql_vat.") ) as aa");
    echo $this->datatables->generate();
}

function exportExcel_rolex_sale_report()
{
    $brand = $this->input->post("brand");
    $shop = $this->input->post("shop");
    $startdate = $this->input->post("startdate");
    $enddate = $this->input->post("enddate");

    $table_join = " ";

    $sql_temp = "posrot_issuedate >= '".$startdate."' and posrot_issuedate <= '".$enddate."'";

    if ($shop=="0"){
        $sql_temp .= " and ( posrot_shop_id = '888' or posrot_shop_id = '0')";
    }else if ($shop < 888) {
        $table_join = " LEFT JOIN `tp_pos_rolex_borrow_item` on `tp_pos_rolex_borrow_item`.`posrobi_pos_temp_id` = `tp_pos_rolex_temp`.`posrot_id`
LEFT JOIN `tp_pos_rolex_borrow` on `tp_pos_rolex_borrow`.`posrob_id` = `tp_pos_rolex_borrow_item`.`posrobi_pos_rolex_borrow_id` LEFT JOIN `tp_pos_rolex_borrower` on `tp_pos_rolex_borrower`.`posbor_name`=`tp_pos_rolex_borrow`.`posrob_borrower_name` ";

        $sql_temp .= " and posrot_shop_id = '0' and `tp_pos_rolex_borrower`.`posbor_id` = '".$shop."'";
    }else{
        $sql_temp .= " and posrot_shop_id = '".$shop."'";
    }

    $sql_vat = "posro_issuedate >= '".$startdate."' and posro_issuedate <= '".$enddate."'";

    if ($shop=="0"){
        $sql_vat .= " ";
    }else {
        $sql_vat .= " and posro_shop_id = '".$shop."'";
    }

    $item_array = $this->tp_saleorder_model->getSaleOrder_Item_rolex($table_join,$sql_temp,$sql_vat);

    //load our new PHPExcel library
    $this->load->library('excel');
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Sale Report');

    $this->excel->getActiveSheet()->setCellValue('A1', 'Sold Date');
    $this->excel->getActiveSheet()->setCellValue('B1', 'เลขที่เอกสาร');
    $this->excel->getActiveSheet()->setCellValue('C1', 'Product Number');
    $this->excel->getActiveSheet()->setCellValue('D1', 'Family');
    $this->excel->getActiveSheet()->setCellValue('E1', 'Description');
    $this->excel->getActiveSheet()->setCellValue('F1', 'Serial');
    $this->excel->getActiveSheet()->setCellValue('G1', 'Retail Price');
    $this->excel->getActiveSheet()->setCellValue('H1', 'Discount(บาท)');
    $this->excel->getActiveSheet()->setCellValue('I1', 'Receive on Inv.');
    $this->excel->getActiveSheet()->setCellValue('J1', 'Customer');

    $row = 2;
    $sum1 = 0;
    $sum2 = 0;
    $sum3 = 0;
    foreach($item_array as $loop) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->solddate);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->number);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->it_refcode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->it_model);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->it_short_description);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->itse_serial_number);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $loop->it_srp);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->it_dc);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $loop->it_netprice);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->cusname);
        $row++;

        $sum1 += $loop->it_srp; $sum2 += $loop->it_dc; $sum3 += $loop->it_netprice;
    }
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, "จำนวนทั้งหมด");
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $row-2);
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, number_format($sum1, 2, '.', ','));
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, number_format($sum2, 2, '.', ','));
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, number_format($sum3, 2, '.', ','));


    $filename='rolex_sale_report.xlsx'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache

    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
}

function saleorder_rolex_temp_borrow_print()
{
    $id = $this->uri->segment(3);
    $borrow_item_id = $this->uri->segment(4);

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

    $sql = "posrobi_id = ".$borrow_item_id;

    $data['borrow_array'] = $this->tp_shop_model->getItem_borrow_serial($sql);

    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/sale/bill_borrow_rolex_print", $data, TRUE));
    $mpdf->Output();
}

function saleorder_rolex_borrow_last()
{
    $borrow_item_id = $this->uri->segment(3);

    $sql = "posrobi_id = ".$borrow_item_id;
    $query = $this->tp_shop_model->getItem_borrow_serial($sql);

    foreach($query as $loop) {
        $id = $loop->posrobi_pos_temp_id;
        break;
    }

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

    $sql = "posrobi_id = ".$borrow_item_id;

    $data['borrow_array'] = $this->tp_shop_model->getItem_borrow_serial($sql);

    $data['pos_rolex_id'] = $id;
    $data['borrow_item_id'] = $borrow_item_id;
    $data['title'] = "Rolex - Sale Memo";
    $this->load->view("TP/sale/saleorder_borrow_view", $data);
}

function saleorder_rolex_void_borrow()
{
    $id = $this->uri->segment(3);
    $borrow_item_id = $this->uri->segment(4);

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

    $sale = array(  'id' => $borrow_item_id,
                    'posrobi_enable' => 1,
                    'posrobi_pos_temp_id' => 0
                );
    $query = $this->tp_shop_model->editPOS_rolex_borrow_item($sale);

    redirect('pos/form_list_borrow_item', 'refresh');
}

function save_edit_remark()
{
    $remark = $this->input->post("remark");
    $posro_id = $this->input->post("posro_id");

    $pos = array( 'id' => $posro_id,
                    'posro_remark' => $remark
            );

    $last_id = $this->tp_saleorder_model->editPOS_rolex($pos);

    $result = array("b" => $last_id);
    echo json_encode($result);
    exit();
}

// Admin function
function view_saleorder()
{
  $id = $this->uri->segment(3);

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
  $query = $this->tp_saleorder_model->getSaleItemSerial($sql);
  if($query){
      $data['serial_array'] =  $query;
  }else{
      $data['serial_array'] = array();
  }
  $data['user_status'] = $this->session->userdata('sessstatus');
  $data['title'] = "Nerd - View Sale Order";
  $this->load->view("TP/sale/view_saleorder", $data);
}

function void_saleorder()
{
  $id = $this->uri->segment(3);

  $currentdate = date("Y-m-d H:i:s");

  $sql = "so_id = '".$id."'";
  $query = $this->tp_saleorder_model->getSaleOrder($sql);
  foreach($query as $loop) {
      $remark = $loop->so_remark;
      $shop_id = $loop->so_shop_id;
  }

  $remark .= "##VOID##".$this->input->post("remarkvoid");
  $sale = array("id" => $id, "so_enable" => 0, "so_remark" => $remark, "so_status" => 'V',
              "so_dateadd" => $currentdate, "so_dateadd_by" => $this->session->userdata('sessid')
              );
  $query = $this->tp_saleorder_model->editSaleOrder($sale);

  $sql = "sh_id = '".$shop_id."'";
  $query = $this->tp_shop_model->getShop($sql);
  foreach($query as $loop) {
      $warehouse_id = $loop->sh_warehouse_id;
  }

  $sql = "soi_saleorder_id = '".$id."'";
  $query = $this->tp_saleorder_model->getSaleItem($sql);
  foreach($query as $loop) {
    // increase stock warehouse
    $this->load->model('tp_warehouse_transfer_model','',TRUE);
    $sql = "stob_item_id = '".$loop->soi_item_id."' and stob_warehouse_id = '".$warehouse_id."'";
    $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);

    $qty_update = $loop->soi_qty;

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
  }

  $sql = "sos_saleorder_id = '".$id."'";
  $query = $this->tp_saleorder_model->getSaleItemSerial($sql);

  foreach($query as $loop) {
    $this->load->model('tp_item_model','',TRUE);
    $serial_item = array( 'id' => $loop->sos_item_serial_id,
                             'itse_enable' => 1,
                             'itse_dateadd' => $currentdate,
                        );
    $query = $this->tp_item_model->editItemSerial($serial_item);
  }


  redirect('sale/view_saleorder/'.$id, 'refresh');
}

function edit_saleorder()
{
  $id = $this->uri->segment(3);

}

}
?>
