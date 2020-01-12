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

	require_once 'includes.php';	
	
	

	$db = new config_database();
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
	// ---------------- PAGE GENERATION START
	
	
	echo open_block( "This is a block in class codelite" , "create.svg" );
	echo tag_enclosed( "p" , "An this is a text enclosed in a paragraph." , "padding-left: 30px;" );
	echo close_block();

	echo open_block( "This is a block in class insidecodelite" , "noimg.png" , "insidecodelite" );
	echo tag_enclosed( "p" , "An this is a text enclosed in a paragraph." , "padding-left: 30px;" );
	echo close_block();


	require_once NSID_PLM_SRC_TEMPLATE . 'footer.php';
	
	$mysqli->close();

?>

