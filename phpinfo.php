<!--
|
|	File: phpinfo.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php
	$gk_page = "phpinfo";
	
	define( 'NSID_PLM_TITLE'		,	'NextStep PLM' );
	define( 'NSID_PLM_SRC_PHP'	, 'src/php/');
	define( 'NSID_PLM_SRC_HTML'	, 'src/html/');
	define( 'NSID_PLM_SRC_CSS'	, 'src/css/');
	define( 'NSID_PLM_SRC_JS'	  , 'src/js/');
	define( 'NSID_PLM_SRC_IMG'  ,	'src/img/');

	require NSID_PLM_SRC_PHP.'includes.php';

	$db = new config_database();
	
	$mysqli = new mysqli( $db->host , $db->username , $db->password , $db->dbname , $db->port );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
	
	
	include NSID_PLM_SRC_PHP . 'navmenu.php';
?>

<div class="codelite" >

<?php

 embedded_phpinfo();
 
?>

</div>

<?php
	include NSID_PLM_SRC_PHP . 'footer.php';
	$mysqli->close();
?>


