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
    $sql_result .= " and itse_enable = '1'";
    $query = $this->tp_warehouse_transfer_model->getItem_stock_caseback($sql_result);
    if($query){
        $data['serial_array'] =  $query;
    }else{
        $data['serial_array'] = array();
    }
    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/shop/stock_rolex_print", $data, TRUE));
    $mpdf->Output();
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

    $sql = "posrobi_pos_rolex_borrow_id = '".$id."'";
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
    
}
?>