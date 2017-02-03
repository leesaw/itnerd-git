<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalog extends CI_Controller {

 function __construct()
 {
   parent::__construct();
 }

 function index()
 {
   $this->load->helper('cookie');
   $this->load->model('user','',TRUE);

   $userid = get_cookie("itnerd_rolex_userid");
   if(isset($userid) && ($userid > 0)) {

        $query = $this->user->getOneUser($userid);
        foreach($query as $row) {
           $sess_array = array(
             'sessid' => $row->id,
             'sessusername' => $row->username,
             'sessfirstname' => $row->firstname,
             'sesslastname' => $row->lastname,
             'sessstatus' => $row->status,
             'sessrolex' => $row->is_rolex
           );
        }
        $this->session->set_userdata($sess_array);
        redirect('rolex/main', 'refresh');

   }else{
        $data['title'] = "Rolex Nerd";
        $this->load->helper(array('form'));
        $this->load->view('ROLEX/catalog_login',$data);
   }
 }

 function verify()
 {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('username', 'Username', 'trim|callback_required_username');
    $this->form_validation->set_rules('password', 'Password', 'trim|callback_required_password|callback_check_database');

    if($this->form_validation->run() == FALSE)
    {
     //Field validation failed.&nbsp; User redirected to login page

       $data['base'] = $this->config->item('base_url');
       $data['title'] = "Rolex Nerd";
       $this->load->view('ROLEX/catalog_login',$data);
    }
    else
    {
      //Go to private area
       redirect('rolex/main', 'refresh');
    }
 }

 function check_database($password)
 {
   //Field validation succeeded.&nbsp; Validate against database
   $username = $this->input->post('username');
   $remember = $this->input->post("rememberme");

   //query the database
   $this->load->model('user','',TRUE);
   $result = $this->user->login($username, $password);

   if($result AND  $username)
   {
     $sess_array = array();
     foreach($result as $row)
     {
       $userid = $row->id;
       $sess_array = array(
         'sessid' => $row->id,
         'sessusername' => $row->username,
		 'sessfirstname' => $row->firstname,
		 'sesslastname' => $row->lastname,
         'sessrolex' => $row->is_rolex,
		 'sessstatus' => $row->status
       );

       $this->session->set_userdata($sess_array);

       // insert log into log_user_login table
       $log_array = array(
           'userid' => $row->id,
           'username' => $row->username,
           'ip_address' => $this->input->ip_address(),
           'dateadd' => date('Y-m-d H:i:s')
       );
       $this->user->addLogLogin($log_array);
     }
     $this->load->helper('cookie');
     if($remember=="1") {
            $cookie_array = array(
                'name'   => 'itnerd_rolex_userid',
                'value'  => $userid,
                'expire' => '2147483647'

            );

            set_cookie($cookie_array);
     }

     return TRUE;
   }
   else if (!$username)
   {
			$this->form_validation->set_message('check_database', '');
            return FALSE;
   }
   else
   {
     $this->form_validation->set_message('check_database', '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fa fa-ban"></i><b>ไม่สามารถเข้าสู่ระบบได้ !</b></div>');
     return false;
   }
 }

 function required_username()
    {
        if( ! $this->input->post('username'))
        {
            $this->form_validation->set_message('required_username', '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b><i class="icon fa fa-ban"></i> กรุณาป้อน Username!</b></div>');
            return FALSE;
        }

        return TRUE;
    }
 function required_password()
    {
        if ($this->input->post('username') AND ! $this->input->post('password'))
        {
            $this->form_validation->set_message('required_password', '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b><i class="icon fa fa-ban"></i> กรุณาป้อน Password!</b></div>');
            return FALSE;
        }

        return TRUE;
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
       delete_cookie('itnerd_rolex_userid');
	   redirect('catalog', 'refresh');
	}

}

?>
