<!--
|
|	File: gk.php
|
|	gKript.org  -  gKript php library
|	! asy
|	R 00.001
|	Code: 53B0000200
|
-->


<?php


	// Where am I installed ?
		define( 'GKPHP_PATH' , 'src/php/gkphp/');
		$gkconfpath = GKPHP_PATH . "config/";
		define( 'GKPHP_CFG_PATH' , $gkconfpath );
		unset( $gkconfpath );


	require_once( GKPHP_PATH . "Configuration_gk.php" );
	require_once( GKPHP_PATH . "Date_gk.php" );
	require_once( GKPHP_PATH . "Forms_gk.php" );
	require_once( GKPHP_PATH . "Html_gk.php" );
	require_once( GKPHP_PATH . "Menu_gk.php" );
	require_once( GKPHP_PATH . "Mysqli_gk.php" );
	require_once( GKPHP_PATH . "QRcode_gk.php" );
	require_once( GKPHP_PATH . "Table_gk.php" );
	require_once( GKPHP_PATH . "Utils_gk.php" );
	
	if( ( ! isset( $using_gkphp ) ) || ( $using_gkphp == false ) ) {
		gkphp_error_page();
	}
	
	ConfigurationLoader::update( GKPHP_CFG_PATH."gk_cfg.xml" , GKPHP_CFG_PATH."gk_cfg.php" );
	require_once( GKPHP_CFG_PATH."gk_cfg.php" );
	$gkcfg = new gk();
	
	$db = new config_database();

	if( $gkcfg->param->session )
		session_start();

	if( $gkcfg->param->authentication->enable ) {
		require_once( GKPHP_PATH . "Authentication_gk.php" );
	}
	
	
	define	( 'GK_STATUS'		, $gkcfg->info->status );
	define	( 'GK_SUBMINOR'	, $gkcfg->info->subminor );
	define	( 'GK_VERSION'	, $gkcfg->info->version.'-'.GK_STATUS.'-'.GK_SUBMINOR );
	define	( 'GK_DEBUG'		, $gkcfg->info->debug );



	function	gkphp_error_page() {
		echo generic_tag_open( "!DOCTYPE html" );
		echo generic_tag_open( "html" );
		echo generic_tag_open( "body" );
		echo div_block_open( ""  , "	margin:1em; background-color:#f44; border:1px solid #999; box-shadow: 1px 2px 3px #999; border-radius: 10px 10px 10px 10px;" );
		echo tag_enclosed( "h2" , "Error!!!" , "padding: 1em;" );
		$link = link_generator( substr( "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] , 0 , -6 ) , "here" );
		println( "You cannot call directly a gK.php library file. Try clicking $link.");
		echo BR( 2 );
		echo div_block_close();
		echo generic_tag_close( "body" );
		echo generic_tag_close( "html" );
		die();
	}


?>