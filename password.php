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

	$nspage = "password";

	require_once 'includes.php';	
	
	$db = new config_database();
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

	$redirect = false;
	if ( $gk_Auth->get_current_user_name() == "guest" ) {
		$redirect = true;
		$redirect_addy = "index.php";
		$pagetime = 10;
	}

	$oldp   = get_check( 'oldp' );
	$newp1  = get_check( 'newp1' );
	$newp2  = get_check( 'newp2' );
	$action = get_check( 'change' );

	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
	// ---------------- PAGE GENERATION START

	if ( $gk_Auth->get_current_user_name() == "guest" ) {
		echo open_block_no_top( "Guest not allowed! IP: " . $gk_Auth->gk_get_real_ip() , "security.svg" , "insidecodelite" );
			$mess  = "This page is for acknowledged users only.<br/><br/>";
			$mess .= "Please, contact the system administrator if you are thinking there's something wrong!<br/>";
			$mess .= "For security policy, this event is logged.<br/>Please wait! You are leaving this page and are redirected to the login one in  ";
			$mess .= "<b><span id=\"time\">$pagetime</span></b> seconds.";
			insert_blockquote( $mess , "Error" );
		echo close_block();
	}
	else {
		echo open_block( "Change password" , "key.svg" , "insidecodelite" );
		println ( "Action logged! Your IP is ".$gk_Auth->gk_get_real_ip() );
		echo BR( 4 );
		echo close_block();
	}
	require_once NSID_PLM_SRC_TEMPLATE . 'footer.php';
	
	$mysqli->close();

?>


