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
	
	$action = get_check( 'action' 							);
	$id			=	get_check( 'id'					, 0				);

	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
	// ---------------- PAGE GENERATION START
	
	echo open_block( "Messages" , "" , "insidecodelite" );


	if ( $gk_Auth->check_user_level( "Review" , "Code" ) ) {
		$I = $gk_Auth->get_current_user_name();
		$sql = "SELECT * FROM `notice` WHERE `receiver` LIKE '$I' AND `active` = 1 AND `type` LIKE 'message' ORDER BY `createTS` ASC Limit 0,10;";
		$rows = query_get_num_rows( $sql );
		if ( $rows ) {
		?>
			<?php
				echo open_block( "Notices" , "message.svg" );
			?>

				<table style="margin:1em;" width="95%">
					<tr>
						<th style="text-align: center;" >Type</th>
						<th style="text-align: left;" >Sender</th>
						<th style="text-align: left;" >Title</th>
						<th style="text-align: left;" >Preview</th>
					</tr>


		<?php

			if ($result = $mysqli->query($sql)) {
				for( $r = 0 ; $r < $rows ; $r++ ) {
					println( "<tr>" );
					$array = $result->fetch_array();
					print( "<td style='text-align: center; border:1px solid #999;' width='10%'>" );
					if ( $array["type"] == "message" )
						echo link_generator( "message.php?action=show&id=".$array["id"] , "Message" );
					println( "</td>" );
					println( "<td style='border:1px solid #999;' width='10%'>" . $array['sender_clean'] . "</td>" );
					println( "<td style='border:1px solid #999;' width='25%'>" . $array['head'] . "</td>" );
					println( "<td style='border:1px solid #999;' >" . gk_text_trunc( $array['body'] , 60 ) . "</td>" );
					println( "</tr>" );
				}
			}
		?>		
				</table>
			</div>
	<?php
		}
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
	else if ( $action == "send" ) {
		///			INSERT
		echo open_block( "Messages" , "message.svg" , "codelite" );
		
		echo close_block();
	}
	else {
		///			FORM
		echo open_block( "Send a new messages" , "create.svg" , "codelite" );
		echo BR();
		open_form( "GET" , "" , "" , "message" , "message" , 1 );
		echo "Sender:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $gk_Auth->get_current_clean_user_name();
		echo BR(2);
		$sql = "SELECT `user_login`, `user_name` FROM `gk_users` WHERE `user_login` NOT LIKE '".$gk_Auth->get_current_user_name()."' ORDER BY `user_role`";
		select_composer_from_sql( "receiver" , "receiver" , 3 , $sql , 1 , "" , "" , "" , 0 , "Receiver: " , "SX" , "user_login" , "user_name" );
		echo BR(2);
		echo "Title:\n";
		echo BR();
		echo text_input_composer( "head" , "" , "" , "text" , 80 , 256 , 1 , "" );
		echo BR(2);
		echo "Message	:\n";
		echo BR();
		echo textarea( 10 , 81 , "body" );
		close_form();
		echo close_block();
	}
	


	echo close_block();

	require_once NSID_PLM_SRC_TEMPLATE . 'footer.php';
	
	$mysqli->close();

?>


