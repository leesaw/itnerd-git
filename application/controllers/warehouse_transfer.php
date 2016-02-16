<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warehouse_transfer extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->model('tp_warehouse_model','',TRUE);
     $this->load->model('tp_log_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function importstock() 
{
	$sql = "";
	$data['wh_array'] = $this->tp_warehouse_model->getWarehouse($sql);
	$data['currentdate'] = date("d/m/Y");

    $data['title'] = "Nerd - Import Stock";
    $this->load->view("TP/warehouse/addstock_view", $data);
}
    
function save_importstock()
{
	$datein = $this->input->post("datein");
	$wh_id = $this->input->post("whid");
	$it_array = $this->input->post("it_id");
	$quantity_array = $this->input->post("it_quantity");
    
    $currentdate= explode('/',date("d/m/Y/H/i/s"));
    $currentdate= ($currentdate[2]+543)."-".$currentdate[1]."-".$currentdate[0]." ".$currentdate[3].":".$currentdate[4].":".$currentdate[5];
    
    $datein = explode('/', $datein);
    $datein= $datein[2]."-".$datein[1]."-".$datein[0];
    
    for($i=0; $i<count($it_array); $i++){
        $stock = array(
                        'stob_dateadd' => $currentdate,
                        'stob_warehouse_id' => $wh_id,
                        'stob_stock_balance_id' => $it_array[$i],
                        'stob_new_qty' => $quantity_array[$i]
        );
        
        $query = $this->tp_log_model->addLogStockBalance($stock);
        
    }
    $this->session->set_flashdata('showresult', 'success');
    
    $sql = "";
	$data['wh_array'] = $this->tp_warehouse_model->getWarehouse($sql);
	$data['currentdate'] = date("d/m/Y");
    
	$data['title'] = "Nerd - Import Stock";
    $this->load->view("TP/warehouse/addstock_view", $data);
}
    
}
?>