<?php

	require_once NSID_PLM_SRC_TEMPLATE . 'bom_funtions.php';

	function synopsis( $code , $sd , $ld , $image = "" , $title = 1 ) {
		
		global $nspage;
		
		$lcode = $code;
		if ( $nspage != "code" ) 
			$lcode = return_code_link( $code );

		if ( $title ) {
			echo open_block( "Code synopsis" , "syn.svg" );
		}
		else
			echo open_block_no_top();
		
		println( "	<div class=\"box50\" style=\"height:160px; background-color: #ccc; \">");
		println( "		<table width=\"100%\" style=\"padding: 10px 10px 10px 10px ;\">" );
		println( "			<tr>" );
		println( "				<td style=\"border:1px solid #999;\" width=\"20%\" >Code:</td>" );
		println( "				<td style=\"border:1px solid #999;\" width=\"80%\"><b>$lcode</b></td>" );
		println( "			</tr>" );
		println( "			<tr>" );
		println( "				<td  style='border:1px solid #999;' >Short descr:</td>" );
		println( "				<td style='border:1px solid #999;'>$sd</td>" );
		println( "			</tr>" );
		println( "			<tr>" );
		println( "				<td  style='border:1px solid #999;  height:70px; text-align: justify; text-justify: inter-word;'>Long descr:</td>" );
		println( "				<td style='border:1px solid #999; text-align: justify; text-justify: inter-word;'>$ld</td>" );
		println( "			</tr>" );
		println( "		</table>" );
		println( "	</div>" );
		$status = get_status_str( $code );
		println( "	<div class=\"box25\" style=\"height:160px; background-color: #ddd; \">");
		println( "		<table width=\"100%\" style=\"padding: 10px 10px 10px 10px ;\">" );
		println( "			<tr>" );
		println( "				<td  style='border:1px solid #999;'width=\"40%\">Status:</td>" );
		println( "				<td style='border:1px solid #999;text-align:center;'>$status</td>" );
		println( "			</tr>" );
		println( "			<tr>" );
		println( "				<td  style='border:1px solid #999;'width=\"40%\">Attachment:</td>" );
		println( "				<td style='border:1px solid #999;'>&nbsp;</td>" );
		println( "			</tr>" );
		println( "			<tr>" );
		println( "				<td  style='border:1px solid #999;'width=\"40%\">Documentation</td>" );
		println( "				<td style='border:1px solid #999;'>&nbsp;</td>" );
		println( "			</tr>" );
		println( "			<tr>" );
		println( "				<td  style='border:1px solid #999;' width=\"40%\">Supplier:</td>" );
		println( "				<td style='border:1px solid #999;'>&nbsp;</td>" );
		println( "			</tr>" );
		println( "			<tr>" );
		
		$ori = return_where_used_text_link( $code );
		
		println( "				<td  style='border:1px solid #999;' width=\"40%\">Included in:</td>" );
		if ( check_in_bom_presence( $code ) )
			println( "				<td style='border:1px solid #999;text-align:center; background-color:#e99;border-radius: 7px;'>$ori</td>" );
		else
			println( "				<td style='border:1px solid #999;text-align:center;'>NO</td>" );
		println( "			</tr>" );
		println( "			<tr>" );
		println( "				<td  style='border:1px solid #999; ' width=\"40%\">Link:</td>" );
		println( "				<td style='border:1px solid #999;'>&nbsp;</td>" );
		println( "			</tr>" );
		println( "		</table>" );
		
		$cs = query_get_a_field( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'" , "status" );
		
		$load = array("code"=>$code, "Short description"=>$sd, "Long description"=>$ld , "status"=>$cs );
		$enc = json_encode($load);
		$qr =  new QRCode();
		$qrs = $qr->getQrCodeUrl( $enc , 150 , 150 , "UTF-8" );
		
		println( "	</div>" );
		println( "	<div class=\"box25\" style=\"height:160px; background-color: #fff; \">");
		println( "		<img class=\"codelite_img\" src=\"$qrs\" />" );
		println( "	</div>" );
		if ( $title )
			println( "</div>" );
	}


	function code_structure( $code , $new ) {
		
		global $codetype;
		
		$codetype = get_codetype_from_code( $code );

		$hr  = "search.php?T=" . $codetype["T"] . "&G=" . $codetype["CG"] . "&S=" . $codetype["CS"];
		$hrt = $codetype["T"] . $codetype["CG"] . $codetype["CS"];
		$title  = "Code structure - ";
		$title .= link_generator( $hr , $hrt );
		echo open_block( $title , "struct.png" );
		
		echo div_block_open( "box66" , "padding-left: 12px;" );
			echo title_h3( "Meaning" );
		?>
				<table style="margin:1em;" width="90%">

		<?php
			println( "<tr>" );
			println( "  <td style='text-align: right;' width='13%' >Typology</td>" );
			$ln = $codetype["T"];
			if ( ! $new ) 
				$ln = TGS_link( $codetype["T"]  , "T" , "search.php?text" );
			println( "  <td style='text-align: center; border:1px solid #999;' width='5%' >$ln</td>" );
			println( "  <td style='border:1px solid #999;' width='20%'>"   . $codetype["Tname"]   . "</td>" );
			println( "  <td></td>" );
			println( "</tr>" );
			println( "<tr>" );
			println( "  <td style='text-align: right;' >Generic category</td>" );
			$ln = $codetype["CG"];
			if ( ! $new )
				$ln = TGS_link( $codetype["CG"]  , "G" , "search.php?text" );
			println( "  <td style='text-align: center; border:1px solid #999;' width='5%' >$ln</td>" );
			println( "  <td style='border:1px solid #999;' >"  . $codetype["CGname"]  . "</td>" );
			println( "  <td style='border:1px solid #999;' >"              . $codetype["CGdescr"] . "</td>" );
			println( "</tr>" );
			println( "<tr>" );
			println( "  <td style='text-align: right;' >Specific category</td>" );
			$ln = $codetype["CS"];
			if ( ! $new )
				$ln = TGS_link( $codetype["CS"]  , "S" , "search.php?text" );
			println( "  <td style='text-align: center; border:1px solid #999;' width='5%' >$ln</td>" );
			println( "  <td style='border:1px solid #999;' >"  . $codetype["CSname"]  . "</td>" );
			println( "  <td style='border:1px solid #999;' >"              . $codetype["CSdescr"] . "</td>" );
			println( "</tr>" );
			if ( $new != 3 ) {
				println( "<tr>" );
				println( "  <td style='text-align: right;' >B.O.M. Allowed</td>" );
				$dbtip = query_get_a_field( "SELECT *  FROM `tipologia` WHERE `idTip` = " . $codetype["T"] , "dbTip" );
				if( $dbtip == 1 ) {
					println( "  <td style='text-align: center; border:1px solid #999;' width='5%' >YES</td>" );
					if ( check_bom_presence( $code ) )
						println( "  <td style='text-align: center; border:1px solid #999; background-color:#faa;border-radius: 7px;' width=\"20%\" ><a href=\"bom.php?code=$code\"><span class=\"blink_text\"><b>Go to the B.O.M.</b></span></td>" );
					else
						println( "  <td style='text-align: center; border:1px solid #999; background-color:#faa;border-radius: 7px;' width=\"20%\" ><a href=\"bom.php?code=$code\"><span class=\"blink_text\"><b>Create</b></span></td>" );
				}
				else {
					println( "  <td style='text-align: center; border:1px solid #999;' width='5%' >NO</td>" );
					println( "  <td></td>" );
				}
				println( "  <td></td>" );
				println( "</tr>" );
			}
		?>		
				</table>
	<?php	
		echo div_block_close();
		
		echo div_block_open( "box33" , "padding-left: 12px;" );
			echo title_h3( "Provider" );
		
		echo div_block_close();
	
	}



	function create_top_n_table( $top ) {
		println( "<div class=\"codelite\">" );
		println( "<h2>Top ten context advisor</h2><br/>" );
		$myTabella = new classTabella;
//		$myTabella->setTabella();
		$myTabella->stdAttributiTabella(array( "width"=>"100%" , "align"=>"center" , "style"=>"padding: 10px 10px 10px 10px ;" ));
		$myTabella->addValoreRiga(array("Contexts" , "Occurrences" , "Percentages" , "Charts" ));
		$myTabella->aggiungiRiga(array( "style"=>"font-weight:bold;" ),4,array(array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"100px"),array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"50px"),array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"50px") , array("style"=>"border:1px solid #999; ") ));
		$items = count( $top );
		$ma = $top[ $items - 1 ]["max"];
		$mi = $top[ $items - 1 ]["min"];
		for( $r = 0 ; $r < $items - 1 ; $r++ ) {
			$cr = sprintf( "%x" , map( $top[ $r ][ "perc" ] , $mi , $ma , 7 , 15 ) );
			$cg = sprintf( "%x" , map( $top[ $r ][ "perc" ] , $mi , $ma , 5 , 13 ) );
			$cb = sprintf( "%x" , map( $top[ $r ][ "perc" ] , $mi , $ma , 5 , 13 ) );
			$col = $cr.$cg.$cb;
			$link = new_code_step2_link_from_context( $top[ $r ][ "context" ] );
			$myTabella->addValoreRiga(array( $link , $top[ $r ][ "value" ] , $top[ $r ][ "perc" ]."%" , "<div style=\"background:#eee; \"><div class=\"bar\" style=\"background:#$col; width:" . $top[ $r ][ "perc" ] . "%;\"></div></div>" ));	
			$myTabella->aggiungiRiga(null,4,array(array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"100px"),array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"50px"),array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"50px") , array("style"=>"border:1px solid #999; ") ));
		}	
		$myTabella->stampaTabella();
		println( "<br/></div>" );
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
		$ncode  = get_latest_revision( $code );
		$oldrev = (int)substr( $ncode, 8 , 2);
		$newrev = sprintf( "%02s" , $oldrev + 1 );
		$root   = substr( $ncode , 0 , 8);
		return $root . $newrev;
	}


	function get_next_revision( $code ) {
		$oldrev = (int)substr($code, 8, 2);
		$newrev = sprintf( "%02s" , $oldrev + 1 );
		$root   = substr($code, 0, 8);
		return $root . $newrev;
	}
		

	function get_latest_revision( $code ) {
		do {
			$last_rev = $code;
			$code = get_next_revision( $code );
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



	function get_codetype( $array ) {
		
		global $codetype;
		
		$codetype["T"] = $array["T"];
		$codetype["CG"] = $array["CG"];
		$codetype["CS"] = $array["CS"];
		$res = query_code_category( 'T' , $codetype["T"] );
		$codetype["Tname"] = $res["Tip"];
		$res = query_code_category( 'CG' , $codetype["CG"] );
		$codetype["CGname"] = $res["CatGen"];
		$codetype["CGdescr"] = $res["CatGenDescr"];
		$res = query_code_category( 'CS' , $codetype["CS"] );
		$codetype["CSname"] = $res["CatSpec"];
		$codetype["CSdescr"] = $res["CatSpecDesc"];
	}



	function get_codetype_from_tgs( $T , $G , $S ) {
		
		global $codetype;
		
		$codetype["T"] = $T;
		$codetype["CG"] = $G;
		$codetype["CS"] = $S;
		$res = query_code_category( 'T' , $codetype["T"] );
		$codetype["Tname"] = $res["Tip"];
		$res = query_code_category( 'CG' , $codetype["CG"] );
		$codetype["CGname"] = $res["CatGen"];
		$codetype["CGdescr"] = $res["CatGenDescr"];
		$res = query_code_category( 'CS' , $codetype["CS"] );
		$codetype["CSname"] = $res["CatSpec"];
		$codetype["CSdescr"] = $res["CatSpecDesc"];
	}

	
	function get_codetype_from_code( $code ) {
		
		$codetype["T"]  = substr( $code , 0 , 1);
		$codetype["CG"] = substr( $code , 1 , 1);
		$codetype["CS"] = substr( $code , 2 , 1);
//		echo $codetype["T"] . " " . $codetype["CG"] . " " . $codetype["CS"];
		$res = query_code_category( 'T' , $codetype["T"] );
		$codetype["Tname"] = $res["Tip"];
		$res = query_code_category( 'CG' , $codetype["CG"] );
		$codetype["CGname"] = $res["CatGen"];
		$codetype["CGdescr"] = $res["CatGenDescr"];
		$res = query_code_category( 'CS' , $codetype["CS"] );
		$codetype["CSname"] = $res["CatSpec"];
		$codetype["CSdescr"] = $res["CatSpecDesc"];
		
		return $codetype;
	}

	
	function get_status( $code ) {
		$sql = "SELECT * FROM `elenco_codici` WHERE `codice` LIKE '$code'";
		$status = query_get_a_field( $sql , "status" );
		return $status;
	}


	function get_status_str( $code ) {
		
		global $cstatus_seq;
		
		$st = get_status( $code );
		return $cstatus_seq[ $st ]["t"];
	}


	function set_notice_by_action_review( $code ) {
		
		global $gk_Auth;

		$promoter = $gk_Auth->get_current_user_name();
		$level = $gk_Auth->get_user_level_by_action( "Review" , "Code" );
		$head = "Code review";
		$code_tx = tag_enclosed( "b" , $code );
		$body = "It is necessary reviewing the code $code_tx. If everything is good the next status will be APPROVED. Instead, if you reject the proposal the code will comeback to the Draft status.";
		$link = "check.php?code=$code";
	
		$sql  = "INSERT INTO `notice` (`id`, `promoter`, `level`, `sender`, `sender_clean`, `receiver`, `type`, `head`, `body`, `link`, `active`, `createTS`, `modifyTS`)";
		$sql .= " VALUES (NULL, '$promoter', '$level', 'system', 'System', '', 'Action required', '$head', '$body', '$link', '1', current_timestamp(), current_timestamp());";
		
		query_sql_run( $sql );
		
		if ( query_get_num_rows( "SELECT * FROM `notice` WHERE `promoter` LIKE '$code' AND `type` LIKE 'Rejection'" ) )
			query_sql_run( "DELETE FROM `notice` WHERE `promoter` LIKE '$code' AND `type` LIKE 'Rejection'" );
	}











?>


