<?php

//------------------------------------------------------------
//	gKript.org since 27/11/2001
//	gk_includes.php 
//	code by AsYntote	
//
//	Ver 0.10-x

//	--- SOURCES

	require_once( NSID_PLM_SRC_PHP."db_connection.php" );
	require_once( NSID_PLM_SRC_PHP."codemenu.php" );
	require_once( NSID_PLM_SRC_PHP."date.php" );
	require_once( NSID_PLM_SRC_PHP."statistics.php" );
	require_once( NSID_PLM_SRC_PHP."mysqli_utils.php" );
	require_once( NSID_PLM_SRC_PHP."utils.php" );
	require_once( NSID_PLM_SRC_PHP."form_elements.php" );
	require_once( NSID_PLM_SRC_PHP."table.php" );

	
//	--- CLASSES
	
	require_once( NSID_PLM_SRC_PHP."class/upload/class.upload.php" );
	
	
	$A_options = [	
		'option0' => [
			'value' => 'x',
			'name' 	=> 'Undefined'
		],
	];
	
	


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	
<?php
		println( "<title>" . NSID_PLM_TITLE . "</title>" );
		println( "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />" );
		
		//CSS Locali
		link_css( "menu.css"     , NSID_PLM_SRC_CSS );
		link_css( "h.css"        , NSID_PLM_SRC_CSS );
		link_css( "body.css"     , NSID_PLM_SRC_CSS );
		link_css( "view.css"     , NSID_PLM_SRC_CSS );
		
		//CSS online
//		link_css( "https://www.w3schools.com/w3css/4/w3.css"     , NSID_PLM_SRC_CSS );

		//CSS locali	
		link_js ( "view.js"      , NSID_PLM_SRC_JS  );
		link_js ( "calendar.js"  , NSID_PLM_SRC_JS  );
?>		

	</head>

<?php


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
