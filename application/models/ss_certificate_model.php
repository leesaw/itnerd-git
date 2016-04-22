<?php
Class Ss_certificate_model extends CI_Model
{
 function get_certificate($where)
 {
	$this->db->select("cer_id, cer_number, cer_naturaldiamond_id, cer_shape_id, cer_cuttingstyle_id, cer_measurement, cer_carat, cer_color_id, cer_clarity_id, cer_proportion_id, cer_symmetry_id, cer_polish_id, cer_totaldepth, cer_tablesize, cer_crownheight, cer_crownangle, cer_starlength, cer_paviliondepth, cer_pavilionangle, cer_lowerhalflength, cer_girdlethickness_id, cer_girdlefinish_id, cer_culet_id, cer_girdleinscription_id, cer_fluorescence_id, cer_softwareresult, cer_status, cer_enable, lcl_value as clarity, lco_value as color, lct_value as culet, lcs_value as cuttingstyle, lfu_value as fluorescence, lgf_value as girdlefinish, lgs_value as girdleinscription, lgt_value as girdlethickness, lnd_value as naturaldiamond, lpo_value as polish, lpt_value as proportion, lsh_value as shape, lsm_value as symmetry");
	$this->db->from("ss_certificate");
    $this->db->join("ss_list_clarity", "lcl_id = cer_clarity_id", "left");
    $this->db->join("ss_list_color", "lco_id = cer_color_id", "left");
    $this->db->join("ss_list_culet", "lct_id = cer_culet_id", "left");
    $this->db->join("ss_list_cuttingstyle", "lcs_id = cer_cuttingstyle_id", "left");
    $this->db->join("ss_list_fluorescence", "lfu_id = cer_fluorescence_id", "left");
    $this->db->join("ss_list_girdlefinish", "lgf_id = cer_girdlefinish_id", "left");
    $this->db->join("ss_list_girdleinscription", "lgs_id = cer_girdleinscription_id", "left");
    $this->db->join("ss_list_girdlethickness", "lgt_id = cer_girdlethickness_id", "left");
    $this->db->join("ss_list_naturaldiamond", "lnd_id = cer_naturaldiamond_id", "left");
    $this->db->join("ss_list_polish", "lpo_id = cer_polish_id", "left");
    $this->db->join("ss_list_proportion", "lpt_id = cer_proportion_id", "left");
    $this->db->join("ss_list_shape", "lsh_id = cer_shape_id", "left");
    $this->db->join("ss_list_symmetry", "lsm_id = cer_symmetry_id", "left");
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }

 function add_certificate($insert=NULL)
 {		
	$this->db->insert('ss_certificate', $insert);
	return $this->db->insert_id();			
 }
    
 function edit_certificate($edit=NULL)
 {
	$this->db->where('cer_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('ss_certificate', $edit); 	
	return $query;
 }
    
}
?>