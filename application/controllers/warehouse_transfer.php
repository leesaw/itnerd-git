<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warehouse_transfer extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->model('tp_warehouse_model','',TRUE);
     $this->load->model('tp_warehouse_transfer_model','',TRUE);
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
    
function test1()
{
    $datein = $this->input->post("datein");
	$wh_id = $this->input->post("whid");
    $item = $this->input->post("item");
    $result = "";
    for($i=0; $i<count($item); $i++) {
        $result .= $item[$i]["id"]."+".$item[$i]["qty"]."*";
    }
    
    echo $datein."/".$wh_id."/".$result;
}
    
function importstock_confirm()
{
    $datein = $this->input->post("datein");
	$wh_id = $this->input->post("whid");
    $it_array = $this->input->post("item");
    
    $currentdate= date("Y-m-d H:i:s");
    
    $datein = explode('/', $datein);
    $datein= $datein[2]."-".$datein[1]."-".$datein[0];

}
    
function importstock_save()
{
	$datein = $this->input->post("datein");
	$wh_id = $this->input->post("whid");
    $it_array = $this->input->post("item");
    
    $currentdate= date("Y-m-d H:i:s");
    
    $datein = explode('/', $datein);
    $datein= $datein[2]."-".$datein[1]."-".$datein[0];

    for($i=0; $i<count($it_array); $i++){
        $sql = "stob_item_id = '".$it_array[$i]["id"]."' and stob_warehouse_id = '".$wh_id."'";
        $query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);
        if (!empty($query)) {
            foreach($query as $loop) {
                $stock_id = $loop->stob_id;
                $qty_new = $loop->stob_qty + $it_array[$i]["qty"];
                $stock = array( 'id' => $loop->stob_id,
                                'stob_qty' => $qty_new,
                                'stob_lastupdate' => $currentdate,
                                'stob_lastupdate_by' => $this->session->userdata('sessid')
                            );
                $query = $this->tp_warehouse_transfer_model->editWarehouse_transfer($stock);
                break;
            }
            $stock = array(
                        'stob_dateadd' => $currentdate,
                        'stob_datein' => $datein,
                        'stob_status' => 'I',
                        'stob_dateadd_by' => $this->session->userdata('sessid'),
                        'stob_warehouse_id' => $wh_id,
                        'stob_stock_balance_id' => $stock_id,
                        'stob_new_qty' => $it_array[$i]["qty"]
            );

            $query = $this->tp_log_model->addLogStockBalance($stock);
            
        }else{
            
        }
        $stock = array(
                        'stob_dateadd' => $currentdate,
                        'stob_datein' => $datein,
                        'stob_status' => 'I',
                        'stob_dateadd_by' => $this->session->userdata('sessid'),
                        'stob_warehouse_id' => $wh_id,
                        'stob_stock_balance_id' => $it_array[$i]["id"],
                        'stob_new_qty' => $it_array[$i]["qty"]
        );
        
        $query = $this->tp_log_model->addLogStockBalance($stock);
        
    }
    return true;
}
    
}
?>