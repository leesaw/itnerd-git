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
    $tmp_array = array_merge($tmp_array,$repair);
    $log_result = $this->tp_repair_model->add_log_repair($tmp_array);

    $result = array("b" => $last_id);
    echo json_encode($result);
    exit();
}
    
function view_repair()
{
    $id = $this->uri->segment(3);
    
    $sql = $this->shop_rolex;
    $sql .= " and sh_category_id = 1";
	$data['shop_array'] = $this->tp_shop_model->getShop($sql);
    
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
    if ($this->input->post("number") != "")
        $data['number'] = $this->input->post("number");
    else
        $data['number'] = "NULL";
    if ($this->input->post("refcode") != "")
        $data['refcode'] = $this->input->post("refcode");
    else
        $data['refcode'] = "NULL";
    
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
    $status = $this->uri->segment(7);
    
    $where = "";
    if ($this->session->userdata('sessstatus') != '88') {
        $where .= $this->no_rolex;
    }else{ $where .= "br_id != 888"; }
    
    if ($number != "NULL") {
        $where .= " and rep_number like '".$number."'";
    }
    if ($refcode != "NULL") {
        $where .= " and rep_refcode like '".$refcode."'";
    }
    
    if ($brandid > 0) {
        $where .= " and rep_brand_id = '".$brandid."'";
    }
    if ($shopid > 0) {
        $where .= " and rep_shop_id = '".$shopid."'";
    }
    if ($status != '0') {
        $where .= " and rep_status = '".$status."'";
    }
    
    $where .= " and rep_enable = 1";
    
    $this->load->library('Datatables');
    $this->datatables
    ->select("rep_datein, rep_number, rep_refcode, br_name, sh1.sh_name as shopname, CONCAT(rep_cusname,' ', rep_custelephone), rep_case, 
    (CASE 
        WHEN rep_status = 'G' THEN '<button class=\'btn btn-danger btn-xs\'>รับเข้าซ่อม</button>'
        WHEN rep_status = 'A' THEN '<button class=\'btn btn-warning btn-xs\'>ประเมินการซ่อมแล้ว</button>'
        WHEN rep_status = 'D'THEN '<button class=\'btn btn-primary btn-xs\'>ซ่อมเสร็จ</button>'
        WHEN rep_status = 'C'THEN '<button class=\'btn bg-purple btn-xs\'>ซ่อมไม่ได้</button>'
        WHEN rep_status = 'R' THEN '<button class=\'btn btn-success btn-xs\'>ส่งกลับแล้ว</button>'
        ELSE 1
    END) AS status, rep_id", FALSE)
    ->from('tp_repair')
	->join('tp_shop sh1', 'rep_shop_id = sh1.sh_id','left')
    ->join('tp_shop sh2', 'rep_return_shop_id = sh2.sh_id','left')
    ->join('tp_brand', 'rep_brand_id = br_id','left')
    ->join('nerd_users', 'rep_dateaddby = id','left')	
    ->where($where)
    ->edit_column("rep_id",'<a href="'.site_url("tp_repair/view_repair"."/$1").'" class="btn btn-primary btn-xs" target="_blank" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-search"></span></a>',"rep_id");
    echo $this->datatables->generate(); 
}
    
function save_fix_status()
{
    $assess = $this->input->post("assess");
    $warranty = $this->input->post("warranty");
    if($warranty != 1 && $warranty !=2) $warranty = 0;
    $price = $this->input->post("price");
    $response = $this->input->post("response");
    $rep_id = $this->input->post("rep_id");
    
    $currentdate = date("Y-m-d H:i:s");
    $dateassess = date("Y-m-d");
    
    $repair = array( 'rep_id' => $rep_id,
                    'rep_assess' => $assess,
                    'rep_warranty' => $warranty,
                    'rep_price' => $price,
                    'rep_responsename' => $response,
                    'rep_dateassess' => $dateassess,
                    'rep_dateadd' => $currentdate,
                    'rep_status' => 'A',
                    'rep_dateaddby' => $this->session->userdata('sessid')
            );
    
    $last_id = $this->tp_repair_model->edit_repair($repair);
    
    $tmp_array = array("rep_enable" => 1);
    $tmp_array = array_merge($tmp_array,$repair);
    $log_result = $this->tp_repair_model->add_log_repair($tmp_array);

    $result = array("b" => $last_id);
    echo json_encode($result);
    exit();
}

function save_done_status()
{
    $datedone = $this->input->post("datedone");
    $status = $this->input->post("status");
    $remark = $this->input->post("remark");
    $warranty = $this->input->post("warranty");
    if($warranty != 1 && $warranty !=2) $warranty = 0;
    $price = $this->input->post("price");
    $response = $this->input->post("response");
    $rep_id = $this->input->post("rep_id");
    
    
    $datedone_array = explode('/', $datedone);
    $datedone = $datedone_array[2]."-".$datedone_array[1]."-".$datedone_array[0];
    
    $currentdate = date("Y-m-d H:i:s");
    
    $repair = array( 'rep_id' => $rep_id,
                    'rep_remark' => $remark,
                    'rep_warranty' => $warranty,
                    'rep_price' => $price,
                    'rep_responsename' => $response,
                    'rep_datedone' => $datedone,
                    'rep_dateadd' => $currentdate,
                    'rep_status' => $status,
                    'rep_dateaddby' => $this->session->userdata('sessid')
            );
    
    $last_id = $this->tp_repair_model->edit_repair($repair);
    
    $tmp_array = array("rep_enable" => 1);
    $tmp_array = array_merge($tmp_array,$repair);
    $log_result = $this->tp_repair_model->add_log_repair($tmp_array);

    $result = array("b" => $last_id);
    echo json_encode($result);
    exit();
}
    
function save_return_status()
{
    $returndate = $this->input->post("returndate");
    $shop_return = $this->input->post("shop_return");
    $remark = $this->input->post("remark");
    $rep_id = $this->input->post("rep_id");
    
    
    $returndate_array = explode('/', $returndate);
    $returndate = $returndate_array[2]."-".$returndate_array[1]."-".$returndate_array[0];
    
    $currentdate = date("Y-m-d H:i:s");
    
    $repair = array( 'rep_id' => $rep_id,
                    'rep_remark' => $remark,
                    'rep_return_shop_id' => $shop_return,
                    'rep_datereturn' => $returndate,
                    'rep_dateadd' => $currentdate,
                    'rep_status' => 'R',
                    'rep_dateaddby' => $this->session->userdata('sessid')
            );
    
    $last_id = $this->tp_repair_model->edit_repair($repair);
    
    $tmp_array = array("rep_enable" => 1);
    $tmp_array = array_merge($tmp_array,$repair);
    $log_result = $this->tp_repair_model->add_log_repair($tmp_array);

    $result = array("b" => $last_id);
    echo json_encode($result);
    exit();
}
    
function disable_repair()
{
    $rep_id = $this->input->post("rep_id");
    $currentdate = date("Y-m-d H:i:s");
    
    $repair = array( 'rep_id' => $rep_id,
                    'rep_enable' => 0,
                    'rep_dateadd' => $currentdate,
                    'rep_dateaddby' => $this->session->userdata('sessid')
            );
    
    $last_id = $this->tp_repair_model->edit_repair($repair);

    $log_result = $this->tp_repair_model->add_log_repair($repair);

    $result = array("b" => $last_id);
    echo json_encode($result);
    exit();
}
    
function form_edit_repair()
{
    $id = $this->uri->segment(3);
    
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
    
    $where = "rep_id = '".$id."'";
    $data['repair_array'] = $this->tp_repair_model->get_repair($where);
    
    $data['title'] = "Nerd | View Repair";
    $this->load->view('TP/repair/form_edit_repair',$data);
}
    
function edit_repair()
{
    $rep_id = $this->input->post("rep_id");

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
    
    $repair = array( 'rep_id' => $rep_id, 
                    'rep_datein' => $datein,
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
                    'rep_dateadd' => $currentdate,
                    'rep_dateaddby' => $this->session->userdata('sessid')
            );
    
    $last_id = $this->tp_repair_model->edit_repair($repair);

    $log_result = $this->tp_repair_model->add_log_repair($repair);

    $result = array("b" => $rep_id);
    echo json_encode($result);
    exit();
}
    
}
?>