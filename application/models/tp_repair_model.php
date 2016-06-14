<?php
Class Tp_repair_model extends CI_Model
{
 function get_repair($where)
 {
	$this->db->select("rep_id, rep_dateadd, rep_dateaddby, firstname, lastname, rep_remark, rep_cusname, rep_custelephone, rep_datein, rep_number, rep_shop_id, sh1.sh_code as shopin_code, sh1.sh_name as shopin_name, rep_brand_id, br_name, br_code, rep_refcode, rep_case, rep_datecs, rep_getfrom, rep_assess, rep_warranty, rep_price, rep_datedone, rep_datereturn, rep_return_shop_id, sh2.sh_code as shopreturn_code, sh2.sh_name as shopreturn_name, rep_responsename, rep_status, rep_enable");
	$this->db->from('tp_repair');
	$this->db->join('tp_shop sh1', 'rep_shop_id = sh1.sh_id','left');
    $this->db->join('tp_shop sh2', 'rep_return_shop_id = sh2.sh_id','left');	
    $this->db->join('tp_brand', 'rep_brand_id = br_id','left');
    $this->db->join('nerd_users', 'rep_dateaddby = id','left');	
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function add_repair($insert=NULL)
 {		
	$this->db->insert('tp_repair', $insert);
	return $this->db->insert_id();			
 }
    
 function add_log_repair($insert=NULL)
 {		
	$this->db->insert('log_repair', $insert);
	return $this->db->insert_id();			
 }

 function edit_repair($edit=NULL)
 {
	$this->db->where('rep_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_repair', $edit); 	
	return $query;
 }


}
?>