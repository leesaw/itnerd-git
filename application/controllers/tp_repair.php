<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tp_repair extends CI_Controller {

public $no_rolex = "";
public $shop_rolex = "";
    
function __construct()
{
     parent::__construct();
     $this->load->model('tp_repair_model','',TRUE);
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
 
function form_new_repair()
{
    $sql = $this->shop_rolex;
    $sql .= " and sh_category_id = 1";
	$data['shop_array'] = $this->tp_shop_model->getShop($sql);
	$data['currentdate'] = date("d/m/Y");
    
    $this->load->model('tp_item_model','',TRUE);
    $sql = "br_enable = 1 and ".$this->no_rolex;
    $query = $this->tp_item_model->getBrand($sql);
	if($query){
		$data['brand_array'] =  $query;
	}else{
		$data['brand_array'] = array();
	}
    
    $data['title'] = "Nerd | New Repair";
    $this->load->view('TP/repair/form_new_repair',$data);
}
    
function save_repair()
{
    $datein = $this->input->post("datein");
    $cusname = $this->input->post("cusname");
    $custelephone = $this->input->post("custelephone");
    $datecs = $this->input->post("datecs");
    $shopid = $this->input->post("shopid");
    $number = $this->input->post("number");
    $getfrom = $this->input->post("getfrom");
    $refcode = $this->input->post("refcode");
    $brandid = $this->input->post("brandid");
    $case = $this->input->post("case1");
    
    $currentdate = date("Y-m-d H:i:s");
    
    $datein_array = explode('/', $datein);
    $datein = $datein_array[2]."-".$datein_array[1]."-".$datein_array[0];
    $datecs_array = explode('/', $datecs);
    $datecs = $datecs_array[2]."-".$datecs_array[1]."-".$datecs_array[0];
    
    $day = date("Y-m-d");
    $month_array = explode('-',date("y-m-d"));
    
    $number = $this->ngg_gold_model->get_Maxnumber_warranty($day, $shop_id);
    $number++;
    
    $number = $month_array[0].$month_array[1].$month_array[2].str_pad($number, 5, '0', STR_PAD_LEFT);
    
    $warranty = array( 'ngw_number' => $number,
                    'ngw_product' => $product,
                    'ngw_kindgold' => $kindgold,
                    'ngw_price' => $price,
                    'ngw_payment' => $payment,
                    'ngw_code' => $code,
                    'ngw_weight' => $weight,
                    'ngw_jewelry' => $jewelry,
                    'ngw_datestart' => $datestart,
                    'ngw_old' => $old,
                    'ngw_model' => $model,
                    'ngw_goldbuy' => $goldbuy,
                    'ngw_goldsell' => $goldsell,
                    'ngw_customername' => $cusname,
                    'ngw_customertelephone' => $custelephone,
                    'ngw_customeraddress' => $cusaddress,
                    'ngw_saleperson_id' => $saleperson_code,
                    'ngw_issuedate' => $datein,
                    'ngw_shop_id' => $shop_id,
                    'ngw_dateadd' => $currentdate,
                    'ngw_remark' => $remark,
                    'ngw_enable' => 1,
                    'ngw_status' => 'N',
                    'ngw_dateaddby' => $this->session->userdata('sessid')
            );
    
    $last_id = $this->ngg_gold_model->add_warranty($warranty);
    $log_result = $this->ngg_gold_model->add_log_warranty($warranty);
    
    $result = array("b" => $last_id);
    echo json_encode($result);
    exit();
}
    

}
?>