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
    $sql = "wh_group_id != 6";
    $data['wh_array'] = $this->tp_warehouse_model->getWarehouse($sql);

    $data['title'] = "NGG| Nerd - Create Invoice";
    $this->load->view("TP/invoice/form_new_invoice", $data);
}

function check_transfer_number()
{
    $tb_number = $this->input->post("tb_number");

    $tb_number = preg_replace('/\D/', '', $tb_number);

    $output = array();
    $warehouse = array();
    $index = 0 ;
    $sql = "stot_number = 'TB".$tb_number."' and stot_enable = '1'";
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

                $stot_id = $loop->stot_id;
                $warehouse = array("wh_id" => $wh_id, "wh_detail" => $wh_detail, "wh_address1" => $wh_address1, "wh_address2" => $wh_address2, "wh_taxid" => $wh_taxid, "wh_branch" => $wh_branch, "wh_vender" => $wh_vender, "stot_id" => $stot_id, "stot_number" => "TB".$tb_number);
            }

            $output[$index] = "<td><input type='hidden' name='it_id' value='".$loop->it_id."'><input type='hidden' name='it_refcode' value='".$loop->it_refcode."'>".$loop->it_refcode."</td><td><input type='hidden' name='br_name' value='".$loop->br_name."'>".$loop->br_name."</td><td><input type='hidden' name='it_srp1' id='it_srp1' value='".$loop->it_srp."'>".$loop->it_srp."</td><td><input type='text' style='width: 80px;' name='it_discount1' id='it_discount1' value='' onChange='calSRP();' readonly></td><td><input type='text' name='it_qty' id='it_qty' value='".$loop->log_stot_qty_final."' onChange='calculate();'></td><td><input type='text' name='it_srp' id='it_srp' value='".number_format($loop->it_srp, 2, ".", ",")."' readonly></td><td><input type='text' name='it_discount' id='it_discount' style='width: 80px;' value='' onChange='calDiscount();'></td><td><input type='text' name='it_netprice' id='it_netprice' value='".number_format($loop->it_srp, 2, ".", ",")."' onChange='calculate();'></td>";
            $index++;
        }
    }

    // check transfer number was created Invoice, or not
    $sql = "inv_stot_number like '%".$tb_number."%'";
    $query = $this->tp_invoice_model->get_invoice_detail($sql);
    if (count($query) > 0) $exist_number = true;
    else $exist_number = false;

    $final = array("item" => $output, "warehouse" => $warehouse, "exist_number" => $exist_number);
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
            $output[$index] = "<td><input type='hidden' name='it_id' value='".$loop->it_id."'><input type='hidden' name='it_refcode' value='".$loop->it_refcode."'>".$loop->it_refcode."</td><td><input type='hidden' name='br_name' value='".$loop->br_name."'>".$loop->br_name." ".$loop->it_model."</td><td><input type='hidden' name='it_srp1' id='it_srp1' value='".$loop->it_srp."'>".$loop->it_srp."</td><td><input type='text' style='width: 80px;' name='it_discount1' id='it_discount1' value='' onChange='calSRP();'";
            // repair item can edit
            if ($loop->it_id > 1) $output[$index] .= " readonly";
            $output[$index] .= "></td><td><input type='text' name='it_qty' id='it_qty' value='1' onChange='calculate();'></td><td><input type='text' name='it_srp' id='it_srp' value='".number_format($loop->it_srp, 2, ".", ",")."' readonly></td><td><input type='text' style='width: 80px;' name='it_discount' id='it_discount' value='' onChange='calDiscount();'></td><td><input type='text' name='it_netprice' id='it_netprice' value='".number_format($loop->it_srp, 2, ".", ",")."' onChange='calculate();'></td>";
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

function save_new_invoice()
{
    // $datein = $this->input->post("datein");
    // $wh_id = $this->input->post("wh_id");
    $cusname = $this->input->post("cusname");
    $cusaddress1 = $this->input->post("cusaddress1");
    $cusaddress2 = $this->input->post("cusaddress2");
    $custax_id = $this->input->post("custax_id");
    $branch = $this->input->post("branch");
    // $branch_number = $this->input->post("branch_number");
    // $vender = $this->input->post("vender");
    // $barcode = $this->input->post("barcode");
    // $tb_number = $this->input->post("tb_number");
    // $stot_id = $this->input->post("stot_id");
    // $discount_srp = $this->input->post("discount_srp");
    $note = $this->input->post("note");
    $remark = $this->input->post("remark");

    $detial = $this->input->post("detail");
    $detial = explode('#,#', $detial);
    $datein = $detial[5];
    $wh_id = $detial[6];
    $branch_number = $detial[7];
    $vender = $detial[4];
    $barcode = $detial[3];
    $tb_number = $detial[2];
    $stot_id = $detial[1];
    $discount_srp = $detial[0];

    $it_array = $this->input->post("item");

    if ($branch == -1) {
        $branch_input = $branch_number;
    }else if ($branch == 0) {
        $branch_input = $branch;
    }

    $currentdate = date("Y-m-d H:i:s");

    $datein = explode('/', $datein);
    $datein_input = $datein[2]."-".$datein[1]."-".$datein[0];
    $month = $datein[2]."-".$datein[1];

    $number = $this->tp_invoice_model->get_max_number($month);
    $number++;
    $year_thai = substr($datein[2] + 543, 2, 2);

    $number = "IV".$year_thai.$datein[1].str_pad($number, 3, '0', STR_PAD_LEFT);

    $invoice = array( 'inv_number' => $number,
                    'inv_warehouse_id' => $wh_id,
                    'inv_warehouse_detail' => $cusname,
                    'inv_warehouse_address1' => $cusaddress1,
                    'inv_warehouse_address2' => $cusaddress2,
                    'inv_warehouse_taxid' => $custax_id,
                    'inv_warehouse_branch' => $branch_input,
                    'inv_issuedate' => $datein_input,
                    'inv_vender' => $vender,
                    'inv_barcode' => $barcode,
                    'inv_stot_number' => $tb_number,
                    'inv_stot_id' => $stot_id,
                    'inv_srp_discount' => $discount_srp,
                    'inv_note' => $note,
                    'inv_remark' => $remark,
                    'inv_dateadd' => $currentdate,
                    'inv_dateadd_by' => $this->session->userdata('sessid')
            );

    $last_id = $this->tp_invoice_model->add_invoice_detail($invoice);

    for($i=0; $i<count($it_array); $i++){

        $item = array( 'invit_invoice_id' => $last_id,
                        'invit_qty' => $it_array[$i]["qty"],
                        'invit_refcode' => $it_array[$i]["refcode"],
                        'invit_brand' => $it_array[$i]["brand"],
                        'invit_item_id' => $it_array[$i]["id"],
                        'invit_srp' => $it_array[$i]["srp"],
                        'invit_discount' => $it_array[$i]["dc"],
                        'invit_netprice' => $it_array[$i]["net"]
        );
        $inv_item_id = $this->tp_invoice_model->add_invoice_item($item);
    }

    $result = array("a" => $number, "b" => $last_id);
    //$result = array("a" => 1, "b" => 2);
    echo json_encode($result);
    exit();
}

function view_invoice()
{
    $id = $this->uri->segment(3);

    $sql = "inv_id = '".$id."'";
    $query = $this->tp_invoice_model->get_invoice_detail($sql);
    if($query){
        $data['inv_array'] =  $query;
    }else{
        $data['inv_array'] = array();
    }

    $sql = "invit_invoice_id = '".$id."' and invit_enable=1";
    $query = $this->tp_invoice_model->get_invoice_item($sql);
    if($query){
        $data['item_array'] =  $query;
    }else{
        $data['item_array'] = array();
    }

    $data['inv_id'] = $id;

    if ($this->session->userdata('sessstatus') == 6 || $this->session->userdata('sessstatus') == 1) {
        $data['auth_edit'] = true;
    }else{
        $data['auth_edit'] = false;
    }


    $data['title'] = "NGG| Nerd - View Invoice";
    $this->load->view("TP/invoice/view_invoice", $data);
}

function print_invoice()
{
    $id = $this->uri->segment(3);

    $sql = "inv_id = '".$id."' and inv_enable = '1'";
    $query = $this->tp_invoice_model->get_invoice_detail($sql);
    if($query){
        $data['inv_array'] =  $query;
    }else{
        $data['inv_array'] = array();
    }

    $sql = "invit_invoice_id = '".$id."' and invit_enable=1";
    $query = $this->tp_invoice_model->get_invoice_item($sql);
    if($query){
        $data['item_array'] =  $query;
    }else{
        $data['item_array'] = array();
    }

    if (count($query) % 10 != 1 || count($query) == 1) {
        $data["totalpage"] = ceil(count($query)/10);
    }else{
        $data["totalpage"] = floor(count($query)/10);
    }

    $data["lastpage"] = count($query) % 10;
    $data['count_item'] = count($query);

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th',array(203,278),'0', 'thangsana');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/style_dotprint_invoice.css');

    $mpdf->SetWatermarkImage(base_url()."dist/img/invoice.png", 0.2, 'P');
    //$mpdf->showWatermarkImage = true;

    $datetime = date(YmdHis);
    //echo $html;
    //$mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/invoice/print_invoice_noline", $data, TRUE));
    $mpdf->Output('Invoice_'.$datetime.'.pdf','I');
}

function excel_invoice()
{
    $id = $this->uri->segment(3);

    $sql = "inv_id = '".$id."' and inv_enable = '1'";
    $inv_array = $this->tp_invoice_model->get_invoice_detail($sql);

    $sql = "invit_invoice_id = '".$id."' and invit_enable=1";
    $item_array = $this->tp_invoice_model->get_invoice_item($sql);

    foreach($inv_array as $loop) {
        $inv_id = $loop->inv_id;
        $inv_datein = $loop->inv_issuedate;
        $datein_array = explode("-",$inv_datein);
        $inv_datein = $datein_array[2]."/".$datein_array[1]."/".$datein_array[0];
        $inv_number = $loop->inv_number;
        $inv_whname = $loop->wh_code."-".$loop->wh_name;
        $inv_cusname = $loop->inv_warehouse_detail;
        $inv_address1 = $loop->inv_warehouse_address1;
        $inv_address2 = $loop->inv_warehouse_address2;
        $inv_taxid = $loop->inv_warehouse_taxid;
        $inv_branch = $loop->inv_warehouse_branch;
        if ($inv_branch == 0) {
            $inv_branch = "สำนักงานใหญ่";
        }else{
            $inv_branch = "สาขาที่ ".str_pad($inv_branch, 5, '0', STR_PAD_LEFT);
        }

        $inv_vender = $loop->inv_vender;
        $inv_barcode = $loop->inv_barcode;
        $inv_stot_number = $loop->inv_stot_number;
        $inv_srp_discount = $loop->inv_srp_discount;
        $inv_note = $loop->inv_note;
        $inv_dateadd = $loop->inv_dateadd;
        $inv_remark = $loop->inv_remark;
        $inv_enable = $loop->inv_enable;
        $inv_discount_percent = $loop->inv_discount_percent;

        $editor_view = $loop->firstname." ".$loop->lastname." ".$loop->inv_dateadd;
    }


    //load our new PHPExcel library
    $this->load->library('excel');
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Invoice');

    $this->excel->getActiveSheet()->setCellValue('A1', 'วันที่ออกใบ Invoice');
    $this->excel->getActiveSheet()->setCellValue('B1', $inv_datein);
    $this->excel->getActiveSheet()->setCellValue('D1', 'เลขที่ Invoice');
    $this->excel->getActiveSheet()->setCellValue('E1', $inv_number);

    $this->excel->getActiveSheet()->setCellValue('A2', 'นามผู้ซื้อ');
    $this->excel->getActiveSheet()->setCellValue('B2', $inv_cusname);
    $this->excel->getActiveSheet()->setCellValue('C2', 'เลขประจำตัวผู้เสียภาษี ');
    $this->excel->getActiveSheet()->setCellValue('D2', $inv_taxid);
    $this->excel->getActiveSheet()->setCellValue('F2', 'ที่อยู่ผู้ซื้อ ');
    $this->excel->getActiveSheet()->setCellValue('G2', $inv_address1." ".$inv_address2);
    $this->excel->getActiveSheet()->setCellValue('H2', $inv_branch);

    $this->excel->getActiveSheet()->setCellValue('A3', 'Vender Code');
    $this->excel->getActiveSheet()->setCellValue('B3', $inv_vender);
    $this->excel->getActiveSheet()->setCellValue('C3', 'Barcode');
    $this->excel->getActiveSheet()->setCellValue('D3', $inv_barcode);
    $this->excel->getActiveSheet()->setCellValue('E3', 'เลขที่ใบส่งของอ้างอิง');
    $this->excel->getActiveSheet()->setCellValue('F3', $inv_stot_number);
    $this->excel->getActiveSheet()->setCellValue('G3', 'ส่วนลดราคาป้าย '.$inv_srp_discount.' %');

    $this->excel->getActiveSheet()->setCellValue('A5', 'Ref. Number');
    $this->excel->getActiveSheet()->setCellValue('B5', 'รายละเอียด');
    $this->excel->getActiveSheet()->setCellValue('C5', 'จำนวน');
    $this->excel->getActiveSheet()->setCellValue('D5', 'หน่วยละ');
    $this->excel->getActiveSheet()->setCellValue('E5', 'ส่วนลด %');
    $this->excel->getActiveSheet()->setCellValue('F5', 'จำนวนเงิน');

    $row = 6;
    $sum = 0;
    $sum_qty = 0;
    foreach($item_array as $loop) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->invit_refcode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, strtoupper($loop->invit_brand));
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->invit_qty);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->invit_srp);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, number_format($loop->invit_discount));
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->invit_netprice*$loop->invit_qty);
        $row++;
        $sum += $loop->invit_netprice*$loop->invit_qty;
        $sum_qty += $loop->invit_qty;
    }
    if ($inv_discount_percent > 0) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, "ส่วนลดท้ายบิล");
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $inv_discount_percent."%");
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $sum*$inv_discount_percent/100);
        $row++;
    }
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, "รวมจำนวน");
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $sum_qty);
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, "รวมเงิน");
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $sum*(100-$inv_discount_percent)/100);


    $filename='invoice_'.$inv_number.'.xlsx'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache

    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
}

function void_invoice()
{
    $id = $this->uri->segment(3);

    $currentdate = date("Y-m-d H:i:s");

    $sql = "inv_id = '".$id."'";
    $query = $this->tp_invoice_model->get_invoice_detail($sql);
    foreach($query as $loop) {
        $remark = $loop->inv_remark;
    }
    $remark .= "##VOID##".$this->input->post("remarkvoid");
    $inv = array("id" => $id, "inv_enable" => 0, "inv_remark" => $remark,
                "inv_dateadd" => $currentdate, "inv_dateadd_by" => $this->session->userdata('sessid')
                );
    $query = $this->tp_invoice_model->edit_invoice_detail($inv);

    redirect('tp_invoice/view_invoice/'.$id, 'refresh');
}

function edit_invoice()
{
    $id = $this->uri->segment(3);

    $this->load->model('tp_warehouse_model','',TRUE);
    $sql = "wh_group_id != 3 and wh_group_id != 6 and wh_enable = 1";
    $data['wh_array'] = $this->tp_warehouse_model->getWarehouse($sql);

    $sql = "inv_id = '".$id."'";
    $query = $this->tp_invoice_model->get_invoice_detail($sql);
    if($query){
        $data['inv_array'] =  $query;
    }else{
        $data['inv_array'] = array();
    }

    $sql = "invit_invoice_id = '".$id."' and invit_enable = 1";
    $query = $this->tp_invoice_model->get_invoice_item($sql);
    if($query){
        $data['item_array'] =  $query;
    }else{
        $data['item_array'] = array();
    }

    $data['inv_id'] = $id;

    $data['title'] = "NGG| Nerd - Edit Invoice";
    $this->load->view("TP/invoice/edit_invoice", $data);
}

function save_edit_invoice()
{
    $inv_id = $this->input->post("inv_id");
    $datein = $this->input->post("datein");
    $number = $this->input->post("number");
    $wh_id = $this->input->post("wh_id");
    $cusname = $this->input->post("cusname");
    $cusaddress1 = $this->input->post("cusaddress1");
    $cusaddress2 = $this->input->post("cusaddress2");
    $custax_id = $this->input->post("custax_id");
    $branch = $this->input->post("branch");
    $branch_number = $this->input->post("branch_number");
    $vender = $this->input->post("vender");
    $barcode = $this->input->post("barcode");
    $tb_number = $this->input->post("tb_number");
    $stot_id = $this->input->post("stot_id");
    $discount_srp = $this->input->post("discount_srp");
    $note = $this->input->post("note");
    $remark = $this->input->post("remark");
    $it_array = $this->input->post("item");

    if ($branch == -1) {
        $branch_input = $branch_number;
    }else if ($branch == 0) {
        $branch_input = $branch;
    }

    $currentdate = date("Y-m-d H:i:s");

    $datein = explode('/', $datein);
    $datein_input = $datein[2]."-".$datein[1]."-".$datein[0];

    $invoice = array( 'id' => $inv_id,
                    'inv_warehouse_id' => $wh_id,
                    'inv_warehouse_detail' => $cusname,
                    'inv_warehouse_address1' => $cusaddress1,
                    'inv_warehouse_address2' => $cusaddress2,
                    'inv_warehouse_taxid' => $custax_id,
                    'inv_warehouse_branch' => $branch_input,
                    'inv_issuedate' => $datein_input,
                    'inv_vender' => $vender,
                    'inv_barcode' => $barcode,
                    'inv_stot_number' => $tb_number,
                    'inv_stot_id' => $stot_id,
                    'inv_srp_discount' => $discount_srp,
                    'inv_note' => $note,
                    'inv_remark' => $remark,
                    'inv_dateadd' => $currentdate,
                    'inv_dateadd_by' => $this->session->userdata('sessid')
            );

    $last_id = $this->tp_invoice_model->edit_invoice_detail($invoice);


    $sql = "invit_invoice_id = '".$inv_id."'";
    $query_item = $this->tp_invoice_model->get_invoice_item($sql);

    $new_item = array();
    $index = 0;

    foreach($query_item as $loop3) {
        $item = array( 'id' => $loop3->invit_id,
                    'invit_enable' => 0
            );
        $inv_item_id = $this->tp_invoice_model->edit_invoice_item($item);
    }

    for($i=0; $i<count($it_array); $i++){
        $item = array( 'invit_invoice_id' => $inv_id,
                        'invit_qty' => $it_array[$i]["qty"],
                        'invit_refcode' => $it_array[$i]["refcode"],
                        'invit_brand' => $it_array[$i]["brand"],
                        'invit_item_id' => $it_array[$i]["id"],
                        'invit_srp' => $it_array[$i]["srp"],
                        'invit_discount' => $it_array[$i]["dc"],
                        'invit_netprice' => $it_array[$i]["net"]
            );
        $inv_item_id = $this->tp_invoice_model->add_invoice_item($item);
    }
    /*  ok if item id is not duplicate
    for($i=0; $i<count($it_array); $i++){
        $duplicate = 0;
        foreach($query_item as $loop3) {
            if ($loop3->invit_item_id == $it_array[$i]["id"]) {
                $duplicate = $loop3->invit_id;
                $new_item[$index] = $it_array[$i]["id"];
                $index++;
            }
        }
        if ($duplicate > 0) {
            $item = array( 'id' => $duplicate,
                        'invit_qty' => $it_array[$i]["qty"],
                        'invit_refcode' => $it_array[$i]["refcode"],
                        'invit_brand' => $it_array[$i]["brand"],
                        'invit_item_id' => $it_array[$i]["id"],
                        'invit_srp' => $it_array[$i]["srp"],
                        'invit_discount' => $it_array[$i]["dc"],
                        'invit_netprice' => $it_array[$i]["net"]
            );
            $inv_item_id = $this->tp_invoice_model->edit_invoice_item($item);
        }else{
            $item = array( 'invit_invoice_id' => $inv_id,
                        'invit_qty' => $it_array[$i]["qty"],
                        'invit_refcode' => $it_array[$i]["refcode"],
                        'invit_brand' => $it_array[$i]["brand"],
                        'invit_item_id' => $it_array[$i]["id"],
                        'invit_srp' => $it_array[$i]["srp"],
                        'invit_discount' => $it_array[$i]["dc"],
                        'invit_netprice' => $it_array[$i]["net"]
            );
            $inv_item_id = $this->tp_invoice_model->add_invoice_item($item);
        }
    }

    foreach($query_item as $loop4) {
        $exist = 0;
        for($i=0; $i<count($new_item); $i++) {
            if ($loop4->invit_item_id == $new_item[$i]) {
                $exist = 1;
            }
        }
        if ($exist == 0) {
            $item = array( 'id' => $loop4->invit_id,
                        'invit_enable' => 0
            );
            $inv_item_id = $this->tp_invoice_model->edit_invoice_item($item);
        }
    }

    */

    $result = array("a" => $number, "b" => $inv_id);
    //$result = array("a" => 1, "b" => 2);
    echo json_encode($result);
    exit();
}

function get_invoice_item()
{
    $inv_id = $this->input->post("inv_id");
    $dc1 = $this->input->post("dc1");

    $output = array();
    $index = 0 ;
    $sql = "invit_invoice_id = '".$inv_id."' and invit_enable = 1";
    $result = $this->tp_invoice_model->get_invoice_item($sql);

    if (count($result) >0) {
        foreach($result as $loop) {
            $output[$index] = "<td><input type='hidden' name='it_id' value='".$loop->invit_item_id."'><input type='hidden' name='it_refcode' value='".$loop->invit_refcode."'>".$loop->invit_refcode."</td><td><input type='hidden' name='br_name' value='".$loop->invit_brand."'>".$loop->invit_brand."</td><td><input type='hidden' name='it_srp1' id='it_srp1' value='".$loop->it_srp."'>".$loop->it_srp."</td><td><input type='text' style='width: 80px;' name='it_discount1' id='it_discount1' value='".number_format($dc1)."' onChange='calSRP();'";
            if ($loop->invit_item_id > 1) $output[$index] .= " readonly";
            $output[$index] .= "></td><td><input type='text' name='it_qty' id='it_qty' value='".$loop->invit_qty."' onChange='calculate();'></td><td><input type='text' name='it_srp' id='it_srp' value='".number_format($loop->invit_srp, 2, ".", ",")."' readonly></td><td><input type='text' style='width: 80px;' name='it_discount' id='it_discount' value='".number_format($loop->invit_discount)."' onChange='calDiscount();'></td><td><input type='text' name='it_netprice' id='it_netprice' value='".number_format($loop->invit_netprice, 2, ".", ",")."' onChange='calculate();'></td>";
            $index++;
        }
    }

    echo json_encode($output);
    exit();
}

function list_invoice_month()
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
    $sql = "inv_enable = '1' and invit_enable = '1'";
    $sql .= " and inv_issuedate >= '".$start."' and inv_issuedate <= '".$end."'";

    $data['inv_array'] = $this->tp_invoice_model->get_invoice_detail_sumnetprice_list($sql);

    $data['title'] = "Nerd - Invoice List";
    $this->load->view("TP/invoice/list_invoice_month", $data);
}

function upload_excel_invoice()
{
    $luxury = $this->uri->segment(3);

    $this->load->helper(array('form', 'url'));

    $config['upload_path']          = './uploads/excel';
    $config['allowed_types']        = 'xls|xlsx';
    $config['max_size']             = '5000';

    $this->load->library('upload', $config);

    if ( !$this->upload->do_upload('excelfile_name'))
    {
        $error = array('error' => $this->upload->display_errors());

    }
    else
    {
        $data = $this->upload->data();
        $arr = array();
        $index = 0;
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($data['full_path']);
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        foreach ($cell_collection as $cell) {
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

            if ($row != 1) {
                $arr_data[$row-2][$column] = $data_value;

            }

        }

        for($i=0; $i<count($arr_data); $i++) {
            if ($arr_data[$i]['A'] != "") {
                $sql = "it_enable = 1 and it_refcode = '".$arr_data[$i]['A']."' and ".$this->no_rolex;
                $sql .= " and it_has_caseback = '".$luxury."'";
                $this->load->model('tp_item_model','',TRUE);
                $result = $this->tp_item_model->getItem($sql);
                foreach ($result as $loop) {
                    $output = "<td><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' id='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td><td>";
                    if ($luxury == 0) {
                        $output .= "<input type='text' name='it_quantity' id='it_quantity' value='".$arr_data[$i]['B']."' style='width: 50px;' onChange='calculate();'></td><td>".$loop->it_uom."</td>";
                    }else{
                        $output .= "<input type='hidden' name='it_quantity' id='it_quantity' value='1'>1</td><td>".$loop->it_uom."</td>";
                        $output .= "<td><input type='text' name='it_code' id='it_code' value='".$arr_data[$i]['B']."' style='width: 200px;'></td>";
                    }

                    $arr[$index] = $output;
                    $index++;
                }
            }

        }
        unlink($data['full_path']);

        echo json_encode($arr);
        exit();
    }

}

function upload_excel_invoice_item()
{
    $this->load->helper(array('form', 'url'));

    $config['upload_path']          = './uploads/excel';
    $config['allowed_types']        = 'xls|xlsx';
    $config['max_size']             = '5000';

    $this->load->library('upload', $config);

    if ( !$this->upload->do_upload('excelfile_name'))
    {
        $error = array('error' => $this->upload->display_errors());

    }
    else
    {
        $data = $this->upload->data();
        $arr = array();
        $index = 0;
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($data['full_path']);
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        foreach ($cell_collection as $cell) {
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

            if ($row != 1) {
                $arr_data[$row-2][$column] = $data_value;

            }

        }

        $index = 0 ;
        $output = array();
        for($i=0; $i<count($arr_data); $i++) {
            if ($arr_data[$i]['A'] != "" && $arr_data[$i]['B'] != "") {
              $sql = "it_refcode = '".$arr_data[$i]['A']."' and it_enable = '1'";
              $this->load->model('tp_item_model','',TRUE);
              $result = $this->tp_item_model->getItem($sql);

              if (count($result) >0) {
                  foreach($result as $loop) {
                      $output[$index] = "<td><input type='hidden' name='it_id' value='".$loop->it_id."'><input type='hidden' name='it_refcode' value='".$loop->it_refcode."'>".$loop->it_refcode."</td><td><input type='hidden' name='br_name' value='".$loop->br_name."'>".$loop->br_name."</td><td><input type='hidden' name='it_srp1' id='it_srp1' value='".$loop->it_srp."'>".$loop->it_srp."</td><td><input type='text' style='width: 80px;' name='it_discount1' id='it_discount1' value='' onChange='calSRP();'";
                      // repair item can edit
                      if ($loop->it_id > 1) $output[$index] .= " readonly";
                      $output[$index] .= "></td><td><input type='text' name='it_qty' id='it_qty' value='".$arr_data[$i]['B']."' onChange='calculate();'></td><td><input type='text' name='it_srp' id='it_srp' value='".number_format($loop->it_srp, 2, ".", ",")."' readonly></td><td><input type='text' style='width: 80px;' name='it_discount' id='it_discount' value='' onChange='calDiscount();'></td><td><input type='text' name='it_netprice' id='it_netprice' value='".number_format($loop->it_srp, 2, ".", ",")."' onChange='calculate();'></td>";
                      $index++;
                  }
              }


            }

        }
        unlink($data['full_path']);

        echo json_encode($output);
        exit();
    }

}

}
?>
