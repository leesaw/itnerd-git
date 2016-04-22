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
    
}
    

}
?>