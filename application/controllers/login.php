<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

 function __construct()
 {
   parent::__construct();
 }

 function index()
 {
   $this->load->helper('cookie');
   $this->load->model('user','',TRUE);
    
   $userid = get_cookie("itnerd_userid");
   if(isset($userid) && ($userid > 0)) {
        
        $query = $this->user->getOneUser($userid);
        foreach($query as $row) {
           $sess_array = array(
             'sessid' => $row->id,
             'sessusername' => $row->username,
             'sessfirstname' => $row->firstname,
             'sesslastname' => $row->lastname,
             'sessstatus' => $row->status,
             'sessteam' => $row->team_id
           );
        }
        $this->session->set_userdata($sess_array); 
        redirect('main', 'refresh');

   }else{
        $data['title'] = "NGG|IT Nerd";
        $this->load->helper(array('form'));
        $this->load->view('login_view',$data);
   }
 }

}

?>