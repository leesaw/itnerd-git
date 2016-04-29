<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ss_certificate extends CI_Controller {

    
function __construct()
{
     parent::__construct();
     $this->load->model('ss_list_model','',TRUE);
     $this->load->model('ss_certificate_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('catalog', 'refresh');
}

function index()
{
    
}
 
function add_newcert()
{
    $this->load->helper(array('form'));
	
    //////////   ------ get list
	$query = $this->ss_list_model->get_list_clarity();
	if($query){
		$data['clarity_array'] =  $query;
	}else{
		$data['clarity_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_color();
	if($query){
		$data['color_array'] =  $query;
	}else{
		$data['color_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_culet();
	if($query){
		$data['culet_array'] =  $query;
	}else{
		$data['culet_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_cuttingstyle();
	if($query){
		$data['cuttingstyle_array'] =  $query;
	}else{
		$data['cuttingstyle_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_fluorescence();
	if($query){
		$data['fluorescence_array'] =  $query;
	}else{
		$data['fluorescence_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_girdlefinish();
	if($query){
		$data['girdlefinish_array'] =  $query;
	}else{
		$data['girdlefinish_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_girdleinscription();
	if($query){
		$data['girdleinscription_array'] =  $query;
	}else{
		$data['girdleinscription_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_girdlethickness();
	if($query){
		$data['girdlethickness_array'] =  $query;
	}else{
		$data['girdlethickness_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_naturaldiamond();
	if($query){
		$data['naturaldiamond_array'] =  $query;
	}else{
		$data['naturaldiamond_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_polish();
	if($query){
		$data['polish_array'] =  $query;
	}else{
		$data['polish_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_proportion();
	if($query){
		$data['proportion_array'] =  $query;
	}else{
		$data['proportion_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_shape();
	if($query){
		$data['shape_array'] =  $query;
	}else{
		$data['shape_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_symmetry();
	if($query){
		$data['symmetry_array'] =  $query;
	}else{
		$data['symmetry_array'] = array();
	}
    
    /////   ------  end get list
    
	$data['title'] = "NGG| Nerd - Add New Certification";
	$this->load->view('SS/certificate/add_newcert_view',$data);
}
    
function save()
{
    $shape= ($this->input->post('shape'));
    $cuttingstyle= ($this->input->post('cuttingstyle'));
    $measurement= ($this->input->post('measurement'));
    $carat= ($this->input->post('carat'));
    $color= ($this->input->post('color'));
    $clarity= ($this->input->post('clarity'));
    $girdleinscription= ($this->input->post('girdleinscription'));
    $fluorescence= ($this->input->post('fluorescence'));
    $proportion= ($this->input->post('proportion'));
    $symmetry= ($this->input->post('symmetry'));
    $polish= ($this->input->post('polish'));
    $totaldepth= ($this->input->post('totaldepth'));
    $totalsize= ($this->input->post('totalsize'));
    $crownheight= ($this->input->post('crownheight'));
    $crownangle= ($this->input->post('crownangle'));
    $starlength= ($this->input->post('starlength'));
    $paviliondepth= ($this->input->post('paviliondepth'));
    $pavilionangle= ($this->input->post('pavilionangle'));
    $lowerhalflength= ($this->input->post('lowerhalflength'));
    
    $currentdate = date("Y-m-d");
    
    $number = $this->ss_certificate_model->get_maxnumber_certificate($currentdate);

    $product = array(
        'shape' => $shape,
        'cuttingstyle' => $cuttingstyle,
        'measurement' => $measurement,
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
    

}
?>