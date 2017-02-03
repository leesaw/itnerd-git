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
            'sessrolex' => $row->is_rolex,
            'sessshopid' => $row->shop_id
          );

          $log_array = array(
           'userid' => $row->id,
           'username' => $row->username,
           'ip_address' => $this->input->ip_address(),
           'dateadd' => date('Y-m-d H:i:s')
           );
           $this->user->addLogLogin($log_array);
       }



       $this->session->set_userdata($sess_array);
       redirect('timepieces/main', 'refresh');

   }else{
        $data['title'] = "NGG| Nerd";
        $this->load->helper(array('form'));
        $this->load->view('login_view',$data);
   }
 }

 function users()
 {
    $this->load->model('user','',TRUE);
    $query = $this->user->getAllUsers();
    $data['user_array'] = $query;

    $data['title'] = "NGG| Nerd - Users";
    $this->load->view('user/user',$data);
 }

 function banUser()
 {
    $id = $this->uri->segment(3);

    $this->load->model('user','',TRUE);
    $result = $this->user->banUser($id);
    redirect('login/users', 'refresh');
 }

 function addUser()
 {
    $data['title'] = "NGG| Nerd - New User";
    $this->load->view('user/adduser',$data);
 }

 function saveuser()
 {
    $username = $this->input->post('username');
    $password = MD5($this->input->post('password1'));
    $status = $this->input->post('status');
    $team_id = $this->input->post('team_id');
    $firstname = $this->input->post('firstname');
    $lastname = $this->input->post('lastname');

    $this->load->model('user','',TRUE);
    $user_num = $this->user->checkUsername($username);

    if ($user_num > 0) {
        $result = false;
    }else{
        $task = array(
            'username' => $username,
            'password' => $password,
            'status' => $status,
            'team_id' => $team_id,
            'firstname' => $firstname,
            'lastname' => $lastname
        );

        $result = $this->user->adduser($task);
    }
    if ($result){
        $this->session->set_flashdata('showresult', 'true');
    }else{
        $this->session->set_flashdata('showresult', 'fail');
    }

    $data['title'] = "NGG| Nerd - New User";
    redirect('login/addUser','refresh');
 }

 function editUser()
 {
    $id = $this->uri->segment(3);

    $this->load->model('user','',TRUE);
    $query = $this->user->getOneUser($id);
    $data['user_array'] = $query;

    $data['title'] = "NGG| Nerd - Edit User";
    $this->load->view('user/edituser',$data);
 }

 function save_edituser()
 {
    $userid = $this->input->post('userid');
    $status = $this->input->post('status');
    $team_id = $this->input->post('team_id');
    $firstname = $this->input->post('firstname');
    $lastname = $this->input->post('lastname');

    $this->load->model('user','',TRUE);

    $task = array(
        'id' => $userid,
        'status' => $status,
        'team_id' => $team_id,
        'firstname' => $firstname,
        'lastname' => $lastname
    );

    $result = $this->user->editUser($task);

    if ($result){
        $this->session->set_flashdata('showresult', 'true');
    }else{
        $this->session->set_flashdata('showresult', 'fail');
    }

    $data['title'] = "NGG| Nerd - Edit User";
    redirect('login/edituser/'.$userid,'refresh');


 }

}

?>
