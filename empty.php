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

	require_once NSID_PLM_SRC_TEMPLATE . 'code_functions.php';
	require_once( NSID_PLM_SRC_TEMPLATE . "codemenu.php" );


	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
	// ---------------- PAGE GENERATION START
	
	echo open_block( "Title class codelite" , "create.svg" );
	echo 		tag_enclosed( "span" , "An this is a text enclosed in a paragraph." , "margin-left: 16px;" );
	echo close_block();

	require_once NSID_PLM_SRC_TEMPLATE . 'footer.php';
	
	$mysqli->close();

?>


