<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ngg_gold extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->library('form_validation');
     $this->load->model('ngg_gold_model','',TRUE);
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function main()
{
    $data['sessstatus'] = $this->session->userdata('sessstatus');
    $this->load->model('tp_shop_model','',TRUE);
    
    $where = "sh_id = '".$this->session->userdata('sessshopid')."'";
    $data['shop_array'] = $this->tp_shop_model->getShop($where);
    $data['title'] = "NGG| Nerd";
    $this->load->view('NGG/gold/main',$data);
}
    
function changepass()
{
    $this->load->helper(array('form'));

    $data['id'] = $this->session->userdata('sessid');

    $data['title'] = "NGG| Nerd - Change Password";
    $this->load->view('NGG/gold/changepass_view',$data);
}

function updatepass()
{
    $this->load->library('form_validation');
    $this->load->model('user','',TRUE);

    $this->form_validation->set_rules('opassword', 'old password', 'trim|xss_clean|required|md5');
    $this->form_validation->set_rules('npassword', 'new password', 'trim|xss_clean|required|md5');
    $this->form_validation->set_rules('passconf', 'Password confirmation', 'trim|xss_clean|required|matches[npassword]');
    $this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
    $this->form_validation->set_message('matches', 'กรุณาใส่รหัสให้ตรงกัน');
    $this->form_validation->set_error_delimiters('<code>', '</code>');

    if($this->form_validation->run() == TRUE) {
        $newpass= ($this->input->post('npassword'));
        $oldpass= ($this->input->post('opassword'));
        $id= ($this->input->post('id'));

        if ($this->user->checkpass($id,$oldpass)) {

            $user = array(
                'id' => $id,
                'password' => $newpass
            );

            $result = $this->user->editUser($user);
            if ($result)
                $this->session->set_flashdata('showresult', 'success');
            else
                $this->session->set_flashdata('showresult', 'fail');

        }else{
            $this->session->set_flashdata('showresult', 'failpass');
        }
        redirect(current_url());
    }
        $data['id'] = $this->session->userdata('sessid');
        $data['title'] = "NGG| Nerd - Change Password";
        $this->load->view('NGG/gold/changepass_view',$data);
}
    
function form_warranty()
{
    $this->load->model('tp_shop_model','',TRUE);
    $where = "sh_id = '".$this->session->userdata('sessshopid')."'";
    $data['shop_array'] = $this->tp_shop_model->getShop($where);
	$data['datein'] = date("d/m/Y");
    
    $data['title'] = "NGG| Nerd - Create Warranty Card";
    $this->load->view('NGG/gold/form_warranty',$data);
}
    
function save_warranty()
{
    $datein = $this->input->post("datein");
    $cusname = $this->input->post("cusname");
    $cusaddress = $this->input->post("cusaddress");
    $custelephone = $this->input->post("custelephone");
    $product = $this->input->post("product");
    $kindgold = $this->input->post("kindgold");
    $payment = $this->input->post("payment");
    $code = $this->input->post("code");
    $weight = $this->input->post("weight");
    $price = $this->input->post("price");
    $jewelry = $this->input->post("jewelry");
    $model = $this->input->post("model");
    $datestart = $this->input->post("datestart");
    $old = $this->input->post("old");
    $goldbuy = $this->input->post("goldbuy");
    $goldsell = $this->input->post("goldsell");
    $shop_id = $this->input->post("shop_id");
    $saleperson_code = $this->input->post("saleperson_code");
    $remark = $this->input->post("remark");
    
    $currentdate = date("Y-m-d H:i:s");
    
    $datein = explode('/', $datein);
    $datein = $datein[2]."-".$datein[1]."-".$datein[0];
    $datestart = explode('/', $datestart);
    $datestart = $datestart[2]."-".$datestart[1]."-".$datestart[0];
    
    $day = date("Y-m-d");
    $month_array = explode('-',date("y-m-d"));
    
    $number = $this->ngg_gold_model->get_Maxnumber_warranty($day, $shop_id);
    $number++;
    
    $number = $month_array[0].$month_array[1].$month_array[2].str_pad($number, 5, '0', STR_PAD_LEFT);
    
    $warranty = array( 'ngw_number' => $number,
                    'ngw_product' => $product,
                    'ngw_kindgold' => $kindgold,
                    'ngw_price' => $price,
                    'ngw_payment' => $payment,
                    'ngw_code' => $code,
                    'ngw_weight' => $weight,
                    'ngw_jewelry' => $jewelry,
                    'ngw_datestart' => $datestart,
                    'ngw_old' => $old,
                    'ngw_model' => $model,
                    'ngw_goldbuy' => $goldbuy,
                    'ngw_goldsell' => $goldsell,
                    'ngw_customername' => $cusname,
                    'ngw_customertelephone' => $custelephone,
                    'ngw_customeraddress' => $cusaddress,
                    'ngw_saleperson_id' => $saleperson_code,
                    'ngw_issuedate' => $datein,
                    'ngw_shop_id' => $shop_id,
                    'ngw_dateadd' => $currentdate,
                    'ngw_remark' => $remark,
                    'ngw_enable' => 1,
                    'ngw_status' => 'N',
                    'ngw_dateaddby' => $this->session->userdata('sessid')
            );
    
    $last_id = $this->ngg_gold_model->add_warranty($warranty);
    $log_result = $this->ngg_gold_model->add_log_warranty($warranty);
    
    $result = array("b" => $last_id);
    echo json_encode($result);
    exit();
}
    
function view_warranty()
{
    $id = $this->uri->segment(3);

    $sql = "ngw_id = '".$id."'";
    $query = $this->ngg_gold_model->get_warranty($sql);
    if($query){
        $data['warranty_array'] =  $query;
    }else{
        $data['warranty_array'] = array();
    }
    
    $data['ngw_id'] = $id;
    $data['title'] = "NGG| Nerd - View Warranty Card";
    $this->load->view('NGG/gold/view_warranty',$data);
}
    
function print_warranty()
{
    $id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th','A5-L','0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/style_A5_gold_warranty.css');
    $mpdf->SetWatermarkImage(base_url()."dist/img/watermark-ngg.png", 0.1, array(100,33), array(55,70));
    $mpdf->showWatermarkImage = true;

    $sql = "ngw_id = '".$id."'";
    $query = $this->ngg_gold_model->get_warranty($sql);
    if($query){
        $data['warranty_array'] =  $query;
    }else{
        $data['warranty_array'] = array();
    }

    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("NGG/gold/print_warranty", $data, TRUE));
    $mpdf->Output();
}
    
function check_telephone()
{
    $telephone = str_replace("/","", $this->input->post("telephone"));
    $where = "ngw_customertelephone like '%".$telephone."%'";
    $query = $this->ngg_gold_model->get_warranty($where);
    $name = "";
    $address = "";
    foreach($query as $loop) {
        $name = $loop->ngw_customername;
        $address = $loop->ngw_customeraddress;
    }
    
    $result = array("a" => $name, "b" => $address);
    echo json_encode($result);
}
    
}
?>