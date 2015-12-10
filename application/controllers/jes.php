<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jes extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->model('jes_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function license_now()
{
    $query = $this->jes_model->getActiveLicense();
    
    $user_array = array();
    $i =0;
    foreach ($query as $loop) {
        $text = $loop->SID;
        preg_match_all("/\[([^\]]*)\]/", $text, $matches, PREG_SET_ORDER);
        foreach ($matches as $r) {
            $user = $this->jes_model->getUser($r[1]);
            foreach($user as $loop2) { 
                $user_array[$i] = array( 'userfullname' => $loop2->UserFullName, 
                               'sid' => $loop->SID,
                               'LastUpdate' => $loop->LastUpdate ); 
                $i++;
            }
            
        }
        
        
    }
    //$data['license_array'] = $query;
    $data['user_array'] = $user_array;
    
    $data['user_status'] = $this->session->userdata('sessstatus');
    $data['title'] = "NGG|IT Nerd - JES license";
    $this->load->view('JES/license_now',$data);
}
    
function watch()
{
    $remark = $this->uri->segment(3);
    
    $whtype = $this->jes_model->getAllWHType();
    foreach($whtype as $loop) {
        if(($remark=='0') || (!isset($remark))) {
            $lux_query = $this->jes_model->getNumberWatch_warehouse($loop->WTCode, '_L');
            $fashion_query = $this->jes_model->getNumberWatch_warehouse($loop->WTCode, '_F');
        }elseif($remark=='1') {
            $lux_query = $this->jes_model->getNumberWatch_warehouse($loop->WTCode, '_LC#');
            $fashion_query = $this->jes_model->getNumberWatch_warehouse($loop->WTCode, '_FC#');
        }elseif($remark=='2') {
            $lux_query = $this->jes_model->getNumberWatch_warehouse($loop->WTCode, '_L');
            $fashion_query = $this->jes_model->getNumberWatch_warehouse($loop->WTCode, '_F');
            
            $lux_temp = $this->jes_model->getNumberWatch_warehouse($loop->WTCode, '_LC#');
            $fashion_temp = $this->jes_model->getNumberWatch_warehouse($loop->WTCode, '_FC#');
            
            foreach($lux_query as &$loop1) {
                foreach($lux_temp as $loop2) {
                    if($loop1->WTCode == $loop2->WTCode) {
                        $loop1->sum1 = $loop1->sum1 - $loop2->sum1;
                    }
                }
            }
            
            foreach($fashion_query as &$loop1) {
                foreach($fashion_temp as $loop2) {
                    if($loop1->WTCode == $loop2->WTCode) {
                        $loop1->sum1 = $loop1->sum1 - $loop2->sum1;
                    }
                }
            }
        }
        
        if(!empty($lux_query)) {
            foreach($lux_query as $loop2) {
                $lux_sum = $loop2->sum1;
            }
        }else{
            $lux_sum = 0;
        }
        
        if(!empty($fashion_query)) {
            foreach($fashion_query as $loop2) {
                $fashion_sum = $loop2->sum1;
            }
        }else{
            $fashion_sum = 0;
        }
        if (($lux_sum>0)||($fashion_sum>0)) {
        $whcode_array[] = array("WTCode"=>$loop->WTCode, "WTDesc1"=>$loop->WTDesc1, "luxsum"=>$lux_sum, "fashionsum"=>$fashion_sum);
        }
    }
    
    //$data['brand_array'] = $this->jes_model->getInventoryWatch_whtype();
    //$query = $this->jes_model->getProductType_onlyWatch();
    if(($remark=='0') || (!isset($remark))) {
        $query = $this->jes_model->getProductType_onlyWatch_lf("_L");
    }elseif($remark=='1') {
        $query = $this->jes_model->getProductType_onlyWatch_lf("_LC#");
    }else{
        $query = $this->jes_model->getProductType_onlyWatch_lf("_L");
        
        $query_temp = $this->jes_model->getProductType_onlyWatch_lf("_LC#");
        
        foreach($query as $loop1 => $pt_result) {
            foreach($query_temp as $loop2) {
                if($pt_result->PTCode == $loop2->PTCode) {
                    unset($query[$loop1]);
                }
            }
        }
    }
    $data['producttype_array'] = $query;
    //$pt_array = array();
    foreach($query as $loop) {
        $pt_query = $this->jes_model->getInventoryWatch_producttype($loop->PTCode);
        if(!empty($pt_query)) {
            foreach($pt_query as $loop2) {
                $luxbrand_array[] = array("PTCode"=>$loop->PTCode, "PTDesc1"=>$loop->PTDesc1, "sum1"=>$loop2->sum1);
            }
        }else{
            $luxbrand_array[] = array("PTCode"=>$loop->PTCode, "PTDesc1"=>$loop->PTDesc1, "sum1"=> 0);
        }
    }
    
    if(($remark=='0') || (!isset($remark))) {
        $query = $this->jes_model->getProductType_onlyWatch_lf("_F");
    }elseif($remark=='1') {
        $query = $this->jes_model->getProductType_onlyWatch_lf("_FC#");
    }else{
        $query = $this->jes_model->getProductType_onlyWatch_lf("_F");
        
        $query_temp = $this->jes_model->getProductType_onlyWatch_lf("_FC#");
        
        foreach($query as $loop1 => $pt_result) {
            foreach($query_temp as $loop2) {
                if($pt_result->PTCode == $loop2->PTCode) {
                    unset($query[$loop1]);
                }
            }
        }
    }
    $data['producttype_array'] = $query;
    //$pt_array = array();
    foreach($query as $loop) {
        $pt_query = $this->jes_model->getInventoryWatch_producttype($loop->PTCode);
        if(!empty($pt_query)) {
            foreach($pt_query as $loop2) {
                $fashionbrand_array[] = array("PTCode"=>$loop->PTCode, "PTDesc1"=>$loop->PTDesc1, "sum1"=>$loop2->sum1);
            }
        }else{
            $fashionbrand_array[] = array("PTCode"=>$loop->PTCode, "PTDesc1"=>$loop->PTDesc1, "sum1"=> 0);
        }
    }
    
    // only CT central graph
    $ct_array = $this->watch_viewInventory_graph('CT', $remark);
    // only CT The mall graph
    $mg_array = $this->watch_viewInventory_graph('MG', $remark);
    // only CT robinson graph
    $rb_array = $this->watch_viewInventory_graph('RB', $remark);
    
    $data['luxbrand_array'] = $luxbrand_array;
    $data['fashionbrand_array'] = $fashionbrand_array;
    $data['whcode_array'] = $whcode_array;
    $data['ct_array'] = $ct_array;
    $data['mg_array'] = $mg_array;
    $data['rb_array'] = $rb_array;
    
    if($remark=='') $remark='0';
    $data['remark'] = $remark;
    
    $data['title'] = "NGG|IT Nerd - Watch";
    $this->load->view('JES/watch/main',$data);
}
    
function watch_viewInventory_graph($whtype, $remark)
{
    $whname = $this->jes_model->getAllWHName($whtype);
    $result_array = array();
    
    foreach($whname as $loop) {
        $lux_sum = 0;
        $fashion_sum = 0;
        if(($remark=='0') || (!isset($remark))) {
            $lux_query = $this->jes_model->getNumberWatch_departmentstore($loop->WHCode, '_L');
            $fashion_query = $this->jes_model->getNumberWatch_departmentstore($loop->WHCode, '_F');
        }elseif ($remark=='1') {
            $lux_query = $this->jes_model->getNumberWatch_departmentstore($loop->WHCode, '_LC#');
            $fashion_query = $this->jes_model->getNumberWatch_departmentstore($loop->WHCode, '_FC#');
        }elseif ($remark=='2') {
            $lux_query = $this->jes_model->getNumberWatch_departmentstore($loop->WHCode, '_L');
            $fashion_query = $this->jes_model->getNumberWatch_departmentstore($loop->WHCode, '_F');
            
            $lux_temp = $this->jes_model->getNumberWatch_departmentstore($loop->WHCode, '_LC#');
            $fashion_temp = $this->jes_model->getNumberWatch_departmentstore($loop->WHCode, '_FC#');
            
            foreach($lux_query as &$loop1) {
                foreach($lux_temp as $loop2) {
                    if($loop1->IHWareHouse == $loop2->IHWareHouse) {
                        $loop1->sum1 = $loop1->sum1 - $loop2->sum1;
                    }
                }
            }
            
            foreach($fashion_query as &$loop1) {
                foreach($fashion_temp as $loop2) {
                    if($loop1->IHWareHouse == $loop2->IHWareHouse) {
                        $loop1->sum1 = $loop1->sum1 - $loop2->sum1;
                    }
                }
            }
        }
        
        if(!empty($lux_query)) {
            foreach($lux_query as $loop2) {
                $lux_sum += $loop2->sum1;
            }
        }
        
        if(!empty($fashion_query)) {
            foreach($fashion_query as $loop2) {
                $fashion_sum = $loop2->sum1;
            }
        }
        if (($lux_sum>0)||($fashion_sum>0)) {
            $result_array[] = array("WHCode"=>$loop->WHCode, "WHDesc1"=>$loop->WHDesc1, "luxsum"=>$lux_sum, "fashionsum"=>$fashion_sum);
        }
    }
    
    return $result_array;
}
    
function watch_viewInventory_branch()
{
    $remark = $this->uri->segment(3);
    $wh_code = $this->uri->segment(4);
    
    //$data['item_array'] = $this->jes_model->getInventoryWatch_branch_item($wh_code);
    $query = $this->jes_model->getStoreName($wh_code);
    foreach($query as $loop) {
        $data['branchname'] = $loop->WHDesc1;
        $data['whtypecode'] = $loop->WHType;
        $query = $this->jes_model->getWarehouseTypeName($loop->WHType);
        foreach($query as $loop) {
            $data['whtypename'] = $loop->WTDesc1;
        }
    }
    
    if ($remark==0) {
        $data['pt_array'] = $this->jes_model->getInventoryWatch_branch_item_producttype($wh_code,"");
        $data['item_array'] = $this->jes_model->getInventoryWatch_branch_item($wh_code,"");
    }elseif($remark==1) {
        $data['pt_array'] = $this->jes_model->getInventoryWatch_branch_item_producttype($wh_code,"C#");
        $data['item_array'] = $this->jes_model->getInventoryWatch_branch_item($wh_code,"C#");
    }elseif($remark==2) {
        $pt_query = $this->jes_model->getInventoryWatch_branch_item_producttype($wh_code,"");
        $pt_temp = $this->jes_model->getInventoryWatch_branch_item_producttype($wh_code,"C#");
        
        foreach($pt_query as &$loop1) {
            foreach($pt_temp as $loop2) {
                if($loop1->PTCode == $loop2->PTCode) {
                    $loop1->sum1 = $loop1->sum1 - $loop2->sum1;
                }
            }
        }
        
        $data['pt_array'] = $pt_query;
        
        $item_query1 = $this->jes_model->getInventoryWatch_branch_item($wh_code,"H#");
        $item_query2 = $this->jes_model->getInventoryWatch_branch_item($wh_code,"D#");
        $data['item_array'] = array_merge($item_query1,$item_query2);
    }
        
    $data['title'] = "NGG|IT Nerd - Watch";
    $this->load->view('JES/watch/viewInventory_branch_item',$data);
}
    
function watch_viewInventory_whtype()
{
    $remark = $this->uri->segment(3);
    $wh_code = $this->uri->segment(4);

    $query = $this->jes_model->getWarehouseTypeName($wh_code);
    foreach($query as $loop) {
        $data['branchname'] = $loop->WTDesc1;
    }
    
    if ($remark==0) {
        $data['lux_array'] = $this->jes_model->getInventoryWatch_whtype_brand($wh_code,"_L");
        $data['fashion_array'] = $this->jes_model->getInventoryWatch_whtype_brand($wh_code,"_F");
    }elseif($remark==1) {
        $data['lux_array'] = $this->jes_model->getInventoryWatch_whtype_brand($wh_code,"_LC#");
        $data['fashion_array'] = $this->jes_model->getInventoryWatch_whtype_brand($wh_code,"_FC#");
    }elseif($remark==2) {
        $lux_query = $this->jes_model->getInventoryWatch_whtype_brand($wh_code,"_L");
        $fashion_query = $this->jes_model->getInventoryWatch_whtype_brand($wh_code,"_F"); 
        
        $lux_temp = $this->jes_model->getInventoryWatch_whtype_brand($wh_code,"_LC#");
        $fashion_temp = $this->jes_model->getInventoryWatch_whtype_brand($wh_code,"_FC#"); 
        
        foreach($lux_query as &$loop1) {
            foreach($lux_temp as $loop2) {
                if($loop1->PTCode == $loop2->PTCode) {
                    $loop1->sum1 = $loop1->sum1 - $loop2->sum1;
                }
            }
        }
            
        foreach($fashion_query as &$loop1) {
            foreach($fashion_temp as $loop2) {
                if($loop1->PTCode == $loop2->PTCode) {
                    $loop1->sum1 = $loop1->sum1 - $loop2->sum1;
                }
            }
        }
        
        $data['lux_array'] = $lux_query;
        $data['fashion_array'] = $fashion_query;
    }
    
    if ($wh_code != "HQ") {
        $data['branch_array'] = $this->watch_viewInventory_graph($wh_code, $remark);
        $data['whcode'] = $wh_code;
    }
    
    $data['remark'] = $remark;
    
    $data['title'] = "NGG|IT Nerd - Watch";
    $this->load->view('JES/watch/viewInventory_whtype',$data);
}
    
function watch_viewInventory_product()
{
    $pt_code = $this->uri->segment(3);
    
    $data['item_array'] = $this->jes_model->getInventoryWatch_product_item($pt_code);
    $query = $this->jes_model->getProductName($pt_code);
    foreach($query as $loop) {
        $data['branchname'] = $loop->PTDesc1;
    }
    $data['pt_array'] = $this->jes_model->getInventoryWatch_product_item_branch($pt_code);
    $data['pt_code'] = $pt_code;
    
    $data['title'] = "NGG|IT Nerd - Watch";
    $this->load->view('JES/watch/viewInventory_product_item',$data);
}
    
function watch_store()
{
    $data['brand_array'] = $this->jes_model->getAllWHType();
    $data['title'] = "NGG|IT Nerd - Watch";
    $this->load->view('JES/watch/viewStore',$data);
}
    
function watch_store_departmentstore()
{
    $dp_code = $this->uri->segment(3);
    
    $data['brand_array'] = $this->jes_model->getAllWHName($dp_code);
    $data['title'] = "NGG|IT Nerd - Watch";
    $this->load->view('JES/watch/viewStore_departmentstore',$data);
}

function watch_store_branch()
{
    $dp_code = $this->uri->segment(3);
    
    $data['brand_array'] = $this->jes_model->getWarehouse_branch($dp_code);
    $data['title'] = "NGG|IT Nerd - Watch";
    $this->load->view('JES/watch/viewStore_departmentstore',$data);
}
    
function watch_store_product()
{
    $pt_code = $this->uri->segment(3);
    
    $data['brand_array'] = $this->jes_model->getWarehouse_product($pt_code);
    $data['title'] = "NGG|IT Nerd - Watch";
    $this->load->view('JES/watch/viewStore_departmentstore',$data);
}
    
function report()
{
    $query = $this->jes_model->getAllWHType();
    $data['whtype_array'] = $query;
    
    $whname_array = array();
    foreach($query as $loop) {
        $whname_array[] = array("wh" => $this->jes_model->getWarehouse_branch($loop->WTCode), "WHType" => $loop->WTCode);
    }
    
    $data['whname_array'] = $whname_array;
    $data['lux_array'] = $this->jes_model->getProductType_onlyWatch_lf("_L");
    $data['fashion_array'] = $this->jes_model->getProductType_onlyWatch_lf("_F");
    
    $data['title'] = "NGG|IT Nerd - Report";
    $this->load->view('JES/watch/report',$data);
}
    
function report_filter()
{
    $query = $this->jes_model->getAllWHType();
    // warehouse[][] => All warehouse code chosen 
    $warehouse = array();
    $count = 0;
    foreach($query as $loop) {
        $x = $this->input->post("whname_".$loop->WTCode);
        if (count($x)>0) {
            $warehouse[] = $x;
            $count++;
        }
    }
    $lux = $this->input->post("ptype_lux");
    $fashion = $this->input->post("ptype_fashion");
    if (empty($lux)) $lux = array();
    if (empty($fashion)) $fashion = array();
    // all product type code
    $producttype = array_merge($lux, $fashion);
    
    if ($this->input->post("action")==0) {
        // When you need stock balance report
        
        $product = array();
        for($i=0; $i<count($producttype); $i++) {
            $query = $this->jes_model->getOneProductType($producttype[$i]);
            foreach($query as $loop) {
                $product[] = $loop->PTDesc1;
            }
        }

        $stock = array();
        for ($i=0; $i<$count; $i++) {
            for ($j=0; $j<count($warehouse[$i]); $j++) {
                if ($warehouse[$i][$j] !="") {
                    $query = $this->jes_model->getOneWareHouseName($warehouse[$i][$j]);
                    foreach($query as $loop) $whname = $loop->WHDesc1;

                    $stock[] = array("number" => $this->jes_model->reportStock_store_product($warehouse[$i][$j],$producttype), "whname" => $whname);
                }
            }
        }

        $data['stock'] = $stock;
        //$data['warehouse'] = $warehouse;
        $data['producttype'] = $producttype;
        $data['product'] = $product;

        $this->session->set_flashdata("sessionproduct", $product);
        $this->session->set_flashdata("sessionproducttype", $producttype);
        $this->session->set_flashdata("sessionwarehouse", $warehouse);

        $data['title'] = "NGG|IT Nerd - Report";
        $this->load->view('JES/watch/report_filter',$data);
        
    }elseif($this->input->post("action")==1) {
        // When you need stock item list
            
        $data['item_array'] = $this->jes_model->reportStock_itemlist_store_product($warehouse, $producttype);
        
        $this->session->set_flashdata("sessionproducttype", $producttype);
        $this->session->set_flashdata("sessionwarehouse", $warehouse);
        
        $data['title'] = "NGG|IT Nerd - Report";
        $this->load->view('JES/watch/report_filter_itemlist',$data);
    }
}
    
function exportExcel_stock()
{
    $warehouse = $this->session->flashdata("sessionwarehouse");
    $product = $this->session->flashdata("sessionproduct");  
    $producttype = $this->session->flashdata("sessionproducttype");  

    $stock = array();
    for ($i=0; $i<count($warehouse); $i++) {
        for ($j=0; $j<count($warehouse[$i]); $j++) {
            if ($warehouse[$i][$j] !="") {
                $query = $this->jes_model->getOneWareHouseName($warehouse[$i][$j]);
                foreach($query as $loop) $whname = $loop->WHDesc1;
                
                $stock[] = array("number" => $this->jes_model->reportStock_store_product($warehouse[$i][$j],$producttype), "whname" => $whname);
            }
        }
    }
    
    //load our new PHPExcel library
    $this->load->library('excel');
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Stock_Balance');

    //$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "ทองคำแท่ง (96.5)");
    $this->excel->getActiveSheet()->setCellValue('A1', 'Warehouse');
    $char = 'B';
    $count = 0;
    for($i=0; $i<count($product); $i++) {
        $this->excel->getActiveSheet()->setCellValue($char.'1', $product[$i]);
        $char++;
        $count++;
        $sum_product[$i] = 0;
    }
    
    $this->excel->getActiveSheet()->setCellValue($char.'1', "Sum");
    
    $row = 2;
    for($i=0; $i<count($stock); $i++) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $stock[$i]['whname']);
        
        foreach($stock[$i]['number'] as $loop) {
            $sum_store=0;
            $column = 1;
            for($k=0; $k<$count; $k++) {
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow($column, $row, $loop->{"num".$k});
                $sum_store+=$loop->{"num".$k};
                $sum_product[$k]+=$loop->{"num".$k};
                $column++;
            }
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($column, $row, $sum_store);
        }
        
        
        $row++;
    }
    
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "Sum");
    $column = 1;
    for($i=0; $i<count($product); $i++) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow($column, $row, $sum_product[$i]);
        $column++;
    }
    

    $filename='timepieces_stock_balance.xlsx'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache

    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
}
    
function exportExcel_stock_itemlist()
{
    $warehouse = $this->session->flashdata("sessionwarehouse");
    $producttype = $this->session->flashdata("sessionproducttype");  
    
    $item_array = $this->jes_model->reportStock_itemlist_store_product($warehouse, $producttype);
    
    //load our new PHPExcel library
    $this->load->library('excel');
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Stock_Item_List');

    //$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "ทองคำแท่ง (96.5)");
    $this->excel->getActiveSheet()->setCellValue('A1', 'Barcode');
    $this->excel->getActiveSheet()->setCellValue('B1', 'Item Code');
    $this->excel->getActiveSheet()->setCellValue('C1', 'Ref Code');
    $this->excel->getActiveSheet()->setCellValue('D1', 'Description');
    $this->excel->getActiveSheet()->setCellValue('E1', 'Long Description');
    $this->excel->getActiveSheet()->setCellValue('F1', 'SRP');
    $this->excel->getActiveSheet()->setCellValue('G1', 'Warehouse');
    $this->excel->getActiveSheet()->setCellValue('H1', 'Qty (Pcs.)');
    
    $row = 2;
    foreach($item_array as $loop) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->IHBarcode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->itemcode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->ITRefCode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->ITShortDesc2." ".$loop->ITShortDesc1);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->ITLongDesc1);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, number_format($loop->ITSRP));
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $loop->WHDesc1." (".$loop->WHCode.")");
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->IHQtyCal);
        $row++;
    }
    

    $filename='timepieces_stock_balance.xlsx'; //save our workbook as this file name
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