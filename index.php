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

	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
		
	echo div_block_open( "insidecodelite" );
	
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



	echo 		open_block( "Login information" , "account.svg" );
	echo 		BR( 1, 0);
//		$gk_Auth->gk_debug( $gk_Auth->user."<br>" );
//		$gk_Auth->gk_debug( $gk_Auth->role."<br>" );
		if ( $gk_Auth->role == GK_USER_GUEST ) {
				$_SESSION["user"] = "guest";
				$_SESSION["role"] = GK_USER_GUEST;
				$_SESSION["pass"] = "guest";
				if ( ! isset( $_POST["register"] ) )
					echo "<br /><b>You are NOT logged in.</b> You are a GUEST<br><br>";
				else
					echo "<br /><h4>You are NOT logged in as user ".$_POST["user_login"]."</h4> You are a GUEST<br><br>";
		}
		else {
//				$_SESSION["user"] = $_POST["user_login"];
//				$_SESSION["pass"] = md5( $_POST["user_password"] );
				$out = "Welcome ".$_SESSION["clean_user"].". You are ";
				switch ( $gk_Auth->role ) {
						case GK_USER_ADMIN :
								$out .= "ADMINISTRATOR<br>";
								break;
						case GK_USER_SUPER :
								$out .= "SUPER USER<br>";
								break;
						case GK_USER_USER :
								$out .= "USER<br>";
								break;
				}
				$out .= "Click <a href=\"index.php\">here</a> to continue<br><br>Wait. In a few seconds you will be redirected.<br><br>";
		}


		if ( $gk_Auth->role == "guest" ) {
			echo '<div>'."\n";
			echo '  <form method="post" action="index.php">'."\n";
			echo '   <table width="30%">'."\n";
			echo '     <tr>'."\n";
			echo '       <td class="user">User name</td>'."\n";
			echo '       <td class="input"><input type="text" name="user_login" size="12" /></td>'."\n";
			echo '     </tr>'."\n";
			echo '     <tr>'."\n";
			echo '       <td class="user">Password</td>'."\n";
			echo '       <td class="input"><input type="password" name="user_password" size="12"/></td>'."\n";
			echo '     </tr>'."\n";
			echo '     <tr>'."\n";
			echo '       <td class="user">Remember me</td>'."\n";
			echo '       <td class="input"><input type="checkbox" name="autologin"></input></td>'."\n";
			echo '     </tr>'."\n";
			echo '     <tr>'."\n";
			echo '      <td class="user">&nbsp;</td>'."\n";
			echo '      <td class="input">
							<input type="submit" value="Login" />
						</td>'."\n";
			echo '     </tr>'."\n";
/*							<input type="hidden" value="Register" name="register" /> */
			echo '   </table>'."\n";
			echo '  </form>'."\n";
			echo '</div>'."\n";
			echo '<div class="stripes"><span></span></div>'."\n";
		}
		else {
			echo '<div class="subnav">'."\n";
			echo '   <table width="30%">'."\n";
			echo '     <tr>'."\n";
			echo '       <td class="user">User name</td>'."\n";
			echo '       <td class="input">'.$gk_Auth->get_current_clean_user_name().'</td>'."\n";
			echo '     </tr>'."\n";
			echo '     <tr>'."\n";
			echo '       <td class="user">Role</td>'."\n";
			echo '       <td class="input">'.$gk_Auth->get_current_user_role().'</td>'."\n";
			echo '     </tr>'."\n";
			echo '   </table>'."\n<br />\n";
			echo '   <form action="gk_logout.php" method="POST">'."\n";
//			echo '     <input type="submit" value="'.$gk_Auth->get_current_clean_user_name().' logout" />'."\n";
   			echo '   </form>'."\n";
			echo '</div>'."\n";
			echo '<div class="stripes"><span></span></div>'."\n";
		}


	echo 		div_block_close();
	echo div_block_close();
	
	include NSID_PLM_SRC_TEMPLATE . 'footer.php';
	$mysqli->close();
?>

