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
    $query = $this->db->get('tp_item');
    return $query->num_rows();
}

function newwarehouse_save()
{
    $this->form_validation->set_rules('whname', 'whname', 'trim|xss_clean|required|callback_ไ้ืฟทำ_is_exist');
    $this->form_validation->set_rules('whcode', 'whcode', 'trim|xss_clean|required');
    $this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
    $this->form_validation->set_error_delimiters('<code>', '</code>');

    if($this->form_validation->run() == TRUE) {
        $whname= ($this->input->post('whname'));
        $whcode= ($this->input->post('whcode'));
        $wgid= ($this->input->post('wgid'));

        $warehouse = array(
            'wh_name' => $whname,
            'wh_code' => $whcode,
            'wh_group_id' => $wgid
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
    
function disable_warehouse()
{
    $wh_id = $this->uri->segment(3);
    
    $warehouse = array("id" => $wh_id, "wh_enable" => 0);
    $result = $this->tp_warehouse_model->editWarehouse($warehouse);
    
    redirect('warehouse/manage', 'refresh');
}
    
function getBalance()
{   
    $sql = $this->no_rolex;
    $data['brand_array'] = $this->tp_item_model->getBrand($sql);
    $sql = "wh_enable = '1'";
    $data['whname_array'] = $this->tp_warehouse_model->getWarehouse($sql);

    $data['title'] = "NGG| Nerd - Search Stock";
    $this->load->view('TP/warehouse/search_stock',$data);
}
    
function showBalance()
{
    $refcode = $this->input->post("refcode");
    $brand = $this->input->post("brand");
    $warehouse = $this->input->post("warehouse");
    $minprice = $this->input->post("minprice");
    $maxprice = $this->input->post("maxprice");
    /*
    $sql = $this->no_rolex;
    
    if (($brand=="0") && ($warehouse=="0") && ($minprice=="") && ($maxprice=="")){
        if ($refcode!="") {
            $keyword = explode(" ",$refcode);
            if (count($keyword) < 2) { 
                $sql .= " and (it_short_description like '%".$refcode."%' or it_refcode like '%".$refcode."%')";
            }else{
                for($i=0; $i<count($keyword); $i++) {
                    $sql .= " and (it_short_description like '%".$keyword[$i]."%' or it_refcode like '%".$keyword[$i]."%')";
                }
            }
        }
    }else {
        if ($refcode!="") {
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

        if (($minprice !="") && ($minprice>=0)) $sql .= " and it_srp >= '".$minprice."'";
        else $sql .= " and it_srp >=0";
            
        if (($maxprice !="") && ($maxprice>=0)) $sql .= "it_srp <= '".$maxprice."'";
        else $sql .= " and it_srp >=0";
    }
    $data['stock_array'] = $this->tp_warehouse_model->getWarehouse_balance($sql);
    */
    if ($refcode == "") $refcode = "NULL";
    $data['refcode'] = $refcode;
    $data['brand'] = $brand;
    $data['warehouse'] = $warehouse;
    if ($minprice == "") $minprice = 0;
    $data['minprice'] = $minprice;
    if ($maxprice == "") $maxprice = 0;
    $data['maxprice'] = $maxprice;

    $data['title'] = "NGG| Nerd - Ref Code";
    $this->load->view('TP/warehouse/show_stock',$data);
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
    $keyword = explode("%20", $refcode);
    $brand = $this->uri->segment(4);
    $warehouse = $this->uri->segment(5);
    $minprice = $this->uri->segment(6);
    $maxprice = $this->uri->segment(7);
    
    $sql = $this->no_rolex;
    
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
            
        if (($maxprice >"0") && ($maxprice>=0)) $sql .= "it_srp <= '".$maxprice."'";
        else $sql .= " and it_srp >=0";
    }
    
    $this->load->library('Datatables');
    $this->datatables
    ->select("it_refcode, br_name, it_model, wh_name, stob_qty, it_srp, it_short_description")
    ->from('tp_stock_balance')
    ->join('tp_warehouse', 'wh_id = stob_warehouse_id','left')
    ->join('tp_item', 'it_id = stob_item_id','left')
    ->join('tp_brand', 'br_id = it_brand_id','left')
    ->join('tp_item_serial', 'itse_item_id=stob_item_id and itse_warehouse_id=stob_warehouse_id','left')
    ->where('it_enable',1)
    ->where($sql);
    echo $this->datatables->generate(); 
}
    


}
?>