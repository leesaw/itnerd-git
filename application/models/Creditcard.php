<?php
Class Creditcard extends CI_Model
{
 function getCreditcard()
 {
	$this->db->select("cdc_id, cdc_name, cdc_remark");
	$this->db->order_by("cdc_name", "asc");
	$this->db->from('list_creditcard');
    $this->db->where('enable', 1);
	$query = $this->db->get();		
	return $query->result();
 }

}
?>