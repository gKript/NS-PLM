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

	require_once 'includes.php';	
	require_once NSID_PLM_SRC_TEMPLATE . 'index_funtions.php';	

	$db = new config_database();
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
?>

<?php

	$code	= get_check( 'code' );

	require_once NSID_PLM_SRC_TEMPLATE . 'code_functions.php';
	require_once NSID_PLM_SRC_TEMPLATE . 'bom_funtions.php';
	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php'; 
	
	if ( ( $_SESSION["clean_user"] == "guest" ) && ( ! $nscfg->param->user->guest_allowed ) ) 
		insert_blockquote( "Sorry but Guest user is not allowed here!<br/>Please, go to <a href=\"index.php\">home page</a> to log in." , "Error" , 1 );
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

/*
		println( "<div class=\"codelite\">" );
		println( "<h2>Where Used</h2><br/>" );
*/		
		echo open_block( "Where Used" );

//		println( "<div class=\"box100\" style=\"height:300px;\">");
	//	echo div_block_open( "insidecodelite" );

	
		$myTabella = new classTabella;
//		$myTabella->setTabella();	
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
		//echo div_block_close();	
		echo div_block_close();	
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
