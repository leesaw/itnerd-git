<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tp_delivery extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->library('form_validation');
     $this->load->model('tp_delivery_model','',TRUE);
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');

     if ($this->session->userdata('sessrolex') == 0) {
       if ($this->session->userdata('sessstatus') == 2) {
         $this->no_rolex = "br_id > 0";
       }else if ($this->session->userdata('sessstatus') == 1) {
         $this->no_rolex = "br_id > 0";
       }else{
         $this->no_rolex = "br_id != 888";
       }
     }else{
       $this->no_rolex = "br_id = 888";
     }
}

function index()
{

}

function form_confirm_sent()
{
    $data['title'] = "NGG| Nerd - Confirm Delivery";
    $this->load->view("TP/delivery/form_confirm_sent", $data);
}

function check_transfer_number()
{
  $transfer_number = $this->input->post("transfer_number");

  $sql = "stot_number = '".$transfer_number."' and stot_enable = 1 and delivery_status > 0";
  $result = $this->tp_delivery_model->get_transfer_between($sql);
  // not found
  $alert = 0;
  $output = "";
  foreach ($result as $loop) {
    if ($loop->stot_status == 1) {
      $alert = 1;
    }elseif ($loop->stot_status == 3) {
      $alert = 3;
    }elseif ($loop->stot_status == 4) {
      $alert = 4;
    }elseif ($loop->delivery_status == 2) {
      $alert = 2;
    }else{
      $alert = 10;
      $brand_detail = "";
      $count = 0;
      $sql = "log_stot_transfer_id = ".$loop->stot_id;
      $result2 = $this->tp_delivery_model->get_brand_number($sql);
      foreach($result2 as $loop_brand) {
        if ($count>0) $brand_detail .= ", ";
        $brand_detail .= $loop_brand->br_name." <b>(".$loop_brand->qty.")</b>";
        $count += $loop_brand->qty;
      }
      $output .= "<td><input type='hidden' name='stot_id' value='".$loop->stot_id."'>".$loop->stot_number."</td><td>".$brand_detail."</td><td>";
      $output .= $count."</td><td>".$loop->stot_datein."</td><td>".$loop->wh_out_code."-".$loop->wh_out_name."</td><td>".$loop->wh_in_code."-".$loop->wh_in_name."</td>";
    }
    break;
  }

  $result = array("alert" => $alert, "output" => $output);
  echo json_encode($result);
  exit();
}

function save_confirm_sent()
{
  $stot_id = $this->input->post("stot_array");
  $remark = $this->input->post("remark");

  $currentdate = date("Y-m-d H:i:s");

  for($i=0; $i<count($stot_id); $i++) {
    $temp = array( 'id' => $stot_id[$i], 'delivery_status' => 2, 'delivery_dateadd' => $currentdate, 'delivery_remark' => $remark);
    $result = $this->tp_delivery_model->edit_delivery($temp);
  }

  echo 1;
}

function report_delivery()
{
  $datein = $this->input->post("datein");
  if ($datein !="") {
      $month = explode('/',$datein);
      $currentdate = $month[1]."-".$month[0];
  }else{
      $currentdate = date("Y-m");
  }

  // $start = $currentdate."-01 00:00:00";
  // $end = $currentdate."-31 23:59:59";
  $start = $currentdate."-01";
  $end = $currentdate."-31";

  $sql = "stot_datein >= '".$start."' and stot_datein <= '".$end."' and delivery_status > 0 and stot_status = 2";
  if ($this->session->userdata('sessstatus') != '88') {
      $sql .= " and stot_is_rolex = ".$this->session->userdata('sessrolex');
  }

  $final_array = array();
  $index = 0;
  $query = $this->tp_delivery_model->get_transfer_between($sql);
  foreach ($query as $loop) {
      $where_brand = "log_stot_transfer_id = '".$loop->stot_id."'";
      $query_brand = $this->tp_delivery_model->get_brand_number($where_brand);
      $brand_string = "";
      $count = 0;
      foreach ($query_brand as $loop_brand) {
          if ($count>0) $brand_string .= ", ";
          $brand_string .= $loop_brand->br_name." <b>(".$loop_brand->qty.")</b>";
          $count++;
      }

      $final_array[$index] = array("stot_number" => $loop->stot_number, "stot_datein" => $loop->stot_datein, "wh_out" => $loop->wh_out_code."-".$loop->wh_out_name, "wh_in" =>$loop->wh_in_code."-".$loop->wh_in_name, "name" => $loop->firstname." ".$loop->lastname,
       "delivery_status" => $loop->delivery_status, "delivery_remark" => $loop->delivery_remark, "stot_id" => $loop->stot_id, "stot_has_serial" => $loop->stot_has_serial, "brand" => $brand_string);
      $index++;
  }

  $data["final_array"] = $final_array;
  $currentdate = explode('-', $currentdate);
  $currentdate = $currentdate[1]."/".$currentdate[0];
  $data["currentdate"] = $currentdate;
  $data['month'] = $currentdate;

  $sql = $this->no_rolex;
  $this->load->model('tp_item_model','',TRUE);
  $data['brand_array'] = $this->tp_item_model->getBrand($sql);
  $sql = "";
  $this->load->model('tp_warehouse_model','',TRUE);
  $data['whname_array'] = $this->tp_warehouse_model->getWarehouse($sql);

  $data['title'] = "Nerd - Delivery Report";
  $this->load->view("TP/delivery/report_delivery", $data);
}

}
?>
