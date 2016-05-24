<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ngg_gold extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->library('form_validation');
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
    
}
?>