<?php
Class User extends CI_Model
{
 function login($username, $password)
 {
   $this -> db -> select('id, username, password, firstname, lastname, status, is_rolex, shop_id');
   $this -> db -> from('nerd_users');
   $this -> db -> where('username', $username);
   $this -> db -> where('password', MD5($password));
   $this -> db -> where('status >', 0);
   $this -> db -> where('enable', 1);
   $this -> db -> limit(1);

   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
function checkpass($id, $password)
 {
   $this -> db -> select('username');
   $this -> db -> from('nerd_users');
   $this -> db -> where('id', $id);
   $this -> db -> where('password', $password);
   $this -> db -> limit(1);

   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return true;
   }
   else
   {
     return false;
   }
 }
 
 function getUsers()
 {
	$this->db->select("id, username, firstname, lastname, status, team_id");
	$this->db->order_by("id", "asc");
	$this->db->from('nerd_users');	
	$this->db->where('status >', 0);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getAllUsers()
 {
	$this->db->select("id, username, firstname, lastname, status, team_id, ngg_worker_id, ngg_company_id, ngg_position_id, ngg_department_id, approval_status");
	$this->db->order_by("id", "asc");
	$this->db->from('nerd_users');	
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getUsers_team($teamid)
 {
	$this->db->select("id, username, firstname, lastname, status");
	$this->db->order_by("id", "asc");
	$this->db->from('nerd_users');	
	$this->db->where('status >', 0);
    $this->db->where('team_id', $teamid);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneUser($id=NULL)
 {
	$this->db->select("id, username, firstname, lastname, status, is_rolex, shop_id");
	$this->db->from('nerd_users');			
	$this->db->where('id', $id);	
	$query = $this->db->get();		
	return $query->result();
 }
    
 function checkUsername($username=NULL)
 {
	$this->db->select("id");
	$this->db->from('nerd_users');			
	$this->db->where('username', $username);	
	$query = $this->db->get();		
	return $query->num_rows();
 }
 
 function addUser($user=NULL)
 {		
	$this->db->insert('nerd_users', $user);
	return $this->db->insert_id();			
 }
 
 function delUser($id=NULL)
 {
	$this->db->where('id', $id);
	$this->db->delete('nerd_users'); 
 }
 
 function editUser($user=NULL)
 {
	$this->db->where('id', $user['id']);
	unset($user['id']);
	$query = $this->db->update('nerd_users', $user); 	
	return $query;
 }
 
 function banUser($id=NULL)
 {
	$this->db->where('id', $id);
	$user = array(
				'status' => 0
			);
	$query = $this->db->update('nerd_users', $user); 	
	return $query;
 }
    
 function getTeamOtherUserID($userid, $teamid)
 {
    $this->db->select("id, firstname, lastname");
    $this->db->from("nerd_users");
    $this->db->where("id !=", $userid);
    $this->db->where("team_id", $teamid);
    $query = $this->db->get();		
	return $query->result();
 }
    
 function addLogLogin($user=NULL)
 {
	$query = $this->db->insert('log_user_login', $user); 	
	return $query;
 }

}
?>