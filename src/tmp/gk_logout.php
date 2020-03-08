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
	
	$gk_Auth->gk_logout( session_id() );
	
	gk_site_open( "./templates/".$tpl->css , "./templates/".$tpl->logo , "index.php" , 2 );
	gk_left_open();
 		gk_v_menu( $gk_page );
// 		gk_login_box();
// 		gk_rss_box();
	gk_left_close();
	gk_right_open();
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
				$out = "<br>Thanks to have visited <h8>NS Core</h8><br><h8>Goodbye</h8><br><br>Wait. In a few seconds you will be redirected.<br><br>";
				gk_news_out_open( "Succesfully logout" , "" , $out );
				gk_news_out_close();
		}
	gk_right_close();
	gk_main_close();
	gk_body_close();
	gk_html_close();

?>
