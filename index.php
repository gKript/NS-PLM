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

	$action = get_check( 'action' );

	if ( $action == "logout" ) 
		$gk_Auth->gk_logout( session_id() );
	

	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
		
	echo div_block_open( "insidecodelite" );
	
	if ( 	$gk_Auth->first() == true ) {
		echo 		open_block( "Welcome" , "welcome.svg" );
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

	echo 		open_block( "Login information" );
	echo 		BR( 1, 0);

	if ( $gk_Auth->role == "guest" ) {
		
		if ( $ck ) {
			insert_blockquote( "Found authentication cookies for user [ ". tag_enclosed( "b" , $_COOKIE["GK_USER"] ) ." ].<br/>if it's not you, please, sign in with your credentials through the following form.<br/>Otherwise, continue working normally.<br/><br/>Bye<br/><br/>" , "Success" );
			echo BR( 1,0);
		}		
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
	echo div_block_close();
	}
	else {
		echo '<div class="subnav">'."\n";
		echo '<table width="500px">'."\n";
		echo '<tr>'."\n";
		$img = img_generator( "account.svg" , "account" , "" , "" , "autoclose" , 0 , 48 , 48 );
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

		echo open_block( "Dashboard" , "dashboard.svg" , "insidecodelite" );
//		echo div_block_open( "codelite" , "padding-left: 16px; padding-right: 16px;" );
		echo open_block_no_top( "Tasks to be performed" , "task.svg" );
		echo tag_enclosed( "p" , "The tasks you are involved in are the following:" ) ;
		echo 	BR(1,0);
		echo div_block_close();
		
		
		
		
		
		
		
	}
	echo div_block_close();
	
	include NSID_PLM_SRC_TEMPLATE . 'footer.php';
	$mysqli->close();
?>

