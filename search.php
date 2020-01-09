 <!--
|
|	File: index.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php
	$nspage = "index";

	require_once 'src/php/includes.php';
	
	require_once NSID_PLM_SRC_PHP . 'code_functions.php';
	require_once NSID_PLM_SRC_PHP . 'index_funtions.php';
	
	

	$db = new config_database();
	
	$mysqli = new mysqli( $db->host , $db->username , $db->password , $db->dbname , $db->port );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
?>


<?php

	$T			= get_check( 'T' 			, "_" 	);
	$G			= get_check( 'G' 			, "_" 	);
	$S 			= get_check( 'S' 			, "_" 	);
	$hist 	= get_check( 'hist'				, ""	);
	
	if ( $hist != "" )
		$//EEPROM 	= $hist;
	else
		$//EEPROM 	= get_check( '//EEPROM'				, $hist					);
	$order 	= get_check( 'order'	, "mod_desc"	);
	$src		= get_check( 'src'									);
	$action = get_check( 'action' 							);
	$limit	=	get_check( 'limit' 	, 20					);

	include NSID_PLM_SRC_PHP . 'navmenu.php';
?>

	<div class="insidecodelite">

		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		
	</div>



<?php
	include NSID_PLM_SRC_PHP . 'footer.php';
	$mysqli->close();
?>

