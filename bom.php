<!--
|
|	File: bom.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php
	$nspage = "bom";
	
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

	$code			= get_check( 'code'							);
	$level		= get_check( 'level'		, 1			);
	$rev			= get_check( 'rev'			, 1			);
	$newcode	= get_check( 'newcode'	, null	);
	$quantity	= get_check( 'quantity'	, null	);
	$delete		= get_check( 'delete'		, ""		);
	$action		= get_check( 'action'		, null	);
	$confirm	= get_check( 'confirm'	, ""		);
	

	if ( $action == "Add to this bom" )
		add_code_in_bom( $code , $newcode , $quantity , $rev );
	
	
	if ( $action == "Remove" ) {
		if ( $confirm == "YES" ) {
			$sql = "DELETE FROM `lista_composizione` WHERE `son` LIKE '$delete' and `father` LIKE '$code'";
			query_sql_run( $sql );
			insert_blockquote( "Code <b>$delete</b> succesfully removed from the BOM [$code]" , "Success" );
		}
		else {
			$syes = "<a class=\"codelite\" href=\"bom.php?code=$code&delete=$delete&action=Remove&confirm=YES\"><b>YES</b></a>";
			$sno = "<a class=\"codelite\" href=\"bom.php?code=$code\"><b>NO</b></a>";
			insert_blockquote( "Are you sure to <b>REMOVE</b> code <b>$delete</b> from the BOM [$code] ?<br/><br/><br/>$syes&nbsp;&nbsp;&nbsp;&nbsp;$sno" , "Are you sure?" );
		}
	}
	
	if ( ! $code ) 
		insert_blockquote( "This page needs a code! " , "Error" , 1 );
	
	emphasis_code( $code );
?>

	<div class="insidecodelite">

<?php
	
	$array = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'" );
	synopsis( $code , $array["abbreviazione"] , $array["descrizione"]  );

?>
		

<?php
	create_bom_table( $code , $level );

?>


	</div>


	
<?php
	include NSID_PLM_SRC_PHP . 'footer.php';
	$mysqli->close();
?>




