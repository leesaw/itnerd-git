<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jes_salereport extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->model('jes_model','',TRUE);
     $this->load->model('jes_salereport_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function salereport_graph()
{   
    // show default datepicker
    $current= date('Y-m-d');
    $current = explode('-', $current);
    $data['start_date'] = "01/".$current[1]."/".$current[0];
    $data['end_date'] = $current[2]."/".$current[1]."/".$current[0];
    
    $start = $current[0]."-".$current[1]."-01";
    $end = $current[0]."-".$current[1]."-".$current[2];
    
    // sum sale by brand
    $data['sale_fashion_brand'] = $this->jes_salereport_model->getSale_watch_lf_between("_F",$start,$end);
    
    $data['sale_luxury_brand'] = $this->jes_salereport_model->getSale_watch_lf_between("_L",$start,$end);
    
    // sum sale by shop WTCode
    $shop_fashion[] = array("WTCode"=>0, "WTDesc1"=>0, "sum1"=>0);
    $shop_luxury[] = array("WTCode"=>0, "WTDesc1"=>0, "sum1"=>0);
    $whtype = $this->jes_model->getAllWHType();
    foreach($whtype as $loop) {
        $lux_query = $this->jes_salereport_model->getSale_watch_warehouse_between($loop->WTCode,"_L",$start,$end);
        $fashion_query = $this->jes_salereport_model->getSale_watch_warehouse_between($loop->WTCode,"_F",$start,$end);
        
        $lux_sum = 0;
        foreach($lux_query as $loop2) {
            $lux_sum += $loop2->sum1;
        }
        
        $fashion_sum = 0;
        foreach($fashion_query as $loop2) {
            $fashion_sum += $loop2->sum1;
        }

        if ($fashion_sum>0) {
            $shop_fashion[] = array("WTCode"=>$loop->WTCode, "WTDesc1"=>$loop->WTDesc1, "sum1"=>$fashion_sum);
        }
        
        if ($lux_sum>0) {
            $shop_luxury[] = array("WTCode"=>$loop->WTCode, "WTDesc1"=>$loop->WTDesc1, "sum1"=>$lux_sum);
        }
    }
    
    $data['sale_fashion_shop'] = $shop_fashion;
    $data['sale_luxury_shop'] = $shop_luxury;
    
    $data['title'] = "NGG|Timepieces - Graph Report";
    $this->load->view('JES/watch/salereport_main',$data);
}
    
function filter_graph()
{
    $start = $this->input->post('startdate');
    $end = $this->input->post('enddate');
    
    $data['start_date'] = $start;
    $data['end_date'] = $end;
        
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
    
    // sum sale by brand
    $data['sale_fashion_brand'] = $this->jes_salereport_model->getSale_watch_lf_between("_F",$start,$end);
    
    $data['sale_luxury_brand'] = $this->jes_salereport_model->getSale_watch_lf_between("_L",$start,$end);
    
    // sum sale by shop WTCode
    $shop_fashion[] = array("WTCode"=>0, "WTDesc1"=>0, "sum1"=>0);
    $shop_luxury[] = array("WTCode"=>0, "WTDesc1"=>0, "sum1"=>0);
    $whtype = $this->jes_model->getAllWHType();
    foreach($whtype as $loop) {
        $lux_query = $this->jes_salereport_model->getSale_watch_warehouse_between($loop->WTCode,"_L",$start,$end);
        $fashion_query = $this->jes_salereport_model->getSale_watch_warehouse_between($loop->WTCode,"_F",$start,$end);
        
        $lux_sum = 0;
        foreach($lux_query as $loop2) {
            $lux_sum += $loop2->sum1;
        }
        
        $fashion_sum = 0;
        foreach($fashion_query as $loop2) {
            $fashion_sum += $loop2->sum1;
        }

        if ($fashion_sum>0) {
            $shop_fashion[] = array("WTCode"=>$loop->WTCode, "WTDesc1"=>$loop->WTDesc1, "sum1"=>$fashion_sum);
        }
        
        if ($lux_sum>0) {
            $shop_luxury[] = array("WTCode"=>$loop->WTCode, "WTDesc1"=>$loop->WTDesc1, "sum1"=>$lux_sum);
        }
    }
    
    $data['sale_fashion_shop'] = $shop_fashion;
    $data['sale_luxury_shop'] = $shop_luxury;
    
    $data['title'] = "NGG|Timepieces - Graph Report";
    $this->load->view('JES/watch/salereport_main',$data);
}
    
function salereport_table()
{
    $data['brand_array'] = $this->jes_model->getProductType_onlyWatch_lf("_");

    $shop_array = $this->jes_salereport_model->getShop_branch();
    $data['shop_array'] = $shop_array;
    
    $data['title'] = "NGG|IT Nerd - Sale Report Search";
    $this->load->view('JES/watch/salereport_select',$data);
}
    
function show_salereport()
{
    $brand = $this->input->post("brand");
    $shop = $this->input->post("shop");
    $start = $this->input->post("startdate");
    $end = $this->input->post("enddate");
    
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
    $data['shop'] = $shop;
    $data['startdate'] = $start;
    $data['enddate'] = $end;
    $data['brand'] = $brand;
    
    $data['sale_array'] = $this->jes_salereport_model->getSaleReport_brand_shop_date($brand,$shop,$start,$end);
    
    $data['title'] = "NGG|IT Nerd - Sale Report";
    $this->load->view('JES/watch/salereport_search_viewtable',$data);
}
    
function salereport_filter()
{
    $start = $this->input->post('startdate');
    $end = $this->input->post('enddate');
    
    $data['start_date'] = $start;
    $data['end_date'] = $end;
        
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
    
    
}
    
function sale_viewBrand_filter()
{
    $start = $this->input->post('startdate');
    $end = $this->input->post('enddate');
    
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
    
    $brand = $this->input->post('code');
    
    $data['brand'] = $brand;
    $data['startdate'] = $start;
    $data['enddate'] = $end;
    
    $data['sale_array'] = $this->jes_salereport_model->getSaleReport_brand($brand,$start,$end);
    
    $data['title'] = "NGG|IT Nerd - Sale Report";
    $this->load->view('JES/watch/salereport_brand_viewtable',$data);
}
    
function sale_viewShop_filter()
{
    $start = $this->input->post('startdate');
    $end = $this->input->post('enddate');
    
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
    
    $shop = $this->input->post('code');
    $remark = $this->input->post('remark');
    
    $data['shop'] = $shop;
    $data['startdate'] = $start;
    $data['enddate'] = $end;
    $data['remark'] = $remark;
    
    $data['sale_array'] = $this->jes_salereport_model->getSaleReport_shop($shop,$remark,$start,$end);
    
    $data['title'] = "NGG|IT Nerd - Sale Report";
    $this->load->view('JES/watch/salereport_shop_viewtable',$data);
}

function exportExcel_saleBrand_itemlist()
{
    $brand = $this->input->post("brand");
    $start = $this->input->post("startdate");
    $end = $this->input->post("enddate");
    
    $item_array = $this->jes_salereport_model->getSaleReport_brand($brand,$start,$end);
    
    //load our new PHPExcel library
    $this->load->library('excel');
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Sale_Report');

    //$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "ทองคำแท่ง (96.5)");
    $this->excel->getActiveSheet()->setCellValue('A1', 'Sale Date');
    $this->excel->getActiveSheet()->setCellValue('B1', 'Brand');
    $this->excel->getActiveSheet()->setCellValue('C1', 'Item Code');
    $this->excel->getActiveSheet()->setCellValue('D1', 'Ref Code');
    $this->excel->getActiveSheet()->setCellValue('E1', 'Description');
    $this->excel->getActiveSheet()->setCellValue('F1', 'Shop');
    $this->excel->getActiveSheet()->setCellValue('G1', 'Qty (Pcs.)');
    $this->excel->getActiveSheet()->setCellValue('H1', 'Unit Price');
    $this->excel->getActiveSheet()->setCellValue('I1', 'Discount%');
    $this->excel->getActiveSheet()->setCellValue('J1', 'Total Amount');
    
    
    
    $row = 2;
    foreach($item_array as $loop) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->PIIssueDate);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->PTDesc1);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->PDItemCode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->ITRefCode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->ITShortDesc1);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->SHDesc1." (".$loop->PIShop.")");
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, number_format($loop->PDQty));
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->PDUnitPrice);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $loop->PDDiscPercent);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->PDAmount);
        $row++;
    }
    

    $filename='timepieces_sale_report.xlsx'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache

    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
}
    
function exportExcel_saleShop_itemlist()
{
    $shop = $this->input->post("shop");
    $start = $this->input->post("startdate");
    $end = $this->input->post("enddate");
    $remark = $this->input->post("remark");
    
    $item_array = $this->jes_salereport_model->getSaleReport_shop($shop,$remark,$start,$end);
    
    //load our new PHPExcel library
    $this->load->library('excel');
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Sale_Report');

    //$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "ทองคำแท่ง (96.5)");
    $this->excel->getActiveSheet()->setCellValue('A1', 'Sale Date');
    $this->excel->getActiveSheet()->setCellValue('B1', 'Brand');
    $this->excel->getActiveSheet()->setCellValue('C1', 'Item Code');
    $this->excel->getActiveSheet()->setCellValue('D1', 'Ref Code');
    $this->excel->getActiveSheet()->setCellValue('E1', 'Description');
    $this->excel->getActiveSheet()->setCellValue('F1', 'Shop');
    $this->excel->getActiveSheet()->setCellValue('G1', 'Qty (Pcs.)');
    $this->excel->getActiveSheet()->setCellValue('H1', 'Unit Price');
    $this->excel->getActiveSheet()->setCellValue('I1', 'Discount%');
    $this->excel->getActiveSheet()->setCellValue('J1', 'Total Amount');
    
    
    
    $row = 2;
    foreach($item_array as $loop) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->PIIssueDate);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->PTDesc1);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->PDItemCode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->ITRefCode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->ITShortDesc1);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->SHDesc1." (".$loop->SHCode.")");
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, number_format($loop->PDQty));
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->PDUnitPrice);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $loop->PDDiscPercent);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->PDAmount);
        $row++;
    }
    

    $filename='timepieces_sale_report.xlsx'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache

    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
}
    
function exportExcel_saleSearch_itemlist()
{
    $shop = $this->input->post("shop");
    $start = $this->input->post("startdate");
    $end = $this->input->post("enddate");
    $brand = $this->input->post("brand");
    
    $item_array = $this->jes_salereport_model->getSaleReport_brand_shop_date($brand,$shop,$start,$end);
    
    //load our new PHPExcel library
    $this->load->library('excel');
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Sale_Report');

    //$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "ทองคำแท่ง (96.5)");
    $this->excel->getActiveSheet()->setCellValue('A1', 'Sale Date');
    $this->excel->getActiveSheet()->setCellValue('B1', 'Brand');
    $this->excel->getActiveSheet()->setCellValue('C1', 'Item Code');
    $this->excel->getActiveSheet()->setCellValue('D1', 'Ref Code');
    $this->excel->getActiveSheet()->setCellValue('E1', 'Description');
    $this->excel->getActiveSheet()->setCellValue('F1', 'Shop');
    $this->excel->getActiveSheet()->setCellValue('G1', 'Qty (Pcs.)');
    $this->excel->getActiveSheet()->setCellValue('H1', 'Unit Price');
    $this->excel->getActiveSheet()->setCellValue('I1', 'Discount%');
    $this->excel->getActiveSheet()->setCellValue('J1', 'Total Amount');
    
    
    
    $row = 2;
    foreach($item_array as $loop) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->PIIssueDate);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->PTDesc1);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->PDItemCode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->ITRefCode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->ITShortDesc1);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->SHDesc1." (".$loop->SHCode.")");
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, number_format($loop->PDQty));
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->PDUnitPrice);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $loop->PDDiscPercent);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->PDAmount);
        $row++;
    }
    

    $filename='timepieces_sale_report.xlsx'; //save our workbook as this file name
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