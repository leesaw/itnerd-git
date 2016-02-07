<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timepieces extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->model('timepieces_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function salereport_graph()
{   
    // show default datepicker
    $current= date('Y-m-d');
    $current = explode('-', $current);
    $data['start_date'] = "01/".$current[1]."/".$current[0];
    $data['end_date'] = $current[2]."/".$current[1]."/".$current[0];
    
    $start = $current[0]."-".$current[1]."-01";
    $end = $current[0]."-".$current[1]."-".$current[2];
    
    // sum sale by brand
    $data['sale_fashion_brand'] = $this->jes_salereport_model->getSale_watch_lf_between("_F",$start,$end);
    
    $data['sale_luxury_brand'] = $this->jes_salereport_model->getSale_watch_lf_between("_L",$start,$end);
    
    // sum sale by shop WTCode
    $shop_fashion[] = array("WTCode"=>0, "WTDesc1"=>0, "sum1"=>0);
    $shop_luxury[] = array("WTCode"=>0, "WTDesc1"=>0, "sum1"=>0);
    $whtype = $this->jes_model->getAllWHType();
    foreach($whtype as $loop) {
        $lux_query = $this->jes_salereport_model->getSale_watch_warehouse_between($loop->WTCode,"_L",$start,$end);
        $fashion_query = $this->jes_salereport_model->getSale_watch_warehouse_between($loop->WTCode,"_F",$start,$end);
        
        $lux_sum = 0;
        foreach($lux_query as $loop2) {
            $lux_sum += $loop2->sum1;
        }
        
        $fashion_sum = 0;
        foreach($fashion_query as $loop2) {
            $fashion_sum += $loop2->sum1;
        }

        if ($fashion_sum>0) {
            $shop_fashion[] = array("WTCode"=>$loop->WTCode, "WTDesc1"=>$loop->WTDesc1, "sum1"=>$fashion_sum);
        }
        
        if ($lux_sum>0) {
            $shop_luxury[] = array("WTCode"=>$loop->WTCode, "WTDesc1"=>$loop->WTDesc1, "sum1"=>$lux_sum);
        }
    }
    
    $data['sale_fashion_shop'] = $shop_fashion;
    $data['sale_luxury_shop'] = $shop_luxury;
    
    $data['title'] = "NGG|Timepieces - Graph Report";
    $this->load->view('JES/watch/salereport_main',$data);
}
  
    
}
?>