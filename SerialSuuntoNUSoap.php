<?php
		require_once("dist/lib/nusoap.php");

		define("DBSERVER","localhost");
		define("DBUSERNAME","ab66792_rolex");
		define("DBPASSWORD","rolexudon04032016");
		define("DBNAME","ab66792_rolex");

		//Create a new soap server
		$server = new soap_server();

		//Define our namespace
		//$namespace = "http://localhost/nusoap-master/index.php";
		//$server->wsdl->schemaTargetNamespace = $namespace;

		//Configure our WSDL
		$server->configureWSDL("SerialSuuntoSOAP", "urn:SerialSuuntoSOAP");


		 $server->wsdl->addComplexType(
	       'SerialSuunto',
	       'complexType',
	       'struct',
	       'all',
	       '',
	       array(
	         'serial' => array(
	           'name' => 'official', 'type' => 'xsd:decimal'),
	       )
	   );

		$server->register(
						"CheckSerialSuunto", array("username" => "xsd:string", "password" => "xsd:string", "serial_input" => "xsd:string"), array("return" => "tns:SerialSuunto"), "urn:SerialSuuntoSOAP", "urn:SerialSuuntoSOAP#CheckSerialSuunto", "rpc", "encoded",
            "Check Serial Suunto"
		);

		function CheckSerialSuunto($username, $password, $serial) {

			 $connect_db = mysql_connect(DBSERVER,DBUSERNAME,DBPASSWORD) or die('Not connected : ' . mysql_error());
			 $db_name = mysql_select_db(DBNAME, $connect_db) or die('Not connected : ' . mysql_error());
			 $query = mysql_query("select * from nerd_users where username like '".$username."' and password like '".md5($password)."' and enable = 1 and status = 0", $connect_db);
			 $num = mysql_num_rows($query);

			 if ($num > 0) {
					$query1 = mysql_query("select * from tp_item_serial left join tp_item on it_id = itse_item_id where itse_serial_number like '".$serial."' and it_brand_id = '896'", $connect_db);

					$return = array();
					$cal = array();
					$index = 0;
					while ($row = mysql_fetch_array($query1, MYSQL_ASSOC)) {
							$index++;
              break;
					}
					$return['serial'] = $index;
					return $return;
			 }
			 else
			 {
					return array('serial' => 0);
			 }
		}


		// Get our posted data if the service is being consumed
		// otherwise leave this data blank.
		$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';


		// pass our posted data (or nothing) to the soap service
		$server->service($POST_DATA);
		exit();
?>
