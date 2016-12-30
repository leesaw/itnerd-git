<?php
Class Tp_saleperson_model extends CI_Model
{
 function getSalePerson($where)
 {
	$this->db->select("sp_id, sp_barcode, sp_firstname, sp_lastname, sp_shop_id, sh_name, sh_code, sp_username_id");
	$this->db->from('tp_sale_person');
	$this->db->join('tp_shop', 'sp_shop_id = sh_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

  function getSalePerson_sort_name($where)
 {
	$this->db->select("sp_id, sp_barcode, sp_firstname, sp_lastname, sp_shop_id, sh_name, sh_code, sp_username_id");
	$this->db->from('tp_sale_person');
	$this->db->join('tp_shop', 'sp_shop_id = sh_id','left');
    if ($where != "") $this->db->where($where);
    $this->db->order_by("sp_firstname", "asc");
	$query = $this->db->get();
	return $query->result();
 }

 function getBorrowerName()
 {
    $this->db->select("posbor_id, posbor_name");
    $this->db->from("tp_pos_rolex_borrower");
    $query = $this->db->get();
	return $query->result();
 }

 function addSalePerson($insert=NULL)
 {
	$this->db->insert('tp_sale_person', $insert);
	return $this->db->insert_id();
 }

 function delSalePerson($id=NULL)
 {
	$this->db->where('sp_id', $id);
	$this->db->delete('tp_sale_person');
 }

 function editSalePerson($edit=NULL)
 {
	$this->db->where('sp_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_sale_person', $edit);
	return $query;
 }

}
?>
