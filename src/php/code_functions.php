<?php

	require_once NSID_PLM_SRC_PHP . 'bom_funtions.php';

	function synopsis( $code , $sd , $ld , $image = "" ) {
		println( "<div class=\"codelite\">");
		println ( "<h2>Code	 synopsis</h2><br/>" );
		
		println( "<div class=\"box50\" style=\"height:150px;\">");
		println( "<table class=\"codelite_img\" width=\"100%\" >" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999;'width=\"20%\">Code:</td>" );
		println ( "		<td style='border:1px solid #999;'><b>$code</b></td>" );
		println( "	</tr>" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999;' >Short descr:</td>" );
		println ( 		"<td style='border:1px solid #999;'>$sd</td>" );
		println( "	</tr>" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999;  height:70px; text-align: justify; text-justify: inter-word;'>Long descr:</td>" );
		println ( 		"<td style='border:1px solid #999; text-align: justify; text-justify: inter-word;'>$ld</td>" );
		println( "	</tr>" );
		println( "</table>" );
		println ( "</div>" );
		
		println( "<div class=\"box25\" style=\"height:150px;\">");
		println( "<table class=\"codelite_img\" width=\"100%\" >" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999;'width=\"40%\">Attachment:</td>" );
		println ( "		<td style='border:1px solid #999;'>&nbsp;</td>" );
		println( "	</tr>" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999;'width=\"40%\">Documentation</td>" );
		println ( 		"<td style='border:1px solid #999;'>&nbsp;</td>" );
		println( "	</tr>" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999;' width=\"40%\">Provider:</td>" );
		println ( 		"<td style='border:1px solid #999;'>&nbsp;</td>" );
		println( "	</tr>" );
		println( "	<tr>" );
		
		$ori = get_father( $code );
		
		println ( "		<td  style='border:1px solid #999;' width=\"40%\">Origin:</td>" );
		println ( 		"<td style='border:1px solid #999;text-align:center;'>$ori</td>" );
		println( "	</tr>" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999; ' width=\"40%\">Link:</td>" );
		println ( 		"<td style='border:1px solid #999;'>&nbsp;</td>" );
		println( "	</tr>" );
		println( "</table>" );
		
		$load = array("code"=>$code, "Short description"=>$sd, "Long description"=>$ld);
		$enc = json_encode($load);
		$qr =  new QRCode();
		$qrs = $qr->getQrCodeUrl( $enc , 150 , 150 , "UTF-8" );
		
		println ( "</div>" );
		println( "<div class=\"box25\" style=\"height:150px;\">");
		println ( "<img class=\"codelite_img\" src=\"$qrs\" style= \"border:1px solid #999;\" />" );
		println ( "</div>" );
		println ( "</div>" );
	}


	function create_top_n_table( $top ) {
		println( "<div class=\"codelite\">" );
		println( "<h2>Top ten context advisor</h2><br/><br/>" );
		$myTabella = new classTabella;
		$myTabella->setTabella();
		$myTabella->stdAttributiTabella(array("class"=>"codellite_img" , "width"=>"95%" , "align"=>"center"));
		$myTabella->addValoreRiga(array("Contexts" , "Occurrences" , "Percentages" , "Charts" ));
		$myTabella->aggiungiRiga(array( "style"=>"font-weight:bold;" ),4,array(array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"100px"),array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"50px"),array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"50px") , array("style"=>"border:1px solid #999; ") ));
		$items = count( $top );
		for( $r = 0 ; $r < $items ; $r++ ) {
			$link = new_code_step2_link_from_context( $top[ $r ][ "context" ] );
			$myTabella->addValoreRiga(array( $link , $top[ $r ][ "value" ] , $top[ $r ][ "perc" ]."%" , "<div style=\"background:#eee; \"><div style=\"height:14px;width:" . $top[ $r ][ "perc" ] . "%; background:#aaa; \"></div></div>" ));	
			$myTabella->aggiungiRiga(null,4,array(array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"100px"),array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"50px"),array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"50px") , array("style"=>"border:1px solid #999; ") ));
		}	
		$myTabella->stampaTabella();
		println( "<br/></div>" );
	}


	function check_bom_presence( $father ) {
		$sql = "SELECT * FROM `lista_composizione` WHERE `father` LIKE '$father' ORDER BY `lista_composizione`.`modify` DESC LIMIT 0,1";
		return query_get_num_rows( $sql ); 
	}


	function code_link( $code , $link = "code.php?code" ) {
		echo '<a href="' . $link . "=" . $code . '">' . $code . "</a>";
	}

	function return_code_link( $code , $link = "code.php?code" ) {
		return '<a href="' . $link . "=" . $code . '">' . $code . "</a>";
	}


	function new_code_insert( $code , $sdescr , $ldescr , $bom = 0 ) {
		global $mysqli;
		
		$t = substr($code, 0, 1);
		$g = substr($code, 1, 1);
		$s = substr($code, 2, 1);
		
		$sql = "INSERT INTO `elenco_codici` (`idCodice`, `codice`, `T`, `CG`, `CS`, `abbreviazione`, `descrizione`, `dbCodici`, `createTS`, `modifyTS`) VALUES (NULL, '$code', '$t', '$g', '$s', '$sdescr', '$ldescr', '$bom', current_timestamp(), current_timestamp())";
		
		$mysqli->query ( $sql ) or 
			die( "query_single_line() : Problem with query<br/>&nbsp;&nbsp;&nbsp;&nbsp;Query : $query<br/>&nbsp;&nbsp;&nbsp;&nbsp;MySql :" . $mysqli->error ."<br/>" );
				
	}


	function get_new_code( $t, $g, $s ) {
		global $mysqli;
		$srch = "$t$g$s";
		$sql = "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$srch%' ORDER BY `codice`  DESC Limit 0,1";
		$result = $mysqli->query( $sql ) or 
			die( "query_single_line() : Problem with query<br/>&nbsp;&nbsp;&nbsp;&nbsp;Query : $sql<br/>&nbsp;&nbsp;&nbsp;&nbsp;MySql :" . $mysqli->error ."<br/>" );
		if ( $row = $result->fetch_array() )
			$code = $row[ "codice" ];
		else 
				return "$t$g$s" . "0000100";
		$cod_id = (int)substr($code, 3, 5);
		$ncode_id = sprintf( "%05d" , $cod_id + 1 );
		$ret = $srch . $ncode_id . "00";
		return $ret;
	}
	
	

	function get_new_revision( $code ) {
		$oldrev = (int)substr($code, 8, 2);
		$newrev = sprintf( "%02s" , $oldrev + 1 );
		$root   = substr($code, 0, 8);
		return $root . $newrev;
	}
	
	

	function get_latest_revision( $code ) {
		do {
			$last_rev = $code;
			$code = get_new_revision( $code );
			$sql = "SELECT * FROM `elenco_codici` WHERE `codice` LIKE '$code'";
		}
		while( query_get_num_rows( $sql ) != 0 );
		return $last_rev;
	}



	function query_code_category( $cat , $id , $echo = 0 ) {
		global $mysqli;
		
		if ( $cat == "T" ) {
			$sql = "SELECT * FROM `tipologia` WHERE `idTip` = $id";
		}
		if ( $cat == "CG" ) {
			$sql = "SELECT *  FROM `catgenerica` WHERE `idCatGen` LIKE '$id'";
		}
		if ( $cat == "CS" ) {
			$sql = "SELECT *  FROM `catspecifica` WHERE `idCatSpec` LIKE '$id'";
		}
		if ( $echo ) 
			echo $sql."<br/>";
		$result = query_get_result( $sql );
		if ( ! $result )
			return NULL;
		$array = $result->fetch_array();
		return $array;
	}


	function new_code_step2_link_from_context( $context ) {
		$T = substr( $context , 0 , 1 );
		$G = substr( $context , 1 , 1 );
		$S = substr( $context , 2 , 1 );
		$link = "<a href=\"code.php?T=$T&G=$G&S=$S&action=Create\">$context</a>";
		return $link;		
	}



?>


