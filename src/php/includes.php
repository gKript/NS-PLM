<?php

//------------------------------------------------------------
//	gKript.org since 27/11/2001
//	gk_includes.php 
//	code by AsYntote	
//
//	Ver 0.10-x

	define( 'NSID_PLM_TITLE'		,	'NS-PLM' );	

	define( 'NSID_PLM_SRC_PHP'	, 'src/php/');
	define( 'NSID_PLM_SRC_HTML'	, 'src/html/');
	define( 'NSID_PLM_SRC_CSS'	, 'src/css/');
	define( 'NSID_PLM_SRC_JS'	  , 'src/js/');
	define( 'NSID_PLM_SRC_IMG'  ,	'src/img/');
	
	define( 'ITEMS_IN_HISTORY'	,	10				);


//	--- SOURCES

	require_once( NSID_PLM_SRC_PHP."db_connection.php" );
	require_once( NSID_PLM_SRC_PHP."codemenu.php" );
	require_once( NSID_PLM_SRC_PHP."date.php" );
	require_once( NSID_PLM_SRC_PHP."statistics.php" );
	require_once( NSID_PLM_SRC_PHP."mysqli_utils.php" );
	require_once( NSID_PLM_SRC_PHP."utils.php" );
	require_once( NSID_PLM_SRC_PHP."form_elements.php" );
//	require_once( NSID_PLM_SRC_PHP."table.php" );
	require_once( NSID_PLM_SRC_PHP."qrcode.php" );
	require_once( NSID_PLM_SRC_PHP."html.php" );
	require_once( NSID_PLM_SRC_PHP."html_template.php" );

	
//	--- CLASSES
	
//	require_once( NSID_PLM_SRC_PHP."class/upload/class.upload.php" );
	



//	session_start();


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
	
	


	function embedded_phpinfo() {
			ob_start();
			phpinfo();
			$phpinfo = ob_get_contents();
			ob_end_clean();
			$phpinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $phpinfo);
			echo "
					<style type='text/css'>
							#phpinfo {}
							#phpinfo pre {margin: 0; font-family: monospace;}
							#phpinfo a:link {color: #009; text-decoration: none; background-color: #fff;}
							#phpinfo a:hover {text-decoration: underline;}
							#phpinfo table {border-collapse: collapse; border: 0; width: 934px; box-shadow: 1px 2px 3px #ccc;}
							#phpinfo .center {text-align: center;}
							#phpinfo .center table {margin: 1em auto; text-align: left;}
							#phpinfo .center th {text-align: center !important;}
							#phpinfo td, th {border: 1px solid #666; font-size: 75%; vertical-align: baseline; padding: 4px 5px;}
							#phpinfo h1 {font-size: 150%;}
							#phpinfo h2 {font-size: 125%;}
							#phpinfo .p {text-align: left;}
							#phpinfo .e {background-color: #ccf; width: 300px; font-weight: bold;}
							#phpinfo .h {background-color: #99c; font-weight: bold;}
							#phpinfo .v {background-color: #ddd; max-width: 300px; overflow-x: auto; word-wrap: break-word;}
							#phpinfo .v i {color: #999;}
							#phpinfo img {float: right; border: 0;}
							#phpinfo hr {width: 934px; background-color: #ccc; border: 0; height: 0px;}
					</style>
					<div id='phpinfo'>
							$phpinfo
					</div>
					";
	}


?>
