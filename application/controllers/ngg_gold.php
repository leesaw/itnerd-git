<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ngg_gold extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->library('form_validation');
     $this->load->model('ngg_gold_model','',TRUE);
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function main()
{
    $data['sessstatus'] = $this->session->userdata('sessstatus');
    $this->load->model('tp_shop_model','',TRUE);
    
    $where = "sh_id = '".$this->session->userdata('sessshopid')."'";
    $data['shop_array'] = $this->tp_shop_model->getShop($where);
    $data['title'] = "NGG| Nerd";
    $this->load->view('NGG/gold/main',$data);
}
    
function changepass()
{
    $this->load->helper(array('form'));

    $data['id'] = $this->session->userdata('sessid');

    $data['title'] = "NGG| Nerd - Change Password";
    $this->load->view('NGG/gold/changepass_view',$data);
}

function updatepass()
{
    $this->load->library('form_validation');
    $this->load->model('user','',TRUE);

    $this->form_validation->set_rules('opassword', 'old password', 'trim|xss_clean|required|md5');
    $this->form_validation->set_rules('npassword', 'new password', 'trim|xss_clean|required|md5');
    $this->form_validation->set_rules('passconf', 'Password confirmation', 'trim|xss_clean|required|matches[npassword]');
    $this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
    $this->form_validation->set_message('matches', 'กรุณาใส่รหัสให้ตรงกัน');
    $this->form_validation->set_error_delimiters('<code>', '</code>');

    if($this->form_validation->run() == TRUE) {
        $newpass= ($this->input->post('npassword'));
        $oldpass= ($this->input->post('opassword'));
        $id= ($this->input->post('id'));

        if ($this->user->checkpass($id,$oldpass)) {

            $user = array(
                'id' => $id,
                'password' => $newpass
            );

            $result = $this->user->editUser($user);
            if ($result)
                $this->session->set_flashdata('showresult', 'success');
            else
                $this->session->set_flashdata('showresult', 'fail');

        }else{
            $this->session->set_flashdata('showresult', 'failpass');
        }
        redirect(current_url());
    }
        $data['id'] = $this->session->userdata('sessid');
        $data['title'] = "NGG| Nerd - Change Password";
        $this->load->view('NGG/gold/changepass_view',$data);
}
    
function form_warranty()
{
    $this->load->model('tp_shop_model','',TRUE);
    $where = "sh_id = '".$this->session->userdata('sessshopid')."'";
    $data['shop_array'] = $this->tp_shop_model->getShop($where);
	$data['datein'] = date("d/m/Y");
    
    $data['title'] = "NGG| Nerd - Create Warranty Card";
    $this->load->view('NGG/gold/form_warranty',$data);
}
    
function save_warranty()
{
    $datein = $this->input->post("datein");
    $cusname = $this->input->post("cusname");
    $cusaddress = $this->input->post("cusaddress");
    $custelephone = $this->input->post("custelephone");
    $product = $this->input->post("product");
    $kindgold = $this->input->post("kindgold");
    $payment = $this->input->post("payment");
    $code = $this->input->post("code");
    $weight = $this->input->post("weight");
    $price = $this->input->post("price");
    $jewelry = $this->input->post("jewelry");
    $model = $this->input->post("model");
    $datestart = $this->input->post("datestart");
    $old = $this->input->post("old");
    $goldbuy = $this->input->post("goldbuy");
    $goldsell = $this->input->post("goldsell");
    $shop_id = $this->input->post("shop_id");
    $saleperson_code = $this->input->post("saleperson_code");
    $remark = $this->input->post("remark");
    
    $currentdate = date("Y-m-d H:i:s");
    
    $datein = explode('/', $datein);
    $datein = $datein[2]."-".$datein[1]."-".$datein[0];
    $datestart = explode('/', $datestart);
    $datestart = $datestart[2]."-".$datestart[1]."-".$datestart[0];
    
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
    
function view_warranty()
{
    $id = $this->uri->segment(3);

    $sql = "ngw_id = '".$id."'";
    $query = $this->ngg_gold_model->get_warranty($sql);
    if($query){
        $data['warranty_array'] =  $query;
    }else{
        $data['warranty_array'] = array();
    }
    
    $data['ngw_id'] = $id;
    $data['title'] = "NGG| Nerd - View Warranty Card";
    $this->load->view('NGG/gold/view_warranty',$data);
}
    
function print_warranty()
{
    $id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th','A5-L','0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/style_A5_gold_warranty.css');
    $mpdf->SetWatermarkImage(base_url()."dist/img/watermark-ngg.png", 0.1, array(100,33), array(55,70));
    $mpdf->showWatermarkImage = true;

    $sql = "ngw_id = '".$id."'";
    $query = $this->ngg_gold_model->get_warranty($sql);
    if($query){
        $data['warranty_array'] =  $query;
    }else{
        $data['warranty_array'] = array();
    }

    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("NGG/gold/print_warranty", $data, TRUE));
    $mpdf->Output();
}
    
function check_telephone()
{
    $telephone = str_replace("/","", $this->input->post("telephone"));
    $where = "ngw_customertelephone like '%".$telephone."%'";
    $query = $this->ngg_gold_model->get_warranty($where);
    $name = "";
    $address = "";
    foreach($query as $loop) {
        $name = $loop->ngw_customername;
        $address = $loop->ngw_customeraddress;
    }
    
    $result = array("a" => $name, "b" => $address);
    echo json_encode($result);
}
    
function list_warranty_today()
{
    $currentdate = date("Y-m-d");
    //$currentdate = "2016-05-26";
    $start = $currentdate." 00:00:00";
    $end = $currentdate." 23:59:59";
    
    $this->load->model('tp_shop_model','',TRUE);
    $sql = "ngw_dateadd >= '".$start."' and ngw_dateadd <= '".$end."' and ngw_shop_id = '".$this->session->userdata('sessshopid')."'";
    $query = $this->ngg_gold_model->get_warranty($sql);
    if($query){
        $data['pos_array'] =  $query;
    }else{
        $data['pos_array'] = array();
    }
    
    $where = "sh_id = '".$this->session->userdata('sessshopid')."'";
    $data['shop_array'] = $this->tp_shop_model->getShop($where);
    
    $currentdate = explode('-', $currentdate);
    $currentdate = $currentdate[2]."/".$currentdate[1]."/".$currentdate[0];
    $data["currentdate"] = $currentdate;
    $data['title'] = "NGG| Nerd - Warranty Card List";
    $this->load->view("NGG/gold/list_warranty_today", $data);
}
    
function void_warranty()
{
    $id = $this->uri->segment(3);
    
    $currentdate = date("Y-m-d H:i:s");
    
    $sql = "ngw_id = '".$id."'";
    $query = $this->ngg_gold_model->get_warranty($sql);
    foreach($query as $loop) {
        $remark = $loop->ngw_remark;
        $shop_id = $loop->ngw_shop_id;
        
        $cusname = $loop->ngw_customername; 
        $cusaddress = $loop->ngw_customeraddress;
        $custelephone = $loop->ngw_customertelephone;
        $shopname = $loop->sh_name;
        $shoptelephone = $loop->sh_telephone;
        $number = $loop->ngw_number;
        $product = $loop->ngw_product;
        $kindgold = $loop->ngw_kindgold;
        $price = $loop->ngw_price;
        $payment = $loop->ngw_payment;
        $code = $loop->ngw_code;
        $weight = $loop->ngw_weight;
        $jewelry = $loop->ngw_jewelry;
        $datestart = $loop->ngw_datestart;
        $old = $loop->ngw_old;
        $model = $loop->ngw_model;
        $goldbuy = $loop->ngw_goldbuy;
        $goldsell = $loop->ngw_goldsell;
        $issuedate = $loop->ngw_issuedate;
        $salebarcode = $loop->sp_barcode;
        $saleperson_code = $loop->ngw_saleperson_id;
        $datein = $loop->ngw_issuedate;
    }
    $remark .= "##VOID##".$this->input->post("remarkvoid");
    $pos = array("id" => $id, "ngw_status" => 'V', "ngw_remark" => $remark
                );
    $query = $this->ngg_gold_model->edit_warranty($pos);
    
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
                    'ngw_status' => 'V',
                    'ngw_dateaddby' => $this->session->userdata('sessid')
            );
    $query = $this->ngg_gold_model->add_log_warranty($warranty);
		
    redirect('ngg_gold/view_warranty/'.$id, 'refresh');
}
    
function list_warranty_filter()
{
    $currentdate = date("Y-m");
    $currentdate = explode('-', $currentdate);
    $currentmonth = $currentdate[1]."/".$currentdate[0];
    $data['month'] = $currentmonth;
    
    $start = $currentdate[0]."-".$currentdate[1]."-01 00:00:00";
    $end = $currentdate[0]."-".$currentdate[1]."-31 23:59:59";
    
    $sql = "ngw_dateadd >= '".$start."' and ngw_dateadd <= '".$end."'";
    $data['warranty_array'] = $this->ngg_gold_model->get_warranty($sql);
    $data['count_warranty'] = $this->ngg_gold_model->count_warranty($sql);
    
    $this->load->model('tp_shop_model','',TRUE);
    $where = "sh_id = '".$this->session->userdata('sessshopid')."'";
    $data['shop_array'] = $this->tp_shop_model->getShop($where);
    
    $data["startdate"] = $currentdate[0]."-".$currentdate[1]."-01";
    $data["enddate"] = $currentdate[0]."-".$currentdate[1]."-31";
    $data["start_form"] = "";
    $data["end_form"] = "";
    $data["search"] = 0;
    
    $data['title'] = "NGG| Nerd - Warranty Card List";
    $this->load->view("NGG/gold/list_warranty_month", $data);
}
    
function result_warranty_filter()
{
    $data['month'] = "";
        
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
    
    $sql = "ngw_dateadd >= '".$start."' and ngw_dateadd <= '".$end."'";
    $data['count_warranty'] = $this->ngg_gold_model->count_warranty($sql);
    
    $this->load->model('tp_shop_model','',TRUE);
    $where = "sh_id = '".$this->session->userdata('sessshopid')."'";
    $data['shop_array'] = $this->tp_shop_model->getShop($where);
    
    $data["start_form"] = $this->input->post("startdate");
    $data["end_form"] = $this->input->post("enddate");
    
    $data["search"] = 1;
    
    $data['title'] = "NGG| Nerd - Warranty Card List";
    $this->load->view("NGG/gold/list_warranty_month", $data);
}
    
function ajaxViewWarranty()
{
    $startdate = $this->uri->segment(3);
    $enddate = $this->uri->segment(4);
    
    $start = $startdate." 00:00:00";
    $end = $enddate." 23:59:59";
    
    $sql = "ngw_dateadd >= '".$start."' and ngw_dateadd <= '".$end."'";
    
    $this->load->library('Datatables');
    $this->datatables
    ->select("IF(ngw_status = 'V', CONCAT(ngw_number, ' <button class=\"btn btn-danger btn-xs\">ยกเลิก</button>'), ngw_number) as column1, ngw_product, ngw_kindgold, ngw_weight, ngw_price, ngw_customername, ngw_customertelephone, CONCAT(sp_firstname, ' ', sp_lastname) as salename, sh_name, ngw_id", FALSE)
    ->from("ngg_gold_warranty")
    ->join("tp_shop", "sh_id = ngw_shop_id", "left")
    ->join("nerd_users", "id = ngw_dateaddby", "left")
    ->join("tp_sale_person", "sp_id = ngw_saleperson_id", "left")
    ->where("ngw_enable", 1)
    ->where($sql)
    ->edit_column("ngw_id",'<a href="'.site_url("ngg_gold/view_warranty").'/$1"'.' class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-search"></span></a>',"ngw_id");
    echo $this->datatables->generate(); 
}
    
}
?>