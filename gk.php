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


	require_once( GKPHP_PATH . "Date_gk.php" );
	require_once( GKPHP_PATH . "Forms_gk.php" );
	require_once( GKPHP_PATH . "Html_gk.php" );
	require_once( GKPHP_PATH . "Mysqli_gk.php" );
	require_once( GKPHP_PATH . "QRcode_gk.php" );
	require_once( GKPHP_PATH . "Table_gk.php" );
	require_once( GKPHP_PATH . "Utils_gk.php" );
	require_once( GKPHP_PATH . "Configuration_gk.php" );
	
	ConfigurationLoader::update( GKPHP_CFG_PATH."gk_cfg.xml" , GKPHP_CFG_PATH."gk_cfg.php" );
	require_once( GKPHP_CFG_PATH."gk_cfg.php" );
	$gkcfg = new gk();

	if( $gkcfg->param->session )
		session_start();

	if( $gkcfg->param->authentication->enable )
		require_once( GKPHP_PATH . "Authentication_gk.php" );

	define	( 'GK_STATUS'		, $gkcfg->info->status );
	define	( 'GK_SUBMINOR'	, $gkcfg->info->subminor );
	define	( 'GK_VERSION'	, $gkcfg->info->version.GK_STATUS.'-'.GK_SUBMINOR );
	define	( 'GK_DEBUG'		, $gkcfg->info->debug );

