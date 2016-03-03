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
    
}
?>