<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pos extends CI_Controller {

public $no_rolex = "";
public $shop_rolex = "";
public $qty_limit = " and stob_qty > 0";
    
function __construct()
{
     parent::__construct();
     $this->load->model('tp_saleorder_model','',TRUE);
     $this->load->model('tp_shop_model','',TRUE);
     $this->load->model('tp_warehouse_model','',TRUE);
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

function getBalance_shop()
{
    $remark = $this->uri->segment(3);
    $stock = "";
    if ($remark=="all") $stock = "";
    else if ($remark=="have") $stock = " and stob_qty > 0";
    else if ($remark=="no") $stock = " and stob_qty <= 0";
    
    $sql = $this->no_rolex;
    $this->load->model('tp_item_model','',TRUE);
    $data['brand_array'] = $this->tp_item_model->getBrand($sql);
    
    $sql = $this->shop_rolex;
    $query = $this->tp_shop_model->getShop($sql);
    foreach($query as $loop) {
        $data['shop_name'] = $loop->sh_name;
        $sql_result = "stob_warehouse_id = '".$loop->sh_warehouse_id."'".$stock;
        $result = $this->tp_warehouse_model->getWarehouse_balance($sql_result);
    }
    
    $data['item_array'] = $result;
    $data['remark'] = $remark;
    $data['title'] = "NGG| Nerd - Search Stock";
    $this->load->view('TP/shop/search_stock',$data);
}
    
function stock_rolex_print()
{
    $remark = $this->uri->segment(3);
    if ($remark=="all") { $stock = ""; $data['detail'] = "สินค้าทั้งหมด"; }
    else if ($remark=="have") { $stock = " and stob_qty > 0"; $data['detail'] = "เฉพาะสินค้าที่มีของ(จำนวน > 0)"; }
    else if ($remark=="no") { $stock = " and stob_qty <= 0"; $data['detail'] = "เฉพาะสินค้าที่หมด(จำนวน = 0)"; }
		
    $this->load->library('mpdf/mpdf');                
    $mpdf= new mPDF('th','A4','0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');

    $sql = $this->shop_rolex;
    $query = $this->tp_shop_model->getShop($sql);
    foreach($query as $loop) {
        $data['shop_name'] = $loop->sh_name;
        $sql_result = "stob_warehouse_id = '".$loop->sh_warehouse_id."'".$stock;
        $result = $this->tp_warehouse_model->getWarehouse_balance($sql_result);
    }

    $data['item_array'] = $result;
    
    $this->load->model('tp_warehouse_transfer_model','',TRUE);
    //$sql_result .= " and itse_enable = '1'";
    $query = $this->tp_warehouse_transfer_model->getItem_stock_caseback($sql_result);
    if($query){
        $data['serial_array'] =  $query;
    }else{
        $data['serial_array'] = array();
    }
    
    $sql = "";
    $query_sold_tax = $this->tp_saleorder_model->getPOS_rolex_item($sql);
    $query_sold_bill = $this->tp_saleorder_model->getPOS_rolex_temp_item($sql);
    $data['sold_array'] = array_merge($query_sold_tax,$query_sold_bill);
    
    $sql = "";
    $data['borrow_array'] = $this->tp_shop_model->getItem_borrow_serial($sql);
    
    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/shop/stock_rolex_print", $data, TRUE));
    $mpdf->Output();
}
    
function stock_rolex_excel()
{
    /*$remark = $this->uri->segment(3);
    if ($remark=="all") { $stock = ""; $detail = "สินค้าทั้งหมด"; }
    else if ($remark=="have") { $stock = " and stob_qty > 0"; $detail = "เฉพาะสินค้าที่มีของ(จำนวน > 0)"; }
    else if ($remark=="no") { $stock = " and stob_qty <= 0"; $detail = "เฉพาะสินค้าที่หมด(จำนวน = 0)"; }
	*/	
    $stock = " and stob_qty > 0";
    $sql = $this->shop_rolex;
    $query = $this->tp_shop_model->getShop($sql);
    foreach($query as $loop) {
        $shopname = $loop->sh_name;
        $sql_result = "stob_warehouse_id = '".$loop->sh_warehouse_id."'".$stock;
        $result = $this->tp_warehouse_model->getWarehouse_balance($sql_result);
    }

    $item_array = $result;
    $sql_result .= " and itse_enable = 1";
    $this->load->model('tp_warehouse_transfer_model','',TRUE);
    //$sql_result .= " and itse_enable = '1'";
    $query = $this->tp_warehouse_transfer_model->getItem_stock_caseback($sql_result);
    $serial_array = $query;
    
    $sql = "";
    $query_sold_tax = $this->tp_saleorder_model->getPOS_rolex_item($sql);
    $query_sold_bill = $this->tp_saleorder_model->getPOS_rolex_temp_item($sql);
    $sold_array = array_merge($query_sold_tax,$query_sold_bill);
    
    $sql = "";
    $borrow_array = $this->tp_shop_model->getItem_borrow_serial($sql);
    
    //load our new PHPExcel library
    $this->load->library('excel');
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Stock_Balance');
    $this->excel->getActiveSheet()->setCellValue('A1', '** จำนวนยอดคงเหลือ เฉพาะที่อยู่ใน Shop Rolex Central Udonthani เท่านั้น');
    
    $this->excel->getActiveSheet()->setCellValue('A2', 'No.');
    $this->excel->getActiveSheet()->setCellValue('B2', 'Product Code');
    $this->excel->getActiveSheet()->setCellValue('C2', 'Brand');
    $this->excel->getActiveSheet()->setCellValue('D2', 'Description');
    $this->excel->getActiveSheet()->setCellValue('E2', 'Family');
    $this->excel->getActiveSheet()->setCellValue('F2', 'Bracelet');
    $this->excel->getActiveSheet()->setCellValue('G2', 'จำนวน (Pcs.)');
    $this->excel->getActiveSheet()->setCellValue('H2', 'ราคาป้าย');
    $this->excel->getActiveSheet()->setCellValue('I2', 'Serial');
    
    $row = 3;
    $no = 1;
    foreach($item_array as $loop) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $no);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->it_refcode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->br_name);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->it_short_description);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->it_model);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->it_remark);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $loop->stob_qty);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, number_format($loop->it_srp, 2, '.', ','));
        
        $serial_temp = "";
        $count = 0;
        foreach ($serial_array as $loop2) {
            if ($loop->stob_item_id==$loop2->it_id) {
                if ($count != 0) $serial_temp .= " , ";
                $serial_temp .= $loop2->itse_serial_number;
                $count++;
            }
        }
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $serial_temp);
        $row++;
        $no++;
    }
    

    $filename='rolex_stock_shoponly.xlsx'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache

    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
}
    
function stock_rolex_borrow()
{
    $datein = date("d/m/Y");
    
    // shop rolex
    $sql = "sh_id = '888'";
    $data['shop_array'] = $this->tp_shop_model->getShop($sql);
    
    $this->load->model('tp_saleperson_model','',TRUE);
    $data['borrower_array'] = $this->tp_saleperson_model->getBorrowerName($sql);

    $data['datein'] = $datein;
    $data['title'] = "Rolex - Sale Memo";
    $this->load->view("TP/shop/pos_borrow", $data);
}
    
function stock_rolex_borrow_save()
{
    $borrower = $this->input->post("borrower");

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
    
    $number = $this->tp_shop_model->getMaxNumber_rolex_borrow_shop($month, $shop_id);
    
    $number++;
    
    $number = "NGGTP-TD".$month_array[0].$month_array[1].str_pad($number, 3, '0', STR_PAD_LEFT);

    $sale = array( 'posrob_number' => $number,
                    'posrob_issuedate' => $datein,
                    'posrob_dateadd' => $currentdate,
                    'posrob_shop_id' => $shop_id,
                    'posrob_borrower_name' => $borrower,
                    'posrob_sale_person_id' => $saleperson_code,
                    'posrob_remark' => $remark,
                    'posrob_dateadd_by' => $this->session->userdata('sessid')
            );
    
    $last_id = $this->tp_shop_model->addPOS_rolex_borrow($sale);
    $count = 0;
    for($i=0; $i<count($it_array); $i++){
        // add item to so
        $sale = array(  'posrobi_pos_rolex_borrow_id' => $last_id,
                        'posrobi_item_id' => $it_array[$i]["id"],
                        'posrobi_qty' => $it_array[$i]["qty"],
                        'posrobi_item_serial_number_id' => $it_array[$i]["itse_id"],
                        'posrobi_stock_balance_id' => $it_array[$i]["stob_id"]
            );
        $query = $this->tp_shop_model->addPOS_rolex_borrow_item($sale);
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
    //$result = array("a" => $shop_id, "b" => $month);
    echo json_encode($result);
    exit();
}
   
function stock_rolex_borrow_print()
{
    $id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th','A4','0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');
    $mpdf->SetWatermarkImage(base_url()."dist/img/logo-nggtp.jpg", 0.05, array(100,60), array(55,110));
    $mpdf->showWatermarkImage = true;

    $sql = "posrob_id = '".$id."'";
    $query = $this->tp_shop_model->getPOS_rolex_borrow($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }

    $sql = "posrobi_pos_rolex_borrow_id = '".$id."'";
    $query = $this->tp_shop_model->getPOS_rolex_borrow_item($sql);
    if($query){
        $data['item_array'] =  $query;
    }else{
        $data['item_array'] = array();
    }

    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/shop/bill_borrow_rolex_print", $data, TRUE));
    $mpdf->Output();
}
    
function stock_rolex_pos_borrow_last()
{
    $id = $this->uri->segment(3);

    $sql = "posrob_id = '".$id."'";
    $query = $this->tp_shop_model->getPOS_rolex_borrow($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }

    foreach($query as $loop) {
        if ($loop->posrob_status =='R') {
            $sql = "posrobi_return_id = '".$id."'";;
        }else{
            $sql = "posrobi_pos_rolex_borrow_id = '".$id."'";
        }
    }
    $query = $this->tp_shop_model->getPOS_rolex_borrow_item($sql);
    if($query){
        $data['item_array'] =  $query;
    }else{
        $data['item_array'] = array();
    }
    
    $data['pos_rolex_id'] = $id;
    $data['title'] = "Rolex - Sale Memo";
    $this->load->view("TP/shop/stock_pos_borrow_view", $data);
}
    
function stock_POS_borrow_today()
{
    $currentdate = date("Y-m-d");
    $start = $currentdate." 00:00:00";
    $end = $currentdate." 23:59:59";
    
    $sql = "posrob_dateadd >= '".$start."' and posrob_dateadd <= '".$end."' and posrob_shop_id = '888'";
    $query = $this->tp_shop_model->getPOS_rolex_borrow($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }
    $currentdate = explode('-', $currentdate);
    $currentdate = $currentdate[2]."/".$currentdate[1]."/".$currentdate[0];
    $data["currentdate"] = $currentdate;
    $data['title'] = "Nerd - Report";
    $this->load->view("TP/shop/report_stock_POS_borrow_today", $data);
}
    
function stock_POS_borrow_history()
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
    
    $sql = "posrob_dateadd >= '".$start."' and posrob_dateadd <= '".$end."' and posrob_shop_id = '888'";
    $query = $this->tp_shop_model->getPOS_rolex_borrow($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }
    $currentdate = explode('-', $currentdate);
    $currentdate = $currentdate[1]."/".$currentdate[0];
    $data["currentdate"] = $currentdate;
    $data['title'] = "Nerd - Report";
    $this->load->view("TP/shop/report_stock_POS_borrow_history", $data);
}
    
function saleorder_rolex_void_pos_borrow()
{
    $id = $this->uri->segment(3);
    
    $currentdate = date("Y-m-d H:i:s");
    
    $sql = "posrob_id = '".$id."'";
    $query = $this->tp_shop_model->getPOS_rolex_borrow($sql);
    foreach($query as $loop) {
        $remark = $loop->posrob_remark;
        $shop_id = $loop->posrob_shop_id;
    }
    $remark .= "##VOID##".$this->input->post("remarkvoid");
    $pos = array("id" => $id, "posrob_status" => 'V', "posrob_remark" => $remark,
                "posrob_dateadd" => $currentdate, "posrob_dateadd_by" => $this->session->userdata('sessid')
                );
    $query = $this->tp_shop_model->editPOS_rolex_borrow($pos);
    
    $sql = "posrobi_pos_rolex_borrow_id = '".$id."'";
    $query = $this->tp_shop_model->getPOS_rolex_borrow_item($sql);
    foreach($query as $loop) {
        // increase stock warehouse out
        $qty_update = $loop->posrobi_qty;
        $itse_id = $loop->posrobi_item_serial_number_id;
        $this->load->model('tp_warehouse_transfer_model','',TRUE);
        $sql = "stob_id = '".$loop->posrobi_stock_balance_id."'";
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
		
    redirect('pos/stock_POS_borrow_today', 'refresh');
}
    
function stock_POS_sale_history()
{
    $month = date("Y-m");
    $start = $month."-01 00:00:00";
    $end = $month."-31 23:59:59";
    
    
}
    
function stock_rolex_borrow_return()
{
    $datein = date("d/m/Y");
    
    // shop rolex
    $sql = "sh_id = '888'";
    $data['shop_array'] = $this->tp_shop_model->getShop($sql);

    $data['datein'] = $datein;
    $data['title'] = "Rolex - Sale Memo";
    $this->load->view("TP/shop/pos_borrow_return", $data);
}
    
function check_rolex_borrow_serial()
{
    $refcode = $this->input->post("refcode");
    $shop_id = $this->input->post("shop_id");
    
    $output = "";
    $sql = "itse_serial_number = '".$refcode."' and posrobi_enable = '1' and posrob_status != 'V'";
    
    $result = $this->tp_shop_model->getItem_borrow_serial($sql);
    
    if (count($result) >0) {
        foreach($result as $loop) {
            $output .= "<td><input type='hidden' name='stob_id' id='stob_id' value='".$loop->posrobi_stock_balance_id."'><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'><input type='hidden' name='it_srp' id='it_srp' value='".$loop->it_srp."'><input type='hidden' name='itse_id' id='itse_id' value='".$loop->itse_id."'><input type='hidden' name='posrobi_id' id='posrobi_id' value='".$loop->posrobi_id."'>".$loop->it_refcode."</td><td>".$loop->itse_serial_number."</td><td>".$loop->it_short_description."</td><td>".$loop->it_model."</td><td>".$loop->it_remark."</td><td><input type='text' name='it_quantity' id='it_quantity' value='1 ".$loop->it_uom."' style='width: 50px;' readonly></td><td>".number_format($loop->it_srp)."</td><td>".$loop->posrob_borrower_name."</td>";
        }
    }
    
    
    echo $output;
}
    
function stock_rolex_borrow_return_save()
{
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
    
    $number = $this->tp_shop_model->getMaxNumber_rolex_borrow_shop($month, $shop_id);
    
    $number++;
    
    $number = "NGGTP-TD".$month_array[0].$month_array[1].str_pad($number, 3, '0', STR_PAD_LEFT);

    $sale = array( 'posrob_number' => $number,
                    'posrob_issuedate' => $datein,
                    'posrob_dateadd' => $currentdate,
                    'posrob_shop_id' => $shop_id,
                    'posrob_status' => 'R',
                    'posrob_sale_person_id' => $saleperson_code,
                    'posrob_remark' => $remark,
                    'posrob_dateadd_by' => $this->session->userdata('sessid')
            );
    
    $last_id = $this->tp_shop_model->addPOS_rolex_borrow($sale);
    $count = 0;
    for($i=0; $i<count($it_array); $i++){
        // add item to so
        $sale = array(  'id' => $it_array[$i]["posrobi_id"],
                        'posrobi_return_id' => $last_id,
                        'posrobi_enable' => 0
            );
        $query = $this->tp_shop_model->editPOS_rolex_borrow_item($sale);
        $count += $it_array[$i]["qty"];
        // decrease stock warehouse out
        $this->load->model('tp_warehouse_transfer_model','',TRUE);
        $sql = "stob_id = '".$it_array[$i]["stob_id"]."'";
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);

        $qty_update = $it_array[$i]["qty"];

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
        
        $serial = array("id" => $it_array[$i]["itse_id"], "itse_enable" => 1, "itse_dateadd" => $currentdate);
        
        $this->load->model('tp_item_model','',TRUE);
        $query = $this->tp_item_model->editItemSerial($serial);
    }
    $result = array("a" => $count, "b" => $last_id);
    //$result = array("a" => $shop_id, "b" => $month);
    echo json_encode($result);
    exit();
}
    
function stock_rolex_borrow_return_print()
{
    $id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th','A4','0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');
    $mpdf->SetWatermarkImage(base_url()."dist/img/logo-nggtp.jpg", 0.05, array(100,60), array(55,110));
    $mpdf->showWatermarkImage = true;

    $sql = "posrob_id = '".$id."'";
    $query = $this->tp_shop_model->getPOS_rolex_borrow($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }

    $sql = "posrobi_return_id = '".$id."'";
    $query = $this->tp_shop_model->getPOS_rolex_borrow_return_item($sql);
    if($query){
        $data['item_array'] =  $query;
    }else{
        $data['item_array'] = array();
    }

    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/shop/bill_borrow_return_rolex_print", $data, TRUE));
    $mpdf->Output();
}
    
function stock_rolex_pos_borrow_return_last()
{
    $id = $this->uri->segment(3);

    $sql = "posrob_id = '".$id."'";
    $query = $this->tp_shop_model->getPOS_rolex_borrow($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }

    $sql = "posrobi_return_id = '".$id."'";
    $query = $this->tp_shop_model->getPOS_rolex_borrow_return_item($sql);
    if($query){
        $data['item_array'] =  $query;
    }else{
        $data['item_array'] = array();
    }
    
    $data['pos_rolex_id'] = $id;
    $data['title'] = "Rolex - Sale Memo";
    $this->load->view("TP/shop/stock_pos_borrow_return_view", $data);
}
    
function stock_POS_borrow_return_today()
{
    $currentdate = date("Y-m-d");
    $start = $currentdate." 00:00:00";
    $end = $currentdate." 23:59:59";
    
    $sql = "posrob_dateadd >= '".$start."' and posrob_dateadd <= '".$end."' and posrob_shop_id = '888'";
    $query = $this->tp_shop_model->getPOS_rolex_borrow($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }
    $currentdate = explode('-', $currentdate);
    $currentdate = $currentdate[2]."/".$currentdate[1]."/".$currentdate[0];
    $data["currentdate"] = $currentdate;
    $data['title'] = "Nerd - Report";
    $this->load->view("TP/shop/report_stock_POS_borrow_today", $data);
}
    
}
?>