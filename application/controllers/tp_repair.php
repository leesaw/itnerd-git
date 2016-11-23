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

     $this->no_rolex = "br_id > 0";
     $this->shop_rolex = "sh_id > 0";
    //  if ($this->session->userdata('sessrolex') == 0) {
    //      $this->no_rolex = "br_id != 888";
    //      $this->shop_rolex = "sh_id != 888";
    //  }else{
    //      $this->no_rolex = "br_id = 888";
    //      $this->shop_rolex = "sh_id = 888";
    //  }
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
    $customer = $this->input->post("customer");
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
                    'rep_customer' => $customer,
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

    $sql = "rep_enable = '1' and rep_status != 'R'";
    $query = $this->tp_repair_model->get_summary_status($sql);
    $data['summary_array'] = $query;

    $data['title'] = "NGG| Nerd - Repair List";
    $this->load->view("TP/repair/form_list_repair", $data);
}

function result_list_repair()
{
    if ($this->input->post("number") != "")
        $data['number'] = str_replace("/","_",$this->input->post("number"));
    else
        $data['number'] = "NULL";

    $data['number_show'] = $this->input->post("number");

    if ($this->input->post("refcode") != "")
        $data['refcode'] = $this->input->post("refcode");
    else
        $data['refcode'] = "NULL";

    if ($this->input->post("month") != "") {
        $data['month'] = $this->input->post("month");
        $month = explode('/',$this->input->post("month"));
        $data['month_ajax'] = $month[1]."-".$month[0];
    }
    else {
        $data['month'] = "";
        $data['month_ajax'] = "NULL";
    }

    if ($this->input->post("month_cs") != "") {
        $data['month_cs'] = $this->input->post("month_cs");
        $month = explode('/',$this->input->post("month_cs"));
        $data['month_cs_ajax'] = $month[1]."-".$month[0];
    }
    else {
        $data['month_cs'] = "";
        $data['month_cs_ajax'] = "NULL";
    }

    if ($this->input->post("month_return") != "") {
        $data['month_return'] = $this->input->post("month_return");
        $month = explode('/',$this->input->post("month_return"));
        $data['month_return_ajax'] = $month[1]."-".$month[0];
    }
    else {
        $data['month_return'] = "";
        $data['month_return_ajax'] = "NULL";
    }

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
    $number = str_replace("_","/",$number);
    $refcode = $this->uri->segment(4);
    $brandid = $this->uri->segment(5);
    $shopid = $this->uri->segment(6);
    $status = $this->uri->segment(7);
    $month = $this->uri->segment(8);
    $month_cs = $this->uri->segment(9);
    $month_return = $this->uri->segment(10);

    $where = "";
    $where .= "rep_enable = 1";

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

    if ($month != "NULL") {
        $start_date = $month."-01 00:00:00";
        $end_date = $month."-31 23:59:59";
        $where .= " and rep_datein >= '".$start_date."' and rep_datein <= '".$end_date."'";
    }

    if ($month_cs != "NULL") {
        $start_date = $month_cs."-01 00:00:00";
        $end_date = $month_cs."-31 23:59:59";
        $where .= " and rep_datecs >= '".$start_date."' and rep_datecs <= '".$end_date."'";
    }

    if ($month_return != "NULL") {
        $start_date = $month_return."-01 00:00:00";
        $end_date = $month_return."-31 23:59:59";
        $where .= " and rep_datereturn >= '".$start_date."' and rep_datereturn <= '".$end_date."'";
    }


    $this->load->library('Datatables');
    $this->datatables
    ->select("rep_datein, rep_number, rep_refcode, IF(rep_brand_id = 99999 , 'อื่น ๆ', br_name) as br_name, (CASE WHEN rep_shop_id = 99999 THEN 'อื่น ๆ' WHEN rep_shop_id = 1 THEN 'Head Office นราธิวาสราชนครินทร์' ELSE sh1.sh_name END) as shopname, CONCAT(rep_cusname,' ', rep_custelephone), IF(rep_customer = 1 , 'ลูกค้า', 'สต็อก') as customer, rep_case,
        (CASE WHEN rep_warranty = '1' THEN 'หมดประกัน' WHEN rep_warranty = '2' THEN 'อยู่ในประกัน' ELSE '-' END)
    , rep_price,
    (CASE
        WHEN rep_status = 'G' THEN '<button class=\'btn btn-danger btn-xs\'>รับเข้าซ่อม</button>'
        WHEN rep_status = 'A' THEN '<button class=\'btn btn-warning btn-xs\'>ประเมินการซ่อมแล้ว</button>'
        WHEN rep_status = 'D'THEN '<button class=\'btn btn-primary btn-xs\'>ซ่อมเสร็จ</button>'
        WHEN rep_status = 'C'THEN '<button class=\'btn bg-purple btn-xs\'>ซ่อมไม่ได้</button>'
        WHEN rep_status = 'R' THEN IF(rep_repairable=1, IF(rep_customer_repair=1, '<button class=\'btn btn-success btn-xs\'>ส่งกลับแล้ว<br>[ซ่อมแล้ว]</button>', '<button class=\'btn bg-orange btn-xs\'>ส่งกลับแล้ว<br>[ไม่ได้ซ่อม]</button>' ), '<button class=\'btn bg-maroon btn-xs\'>ส่งกลับแล้ว<br>[ซ่อมไม่ได้]</button>')
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
    $customer = $this->input->post("customer");
    $remark = $this->input->post("remark");
    $warranty = $this->input->post("warranty");
    if($warranty != 1 && $warranty !=2) $warranty = 0;
    $price = $this->input->post("price");
    $response = $this->input->post("response");
    $rep_id = $this->input->post("rep_id");

    $repairable = 0;
    if ($status == 'D') $repairable = 1;
    if ($status == 'C') $repairable = 2;

    $datedone_array = explode('/', $datedone);
    $datedone = $datedone_array[2]."-".$datedone_array[1]."-".$datedone_array[0];

    $currentdate = date("Y-m-d H:i:s");

    $repair = array( 'rep_id' => $rep_id,
                    'rep_remark' => $remark,
                    'rep_repairable' => $repairable,
                    'rep_customer_repair' => $customer,
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
    $customer = $this->input->post("customer");
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
                    'rep_customer' => $customer,
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

function exportExcel_repair_report()
{
    $number = $this->input->post("excel_number");
    $number = str_replace("_","/",$number);
    $refcode = $this->input->post("excel_refcode");
    $brandid = $this->input->post("excel_brandid");
    $shopid = $this->input->post("excel_shopid");
    $status = $this->input->post("excel_status");
    $month = $this->input->post("excel_month");
    $month_cs = $this->input->post("excel_month_cs");
    $month_return = $this->input->post("excel_month_return");

    $where = "";
    $where .= "rep_enable = 1";

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

    if ($month != "NULL") {
        $start_date = $month."-01 00:00:00";
        $end_date = $month."-31 23:59:59";
        $where .= " and rep_datein >= '".$start_date."' and rep_datein <= '".$end_date."'";
    }

    if ($month_cs != "NULL") {
        $start_date = $month_cs."-01 00:00:00";
        $end_date = $month_cs."-31 23:59:59";
        $where .= " and rep_datecs >= '".$start_date."' and rep_datecs <= '".$end_date."'";
    }

    if ($month_return != "NULL") {
        $start_date = $month_return."-01 00:00:00";
        $end_date = $month_return."-31 23:59:59";
        $where .= " and rep_datereturn >= '".$start_date."' and rep_datereturn <= '".$end_date."'";
    }

    $item_array = $this->tp_repair_model->get_repair($where);

    //load our new PHPExcel library
    $this->load->library('excel');
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Repair Report');

    $this->excel->getActiveSheet()->setCellValue('A1', "วันที่ส่งซ่อม");
    $this->excel->getActiveSheet()->setCellValue('B1', 'เลขที่ใบรับ');
    $this->excel->getActiveSheet()->setCellValue('C1', 'Ref. Number');
    $this->excel->getActiveSheet()->setCellValue('D1', 'ยี่ห้อ');
    $this->excel->getActiveSheet()->setCellValue('E1', 'สาขาที่ส่งซ่อม');
    $this->excel->getActiveSheet()->setCellValue('F1', 'รายละเอียดลูกค้า');
    $this->excel->getActiveSheet()->setCellValue('G1', 'ที่มา');
    $this->excel->getActiveSheet()->setCellValue('H1', 'อาการ');
    $this->excel->getActiveSheet()->setCellValue('I1', 'ประกัน');
    $this->excel->getActiveSheet()->setCellValue('J1', 'ราคาซ่อม');
    $this->excel->getActiveSheet()->setCellValue('K1', 'สถานะ');

    $row = 2;
    foreach($item_array as $loop) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->rep_datein);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->rep_number);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->rep_refcode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->br_name);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->shopin_name);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->rep_cusname." ".$loop->rep_custelephone);

        if ($loop->rep_customer == 1) $customer = "ลูกค้า"; else if ($loop->rep_customer == 0) $customer = "สต็อก";
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $customer);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->rep_case);

        if ($loop->rep_warranty == '1') $rep_warranty = "หมดประกัน";
        else if ($loop->rep_warranty == '2') $rep_warranty = "อยู่ในประกัน";
        else $rep_warranty = "-";

        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $rep_warranty);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->rep_price);

        switch ($loop->rep_status) {
            case 'G' : $rep_status = "รับเข้าซ่อม"; break;
            case 'A' : $rep_status = "ประเมินการซ่อมแล้ว"; break;
            case 'D' : $rep_status = "ซ่อมเสร็จ"; break;
            case 'C' : $rep_status = "ซ่อมไม่ได้"; break;
            case 'R' : $rep_status = "ส่งกลับแล้ว";
                      if ($loop->rep_repairable == 1) {
                        if($loop->rep_customer_repair == 1) {
                          $rep_status .= " [ซ่อมแล้ว]";
                        }else{
                          $rep_status .= " [ไม่ได้ซ่อม]";
                        }
                      }else{
                        $rep_status .= " [ซ่อมไม่ได้]";
                      }
        }

        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $rep_status);
        $row++;
    }


    $filename='repair_report.xlsx'; //save our workbook as this file name
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
