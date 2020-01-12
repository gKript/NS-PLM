<?php

//------------------------------------------------------------
//	gKript.org since 27/11/2001
//	gk_includes.php 
//	code by AsYntote	
//
//	Ver 0.10-x

	class config_database {
		
		
		public $host;
		public $username;
		public $password;
		public $dbname;
		public $port;

		function __construct() {
			$this->host = (string) "localhost";
			$this->username = (string) "root";
			$this->password = (string) "";
			$this->dbname = (string) "nsid_plm_data";
			$this->port = (int) 3306;
		}
	}

?>
