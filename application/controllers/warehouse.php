<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warehouse extends CI_Controller {

public $no_rolex = "";
    
function __construct()
{
     parent::__construct();
     $this->load->model('tp_warehouse_model','',TRUE);
     $this->load->model('tp_warehouse_transfer_model','',TRUE);
     $this->load->model('tp_log_model','',TRUE);
     $this->load->model('tp_item_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
    
     if ($this->session->userdata('sessrolex') == 0) $this->no_rolex = "br_id != 888";
     else $this->no_rolex = "br_id = 888";
}

function index()
{
    
}
    
function getBalance()
{   
    $sql = $this->no_rolex;
    $data['brand_array'] = $this->tp_item_model->getBrand($sql);
    $sql = "";
    $data['whname_array'] = $this->tp_warehouse_model->getWarehouse($sql);

    $data['title'] = "NGG| Nerd - Search Stock";
    $this->load->view('TP/warehouse/search_stock',$data);
}
    
function showBalance()
{
    $refcode = $this->input->post("refcode");
    $brand = $this->input->post("brand");
    $warehouse = $this->input->post("warehouse");
    $minprice = $this->input->post("minprice");
    $maxprice = $this->input->post("maxprice");
    $sql = $this->no_rolex;
    
    if (($brand=="0") && ($warehouse=="0") && ($minprice=="") && ($maxprice=="")){
        if ($refcode!="") {
            $keyword = explode(" ",$refcode);
            if (count($keyword) < 2) { 
                $sql .= " and (it_short_description like '%".$refcode."%' or it_refcode like '%".$refcode."%')";
            }else{
                for($i=0; $i<count($keyword); $i++) {
                    $sql .= " and (it_short_description like '%".$keyword[$i]."%' or it_refcode like '%".$keyword[$i]."%')";
                }
            }
        }
    }else {
        if ($refcode!="") {
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
            
        if ($warehouse!="0") $sql .= " and wh_id = '".$warehouse."'";
        else $sql .= " and wh_id != '0'";

        if (($minprice !="") && ($minprice>=0)) $sql .= " and it_srp >= '".$minprice."'";
        else $sql .= " and it_srp >=0";
            
        if (($maxprice !="") && ($maxprice>=0)) $sql .= "it_srp <= '".$maxprice."'";
        else $sql .= " and it_srp >=0";
    }
    $data['stock_array'] = $this->tp_warehouse_model->getWarehouse_balance($sql);
    
    $data['refcode'] = $refcode;
    $data['brand'] = $brand;
    $data['warehouse'] = $warehouse;
    $data['minprice'] = $minprice;
    $data['maxprice'] = $maxprice;

    $data['title'] = "NGG| Nerd - Ref Code";
    $this->load->view('TP/warehouse/show_stock',$data);
}
    
function view_serial()
{
    $stob_id = $this->uri->segment(3);
    $sql = "stob_id = '".$stob_id."'";
    $data['serial_array'] = $this->tp_item_model->getCaseback_stock($sql);
    
    $data['title'] = "NGG| Nerd - Caseback";
    $this->load->view('TP/item/show_serial',$data);
}

}
?>