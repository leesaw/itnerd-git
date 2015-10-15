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
    $whtype = $this->jes_model->getAllWHType();
    foreach($whtype as $loop) {
        $lux_query = $this->jes_model->getNumberWatch_warehouse($loop->WTCode, '_L');
        $fashion_query = $this->jes_model->getNumberWatch_warehouse($loop->WTCode, '_F');
        
        if(!empty($lux_query)) {
            foreach($lux_query as $loop2) {
                $lux_sum = $loop2->sum1;
            }
        }else{
            $lux_sum = 0;
        }
        
        if(!empty($fashion_query)) {
            foreach($fashion_query as $loop2) {
                $fashion_sum = $loop2->sum1;
            }
        }else{
            $fashion_sum = 0;
        }
        if (($lux_sum>0)||($fashion_sum>0))
        $whcode_array[] = array("WTCode"=>$loop->WTCode, "WTDesc1"=>$loop->WTDesc1, "luxsum"=>$lux_sum, "fashionsum"=>$fashion_sum);
    }
    
    //$data['brand_array'] = $this->jes_model->getInventoryWatch_whtype();
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
    
    // only CT central graph
    $ct_array = $this->watch_viewInventory_graph('CT');
    
    $data['pt_array'] = $pt_array;
    $data['whcode_array'] = $whcode_array;
    $data['ct_array'] = $ct_array;
    
    $data['title'] = "NGG|IT Nerd - Watch";
    $this->load->view('JES/watch/main',$data);
}
    
function watch_viewInventory_graph($whtype)
{
    $whname = $this->jes_model->getAllWHName($whtype);
    foreach($whname as $loop) {
        $lux_query = $this->jes_model->getNumberWatch_departmentstore($loop->WHCode, '_L');
        $fashion_query = $this->jes_model->getNumberWatch_departmentstore($loop->WHCode, '_F');
        
        if(!empty($lux_query)) {
            foreach($lux_query as $loop2) {
                $lux_sum = $loop2->sum1;
            }
        }else{
            $lux_sum = 0;
        }
        
        if(!empty($fashion_query)) {
            foreach($fashion_query as $loop2) {
                $fashion_sum = $loop2->sum1;
            }
        }else{
            $fashion_sum = 0;
        }
        if (($lux_sum>0)||($fashion_sum>0))
        $result_array[] = array("WHCode"=>$loop->WHCode, "WHDesc1"=>$loop->WHDesc1, "luxsum"=>$lux_sum, "fashionsum"=>$fashion_sum);
    }
    
    return $result_array;
}
    
function watch_viewInventory_branch()
{
    $wh_code = $this->uri->segment(3);
    
    $data['item_array'] = $this->jes_model->getInventoryWatch_branch_item($wh_code);
    $query = $this->jes_model->getWarehouseTypeName($wh_code);
    foreach($query as $loop) {
        $data['branchname'] = $loop->WTDesc1;
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
    $data['brand_array'] = $this->jes_model->getAllWHType();
    $data['title'] = "NGG|IT Nerd - Watch";
    $this->load->view('JES/watch/viewStore',$data);
}

    
}
?>