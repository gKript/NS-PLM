  <!--
|
|	File: check.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php

	$nspage = "check";

	require_once 'includes.php';	

	$db = new config_database();
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

	$code = get_check( 'code' );

	if ( $code != "" )  {
		if ( ! $gk_Auth->check_user_level( "Approve" , "Code" ) ) {
			$back = "";
			if ( isset( $_SERVER["HTTP_REFERER"] ) ) {
				$back = $_SERVER["HTTP_REFERER"];
			}
			$redirect = true;
			if ( $back != "" )
				$redirect_addy = $back;
			else
				$redirect_addy = "index.php";
			$pagetime = 10;
		}
	}
	if ( ( $gk_Auth->get_current_user_name() == "guest" ) && ( ! $nscfg->param->user->guest_allowed ) ) {
		$redirect = true;
		$redirect_addy = "index.php";
		$pagetime = 10;
		insert_blockquote( "Sorry but Guest user is not allowed here!<br/>Please, go to <a href=\"index.php\">home page</a> to log in." , "Error" , 1 );
	}


	require_once NSID_PLM_SRC_TEMPLATE . 'code_functions.php';
	require_once NSID_PLM_SRC_TEMPLATE . "codemenu.php";
	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
	// ---------------- PAGE GENERATION START
	
	
	if ( $gk_Auth->check_user_level( "Approve" , "Code" ) ) {
	
		echo open_block( "Checking code" , "check.svg" , "insidecodelite" );
		echo 		tag_enclosed( "span" , "This page is intended to check if all the code componets were duly filled." , "margin-left: 16px;" );
		echo BR();
		echo 		tag_enclosed( "span" , "It is up to you checking whether the meaning of the inserted data is correct." , "margin-left: 16px;" );
		
		echo 		generic_tag_open( "blockquote" , "code" );
		echo 			tag_enclosed( "h1" , tag_enclosed( "span" , substr($code, 0, 3) . "  " . substr($code, 3, 5) . "  " . substr($code, 8, 2) , "" , "blink_text" ) );
		echo 		generic_tag_close( "blockquote" );	
	
	
		echo 	open_block( "Mandatory components by policies" , "components.svg" );
		
		$array = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'" );
		synopsis( $code , $array["abbreviazione"] , $array["descrizione"] , "" , 0 );
		echo close_block();
		code_structure( $code , 3 );
//		echo close_block();
		
		echo BR( 1 , 1 , "clearfix" );
		
		echo		div_block_open( "box50" , "margin-top:2em; float: left; background-color:#ddd; height: 300px; border:1px solid #999; " );
		echo 		table_open( 1 , "100%" , "" , "padding: 1em;" );
		echo 			row_open( "border: 1 solid black; " );
		echo 				col_open( 0 , "25%" , "background-color:#bbb; border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		echo					tag_enclosed( "b" , "Component" );
		echo 				col_close();
		echo 				col_open( 0 , "65%" , "background-color:#bbb; border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		echo					tag_enclosed( "b" , "Value" );
		echo 				col_close();
		echo 				col_open( 0 , "10%" , "background-color:#bbb; border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		echo					tag_enclosed( "b" , "Result" );
		echo 				col_close();
		echo 			row_close();
		
		echo 			row_open( "border: 1 solid black; " );
		echo 				col_open( 0 , "25%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		echo					tag_enclosed( "b" , "Code" );
		echo 				col_close();
		echo 				col_open( 0 , "65%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		echo					$code;
		echo 				col_close();
		echo 				col_open( 0 , "10%" , "background-color:#bfb; border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		echo					"OK";
		echo 				col_close();
		echo 			row_close();

		echo 			row_open( "border: 1 solid black; " );
		echo 				col_open( 0 , "25%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		echo					tag_enclosed( "b" , "Short description" );
		echo 				col_close();
		echo 				col_open( 0 , "65%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		echo					$array["abbreviazione"];
		echo 				col_close();
		if ( $array["abbreviazione"] != "" ) {
			echo 				col_open( 0 , "10%" , "background-color:#bfb; border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
			echo					"OK";
			}
		else {
			echo 				col_open( 0 , "10%" , "background-color:#fbb; border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
			$tx  = 			generic_tag_open( "span" , "blink_text" );
			$tx .= 				"Not OK!";
			$tx .= 			generic_tag_close( "span" );
			echo $tx;
		}
		echo 				col_close();
		echo 			row_close();

		echo 			row_open( "border: 1 solid black; " );
		echo 				col_open( 0 , "25%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		echo					tag_enclosed( "b" , "Long description" );
		echo 				col_close();
		echo 				col_open( 0 , "65%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		echo					$array["descrizione"];
		echo 				col_close();
//		echo 				col_open( 0 , "10%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		if ( $array["descrizione"] != "" ) {
			echo 				col_open( 0 , "10%" , "background-color:#bfb; border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
			echo					"OK";
			}
		else {
			echo 				col_open( 0 , "10%" , "background-color:#fbb; border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
			$tx  = 			generic_tag_open( "span" , "blink_text" );
			$tx .= 				"Not OK!";
			$tx .= 			generic_tag_close( "span" );
			echo $tx;
		}
		echo 				col_close();
		echo 			row_close();

		echo 			row_open( "border: 1 solid black; " );
		echo 				col_open( 0 , "25%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		echo					tag_enclosed( "b" , "It is the last revision?" );
		echo 				col_close();
		echo 				col_open( 0 , "65%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		echo					"Latest revision is: " . substr( get_latest_revision( $code ) , 8 , 2 );
		echo 				col_close();
//		echo 				col_open( 0 , "10%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
	if ( substr( get_latest_revision( $code ) , 8 , 2 ) == substr($code, 8, 2) ) {
			echo 				col_open( 0 , "10%" , "background-color:#bfb; border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
			echo					"OK";
			}
		else {
			echo 				col_open( 0 , "10%" , "background-color:#ff8; border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
			$tx  = 			generic_tag_open( "span" , "blink_text" );
			$tx .= 				"Not OK!";
			$tx .= 			generic_tag_close( "span" );
			echo $tx;
		}
		echo 				col_close();
		echo 			row_close();

		echo 			row_open( "border: 1 solid black; " );
		echo 				col_open( 0 , "25%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		echo					tag_enclosed( "b" , "Attributes" );
		echo 				col_close();
		echo 				col_open( 0 , "65%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		if ( check_attributes_presence( $code ) )
			echo					"Present";
		else
			echo					"NOT present";
		echo 				col_close();
//		echo 				col_open( 0 , "10%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		if ( check_attributes_presence( $code ) ) {
			echo 				col_open( 0 , "10%" , "background-color:#bfb; border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
			echo					"OK";
			}
		else {
			echo 				col_open( 0 , "10%" , "background-color:#fbb; border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
			$tx  = 			generic_tag_open( "span" , "blink_text" );
			$tx .= 				"Not OK!";
			$tx .= 			generic_tag_close( "span" );
			echo $tx;
		}
		echo 				col_close();
		echo 			row_close();


		echo 			row_open( "border: 1 solid black; " );
		echo 				col_open( 0 , "25%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		echo					tag_enclosed( "b" , "Weight attributes" );
		echo 				col_close();
		echo 				col_open( 0 , "65%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		$wip = check_weight_attribute_presence( $code );
		if ( $wip )
			echo					"Present";
		else
			echo					"NOT present";
		echo 				col_close();
//		echo 				col_open( 0 , "10%" , "border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
		if ( $wip ) {
			echo 				col_open( 0 , "10%" , "background-color:#bfb; border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
			echo					"OK";
			}
		else {
			echo 				col_open( 0 , "10%" , "background-color:#ffb; border:1px solid #999;  height:38px; text-align: center; text-justify: inter-word;" );
			echo					"NOT OK";
		}
		echo 				col_close();
		echo 			row_close();


		echo 		table_close();
		echo 		div_block_close();
		$approve = "<a href=\"code.php?code=$code&action=approved\"><h1 style= \"text-align: center\" ><b>Approve</b></h1></a>\n";
		$reject  = "<a href=\"code.php?code=$code&action=rejected\"><h1 style= \"text-align: center\" ><b>Reject</b></h1></a>\n";
		echo		div_block_open( "box25" , "vertical-align: middle;margin-top:2em; float: right; background-color:#faa; height: 300px; border:1px solid #999; " );
		echo 				tag_enclosed( "p" , $reject , "margin-top: 110px; vertical-align: middle;margin-left: auto;"  );
		echo 		div_block_close();
		echo		div_block_open( "box25" , "vertical-align: middle;margin-top:2em; float: right; background-color:#afa; height: 300px; border:1px solid #999; " );
		echo 				tag_enclosed( "p" , $approve  , "margin-top: 110px; vertical-align: middle;margin-left: auto;"  );
		echo 		div_block_close();

		
		echo 	close_block();
		
		
	
		echo close_block();

	}
	else {
		insert_blockquote( "You haven't the necessary privileges to perform this action.<br/><br/>If you are thinking there's something wrong please, contact the system administrator!<br/>For security policy, this event is logged.<br/>Please wait! You will be redirected to the previous page in  <b><span id=\"time\">$pagetime</span></b> seconds." , "Caution" );
	}	

	require_once NSID_PLM_SRC_TEMPLATE . 'footer.php';
	
	$mysqli->close();

?>


