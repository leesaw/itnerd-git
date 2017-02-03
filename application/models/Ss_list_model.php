<?php
Class Ss_list_model extends CI_Model
{
 function get_list_clarity()
 {
	$this->db->select("lcl_id as id, lcl_value as value, lcl_enable as enable");
	$this->db->from("ss_list_clarity");
    $this->db->where("lcl_enable", 1);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function get_list_color()
 {
	$this->db->select("lco_id as id, lco_value as value, lco_enable as enable");
	$this->db->from("ss_list_color");
    $this->db->where("lco_enable", 1);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function get_list_culet()
 {
	$this->db->select("lct_id as id, lct_value as value, lct_enable as enable");
	$this->db->from("ss_list_culet");
    $this->db->where("lct_enable", 1);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function get_list_cuttingstyle($where)
 {
	$this->db->select("lcs_id as id, lcs_value as value, lcs_enable as enable");
	$this->db->from("ss_list_cuttingstyle");
    $this->db->where("lcs_enable", 1);
    if ($where != "") $this->db->where($where);
    $this->db->order_by("value", "asc");
	$query = $this->db->get();		
	return $query->result();
 }
    
 function get_list_fluorescence()
 {
	$this->db->select("lfu_id as id, lfu_value as value, lfu_enable as enable");
	$this->db->from("ss_list_fluorescence");
    $this->db->where("lfu_enable", 1);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function get_list_girdlefinish()
 {
	$this->db->select("lgf_id as id, lgf_value as value, lgf_enable as enable");
	$this->db->from("ss_list_girdlefinish");
    $this->db->where("lgf_enable", 1);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function get_list_girdleinscription()
 {
	$this->db->select("lgs_id as id, lgs_value as value, lgs_enable as enable");
	$this->db->from("ss_list_girdleinscription");
    $this->db->where("lgs_enable", 1);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function get_list_girdlethickness()
 {
	$this->db->select("lgt_id as id, lgt_value as value, lgt_enable as enable");
	$this->db->from("ss_list_girdlethickness");
    $this->db->where("lgt_enable", 1);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function get_list_naturaldiamond()
 {
	$this->db->select("lnd_id as id, lnd_value as value, lnd_enable as enable");
	$this->db->from("ss_list_naturaldiamond");
    $this->db->where("lnd_enable", 1);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function get_list_polish()
 {
	$this->db->select("lpo_id as id, lpo_value as value, lpo_enable as enable");
	$this->db->from("ss_list_polish");
    $this->db->where("lpo_enable", 1);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function get_list_proportion()
 {
	$this->db->select("lpt_id as id, lpt_value as value, lpt_enable as enable");
	$this->db->from("ss_list_proportion");
    $this->db->where("lpt_enable", 1);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function get_list_shape($where)
 {
	$this->db->select("lsh_id as id, lsh_value as value, lsh_enable as enable");
	$this->db->from("ss_list_shape");
    $this->db->where("lsh_enable", 1);
    if ($where != "") $this->db->where($where);
    $this->db->order_by("value", "asc");
	$query = $this->db->get();		
	return $query->result();
 }
    
 function get_list_symmetry()
 {
	$this->db->select("lsm_id as id, lsm_value as value, lsm_enable as enable");
	$this->db->from("ss_list_symmetry");
    $this->db->where("lsm_enable", 1);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function get_list_symbol()
 {
	$this->db->select("lsy_id as id, lsy_value as value, lsy_picture as picture, lsy_enable as enable");
	$this->db->from("ss_list_symbol");
    $this->db->where("lsy_enable", 1);
    $this->db->order_by("value");
	$query = $this->db->get();		
	return $query->result();
 }
    
 function add_list_shape($insert)
 {
    $this->db->insert("ss_list_shape", $insert);
    return $this->db->insert_id();
 }
    
 function add_list_cutting($insert)
 {
    $this->db->insert("ss_list_cuttingstyle", $insert);
    return $this->db->insert_id();
 }

}
?>