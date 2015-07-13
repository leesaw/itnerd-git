<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Task extends CI_Controller {

public $num = 0;
    
function __construct()
{
     parent::__construct();
     $this->load->model('task_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
    
     $this->num = $this->task_model->getNumStatus5($this->session->userdata('sessid'));
}

function index()
{

}
    
function main()
{
    $query = $this->task_model->getAllTask($this->session->userdata('sessid'), 1);
    $data['task_array'] = $query;
    
    $data['user_status'] = $this->session->userdata('sessstatus');
    $data['numstatus5'] = $this->num;
    $data['title'] = "NGG|IT Nerd - Task";
    $this->load->view('task/main',$data);
}
    
function viewtask_alluser()
{
    if ($this->session->userdata('sessstatus')==1) {
        $query = $this->task_model->getAllTask(0, 0);
    }
    $data['task_array'] = $query;
    
    $data['title'] = "NGG|IT Nerd - Task";
    $data['numstatus5'] = $this->num;
    $this->load->view('task/viewtask_alluser',$data);
}
    
function viewtask_finish()
{
    if ($this->session->userdata('sessstatus')==1) {
        $query = $this->task_model->getAllTask(0, 3);
    }
    $data['task_array'] = $query;
    
    $data['title'] = "NGG|IT Nerd - Task";
    $data['numstatus5'] = $this->num;
    $this->load->view('task/viewtask_alluser',$data);
}

function addtask()
{
    $query = $this->task_model->getAllCategory();
    $data['category_array'] = $query;
    
    if ($this->session->userdata('sessstatus')==1) {
        $this->load->model('user','',TRUE);
        $query = $this->user->getUsers();   
        $data['user_array'] = $query;
    }
    
    $data['user_id'] = $this->session->userdata('sessid');
    $data['user_firstname'] = $this->session->userdata('sessfirstname');
    $data['user_lastname'] = $this->session->userdata('sesslastname');
    $data['user_status'] = $this->session->userdata('sessstatus');
    
    $data['numstatus5'] = $this->num;
    $data['title'] = "NGG|IT Nerd - New Task";
    $this->load->view('task/addtask',$data);
}

function savetask()
{

    $topic = $this->input->post('topic');
    $category_id = $this->input->post('category');
    $dateadd = date('Y-m-d H:i:s');
        
    $dateon = $this->input->post("dateon");
    if ($dateon != "") {
        $dateon = explode('/', $dateon);
        $dateon= $dateon[2]."-".$dateon[1]."-".$dateon[0];
    }else{
        $dateon= explode('/',date("d/m/y"));
        $dateon= $dateon[2]."-".$dateon[1]."-".$dateon[0];
    }
        
    $detail = $this->input->post('detail');
    $userid = $this->input->post('userid');
    $assign = $this->input->post('assign');
    
    if ($userid==$assign) $status = 1;
    else $status = 5;


    $task = array(
        'topic' => $topic,
        'category_id' => $category_id,
        'dateadd' => $dateadd,
        'dateon' => $dateon,
		'userid' => $userid,
		'detail' => $detail,
        'assign' => $assign,
        'status' => $status   
    );
            
    $result = $this->task_model->addtask($task);
    if ($result){
        $this->session->set_flashdata('showresult', 'true');
    }else{
        $this->session->set_flashdata('showresult', 'fail');
    }

    $query = $this->task_model->getAllCategory();
    $data['category_array'] = $query;
    
    if ($this->session->userdata('sessstatus')==1) {
        $this->load->model('user','',TRUE);
        $query = $this->user->getUsers();   
        $data['user_array'] = $query;
    }
    
    $data['user_id'] = $this->session->userdata('sessid');
    $data['user_firstname'] = $this->session->userdata('sessfirstname');
    $data['user_lastname'] = $this->session->userdata('sesslastname');
    $data['user_status'] = $this->session->userdata('sessstatus');
    
    $data['numstatus5'] = $this->num;
    $data['title'] = "NGG|IT Nerd - New Task";
    redirect('task/addtask','refresh');

}
    
function finishtask()
{
    $id = $this->uri->segment(3);
    
    $this->load->model('task_model','',TRUE);
        
    $task = array('task_id' => $id, 'status' => 3);
    $this->task_model->finish_task($task);

	redirect('task/main', 'refresh');
}
    
function finishtask_today()
{
    $id = $this->uri->segment(3);
    
    $this->load->model('task_model','',TRUE);
        
    $task = array('task_id' => $id, 'status' => 3);
    $this->task_model->finish_task($task);

	redirect('main', 'refresh');
}
    
function gottask()
{
    $id = $this->uri->segment(3);
    
    $this->load->model('task_model','',TRUE);
        
    $task = array('task_id' => $id, 'status' => 1);
    $this->task_model->finish_task($task);

	redirect('task/main', 'refresh');
}

function gottask_notification()
{
    $id = $this->uri->segment(3);
    
    $this->load->model('task_model','',TRUE);
        
    $task = array('task_id' => $id, 'status' => 1);
    $this->task_model->finish_task($task);

	redirect('task/notification', 'refresh');
}
 
function canceltask()
{
    $id = $this->uri->segment(3);
    
    $this->load->model('task_model','',TRUE);
        
    $task = array('task_id' => $id, 'status' => 2);
    $this->task_model->finish_task($task);

	redirect('task/main', 'refresh');
}
    
function canceltask_today()
{
    $id = $this->uri->segment(3);
    
    $this->load->model('task_model','',TRUE);
        
    $task = array('task_id' => $id, 'status' => 2);
    $this->task_model->finish_task($task);

	redirect('main', 'refresh');
}
    
function nexttask()
{
    $data['tasknext_array'] = $this->task_model->getTaskNext($this->session->userdata('sessid'));
    $data['numstatus5'] = $this->num;
    $data['title'] = "NGG|IT Nerd - Next Tasks";
    $this->load->view('task/nexttask',$data);
}
    
function notification()
{
    $data['tasknotification_array'] = $this->task_model->getTaskNotification($this->session->userdata('sessid'));
    $data['numstatus5'] = $this->num;
    $data['title'] = "NGG|IT Nerd - Notification Tasks";
    $this->load->view('task/notification',$data);
}
    
function teamtask()
{
    $data['task_array'] = $this->task_model->getTaskTeam_today($this->session->userdata('sessid'),$this->session->userdata('sessteam'));
    $data['tasklate_array'] = $this->task_model->getTaskTeam_late($this->session->userdata('sessid'),$this->session->userdata('sessteam'));
    $data['tasktomorrow_array'] = $this->task_model->getTaskTeam_tomorrow($this->session->userdata('sessid'),$this->session->userdata('sessteam'));
    $data['title'] = "NGG|IT Nerd - Team Tasks";
    $this->load->view('task/teamtask',$data);
}

function myteam()
{
    $this->load->model('user','',TRUE);
    $data['user_array'] = $this->user->getTeamOtherUserID($this->session->userdata('sessid'),$this->session->userdata('sessteam'));
    $data['title'] = "NGG|IT Nerd - My Team";
    $this->load->view('task/myteam',$data);
}
    
function viewtask_myteam()
{
    $id = $this->uri->segment(3);
    
    $this->load->model('user','',TRUE);
    $query = $this->user->getOneUser($id);
    foreach($query as $loop) { $data['firstname'] = $loop->firstname; $data['lastname'] = $loop->lastname; }
    
    $data['task_array'] = $this->task_model->getTaskToday($id);
    $data['tasklate_array'] = $this->task_model->getTaskLate($id);
    $data['tasktomorrow_array'] = $this->task_model->getTaskTomorrow($id);
    $data['tasknext_array'] = $this->task_model->getTaskNext($id);
    
    $data['title'] = "NGG|IT Nerd - Member Tasks";
    $this->load->view('task/myteam_task',$data);
}
    
}
?>