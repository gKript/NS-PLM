<!--
|
|	File: index.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php
	$gk_page = "index";
	
	define( 'NSID_PLM_TITLE'		,	'NextStep PLM' );
	define( 'NSID_PLM_SRC_PHP'	, 'src/php/');
	define( 'NSID_PLM_SRC_HTML'	, 'src/html/');
	define( 'NSID_PLM_SRC_CSS'	, 'src/css/');
	define( 'NSID_PLM_SRC_JS'	  , 'src/js/');

	require NSID_PLM_SRC_PHP.'includes.php';
	require NSID_PLM_SRC_PHP.'index_funtions.php';
	
	

	$db = new config_database();
	
	$mysqli = new mysqli( $db->host , $db->username , $db->password , $db->dbname , $db->port );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
?>


<?php
	include NSID_PLM_SRC_PHP . 'navmenu.php';
	global $A_options;
?>

<?php

	$T			= get_check( 'T' 			, "_" );
	$G			= get_check( 'G' 			, "_" );
	$S 			= get_check( 'S' 			, "_" );
	$text 	= get_check( 'text'					);
	$order 	= get_check( 'order'				);
	$src		= get_check( 'src'					);
	$action = get_check( 'action' 			);
	$limit	=	get_check( 'limit' 	, 50	);

	$sql = "";
	$test = 0;
	$nores = 0;
	$activity = 0;
	
		
	if ( ( ! $order ) || ( $order == "cod_desc" ) )
		$sorder = "ORDER BY `elenco_codici`.`codice` DESC";
	else if ( $order == "cod_asc" )
		$sorder = "ORDER BY `elenco_codici`.`codice` ASC";
	else if ( $order == "short_desc" )
		$sorder = "ORDER BY `elenco_codici`.`abbreviazione` DESC";
	else if ( $order == "short_asc" ) 
		$sorder = "ORDER BY `elenco_codici`.`abbreviazione` ASC";
	else if ( $order == "long_desc" )
		$sorder = "ORDER BY `elenco_codici`.`descrizione` DESC";
	else if ( $order == "long_asc" )
		$sorder = "ORDER BY `elenco_codici`.`descrizione` ASC";
	else if ( $order == "creat_desc" )
		$sorder = "ORDER BY `elenco_codici`.`createTS` DESC";
	else if ( $order == "creat_asc" )
		$sorder = "ORDER BY `elenco_codici`.`createTS` ASC";
	else if ( $order == "mod_desc" ) 
		$sorder = "ORDER BY `elenco_codici`.`modifyTS` DESC";
	if ( $order == "mod_asc" )
		$sorder = "ORDER BY `elenco_codici`.`modifyTS` ASC";
	
//	echo $sorder;
		
	//echo $text . " " . $T . " " . $G . " " . $S . "<br/>";
	if ( ( $T != "_" ) || ( $G != "_" ) || ( $S != "_" ) || ( $text != "" ) ) {
		$test = 0;
		//	c'è da fare ricerca
		$activity = 1;
		if ( $text == "" ) {
			//	Ricerca contesto
			if ( ( $T == "x" ) || ( $T == "" ) )	$T = "_";
			if ( ( $G == "x" ) || ( $G == "" ) )	$G = "_";
			if ( ( $S == "x" ) || ( $S == "" ) )	$S = "_";
			$str = "&nbsp;&nbsp;&nbsp;&nbsp;Context: \"" . $T.$G.$S . "\"";
			$insflt = "WHERE `codice` LIKE '".$T.$G.$S."%'";
			$sql = "SELECT * FROM `elenco_codici` $insflt $sorder Limit 0,$limit;"; 		//	 Limit 0,10;
			if ( query_get_num_rows( $sql ) )	$test++;
		}
		else {
			if ( is_context( $text ) ) {
//			echo "contesto";
				$upstr = strtoupper( $text );
				$T = substr( $upstr , 0 , 1 );
				$G = substr( $upstr , 1 , 1 );
				$S = substr( $upstr , 2 , 1 );
			}
			//	Ricerca da input testo
			$sql = "SELECT * FROM `elenco_codici` WHERE `codice` LIKE '%$text%' $sorder Limit 0,$limit;";
			if ( query_get_num_rows( $sql ) )	$test++;
			$sql = "SELECT * FROM `elenco_codici` WHERE `abbreviazione` LIKE '%$text%' $sorder Limit 0,$limit;";
			if ( query_get_num_rows( $sql ) )	$test++;
			$sql = "SELECT * FROM `elenco_codici` WHERE `descrizione` LIKE '%$text%' $sorder Limit 0,$limit;";
			if ( query_get_num_rows( $sql ) )	$test++;
			$str = "&nbsp;&nbsp;&nbsp;&nbsp;" . "Text: \"" . $text . "\"";
			$sql = "";
		}
	}
	else
		$sql = "SELECT * FROM `elenco_codici` $sorder Limit 0,$limit;";

?>
	<div class="insidecodelite">
<?php 
	
	if ( ( ! $src ) and ( ! $action ) ){
	
?>
		<div class="codelite">
		<h3>Welcome to NS-PLM</h3>
<?php 
//			insert_blockquote( "This page is designed to start the activities.<br/>You can click on a code here below." , "Blockquote" ); 
?>
		<p>This page is designed to start the activities. You can click on a code here below.</p>
		</div>
<?php
	}
		
		if ( $activity ) {
			$cnt = $T . $G . $S;
			
			if ( is_context( $cnt ) )   {
?>
		<div class="codelite">
			<h3>Context compete</h3>
			<h2>Further actions:</h2><br/>
<?php 
				$ncode = get_new_code( $T ,$G , $S );
				echo "<table style=\"padding-left: 50px;\" width=\"40%\" ><tr><td style='text-align: left; border:1px solid #999;' width='40%' >Create code: <b>$ncode</b></td>";
				echo "<td style='text-align: center; border:1px solid #999; background-color:#fdd;' width='5%' ><a href=\"code.php?T=$T&G=$G&S=$S&action=Create\"><span class=\"blink_text\"><b>Create</b></span>	</a></td></tr></table>";
?>
		</div>
<?php
			}
			else if ( ! ( ( ! $text ) && ( ( $T == "_" ) && ( $G == "_" ) && ( $S == "_" ) ) ) )
				emphasis( "Serching for..." , $str );
		}
?>
		<div class="codelite">
			<h2>Ordering box</h2><br/>
<?php

		select_option( "reset" );
		select_option( "insert" , "cod_desc"	, "Code Desc" 		);
		select_option( "insert" , "cod_asc" 	, "Code Asc"			);
		select_option( "insert" , "short_desc" 	, "Short Description Desc" );
		select_option( "insert" , "short_asc" 	, "Short Description Asc" 	);
		select_option( "insert" , "long_desc" 	, "Long Description Desc" );
		select_option( "insert" , "long_asc" 	, "Long Description Asc" 	);
		select_option( "insert" , "creat_desc" 	, "Creation date Desc" );
		select_option( "insert" , "creat_asc" 	, "Creation Asc" 	);
		select_option( "insert" , "mod_desc" 	, "Modification date Desc" );
		select_option( "insert" , "mod_asc" 	, "Modification date Asc" 	);
		open_form( "GET" , "" , "" );
		select_composer_from_array( "order" , "order" , 0 , "" , "this.form.submit()" , $order , 0 , "Ordering by: " );
		text_input_composer( "limit" , $limit , "" , "number" , 4 , 4 , 1 , "" , "&nbsp;&nbsp;&nbsp;&nbsp;Number of results: " , "before" );
		add_hidden( "T"			, $T		, "_" );
		add_hidden( "G"			, $G		, "_" );
		add_hidden( "S" 		, $S		, "_" );
		add_hidden( "text"	, $text , ""	);
		add_hidden( "src"		, $src	, ""	);
		close_form();
		
		if ( ! ( ( $T != "" ) || ( $G != "" ) || ( $S != "" ) || ( $text != "" ) ) )
			;
			
?>
		</div>
<?php

		if ( ! $sql ) 
			$sql = "SELECT * FROM `elenco_codici` WHERE `codice` LIKE '%$text%' $sorder";
//		echo $sql . "<br/>";
		$rows = query_get_num_rows( $sql );
		if ( $rows ) {
?>
		<div class="codelite">
			<h2>Code as key</h2><br/>


			<table style="margin:1em;" width="90%">
				<tr>
					<th style="text-align: center;" >Code</th>
					<th>Short desrciption</th>
					<th>Long description</th>
				</tr>


	<?php

			if ($result = $mysqli->query($sql)) {
				for( $r = 0 ; $r < $rows ; $r++ ) {
						println( "<tr>" );
						$array = $result->fetch_array();
						print( "<td style='text-align: center; border:1px solid #999;' width='10%'>" );
						code_link($array['codice']);
						println( "</td>" );
						println( "<td style='border:1px solid #999;' width='25%'>" . $array['abbreviazione'] . "</td>" );
						println( "<td style='border:1px solid #999;' >" . $array['descrizione'] . "</td>" );
						println( "</tr>" );
				}
			}
	?>		
			</table>
		</div>
<?php
		}
		else 
			$nores++;
		
	if ( $text ) {
		$sql = "SELECT * FROM `elenco_codici` WHERE `abbreviazione` LIKE '%$text%' $sorder";
//		echo $sql . "<br/>";
		$rows = query_get_num_rows( $sql );
		if ( $rows ) {
?>
		<div class="codelite">
			<h2>Short description as key</h2><br/>

			<table style="margin:1em;" width="90%">
				<tr>
					<th style="text-align: center;" >Code</th>
					<th>Short desrciption</th>
					<th>Long description</th>
				</tr>


	<?php

			if ($result = $mysqli->query($sql)) {
				for( $r = 0 ; $r < $rows ; $r++ ) {
						println( "<tr>" );
						$array = $result->fetch_array();
						print( "<td style='text-align: center; border:1px solid #999;' width='10%'>" );
						code_link($array['codice']);
						println( "</td>" );
						println( "<td style='border:1px solid #999;' width='25%'>" . $array['abbreviazione'] . "</td>" );
						println( "<td style='border:1px solid #999;' >" . $array['descrizione'] . "</td>" );
						println( "</tr>" );
				}
			}
	?>		
			</table>
		</div>
<?php
		}
		else 
			$nores++;

	
		$sql = "SELECT * FROM `elenco_codici` WHERE `descrizione` LIKE '%$text%' $sorder";
//		echo $sql . "<br/>";
		$rows = query_get_num_rows( $sql );
		if ( $rows ) {
?>
		<div class="codelite">
			<h2>Long description as key</h2><br/>


			<table style="margin:1em;" width="90%">
				<tr>
					<th style="text-align: center;" >Code</th>
					<th>Short desrciption</th>
					<th>Long description</th>
				</tr>


	<?php

			if ($result = $mysqli->query($sql)) {
				for( $r = 0 ; $r < $rows ; $r++ ) {
						println( "<tr>" );
						$array = $result->fetch_array();
						print( "<td style='text-align: center; border:1px solid #999;' width='10%'>" );
						code_link($array['codice']);
						println( "</td>" );
						println( "<td style='border:1px solid #999;' width='25%'>" . $array['abbreviazione'] . "</td>" );
						println( "<td style='border:1px solid #999;' >" . $array['descrizione'] . "</td>" );
						println( "</tr>" );
				}
			}
	?>		
			</table>
		</div>
<?php
		}
		else 
			$nores++;
	}
	if ( ( ( ! $text ) && ( $nores == 1 ) ) || ( ( $text ) && ( $nores == 3 ) ) ) {
		//echo $nores;
		insert_blockquote( "No result with this parameters." , "Notice" ); 
	}
	
	
	?>
	</div>
	
<?php
	include NSID_PLM_SRC_PHP . 'footer.php';
	$mysqli->close();
?>

