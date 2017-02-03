<?php
Class Tp_stockmovement_model extends CI_Model
{

 function get_stockmovement($sql)
 {
	$result = $this->db->query($sql, FALSE);
	return $result->result();
 }

}
?>
