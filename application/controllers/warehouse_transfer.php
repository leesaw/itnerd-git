<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warehouse_transfer extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->model('tp_warehouse_model','',TRUE);
     $this->load->model('tp_warehouse_transfer_model','',TRUE);
     $this->load->model('tp_log_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function importstock() 
{
	$sql = "";
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

    $data['remark'] = $remark;
    $data['title'] = "Nerd - Transfer In";
    $this->load->view("TP/warehouse/addstock_view", $data);
}
    
function transferstock() 
{
	$sql = "";
	$data['wh_array'] = $this->tp_warehouse_model->getWarehouse($sql);
	$data['currentdate'] = date("d/m/Y");

    $data['title'] = "Nerd - Transfer Stock";
    $this->load->view("TP/warehouse/transferstock_view", $data);
}
    
function importstock_history()
{
    $data['title'] = "Nerd - Transfer In History";
    $this->load->view("TP/warehouse/stockin_history", $data);
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
    
function importstock_save()
{
    $luxury = $this->uri->segment(3);
	$datein = $this->input->post("datein");
	$wh_id = $this->input->post("whid");
    $it_array = $this->input->post("item");
    
    $currentdate = date("Y-m-d H:i:s");
    
    $datein = explode('/', $datein);
    $datein = $datein[2]."-".$datein[1]."-".$datein[0];
    
    $count = 0;
    $month = date("Y-m");
    $month_array = explode('-',date("y-m"));
    
    $number = $this->tp_warehouse_transfer_model->getMaxNumber_transfer_in($month);
    $number++;
    $number = "TR".$month_array[0].$month_array[1].str_pad($number, 4, '0', STR_PAD_LEFT);
    
    $stock = array( 'stoi_number' => $number,
                    'stoi_datein' => $datein,
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
        
        $stock = array( 'log_stob_stock_in_id' => $last_id,
                        'log_stob_status' => 'I',
                        'log_stob_warehouse_id' => $wh_id,
                        'log_stob_qty_update' => $it_array[$i]["qty"],
                        'log_stob_old_qty' => $old_qty,
                        'log_stob_item_id' => $it_array[$i]["id"],
                        'log_stob_stock_balance_id' => $stock_id
        );
        $query = $this->tp_log_model->addLogStockBalance($stock);
        $count += $it_array[$i]["qty"];
        
        if ($luxury == 1) {
            $itcode = array("itse_serial_number" => $it_array[$i]["code"], "itse_item_id" => $it_array[$i]["id"], "itse_dateadd" => $currentdate);
            
            $this->load->model('tp_item_model','',TRUE);
            $query = $this->tp_item_model->addItemCode($itcode);
        }
    }
    $result = array("a" => $count, "b" => $last_id);
    echo json_encode($result);
    exit();
}
    
function transferstock_select_item()
{
    $datein = $this->input->post("datein");
    $whid_out = $this->input->post("whid_out");
    $whid_in = $this->input->post("whid_in");
    $caseback = $this->input->post("caseback");
    
    $whout_array = explode('#', $whid_out);
    $whname_out = $whout_array[1];
    $whid_out = $whout_array[0];
    
    $whin_array = explode('#', $whid_in);
    $whname_in = $whin_array[1];
    $whid_in = $whin_array[0];
    
    if ($caseback==0) $caseback_label = "<label class='text-green'> No Caseback</label>";
    else $caseback_label = "<label class='text-red'> Caseback</label>";
    
    $data['datein'] = $datein;
    $data['whid_out'] = $whid_out;
    $data['whname_out'] = $whname_out;
    $data['whid_in'] = $whid_in;
    $data['whname_in'] = $whname_in;
    $data['remark'] = $caseback;
    $data['caseback_label'] = $caseback_label;
    
    $data['title'] = "Nerd - Transfer Stock";
    $this->load->view("TP/warehouse/transferstock_select_item", $data);
}
    
function transferstock_save()
{
    $luxury = $this->uri->segment(3);
	$datein = $this->input->post("datein");
	$wh_id = $this->input->post("whid");
    $it_array = $this->input->post("item");
    
    $currentdate = date("Y-m-d H:i:s");
    
    $datein = explode('/', $datein);
    $datein = $datein[2]."-".$datein[1]."-".$datein[0];
    
    $count = 0;
    $month = date("Y-m");
    $month_array = explode('-',date("y-m"));
    
    $number = $this->tp_warehouse_transfer_model->getMaxNumber_transfer_in($month);
    $number++;
    $number = "TB".$month_array[0].$month_array[1].str_pad($number, 4, '0', STR_PAD_LEFT);
    
    $stock = array( 'stoi_number' => $number,
                    'stoi_datein' => $datein,
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
        
        $stock = array( 'log_stob_stock_in_id' => $last_id,
                        'log_stob_status' => 'I',
                        'log_stob_warehouse_id' => $wh_id,
                        'log_stob_qty_update' => $it_array[$i]["qty"],
                        'log_stob_old_qty' => $old_qty,
                        'log_stob_item_id' => $it_array[$i]["id"],
                        'log_stob_stock_balance_id' => $stock_id
        );
        $query = $this->tp_log_model->addLogStockBalance($stock);
        $count += $it_array[$i]["qty"];
        
        if ($luxury == 1) {
            $itcode = array("itse_serial_number" => $it_array[$i]["code"], "itse_item_id" => $it_array[$i]["id"], "itse_dateadd" => $currentdate);
            
            $this->load->model('tp_item_model','',TRUE);
            $query = $this->tp_item_model->addItemCode($itcode);
        }
    }
    $result = array("a" => $count, "b" => $last_id);
    echo json_encode($result);
    exit();
}
    
}
?>