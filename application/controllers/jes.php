<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jes extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->model('jes_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function license_now()
{
    $query = $this->jes_model->getActiveLicense();
    
    $user_array = array();
    $i =0;
    foreach ($query as $loop) {
        $text = $loop->SID;
        preg_match_all("/\[([^\]]*)\]/", $text, $matches, PREG_SET_ORDER);
        foreach ($matches as $r) {
            $user = $this->jes_model->getUser($r[1]);
            foreach($user as $loop2) { 
                $user_array[$i] = array( 'userfullname' => $loop2->UserFullName, 
                               'sid' => $loop->SID,
                               'LastUpdate' => $loop->LastUpdate ); 
                $i++;
            }
            
        }
        
        
    }
    //$data['license_array'] = $query;
    $data['user_array'] = $user_array;
    
    $data['user_status'] = $this->session->userdata('sessstatus');
    $data['title'] = "NGG|IT Nerd - JES license";
    $this->load->view('JES/license_now',$data);
}
    
function watch()
{
    $data['brand_array'] = $this->jes_model->getInventoryWatch_allBrand();
    $query = $this->jes_model->getProductType_onlyWatch();
    $data['producttype_array'] = $query;
    //$pt_array = array();
    foreach($query as $loop) {
        $pt_query = $this->jes_model->getInventoryWatch_producttype($loop->PTCode);
        if(!empty($pt_query)) {
            foreach($pt_query as $loop2) {
                $pt_array[] = array("PTCode"=>$loop->PTCode, "PTDesc1"=>$loop->PTDesc1, "sum1"=>$loop2->sum1);
            }
        }else{
            $pt_array[] = array("PTCode"=>$loop->PTCode, "PTDesc1"=>$loop->PTDesc1, "sum1"=> 0);
        }
    }
    $data['pt_array'] = $pt_array;
    
    $data['title'] = "NGG|IT Nerd - Watch";
    $this->load->view('JES/watch/main',$data);
}
    
function watch_viewInventory_branch()
{
    $wh_code = $this->uri->segment(3);
    
    $data['item_array'] = $this->jes_model->getInventoryWatch_branch_item($wh_code);
    $query = $this->jes_model->getStoreName($wh_code);
    foreach($query as $loop) {
        $data['branchname'] = $loop->WHDesc1;
    }
    $data['pt_array'] = $this->jes_model->getInventoryWatch_branch_item_producttype($wh_code);
    
    $data['title'] = "NGG|IT Nerd - Watch";
    $this->load->view('JES/watch/viewInventory_branch_item',$data);
}
    
function watch_viewInventory_product()
{
    $pt_code = $this->uri->segment(3);
    
    $data['item_array'] = $this->jes_model->getInventoryWatch_product_item($pt_code);
    $query = $this->jes_model->getProductName($pt_code);
    foreach($query as $loop) {
        $data['branchname'] = $loop->PTDesc1;
    }
    $data['pt_array'] = $this->jes_model->getInventoryWatch_product_item_branch($pt_code);
    
    $data['title'] = "NGG|IT Nerd - Watch";
    $this->load->view('JES/watch/viewInventory_product_item',$data);
}
    
function watch_store()
{
    $data['brand_array'] = $this->jes_model->getInventoryWatch_allBrand();
    $data['title'] = "NGG|IT Nerd - Watch";
    $this->load->view('JES/watch/viewStore',$data);
}

    
}
?>