<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rolex extends CI_Controller {

public $no_rolex = "";
    
function __construct()
{
     parent::__construct();
     $this->load->model('rolex_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('catalog', 'refresh');
    
     if ($this->session->userdata('sessrolex') == 0) $this->no_rolex = "br_id != 888";
     else $this->no_rolex = "br_id = 888";
}

function index()
{
    
}
 
function main()
{
    $sql = "it_brand_id = '888'";
    $data['collection_array'] = $this->rolex_model->getCollection($sql);
    
    $data['bracelet_array'] = $this->rolex_model->getBracelet($sql);
    
    $orderby = "it_srp desc";
    $data['item_array'] = $this->rolex_model->getItem($sql, $orderby);
    
    $data['refcode'] = "";
    $data['model'] = 0;
    $data['bracelet'] = 0;
    $data['title'] = "Rolex Catalog";
    $this->load->view('ROLEX/main',$data);
}
    
function filter_item()
{
    $sql = "it_brand_id = '888'";
    $data['collection_array'] = $this->rolex_model->getCollection($sql);
    
    $data['bracelet_array'] = $this->rolex_model->getBracelet($sql);
    
    $refcode = $this->input->post("refcode");
    $keyword = explode("%20", $refcode);
    $model = $this->input->post("model");
    $remark = $this->input->post("remark");
    
    $where = "";
    
    if ($keyword[0] != "NULL") {
        if (count($keyword) > 1) { 
            for($i=0; $i<count($keyword); $i++) {
                if ($i != 0) $where .= " or it_short_description like '%".$keyword[$i]."%'";
                else if ($keyword[$i] != "") $where .= "( it_short_description like '%".$keyword[$i]."%'";
                if ($i == (count($keyword)-1)) $where .= " )";
            }
        }else{
            $where .= "( it_refcode like '%".$keyword[0]."%' or itse_serial_number like '%".$keyword[0]."%' or it_short_description like '%".$keyword[0]."%' )";
        }
        
        $where .= " and ";
    }
    if (($model != "0") && ($remark != "0")) $where .= "it_model = '".$model."' and it_remark = '".$remark."' and ";
    else if (($model != "0") && ($remark == "0")) $where .= "it_model = '".$model."' and ";
    else if (($model == "0") && ($remark != "0")) $where .= "it_remark = '".$remark."' and ";
    $where .= $this->no_rolex;
    
    $orderby = "it_srp desc";
    
    $data['item_array'] = $this->rolex_model->getFilter($where, $orderby);
    $data['refcode'] = $refcode;
    $data['model'] = $model;
    $data['bracelet'] = $remark;
    
    $data['title'] = "Rolex Catalog";
    $this->load->view('ROLEX/main',$data);
}
    
function view()
{
    $it_id = $this->uri->segment(3);
    
    
}

}
?>