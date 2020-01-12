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

	require_once 'includes.php';	
	require_once NSID_PLM_SRC_TEMPLATE.'index_funtions.php';
	

	$db = new config_database();
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
?>

<?php

	$code			= get_check( 'code'							);
	$level		= get_check( 'level'		, 1			);
	$rev			= get_check( 'rev'			, 1			);
	$newcode	= get_check( 'newcode'	, null	);
	$quantity	= get_check( 'quantity'	, null	);
	$delete		= get_check( 'delete'		, ""		);
	$action		= get_check( 'action'		, null	);
	$hl	= get_check( 'hl'	, ""		);
	$confirm	= get_check( 'confirm'	, ""		);
	
	require_once NSID_PLM_SRC_TEMPLATE . 'code_functions.php';
	require_once NSID_PLM_SRC_TEMPLATE . 'bom_funtions.php';
	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
?>

<?php

	if ( is_bom_allowed( $code ) ) {

		global $A_options;
		
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
		create_bom_table( $code , $level , $hl);

	}
	else {
		println( "<div class=\"insidecodelite\">" );
		$array = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'" );
		synopsis( $code , $array["abbreviazione"] , $array["descrizione"]  );
		
		insert_blockquote( "B.O.M. are not allowed for the current code context [$code]" , "Warning" );
	}

	?>

	
	
	</div>


	
<?php
	include NSID_PLM_SRC_TEMPLATE . 'footer.php';
	$mysqli->close();
?>




