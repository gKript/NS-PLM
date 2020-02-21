<?php

//------------------------------------------------------------
//	gKript.org since 27/11/2001
//	gk_includes.php 
//	code by AsYntote	
//
//	Ver 0.10-x

	define( 'NSID_PLM_TITLE'	,	'NS-PLM' );	
	define( 'NSID_ONLINE'			, false );
	

//	--- gkphp
	$using_gkphp = true;
	require_once( "gk.php" );					//	gK.php inclusion
	
//	--- template
	//echo "&nbsp;";

	define( 'NSID_PLM_SRC_TEMPLATE'	, 'src/php/template/');
	define( 'NSID_PLM_SRC_HTML'			, 'src/html/');
	define( 'NSID_PLM_SRC_CSS'			, 'src/css/');
	define( 'NSID_PLM_SRC_JS'	  		, 'src/js/');
	define( 'NSID_PLM_SRC_IMG'  		,	'src/img/');
	
	define( 'ITEMS_IN_HISTORY'			,	10				);

	require_once( NSID_PLM_SRC_TEMPLATE . "statistics.php" );
	require_once( NSID_PLM_SRC_TEMPLATE . "html_template.php" );
	
//	--- CLASSES

//	require_once( NSID_PLM_SRC_PHP."class/upload/class.upload.php" );

	$codetype = array(
   'T' => 0,
	 'Tname' => '',
   'CG' => 0,
	 'CGname' => '',
	 'CGdescr' => '',
	 'CS' => 0,
	 'CSname' => '',
	 'CSdescr' => '',
	 'bom' => 0
	);
	
	$cstatus_seq = array(
		
		0 => array( "p"=>0 , "n"=>0 , "t"=>"" ) ,
		1 => array( "p"=>0 , "n"=>3 , "t"=>"Draft" ) ,
		2 => array( "p"=>0 , "n"=>3 , "t"=>"Modified" ) ,
		3 => array( "p"=>1 , "n"=>4 , "t"=>"Under review" ) ,
		4 => array( "p"=>0 , "n"=>5 , "t"=>"Approved" ) ,
		5 => array( "p"=>4 , "n"=>0 , "t"=>"Stable" ) ,
		6 => array( "p"=>0 , "n"=>0 , "t"=>"Released" ) ,
		7 => array( "p"=>0 , "n"=>8 , "t"=>"End of life" ) ,
		8 => array( "p"=>0 , "n"=>0 , "t"=>"Obsolete" )
	);
	

	ConfigurationLoader::update( "configuration/nsplm_config.xml" , "configuration/nsplm_config.php" );
	require_once( "configuration/nsplm_config.php" );
	$nscfg = new ns();
	
	$ck_allowed = $gkcfg->param->authentication->cookie_allowed;
	$ck = false;

	if ( NSID_ONLINE )
		$nsDb = $nscfg->db->online;
	else
		$nsDb = $nscfg->db->loop;

	define	( 'NS_DB_NAME'		, $nsDb->dbname );
	define	( 'NS_DB_SERVER'	, $nsDb->host );
	define	( 'NS_DB_USER'		, $nsDb->username );
	define	( 'NS_DB_PASS'		, $nsDb->password );
	define	( 'NS_DB_PORT'		,	$nsDb->port );
	
	date_default_timezone_set( $nscfg->param->timezone );
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

	if ( isset( $_POST["user_login"] ) ) {
		$gk_Auth = new gkAuthentication( $_POST["user_login"] , $nscfg->param->user->md5_passw , $nscfg->param->user->auth_debug );
	}
	else if ( isset( $_SESSION["user"] ) ) {
		$_SESSION["auth"] = true;
		$gk_Auth = new gkAuthentication( $_SESSION["user"] , $nscfg->param->user->md5_passw , $nscfg->param->user->auth_debug );
	}
	else if ( ! isset( $_SESSION["user"] ) ) {
		$_SESSION["user"]				= "guest";
		$_SESSION["clean_user"]	= "guest";
		$_SESSION["pass"]				= "guest";
		$_SESSION["role"]				= "guest";
		$_SESSION["auth"]				= false;
		
		if ( $ck_allowed ) {
			
			if ( isset( $_COOKIE["GK_USER"] ) ) {
				$ck = true;
				$gk_Auth = new gkAuthentication( $_COOKIE["GK_USER"] , $nscfg->param->user->md5_passw , $nscfg->param->user->auth_debug );
			}
			else {
				$ck = false;
				$gk_Auth = new gkAuthentication( $_SESSION["user"] , $nscfg->param->user->md5_passw , $nscfg->param->user->auth_debug );
			}
		}
		else {
				$ck = false;
				$gk_Auth = new gkAuthentication( $_SESSION["user"] , $nscfg->param->user->md5_passw , $nscfg->param->user->auth_debug );
		}
	}
	else {
		$_SESSION["user"]				= "guest";
		$_SESSION["clean_user"]	= "guest";
		$_SESSION["pass"]				= "guest";
		$_SESSION["role"]				= "guest";
		$_SESSION["auth"]				= false;
	}

	$redirect = false;
	if ( ( $gk_Auth->get_current_user_name() == "guest" ) && ( isset( $_COOKIE["GK_USER"] ) ) ) {
		$redirect = true;
	}
	
//	check_code_review();
	check_code_without_attributes();
	
	require_once( NSID_PLM_SRC_TEMPLATE . "codemenu.php" );

?>
