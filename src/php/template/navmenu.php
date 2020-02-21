<?php

	require_once NSID_PLM_SRC_TEMPLATE . 'index_funtions.php';

	DocType( "HTML 5" );
	html_open( "http://www.w3.org/1999/xhtml" );
	generic_tag_open( "head" );
	
	
	$rtime = $nscfg->param->redirect_time;
	if ( isset( $pagetime ) ) {
		$rtime = $pagetime;
	}

	$hist 	= get_check( 'hist'	, "" );
	if ( $hist != "" )
		$text 	= $hist;
	else
		$text 	= get_check( 'text'				, $hist					);
	
	//echo $hist . "  " . $text;

	$H = add_search_in_history( $text , $gk_Auth->get_current_user_name() );

	if ( ( $nspage == "code" ) || ( $nspage == "bom" ) || ( $nspage == "where_used" ) || ( $nspage == "code-insert" ) ) {
		if ( ( $nspage == "code" ) && ( $action == "Create" ) ) {
			echo tag_enclosed( "title" , NSID_PLM_TITLE . " - Create step 2" );
		}
		if ( ( $nspage == "code" ) && ( $action == "filter" ) ) {
			echo tag_enclosed( "title" , NSID_PLM_TITLE . " - Filtering" );
		}
		else if ( ( $nspage == "code" ) && ( $code == "0" ) ) {
			echo tag_enclosed( "title" , NSID_PLM_TITLE . " - Create step 1"  );
		}
		else {
			echo tag_enclosed( "title" , NSID_PLM_TITLE . " - " . $code );
		}
	}
	else 
		echo tag_enclosed( "title" , NSID_PLM_TITLE );
	
	println( "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />" );
	
	println( "<link rel=\"icon\" href=\"src/img/logo/ns-plm.ico\">" );
	println( "<link rel=\"shortcut icon\" href=\"src/img/logo/ns-plm.ico\">" );
	
	//CSS Locali
	link_css( "menu.css"     , NSID_PLM_SRC_CSS );
	link_css( "h.css"        , NSID_PLM_SRC_CSS );
	link_css( "body.css"     , NSID_PLM_SRC_CSS );
	link_css( "view.css"     , NSID_PLM_SRC_CSS );
	
	
	//CSS online
	link_css( "https://fonts.googleapis.com/css?family=Montserrat&display=swap"  , null , "online" );


	//CSS locali	
	link_js ( "view.js"				, NSID_PLM_SRC_JS  );
	link_js ( "calendar.js" 	, NSID_PLM_SRC_JS  );
	link_js ( "encryption.js"	, NSID_PLM_SRC_JS  );

	if ( $redirect ) {
		echo open_script( "text/javascript" );
		$js  = "function doRedirect() {\n";
		$js .= "location.href = \"$redirect_addy\"\n";
		$js .= "}\n";
		$js .= "window.setTimeout(\"doRedirect()\", ($rtime+1) * 1000 );\n";
		echo $js;
		echo close_script();

		echo open_script( "text/javascript" );
			$js   = "function startTimer(duration, display) { \n";
			$js  .= "	var timer = duration, minutes, seconds; \n";
			$js  .= "	setInterval(function () { \n";
			$js  .= "		seconds = parseInt(timer % 60, 10); \n";
			$js  .= "		seconds = seconds < 10 ? \"0\" + seconds : seconds; \n";
			$js  .= "		display.textContent = seconds; \n";
			$js  .= "		if (--timer < 0) { \n";
			$js  .= "				timer = duration; \n";
			$js  .= "		} \n";
			$js  .= "	}, 1000); \n";
			$js  .= "} \n";
			$js  .= "window.onload = function () { \n";
			$js  .= "	var mytime = $rtime, \n";
			$js  .= " display = document.querySelector('#time'); \n";
			$js  .= "	startTimer( mytime, display); \n";
			$js  .= "}; \n";
			echo $js;
		echo close_script();
	}

	echo generic_tag_close( "head" );
	echo generic_tag_open ( "body" );

	$back = "";
	$reload = 0;
	if ( isset( $_SERVER["HTTP_REFERER"] ) ) {
		$back = $_SERVER["HTTP_REFERER"];
		if ( $back == get_current_url() )
			$reload = 1;
	}
	echo div_block_open( "" , "" , "centerColumn" );
	echo div_block_open( "" , "" , "header" );
	echo table_open( 0 , "100%" );
	echo row_open();
	echo col_open( 0 , "20%" );
		if ( $nscfg->param->company->logo ) {
			echo link_generator( $nscfg->param->company->link , "" , $nscfg->param->company->target , "" , "open" ); 
			echo img_generator( "logo/".$nscfg->param->company->image , "logo" , "" ,  "float: left; vertical-align: middle; padding-right:32px; " , "autoclose" , 0 , $nscfg->param->company->heigth );
		}
		else {
			echo link_generator( "index.php" , "" , "" , "" , "open" ); 
			echo img_generator( "logo/ns-plm.png" , "nsplm logo" , "" ,  "float: left; vertical-align: middle; padding-right:32px; " , "autoclose" , 0 , 320 );
		}
		echo generic_tag_close( "a" );
	echo col_close();
	echo col_open( 0 , "" , "vertical-align:middle; " );
	echo tag_enclosed( "h1" , "Next Step PLM" );
	echo tag_enclosed( "h2" , tag_enclosed( "b" , "Product Lifecycle Management" ) . " by gKript.org" );
	echo col_close();
	echo col_open( 0 , "396px" , "vertical-align:middle; " );
	if ( $gk_Auth->get_current_user_name() == "guest" ) 
		echo div_block_open( "" , "padding:.5em; margin-right: -3; background-color: #edd; border:1px solid #999; box-shadow: 1px 2px 3px #999; border-radius: 10px 10px 10px 10px;" );
	else
		echo div_block_open( "" , "padding:.5em; margin-right: -3; background-color: #ddd; border:1px solid #999; box-shadow: 1px 2px 3px #999; border-radius: 10px 10px 10px 10px;" );

	if ( ( $gk_Auth->get_current_clean_user_name() != "guest" ) && ( $gk_Auth->get_image_flag() == true ) )
		echo img_generator( "users/".$gk_Auth->get_current_user_name().".jpg" , "user image" , "" , "border:1px solid #000; margin-bottom: 16px;float: right; box-shadow: 1px 2px 3px #999;  border-radius: 20px;" , "autoclose" , 0 , 46 , 46 );
	else
		echo img_generator( "account.svg" , "account icon" , "" , "margin-bottom: 16px;float: right;" , "autoclose" , 0 , 40 , 40 );

	println( "User: \n" . tag_enclosed( "big" , tag_enclosed( "b" , $gk_Auth->get_current_clean_user_name()		) ) );
	BR();
	println( "Role: " . $gk_Auth->get_current_user_role() );
	if ( $gk_Auth->get_current_clean_user_name() != "guest" ) {
		BR();
		$strlev = "Auth level: " . tag_enclosed( "b" ,$gk_Auth->get_current_user_level() );
		echo tag_enclosed( "small" , $strlev );
	}
	echo div_block_close();
	
	if ( $gk_Auth->get_current_clean_user_name() != "guest" ) {
		$loginmenu = new gkMenu( $nspage , $gk_Auth->get_current_user_level() );
		$loginmenu->set_output(1);
		$loginmenu->open( "navmenu" );
		$loginmenu->voice( "Change passw" , "password.php" );
		$loginmenu->separator(1);
		$loginmenu->voice( "Logout" , "index.php?action=logout" );
		$loginmenu->close();
	}
	echo col_close();
	echo row_close();
	echo table_close();
	echo div_block_close();

	if ( ( ( $gk_Auth->get_current_clean_user_name() != "guest" ) || ( $nscfg->param->user->guest_allowed ) ) || ( $ck ) ) {
		$mess = query_get_num_rows( "SELECT * FROM `notice` WHERE `receiver` LIKE '". $gk_Auth->get_current_user_name() ."' AND `type` LIKE 'Message' AND `active` = 1" );
		echo div_block_open( "" , "margin-left: 16px; margin-right: 16px; margin-bottom: 24px; margin-top: 24px;" );
		open_form( "GET" , "search.php" , "" , "" , "menu_srch" );
		$navmenu = new gkMenu( $nspage , $gk_Auth->get_current_user_level() );

		$navmenu->set_output(1);
		$navmenu->open( "navmenu" );
		
		if ( $mess ) {
			$navmenu->voice_icon( "mail.svg" , "Message" , 16 , 16 , 1 );	
//			$navmenu->separator(1);
		}
		$navmenu->voice( "Home" , "index.php" );
		$navmenu->separator(1);
		$navmenu->voice( "Search" , "search.php" );
		$navmenu->separator(1);
		$navmenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Code +" );
				$navmenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Change +" );
						$navmenu->voice( "Modify" 		, "" );
						$navmenu->voice( "Delete" 		, "" );
						$navmenu->voice( "Duplicate"	, "" );
				$navmenu->submenu_close();
				$navmenu->voice( "Create"	, "code.php?code=0&new=1" );
		$navmenu->submenu_close();
		$navmenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Supplier +" );
				$navmenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Change +" );
						$navmenu->voice( "Modify" 		, "" );
						$navmenu->voice( "Delete" 		, "" );
						$navmenu->voice( "Duplicate"	, "" );
				$navmenu->submenu_close();
				$navmenu->voice( "Create"	, "code.php?code=0&new=1" );
		$navmenu->submenu_close();		
		$navmenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Report +" );
				$navmenu->voice( "Code" 		, "" );
				$navmenu->voice( "B.O.M." 		, "" );
				$navmenu->voice( "Supplier"	, "" );
				$navmenu->voice( "Charts"	, "" );
				$navmenu->voice( "Statistics"	, "" );
		$navmenu->submenu_close();		
		$navmenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Info +" );
				$navmenu->voice( "Code concept" 		, "code_concept.php" );
				$navmenu->voice( "Related contexts" 		, "rules.php" );
				$navmenu->voice( "About & License"	, "info.php" );
				$navmenu->voice( "PHP info"	, "phpinfo.php" );
		$navmenu->submenu_close();
		$navmenu->voice( "Quick Filter"	, "code.php?code=0&action=filter" );
		$navmenu->voice( "Message"	, "message.php" );
		$navmenu->separator(1);
		$navmenu->voice( "Back"	, $back );
		$navmenu->separator(1);
		if ( $H ) { 
			echo generic_tag_open( "li" , "" , "float:right;" );
			echo generic_tag_open( "a" );
			$user = $gk_Auth->get_current_user_name();
			$sql = "SELECT * FROM `search` WHERE `user` LIKE '$user' ORDER BY `search`.`createTS` DESC";
			$result = query_get_result( $sql );
			if ( $result ) {
				$loop = ITEMS_IN_HISTORY;
				if ( $result->num_rows != ITEMS_IN_HISTORY )
					$loop = $result->num_rows;
				select_option( "reset" );
				for( $r = 0 ; $r < $loop ; $r++ ) {
					$row = $result->fetch_array();
					select_option( "insert" , $row["search"] , $row["search"] );
				}
				select_composer_from_array( "hist" , "hist" , 1 , "" , "this.form.submit()" , "" , 0 , "History: " );
			}
			echo generic_tag_close( "a" );
			echo generic_tag_close( "li" );
		}
		$navmenu->separator(10);
		echo generic_tag_open( "li" , "" , "float:right;" );
		echo generic_tag_open( "a" );
		text_input_composer( "text" , $text , "" , "Text"   , "" , "" , 1 , "" , "Search " , "before" , 0 , "border-radius: 5px;" );
		button( "Submit" , "src" , "Go" , 0 , "" , "border-radius: 5px;" );
		echo generic_tag_close( "a" );
		echo generic_tag_close( "li" );
		$navmenu->close();
		close_form();
		echo div_block_close();
		
	}
	
	$c =  stat_CodeCountDaily();
	$c += stat_AttribCountDaily();
	$c += stat_BomCountDaily();
	
	if ( $c )
		insert_blockquote( "Daily statistics updated!" , "Blockquote");
	
//		emphasis( "" , "Page reloaded!" );
//	if ( $reload )
//		insert_blockquote( "Page reloaded!" );

?>
		
		
		
		
		