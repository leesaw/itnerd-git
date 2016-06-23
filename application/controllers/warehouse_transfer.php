<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warehouse_transfer extends CI_Controller {

public $no_rolex = "";
    
function __construct()
{
     parent::__construct();
     $this->load->model('tp_warehouse_model','',TRUE);
     $this->load->model('tp_warehouse_transfer_model','',TRUE);
     $this->load->model('tp_log_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
    
     if ($this->session->userdata('sessrolex') == 0) $this->no_rolex = "br_id != 888";
     else $this->no_rolex = "br_id = 888";
}

function index()
{
    
}
    
function importstock() 
{
	$sql = "wh_enable = 1";
	$data['wh_array'] = $this->tp_warehouse_model->getWarehouse($sql);
	$data['currentdate'] = date("d/m/Y");
    $remark = $this->uri->segment(3);
    if ($remark != "") {
        if ($remark == "fashion")
            $remark = 0;
        else
            $remark = 1;
    }else{
        $remark = 0;
    }

    $data['sessrolex'] = $this->session->userdata('sessrolex');
    if ($this->session->userdata('sessrolex') ==1) $remark=1;
    $data['remark'] = $remark;
    $data['title'] = "Nerd - Transfer In";
    $this->load->view("TP/warehouse/addstock_view", $data);
}
    
function upload_excel_transfer_stock()
{
    $luxury = $this->uri->segment(3);
    $whid_out = $this->uri->segment(4);
    
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
                
                $sql = "it_refcode = '".$arr_data[$i]['A']."' and stob_warehouse_id = '".$whid_out."'";
                $result = $this->tp_warehouse_transfer_model->getItem_stock($sql);
                
                foreach ($result as $loop) {
                    $output = "<td><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td>";

                    if ($loop->stob_qty > 0) { 
                        $output .= "<td style='width: 120px;'>";
                    }else{
                        $output .= "<td style='width: 120px;background-color: #F6CECE; font-weight: bold;'>";
                    }
                    $output .= "<input type='hidden' name='old_qty' id='old_qty' value='".$loop->stob_qty."'>".$loop->stob_qty."</td>";
                    $output .= "<td><input type='text' name='it_quantity' id='it_quantity' value='".$arr_data[$i]['B']."' style='width: 50px;' onChange='calculate();'></td><td>".$loop->it_uom."</td>";
                    
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
    
function upload_excel_transfer_stock_fashion()
{
    $luxury = $this->uri->segment(3);
    $whid_out = $this->uri->segment(4);
    
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
            if ($arr_data[$i]['A'] != "" && $arr_data[$i]['B'] != "") {
                if($luxury ==0) {
                    $sql = "it_refcode = '".$arr_data[$i]['A']."' and stob_warehouse_id = '".$whid_out."' and it_has_caseback = '".$luxury."'";
                    $result = $this->tp_warehouse_transfer_model->getItem_stock($sql);
                    foreach ($result as $loop) {
                        $output = "<td><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td>";

                        if ($loop->stob_qty > 0) { 
                            $output .= "<td style='width: 120px;'>";
                        }else{
                            $output .= "<td style='width: 120px;background-color: #F6CECE; font-weight: bold;'>";
                        }
                        $output .= "<input type='hidden' name='old_qty' id='old_qty' value='".$loop->stob_qty."'>".$loop->stob_qty."</td>";
                        $output .= "<td><input type='text' name='it_quantity' id='it_quantity' value='".$arr_data[$i]['B']."' style='width: 50px;' onChange='calculate();'></td><td>".$loop->it_uom."</td>";

                        $arr[$index] = $output;
                        $index++;
                    }
                }else{
                    $sql = "itse_serial_number = '".$arr_data[$i]['B']."' and itse_enable = 1 and itse_warehouse_id = '".$whid_out."' and ".$this->no_rolex;

                    $result = $this->tp_warehouse_transfer_model->getItem_stock_caseback($sql);
                    foreach ($result as $loop) {
                        $output = "<td><input type='hidden' name='itse_id' id='itse_id' value='".$loop->itse_id."'><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td>";
                        $output .= "<td><input type='hidden' name='old_qty' id='old_qty' value='".$loop->stob_qty."'><input type='hidden' name='it_quantity' id='it_quantity' value='1'>1</td><td>".$loop->it_uom."</td>";
                        $output .= "<td><input type='text' name='it_code' id='it_code' value='".$loop->itse_serial_number."' style='width: 200px;' readonly></td>";
                        $arr[$index] = $output;
                        $index++;
                    }
                }

            }
            
        }
        unlink($data['full_path']);
        
        echo json_encode($arr);
        exit();
    }

}
    
function upload_excel_import_stock()
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
    
function transferstock() 
{
	$sql = "wh_enable = 1";
	$data['wh_array'] = $this->tp_warehouse_model->getWarehouse($sql);
	$data['currentdate'] = date("d/m/Y");

    $data['sessrolex'] = $this->session->userdata('sessrolex');
    $data['title'] = "Nerd - Transfer Stock";
    $this->load->view("TP/warehouse/transferstock_view", $data);
}
    
function importstock_print()
{
		$id = $this->uri->segment(3);
		
		$this->load->library('mpdf/mpdf');                
        $mpdf= new mPDF('th','A4','0', 'thsaraban');
		$stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');
		
        $sql = "stoi_id = '".$id."'";
		$query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_in($sql);
		if($query){
			$data['stock_array'] =  $query;
		}else{
			$data['stock_array'] = array();
		}
		
		//echo $html;
        $mpdf->SetJS('this.print();');
		$mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML($this->load->view("TP/warehouse/stock_in_print", $data, TRUE));
        $mpdf->Output();
}
    
function importstock_serial_print()
{
    $id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');                
    $mpdf= new mPDF('th','A4','0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');

    $sql = "stoi_id = '".$id."'";
    $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_in($sql);
    if($query){
        $data['stock_array'] =  $query;
    }else{
        $data['stock_array'] = array();
    }

    $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_in_serial($sql);
    if($query){
        $data['serial_array'] =  $query;
    }else{
        $data['serial_array'] = array();
    }
    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/warehouse/stock_in_print", $data, TRUE));
    $mpdf->Output();
}
    
function importstock_save()
{
    
    $luxury = $this->uri->segment(3);
	$datein = $this->input->post("datein");
	$wh_id = $this->input->post("whid");
    $it_array = $this->input->post("item");
    
    if ($luxury == 1) {
        $this->load->model('tp_item_model','',TRUE);
        for($i=0; $i<count($it_array); $i++){
            $check_caseback = $this->tp_item_model->checkAvailable_caseback($it_array[$i]["code"]);
            if ($check_caseback > 0) {
                $result = array("a" => $i, "b" => 0);
                echo json_encode($result);
                exit();
            }
            
        }
    }
    
    $currentdate = date("Y-m-d H:i:s");
    
    $datein = explode('/', $datein);
    $datein = $datein[2]."-".$datein[1]."-".$datein[0];
    
    $count = 0;
    $month = date("Y-m");
    $month_array = explode('-',date("y-m"));
    
    $number = $this->tp_warehouse_transfer_model->getMaxNumber_transfer_in($month,$this->session->userdata('sessrolex'));
    $number++;
    
    if ($this->session->userdata('sessrolex') == 0) {
        $number = "TR".$month_array[0].$month_array[1].str_pad($number, 4, '0', STR_PAD_LEFT);
    }else{
        $number = "TR-Ro".$month_array[0].$month_array[1].str_pad($number, 3, '0', STR_PAD_LEFT);
    }
    
    $stock = array( 'stoi_number' => $number,
                    'stoi_warehouse_id' => $wh_id,
                    'stoi_datein' => $datein,
                    'stoi_is_rolex' => $this->session->userdata('sessrolex'),
                    'stoi_has_serial' => $luxury,
                    'stoi_dateadd' => $currentdate,
                    'stoi_dateadd_by' => $this->session->userdata('sessid')
            );
    
    $last_id = $this->tp_warehouse_transfer_model->addWarehouse_transfer_in($stock);
    
    for($i=0; $i<count($it_array); $i++){
        
        $sql = "stob_item_id = '".$it_array[$i]["id"]."' and stob_warehouse_id = '".$wh_id."'";
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);
        if (!empty($query)) {
            foreach($query as $loop) {
                $stock_id = $loop->stob_id;
                $qty_new = $loop->stob_qty + $it_array[$i]["qty"];
                $stock = array( 'id' => $loop->stob_id,
                                'stob_qty' => $qty_new,
                                'stob_lastupdate' => $currentdate,
                                'stob_lastupdate_by' => $this->session->userdata('sessid')
                            );
                $query = $this->tp_warehouse_transfer_model->editWarehouse_transfer($stock);
                break;
            }
            $old_qty = $loop->stob_qty;
        }else{
            $stock = array( 'stob_qty' => $it_array[$i]["qty"],
                            'stob_lastupdate' => $currentdate,
                            'stob_lastupdate_by' => $this->session->userdata('sessid'),
                            'stob_warehouse_id' => $wh_id,
                            'stob_item_id' => $it_array[$i]["id"]
                     );
            $query = $this->tp_warehouse_transfer_model->addWarehouse_transfer($stock);
            $stock_id = $this->db->insert_id();
            $old_qty = 0;
            
        }
        
        $stock = array( 'log_stob_transfer_id' => $last_id,
                        'log_stob_status' => 'I',
                        'log_stob_qty_update' => $it_array[$i]["qty"],
                        'log_stob_warehouse_id' => $wh_id,
                        'log_stob_old_qty' => $old_qty,
                        'log_stob_item_id' => $it_array[$i]["id"],
                        'log_stob_stock_balance_id' => $stock_id
        );
        $log_stob_id = $this->tp_log_model->addLogStockBalance($stock);
        $count += $it_array[$i]["qty"];
        
        if ($luxury == 1) {
            $itcode = array("itse_serial_number" => $it_array[$i]["code"], "itse_item_id" => $it_array[$i]["id"], "itse_warehouse_id" => $wh_id, "itse_dateadd" => $currentdate);
            
            $this->load->model('tp_item_model','',TRUE);
            $serial_id = $this->tp_item_model->addItemCode($itcode);
            
            $itcode = array("log_stobs_stob_id" => $log_stob_id, "log_stobs_item_serial_id" => $serial_id);
            $query = $this->tp_log_model->addLogStockBalance_serial($itcode);
        }
    }
    
    $result = array("a" => $count, "b" => $last_id);
    //$result = array("a" => 1, "b" => 2);
    echo json_encode($result);
    exit();
}
    
function transferstock_select_item()
{
    $datein = $this->input->post("datein");
    $whid_out = $this->input->post("whid_out");
    $whid_in = $this->input->post("whid_in");
    
    if ($this->session->userdata('sessrolex') == 0) $caseback = 0;
    else $caseback = 1;
    
    $whout_array = explode('#', $whid_out);
    $whname_out = $whout_array[1];
    $whid_out = $whout_array[0];
    
    $whin_array = explode('#', $whid_in);
    $whname_in = $whin_array[1];
    $whid_in = $whin_array[0];

    $data['datein'] = $datein;
    $data['whid_out'] = $whid_out;
    $data['whname_out'] = $whname_out;
    $data['whid_in'] = $whid_in;
    $data['whname_in'] = $whname_in;
    $data['remark'] = $caseback;
    
    $data['title'] = "Nerd - Transfer Stock";
    $this->load->view("TP/warehouse/transferstock_select_item", $data);
}
    
function transferstock_save()
{
    $luxury = $this->uri->segment(3);
	$datein = $this->input->post("datein");
	$whid_out = $this->input->post("whid_out");
    $whid_in = $this->input->post("whid_in");
    $it_array = $this->input->post("item");
    $stot_remark = $this->input->post("stot_remark");
    
    $currentdate = date("Y-m-d H:i:s");
    
    $datein = explode('/', $datein);
    $datein = $datein[2]."-".$datein[1]."-".$datein[0];
    
    $count = 0;
    $month = date("Y-m");
    $month_array = explode('-',date("y-m"));
    
    $number = $this->tp_warehouse_transfer_model->getMaxNumber_transfer_between($month, $this->session->userdata('sessrolex'));
    $number++;
    
    if ($this->session->userdata('sessrolex') == 0) {
        $number = "TB".$month_array[0].$month_array[1].str_pad($number, 4, '0', STR_PAD_LEFT);
    }else{
        $number = "TB-Ro".$month_array[0].$month_array[1].str_pad($number, 3, '0', STR_PAD_LEFT);
    }
    
    $stock = array( 'stot_number' => $number,
                    'stot_datein' => $datein,
                    'stot_dateadd' => $currentdate,
                    'stot_warehouse_out_id' => $whid_out,
                    'stot_warehouse_in_id' => $whid_in,
                    'stot_status' => 1,
                    'stot_has_serial' => $luxury,
                    'stot_is_rolex' => $this->session->userdata('sessrolex'),
                    'stot_dateadd_by' => $this->session->userdata('sessid'),
                    'stot_remark' => $stot_remark
            );
    $last_id = $this->tp_warehouse_transfer_model->addWarehouse_transfer_between($stock);
    
    for($i=0; $i<count($it_array); $i++){
        if ($luxury==0) {
            $stock = array( 'log_stot_transfer_id' => $last_id,
                            'log_stot_old_qty' => $it_array[$i]["old_qty"],
                            'log_stot_qty_want' => $it_array[$i]["qty"],
                            'log_stot_qty_final' => $it_array[$i]["qty"],
                            'log_stot_item_id' => $it_array[$i]["id"]
            );
            $query = $this->tp_log_model->addLogStockTransfer($stock);
            $count += $it_array[$i]["qty"];
        }else if ($luxury==1){
            $stock = array( 'log_stots_transfer_id' => $last_id,
                            'log_stots_old_qty' => $it_array[$i]["old_qty"],
                            'log_stots_item_serial_id' => $it_array[$i]["id"]
            );
            $query = $this->tp_log_model->addLogStockTransfer_serial($stock);
            $count++;
        }
    }
    $result = array("a" => $count, "b" => $last_id);
    echo json_encode($result);
    exit();
}
    
function transferstock_print()
{
		$id = $this->uri->segment(3);
		
		$this->load->library('mpdf/mpdf');                
        $mpdf= new mPDF('th','A4','0', 'thsaraban');
		$stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');
		
        $sql = "stot_id = '".$id."'";
		$query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between($sql);
		if($query){
			$data['stock_array'] =  $query;
		}else{
			$data['stock_array'] = array();
		}
		
		//echo $html;
        $mpdf->SetJS('this.print();');
		$mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML($this->load->view("TP/warehouse/stock_transfer1_print", $data, TRUE));
        $mpdf->Output();
}
    
function transferstock_print_serial()
{
		$id = $this->uri->segment(3);
		
		$this->load->library('mpdf/mpdf');                
        $mpdf= new mPDF('th','A4','0', 'thsaraban');
		$stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');
		
        $sql = "stot_id = '".$id."'";
		$query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between_serial($sql);
		if($query){
			$data['stock_array'] =  $query;
		}else{
			$data['stock_array'] = array();
		}
    
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between_serial_one($sql);
		if($query){
			$data['serial_array'] =  $query;
		}else{
			$data['serial_array'] = array();
		}
		
		//echo $html;
        $mpdf->SetJS('this.print();');
		$mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML($this->load->view("TP/warehouse/stock_transfer1_print", $data, TRUE));
        $mpdf->Output();
}
    
function checkStock_transfer()
{
    $refcode = $this->input->post("refcode");
    $whid_out = $this->input->post("whid_out");
    
    $sql = "it_refcode = '".$refcode."' and stob_warehouse_id = '".$whid_out."'";
    $result = $this->tp_warehouse_transfer_model->getItem_stock($sql);
    $output = "";
    foreach ($result as $loop) {
        $output .= "<td><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td>";
        
        if ($loop->stob_qty > 0) { 
            $output .= "<td style='width: 120px;'>";
        }else{
            $output .= "<td style='width: 120px;background-color: #F6CECE; font-weight: bold;'>";
        }
        $output .= "<input type='hidden' name='old_qty' id='old_qty' value='".$loop->stob_qty."'>".$loop->stob_qty."</td>";
        $output .= "<td><input type='text' name='it_quantity' id='it_quantity' value='1' style='width: 50px;' onChange='calculate();'></td><td>".$loop->it_uom."</td>";
    }
    echo $output;
}
    
function checkStock_transfer_onlyfashion()
{
    $refcode = $this->input->post("refcode");
    $whid_out = $this->input->post("whid_out");
    
    $sql = "it_refcode = '".$refcode."' and stob_warehouse_id = '".$whid_out."' and it_has_caseback = '0'";
    $result = $this->tp_warehouse_transfer_model->getItem_stock($sql);
    $output = "";
    foreach ($result as $loop) {
        $output .= "<td><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td>";
        
        if ($loop->stob_qty > 0) { 
            $output .= "<td style='width: 120px;'>";
        }else{
            $output .= "<td style='width: 120px;background-color: #F6CECE; font-weight: bold;'>";
        }
        $output .= "<input type='hidden' name='old_qty' id='old_qty' value='".$loop->stob_qty."'>".$loop->stob_qty."</td>";
        $output .= "<td><input type='text' name='it_quantity' id='it_quantity' value='1' style='width: 50px;' onChange='calculate();'></td><td>".$loop->it_uom."</td>";
    }
    echo $output;
}
    
function checkStock_transfer_caseback()
{
    $refcode = $this->input->post("refcode");
    $whid_out = $this->input->post("whid_out");
    
    $sql = "itse_serial_number = '".$refcode."' and itse_enable = 1 and itse_warehouse_id = '".$whid_out."' and ".$this->no_rolex;

    $result = $this->tp_warehouse_transfer_model->getItem_stock_caseback($sql);
    $output = "";
    foreach ($result as $loop) {
        $output .= "<td><input type='hidden' name='itse_id' id='itse_id' value='".$loop->itse_id."'><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td>";
        $output .= "<td><input type='hidden' name='old_qty' id='old_qty' value='".$loop->stob_qty."'><input type='hidden' name='it_quantity' id='it_quantity' value='1'>1</td><td>".$loop->it_uom."</td>";
        $output .= "<td><input type='text' name='it_code' id='it_code' value='".$loop->itse_serial_number."' style='width: 200px;' readonly></td>";
    }
    echo $output;
}
    
function report_transferstock()
{
    $sql = "stot_status = 1 and stot_enable = 1";
    $sql .= " and stot_is_rolex = ".$this->session->userdata('sessrolex');
    $data['transfer_array'] = $this->tp_warehouse_transfer_model->getWarehouse_transfer_list($sql);
    
    $currentdate = date("Y-m");
    
    $currentdate = explode('-', $currentdate);
    $currentmonth = $currentdate[1]."/".$currentdate[0];
    $data['month'] = $currentmonth;
    
    $start = $currentdate[0]."-".$currentdate[1]."-01 00:00:00";
    $end = $currentdate[0]."-".$currentdate[1]."-31 23:59:59";
    
    $sql = "stot_status >= 2 and stot_status <= 3";
    $sql .= " and stot_dateadd >= '".$start."' and stot_dateadd <= '".$end."'";
    $sql .= " and stot_is_rolex = ".$this->session->userdata('sessrolex');
    $data['final_array'] = $this->tp_warehouse_transfer_model->getWarehouse_transfer_list($sql);
    
    $data['title'] = "Nerd - Report Transfer Stock";
    $this->load->view("TP/warehouse/report_transferstock_item", $data);
}
    
function confirm_transfer_between()
{
    $id = $this->uri->segment(3);
    
    $sql = "stot_id = '".$id."'";
    $query = $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between($sql);
    if($query){
        $data['stock_array'] =  $query;
    }else{
        $data['stock_array'] = array();
    }
    
    $data['stot_id'] = $id;
    $data['title'] = "Nerd - Confirm Transfer Stock";
    $this->load->view("TP/warehouse/confirm_transferstock_item", $data);
}
    
function confirm_transfer_between_serial()
{
    $id = $this->uri->segment(3);
    
    $sql = "stot_id = '".$id."'";
    $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between_serial($sql);
    if($query){
        $data['stock_array'] =  $query;
    }else{
        $data['stock_array'] = array();
    }
    
    $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between_serial_one($sql);
    if($query){
        $data['serial_array'] =  $query;
    }else{
        $data['serial_array'] = array();
    }
    
    $data['stot_id'] = $id;
    $data['title'] = "Nerd - Confirm Transfer Stock";
    $this->load->view("TP/warehouse/confirm_transferstock_item_serial", $data);
}
    
function transferstock_save_confirm()
{
    $luxury = $this->uri->segment(3);
    $serial_array = $this->input->post("serial_array");
    $it_array = $this->input->post("item");
    //$it_cancel_array = $this->input->post("cancel_item");
    $stot_id = $this->input->post("stot_id");
    $wh_out_id = $this->input->post("wh_out_id");
    $wh_in_id = $this->input->post("wh_in_id");
    $datein = $this->input->post("datein");
    $stot_remark = $this->input->post("stot_remark");
    
    $currentdate = date("Y-m-d H:i:s");
    
    $stock = array("id" => $stot_id, "stot_status" => 2, "stot_confirm_dateadd" => $currentdate,"stot_confirm_by" => $this->session->userdata('sessid'), "stot_remark" => $stot_remark);
    $query = $this->tp_warehouse_transfer_model->editWarehouse_transfer_between($stock);
    
    
    $count = 0;
    for($i=0; $i<count($it_array); $i++){
        
        // decrease stock warehouse out
        $sql = "stob_item_id = '".$it_array[$i]["item_id"]."' and stob_warehouse_id = '".$wh_out_id."'";
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);
        
        $qty_update = $it_array[$i]["qty_final"];
        
        if (!empty($query)) {
            foreach($query as $loop) {
                $stock_id = $loop->stob_id;

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
        
        // increase stock warehouse in
        $sql = "stob_item_id = '".$it_array[$i]["item_id"]."' and stob_warehouse_id = '".$wh_in_id."'";
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);
        
        if (!empty($query)) {
            foreach($query as $loop) {
                $stock_id = $loop->stob_id;
                
                $qty_new = $loop->stob_qty + $qty_update;
                $stock = array( 'id' => $loop->stob_id,
                                'stob_qty' => $qty_new,
                                'stob_lastupdate' => $currentdate,
                                'stob_lastupdate_by' => $this->session->userdata('sessid')
                            );
                $query = $this->tp_warehouse_transfer_model->editWarehouse_transfer($stock);
                break;
            }
        }else{
            $stock = array( 'stob_qty' => $qty_update,
                            'stob_lastupdate' => $currentdate,
                            'stob_lastupdate_by' => $this->session->userdata('sessid'),
                            'stob_warehouse_id' => $wh_in_id,
                            'stob_item_id' => $it_array[$i]["item_id"]
                     );
            $query = $this->tp_warehouse_transfer_model->addWarehouse_transfer($stock);
            
        }
        
        $stock = array( 'id' => $it_array[$i]["id"],
                            'log_stot_qty_final' => $it_array[$i]["qty_final"]
                        );
            
        $query = $this->tp_log_model->editWarehouse_transfer_between($stock);
            
        $count += $it_array[$i]["qty_final"];
    }
    
    if ($serial_array != "") {
    for($i=0; $i<count($serial_array); $i++){
        $stock = array( 'log_stots_stot_id' => $serial_array[$i]["serial_log_id"],
                        'log_stots_item_serial_id' => $serial_array[$i]["serial_item_id"]
        );

        $query = $this->tp_log_model->addLogStockTransfer_serial($stock);
        $this->load->model('tp_item_model','',TRUE);
        $serial_item = array( 'id' => $serial_array[$i]["serial_item_id"],
                            'itse_warehouse_id' => $wh_in_id
                        );
        $query = $this->tp_item_model->editItemSerial($serial_item);

    } }

    $result = array("a" => $count, "b" => $stot_id);
    echo json_encode($result);
    exit();
}
    
function transferstock_final_print()
{
    $id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');                
    $mpdf= new mPDF('th','A4','0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');

    $sql = "stot_id = '".$id."'";
    $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between($sql);
    if($query){
        $data['stock_array'] =  $query;
    }else{
        $data['stock_array'] = array();
    }

    $sql = "log_stot_transfer_id = '".$id."'";
    $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between_serial_one($sql);
    if($query){
        $data['serial_array'] =  $query;
    }else{
        $data['serial_array'] = array();
    }   

    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/warehouse/stock_transfer2_print", $data, TRUE));
    $mpdf->Output();
}
    
function transferstock_final_excel()
{
    $id = $this->uri->segment(3);

    $sql = "stot_id = '".$id."'";
    $query1 = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between($sql);

    $sql = "log_stot_transfer_id = '".$id."'";
    $query2 = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between_serial_one($sql);
		
    //load our new PHPExcel library
    $this->load->library('excel');
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Transfer');
    
    foreach($query1 as $loop) { $datetime = $loop->stot_datein; $si_id = $loop->stot_number; $editor = $loop->firstname." ".$loop->lastname; $confirm = $loop->confirm_firstname." ".$loop->confirm_lastname; $stock_out = $loop->wh_out_code."-".$loop->wh_out_name; $stock_in = $loop->wh_in_code."-".$loop->wh_in_name; $status = $loop->stot_status; $stock_remark = $loop->stot_remark; $dateadd = $loop->stot_confirm_dateadd; break; } 
    $GGyear=substr($datetime,0,4); 
     $GGmonth=substr($datetime,5,2); 
     $GGdate=substr($datetime,8,2);

    $this->excel->getActiveSheet()->setCellValue('A1', 'ใบส่งของ เลขที่');
    $this->excel->getActiveSheet()->setCellValue('B1', $si_id);

    $this->excel->getActiveSheet()->setCellValue('A2', 'ย้ายคลังจาก');
    $this->excel->getActiveSheet()->setCellValue('B2', $stock_out);
    $this->excel->getActiveSheet()->setCellValue('C2', 'ไปยัง');
    $this->excel->getActiveSheet()->setCellValue('D2', $stock_in);
    
    $this->excel->getActiveSheet()->setCellValue('D1', 'วันที่');
    $this->excel->getActiveSheet()->setCellValue('E1', $GGdate."/".$GGmonth."/".$GGyear);
    
    
    $this->excel->getActiveSheet()->setCellValue('A4', 'No.');
    $this->excel->getActiveSheet()->setCellValue('B4', 'Ref. Number');
    $this->excel->getActiveSheet()->setCellValue('C4', 'รายละเอียดสินค้า');
    $this->excel->getActiveSheet()->setCellValue('D4', 'จำนวน');
    $this->excel->getActiveSheet()->setCellValue('E4', 'หน่วย');
    $this->excel->getActiveSheet()->setCellValue('F4', 'หน่วยละ');
    $this->excel->getActiveSheet()->setCellValue('G4', 'จำนวนเงิน');
    
    $row = 5;
    $no = 1;
    $sum = 0;
    $sum_qty = 0;
    foreach($query1 as $loop) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $no);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->it_refcode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, strtoupper($loop->br_name));
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->qty_final);  
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->it_uom);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->it_srp);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $loop->qty_final*$loop->it_srp);
        $row++;
        $no++;
        $sum += $loop->qty_final*$loop->it_srp; 
        $sum_qty += $loop->qty_final;
    }
    
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, "รวมจำนวน");
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $sum_qty);    
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, "รวมเงิน");
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $sum);
    

    $filename='nerd_transfer.xlsx'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache

    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
}
    
function transferstock_final_print_serial()
{
    // ไม่ได้ใช้
		$id = $this->uri->segment(3);
		
		$this->load->library('mpdf/mpdf');                
        $mpdf= new mPDF('th','A4','0', 'thsaraban');
		$stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');
		
        $sql = "stot_id = '".$id."'";
		$query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between_serial($sql);
		if($query){
			$data['stock_array'] =  $query;
		}else{
			$data['stock_array'] = array();
		}
    
        $sql = "log_stot_id = '".$id."' and log_stots_enable = '1'";
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between_serial_one($sql);
        if($query){
            $data['serial_array'] =  $query;
        }else{
            $data['serial_array'] = array();
        }   
		
		//echo $html;
        $mpdf->SetJS('this.print();');
		$mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML($this->load->view("TP/warehouse/stock_transfer2_print", $data, TRUE));
        $mpdf->Output();
}
    
function disable_transfer_between()
{
    $id = $this->uri->segment(3);
    
    $sql = "stot_id = '".$id."'";
    $query = $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between($sql);
    if($query){
        $data['stock_array'] =  $query;
    }else{
        $data['stock_array'] = array();
    }
    
    $data['stot_id'] = $id;
    $data['title'] = "Nerd - Confirm Transfer Stock";
    $this->load->view("TP/warehouse/disable_transferstock_item", $data);
}
    
function disable_transfer_between_serial()
{
    $id = $this->uri->segment(3);
    
    $sql = "stot_id = '".$id."'";
    $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between_serial($sql);
    if($query){
        $data['stock_array'] =  $query;
    }else{
        $data['stock_array'] = array();
    }

    $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between_serial_one($sql);
    if($query){
        $data['serial_array'] =  $query;
    }else{
        $data['serial_array'] = array();
    }
    
    $data['stot_id'] = $id;
    $data['title'] = "Nerd - Confirm Transfer Stock";
    $this->load->view("TP/warehouse/disable_transferstock_item_serial", $data);
}
    
function transferstock_disable_confirm()
{
    $currentdate = date("Y-m-d H:i:s");
    
    
    $stot_id = $this->input->post("stot_id");
    $stock = array("id" => $stot_id, "stot_status" => 3, "stot_enable" => 0, "stot_confirm_dateadd" => $currentdate,"stot_confirm_by" => $this->session->userdata('sessid'));
    $query = $this->tp_warehouse_transfer_model->editWarehouse_transfer_between($stock);
    
    if ($query) {
        $result = "OK";
    }else{
        $result = "ERROR";
    }
    
    echo json_encode($result);
    exit();
}

function importstock_history()
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
    
    $sql = "";
    $sql .= "stoi_dateadd >= '".$start."' and stoi_dateadd <= '".$end."'";
    if ($this->session->userdata('sessstatus') != '88') {
        $sql .= " and stoi_enable = 1 and stoi_is_rolex = ".$this->session->userdata('sessrolex');
    }
    
    $data['final_array'] = $this->tp_warehouse_transfer_model->getWarehouse_stockin_list($sql);
    
    $currentdate = explode('-', $currentdate);
    $currentdate = $currentdate[1]."/".$currentdate[0];
    $data["currentdate"] = $currentdate;
    $data['month'] = $currentdate;
    
    $data['title'] = "Nerd - Report Transfer In";
    $this->load->view("TP/warehouse/report_stockin_item", $data);
}
    
    
function transferstock_history()
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
    
    $sql = "stot_dateadd >= '".$start."' and stot_dateadd <= '".$end."'";
    if ($this->session->userdata('sessstatus') != '88') {
        $sql .= " and stot_is_rolex = ".$this->session->userdata('sessrolex');
    }
    $data['final_array'] = $this->tp_warehouse_transfer_model->getWarehouse_transfer_list($sql);
    
    $currentdate = explode('-', $currentdate);
    $currentdate = $currentdate[1]."/".$currentdate[0];
    $data["currentdate"] = $currentdate;
    $data['month'] = $currentdate;
    
    $sql = $this->no_rolex;
    $this->load->model('tp_item_model','',TRUE);
    $data['brand_array'] = $this->tp_item_model->getBrand($sql);
    $sql = "wh_enable = '1'";
    $data['whname_array'] = $this->tp_warehouse_model->getWarehouse($sql);
    
    $data['title'] = "Nerd - Report Transfer Stock";
    $this->load->view("TP/warehouse/report_transfer_item", $data);
}
    
function transferstock_history_all()
{
    if ($this->session->userdata('sessstatus') == '88') {
    $currentdate = date("Y-m");
    
    $currentdate = explode('-', $currentdate);
    $currentmonth = $currentdate[1]."/".$currentdate[0];
    $data['month'] = $currentmonth;
    
    $start = $currentdate[0]."-".$currentdate[1]."-01 00:00:00";
    $end = $currentdate[0]."-".$currentdate[1]."-31 23:59:59";
    
    $sql = "stot_dateadd >= '".$start."' and stot_dateadd <= '".$end."'";
    $data['final_array'] = $this->tp_warehouse_transfer_model->getWarehouse_transfer_list($sql);
    
    $data['title'] = "Nerd - Report Transfer Stock";
    $this->load->view("TP/warehouse/report_transfer_item", $data);
    }
}
    
function checkSerial_warehouse()
{
    $serial = $this->input->post("serial");
    $serial_wh_id = $this->input->post("serial_wh_id");
    
    $this->load->model('tp_item_model','',TRUE);
    $number = $this->tp_item_model->checkCaseback_warehouse($serial, $serial_wh_id);
    $result1 = 0;
    $result2 = "";
    $result3 = 0;
    foreach($number as $loop) {
        $result1 = $loop->itse_item_id;
        $result2 = $loop->itse_serial_number;
        $result3 = $loop->itse_id;
    }

    $result = array("a" => $result1, "b" => $result2, "c" => $result3);
    echo json_encode($result);
    exit();
}
    
function result_search_transfer_item()
{
    $refcode = $this->input->post("refcode");
    $brand = $this->input->post("brand");
    $warehouse = $this->input->post("warehouse");

    if ($refcode == "") $refcode = "NULL";
    $data['refcode'] = $refcode;
    
    $brand_array = explode("-", $brand);
    $brand_code = $brand_array[0];
    $brand_name = $brand_array[1];
    $data['brand_id'] = $brand_code;
    $data['brand_name'] = $brand_name;
    
    $wh_array = explode("-", $warehouse);
    $wh_code = $wh_array[0];
    $wh_name = $wh_array[1];
    $data['wh_id'] = $wh_code;
    $data['wh_name'] = $wh_name;

    
    
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

    $data['title'] = "Nerd - Search Stock Transfer";
    $this->load->view('TP/warehouse/result_search_transfer_item',$data);
}
    
function ajaxView_seach_transfer()
{
    $refcode = $this->uri->segment(3);
    $keyword = explode("%20", $refcode);
    $brand = $this->uri->segment(4);
    $warehouse = $this->uri->segment(5);
    $startdate = $this->uri->segment(6);
    $enddate = $this->uri->segment(7);
    
    $sql = "";
    if ($this->session->userdata('sessstatus') != '88') {
        $sql .= $this->no_rolex;
    }else{ $sql .= "br_id != 888"; }
    
    $sql .= " and stot_datein >= '".$startdate."' and stot_datein <= '".$enddate."'";
    
    if (($brand=="0") && ($warehouse=="0")){
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
            
        if ($warehouse!="0") $sql .= " and (stot_warehouse_out_id = '".$warehouse."' or 	stot_warehouse_in_id = '".$warehouse."')";
        else $sql .= " and stot_warehouse_out_id != '0'";

    }
    
    $this->load->library('Datatables');
    $this->datatables
    ->select("stot_datein, CONCAT('/', stot_id, '\">', stot_number, '</a>') as transfer_id, it_refcode, br_name, it_model, it_short_description, it_srp, 	log_stot_qty_final, CONCAT(wh1.wh_code,'-',wh1.wh_name) as wh_in, CONCAT(wh2.wh_code,'-',wh2.wh_name ) as wh_out", FALSE)
    ->from('log_stock_transfer')
    ->join('tp_stock_transfer', 'log_stot_transfer_id = stot_id','left')
    ->join('tp_item', 'it_id = log_stot_item_id','left')
    ->join('tp_brand', 'br_id = it_brand_id','left')
    ->join('tp_warehouse wh1', 'wh1.wh_id = stot_warehouse_out_id','inner')
    ->join('tp_warehouse wh2', 'wh2.wh_id = stot_warehouse_in_id','inner')
    ->where('stot_enable',1)
    ->where('log_stot_qty_final >',0)
    ->where($sql)
    ->edit_column("transfer_id",'<a target="_blank"  href="'.site_url("warehouse_transfer/transferstock_final_print").'$1',"transfer_id");
    echo $this->datatables->generate(); 
}
    
function ajaxView_seach_transfer_serial()
{
    $serial = $this->uri->segment(3);
    $sql = "";
    if ($this->session->userdata('sessstatus') != '88') {
        $sql .= $this->no_rolex;
    }else{ $sql .= "br_id != 888"; }
    
    $sql .= " and itse_serial_number like '".$serial."'";
    
    $this->load->library('Datatables');
    $this->datatables
    ->select("stot_datein, CONCAT('/', stot_id, '\">', stot_number, '</a>') as transfer_id, it_refcode, itse_serial_number,  CONCAT(wh1.wh_code,'-',wh1.wh_name) as wh_in, CONCAT(wh2.wh_code,'-',wh2.wh_name ) as wh_out", FALSE)
    ->from('log_stock_transfer_serial')
    ->join('log_stock_transfer', 'log_stots_stot_id = log_stot_id', 'left')
    ->join('tp_item_serial', 'log_stots_item_serial_id = itse_id', 'left')
    ->join('tp_stock_transfer', 'log_stot_transfer_id = stot_id','left')
    ->join('tp_item', 'it_id = log_stot_item_id','left')
    ->join('tp_brand', 'br_id = it_brand_id','left')
    ->join('tp_warehouse wh1', 'wh1.wh_id = stot_warehouse_out_id','inner')
    ->join('tp_warehouse wh2', 'wh2.wh_id = stot_warehouse_in_id','inner')
    ->where('stot_enable',1)
    ->where('log_stot_qty_final >',0)
    ->where($sql)
    ->edit_column("transfer_id",'<a target="_blank"  href="'.site_url("warehouse_transfer/transferstock_final_print").'$1',"transfer_id");
    echo $this->datatables->generate(); 
}
    
function exportExcel_transfer_report()
{
    $refcode = $this->input->post("refcode");
    $keyword = explode(" ", $refcode);
    $brand = $this->input->post("brand");
    $warehouse = $this->input->post("warehouse");
    $startdate = $this->input->post("startdate");
    $enddate = $this->input->post("enddate");
    
    $sql = "";
    if ($this->session->userdata('sessstatus') != '88') {
        $sql .= $this->no_rolex;
    }else{ $sql .= "br_id != 888"; }
    
    $sql .= " and stot_datein >= '".$startdate."' and stot_datein <= '".$enddate."'";
    
    if (($brand=="0") && ($warehouse=="0")){
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
            
        if ($warehouse!="0") $sql .= " and (stot_warehouse_out_id = '".$warehouse."' or 	stot_warehouse_in_id = '".$warehouse."')";
        else $sql .= " and stot_warehouse_out_id != '0'";

    }
    
    $item_array = $this->tp_warehouse_transfer_model->getItem_transfer($sql);
    
    //load our new PHPExcel library
    $this->load->library('excel');
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Transfer Report');

    $this->excel->getActiveSheet()->setCellValue('A1', 'วันที่ย้าย');
    $this->excel->getActiveSheet()->setCellValue('B1', 'เลขที่ย้ายคลัง');
    $this->excel->getActiveSheet()->setCellValue('C1', 'Ref. Number');
    $this->excel->getActiveSheet()->setCellValue('D1', 'Brand');
    $this->excel->getActiveSheet()->setCellValue('E1', 'Family');
    $this->excel->getActiveSheet()->setCellValue('F1', 'Description');
    $this->excel->getActiveSheet()->setCellValue('G1', 'SRP');
    $this->excel->getActiveSheet()->setCellValue('H1', 'Qty (Pcs.)');
    $this->excel->getActiveSheet()->setCellValue('I1', 'ออกจากคลัง');
    $this->excel->getActiveSheet()->setCellValue('J1', 'เข้าคลัง');
    
    $row = 2;
    foreach($item_array as $loop) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->stot_datein);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->stot_number);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->it_refcode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->br_name);    
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->it_model);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->it_short_description);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $loop->it_srp);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->log_stot_qty_final);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $loop->wh_in);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->wh_out);
        $row++;
    }
    

    $filename='transfer_report.xlsx'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache

    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
}
    
function form_return_headoffice()
{
    $sql = "wh_enable = 1 and (wh_group_id = 3 or wh_group_id = 7)";
	$data['wh_out'] = $this->tp_warehouse_model->getWarehouse($sql);
	$data['currentdate'] = date("d/m/Y");
    
    $sql = "wh_enable = 1 and wh_group_id = 3";
	$data['wh_ho'] = $this->tp_warehouse_model->getWarehouse($sql);
	$data['currentdate'] = date("d/m/Y");

    $data['sessrolex'] = $this->session->userdata('sessrolex');
    $data['remark'] = 0;
    $data['title'] = "Nerd - Return Stock";
    $this->load->view("TP/warehouse/form_return_headoffice", $data);
}
    
function form_return_headoffice_select_item()
{
    $datein = $this->input->post("datein");
    $whid_out = $this->input->post("whid_out");
    $whid_in = $this->input->post("whid_in");
    $watch_luxury = $this->input->post("watch_luxury");
    /*
    if ($this->session->userdata('sessrolex') == 0) $caseback = 0;
    else $caseback = 1;
    */
    $whout_array = explode('#', $whid_out);
    $whname_out = $whout_array[1];
    $whid_out = $whout_array[0];
    
    $whin_array = explode('#', $whid_in);
    $whname_in = $whin_array[1];
    $whid_in = $whin_array[0];

    $data['datein'] = $datein;
    $data['whid_out'] = $whid_out;
    $data['whname_out'] = $whname_out;
    $data['whid_in'] = $whid_in;
    $data['whname_in'] = $whname_in;
    $data['remark'] = $watch_luxury;
    $data['sessrolex'] = $this->session->userdata('sessrolex');
    
    $data['title'] = "Nerd - Return Stock";
    $this->load->view("TP/warehouse/form_return_headoffice_select_item", $data);
}
    
function save_return_headoffice()
{
    $luxury = $this->uri->segment(3);
	$datein = $this->input->post("datein");
	$whid_out = $this->input->post("whid_out");
    $whid_in = $this->input->post("whid_in");
    $it_array = $this->input->post("item");
    $stot_remark = $this->input->post("stot_remark");
    
    $currentdate = date("Y-m-d H:i:s");
    
    $datein = explode('/', $datein);
    $datein = $datein[2]."-".$datein[1]."-".$datein[0];
    
    $count = 0;
    $month = date("Y-m");
    $month_array = explode('-',date("y-m"));
    
    $number = $this->tp_warehouse_transfer_model->getMaxNumber_transfer_between($month, $this->session->userdata('sessrolex'));
    $number++;
    
    if ($this->session->userdata('sessrolex') == 0) {
        $number = "TB".$month_array[0].$month_array[1].str_pad($number, 4, '0', STR_PAD_LEFT);
    }else{
        $number = "TB-Ro".$month_array[0].$month_array[1].str_pad($number, 3, '0', STR_PAD_LEFT);
    }
    
    $stock = array( 'stot_number' => $number,
                    'stot_datein' => $datein,
                    'stot_dateadd' => $currentdate,
                    'stot_warehouse_out_id' => $whid_out,
                    'stot_warehouse_in_id' => $whid_in,
                    'stot_has_serial' => $luxury,
                    'stot_is_rolex' => $this->session->userdata('sessrolex'),
                    'stot_dateadd_by' => $this->session->userdata('sessid'),
                    'stot_remark' => $stot_remark,
                    "stot_status" => 2, 
                    "stot_confirm_dateadd" => $currentdate,
                    "stot_confirm_by" => $this->session->userdata('sessid')
            );
    $last_id = $this->tp_warehouse_transfer_model->addWarehouse_transfer_between($stock);
    
    for($i=0; $i<count($it_array); $i++){
        
        // check item id of serial
        $where = "log_stot_transfer_id = '".$last_id."' and log_stot_item_id = '".$it_array[$i]["id"]."' and log_stot_enable=1";
        $check_item = $this->tp_log_model->getLogStockTransfer($where);
        $count_result = 0;
        foreach($check_item as $loop_check) {
            $count_result++;
            $log_stot_id = $loop_check->log_stot_id;
            $log_qty = $loop_check->log_stot_qty_want;
        }
        if ($count_result > 0) {
            $qty_update = $log_qty + $it_array[$i]["qty"];
            $stock = array('id' => $log_stot_id, 'log_stot_qty_want' => $qty_update, 'log_stot_qty_final' => $qty_update);
            $query = $this->tp_log_model->editWarehouse_transfer_between($stock);
            $last_log_id = $log_stot_id;
        }else{
            $stock = array( 'log_stot_transfer_id' => $last_id,
                            'log_stot_old_qty' => $it_array[$i]["old_qty"],
                            'log_stot_qty_want' => $it_array[$i]["qty"],
                            'log_stot_qty_final' => $it_array[$i]["qty"],
                            'log_stot_item_id' => $it_array[$i]["id"]
            );
            $last_log_id = $this->tp_log_model->addLogStockTransfer($stock);
        }
        $count += $it_array[$i]["qty"];
        
        if ($luxury==1){
            
            $stock = array( 'log_stots_stot_id' => $last_log_id,
                            'log_stots_item_serial_id' => $it_array[$i]["itse_id"]
            );
            $query = $this->tp_log_model->addLogStockTransfer_serial($stock);
            
            $this->load->model('tp_item_model','',TRUE);
            $serial_item = array( 'id' => $it_array[$i]["itse_id"],
                                'itse_warehouse_id' => $whid_in,
                                'itse_dateadd' => $currentdate
                            );
            $query = $this->tp_item_model->editItemSerial($serial_item);
            //$count++;
        }
        
        
        // decrease stock warehouse out
        $sql = "stob_item_id = '".$it_array[$i]["id"]."' and stob_warehouse_id = '".$whid_out."'";
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);
        
        $qty_update = $it_array[$i]["qty"];
        
        if (!empty($query)) {
            foreach($query as $loop) {
                $stock_id = $loop->stob_id;

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
        
        // increase stock warehouse in
        $sql = "stob_item_id = '".$it_array[$i]["id"]."' and stob_warehouse_id = '".$whid_in."'";
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);
        
        if (!empty($query)) {
            foreach($query as $loop) {
                $stock_id = $loop->stob_id;
                
                $qty_new = $loop->stob_qty + $qty_update;
                $stock = array( 'id' => $loop->stob_id,
                                'stob_qty' => $qty_new,
                                'stob_lastupdate' => $currentdate,
                                'stob_lastupdate_by' => $this->session->userdata('sessid')
                            );
                $query = $this->tp_warehouse_transfer_model->editWarehouse_transfer($stock);
                break;
            }
        }else{
            $stock = array( 'stob_qty' => $qty_update,
                            'stob_lastupdate' => $currentdate,
                            'stob_lastupdate_by' => $this->session->userdata('sessid'),
                            'stob_warehouse_id' => $whid_in,
                            'stob_item_id' => $it_array[$i]["id"]
                     );
            $query = $this->tp_warehouse_transfer_model->addWarehouse_transfer($stock);
            
        }
    }

    
    $result = array("a" => $count, "b" => $last_id);
    echo json_encode($result);
    exit();
}
    
function form_replace_branch()
{
    $sql = "wh_enable = 1 and (wh_group_id != 3)";
    $result = $this->tp_warehouse_model->getWarehouse($sql);
	$data['wh_out'] = $result;

	$data['wh_ho'] = $result;
	$data['currentdate'] = date("d/m/Y");

    $data['sessrolex'] = $this->session->userdata('sessrolex');
    $data['remark'] = 0;
    $data['title'] = "Nerd - Replace Stock";
    $this->load->view("TP/warehouse/form_replace_branch", $data);
}
    
function form_replace_branch_select_item()
{
    $datein = $this->input->post("datein");
    $whid_out = $this->input->post("whid_out");
    $whid_in = $this->input->post("whid_in");
    $watch_luxury = $this->input->post("watch_luxury");
    /*
    if ($this->session->userdata('sessrolex') == 0) $caseback = 0;
    else $caseback = 1;
    */
    $whout_array = explode('#', $whid_out);
    $whname_out = $whout_array[1];
    $whid_out = $whout_array[0];
    
    $whin_array = explode('#', $whid_in);
    $whname_in = $whin_array[1];
    $whid_in = $whin_array[0];

    $data['datein'] = $datein;
    $data['whid_out'] = $whid_out;
    $data['whname_out'] = $whname_out;
    $data['whid_in'] = $whid_in;
    $data['whname_in'] = $whname_in;
    $data['remark'] = $watch_luxury;
    $data['sessrolex'] = $this->session->userdata('sessrolex');
    
    $data['title'] = "Nerd - Return Stock";
    $this->load->view("TP/warehouse/form_replace_branch_select_item", $data);
}
    
function save_replace_branch()
{
    $luxury = $this->uri->segment(3);
	$datein = $this->input->post("datein");
	$whid_out = $this->input->post("whid_out");
    $whid_in = $this->input->post("whid_in");
    $it_array = $this->input->post("item");
    $stot_remark = $this->input->post("stot_remark");
    
    $currentdate = date("Y-m-d H:i:s");
    
    $datein = explode('/', $datein);
    $datein = $datein[2]."-".$datein[1]."-".$datein[0];
    
    $count = 0;
    $month = date("Y-m");
    $month_array = explode('-',date("y-m"));
    
    $number = $this->tp_warehouse_transfer_model->getMaxNumber_transfer_between($month, $this->session->userdata('sessrolex'));
    $number++;
    
    if ($this->session->userdata('sessrolex') == 0) {
        $number = "TB".$month_array[0].$month_array[1].str_pad($number, 4, '0', STR_PAD_LEFT);
    }else{
        $number = "TB-Ro".$month_array[0].$month_array[1].str_pad($number, 3, '0', STR_PAD_LEFT);
    }
    
    $stock = array( 'stot_number' => $number,
                    'stot_datein' => $datein,
                    'stot_dateadd' => $currentdate,
                    'stot_warehouse_out_id' => $whid_out,
                    'stot_warehouse_in_id' => $whid_in,
                    'stot_has_serial' => $luxury,
                    'stot_is_rolex' => $this->session->userdata('sessrolex'),
                    'stot_dateadd_by' => $this->session->userdata('sessid'),
                    'stot_remark' => $stot_remark,
                    "stot_status" => 4, 
                    "stot_confirm_dateadd" => $currentdate,
                    "stot_confirm_by" => $this->session->userdata('sessid')
            );
    $last_id = $this->tp_warehouse_transfer_model->addWarehouse_transfer_between($stock);
    
    for($i=0; $i<count($it_array); $i++){
        
        // check item id of serial
        $where = "log_stot_transfer_id = '".$last_id."' and log_stot_item_id = '".$it_array[$i]["id"]."' and log_stot_enable=1";
        $check_item = $this->tp_log_model->getLogStockTransfer($where);
        $count_result = 0;
        foreach($check_item as $loop_check) {
            $count_result++;
            $log_stot_id = $loop_check->log_stot_id;
            $log_qty = $loop_check->log_stot_qty_want;
        }
        if ($count_result > 0) {
            $qty_update = $log_qty + $it_array[$i]["qty"];
            $stock = array('id' => $log_stot_id, 'log_stot_qty_want' => $qty_update, 'log_stot_qty_final' => $qty_update);
            $query = $this->tp_log_model->editWarehouse_transfer_between($stock);
            $last_log_id = $log_stot_id;
        }else{
            $stock = array( 'log_stot_transfer_id' => $last_id,
                            'log_stot_old_qty' => $it_array[$i]["old_qty"],
                            'log_stot_qty_want' => $it_array[$i]["qty"],
                            'log_stot_qty_final' => $it_array[$i]["qty"],
                            'log_stot_item_id' => $it_array[$i]["id"]
            );
            $last_log_id = $this->tp_log_model->addLogStockTransfer($stock);
        }
        $count += $it_array[$i]["qty"];
        
        if ($luxury==1){
            
            $stock = array( 'log_stots_stot_id' => $last_log_id,
                            'log_stots_item_serial_id' => $it_array[$i]["itse_id"]
            );
            $query = $this->tp_log_model->addLogStockTransfer_serial($stock);
            
            $this->load->model('tp_item_model','',TRUE);
            $serial_item = array( 'id' => $it_array[$i]["itse_id"],
                                'itse_warehouse_id' => $whid_in,
                                'itse_dateadd' => $currentdate
                            );
            $query = $this->tp_item_model->editItemSerial($serial_item);
            //$count++;
        }
        
        
        // decrease stock warehouse out
        $sql = "stob_item_id = '".$it_array[$i]["id"]."' and stob_warehouse_id = '".$whid_out."'";
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);
        
        $qty_update = $it_array[$i]["qty"];
        
        if (!empty($query)) {
            foreach($query as $loop) {
                $stock_id = $loop->stob_id;

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
        
        // increase stock warehouse in
        $sql = "stob_item_id = '".$it_array[$i]["id"]."' and stob_warehouse_id = '".$whid_in."'";
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);
        
        if (!empty($query)) {
            foreach($query as $loop) {
                $stock_id = $loop->stob_id;
                
                $qty_new = $loop->stob_qty + $qty_update;
                $stock = array( 'id' => $loop->stob_id,
                                'stob_qty' => $qty_new,
                                'stob_lastupdate' => $currentdate,
                                'stob_lastupdate_by' => $this->session->userdata('sessid')
                            );
                $query = $this->tp_warehouse_transfer_model->editWarehouse_transfer($stock);
                break;
            }
        }else{
            $stock = array( 'stob_qty' => $qty_update,
                            'stob_lastupdate' => $currentdate,
                            'stob_lastupdate_by' => $this->session->userdata('sessid'),
                            'stob_warehouse_id' => $whid_in,
                            'stob_item_id' => $it_array[$i]["id"]
                     );
            $query = $this->tp_warehouse_transfer_model->addWarehouse_transfer($stock);
            
        }
    }

    
    $result = array("a" => $count, "b" => $last_id);
    echo json_encode($result);
    exit();
}
    
function undo_confirm_transfer_between()
{
    $currentdate = date("Y-m-d");
    $last14days = date('Y-m-d', strtotime('-14 days'));
    
    $start = $last14days." 00:00:00";
    $end = $currentdate." 23:59:59";
    
    $sql = "stot_confirm_dateadd >= '".$start."' and stot_confirm_dateadd <= '".$end."' and stot_status='2'";
    if ($this->session->userdata('sessstatus') != '88') {
        $sql .= " and stot_is_rolex = ".$this->session->userdata('sessrolex');
    }
    $data['final_array'] = $this->tp_warehouse_transfer_model->getWarehouse_transfer_list($sql);
    
    $data['title'] = "Nerd - Report Transfer Stock";
    $this->load->view("TP/warehouse/list_undo_transfer_between", $data);
}
    
function save_undo_transfer_between()
{
    $stot_id = $this->input->post("stot_id");
    $currentdate = date("Y-m-d H:i:s");
    
    $stock = array("id" => $stot_id, "stot_status" => 1, "stot_confirm_dateadd" => '0000-00-00 00:00:00',"stot_confirm_by" => 0);
    $query = $this->tp_warehouse_transfer_model->editWarehouse_transfer_between($stock);
    
    $count = 0;
    
    $sql = "stot_id = '".$stot_id."'";
    $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between($sql);
    foreach($query as $loop){
        $wh_out_id = $loop->wh_out_id;
        $wh_in_id = $loop->wh_in_id;
        $item_id = $loop->log_stot_item_id;
        $qty = $loop->qty_final;
        
        // decrease stock warehouse in
        $where2 = "stob_item_id = '".$item_id."' and stob_warehouse_id = '".$wh_in_id."'";
        $query2 = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);
        
        if (!empty($query)) {
            foreach($query as $loop) {
                $stock_id = $loop->stob_id;

                $qty_new = $loop->stob_qty - $qty;
                $stock = array( 'id' => $loop->stob_id,
                                'stob_qty' => $qty_new,
                                'stob_lastupdate' => $currentdate,
                                'stob_lastupdate_by' => $this->session->userdata('sessid')
                            );
                $query = $this->tp_warehouse_transfer_model->editWarehouse_transfer($stock);
                break;
            }
        }
        
        // increase stock warehouse out
        $sql = "stob_item_id = '".$item_id."' and stob_warehouse_id = '".$wh_out_id."'";
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);
        
        if (!empty($query)) {
            foreach($query as $loop) {
                $stock_id = $loop->stob_id;
                
                $qty_new = $loop->stob_qty + $qty;
                $stock = array( 'id' => $loop->stob_id,
                                'stob_qty' => $qty_new,
                                'stob_lastupdate' => $currentdate,
                                'stob_lastupdate_by' => $this->session->userdata('sessid')
                            );
                $query = $this->tp_warehouse_transfer_model->editWarehouse_transfer($stock);
                break;
            }
        }else{
            $stock = array( 'stob_qty' => $qty,
                            'stob_lastupdate' => $currentdate,
                            'stob_lastupdate_by' => $this->session->userdata('sessid'),
                            'stob_warehouse_id' => $wh_out_id,
                            'stob_item_id' => $item_id
                     );
            $query = $this->tp_warehouse_transfer_model->addWarehouse_transfer($stock);
            
        }
            
        $count += $qty;
    }
    
    $sql = "stot_id = '".$stot_id."'";
    $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between_serial_one($sql);
    foreach($query as $loop){
        $itse_id = $loop->log_stots_item_serial_id;
        $log_stots_id = $loop->log_stots_id;
            
        $serial = array( 'id' => $log_stots_id,
                        'log_stots_enable' => 0
        );
        $del_query = $this->tp_log_model->editWarehouse_transfer_between_serial($serial);
            
       

        $query = $this->tp_log_model->addLogStockTransfer_serial($stock);
        $this->load->model('tp_item_model','',TRUE);
        $serial_item = array( 'id' => $serial_array[$i]["serial_item_id"],
                            'itse_warehouse_id' => $wh_in_id
                        );
        $query = $this->tp_item_model->editItemSerial($serial_item);

    }

    $result = array("a" => $count, "b" => $stot_id);
    echo json_encode($result);
    exit();
}
    
function save_undo_transfer_between_serial()
{
    $stot_id = $this->input->post("stot_id");
    
    $sql = "stot_id = '".$stot_id."'";
    $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between_serial($sql);
    if($query){
        $data['stock_array'] =  $query;
    }else{
        $data['stock_array'] = array();
    }

    $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between_serial_one($sql);
    if($query){
        $data['serial_array'] =  $query;
    }else{
        $data['serial_array'] = array();
    }
    
    $data['stot_id'] = $id;
    $data['title'] = "Nerd - Confirm Transfer Stock";
    $this->load->view("TP/warehouse/disable_transferstock_item_serial", $data);
}
    
    
}
?>