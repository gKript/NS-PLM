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
	$nspage = "phpinfo";

	require_once 'includes.php';
	$db = new config_database();
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
	
	require_once NSID_PLM_SRC_TEMPLATE . 'php_info.php';
	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
	if ( ( $_SESSION["clean_user"] == "guest" ) && ( ! $nscfg->param->user->guest_allowed ) ) 
		insert_blockquote( "Sorry but Guest user is not allowed here!<br/>Please, go to <a href=\"index.php\">home page</a> to log in." , "Error" , 1 );
?>

<div class="insidecodelite" >

<?php

 embedded_phpinfo();
 
?>

</div>

<?php
	include NSID_PLM_SRC_TEMPLATE . 'footer.php';
	$mysqli->close();
?>


