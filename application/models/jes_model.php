<?php
Class Jes_model extends CI_Model
{
    function getActiveLicense()
    {
        $db2 = $this->load->database('db2',TRUE);
        $db2->select("SID, CONVERT(CHAR(19),LastUpdate) as LastUpdate");
        $db2->from('[JES_NGG].[dbo].[LicenseUsage]');
        $query = $db2->get();
        return $query->result();
    }
    
    function getUser($userid)
    {
        $db2 = $this->load->database('db2',TRUE);
        $db2->select("Username, UserFullName");
        $db2->from("[JES_NGG].[dbo].[User]");
        $db2->where("Username",$userid);
        $query = $db2->get();
        return $query->result();
    }

}
?>