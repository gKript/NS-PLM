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
	
	require_once NSID_PLM_SRC_TEMPLATE . 'code_functions.php';
	require_once NSID_PLM_SRC_TEMPLATE . 'index_funtions.php';


	if ( isset( $_POST["autologin"] ) ) {
		if ( $_POST["autologin"] == "on" )
			$gk_Auth->autoconnect = true;
		else
			$gk_Auth->autoconnect = false;
	}

	if ( isset( $_POST["user_login"] ) ) {
		$gk_Auth->password_md5 = false;
		$gk_Auth->gk_clean_online_session_id();
		$gk_Auth->get_authentication( $_POST["user_login"] , $_POST["user_password"] );
	}

	$code		= get_check( 'code' );
	$action = get_check( 'action' );
	$ignore = get_check( 'ignore' , "false" );
	$id			= get_check( 'id' );
	
	
	if ( $action == "read" )
		query_sql_run( "UPDATE `notice` SET `active` = '0' WHERE `id` = $id;" );
	
	if ( $action == "logout" ) 
		$gk_Auth->gk_logout( session_id() );
	
	if ( ( $action == "attribute" ) && ( $ignore == "true" ) ) {
		$sql = "UPDATE `code_action` SET `ignore_it` = '1' WHERE `code_action`.`id` = $id";
		query_sql_run( $sql );
	}
	
	$redirect_addy = "index.php";

	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
		
	echo div_block_open( "insidecodelite" );
	
	if ( 	$gk_Auth->first() == true ) {
		echo 		open_block_no_top( "Welcome" , "welcome.svg" );
		$text  = 		"This page has been designed to start the activities.\n";
		$text .= 		BR(1,0);
		$text .= 		"You can start clicking a code from the table below or searching something.\n";
		$text .= 		BR(1,0);
		$text .= 		"The menu above is the best tool to start useing NS-PLM.\n";
		$text .= 		BR(2,0);
		$text .=		"Good work.";
		echo 				tag_enclosed( "p" , $text );
		echo 		div_block_close();
	}

	if ( $gk_Auth->role == "guest" )
		echo 		open_block_no_top( "Login" );
	else
		echo 		open_block_no_top( "Welcome back!" );
	
	echo 		BR( 1, 0);

	if ( $gk_Auth->role == "guest" ) {
		
		if ( $redirect ) {
			insert_blockquote( "Found authentication cookies for user [ ". tag_enclosed( "b" , $_COOKIE["GK_USER"] ) ." ].<br/>You will be signed in in 5 seconds. Please wait" , "Redirect" );
//			insert_blockquote( "Found authentication cookies for user [ ". tag_enclosed( "b" , $_COOKIE["GK_USER"] ) ." ].<br/>if it's not you, please, sign in with your credentials through the following form.<br/>Otherwise, continue working normally.<br/><br/>Bye<br/><br/>" , "Success" );
			echo BR( 1,0);
		}	
		else {
			echo '<div class="insidecodelite" style="width: 350px; padding: 10px" >'."\n";
			echo '  <form method="post" action="index.php">'."\n";
			echo '   <table width="100%">'."\n";
			echo '     <tr>'."\n";
			echo '       <td class="user">User name</td>'."\n";
			echo '       <td class="input"><input type="text" name="user_login" size="12" /></td>'."\n";
			echo '     </tr>'."\n";
			echo '     <tr>'."\n";
			echo '       <td class="user">Password</td>'."\n";
			echo '       <td class="input"><input type="password" name="user_password" size="12"/></td>'."\n";
			echo '     </tr>'."\n";
			if ( $ck_allowed ) {
				echo '     <tr>'."\n";
				echo '       <td class="user">Remember me</td>'."\n";
				echo '       <td class="input"><input type="checkbox" name="autologin"></input></td>'."\n";
				echo '     </tr>'."\n";
			}
			echo '     <tr>'."\n";
			echo '      <td class="user">&nbsp;</td>'."\n";
			echo '      <td class="input"><input type="submit" value="Login" /></td>'."\n";
			echo '     </tr>'."\n";
	/*		if ( ! $ck_allowed ) {
				echo "<input type=\"hidden\" value=\"0\" name=\"autologin\" />"
			}
	*/	echo '</table>'."\n";
			echo '</form>'."\n";
			echo '</div>'."\n";
			echo '<div class="stripes"><span></span></div>'."\n";
		}
	echo div_block_close();
	}
	else {
		echo '<div class="subnav">'."\n";
		echo '<table width="500px">'."\n";
		echo '<tr>'."\n";
		$img = img_generator( "people.svg" , "account" , "" , "" , "autoclose" , 0 , 48 , 48 );
		echo '<td rowspan="2">'.$img.'</td>'."\n";
		echo '<td class="user">User name:</td>'."\n";
		$tx = tag_enclosed( "big" , tag_enclosed( "b" , $gk_Auth->get_current_clean_user_name() ) );
		echo '<td class="input">'.$tx.'</td>'."\n";
		echo '</tr>'."\n";
		echo '<tr>'."\n";
		echo '<td class="user">Role:</td>'."\n";
		echo '<td class="input">'.$gk_Auth->get_current_user_role().'</td>'."\n";
		echo '</tr>'."\n";
		echo '</table>'."\n<br />\n";
		echo '<form action="gk_logout.php" method="POST">'."\n";
//			echo '     <input type="submit" value="'.$gk_Auth->get_current_clean_user_name().' logout" />'."\n";
			echo '   </form>'."\n";
		echo '</div>'."\n";
		echo div_block_close();
		echo div_block_close();

		echo open_block_no_top( "Dashboard" , "dashboard.svg" , "insidecodelite" );
//		echo div_block_open( "codelite" , "padding-left: 16px; padding-right: 16px;" );
//		echo open_block_no_top( "Tasks to be performed" , "task.svg" );
		echo tag_enclosed( "p" , "The tasks you are involved in are the following:" ) ;
//		echo 	BR(1,0);
	
		if ( $gk_Auth->get_current_user_name() != "guest" ) {
			$I = $gk_Auth->get_current_user_name();
			$lev = $gk_Auth->get_current_user_level();

			echo open_block( "Announcements" , "message.svg" , "codelite" );
			
				$sql = "SELECT *  FROM `notice` WHERE `receiver` LIKE '$I' AND `type` LIKE 'Approved' AND `active` = 1 ORDER BY `id` ASC ";
				$rows = query_get_num_rows( $sql );
				if ( $rows ) {
					echo open_block_no_top( "Promotions approved" , "ok" , "acodelite" );
						echo table_open( 0 , "95%" , "" , "margin:1em;" );
							echo row_open();
								echo set_header_table( "Approver"	, 0 , "" , "text-align: left;" );
								echo set_header_table( "Code"			, 0 , "" , "text-align: left;" );
								echo set_header_table( "Text"			, 0 , "" , "text-align: left;" );
							echo row_close();

							if ($result = $mysqli->query($sql)) {
								for( $r = 0 ; $r < $rows ; $r++ ) {
									echo row_open();
										$array = $result->fetch_array();
										println( "<td style='border:1px solid #999;' width='10%'>" . $array['sender_clean'] . "</td>" );
										println( "<td style='border:1px solid #999;' width='15%'>" . $array['promoter'] . "</td>" );
										println( "<td style='border:1px solid #999;' >" . gk_text_trunc( $array['body'] , 100 ) . "</td>" );
									echo row_close();
									
									$id = $array['id'];
									query_sql_run( "UPDATE `notice` SET `active` = '0' WHERE `id` = $id;" );
									
								}
							}
						echo table_close();
					echo close_block();
				}

			
				$sql = "SELECT * FROM `notice` WHERE `receiver` LIKE '$I' AND `active` = 1 AND `type` = 'Rejection' ORDER BY `createTS` ASC Limit 0,10";
				$rows = query_get_num_rows( $sql );
				if ( $rows ) {
					echo open_block_no_top( "Rejection" , "rejection" , "rcodelite" );
						echo table_open( 0 , "95%" , "" , "margin:1em;" );
							echo row_open();
								echo set_header_table( "Reply"		, 0 , "2%" , "text-align: center;" );
								echo set_header_table( "Read"			, 0 , "2%" , "text-align: center;" );
								echo set_header_table( "Type"			, 0 , "" , "text-align: center;" );
								echo set_header_table( "Sender"		, 0 , "" , "text-align: left;" );
								echo set_header_table( "Title"		, 0 , "" , "text-align: left;" );
								echo set_header_table( "Preview"	, 0 , "" , "text-align: left;" );
							echo row_close();

							if ($result = $mysqli->query($sql)) {
								for( $r = 0 ; $r < $rows ; $r++ ) {
									println( "<tr>" );
										$array = $result->fetch_array();
										
										echo set_col_table( link_generator( "message.php?action=reply&id=".$array["id"] , img_generator( "reply.svg" , "Reply to this message"  , "" , "height:16px;" ) )	, 0 , "2%" , "text-align: center;" );
										echo set_col_table( link_generator( "index.php?action=read&id=".$array["id"] , img_generator( "read.svg" , "Mark as read"  , "" , "height:16px;" ) )	, 0 , "2%" , "text-align: center;" );
										
										print( "<td style='text-align: center; border:1px solid #999;' width='10%'>" );
										$tx  = generic_tag_open( "span" , "blink_text" );
										$tx .= link_generator( "code.php?code=".$array["promoter"] , "Rejection" , "" , "" , "autoclose" , $array["head"]. "\n\n" . $array["body"] );
										$tx .= generic_tag_close( "span" );
										echo $tx;
										println( "</td>" );
										println( "<td style='border:1px solid #999;' width='10%'>" . $array['sender_clean'] . "</td>" );
										println( "<td style='border:1px solid #999;' width='15%'>" . $array['head'] . "</td>" );
										println( "<td style='border:1px solid #999;' >" . gk_text_trunc( $array['body'] , 100 ) . "</td>" );
									println( "</tr>" );
								}
							}
						echo table_close();
					echo close_block();
				}
		

				$sql = "SELECT * FROM `notice` WHERE `receiver` LIKE '$I' AND `active` = 1 AND `type` LIKE 'Message' ORDER BY `createTS` ASC Limit 0,10;";
				$rows = query_get_num_rows( $sql );
				if ( $rows ) {
					echo open_block_no_top( "Unread messages" , "chat" , "mcodelite" );
						echo table_open( 0 , "95%" , "" , "margin:1em;" );
							echo row_open();
								echo set_header_table( "Answ"			, 0 , "2%" , "text-align: center;" );
								echo set_header_table( "Read"			, 0 , "2%" , "text-align: center;" );
								echo set_header_table( "Type"			, 0 , "" , "text-align: center;" );
								echo set_header_table( "Sender"		, 0 , "" , "text-align: left;" );
								echo set_header_table( "Title"		, 0 , "" , "text-align: left;" );
								echo set_header_table( "Preview"	, 0 , "" , "text-align: left;" );
							echo row_close();

							if ($result = $mysqli->query($sql)) {
								for( $r = 0 ; $r < $rows ; $r++ ) {
									println( "<tr>" );
									
									$array = $result->fetch_array();
									
									if ( $array["type"] == "Message" ) {
										echo set_col_table( link_generator( "message.php?action=reply&id=".$array["id"] , img_generator( "reply.svg" , "Reply" , "" , "height:16px;" ) )			, 0 , "2%" , "text-align: center;" );
										echo set_col_table( link_generator( "index.php?action=read&id=".$array["id"] , img_generator( "read.svg" , "Mark as read"  , "" , "height:16px;" ) )	, 0 , "2%" , "text-align: center;" );
									}
									else {
										echo set_col_table( "" );
										echo set_col_table( "" );
									}
									
									print( "<td style='text-align: center; border:1px solid #999;' width='10%'>" );
									if ( $array["type"] == "Message" ) {
										$tx  = generic_tag_open( "span" , "blink_text" );
										$tx .= link_generator( "message.php?action=show&id=".$array["id"] , "Message" , "" , "" , "autoclose" , $array["head"]. "\n\n" . $array["body"] );
										$tx .= generic_tag_close( "span" );
										echo $tx;
									}
									else if ( $array["type"] == "Action required" )
										echo link_generator( $array["link"] , "Action required" , "" , "" , "autoclose" , strip_tags( $array["head"]. "\n\n" . $array["body"] ) );
									println( "</td>" );
									println( "<td style='border:1px solid #999;' width='10%'>" . $array['sender_clean'] . "</td>" );
									println( "<td style='border:1px solid #999;' width='15%'>" . $array['head'] . "</td>" );
									println( "<td style='border:1px solid #999;' >" . gk_text_trunc( $array['body'] , 100 ) . "</td>" );
									println( "</tr>" );
								}
							}
							
							echo table_close();
						echo close_block();
				}
				
				
				$sql = "SELECT * FROM `notice` WHERE `level` <= $lev AND `active` = 1 AND `type` LIKE 'Action required' ORDER BY `createTS` ASC Limit 0,10;";
				$rows = query_get_num_rows( $sql );
				if ( $rows ) {
					echo open_block_no_top( "Action required" , "action" , "wcodelite" );
						echo table_open( 0 , "95%" , "" , "margin:1em;" );
							echo row_open();
								echo set_header_table( "Type"			, 0 , "" , "text-align: center;" );
								echo set_header_table( "Title"		, 0 , "" , "text-align: left;" );
								echo set_header_table( "Preview"	, 0 , "" , "text-align: left;" );
							echo row_close();

							if ($result = $mysqli->query($sql)) {
								for( $r = 0 ; $r < $rows ; $r++ ) {
									println( "<tr>" );
									
									$array = $result->fetch_array();
									
									print( "<td style='text-align: center; border:1px solid #999;' width='10%'>" );
									if ( $array["type"] == "Message" ) {
										$tx  = generic_tag_open( "span" , "blink_text" );
										$tx .= link_generator( "message.php?action=show&id=".$array["id"] , "Message" , "" , "" , "autoclose" , strip_tags( $array["head"]. "\n\n" . $array["body"] ) );
										$tx .= generic_tag_close( "span" );
										echo $tx;
									}
									else if ( $array["type"] == "Action required" )
										echo link_generator( $array["link"] , "Action required" , "" , "" , "autoclose" , strip_tags( $array["head"]. "\n\n" . $array["body"] ) );
									println( "</td>" );
									println( "<td style='border:1px solid #999;' width='15%'>" . $array['head'] . "</td>" );
									println( "<td style='border:1px solid #999;' >" . gk_text_trunc( $array['body'] , 100 ) . "</td>" );
									println( "</tr>" );
								}
							}
							
							echo table_close();
						echo close_block();
				}

				
			echo close_block();
		}
	
	
	
		if ( $gk_Auth->check_user_level( "Review" , "Code" ) ) {
		
			$sql = "SELECT *  FROM `code_action` WHERE `action` LIKE 'review' AND `done` = 0 ORDER BY `code_action`.`createTS` ASC Limit 0,10;";
			$rows = query_get_num_rows( $sql );
			if ( $rows ) {
				echo open_block( "Code to be reviewed" , "review.svg" , "insidecodelite" );
			?>


					<table style="margin:1em;" width="95%">
						<tr>
							<th style="text-align: center;" >Code</th>
							<th style="text-align: left;" >Short desrciption</th>
							<th style="text-align: left;" >Long description</th>
						</tr>


			<?php

					if ($result = $mysqli->query($sql)) {
						for( $r = 0 ; $r < $rows ; $r++ ) {
							println( "<tr>" );
							$array = $result->fetch_array();
							$code = $array["code"];
							$ar = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code' " );
							print( "<td style='text-align: center; border:1px solid #999;' width='10%'>" );
							
							echo link_generator( "check.php?code=$code" , $code );
							println( "</td>" );
							println( "<td style='border:1px solid #999;' width='25%'>" . $ar['abbreviazione'] . "</td>" );
							println( "<td style='border:1px solid #999;' >" . $ar['descrizione'] . "</td>" );
							println( "</tr>" );
						}
					}
			?>		
					</table>
				</div>
		<?php
				}
			}
							
			if ( $gk_Auth->check_user_level( "Create" , "Attribute" ) ) {
				$sql = "SELECT *  FROM `code_action` WHERE `action` LIKE 'attribute' AND `ignore_it` = 0 ORDER BY `code_action`.`createTS` ASC Limit 0,10;";
				$rows = query_get_num_rows( $sql );
				if ( $rows ) {
					echo open_block( "Code without attributes" , "attributes.svg" , "codelite" );
				?>
					<table style="margin:1em;" width="95%">
						<tr>
							<th style="text-align: center;" >Code</th>
							<th style="text-align: left;" >Short desrciption</th>
							<th style="text-align: left;" >Long description</th>
						</tr>


				<?php

					if ($result = $mysqli->query($sql)) {
						for( $r = 0 ; $r < $rows ; $r++ ) {
							$array = $result->fetch_array();
							$code = $array["code"];
							if ( ! check_attributes_presence( $code ) ) {
								$ar = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code' " );
								println( "<tr>" );
								print( "<td style='text-align: center; border:1px solid #999;' width='10%'>" );
								echo link_generator( "attributes.php?code=$code&action=Create" , $code );
								println( "</td>" );
								println( "<td style='border:1px solid #999;' width='25%'>" . $ar['abbreviazione'] . "</td>" );
								println( "<td style='border:1px solid #999;' >" . $ar['descrizione'] . "</td>" );
								$ignore_id = $array["id"];
								$ln = link_generator( "index.php?action=attribute&ignore=true&id=$ignore_id" , "Ignore it" );
								println( "<td style='background-color:#ffb; text-align: center; border:1px solid #999;' width='5%'>" . $ln . "</td>" );
								println( "</tr>" );
							}
						}
					}
				}
				?>
					</table>
				</div>
				<?php
			}
//			echo div_block_close();
		}
	echo div_block_close();
				
	include NSID_PLM_SRC_TEMPLATE . 'footer.php';
	$mysqli->close();
?>
