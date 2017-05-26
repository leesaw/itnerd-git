<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tp_stock_return extends CI_Controller {

public $no_rolex = "";

function __construct()
{
  parent::__construct();
  $this->load->model('tp_saleorder_model','',TRUE);
  $this->load->model('tp_stock_return_model','',TRUE);
  $this->load->model('tp_log_model','',TRUE);
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

function form_return_request()
{

  $data['currentdate'] = date("d/m/Y");

  $data['sessrolex'] = $this->session->userdata('sessrolex');
  $data['remark'] = 0;
  $data['title'] = "Nerd - Return Request";
  $this->load->view("TP/warehouse/form_return_request", $data);
}

function check_so_number()
{
  $so_number = $this->input->post("so_number");

  $sql = "so_enable = 1 and so_status = 'N' and so_number = '".$so_number."' and wh_enable = 1 and wh_group_id = 3";
  $result = $this->tp_stock_return_model->get_saleorder_warehouse($sql);
  $output = 0;
  foreach ($result as $loop) {
    $output = $loop->so_id;
  }
  echo $output;
}

function return_request_select_item()
{
  $so_id = $this->input->post("so_id");
  $so_number = $this->input->post("so_number");
  $datein = $this->input->post("datein");

  $sql = "sos_saleorder_id = '".$so_id."'";
  $query = $this->tp_saleorder_model->getSaleSerial($sql);
  $serial = 0;
  foreach($query as $loop){
    $serial++;
    break;
  }

  $sql = "so_id = ".$so_id;
  $result = $this->tp_stock_return_model->get_saleorder_warehouse($sql);
  foreach($result as $loop) {
    $warehouse = $loop->wh_code." - ".$loop->wh_name;
  }

  $data['serial'] = $serial;
  $data['so_number'] = $so_number;
  $data['so_id'] = $so_id;
  $data['datein'] = $datein;
  $data['warehouse_name'] = $warehouse;
  $data['title'] = "Nerd - Return Request";
  $this->load->view("TP/warehouse/return_request_select_item", $data);
}

function check_refcode_so_id()
{
    $refcode = $this->input->post("refcode");
    $so_id = $this->input->post("so_id");

    $sql = "it_refcode = '".$refcode."' and so_enable = 1 and so_status = 'N' and so_id = ".$so_id;
    $result = $this->tp_stock_return_model->getItem_sale_refcode($sql);
    $output = "";
    foreach ($result as $loop) {
        $output .= "<td><input type='hidden' name='it_id' id='it_id' value='".$loop->soi_item_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td>";

        if ($loop->soi_qty > 0) {
            $output .= "<td style='width: 120px;'>";
        }else{
            $output .= "<td style='width: 120px;background-color: #F6CECE; font-weight: bold;'>";
        }
        $output .= "<input type='hidden' name='old_qty' id='old_qty' value='".$loop->soi_qty."'>".$loop->soi_qty."</td>";
        $output .= "<td><input type='text' name='it_quantity' id='it_quantity' value='1' style='width: 50px;'></td><td>".$loop->it_uom."</td>";
    }
    echo $output;
}

function check_caseback_so_id()
{
  $refcode = $this->input->post("refcode");
  $so_id = $this->input->post("so_id");

  $sql = "itse_serial_number = '".$refcode."' and itse_enable = 0 and so_enable = 1 and so_status = 'N' and so_id = ".$so_id;

  $result = $this->tp_stock_return_model->getItem_sale_caseback($sql);
  $output = "";
  foreach ($result as $loop) {
      $output .= "<td><input type='hidden' name='itse_id' id='itse_id' value='".$loop->itse_id."'><input type='hidden' name='it_id' id='it_id' value='".$loop->sos_item_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td>";
      $output .= "<td><input type='hidden' name='old_qty' id='old_qty' value='".$loop->soi_qty."'><input type='hidden' name='it_quantity' id='it_quantity' value='1'>1</td><td>".$loop->it_uom."</td>";
      $output .= "<td><input type='text' name='it_code' id='it_code' value='".$loop->itse_serial_number;
      $output .= "' style='width: 200px;' readonly></td>";
  }
  echo $output;
}

function save_return_request()
{
  $luxury = $this->input->post("serial");
  $datein = $this->input->post("datein");
  $so_id = $this->input->post("so_id");
  $it_array = $this->input->post("item_array");
  $remark = $this->input->post("remark");

  $currentdate = date("Y-m-d H:i:s");

  $datein = explode('/', $datein);
  $datein = $datein[2]."-".$datein[1]."-".$datein[0];

  $count = 0;
  $month = date("Y-m");
  $month_array = explode('-',date("y-m"));

  $number = $this->tp_stock_return_model->getMaxNumber_return_request($month);
  $number++;

  $number = "RR".$month_array[0].$month_array[1].str_pad($number, 4, '0', STR_PAD_LEFT);

  $stock = array( 'stor_number' => $number,
                  'stor_so_id' => $so_id,
                  'stor_issue' => $datein,
                  'stor_has_serial' => $luxury,
                  'stor_dateadd' => $currentdate,
                  'stor_remark' => $remark,
                  'stor_status' => 1,
                  'stor_dateadd_by' => $this->session->userdata('sessid')
          );

  $last_id = $this->tp_stock_return_model->add_stock_return($stock);

  for($i=0; $i<count($it_array); $i++){

      // $sql = "stob_item_id = '".$it_array[$i]["id"]."' and stob_warehouse_id = '".$wh_id."'";
      // $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);
      // if (!empty($query)) {
      //     foreach($query as $loop) {
      //         $stock_id = $loop->stob_id;
      //         $qty_new = $loop->stob_qty + $it_array[$i]["qty"];
      //         $stock = array( 'id' => $loop->stob_id,
      //                         'stob_qty' => $qty_new,
      //                         'stob_lastupdate' => $currentdate,
      //                         'stob_lastupdate_by' => $this->session->userdata('sessid')
      //                     );
      //         $query = $this->tp_warehouse_transfer_model->editWarehouse_transfer($stock);
      //         break;
      //     }
      //     $old_qty = $loop->stob_qty;
      // }else{
      //     $stock = array( 'stob_qty' => $it_array[$i]["qty"],
      //                     'stob_lastupdate' => $currentdate,
      //                     'stob_lastupdate_by' => $this->session->userdata('sessid'),
      //                     'stob_warehouse_id' => $wh_id,
      //                     'stob_item_id' => $it_array[$i]["id"]
      //              );
      //     $query = $this->tp_warehouse_transfer_model->addWarehouse_transfer($stock);
      //     $stock_id = $this->db->insert_id();
      //     $old_qty = 0;
      //
      // }

      $stock = array( 'log_stor_stor_id' => $last_id,
                      'log_stor_status' => 'R',
                      'log_stor_qty_update' => $it_array[$i]["qty"],
                      'log_stor_old_qty' => $it_array[$i]["old_qty"],
                      'log_stor_item_id' => $it_array[$i]["id"],

      );
      $log_stob_id = $this->tp_stock_return_model->add_log_stock_return($stock);
      $count += $it_array[$i]["qty"];

      if ($luxury == 1) {
          // $itcode = array("itse_serial_number" => $it_array[$i]["code"], "itse_item_id" => $it_array[$i]["id"], "itse_dateadd" => $currentdate);
          //
          // $this->load->model('tp_item_model','',TRUE);
          // $serial_id = $this->tp_item_model->addItemCode($itcode);

          $itcode = array("log_stors_stor_id" => $log_stob_id, "log_stors_item_serial_id" => $it_array[$i]["itse_id"]);
          $query = $this->tp_stock_return_model->add_log_serial_stock_return($itcode);
      }
  }

  $result = array("a" => $count, "b" => $last_id);
  //$result = array("a" => 1, "b" => 2);
  echo json_encode($result);
  exit();
}

function print_return_request()
{
  $id = $this->uri->segment(3);

  $this->load->library('mpdf/mpdf');
  $mpdf= new mPDF('th','A4','0', 'thsaraban');
  $stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');

  $sql = "stor_id = '".$id."'";
  $query = $this->tp_stock_return_model->get_return_item($sql);
  if($query){
      $data['request_array'] =  $query;
  }else{
      $data['request_array'] = array();
  }

  $sql = "stor_id = '".$id."'";
  $query = $this->tp_stock_return_model->get_return_serial($sql);
  if($query){
      $data['serial_array'] =  $query;
  }else{
      $data['serial_array'] = array();
  }

  //echo $html;
  $mpdf->SetJS('this.print();');
  $mpdf->WriteHTML($stylesheet,1);
  $mpdf->WriteHTML($this->load->view("TP/warehouse/print_return_request", $data, TRUE));
  $mpdf->Output();
}

function report_return_request()
{
  $sql = "stor_status = 1 and stor_enable = 1";

  $final_array = array();
  $index = 0;
  $query = $this->tp_stock_return_model->get_return_request($sql);

  $data['request_array'] = $query;

  $data['title'] = "Nerd - Return Request List";
  $this->load->view("TP/warehouse/list_return_request", $data);
}

function confirm_return_request()
{
  $id = $this->uri->segment(3);

  $sql = "stor_id = '".$id."'";
  $query = $query = $this->tp_stock_return_model->get_return_item($sql);
  if($query){
      $data['stock_array'] =  $query;
  }else{
      $data['stock_array'] = array();
  }

  foreach($query as $loop) {
    $so_id = $loop->so_id;
    break;
  }

  $sql = "so_id = ".$so_id;
  $query = $this->tp_stock_return_model->get_sale_item_sum($sql);
  if($query){
      $data['so_array'] =  $query;
  }else{
      $data['so_array'] = array();
  }

  $sql = "wh_enable = 1 and (wh_group_id = 3)";
  $this->load->model('tp_warehouse_model','',TRUE);
  $result = $this->tp_warehouse_model->getWarehouse($sql);
  $data['wh_array'] = $result;

  $data['stor_id'] = $id;
  $data['title'] = "Nerd - Confirm Return Request";
  $this->load->view("TP/warehouse/confirm_return_request", $data);
}

function check_return_item_list()
{
  $stor_id = $this->input->post("stor_id");
  $refcode = $this->input->post("refcode");
  $result1 = 0;
  $result2 = "";
  $result3 = 0;

  $sql = "stor_id = ".$stor_id;
  $query = $this->tp_stock_return_model->get_return_request($sql);
  foreach($query as $loop) {
    $luxury = $loop->stor_has_serial;
    break;
  }

  if ($luxury == 0) {
    $sql = "stor_id = ".$stor_id." and it_refcode = '".$refcode."'";
    $query = $this->tp_stock_return_model->get_return_item($sql);
    foreach($query as $loop) {
      $result1 = $loop->log_stor_item_id;
      $result2 = $loop->it_refcode;
      $result3 = $loop->qty_update;
    }
  }else{
    $sql = "stor_id = ".$stor_id." and itse_serial_number = '".$refcode."'";
    $query = $this->tp_stock_return_model->get_return_serial($sql);
    foreach($query as $loop) {
      $result1 = $loop->log_stor_item_id;
      $result2 = $loop->itse_serial_number;
      $result3 = $loop->itse_id;
    }
  }

  $result = array("a" => $result1, "b" => $result2, "c" => $result3, "luxury" => $luxury);
  echo json_encode($result);
  exit();
}

function save_return_confirm()
{
  $serial_array = $this->input->post("serial_array");
  $it_array = $this->input->post("item");
  //$it_cancel_array = $this->input->post("cancel_item");
  $stor_id = $this->input->post("stor_id");
  $luxury = $this->input->post("luxury");
  $whid = $this->input->post("whid");
  $datein = $this->input->post("datein");
  $datein = explode("/", $datein);
  $datein = $datein[2]."-".$datein[1]."-".$datein[0];
  $stor_remark = $this->input->post("stor_remark");

  $currentdate = date("Y-m-d H:i:s");

  $count = 0;

  $sql = "stor_id = ".$stor_id;
  $query = $this->tp_stock_return_model->get_return_request($sql);
  foreach($query as $loop){
    $so_id = $loop->stor_so_id;
    break;
  }

  $stock = array("id" => $stor_id, "stor_status" => 2, "stor_confirm_dateadd" => $currentdate, "stor_confirm_by" => $this->session->userdata('sessid'), "stor_remark" => $stor_remark, "stor_issue" => $datein, "stor_warehouse_id" => $whid);
  $query = $this->tp_stock_return_model->edit_stock_return($stock);

  for($i=0; $i<count($it_array); $i++){

      // increase stock warehouse out
      $sql = "stob_item_id = '".$it_array[$i]["item_id"]."' and stob_warehouse_id = '".$whid."'";
      $this->load->model('tp_warehouse_transfer_model','',TRUE);
      $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);

      $qty_update = $it_array[$i]["qty_final"];

      if (!empty($query)) {
          foreach($query as $loop) {
              $stock_id = $loop->stob_id;

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

      $stock = array( 'id' => $it_array[$i]["id"],
                      'log_stor_qty_final' => $it_array[$i]["qty_final"],
                      'log_stor_stock_balance_id' => $stock_id,
                      );

      $query = $this->tp_stock_return_model->edit_log_stock_return($stock);

      $count += $it_array[$i]["qty_final"];

      if ($luxury == 0) {
        $this->load->model('tp_saleorder_model','',TRUE);
        $sql = "soi_saleorder_id = ".$so_id." and soi_item_id = ".$it_array[$i]["item_id"];
        $query = $this->tp_saleorder_model->getSaleItem($sql);
        foreach($query as $loop) {
          $old_qty = $loop->soi_qty;
          $soi_id = $loop->soi_id;
          if ($old_qty > 0) break;
        }


        $soi_update = $old_qty - $it_array[$i]["qty_final"];
        $saleitem = array("id" => $soi_id, "soi_qty" => $soi_update, "soi_remark" => "Return");

        $query = $this->tp_saleorder_model->editSaleItem($saleitem);
      }

  }

  if ($serial_array != "") {
  for($i=0; $i<count($serial_array); $i++){

      $this->load->model('tp_item_model','',TRUE);
      $serial_item = array( 'id' => $serial_array[$i]["serial_item_id"],
                          'itse_warehouse_id' => $whid,
                          'itse_enable' => 1,
                      );
      $query = $this->tp_item_model->editItemSerial($serial_item);

      $this->load->model('tp_saleorder_model','',TRUE);
      $sql = "sos_saleorder_id = ".$so_id." and sos_item_serial_id = ".$serial_array[$i]["serial_item_id"];
      $query = $this->tp_saleorder_model->getSaleItemSerial($sql);

      foreach($query as $loop) {
        $old_qty = $loop->soi_qty;
        $soi_id = $loop->sos_soi_id;
        if ($old_qty > 0) break;
        break;
      }

      $soi_update = $old_qty - 1;
      $saleitem = array("id" => $soi_id, "soi_qty" => $soi_update, "soi_remark" => "Return");

      $query = $this->tp_saleorder_model->editSaleItem($saleitem);

  } }

  $result = array("a" => $count, "b" => $stor_id);
  echo json_encode($result);
  exit();
}

function print_return_confirm()
{
  $id = $this->uri->segment(3);

  $this->load->library('mpdf/mpdf');
  $mpdf= new mPDF('th','A4','0', 'thsaraban');
  $stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');

  $sql = "stor_id = '".$id."'";
  $query = $this->tp_stock_return_model->get_return_request($sql);
  if($query){
      $data['detail_array'] =  $query;
  }else{
      $data['detail_array'] = array();
  }

  $sql = "stor_id = '".$id."'";
  $query = $this->tp_stock_return_model->get_return_item($sql);
  if($query){
      $data['request_array'] =  $query;
  }else{
      $data['request_array'] = array();
  }

  $sql = "stor_id = '".$id."'";
  $query = $this->tp_stock_return_model->get_return_serial($sql);
  if($query){
      $data['serial_array'] =  $query;
  }else{
      $data['serial_array'] = array();
  }

  //echo $html;
  $mpdf->SetJS('this.print();');
  $mpdf->WriteHTML($stylesheet,1);
  $mpdf->WriteHTML($this->load->view("TP/warehouse/print_return_confirm", $data, TRUE));
  $mpdf->Output();
}

function list_return()
{
  $datein = $this->input->post("datein");
  if ($datein !="") {
      $month = explode('/',$datein);
      $currentdate = $month[1]."-".$month[0];
  }else{
      $currentdate = date("Y-m");
  }

  $start = $currentdate."-01 00:00:00";
  $end = $currentdate."-31 23:59:59";

  $sql = "stor_dateadd >= '".$start."' and stor_dateadd <= '".$end."' and stor_status > 0";
  $query = $this->tp_stock_return_model->get_return_request($sql);
  $data['request_array'] = $query;

  $currentdate = explode('-', $currentdate);
  $currentdate = $currentdate[1]."/".$currentdate[0];
  $data["currentdate"] = $currentdate;
  $data['month'] = $currentdate;

  $data['title'] = "Nerd - Return Request List";
  $this->load->view("TP/warehouse/list_return", $data);
}

function view_return()
{
  $id = $this->uri->segment(3);

  $sql = "stor_id = '".$id."'";
  $query = $this->tp_stock_return_model->get_return_request($sql);
  if($query){
      $data['stor_array'] =  $query;
  }else{
      $data['stor_array'] = array();
  }

  $sql = "stor_id = '".$id."'";
  $query = $this->tp_stock_return_model->get_return_item($sql);
  if($query){
      $data['item_array'] =  $query;
  }else{
      $data['item_array'] = array();
  }

  $sql = "stor_id = '".$id."'";
  $query = $this->tp_stock_return_model->get_return_serial($sql);
  if($query){
      $data['serial_array'] =  $query;
  }else{
      $data['serial_array'] = array();
  }

  $data['user_status'] = $this->session->userdata('sessstatus');
  $data['title'] = "Nerd - View Return";
  $this->load->view("TP/warehouse/view_return", $data);
}

function void_return()
{
  $id = $this->uri->segment(3);

  $currentdate = date("Y-m-d H:i:s");

  $sql = "stor_id = '".$id."'";
  $query = $this->tp_stock_return_model->get_return_request($sql);
  foreach($query as $loop) {
      $remark = $loop->stor_remark;
  }

  $remark .= "##VOID##".$this->input->post("remarkvoid");
  $return = array("id" => $id, "stor_enable" => 0, "stor_remark" => $remark, "stor_status" => 3,
              "stor_dateadd" => $currentdate, "stor_dateadd_by" => $this->session->userdata('sessid')
              );
  $query = $this->tp_stock_return_model->edit_stock_return($return);

  redirect('tp_stock_return/view_return/'.$id, 'refresh');
}


}
