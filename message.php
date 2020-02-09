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
	$receiver = get_check( 'receiver' 		);
	$type			= get_check( 'type' 				);
	$action		= get_check( 'action' 			);
	$code			= get_check( 'code' 		   	);
	$nl				= get_check( 'nl'      			);
	$id				=	get_check( 'id'				, 0	);
	
	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
	// ---------------- PAGE GENERATION START
	
	if ( $action == "show" )
		query_sql_run( "UPDATE `notice` SET `active` = '0' WHERE `id` = $id;" );

	else if ( $action == "munread" ) {
		query_sql_run( "UPDATE `notice` SET `active` = '1' WHERE `id` = $id;" );
		$action = "show";
	}
	else if ( $action == "mread" ) {
		query_sql_run( "UPDATE `notice` SET `active` = '0' WHERE `id` = $id;" );
		$action = "show";
	}

	if ( ( $gk_Auth->check_user_level( "Modify" , "Code" ) ) && ( ( $nl > 0 ) && ( $nl < 5 ) ) ) {
		query_sql_run( "UPDATE `elenco_codici` SET `status` = '$nl' WHERE `elenco_codici`.`codice` LIKE '$promoter'" );
		if ( ( $action == "approved" ) || ( $action == "rejected" ) ) {
//			query_sql_run( "UPDATE `code_action` SET `done` = '1' WHERE `code_action`.`action` = 'review' AND `code_action`.`code` = '$code';" );
			query_sql_run( "DELETE FROM `notice` WHERE `type` LIKE 'Action required' AND `body` LIKE '%$promoter%'" );
		}
	}

	if ( $action == "approved" )
		insert_blockquote( "Code $code succesfully APPROVED!" , "Success" );
	else if ( $action == "rejected" )
		insert_blockquote( "Code $code is REJECTED and the new status is now DRAFT<br/>Write to the Promoter why you have rejected the code promotion and, eventually, what to change." , "Warning" );

	echo open_block_no_top( "Messages" , "" , "insidecodelite" );

		$I = $gk_Auth->get_current_user_name();
		$sql = "SELECT * FROM `notice` WHERE `receiver` LIKE '$I' AND `type` LIKE 'Message' ORDER BY `createTS` ASC Limit 0,10;";
		$rows = query_get_num_rows( $sql );
		if ( $rows ) {
			echo open_block( "Notices" , "message.svg" , "mcodelite" );
				echo table_open( 0 , "99%" , "" , "margin:1em;" );
					echo row_open();
						echo set_header_table( "Reply"			, 0 , "2%" , "text-align: center;" );
						echo set_header_table( "Read"			, 0 , "2%" , "text-align: center;" );
						echo set_header_table( "UnRead"		, 0 , "2%" , "text-align: center;" );
						echo set_header_table( "Delete"		, 0 , "2%" , "text-align: center;" );
						echo set_header_table( "Type" , 0 , "10%" , "text-align: center;" );
						echo set_header_table( "Sender" , 0 , "10%" , "text-align: center;" );
						echo set_header_table( "Title" , 0 , "22%" , "text-align: left;" );
						echo set_header_table( "Preview" , 0 , "50%" , "text-align: left;" );
					echo row_close();
					if ($result = $mysqli->query($sql)) {
						for( $r = 0 ; $r < $rows ; $r++ ) {
							echo row_open();
							$array = $result->fetch_array();
							
							echo set_col_table( link_generator( "message.php?action=mreply&id=".$array["id"] , img_generator( "reply.svg"	, "Reply" , "" , "height:16px;" ) )			, 0 , "2%" , "text-align: center;" );
							echo set_col_table( link_generator( "message.php?action=mread&id=".$array["id"]		, img_generator( "read.svg"		, "Mark as read"  , "" , "height:16px;" ) )	, 0 , "2%" , "text-align: center;" );
							echo set_col_table( link_generator( "message.php?action=munread&id=".$array["id"] , img_generator( "unread.svg"	, "Mark as unread" , "" , "height:16px;" ) )			, 0 , "2%" , "text-align: center;" );
							echo set_col_table( link_generator( "index.php?action=mdelete&id=".$array["id"]		, img_generator( "delete.svg"	, "Delete"  , "" , "height:16px;" ) )	, 0 , "2%" , "text-align: center;" );
							
							echo set_col_table( link_generator( "message.php?action=show&id=".$array["id"] , "Message" ) , 1 , "" , "text-align: center;" );
							if ( $array["active"] ) {
								echo set_col_table( tag_enclosed( "b" , $array['sender_clean'] ) , 1 , "" , "text-align: center;" );
								echo set_col_table( tag_enclosed( "b" , $array['head'] ) , 1 , "" );
								echo set_col_table( tag_enclosed( "b" , gk_text_trunc( $array['body'] , 60 ) ) , 1 );
							}
							else {
								echo set_col_table( $array['sender_clean'] , 1 , "" , "text-align: center;" );
								echo set_col_table( $array['head'] , 1 , "" );
								echo set_col_table( gk_text_trunc( $array['body'] , 60 ) , 1 );
							}
							echo row_close();
						}
					}
				echo table_close();
			echo close_block();
		}


		if ( $action == "show" ) {
			///			SHOW
			$sql = "SELECT * FROM `notice` WHERE `id` = $id";
			$array = query_single_line( $sql );
		
			echo open_block( "Message from ".$array["sender_clean"] , "create.svg" , "codelite" );
				echo BR(2);
				echo "Title:\n";
				echo BR();
				echo text_input_composer( "head" , stripslashes( $array["head"] ) , "" , "text" , 80 , 256 , 0 , "" , "" , "" , 1 );
				echo BR(2);
				echo "Message	:\n";
				echo BR();
				echo textarea( 10 , 81 , "body" , stripslashes( $array["body"] ) , "" , 1 );
			echo close_block();
		}
		else if ( $action == "Send" ) {
			///			SEND
			
			$sender = $gk_Auth->get_current_user_name();
			$csender = $gk_Auth->get_current_clean_user_name();
			
			$head = addslashes( $head );
			$body = addslashes( $body );
			
			$sql  = "INSERT INTO `notice` (`id`, `promoter`, `level`, `sender`, `sender_clean`, `receiver`, `type`, `head`, `body`, `link`, `active`, `createTS`, `modifyTS`) ";
			if ( $type == "rejection" ) 
				$sql .= "VALUES (NULL, '$promoter', '99', '$sender', '$csender', '$receiver', 'Rejection', '$head', '$body', NULL, '1', current_timestamp(), current_timestamp());";
			else
				$sql .= "VALUES (NULL, '$promoter', '99', '$sender', '$csender', '$receiver', 'Message', '$head', '$body', NULL, '1', current_timestamp(), current_timestamp());";
			
			query_sql_run( $sql );

			echo open_block( "Message Sent" , "send.svg" , "codelite" );
				echo BR(2);
				echo "Title:\n";
				echo BR();
				echo text_input_composer( "head" , stripslashes( $head ) , "" , "text" , 80 , 256 , 0 , "" , "" , "" , 1 );
				echo BR(2);
				echo "Message	:\n";
				echo BR();
				echo textarea( 10 , 81 , "body" , stripslashes( $body ) , "" , 1 );
			echo close_block();
		}	else if ( $action == "list" ) {
			///			LIST
		}
		else {
			///			FORM
			if ( $action == "reply" ) {
				$array = query_single_line( "SELECT * FROM `notice` WHERE `id` = $id;" );
				$newhead = "RE: ".$array["head"];
				$newbody = "\n\n\n\n------------------------\n".$array["body"];
				$receiver = $array["sender"];
			}
			echo open_block( "Send a new messages" , "create.svg" , "codelite" );
			echo BR();
			open_form( "GET" , "" , "" , "message" , "message" , 1 );
			echo "Sender:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $gk_Auth->get_current_clean_user_name();
			echo BR(2);
			if ( $action == "rejected" )
				echo "Receiver:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . query_get_a_field( "SELECT * FROM `gk_users` WHERE `user_login` LIKE '$receiver';" , "user_name" );
			else if ( $action == "reply" ) 
				echo "Receiver:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $array["sender_clean"];
			else {
				$sql = "SELECT `user_login`, `user_name` FROM `gk_users` WHERE `user_login` NOT LIKE '".$gk_Auth->get_current_user_name()."' ORDER BY `user_role`";
				select_composer_from_sql( "receiver" , "receiver" , 3 , $sql , 1 , "" , "" , "" , 0 , "Receiver: " , "SX" , "user_login" , "user_name" );
			}
			echo BR(2);
			echo "Title:\n";
			echo BR();
			if ( $action == "rejected" ) 
				echo text_input_composer( "head" , "$promoter: Promotion rejected" , "" , "text" , 80 , 256 , 1 , "" );
			else if ( $action == "reply" ) 
				echo text_input_composer( "head" , $newhead , "" , "text" , 80 , 256 , 1 , "" );
			else
				echo text_input_composer( "head" , "" , "" , "text" , 80 , 256 , 1 , "" );
			echo BR(2);
			echo "Message	:\n";
			echo BR();
			if ( $action == "reply" )
				echo textarea( 10 , 81 , "body" , $newbody );
			else
				echo textarea( 10 , 81 , "body" );
			echo BR(2);
			button( "submit" , "action" , "Send" );
			if ( $action == "rejected" ) {
				add_hidden( "type" , "rejection" );
				add_hidden( "receiver" , $receiver );
			}
			else if ( $action == "reply" ) {
				add_hidden( "receiver" , $receiver );
			}
			add_hidden( "promoter" , $promoter );
			close_form();
			echo close_block();
		}

	echo close_block();

	require_once NSID_PLM_SRC_TEMPLATE . 'footer.php';
	
	$mysqli->close();

?>




