<?php
Class Tp_repair_model extends CI_Model
{
 function get_repair($where)
 {
	$this->db->select("rep_id, rep_dateadd, rep_dateaddby, firstname, lastname, rep_remark, rep_cusname, rep_custelephone, rep_datein, rep_number, rep_shop_id, IF(rep_shop_id = 99999 , 'OTHER', sh1.sh_code) as shopin_code, IF(rep_shop_id = 99999 , 'อื่น ๆ', sh1.sh_name) as shopin_name, rep_brand_id, IF(rep_brand_id = 99999 , 'OTHER', br_code) as br_code, IF(rep_brand_id = 99999 , 'อื่น ๆ', br_name) as br_name, rep_refcode, rep_case, rep_datecs, rep_getfrom, rep_assess, rep_dateassess, rep_warranty, rep_price, rep_datedone, rep_datereturn, rep_return_shop_id,  IF(rep_return_shop_id = 99999 , 'OTHER', sh2.sh_code) as shopreturn_code, IF(rep_return_shop_id = 99999 , 'อื่น ๆ', sh2.sh_name) as shopreturn_name, rep_responsename, rep_status, rep_enable", FALSE);
	$this->db->from('tp_repair');
	$this->db->join('tp_shop sh1', 'rep_shop_id = sh1.sh_id','left');
    $this->db->join('tp_shop sh2', 'rep_return_shop_id = sh2.sh_id','left');	
    $this->db->join('tp_brand', 'rep_brand_id = br_id','left');
    $this->db->join('nerd_users', 'rep_dateaddby = id','left');	
    if ($where != "") $this->db->where($where);
    $this->db->order_by('rep_datein');
	$query = $this->db->get();		
	return $query->result();
 }

 function get_summary_status($where)
 {
 	$this->db->select("rep_status, count(*) as count1", FALSE);
	$this->db->from('tp_repair');
	$this->db->join('tp_shop sh1', 'rep_shop_id = sh1.sh_id','left');
    $this->db->join('tp_shop sh2', 'rep_return_shop_id = sh2.sh_id','left');	
    $this->db->join('tp_brand', 'rep_brand_id = br_id','left');
    $this->db->join('nerd_users', 'rep_dateaddby = id','left');	
    if ($where != "") $this->db->where($where);
    $this->db->group_by('rep_status');
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
	$this->db->where('rep_id', $edit['rep_id']);
	unset($edit['rep_id']);
	$query = $this->db->update('tp_repair', $edit); 	
	return $query;
 }


}
?>