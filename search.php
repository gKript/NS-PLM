 <!--
|
|	File: search.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php

	$nspage = "search";

	require_once 'includes.php';
	
	require_once NSID_PLM_SRC_TEMPLATE . 'code_functions.php';
	require_once NSID_PLM_SRC_TEMPLATE . 'index_funtions.php';

	$T			= get_check( 'T' 			, "_" 				);
	$G			= get_check( 'G' 			, "_" 				);
	$S 			= get_check( 'S' 			, "_" 				);

	$order 	= get_check( 'order'	, "mod_desc"	);
	$src		= get_check( 'src'									);
	$action = get_check( 'action' 							);
	$limit	=	get_check( 'limit' 	, 20					);

	include NSID_PLM_SRC_TEMPLATE . 'navmenu.php';

	global $A_options;
	
	$sql = "";
	$test = 0;
	$nores = 5;
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

	$slimit = "Limit 0,$limit;";

		
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
			$sql = "SELECT * FROM `elenco_codici` $insflt $sorder $slimit;"; 		//	 Limit 0,10;
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
			$sql = "SELECT * FROM `elenco_codici` WHERE `codice` LIKE '%$text%' $sorder $slimit;";
			if ( query_get_num_rows( $sql ) )	$test++;
			$sql = "SELECT * FROM `elenco_codici` WHERE `abbreviazione` LIKE '%$text%' $sorder $slimit;";
			if ( query_get_num_rows( $sql ) )	$test++;
			$sql = "SELECT * FROM `elenco_codici` WHERE `descrizione` LIKE '%$text%' $sorder $slimit;";
			if ( query_get_num_rows( $sql ) )	$test++;
			$str = "&nbsp;&nbsp;&nbsp;&nbsp;" . "Text: \"" . $text . "\"";
			$sql = "";
		}
	}
	else
		$sql = "SELECT * FROM `elenco_codici` $sorder $slimit;";

?>
	<div class="insidecodelite">
<?php 
	
		$iscnt = 0;
		if ( $activity ) {
			$cnt = $T . $G . $S;
			if ( ( is_context( $cnt ) ) && ( $gk_Auth->check_user_level( "Create" , "Code" ) ) ) {
				$iscnt = 1;
				echo open_block_no_top( "Suggestions" , "idea" );
					echo tag_enclosed( "h4" , "Context compete: Create a new code" );
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

		echo open_block_no_top( "Sorting options box" , "sort" );
		echo BR();

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
			$sql = "SELECT * FROM `elenco_codici` WHERE `codice` LIKE '%$text%' $sorder $slimit";
//		echo $sql . "<br/>";
		$rows = query_get_num_rows( $sql );
		if ( $rows ) {

			echo open_block_no_top( "Code as key" , "code" );

?>
			<table style="margin:1em;" width="90%">
				<tr>
					<th style="text-align: center;" >Code</th>
					<th style="text-align: left;" >Short desrciption</th>
					<th style="text-align: left;" >Long description</th>
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
			$nores--;
		
		if ( $iscnt ) {
			
			unset( $sordeer );
			
			if ( ( ! $order ) || ( $order == "cod_desc" ) )
				$sorder = "ORDER BY `codice` DESC";
			else if ( $order == "cod_asc" )
				$sorder = "ORDER BY `codice` ASC";
			else if ( $order == "creat_desc" )
				$sorder = "ORDER BY `createTS` DESC";
			else if ( $order == "creat_asc" )
				$sorder = "ORDER BY `createTS` ASC";
			else if ( $order == "mod_desc" ) 
				$sorder = "ORDER BY `modifyTS` DESC";
			if ( $order == "mod_asc" )
				$sorder = "ORDER BY `modifyTS` ASC";
			
		
				$sql = "SELECT * FROM `bom` WHERE `code` LIKE '$cnt%' $sorder $slimit";
	//		echo $sql . "<br/>";
			$rows = query_get_num_rows( $sql );
			if ( $rows ) {
				echo open_block_no_top( "B.O.M. Father as key" , "father" );

	?>
				<table style="margin:1em;" width="90%">
					<tr>
						<th style="text-align: center;" >Code</th>
						<th style="text-align: left;" >Short desrciption</th>
						<th style="text-align: left;" >Long description</th>
					</tr>
		<?php
				if ($result = $mysqli->query($sql)) {
					for( $r = 0 ; $r < $rows ; $r++ ) {
							println( "<tr>" );
							$array = $result->fetch_array();
							$fc = $array['code'];
							$details = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$fc'" );
							print( "<td style='text-align: center; border:1px solid #999;' width='15%'>" );
							echo return_code_link( $fc ) . " rev." . $array["Revisione"] ;
							println( "</td>" );
							println( "<td style='border:1px solid #999;' width='25%'>" . $details['abbreviazione'] . "</td>" );
							println( "<td style='border:1px solid #999;' >" . $details['descrizione'] . "</td>" );
							println( "</tr>" );
					}
				}
		?>		
				</table>
			</div>
	<?php
			}
			else 
				$nores--;
		

		
			$sql = "SELECT *  FROM `lista_composizione` WHERE `son` LIKE '$cnt%'";
	//		echo $sql . "<br/>";
			$rows = query_get_num_rows( $sql );
			if ( $rows ) {
				echo open_block_no_top( "Son [$cnt] inside a B.O.M. as key" , "son" );
	?>
				<table style="margin:1em;" width="90%">
					<tr>
						<th style="text-align: center;" >Father Code</th>
						<th style="text-align: left;" >Short desrciption</th>
						<th style="text-align: left;" >Long description</th>
					</tr>
		<?php
				if ($result = $mysqli->query($sql)) {
					$res = array();
					$rev = array();
					for( $r = 0 ; $r < $rows ; $r++ ) {
						$array = $result->fetch_array();
						$sc = $array['father'];
						$rv = $array['revision'];
						if ( ! in_array( $sc , $res ) ) {
							$res[] = $sc;
							$rev[] = $rv;
						}
					}
					$rows = count( $res );
					for( $r = 0 ; $r < $rows ; $r++ ) {
							println( "<tr>" );
							$sc = $res[$r];
							$details = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$sc'" );
							print( "<td style='text-align: center; border:1px solid #999;' width='15%'>" );
							echo return_bom_link( $sc ) . " rev." . $rev[$r] ;
							println( "</td>" );
							println( "<td style='border:1px solid #999;' width='25%'>" . $details['abbreviazione'] . "</td>" );
							println( "<td style='border:1px solid #999;' >" . $details['descrizione'] . "</td>" );
							println( "</tr>" );
					}
				}
		?>		
				</table>
			</div>
	<?php
			}
			else 
				$nores--;
		
		}
		else 
			$nores = $nores - 2;
		
	if ( $text ) {
		$sql = "SELECT * FROM `elenco_codici` WHERE `abbreviazione` LIKE '%$text%' $sorder $slimit";
//		echo $sql . "<br/>";
		$rows = query_get_num_rows( $sql );
		if ( $rows ) {
			echo open_block_no_top( "Short description as key" , "description" );

?>

			<table style="margin:1em;" width="90%">
				<tr>
					<th style="text-align: center;" >Code</th>
					<th style="text-align: left;" >Short desrciption</th>
					<th style="text-align: left;" >Long description</th>
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
			$nores--;


	
		$sql = "SELECT * FROM `elenco_codici` WHERE `descrizione` LIKE '%$text%' $sorder $slimit";
//		echo $sql . "<br/>";
		$rows = query_get_num_rows( $sql );
		if ( $rows ) {
			echo open_block_no_top( "Long description as key" , "description" );
?>
			<table style="margin:1em;" width="90%">
				<tr>
					<th style="text-align: center;" >Code</th>
					<th style="text-align: left;" >Short desrciption</th>
					<th style="text-align: left;" >Long description</th>
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
			$nores--;
	}
	
	
//	echo $nores;
	if ( ! $nores  ) {
		insert_blockquote( "No result with this parameters." , "Notice" ); 
	}
	
	
	?>
	</div>
	
<?php
	include NSID_PLM_SRC_TEMPLATE . 'footer.php';
	$mysqli->close();
?>

