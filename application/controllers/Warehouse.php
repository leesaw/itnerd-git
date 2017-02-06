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

function manage()
{
    $sql = "";
    $data['warehouse_array'] = $this->tp_warehouse_model->getWarehouse($sql);

    $data['title'] = "NGG| Nerd - Warehouse Manage";
    $this->load->view('TP/warehouse/manage_view',$data);
}

function addwarehouse()
{
    $sql = "";
    $data['whgroup_array'] = $this->tp_warehouse_model->getWarehouseGroup($sql);

    $data['title'] = "NGG| Nerd - Add New Warehouse";
    $this->load->view('TP/warehouse/addwarehouse_view',$data);
}

function whname_is_exist($id)
{

    if($this->id_validate($id)>0)
    {
		$this->form_validation->set_message('whname_is_exist', 'ชื่อคลังสินค้านี้มีอยู่ในระบบแล้ว');
        return FALSE;
    }
    else {
        return TRUE;
    }
}

function id_validate($where)
{
    $this->db->where('wh_name', $this->input->post('whname'));
    $query = $this->db->get('tp_warehouse');
    return $query->num_rows();
}

function newwarehouse_save()
{
    $this->form_validation->set_rules('whname', 'whname', 'trim|xss_clean|required|callback_whname_is_exist');
    $this->form_validation->set_rules('whcode', 'whcode', 'trim|xss_clean|required');
    $this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
    $this->form_validation->set_error_delimiters('<code>', '</code>');

    if($this->form_validation->run() == TRUE) {
        $whname= ($this->input->post('whname'));
        $whcode= ($this->input->post('whcode'));
        $wgid= ($this->input->post('wgid'));
        $whdetail = $this->input->post('detail');
        $whaddress1 = $this->input->post('address1');
        $whaddress2 = $this->input->post('address2');
        $whtaxid = $this->input->post('taxid');
        $whbranch = $this->input->post('branch');

        $warehouse = array(
            'wh_name' => $whname,
            'wh_code' => $whcode,
            'wh_group_id' => $wgid,
            'wh_detail' => $whdetail,
            'wh_address1' => $whaddress1,
            'wh_address2' => $whaddress2,
            'wh_taxid' => $whtaxid,
            'wh_branch' => $whbranch,
        );

        $warehouse_id = $this->tp_warehouse_model->addWarehouse($warehouse);

        if ($warehouse_id)
            $this->session->set_flashdata('showresult', 'success');
        else
            $this->session->set_flashdata('showresult', 'fail');
        redirect(current_url());
    }

    $sql = "";
    $data['whgroup_array'] = $this->tp_warehouse_model->getWarehouseGroup($sql);

    $data['title'] = "NGG| Nerd - Add New Warehouse";
    $this->load->view('TP/warehouse/addwarehouse_view',$data);
}

function edit_warehouse()
{
    $id = $this->uri->segment(3);
    $where = "wh_id = '".$id."'";
    $data['wh_array'] = $this->tp_warehouse_model->getWarehouse($where);

    $sql = "";
    $data['whgroup_array'] = $this->tp_warehouse_model->getWarehouseGroup($sql);

    $data['title'] = "NGG| Nerd - Edit Warehouse";
    $this->load->view('TP/warehouse/editwarehouse_view',$data);
}

function edit_warehouse_save()
{
    $this->form_validation->set_rules('whname', 'whname', 'trim|xss_clean|required');
    $this->form_validation->set_rules('whcode', 'whcode', 'trim|xss_clean|required');
    $this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
    $this->form_validation->set_error_delimiters('<code>', '</code>');
    $id = $this->input->post('whid');

    if($this->form_validation->run() == TRUE) {
        $whname= ($this->input->post('whname'));
        $whcode= ($this->input->post('whcode'));
        $wgid= ($this->input->post('wgid'));
        $whdetail = $this->input->post('detail');
        $whaddress1 = $this->input->post('address1');
        $whaddress2 = $this->input->post('address2');
        $whtaxid = $this->input->post('taxid');
        $whbranch = $this->input->post('branch');

        $warehouse = array(
            'id' => $id,
            'wh_name' => $whname,
            'wh_code' => $whcode,
            'wh_group_id' => $wgid,
            'wh_detail' => $whdetail,
            'wh_address1' => $whaddress1,
            'wh_address2' => $whaddress2,
            'wh_taxid' => $whtaxid,
            'wh_branch' => $whbranch,
        );

        $warehouse_id = $this->tp_warehouse_model->editWarehouse($warehouse);

        if ($warehouse_id)
            $this->session->set_flashdata('showresult', 'success');
        else
            $this->session->set_flashdata('showresult', 'fail');
        redirect('warehouse/edit_warehouse/'.$id, 'refresh');
    }

    $where = "wh_id = '".$id."'";
    $data['wh_array'] = $this->tp_warehouse_model->getWarehouse($where);

    $sql = "";
    $data['whgroup_array'] = $this->tp_warehouse_model->getWarehouseGroup($sql);

    $data['title'] = "NGG| Nerd - Edit Warehouse";
    $this->load->view('TP/warehouse/editwarehouse_view',$data);
}

function disable_warehouse()
{
    $wh_id = $this->uri->segment(3);

    $warehouse = array("id" => $wh_id, "wh_enable" => 0);
    $result = $this->tp_warehouse_model->editWarehouse($warehouse);

    redirect('warehouse/manage', 'refresh');
}

function getBalance()
{
    $sql = "br_id != 888";
    $data['brand_array'] = $this->tp_item_model->getBrand($sql);
    $sql = "wh_enable = '1'";
    $data['whname_array'] = $this->tp_warehouse_model->getWarehouse($sql);

    // get total in each shops
    $sql = "br_id != 888";
    $sql .= " and it_enable = 1 and stob_enable = 1 and wh_enable = 1";
    $data['number_array'] = $this->tp_warehouse_model->getNumber_balance_groupbyshop($sql);

    $data['title'] = "NGG| Nerd - Search Stock";
    $this->load->view('TP/warehouse/search_stock',$data);
}

function showSerial()
{
    $serial = $this->input->post("serial");

    $where = "itse_serial_number like '".$serial."'";
    $data['stock_array'] = $this->tp_warehouse_model->getWarehouse_balance_caseback($where);

    $data['serial'] = $serial;

    $data['title'] = "NGG| Nerd - Search Stock";
    $this->load->view('TP/warehouse/result_serial',$data);
}

function showBalance()
{
    $refcode = $this->input->post("refcode");
    $brand = $this->input->post("brand");
    $warehouse = $this->input->post("warehouse");
    $minprice = $this->input->post("minprice");
    $maxprice = $this->input->post("maxprice");

    if ($refcode == "") $refcode = "NULL";
    $data['refcode_show'] = $refcode;
    $refcode = str_replace('/', '_2F_', $refcode);
    $data['refcode'] = $refcode;
    $data['brand'] = $brand;
    $data['warehouse'] = $warehouse;
    if ($minprice == "") $minprice = 0;
    $data['minprice'] = $minprice;
    if ($maxprice == "") $maxprice = 0;
    $data['maxprice'] = $maxprice;

    $data['viewby'] = 0;

    $sql = "br_id = '".$brand."'";
    $data['brand_array'] = $this->tp_item_model->getBrand($sql);
    $sql = "wh_id = '".$warehouse."'";
    $data['whname_array'] = $this->tp_warehouse_model->getWarehouse($sql);

    $data['title'] = "NGG| Nerd - Stock";
    $this->load->view('TP/warehouse/show_stock',$data);
}

function show_all_product_warehouse()
{
    $warehouse = $this->input->post("wh_id");

    $sql = "stob_warehouse_id = '".$warehouse."' and stob_qty > 0";
    $result = $this->tp_warehouse_model->getAll_Item_warehouse($sql);

    $arr = array();
    $index = 0;
    foreach ($result as $loop) {
        $output = "<td><input type='hidden' name='it_id' id='it_id' value='".$loop->stob_item_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td>";

        if ($loop->stob_qty > 0) {
            $output .= "<td style='width: 120px;'>";
        }else{
            $output .= "<td style='width: 120px;background-color: #F6CECE; font-weight: bold;'>";
        }
        $output .= "<input type='hidden' name='old_qty' id='old_qty' value='".$loop->stob_qty."'>".$loop->stob_qty."</td>";
        $output .= "<td><input type='text' name='it_quantity' id='it_quantity' value='".$loop->stob_qty."' style='width: 50px;' onChange='calculate();'></td><td>".$loop->it_uom."</td>";

        $arr[$index] = $output;
        $index++;
    }
    echo json_encode($arr);
    exit();
}

function show_all_product_warehouse_onlyfashion()
{
    $warehouse = $this->input->post("wh_id");

    $sql = "stob_warehouse_id = '".$warehouse."' and stob_qty > 0 and it_has_caseback = '0'";
    $result = $this->tp_warehouse_model->getAll_Item_warehouse($sql);

    $arr = array();
    $index = 0;
    foreach ($result as $loop) {
        $output = "<td><input type='hidden' name='it_id' id='it_id' value='".$loop->stob_item_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td>";

        if ($loop->stob_qty > 0) {
            $output .= "<td style='width: 120px;'>";
        }else{
            $output .= "<td style='width: 120px;background-color: #F6CECE; font-weight: bold;'>";
        }
        $output .= "<input type='hidden' name='old_qty' id='old_qty' value='".$loop->stob_qty."'>".$loop->stob_qty."</td>";
        $output .= "<td><input type='text' name='it_quantity' id='it_quantity' value='".$loop->stob_qty."' style='width: 50px;' onChange='calculate();'></td><td>".$loop->it_uom."</td>";

        $arr[$index] = $output;
        $index++;
    }
    echo json_encode($arr);
    exit();
}

function show_all_product_warehouse_caseback()
{
    $warehouse = $this->input->post("wh_id");

    $sql = "itse_warehouse_id = '".$warehouse."' and itse_enable = '1' and it_has_caseback = '1'";
    $result = $this->tp_warehouse_model->getAll_Item_warehouse_caseback($sql);

    $arr = array();
    $index = 0;
    foreach ($result as $loop) {
       $output = "<td><input type='hidden' name='itse_id' id='itse_id' value='".$loop->itse_id."'><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td>";
       $output .= "<td><input type='hidden' name='old_qty' id='old_qty' value='".$loop->stob_qty."'><input type='hidden' name='it_quantity' id='it_quantity' value='1'>1</td><td>".$loop->it_uom."</td>";
       $output .= "<td><input type='text' name='it_code' id='it_code' value='".$loop->itse_serial_number."' style='width: 200px;' readonly></td>";

       $arr[$index] = $output;
       $index++;
    }
    echo json_encode($arr);
    exit();
}

function show_all_product_transfer_id()
{
    $transfer_id = $this->input->post("transfer_id");
    $warehouse = $this->input->post("whid_out");

    $sql = "log_stot_transfer_id = '".$transfer_id."'";
    $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer_between($sql);

    $arr = array();
    $index = 0;

    foreach($query as $loop1) {

        $sql = "stob_warehouse_id = '".$warehouse."' and stob_item_id = '".$loop1->log_stot_item_id."'";

        $result = $this->tp_warehouse_model->getAll_Item_warehouse($sql);

        foreach ($result as $loop) {
            $output = "<td><input type='hidden' name='it_id' id='it_id' value='".$loop->stob_item_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td>";

            if ($loop->stob_qty > 0) {
                $output .= "<td style='width: 120px;'>";
            }else{
                $output .= "<td style='width: 120px;background-color: #F6CECE; font-weight: bold;'>";
            }

            $output .= "<input type='hidden' name='old_qty' id='old_qty' value='".$loop->stob_qty."'>".$loop->stob_qty."</td>";
            $output .= "<td><input type='text' name='it_quantity' id='it_quantity' value='".$loop1->qty_final."' style='width: 50px;' onChange='calculate();'></td><td>".$loop->it_uom."</td>";

            $arr[$index] = $output;
            $index++;
        }

    }

    echo json_encode($arr);
    exit();
}

function showBalance_byserial()
{
    $refcode = $this->input->post("refcode");
    $brand = $this->input->post("brand");
    $warehouse = $this->input->post("warehouse");
    $minprice = $this->input->post("minprice");
    $maxprice = $this->input->post("maxprice");

    if ($refcode == "") $refcode = "NULL";
    $data['refcode'] = $refcode;
    $data['brand'] = $brand;
    $data['warehouse'] = $warehouse;
    if ($minprice == "") $minprice = 0;
    $data['minprice'] = $minprice;
    if ($maxprice == "") $maxprice = 0;
    $data['maxprice'] = $maxprice;

    $data['viewby'] = 1;

    $sql = "br_id = '".$brand."'";
    $data['brand_array'] = $this->tp_item_model->getBrand($sql);
    $sql = "wh_id = '".$warehouse."'";
    $data['whname_array'] = $this->tp_warehouse_model->getWarehouse($sql);

    $data['title'] = "NGG| Nerd - Stock";
    $this->load->view('TP/warehouse/show_stock_byserial',$data);
}

function view_serial()
{
    $stob_id = $this->uri->segment(3);
    $sql = "stob_id = '".$stob_id."' and itse_enable = '1'";
    $data['serial_array'] = $this->tp_item_model->getCaseback_stock($sql);

    $data['title'] = "NGG| Nerd - Caseback";
    $this->load->view('TP/item/show_serial',$data);
}

function ajaxViewStock()
{
    $refcode = $this->uri->segment(3);
    $refcode = str_replace('_2F_', '/', $refcode);
    $keyword = explode("%20", $refcode);
    $brand = $this->uri->segment(4);
    $warehouse = $this->uri->segment(5);
    $minprice = $this->uri->segment(6);
    $maxprice = $this->uri->segment(7);

    $sql = "br_id != '888'";

    if (($brand=="0") && ($warehouse=="0") && ($minprice=="") && ($maxprice=="")){
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

        if ($warehouse!="0") $sql .= " and wh_id = '".$warehouse."'";
        else $sql .= " and wh_id != '0'";

        if (($minprice >"0") && ($minprice>=0)) $sql .= " and it_srp >= '".$minprice."'";
        else $sql .= " and it_srp >=0";

        if (($maxprice >"0") && ($maxprice>=0)) $sql .= " and it_srp <= '".$maxprice."'";
        else $sql .= " and it_srp >=0";
    }

    $this->load->library('Datatables');
    $this->datatables
    ->select("it_refcode, br_name, it_model, wh_code, wh_name, stob_qty, it_srp, it_short_description")
    ->from('tp_stock_balance')
    ->join('tp_warehouse', 'wh_id = stob_warehouse_id','left')
    ->join('tp_item', 'it_id = stob_item_id','left')
    ->join('tp_brand', 'br_id = it_brand_id','left')
    ->where('stob_qty >', 0)
    ->where('it_enable',1)
    ->where($sql);
    echo $this->datatables->generate();
}

function ajaxViewStock_serial()
{
    $refcode = $this->uri->segment(3);
    $refcode = str_replace('_2F_', '/', $refcode);
    $keyword = explode("%20", $refcode);
    $brand = $this->uri->segment(4);
    $warehouse = $this->uri->segment(5);
    $minprice = $this->uri->segment(6);
    $maxprice = $this->uri->segment(7);

    $sql = "br_id != '888'";

    if (($brand=="0") && ($warehouse=="0") && ($minprice=="") && ($maxprice=="")){
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

        if ($warehouse!="0") $sql .= " and wh_id = '".$warehouse."'";
        else $sql .= " and wh_id != '0'";

        if (($minprice >"0") && ($minprice>=0)) $sql .= " and it_srp >= '".$minprice."'";
        else $sql .= " and it_srp >=0";

        if (($maxprice >"0") && ($maxprice>=0)) $sql .= " and it_srp <= '".$maxprice."'";
        else $sql .= " and it_srp >=0";
    }
    $sql .= " and itse_enable=1";

    $this->load->library('Datatables');
    $this->datatables
    ->select("it_refcode, IF(itse_sample = 1, CONCAT(itse_serial_number, '(Sample)'), itse_serial_number), br_name, it_model, wh_code, wh_name, '1', it_srp, it_short_description", false)
    ->from('tp_item_serial')
    ->join('tp_warehouse', 'wh_id = itse_warehouse_id','left')
    ->join('tp_item', 'it_id = itse_item_id','left')
    ->join('tp_brand', 'br_id = it_brand_id','left')
    ->where('it_enable',1)
    ->where($sql);
    echo $this->datatables->generate();
}

function exportExcel_stock_itemlist()
{
    $refcode = $this->input->post("refcode");
    $refcode = str_replace('_2F_', '/', $refcode);
    $keyword = explode(" ", $refcode);
    $brand = $this->input->post("brand");
    $warehouse = $this->input->post("warehouse");
    $minprice = $this->input->post("minprice");
    $maxprice = $this->input->post("maxprice");

    $sql = "br_id != '888'";
    $sql .= " and stob_qty >0 and it_enable = 1";

    if (($brand=="0") && ($warehouse=="0") && ($minprice=="") && ($maxprice=="")){
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

        if ($warehouse!="0") $sql .= " and wh_id = '".$warehouse."'";
        else $sql .= " and wh_id != '0'";

        if (($minprice >"0") && ($minprice>=0)) $sql .= " and it_srp >= '".$minprice."'";
        else $sql .= " and it_srp >=0";

        if (($maxprice >"0") && ($maxprice>=0)) $sql .= " and it_srp <= '".$maxprice."'";
        else $sql .= " and it_srp >=0";
    }

    $item_array = $this->tp_warehouse_model->getWarehouse_balance($sql);

    //load our new PHPExcel library
    $this->load->library('excel');
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Stock_Balance');

    $this->excel->getActiveSheet()->setCellValue('A1', 'Ref. Number');
    $this->excel->getActiveSheet()->setCellValue('B1', 'ยี่ห้อ');
    $this->excel->getActiveSheet()->setCellValue('C1', 'Family');
    $this->excel->getActiveSheet()->setCellValue('D1', 'รหัสคลังสินค้า');
    $this->excel->getActiveSheet()->setCellValue('E1', 'คลังสินค้า');
    $this->excel->getActiveSheet()->setCellValue('F1', 'คลังสินค้า (English)');
    $this->excel->getActiveSheet()->setCellValue('G1', 'จำนวน (Pcs.)');
    $this->excel->getActiveSheet()->setCellValue('H1', 'ราคาป้าย');
    $this->excel->getActiveSheet()->setCellValue('I1', 'รายละเอียด');
    if ($this->session->userdata('sessstatus') == '88') { $this->excel->getActiveSheet()->setCellValue('J1', 'ราคาทุน'); }

    $row = 2;
    $count_qty = 0;
    foreach($item_array as $loop) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->it_refcode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->br_name);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->it_model);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->wh_code);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->wh_name);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->wh_name_eng);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $loop->stob_qty);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->it_srp);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $loop->it_short_description);
        if ($this->session->userdata('sessstatus') == '88') { $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->it_cost_baht); }
        $row++;
        $count_qty += $loop->stob_qty;
    }

    // count all qty
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, "จำนวนรวม");
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $count_qty);

    //--------

    $filename='timepieces_search.xlsx'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache

    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
}

function exportExcel_stock_itemlist_caseback()
{
    $refcode = $this->input->post("refcode");
    $refcode = str_replace('_2F_', '/', $refcode);
    $keyword = explode(" ", $refcode);
    $brand = $this->input->post("brand");
    $warehouse = $this->input->post("warehouse");
    $minprice = $this->input->post("minprice");
    $maxprice = $this->input->post("maxprice");

    $sql = "br_id != '888'";

    $sql .= " and it_enable = 1";

    if (($brand=="0") && ($warehouse=="0") && ($minprice=="") && ($maxprice=="")){
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

        if ($warehouse!="0") $sql .= " and wh_id = '".$warehouse."'";
        else $sql .= " and wh_id != '0'";

        if (($minprice >"0") && ($minprice>=0)) $sql .= " and it_srp >= '".$minprice."'";
        else $sql .= " and it_srp >=0";

        if (($maxprice >"0") && ($maxprice>=0)) $sql .= " and it_srp <= '".$maxprice."'";
        else $sql .= " and it_srp >=0";
    }
    $sql .= " and itse_enable=1";

    $item_array = $this->tp_warehouse_model->getWarehouse_balance_caseback($sql);

    //load our new PHPExcel library
    $this->load->library('excel');
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Stock_Balance');

    $this->excel->getActiveSheet()->setCellValue('A1', 'Ref. Number');
    $this->excel->getActiveSheet()->setCellValue('B1', 'ยี่ห้อ');
    $this->excel->getActiveSheet()->setCellValue('C1', 'Family');
    $this->excel->getActiveSheet()->setCellValue('D1', 'รหัสคลังสินค้า');
    $this->excel->getActiveSheet()->setCellValue('E1', 'คลังสินค้า');
    $this->excel->getActiveSheet()->setCellValue('F1', 'คลังสินค้า (English)');
    $this->excel->getActiveSheet()->setCellValue('G1', 'Caseback');
    $this->excel->getActiveSheet()->setCellValue('H1', 'จำนวน');
    $this->excel->getActiveSheet()->setCellValue('I1', 'ราคาป้าย');
    $this->excel->getActiveSheet()->setCellValue('J1', 'รายละเอียด');

    $row = 2;
    $count_qty = 0;
    foreach($item_array as $loop) {
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->it_refcode);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->br_name);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->it_model);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->wh_code);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->wh_name);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->wh_name_eng);

        if ($loop->itse_sample > 0) $serial = $loop->itse_serial_number."(Sample)";
        else $serial = $loop->itse_serial_number;
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $serial);

        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, 1);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $loop->it_srp);
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->it_short_description);
        $row++;
        $count_qty++;
    }

    // count all qty
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, "จำนวนรวม");
    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $count_qty);

    //--------

    $filename='caseback.xlsx'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache

    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');

    //echo "OK";
}

}
?>
