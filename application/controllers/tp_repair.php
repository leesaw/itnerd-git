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
    $case = $this->input->post("case");
    $remark = $this->input->post("remark");
    
    $currentdate = date("Y-m-d H:i:s");
    
    $datein_array = explode('/', $datein);
    $datein = $datein_array[2]."-".$datein_array[1]."-".$datein_array[0];
    $datecs_array = explode('/', $datecs);
    $datecs = $datecs_array[2]."-".$datecs_array[1]."-".$datecs_array[0];
    
    $repair = array( 'rep_datein' => $datein,
                    'rep_cusname' => $cusname,
                    'rep_custelephone' => $custelephone,
                    'rep_datecs' => $datecs,
                    'rep_number' => $number,
                    'rep_shop_id' => $shopid,
                    'rep_brand_id' => $brandid,
                    'rep_getfrom' => $getfrom,
                    'rep_refcode' => $refcode,
                    'rep_case' => $case,
                    'rep_remark' => $remark,
                    'rep_enable' => 1,
                    'rep_dateadd' => $currentdate,
                    'rep_status' => 'G',
                    'rep_dateaddby' => $this->session->userdata('sessid')
            );
    
    $last_id = $this->tp_repair_model->add_repair($repair);
    
    $tmp_array = array("rep_id" => $last_id);
    $log_result = $this->tp_repair_model->add_log_repair($tmp_array);

    $result = array("b" => $last_id);
    echo json_encode($result);
    exit();
}
    
function view_repair()
{
    $id = $this->uri->segment(3);
    
    $where = "rep_id = '".$id."'";
    $data['repair_array'] = $this->tp_repair_model->get_repair($where);
    
    $data['title'] = "Nerd | View Repair";
    $this->load->view('TP/repair/view_repair',$data);
}
    
function form_list_repair()
{
    $sql = $this->shop_rolex;
    $sql .= " and sh_category_id = 1";
	$data['shop_array'] = $this->tp_shop_model->getShop($sql);
    
    $this->load->model('tp_item_model','',TRUE);
    $sql = "br_enable = 1 and ".$this->no_rolex;
    $query = $this->tp_item_model->getBrand($sql);
	if($query){
		$data['brand_array'] =  $query;
	}else{
		$data['brand_array'] = array();
	}

    $data['title'] = "NGG| Nerd - Repair List";
    $this->load->view("TP/repair/form_list_repair", $data);
}
    
function result_list_repair()
{
    $data['number'] = $this->input->post("number");
    $data['refcode'] = $this->input->post("refcode");
    $data['brandid'] = $this->input->post("brandid");
    $data['shopid'] = $this->input->post("shopid");
    $data['status'] = $this->input->post("status");
    
    $sql = $this->shop_rolex;
    $sql .= " and sh_category_id = 1";
	$data['shop_array'] = $this->tp_shop_model->getShop($sql);
    
    $this->load->model('tp_item_model','',TRUE);
    $sql = "br_enable = 1 and ".$this->no_rolex;
    $query = $this->tp_item_model->getBrand($sql);
	if($query){
		$data['brand_array'] =  $query;
	}else{
		$data['brand_array'] = array();
	}

    $data['title'] = "NGG| Nerd - Repair List";
    $this->load->view("TP/repair/result_list_repair", $data);
    
}
    
function ajaxView_seach_repair()
{
    $number = $this->uri->segment(3);
    $refcode = $this->uri->segment(4);
    $brandid = $this->uri->segment(5);
    $shopid = $this->uri->segment(6);
    
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

}
?>