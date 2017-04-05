<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {

public $no_rolex = "";

function __construct()
{
     parent::__construct();
     $this->load->model('tp_item_model','',TRUE);
     $this->load->library('form_validation');
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

function manage()
{
    $sql = "br_enable = 1 and ".$this->no_rolex;
    $query = $this->tp_item_model->getBrand($sql);
	if($query){
		$data['brand_array'] =  $query;
	}else{
		$data['brand_array'] = array();
	}

    $sql = "itc_enable = 1";
	$query = $this->tp_item_model->getItemCategory($sql);
	if($query){
		$data['cat_array'] =  $query;
	}else{
		$data['cat_array'] = array();
	}

    $data['title'] = "NGG| Nerd - All Product";
    $this->load->view('TP/item/allitem_view',$data);
}

function export_excel_item()
{
  $all = $this->input->post("all");
  $where = "";
  if ($all != 1) {
    $refcode = $this->input->post("refcode");
    $keyword = explode("%20", $refcode);
    $brandid = $this->input->post("brandid");
    $catid = $this->input->post("catid");
    if ($keyword[0] != "NULL") {
        if (count($keyword) > 1) {
            for($i=0; $i<count($keyword); $i++) {
                if ($i != 0) $where .= " or it_short_description like '%".$keyword[$i]."%'";
                else if ($keyword[$i] != "") $where .= "( it_short_description like '%".$keyword[$i]."%'";
                if ($i == (count($keyword)-1)) $where .= " )";
            }
        }else{
            $where .= "( it_refcode like '%".$keyword[0]."%' or it_short_description like '%".$keyword[0]."%' )";
        }

        $where .= " and ";
    }
    if (($brandid != 0) && ($catid != 0)) $where .= "it_brand_id = '".$brandid."' and it_category_id = '".$catid."' and ";
    else if (($brandid != 0) && ($catid == 0)) $where .= "it_brand_id = '".$brandid."' and ";
    else if (($brandid == 0) && ($catid != 0)) $where .= "it_category_id = '".$catid."' and ";
    $where .= $this->no_rolex." and it_enable = 1";
  }else{
    $where = "it_enable = 1";
  }

  $item_array = $this->tp_item_model->getItem($where);

  //load our new PHPExcel library
  $this->load->library('excel');
  //activate worksheet number 1
  $this->excel->setActiveSheetIndex(0);
  //name the worksheet
  $this->excel->getActiveSheet()->setTitle('Sale Report');

  $this->excel->getActiveSheet()->setCellValue('A1', 'Ref. Number');
  $this->excel->getActiveSheet()->setCellValue('B1', 'Brand');
  $this->excel->getActiveSheet()->setCellValue('C1', 'Family');
  $this->excel->getActiveSheet()->setCellValue('D1', 'SRP');
  $this->excel->getActiveSheet()->setCellValue('E1', 'Product Category');

  $row = 2;
  foreach($item_array as $loop) {
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->it_refcode);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->br_name);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->it_model);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->it_srp);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->itc_name);
      $row++;
  }


  $filename='item_list_'.date('YmdHis').'.xlsx'; //save our workbook as this file name
  header('Content-Type: application/vnd.ms-excel'); //mime type
  header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
  header('Cache-Control: max-age=0'); //no cache

  //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
  //if you want to save it as .XLSX Excel 2007 format
  $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
  //force user to download the Excel file without writing it to server's HD
  $objWriter->save('php://output');
}

function additem()
{
	$this->load->helper(array('form'));

    $sql = "itc_enable = 1";
	$query = $this->tp_item_model->getItemCategory($sql);
	if($query){
		$data['cat_array'] =  $query;
	}else{
		$data['cat_array'] = array();
	}

    $sql = "br_enable = 1 and ".$this->no_rolex;
    $query = $this->tp_item_model->getBrand($sql);
	if($query){
		$data['brand_array'] =  $query;
	}else{
		$data['brand_array'] = array();
	}

	$data['title'] = "NGG| Nerd - Add Product";
	$this->load->view('TP/item/additem_view',$data);
}

function refcode_is_exist($id)
{

    if($this->id_validate($id)>0)
    {
		$this->form_validation->set_message('refcode_is_exist', 'รหัสสินค้านี้มีอยู่ในระบบแล้ว');
        return FALSE;
    }
    else {
        return TRUE;
    }
}

function id_validate($id)
{
    $this->db->where('it_refcode', $this->input->post('refcode'));
    $query = $this->db->get('tp_item');
    return $query->num_rows();
}

function number_is_money($str)
{

    if(!$this->is_money($str))
    {
		$this->form_validation->set_message('number_is_money', 'กรุณาใส่จำนวนเงินเท่านั้น');
        return FALSE;
    }
    else {
        return TRUE;
    }
}

function is_money($str)
{
	//return (bool) preg_match('/^[\-+]?[0-9]+[\.,][0-9]+$/', $str);
    return (bool) preg_match('/^[0-9,.]+$/', $str);
}

function save()
{
    $this->form_validation->set_rules('refcode', 'refcode', 'trim|xss_clean|required|callback_refcode_is_exist');
    //$this->form_validation->set_rules('name', 'Name', 'trim|xss_clean|required');
    $this->form_validation->set_rules('model', 'model', 'trim|xss_clean|required');
    $this->form_validation->set_rules('cost', 'cost', 'trim|xss_clean|required|callback_number_is_money');
    $this->form_validation->set_rules('srp', 'srp', 'trim|xss_clean|required|callback_number_is_money');
    $this->form_validation->set_rules('minstock', 'minstock', 'trim|xss_clean|required|numeric');
    $this->form_validation->set_rules('uom', 'uom', 'trim|xss_clean|required');
    $this->form_validation->set_rules('short', 'short', 'xss_clean');
    //$this->form_validation->set_rules('long', 'long', 'xss_clean');
    $this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
    $this->form_validation->set_message('numeric', 'กรุณาใส่เฉพาะตัวเลขเท่านั้น');
    $this->form_validation->set_error_delimiters('<code>', '</code>');

    if($this->form_validation->run() == TRUE) {
        $refcode= ($this->input->post('refcode'));
        //$itcode= ($this->input->post('itcode'));
        //$name= ($this->input->post('name'));
        $catid= ($this->input->post('catid'));
        $brandid= ($this->input->post('brandid'));
        $uom= ($this->input->post('uom'));
        $model= ($this->input->post('model'));
        $minstock= ($this->input->post('minstock'));
        $cost= str_replace(",", "", ($this->input->post('cost')));
        $srp= str_replace(",", "", ($this->input->post('srp')));
        $short= ($this->input->post('short'));
        $long= ($this->input->post('long'));
        $caseback = $this->input->post('caseback');
        $remark = $this->input->post('remark');

        $product = array(
            'it_refcode' => $refcode,
            //'it_code' => $itcode,
            //'it_name' => $name,
            'it_category_id' => $catid,
            'it_brand_id' => $brandid,
            'it_uom' => $uom,
            'it_model' => $model,
            'it_srp' => $srp,
            'it_cost_baht' => $cost,
            'it_short_description' => $short,
            'it_long_description' => $long,
            'it_min_stock' => $minstock,
            'it_has_caseback' => $caseback,
            'it_remark' => $remark,
        );

        $item_id = $this->tp_item_model->addItem($product);

        $currentdate = date("Y-m-d H:i:s");

        $temp = array('it_id' => $item_id, 'it_dateadd' => $currentdate,'it_by_user' => $this->session->userdata('sessid'));

        $product = array_merge($product, $temp);

        $result_log = $this->tp_item_model->addItem_log($product);

        //array_push($product);

        if ($item_id)
            $this->session->set_flashdata('showresult', 'success');
        else
            $this->session->set_flashdata('showresult', 'fail');
        redirect(current_url());
    }

    $sql = "itc_enable = 1";
	$query = $this->tp_item_model->getItemCategory($sql);
	if($query){
		$data['cat_array'] =  $query;
	}else{
		$data['cat_array'] = array();
	}

    $sql = "br_enable = 1 and ".$this->no_rolex;
    $query = $this->tp_item_model->getBrand($sql);
	if($query){
		$data['brand_array'] =  $query;
	}else{
		$data['brand_array'] = array();
	}

    $data['title'] = "NGG| Nerd - Add Product";
	$this->load->view('TP/item/additem_view',$data);
}

function edit_save()
{
    $this->form_validation->set_rules('refcode', 'refcode', 'trim|xss_clean|required');
    $this->form_validation->set_rules('model', 'model', 'trim|xss_clean|required');
    $this->form_validation->set_rules('cost', 'cost', 'trim|xss_clean|required|callback_number_is_money');
    $this->form_validation->set_rules('srp', 'srp', 'trim|xss_clean|required|callback_number_is_money');
    $this->form_validation->set_rules('minstock', 'minstock', 'trim|xss_clean|required|numeric');
    $this->form_validation->set_rules('uom', 'uom', 'trim|xss_clean|required');
    $this->form_validation->set_rules('short', 'short', 'xss_clean');
    $this->form_validation->set_rules('long', 'long', 'xss_clean');
    $this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
    $this->form_validation->set_message('numeric', 'กรุณาใส่เฉพาะตัวเลขเท่านั้น');
    $this->form_validation->set_error_delimiters('<code>', '</code>');

    $it_id= $this->input->post('it_id');

    if($this->form_validation->run() == TRUE) {
        $refcode= ($this->input->post('refcode'));
        $catid= ($this->input->post('catid'));
        $brandid= ($this->input->post('brandid'));
        $uom= ($this->input->post('uom'));
        $model= ($this->input->post('model'));
        $minstock= ($this->input->post('minstock'));
        $cost= str_replace(",", "", ($this->input->post('cost')));
        $srp= str_replace(",", "", ($this->input->post('srp')));
        $short= ($this->input->post('short'));
        $long= ($this->input->post('long'));
        $caseback = $this->input->post('caseback');
        $remark = $this->input->post('remark');

        $product = array(
            'id' => $it_id,
            'it_refcode' => $refcode,
            'it_category_id' => $catid,
            'it_brand_id' => $brandid,
            'it_uom' => $uom,
            'it_model' => $model,
            'it_srp' => $srp,
            'it_cost_baht' => $cost,
            'it_short_description' => $short,
            'it_long_description' => $long,
            'it_min_stock' => $minstock,
            'it_has_caseback' => $caseback,
            'it_remark' => $remark,
        );

        $item_id = $this->tp_item_model->editItem($product);

        $currentdate = date("Y-m-d H:i:s");

        unset($product['id']);
        $temp = array('it_id' => $it_id, 'it_dateadd' => $currentdate,'it_by_user' => $this->session->userdata('sessid'));

        $product = array_merge($product, $temp);

        $result_log = $this->tp_item_model->addItem_log($product);

        if ($item_id)
            $this->session->set_flashdata('showresult', 'success');
        else
            $this->session->set_flashdata('showresult', 'fail');


        redirect('item/editproduct/'.$it_id, 'refresh');
    }

    $sql = "it_id = '".$it_id."' and ".$this->no_rolex;
    $query = $this->tp_item_model->getItem($sql);
    if($query){
        $data['product_array'] =  $query;
    }

    $sql = "itc_enable = 1";
	$query = $this->tp_item_model->getItemCategory($sql);
	if($query){
		$data['cat_array'] =  $query;
	}else{
		$data['cat_array'] = array();
	}

    $sql = "br_enable = 1 and ".$this->no_rolex;
    $query = $this->tp_item_model->getBrand($sql);
	if($query){
		$data['brand_array'] =  $query;
	}else{
		$data['brand_array'] = array();
	}

    $data['title'] = "NGG| Nerd - Edit Product";
	$this->load->view('TP/item/edititem_view',$data);
}
//  AJAX DATATABLE
public function ajaxViewAllItem()
{
    $this->load->library('Datatables');
    $this->datatables
    ->select("it_refcode, br_name, it_model, it_srp, itc_name, it_id")
    ->from('tp_item')
    ->join('tp_item_category', 'it_category_id = itc_id','left')
    ->join('tp_brand', 'it_brand_id = br_id','left')
    ->where('it_enable',1)
    ->where($this->no_rolex)

    ->edit_column("it_id",'<div class="tooltip-demo">
<a href="'.site_url("item/viewproduct/$1").'" target="blank" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
<a href="'.site_url("item/editproduct/$1").'" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
</div>',"it_id");
    echo $this->datatables->generate();
}

public function ajaxViewFilterItem()
{
    $refcode = $this->uri->segment(3);
    $keyword = explode("%20", $refcode);
    $brandid = $this->uri->segment(4);
    $catid = $this->uri->segment(5);

    $where = "";

    if ($keyword[0] != "NULL") {
        if (count($keyword) > 1) {
            for($i=0; $i<count($keyword); $i++) {
                if ($i != 0) $where .= " or it_short_description like '%".$keyword[$i]."%'";
                else if ($keyword[$i] != "") $where .= "( it_short_description like '%".$keyword[$i]."%'";
                if ($i == (count($keyword)-1)) $where .= " )";
            }
        }else{
            $where .= "( it_refcode like '%".$keyword[0]."%' or it_short_description like '%".$keyword[0]."%' )";
        }

        $where .= " and ";
    }
    if (($brandid != 0) && ($catid != 0)) $where .= "it_brand_id = '".$brandid."' and it_category_id = '".$catid."' and ";
    else if (($brandid != 0) && ($catid == 0)) $where .= "it_brand_id = '".$brandid."' and ";
    else if (($brandid == 0) && ($catid != 0)) $where .= "it_category_id = '".$catid."' and ";
    $where .= $this->no_rolex;

    $this->load->library('Datatables');
    $this->datatables
    ->select("it_refcode, br_name, it_model, it_srp, itc_name, it_id")
    ->from('tp_item')
    ->join('tp_item_category', 'it_category_id = itc_id','left')
    ->join('tp_brand', 'it_brand_id = br_id','left')
    ->where('it_enable',1)
    ->where($where)

    ->edit_column("it_id",'<div class="tooltip-demo">
<a href="'.site_url("item/viewproduct/$1").'" target="blank" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
<a href="'.site_url("item/editproduct/$1").'" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
</div>',"it_id");
    echo $this->datatables->generate();
}

function viewproduct()
{
    $id = $this->uri->segment(3);
    $sql = "it_id = '".$id."' and ".$this->no_rolex;
    $query = $this->tp_item_model->getItem($sql);
    if($query){
        $data['product_array'] =  $query;
    }

    $data['title'] = "NGG| Nerd - View Product";
    $this->load->view('TP/item/viewitem_view',$data);
}

function editproduct()
{
    $id = $this->uri->segment(3);
    $sql = "it_id = '".$id."' and ".$this->no_rolex;
    $query = $this->tp_item_model->getItem($sql);
    if($query){
        $data['product_array'] =  $query;
    }

    $sql = "itc_enable = 1";
	$query = $this->tp_item_model->getItemCategory($sql);
	if($query){
		$data['cat_array'] =  $query;
	}else{
		$data['cat_array'] = array();
	}

    $sql = "br_enable = 1 and ".$this->no_rolex;
    $query = $this->tp_item_model->getBrand($sql);
	if($query){
		$data['brand_array'] =  $query;
	}else{
		$data['brand_array'] = array();
	}

    $data['title'] = "NGG| Nerd - Edit Product";
    $this->load->view('TP/item/edititem_view',$data);
}

function getRefcode()
{
    $refcode = $this->input->post("refcode");
    $luxury = $this->input->post("luxury");

    $sql = "it_enable = 1 and it_refcode = '".$refcode."' and ".$this->no_rolex;
    $sql .= " and it_has_caseback = '".$luxury."'";
    $result = $this->tp_item_model->getItem($sql);
    $output = "";
    foreach ($result as $loop) {
        $output .= "<td><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' id='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td><td>";
        if ($luxury == 0) {
            $output .= "<input type='text' name='it_quantity' id='it_quantity' value='1' style='width: 50px;' onChange='calculate();'></td><td>".$loop->it_uom."</td>";
        }else{
            $output .= "<input type='hidden' name='it_quantity' id='it_quantity' value='1'>1</td><td>".$loop->it_uom."</td>";
            $output .= "<td><input type='text' name='it_code' id='it_code' value='' style='width: 200px;'></td>";
        }
    }
    echo $output;
}

function getCaseback()
{
    $refcode = $this->input->post("refcode");

    $sql = "itse_serial_number = '".$refcode."' and itse_enable = 1 and ".$this->no_rolex;
    $result = $this->tp_item_model->getItem_caseback($sql);
    $output = "";
    foreach ($result as $loop) {
        $output .= "<td><input type='hidden' name='caseback_id' id='caseback_id' value='".$loop->itse_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td>".number_format($loop->it_srp)."</td><td>";
        $output .= "1</td><td>".$loop->it_uom."</td>";
        $output .= "<td><input type='text' name='it_code' id='it_code' value='".$loop->itse_serial_number."' style='width: 200px;'></td>";
    }
    echo $output;
}

function getCaseback_lockCaseback()
{
    $refcode = $this->input->post("refcode");

    $sql = "itse_serial_number = '".$refcode."' and ".$this->no_rolex;
    //$sql = "itse_serial_number = '".$refcode."'";
    $result = $this->tp_item_model->getItem_caseback($sql);
    $output = "";
    foreach ($result as $loop) {
        $output .= "<td><input type='hidden' name='caseback_id' id='caseback_id' value='".$loop->itse_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td>".number_format($loop->it_srp)."</td><td>";
        $output .= "1</td><td>".$loop->it_uom."</td>";
        $output .= "<td><input type='text' name='it_code' id='it_code' value='".$loop->itse_serial_number."' style='width: 200px;' readonly></td>";
    }
    echo $output;
}

function getCaseback_warehouse()
{
    $refcode = $this->input->post("caseback");

    $sql = "itse_serial_number = '".$refcode."' and itse_enable = 1 and ".$this->no_rolex;
    $result = $this->tp_item_model->getItem_caseback($sql);
    $output = "";
    foreach ($result as $loop) {
        $output .= "<td><input type='hidden' name='caseback_id' id='caseback_id' value='".$loop->itse_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td>".number_format($loop->it_srp)."</td><td>";
        $output .= "1</td><td>".$loop->it_uom."</td>";
        $output .= "<td><input type='text' name='it_code' id='it_code' value='".$loop->itse_serial_number."' style='width: 200px;' readonly></td>";
    }
    echo $output;
}

function getRefcode_caseback_warehouse()
{

}

function rolex_barcode_print()
{
    $id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th',array(110,19),'0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/stylebarcode.css');

    $this->load->model('tp_warehouse_transfer_model','',TRUE);
    $sql_result = "br_id = '888' and itse_serial_number like '27t12326' or itse_serial_number like '6v0357x6'";
    //$sql_result .= " and itse_serial_number = '63S0J540'";
    $query = $this->tp_warehouse_transfer_model->getItem_stock_caseback($sql_result);
    if($query){
        $data['serial_array'] =  $query;
    }else{
        $data['serial_array'] = array();
    }


    //echo $html;
    //$mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/item/barcode_print", $data, TRUE));
    $mpdf->Output();
}

function rolex_refcode_price_print(){

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th',array(110,19),'0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/stylebarcode.css');

    $currentdate = date('Y-m-d');
    $this->load->model('tp_item_model','',TRUE);
    $result = array();
    $index = 0;
    $sql_result = "";

    $sql_result = "br_id = '888'";
    $query = $this->tp_item_model->getItem($sql_result);
    foreach($query as $loop) {
        $result[$index] = array( "br_name" => $loop->br_name, "it_refcode" => $loop->it_refcode, "it_srp" => $loop->it_srp, "it_model" => $loop->it_model, "it_qty" => 1 );
        $index++;
    }
    $data['result_array'] = $result;
    //echo $html;
    //$mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/item/item_barcode_print_refcode", $data, TRUE));
    $mpdf->Output();
}

function item_barcode_print()
{
    $id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th',array(110,19),'0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/stylebarcode.css');

    $currentdate = date('Y-m-d');
    $this->load->model('tp_warehouse_transfer_model','',TRUE);
    $sql_result = "br_id = '896' and itse_dateadd >= '2016-07-09 00:00:00' and itse_dateadd <= '2016-07-09 23:00:00'";
    //$sql_result = "br_id = '896'";
    //$sql_result .= " and itse_serial_number = '63S0J540'";
    $query = $this->tp_item_model->getItem_caseback($sql_result);
    if($query){
        $data['serial_array'] =  $query;
    }else{
        $data['serial_array'] = array();
    }


    //echo $html;
    //$mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/item/item_barcode_print", $data, TRUE));
    $mpdf->Output();
}

function filter_item()
{
    $refcode = $this->input->post("refcode");
    if ($refcode == "") $refcode = "NULL";
    $data['refcode'] = $refcode;
    $data['brandid'] = $this->input->post("brandid");
    $data['catid'] = $this->input->post("catid");

    $sql = "br_enable = 1 and ".$this->no_rolex;
    $query = $this->tp_item_model->getBrand($sql);
	if($query){
		$data['brand_array'] =  $query;
	}else{
		$data['brand_array'] = array();
	}

    $sql = "itc_enable = 1";
	$query = $this->tp_item_model->getItemCategory($sql);
	if($query){
		$data['cat_array'] =  $query;
	}else{
		$data['cat_array'] = array();
	}

    $data['title'] = "NGG| Nerd - All Product";
    $this->load->view('TP/item/filteritem_view',$data);
}

function form_print_tag()
{
    $remark = $this->uri->segment(3);
    if ($remark != "") {
        if ($remark == "fashion")
            $remark = 0;
        else
            $remark = 1;
    }else{
        $remark = 0;
    }

    $data['remark'] = $remark;
    $data['title'] = "NGG| Nerd - Print Tag";
    $this->load->view('TP/item/form_print_tag',$data);
}

function result_print_tag_ean()
{
    $caseback = $this->input->post("caseback");

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th',array(110,19),'0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/stylebarcode.css');

    $currentdate = date('Y-m-d');
    $this->load->model('tp_item_model','',TRUE);
    $sql_result = "";
    for($i=0; $i <count($caseback); $i++) {
        if ($i>0) $sql_result .= " or ";
        $sql_result .= "itse_serial_number like '".$caseback[$i]."'";
    }

    $query = $this->tp_item_model->getItem_caseback($sql_result);
    if($query){
        $data['serial_array'] =  $query;
    }else{
        $data['serial_array'] = array();
    }


    //echo $html;
    //$mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/item/item_barcode_print_ean", $data, TRUE));
    $mpdf->Output();
}

function result_print_tag_refcode()
{
    $it_id = $this->input->post("it_id");
    $it_qty = $this->input->post("it_qty");

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th',array(110,19),'0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/stylebarcode_qr.css');

    $currentdate = date('Y-m-d');
    $this->load->model('tp_item_model','',TRUE);
    $result = array();
    $index = 0;
    $sql_result = "";
    for($i=0; $i <count($it_id); $i++) {
        $sql_result = "it_id = '".$it_id[$i]."'";
        $query = $this->tp_item_model->getItem($sql_result);
        foreach($query as $loop) {
            $result[$index] = array( "br_name" => $loop->br_name, "it_refcode" => $loop->it_refcode, "it_srp" => $loop->it_srp, "it_model" => $loop->it_model, "it_qty" => $it_qty[$i] );
            $index++;
        }
    }
    $data['result_array'] = $result;
    //echo $html;
    //$mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/item/item_barcode_print_refcode0", $data, TRUE));
    // $mpdf->WriteHTML($this->load->view("TP/item/item_barcode_print_refcode", $data, TRUE));
    $mpdf->Output();
}

function result_print_tag_refcode0()
{
    $it_id = array(7204);
    $it_qty = array(1);

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th',array(110,19),'0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/stylebarcode.css');

    $currentdate = date('Y-m-d');
    $this->load->model('tp_item_model','',TRUE);
    $result = array();
    $index = 0;
    $sql_result = "";
    for($i=0; $i <count($it_id); $i++) {
        $sql_result = "it_id = '".$it_id[$i]."'";
        $query = $this->tp_item_model->getItem($sql_result);
        foreach($query as $loop) {
            $result[$index] = array( "br_name" => $loop->br_name, "it_refcode" => $loop->it_refcode, "it_srp" => $loop->it_srp, "it_model" => $loop->it_model, "it_qty" => $it_qty[$i] );
            $index++;
        }
    }
    $data['result_array'] = $result;
    //echo $html;
    //$mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/item/item_barcode_print_refcode0", $data, TRUE));
    $mpdf->Output();
}

function result_print_tag_caseback()
{
    $caseback = $this->input->post("caseback");

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th',array(110,19),'0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/stylebarcode_qr.css');

    $currentdate = date('Y-m-d');
    $this->load->model('tp_item_model','',TRUE);
    $sql_result = "";
    for($i=0; $i <count($caseback); $i++) {
        if ($i>0) $sql_result .= " or ";
        $sql_result .= "itse_serial_number like '".$caseback[$i]."'";
    }

    $query = $this->tp_item_model->getItem_caseback($sql_result);
    if($query){
        $data['serial_array'] =  $query;
    }else{
        $data['serial_array'] = array();
    }


    //echo $html;
    //$mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/item/item_barcode_print_caseback0", $data, TRUE));
    $mpdf->Output();
}

function result_print_tag_rolex()
{
    $caseback = $this->input->post("caseback");

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th',array(110,19),'0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/stylebarcode.css');

    $this->load->model('tp_warehouse_transfer_model','',TRUE);
    $sql_result = "";
    for($i=0; $i <count($caseback); $i++) {
        if ($i>0) $sql_result .= " or ";
        $sql_result .= "itse_serial_number like '".$caseback[$i]."'";
    }
    $query = $this->tp_item_model->getItem_caseback($sql_result);
    if($query){
        $data['serial_array'] =  $query;
    }else{
        $data['serial_array'] = array();
    }

    //echo $html;
    //$mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/item/barcode_print", $data, TRUE));
    $mpdf->Output();
}

function upload_excel_item()
{
    $luxury = $this->uri->segment(3);
    $whid_out = $this->uri->segment(4);

    $this->load->helper(array('form', 'url'));

    $config['upload_path']          = './uploads/excel';
    $config['allowed_types']        = 'xls|xlsx';
    $config['max_size']             = '5000';

    $this->load->library('upload', $config);

    if ( !$this->upload->do_upload('excelfile_name'))
    {
        $error = array('error' => $this->upload->display_errors());

    }
    else
    {
        $data = $this->upload->data();
        $arr = array();
        $index = 0;
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($data['full_path']);
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        foreach ($cell_collection as $cell) {
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

            if ($row != 1) {
                $arr_data[$row-2][$column] = $data_value;

            }

        }

        for($i=0; $i<count($arr_data); $i++) {
            if ($arr_data[$i]['A'] != "") {
                if($luxury ==0) {
                    $sql = "it_enable = 1 and it_refcode = '".$arr_data[$i]['A']."' and ".$this->no_rolex;
                    $sql .= " and it_has_caseback = '".$luxury."'";
                    $this->load->model('tp_item_model','',TRUE);
                    $result = $this->tp_item_model->getItem($sql);
                    foreach ($result as $loop) {
                        $output = "<td><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' id='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td><td>";
                        $output .= "<input type='text' name='it_quantity' id='it_quantity' value='".$arr_data[$i]['B']."' style='width: 50px;' onChange='calculate();'></td><td>".$loop->it_uom."</td>";

                        $arr[$index] = $output;
                        $index++;
                    }
                }else{
                    $sql = "it_enable = 1 and itse_serial_number = '".$arr_data[$i]['A']."' and ".$this->no_rolex;
                    $sql .= " and it_has_caseback = '".$luxury."'";
                    $this->load->model('tp_item_model','',TRUE);
                    $result = $this->tp_item_model->getItem_caseback($sql);
                    foreach ($result as $loop) {
                        $output = "<td><input type='hidden' name='it_id' id='it_id' value='".$loop->it_id."'>".$loop->it_refcode."</td><td>".$loop->br_name."</td><td>".$loop->it_model."</td><td><input type='hidden' name='it_srp' id='it_srp' value='".$loop->it_srp."'>".number_format($loop->it_srp)."</td><td>";
                        $output .= "<input type='hidden' name='it_quantity' id='it_quantity' value='1'>1</td><td>".$loop->it_uom."</td>";
                        $output .= "<td><input type='text' name='it_code' id='it_code' value='".$loop->itse_serial_number."' style='width: 200px;' readonly></td>";
                        $arr[$index] = $output;
                        $index++;
                    }
                }
            }

        }

        unlink($data['full_path']);

        echo json_encode($arr);
        exit();
    }

}

}
?>
