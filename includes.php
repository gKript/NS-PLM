<?php

//------------------------------------------------------------
//	gKript.org since 27/11/2001
//	gk_includes.php 
//	code by AsYntote	
//
//	Ver 0.10-x

	define( 'NSID_PLM_TITLE'	,	'NS-PLM' );	
	define( 'NSID_ONLINE'			, false );
	
	$using_gkphp = true;

//	--- gkphp
	require_once( "gk.php" );


	echo "&nbsp;";
	
//	--- template

	define( 'NSID_PLM_SRC_TEMPLATE'	, 'src/php/template/');
	define( 'NSID_PLM_SRC_HTML'			, 'src/html/');
	define( 'NSID_PLM_SRC_CSS'			, 'src/css/');
	define( 'NSID_PLM_SRC_JS'	  		, 'src/js/');
	define( 'NSID_PLM_SRC_IMG'  		,	'src/img/');
	
	define( 'ITEMS_IN_HISTORY'			,	10				);

	require_once( NSID_PLM_SRC_TEMPLATE . "codemenu.php" );
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
	

	ConfigurationLoader::update( "configuration/nsplm_config.xml" , "configuration/nsplm_config.php" );
	require_once( "configuration/nsplm_config.php" );
	$nscfg = new ns();

	if ( NSID_ONLINE )
		$nsDb = $nscfg->db->online;
	else
		$nsDb = $nscfg->db->loop;

	define	( 'NS_DB_NAME'		, $nsDb->dbname );
	define	( 'NS_DB_SERVER'	, $nsDb->host );
	define	( 'NS_DB_USER'		, $nsDb->username );
	define	( 'NS_DB_PASS'		, $nsDb->password );
	define	( 'NS_DB_PORT'		,	$nsDb->port );
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

		if ( ! isset( $_SESSION["user"] ) ) {
			$_SESSION["user"]				= "guest";
			$_SESSION["clean_user"]	= "guest";
			$_SESSION["pass"]				= "guest";
			$_SESSION["role"]				= "guest";
			$_SESSION["auth"]				= false;
			
			if ( isset( $_COOKIE["GK_USER"] ) ) {
				echo "Cookie!!<br>";
				$gk_Auth = new gkAuthentication( $_COOKIE["GK_USER"] , $nscfg->param->user->md5_passw , $nscfg->param->user->auth_debug );
			}
			else
				$gk_Auth = new gkAuthentication( $_SESSION["user"] , $nscfg->param->user->md5_passw , $nscfg->param->user->auth_debug );
		}
		else {
			$_SESSION["auth"] = true;
			$gk_Auth = new gkAuthentication( $_SESSION["user"] , $nscfg->param->user->md5_passw , $nscfg->param->user->auth_debug );
		}	

?>