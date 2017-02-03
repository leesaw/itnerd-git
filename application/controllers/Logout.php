<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); 

class Main extends CI_Controller {

public $num = 0;
public $ring = 0;

	function __construct()
	{
	   parent::__construct();
	   $this->load->model('user','',TRUE);


	}
	function index()
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

}
