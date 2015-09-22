<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jes extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->model('jes_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function license_now()
{
    $query = $this->jes_model->getActiveLicense();
    
    $user_array = array();
    $i =0;
    foreach ($query as $loop) {
        $text = $loop->SID;
        preg_match_all("/\[([^\]]*)\]/", $text, $matches, PREG_SET_ORDER);
        foreach ($matches as $r) {
            $user = $this->jes_model->getUser($r[1]);
            foreach($user as $loop2) { 
                $user_array[$i] = array( 'userfullname' => $loop2->UserFullName, 
                               'sid' => $loop->SID,
                               'LastUpdate' => $loop->LastUpdate ); 
                $i++;
            }
            
        }
        
        
    }
    //$data['license_array'] = $query;
    $data['user_array'] = $user_array;
    
    $data['user_status'] = $this->session->userdata('sessstatus');
    $data['title'] = "NGG|IT Nerd - JES license";
    $this->load->view('JES/license_now',$data);
}

    
}
?>