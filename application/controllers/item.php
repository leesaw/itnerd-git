<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {
    
public $no_rolex = "";
    
function __construct()
{
     parent::__construct();
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
    $this->form_validation->set_rules('long', 'long', 'aaxss_clean');
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
            'it_min_stock' => $minstock
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
    $this->form_validation->set_rules('long', 'long', 'aaxss_clean');
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
            'it_min_stock' => $minstock
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
    $sql .= " and br_has_serial = '".$luxury."'";
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
    $sql_result = "br_id = '888' and itse_dateadd > '2016-05-31 00:00:00'";
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
    
function item_barcode_print()
{
    $id = $this->uri->segment(3);
    
    $this->load->library('mpdf/mpdf');                
    $mpdf= new mPDF('th',array(110,19),'0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/stylebarcode.css');
    
    $currentdate = date('Y-m-d');
    $this->load->model('tp_warehouse_transfer_model','',TRUE);
    $sql_result = "br_id = '896' and itse_id > 1495";
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

    
}
?>