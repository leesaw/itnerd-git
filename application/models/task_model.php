<?php
Class Task_model extends CI_Model
{
function getAllTask($userid,$status)
{
	$this->db->select("task_id, topic, category.category_id, category.name as categoryname, u1.id as userid, u1.firstname as fname1, u1.lastname as lname1, detail, task.dateadd as taskdateadd, task.dateon as taskdateon, task.assign as assignid, u2.firstname as fname2, u2.lastname as lname2, task.status as task_status");
	$this->db->from("task");	
    $this->db->join("category", "category.category_id=task.category_id", "left");
    $this->db->join("users as u1", "u1.id=task.userid", "left");
    $this->db->join("users as u2", "u2.id=task.assign", "left");
    if ($userid > 0) {
        $this->db->where("task.userid", $userid);
    }
    if ($status > 0) {
        $this->db->where("(task.status=5 or task.status=".$status.")");
    }
    $query = $this->db->get();		
    return $query->result();
}

function addtask($task)
{		
	$this->db->insert('task', $task);
	return $this->db->insert_id();			
}

function getAllCategory()
{
    $this->db->select("category_id, name");
    $this->db->from("category");
    $query = $this->db->get();		
    return $query->result();
}
    
function finish_task($temp)
{
    $this->db->where('task_id', $temp['task_id']);
    unset($temp['task_id']);
    $query = $this->db->update('task', $temp); 	
    return $query;   
}

function ring_task($task_id, $condition)
{
    if ($condition=='plus') {
        $sql = "update task set ring=ring+1 where task_id='".$task_id."'";
    }elseif ($condition=='minus') {
        $sql = "update task set ring=ring-1 where task_id='".$task_id."'";
    }elseif ($condition=='clear') {
        $sql = "update task set ring=0 where task_id='".$task_id."'";
    }
    $query = $this->db->query($sql); 	
    return $query;
}
    
function getNumStatus5($userid)
{
    $this->db->select("task_id");
    $this->db->from("task");
    $this->db->where("status",5);
    $this->db->where("userid", $userid);
    $query = $this->db->get();		
    return $query->num_rows();
}
    
function getNumRing($userid)
{
    $this->db->select("ring");
    $this->db->from("task");
    $this->db->where("status",5);
    $this->db->where("userid", $userid);
    $query = $this->db->get();		
    return $query->num_rows();
}
    
function getTaskToday($userid)
{
    $today = date('Y-m-d');
        
    $this->db->select("task_id, topic, detail, name, userid, assign, date_format(dateon,'%d %M %Y') as dateon", FALSE);
    $this->db->from("task");
    $this->db->join("category", "category.category_id=task.category_id", "left");
    $this->db->where("status",1);
    $this->db->where("userid", $userid);
    $this->db->where("dateon between '".$today." 00:00:00' AND '".$today." 23:59:59'", NULL, FALSE);
    $this->db->order_by("task_id","asc");
    $query = $this->db->get();		
    return $query->result();
}
    
function getTaskLate($userid)
{
    $today = date('Y-m-d');
        
    $this->db->select("task_id, topic, detail, name, userid, assign, date_format(dateon,'%d %M %Y') as dateon", FALSE);
    $this->db->from("task");
    $this->db->join("category", "category.category_id=task.category_id", "left");
    $this->db->where("status",1);
    $this->db->where("userid", $userid);
    $this->db->where("dateon < '".$today." 00:00:00'", NULL, FALSE);
    $this->db->order_by("task_id","asc");
    $query = $this->db->get();		
    return $query->result();
}

function getTaskTomorrow($userid)
{
    $today = date('Y-m-d');
    $tmr = explode('-', $today);
    $tmr[2]+=1;
    $tmr= $tmr[0]."-".$tmr[1]."-".$tmr[2];
        
    $this->db->select("task_id, topic, detail, name, userid, assign, date_format(dateon,'%d %M %Y') as dateon", FALSE);
    $this->db->from("task");
    $this->db->join("category", "category.category_id=task.category_id", "left");
    $this->db->where("status",1);
    $this->db->where("userid", $userid);
    $this->db->where("dateon between '".$tmr." 00:00:00' AND '".$tmr." 23:59:59'", NULL, FALSE);
    $this->db->order_by("task_id","asc");
    $query = $this->db->get();		
    return $query->result();
}
    
function getTaskNext($userid)
{
    $today = date('Y-m-d');
    $tmr = explode('-', $today);
    $tmr[2]+=1;
    $tmr= $tmr[0]."-".$tmr[1]."-".$tmr[2];
        
    $this->db->select("task_id, topic, detail, name, userid, assign, date_format(dateon,'%d %M %Y') as dateon", FALSE);
    $this->db->from("task");
    $this->db->join("category", "category.category_id=task.category_id", "left");
    $this->db->where("status",1);
    $this->db->where("userid", $userid);
    $this->db->where("dateon > '".$tmr." 00:00:00'", NULL, FALSE);
    $this->db->order_by("task_id","asc");
    $query = $this->db->get();		
    return $query->result();
}
    
function getTaskNotification($userid)
{
    $this->db->select("task_id, topic, detail, name, userid, assign, date_format(dateon,'%d %M %Y') as dateon", FALSE);
    $this->db->from("task");
    $this->db->join("category", "category.category_id=task.category_id", "left");
    $this->db->where("status",5);
    $this->db->where("userid", $userid);
    $this->db->order_by("task_id","asc");
    $query = $this->db->get();		
    return $query->result();
}
    
function getTaskTeam_today($userid, $teamid)
{
    $today = date('Y-m-d');
    
    $this->db->select("task_id, topic, detail, category.name as name, userid, assign, date_format(dateon,'%d %M %Y') as dateon, firstname, lastname, ring", FALSE);
    $this->db->from("task");
    $this->db->join("users", "task.userid=users.id", "left");
    $this->db->join("category", "category.category_id=task.category_id", "left");
    $this->db->where("task.status",1);
    $this->db->where("userid !=", $userid);
    $this->db->where("team_id", $teamid);
    $this->db->where("dateon between '".$today." 00:00:00' AND '".$today." 23:59:59'", NULL, FALSE);
    $this->db->order_by("task_id","asc");
    $query = $this->db->get();		
    return $query->result();
}
    
function getTaskTeam_late($userid, $teamid)
{
    $today = date('Y-m-d');
    
    $this->db->select("task_id, topic, detail, category.name as name, userid, assign, date_format(dateon,'%d %M %Y') as dateon, firstname, lastname, ring", FALSE);
    $this->db->from("task");
    $this->db->join("users", "task.userid=users.id", "left");
    $this->db->join("category", "category.category_id=task.category_id", "left");
    $this->db->where("task.status",1);
    $this->db->where("userid !=", $userid);
    $this->db->where("team_id", $teamid);
    $this->db->where("dateon < '".$today." 00:00:00'", NULL, FALSE);
    $this->db->order_by("task_id","asc");
    $query = $this->db->get();		
    return $query->result();
}
    
function getTaskTeam_tomorrow($userid, $teamid)
{
    $today = date('Y-m-d');
    $tmr = explode('-', $today);
    $tmr[2]+=1;
    $tmr= $tmr[0]."-".$tmr[1]."-".$tmr[2];
    
    $this->db->select("task_id, topic, detail, category.name as name, userid, assign, date_format(dateon,'%d %M %Y') as dateon, firstname, lastname, ring", FALSE);
    $this->db->from("task");
    $this->db->join("users", "task.userid=users.id", "left");
    $this->db->join("category", "category.category_id=task.category_id", "left");
    $this->db->where("task.status",1);
    $this->db->where("userid !=", $userid);
    $this->db->where("team_id", $teamid);
    $this->db->where("dateon between '".$tmr." 00:00:00' AND '".$tmr." 23:59:59'", NULL, FALSE);
    $this->db->order_by("task_id","asc");
    $query = $this->db->get();		
    return $query->result();
}
    
}
?>