<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('user','',TRUE);
   $this->load->model('config_model','',TRUE);
   
 }

 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
     
   $this->form_validation->set_rules('username', 'Username', 'trim|xss_clean|callback_required_username');
   $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|callback_required_password|callback_check_database');

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.&nbsp; User redirected to login page

       $data['base'] = $this->config->item('base_url');
       $data['title'] = "NGG|IT Support - Login";
       $this->load->view('login_view',$data);
   }
   else
   {
      //Go to private area
        if (($this->session->userdata('sessstatus') < 10) || ($this->session->userdata('sessstatus') == 99)) {
            redirect('main', 'refresh');
        }elseif ($this->session->userdata('sesscompany') == 1) {
            if ($this->session->userdata('sessstatus')==18) redirect('jes/search_refcode', 'refresh');
            redirect('jes/watch', 'refresh');
        }
   }

 }

 function check_database($password)
 {
   //Field validation succeeded.&nbsp; Validate against database
   $username = $this->input->post('username');
   $remember = $this->input->post("rememberme");

   //query the database
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
		 'sessstatus' => $row->status,
         'sessteam' => $row->team_id,
         'sesscompany' => $row->ngg_company_id,
         'sessposition' => $row->ngg_position_id
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
                'name'   => 'itnerd_userid',
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
}
?>
