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
    
    
    $data['item_array'] = $this->rolex_model->getItem($sql);
    
    $data['title'] = "Rolex Nerd";
    $this->load->view('ROLEX/main',$data);
}

}
?>