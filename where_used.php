 <!--
|
|	File: where_used.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php
	$nspage = "where_used";

	require_once 'src/php/gkphp/includes.php';	
	require_once NSID_PLM_SRC_TEMPLATE . 'index_funtions.php';
	require_once NSID_PLM_SRC_PHP . 'table.php' ;
	

	$db = new config_database();
	
	$mysqli = new mysqli( $db->host , $db->username , $db->password , $db->dbname , $db->port );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
?>

<?php

	$code	= get_check( 'code' );

	require_once NSID_PLM_SRC_TEMPLATE . 'code_functions.php';
	require_once NSID_PLM_SRC_TEMPLATE . 'bom_funtions.php';
	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php'; 
	
?>

<?php

	global $A_options;
	
	if ( ! $code ) 
		insert_blockquote( "This page needs a code! " , "Error" , 1 );
	
	emphasis_code( $code );

?>

		<div class="insidecodelite">

<?php

	$array = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'" );
	$lcode = return_code_link( $code );
	$sd = $array["abbreviazione"];
	$ld = $array["descrizione"];
	synopsis( $code , $array["abbreviazione"] , $array["descrizione"]  );

	$sql = "SELECT *  FROM `lista_composizione` WHERE `son` LIKE '$code' ";
	$result = query_get_result( $sql );
	if ( $result ) {


		println( "<div class=\"codelite\">" );
		println( "<h2>Where Used</h2><br/>" );

		println( "<div class=\"box100\" style=\"height:300px;\">");
		
		$myTabella = new classTabella;
		$myTabella->setTabella();	
		$myTabella->stdAttributiTabella(array( "width"=>"100%" , "align"=>"center" , "style"=>"padding: 10px 10px 10px 10px ;" ));
		$myTabella->addValoreRiga(array( "Code" , "Short description" , "Long description" , "Revision" , "Quantity" ));
		$myTabella->aggiungiRiga(array( "style"=>"font-weight:bold;" ) , 5, array(array(  "style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"10%")  ,  array("style"=>"border:1px solid #999; " , "width"=>"25%", "align"=>"left")  ,  array("style"=>"border:1px solid #999; " , "width"=>"55%", "align"=>"left") , array(  "style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"5%") , array(  "style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"5%") ) );

		for( $r = 0 ; $r < $result->num_rows ; $r++ ) {
			$row = $result->fetch_array();
			$fc = $row["father"];
			$fr = $row["revision"];
			$sq = $row["quantity"];
			$array = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$fc'" );
			$lcode = return_code_link( $code );
			$fsd = $array["abbreviazione"];
			$fld = $array["descrizione"];
			$fcl = return_bom_link_highlighted( $fc , $code );
			$myTabella->addValoreRiga(array( $fcl , $fsd , $fld , $fr , $sq ));
			$myTabella->aggiungiRiga( null , 5, array(array(  "style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"10%")  ,  array("style"=>"border:1px solid #999; " , "width"=>"25%", "align"=>"left")  ,  array("style"=>"border:1px solid #999; " , "width"=>"55%", "align"=>"left") , array(  "style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"5%") , array(  "style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"5%") ) );
		}		
		$myTabella->stampaTabella();
		println( "	</div>" );	
		println( "</div>" );	
	}
	else {
		insert_blockquote( "This code is not involved in any high level assemble code!" , "Notice" );
	}



?>



	</div>


	
<?php
	include NSID_PLM_SRC_TEMPLATE . 'footer.php';
	$mysqli->close();
?>
