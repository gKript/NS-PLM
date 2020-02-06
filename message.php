  <!--
|
|	File: message.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php

	$nspage = "message";

	require_once 'includes.php';	
	
	

	$db = new config_database();
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

	require_once NSID_PLM_SRC_TEMPLATE . 'code_functions.php';
	require_once NSID_PLM_SRC_TEMPLATE . 'codemenu.php';
	
	$head			= get_check( 'head' 				);
	$body			= get_check( 'body' 				);
	$promoter = get_check( 'promoter' 		);
	$receiver = get_check( 'receiver' , $promoter	);
	$action		= get_check( 'action' 			);
	$code			= get_check( 'code' 		   	);
	$nl				= get_check( 'nl'      			);
	$id				=	get_check( 'id'				, 0	);
	
	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
	// ---------------- PAGE GENERATION START

	if ( ( $gk_Auth->check_user_level( "Modify" , "Code" ) ) && ( ( $nl > 0 ) && ( $nl < 5 ) ) ) {
		query_sql_run( "UPDATE `elenco_codici` SET `status` = '$nl' WHERE `elenco_codici`.`codice` LIKE '$code'" );
		if ( ( $action == "approved" ) || ( $action == "rejected" ) ) {
			query_sql_run( "UPDATE `code_action` SET `done` = '1' WHERE `code_action`.`action` = 'review' AND `code_action`.`code` = '$code';" );
			query_sql_run( "UPDATE `notice` SET `active` = '0' WHERE `type` LIKE 'Action required' AND `body` LIKE '%$code%'" );
		}
	}

	if ( $action == "approved" )
		insert_blockquote( "Code $code succesfully APPROVED!" , "Success" );
	else if ( $action == "rejected" )
		insert_blockquote( "Code $code is REJECTED and the new status is now DRAFT<br/>Write to the Promoter why you have rejected the code promotion and, eventually, what to change." , "Warning" );

	echo open_block( "Messages" , "" , "insidecodelite" );

		$I = $gk_Auth->get_current_user_name();
		$sql = "SELECT * FROM `notice` WHERE `receiver` LIKE '$I' AND `active` = 1 AND `type` LIKE 'message' ORDER BY `createTS` ASC Limit 0,10;";
		$rows = query_get_num_rows( $sql );
		if ( $rows ) {
			echo open_block( "Notices" , "message.svg" );
				echo table_open( 0 , "95%" , "" , "margin:1em;" );
					echo row_open();
						echo set_header_table( "Type" , 0 , "" , "text-align: center;" );
						echo set_header_table( "Sender" , 0 , "" , "text-align: left;" );
						echo set_header_table( "Title" , 0 , "" , "text-align: left;" );
						echo set_header_table( "Preview" , 0 , "" , "text-align: left;" );
					echo row_close();
					if ($result = $mysqli->query($sql)) {
						for( $r = 0 ; $r < $rows ; $r++ ) {
							echo row_open();
							$array = $result->fetch_array();
							if ( $array["type"] == "message" )
								echo set_col_table( link_generator( "message.php?action=show&id=".$array["id"] , "Message" ) , 1 , "10%" , "text-align: center;" );
							else
								echo set_col_table( "" , 1 , "10%" , "text-align: center;" );
							echo set_col_table( $array['sender_clean'] , 1 , "10%" );
							echo set_col_table( $array['head'] , 1 , "25%" );
							echo set_col_table( gk_text_trunc( $array['body'] , 60 ) , 1 );
							echo row_close();
						}
					}
				echo table_close();
			echo close_block();
		}


		if ( $action == "show" ) {
			///			VIEW

			$sql = "SELECT * FROM `notice` WHERE `id` = $id";
			$array = query_single_line( $sql );
		
			echo open_block( "Message from ".$array["sender_clean"] , "create.svg" , "codelite" );
				echo BR(2);
				echo "Title:\n";
				echo BR();
				echo text_input_composer( "head" , $array["head"] , "" , "text" , 80 , 256 , 0 , "" , "" , "" , 1 );
				echo BR(2);
				echo "Message	:\n";
				echo BR();
				echo textarea( 10 , 81 , "body" , $array["body"] , "" , 1 );
			echo close_block();
		}
		else if ( $action == "Send" ) {
			///			INSERT
			
			$sender = $gk_Auth->get_current_user_name();
			$csender = $gk_Auth->get_current_clean_user_name();
			
			$sql  = "INSERT INTO `notice` (`id`, `promoter`, `level`, `sender`, `sender_clean`, `receiver`, `type`, `head`, `body`, `link`, `active`, `createTS`, `modifyTS`) ";
			$sql .= "VALUES (NULL, '', '99', '$sender', '$csender', '$receiver', 'message', '$head', '$body', NULL, '1', current_timestamp(), current_timestamp());";
			
			query_sql_run( $sql );

			echo open_block( "Message Sent" , "send.svg" , "codelite" );
				echo BR(2);
				echo "Title:\n";
				echo BR();
				echo text_input_composer( "head" , $head , "" , "text" , 80 , 256 , 0 , "" , "" , "" , 1 );
				echo BR(2);
				echo "Message	:\n";
				echo BR();
				echo textarea( 10 , 81 , "body" , $body , "" , 1 );
			echo close_block();
		}	else if ( $action == "list" ) {
			///			LIST
		}
		else {
			///			FORM
			echo open_block( "Send a new messages" , "create.svg" , "codelite" );
			echo BR();
			open_form( "GET" , "" , "" , "message" , "message" , 1 );
			echo "Sender:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $gk_Auth->get_current_clean_user_name();
			echo BR(2);
			if ( $action == "rejected" )
				echo "Receiver:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . query_get_a_field( "SELECT * FROM `gk_users` WHERE `user_login` LIKE '$promoter';" , "user_name" );
			else {
				$sql = "SELECT `user_login`, `user_name` FROM `gk_users` WHERE `user_login` NOT LIKE '".$gk_Auth->get_current_user_name()."' ORDER BY `user_role`";
				select_composer_from_sql( "receiver" , "receiver" , 3 , $sql , 1 , "" , "" , "" , 0 , "Receiver: " , "SX" , "user_login" , "user_name" );
			}
			echo BR(2);
			echo "Title:\n";
			echo BR();
			if ( $action == "rejected" ) 
				echo text_input_composer( "head" , "Promotion for code $code rejected" , "" , "text" , 80 , 256 , 1 , "" );
			else
				echo text_input_composer( "head" , "" , "" , "text" , 80 , 256 , 1 , "" );
			echo BR(2);
			echo "Message	:\n";
			echo BR();
			echo textarea( 10 , 81 , "body" );
			echo BR(2);
			button( "submit" , "action" , "Send" );
			add_hidden( "promoter" , $promoter );
			close_form();
			echo close_block();
		}

	echo close_block();

	require_once NSID_PLM_SRC_TEMPLATE . 'footer.php';
	
	$mysqli->close();

?>


