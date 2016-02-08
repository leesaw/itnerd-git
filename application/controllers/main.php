<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); 

class Main extends CI_Controller {

public $num = 0;
public $ring = 0;

	function __construct()
	{
	   parent::__construct();
	   $this->load->model('user','',TRUE);
       
       if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
       /*
       $this->load->model('task_model','',TRUE);
        // get number of status=5
       $this->num = $this->task_model->getNumStatus5($this->session->userdata('sessid'));
        
        // get number of ring
       $query = $this->task_model->getNumRing($this->session->userdata('sessid'), $this->session->userdata('sessstatus'), $this->session->userdata('sessteam'));
       if ($this->session->userdata('sessstatus')!=1) { foreach ($query as $loop) { $this->ring += $loop->ring; } }
       else { $this->ring = $query; }
       */
        // end get ring
	}
	function index()
	{

	}
	
	function logout()
	{
	   $this->session->unset_userdata('sessid');
	   $this->session->unset_userdata('sessusername');
	   $this->session->unset_userdata('sessfirstname');
	   $this->session->unset_userdata('sesslastname');
	   $this->session->unset_userdata('sessstatus');
	   session_destroy();
        
       $this->load->helper('cookie');
       delete_cookie('itnerd_userid');
	   redirect('main', 'refresh');
	}
	
	function changepass()
	{
		$this->load->helper(array('form'));
		
		$data['id'] = $this->session->userdata('sessid');
		
		$data['title'] = "NGG|IT Nerd - Change Password";
		$data['numstatus5'] = $this->num;
		$this->load->view('changepass_view',$data);
	}
	
	function updatepass()
	{
		$this->load->library('form_validation');
		
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
			$data['title'] = "NGG|IT Nerd - Change Password";
			$data['numstatus5'] = $this->num;
			$this->load->view('changepass_view',$data);
	}
    
    function config()
    {
        $this->load->model('config_model','',TRUE);
        $data["config_array"] = $this->config_model->getAllconfig();
        
		$data['numstatus5'] = $this->num;
        $data['numring'] = $this->ring;
		$data['title'] = "NGG|IT Nerd - Configuration";
		$this->load->view('config',$data);
    }
    
    function saveconfig()
    {
        $lock_seq_task = $this->input->post('LOCK_SEQ_TASK');
        $config_array = array("config" => "LOCK_SEQ_TASK", "value" => $lock_seq_task);
        $this->load->model('config_model','',TRUE);
        $result = $this->config_model->editConfig($config_array);
        if ($result){
            $this->session->set_flashdata('showresult', 'true');
        }else{
            $this->session->set_flashdata('showresult', 'fail');
        }
        $data["config_array"] = $this->config_model->getAllconfig();
        $data['numstatus5'] = $this->num;
        $data['numring'] = $this->ring;
        $data['title'] = "NGG|IT Nerd - Configuration";
        redirect('main/config', 'refresh');
    }
}