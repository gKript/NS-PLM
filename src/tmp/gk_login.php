<?php
//	Preliminary operations
	define( GK_PATH	, './');
	$gk_page = "gk_log";
	require GK_PATH.'gk_includes.php';
	$cache		= new gk_Cache( $gk_page );
	$template	= new gk_Template();
	$site		= $config->{$tpl->name};
	$css		= $tpl->css;
	$logo		= $tpl->logo;

//	Page generation

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

	if ( ! isset( $_POST["register"] ) )
		gk_site_open( "./templates/".$tpl->css , "./templates/".$tpl->logo , "index.php" , 2 );
	else
		gk_site_open( "./templates/".$tpl->css , "./templates/".$tpl->logo );

	gk_left_open();
 		gk_v_menu( $gk_page );
// 		gk_login_box();
// 		gk_rss_box();
	gk_left_close();
	gk_right_open();
		if ( ! isset( $_POST["register"] ) ) {
			$gk_Auth->gk_debug( $gk_Auth->user."<br>" );
			$gk_Auth->gk_debug( $gk_Auth->role."<br>" );
			if ( $gk_Auth->role == GK_USER_GUEST ) {
					$_SESSION["user"] = "guest";
					$_SESSION["role"] = GK_USER_GUEST;
					$_SESSION["pass"] = "guest";
					echo "<h2>You are NOT logged in as user ".$_POST["user_login"]."</h2><br>Yor are a GUEST<br><br>Wait. In a few seconds you will be redirected.<br><br>";
			}
			else {
					$_SESSION["user"] = $_POST["user_login"];
					$_SESSION["pass"] = md5( $_POST["user_password"] );
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
					gk_news_out_open( "Welcome" , "" , $out );
					gk_news_out_close();
			}
		}
		else {
			echo "<h2>Register</h2><br>New registration in progress...<br><br>";
		}
	gk_right_close();
	gk_main_close();
	gk_body_close();
	gk_html_close();
	
?>
