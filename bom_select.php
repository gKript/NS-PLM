 <!--
|
|	File: bom_select.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php
	$nspage = "bom_select";
	
	define( 'NSID_PLM_TITLE'		,	'NextStep PLM' );
	define( 'NSID_PLM_SRC_PHP'	, 'src/php/');
	define( 'NSID_PLM_SRC_HTML'	, 'src/html/');
	define( 'NSID_PLM_SRC_CSS'	, 'src/css/');
	define( 'NSID_PLM_SRC_JS'	  , 'src/js/');
	define( 'NSID_PLM_SRC_IMG'  ,	'src/img/');

	require NSID_PLM_SRC_PHP.'includes.php';
	require NSID_PLM_SRC_PHP.'index_funtions.php';
	require_once( NSID_PLM_SRC_PHP."table.php" );
	

	$db = new config_database();
	
	$mysqli = new mysqli( $db->host , $db->username , $db->password , $db->dbname , $db->port );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
?>

<?php
	require_once NSID_PLM_SRC_PHP . 'code_functions.php';
	require_once NSID_PLM_SRC_PHP . 'bom_funtions.php';
	include NSID_PLM_SRC_PHP . 'navmenu.php';
	global $A_options;
?>

<?php

	$code			= get_check( 'code' );

	if ( ! $code ) 
		insert_blockquote( "This page needs a code! " , "Error" , 1 );
	
	emphasis_code( $code );

?>

	<div class="insidecodelite">

<?php

	$array = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'" );
	synopsis( $code , $array["abbreviazione"] , $array["descrizione"]  );

	echo "<div class=\"insidecodelite\">\n";



?>


	</div>
	</div>


	
<?php
	include NSID_PLM_SRC_PHP . 'footer.php';
	$mysqli->close();
?>
