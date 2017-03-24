<?php
Class Tp_rolex_model extends CI_Model
{
 function getCustomerInfo($where)
 {
   if ($where != "") {
       $query = $this->db->query("select * from (SELECT posro_customer_name as name, posro_customer_address as address, posro_customer_tel as tel
     FROM `tp_pos_rolex` union SELECT DISTINCT posrot_customer_name as name, posrot_customer_address as address, posrot_customer_tel as tel
     FROM `tp_pos_rolex_temp`) as a where name !='-' and ".$where." group by name");
   }else{
     $query = $this->db->query("select * from (SELECT posro_customer_name as name, posro_customer_address as address, posro_customer_tel as tel
   FROM `tp_pos_rolex` union SELECT DISTINCT posrot_customer_name as name, posrot_customer_address as address, posrot_customer_tel as tel
   FROM `tp_pos_rolex_temp`) as a where name !='-' group by name");
   }
   return $query->result();
 }


}
?>
