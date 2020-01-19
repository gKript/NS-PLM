<?php

	require_once NSID_PLM_SRC_TEMPLATE . 'attributes_function.php';

	function create_bom_table( $code , $maxlevel , $hl = "" ) {
		$sql = "SELECT * FROM `lista_composizione` WHERE `father` LIKE '$code' ORDER BY `lista_composizione`.`modifyTS` DESC";
		$items = 0;
		$result = query_get_result( $sql );
		if ( $result ) 
			$items = $result->num_rows;
		$code_detail = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'" );
		$level = 0;
		$origin = $code;
		$father = "<a href=\"bom.php?code=" . get_father( $code , 1 ) . "&level=" . (string)($maxlevel + 1) . "\" ><b>" . get_father( $code , 1 ) . "</b></a>";
		
//		println( "<div class=\"codelite\">" );
//		println( "<h2>Bill of Materials</h2><br/>" );

		echo open_block( "Bill of Materials" , "bom.svg" );

		$fhash = get_hashid_from_bom( $code );
		println( "<small>BOM Hash ID: [ $fhash ]</small>" );
	
		echo "<span style=\"padding-right: 20px; float:right; \">";
		insert_link( "bom.php?code=$code&level=16" , "Expand all" );
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		insert_link( "bom.php?code=$code&level=1" , "Collaps all" );
		echo "</span><br/><br/>";
		
		$myTabella = new classTabella;
		$myTabella->setTabella();
		$myTabella->stdAttributiTabella(array("width"=>"100%" , "align"=>"center" , "style"=>"padding: 10px 10px 10px 10px ;" ));
		
		if ( get_father( $code , 1 ) ) {
			$sql = "SELECT *  FROM `lista_composizione` WHERE `son` LIKE '$code' ";
			$result = query_get_result( $sql );
			$it = $result->num_rows;
			$myTabella->addValoreRiga(array( "&nbsp;" , "UP one level" ));
			$myTabella->aggiungiRiga(array( "style"=>"font-weight:bold; background-color:#eef;" ) , 2 , array(array( "style"=>"background-color:#eee;" ,"align"=>"center" , "width"=>"2%") , array( "colspan"=>"7" , "style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"10%") ) );
			for( $r = 0 ; $r < $it ; $r++ ) {
				$row = $result->fetch_array();
				$fc = $row["father"];
				$array = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$fc'" );
				$link = return_bom_link( $fc );
				$myTabella->addValoreRiga(array( "&nbsp;" , $link , $array["abbreviazione"] , $array["descrizione"] ));
				$myTabella->aggiungiRiga(array( "style"=>"background-color:#eee;" ) , 4 , array(array( "align"=>"center" ) ,  array( "align"=>"center" , "style"=>"border:1px solid #999; " ) ,  array( "align"=>"left" , "style"=>"border:1px solid #999; " )  , array( "colspan"=>"5" , "align"=>"left" , "style"=>"border:1px solid #999; " )  ) );
			}		
			$myTabella->addValoreRiga(array( "&nbsp;" ));
			$myTabella->aggiungiRiga(array( "style"=>"background-color:#eee;" ) , 1 , array(array( "align"=>"center" ) ) );
//			$myTabella->addValoreRiga(array( "&nbsp;" ));
//			$myTabella->aggiungiRiga(array( "style"=>"background-color:#eee;" ) , 1 , array(array( "align"=>"center" ) ) );
		}

		$myTabella->addValoreRiga(array( "&nbsp;" , "B.O.M." ));
		$myTabella->aggiungiRiga(array( "style"=>"font-weight:bold; background-color:#eef;" ) , 2 , array(array( "style"=>"background-color:#eee;" ,"align"=>"center" , "width"=>"2%") , array( "colspan"=>"7" , "style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"10%") ) );
		$myTabella->addValoreRiga(array( "" , "Code" , "Short description" , "Long description" , "Quantity" , "Unit" , "Actions" ));
		$myTabella->aggiungiRiga(array( "style"=>"font-weight:bold;" ) , 7 , array(array(  "align"=>"center" , "width"=>"2%") , array(  "style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"10%")  ,  array("style"=>"border:1px solid #999; " , "width"=>"15%", "align"=>"left")  ,  array("style"=>"border:1px solid #999; " , "width"=>"60%", "align"=>"left") , array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"5%"  )  ,  array("style"=>"border:1px solid #999; " , "align"=>"center" )  ,  array( "width"=>"12%" , "colspan"=> "2" , "style"=>"border:1px solid #999; " , "align"=>"center" ) ) );
		$link = return_code_link( $code );
		$atttext = "<a href=\"attributes.php?code=$code&action=create\"><b>Attributes New</b></a>";
		$chstyle = "border:1px solid #999;  background-color:#e99;border-radius: 7px;";
		$uexist = "-";
		if ( check_attributes_presence( $code ) ) {
			$atttext = "<a href=\"attributes.php?code=$code&action=Show\"><b>Attributes Show</b></a>";
			$chstyle = "border:1px solid #999;  background-color:#9e9;border-radius: 7px;";
			$uexist = "+";
		}
		$myTabella->addValoreRiga( array( "F" , $code , $code_detail["abbreviazione"] , $code_detail["descrizione"] , "-" , "-" , $atttext ));
		$myTabella->aggiungiRiga( array("style"=>"background-color:#fff;") , 7 , array(array( "width"=>"3%" , "style"=>"background-color:#eee;white-space: nowrap;" , "align"=>"center" , ) , array(  "style"=>"border:1px solid #999; font-weight:bold; " , "align"=>"center" )  ,  array("style"=>"border:1px solid #999;" , "align"=>"left")  ,  array("style"=>"border:1px solid #999; " , "align"=>"left") , array("style"=>"border:1px solid #999; " , "align"=>"center" )  ,  array("style"=>"border:1px solid #999; " , "align"=>"center" )  ,  array( "colspan"=> "2" , "style"=>$chstyle , "align"=>"center") ) );
		$level = 1;
		if ( $items )
			get_next_level_bom( $origin , $code , $level , $myTabella , $fhash , $hl , $maxlevel );

		$code_input = "<input style=\"border-radius: 7px;\" id=\"newcode\" name=\"newcode\" type=\"text\" size=\"10\" maxlength=\"10\" />";
		$quantity_input = "<input style=\"border-radius: 7px;\" id=\"quantity\" name=\"quantity\" type=\"numbers\" size=\"5\" maxlength=\"5\" />";
		$button = "<input style=\"border-radius: 7px;\" type=\"submit\" name=\"action\" value=\"Add to this bom\">";

		$myTabella->addValoreRiga( array( "" , $code_input , "" , $quantity_input , "" , $button ));
		$myTabella->aggiungiRiga( null , 6 , array( array(  "style"=>"background-color:#eee;" ) , array( "style"=>"border:1px solid #999; background-color:#c55;" , "align"=>"center"  )  , array( "colspan"=>"2" , "style"=>"border:1px solid #999; background-color:#c55;" ) , array( "style"=>"border:1px solid #999; background-color:#c55;" ) , array( "style"=>"border:1px solid #999; background-color:#c55;" ) , array( "style"=>"border:1px solid #999; background-color:#c55;" , "align"=>"center" , "colspan"=>"2"  )   ) );
	
		open_form( "GET" , "bom.php" );
		$myTabella->stampaTabella();
		add_hidden( "code" , $code );
		
		println( "<br/>" );
		println( "<br/></div>" );
	}


	function get_next_level_bom( $origin , $code , $curlevel , &$table , $hash , $hl = "" , $maxlevel = 1 ) {
		if ( ( $maxlevel >= 1 ) && ( $curlevel <= $maxlevel ) ) {
			$sql = "SELECT * FROM `lista_composizione` WHERE `father` LIKE '$code' ORDER BY `lista_composizione`.`modifyTS` DESC";
			$result = query_get_result( $sql );
			$items = $result->num_rows;
			$level = $curlevel;
			for( $r = 0 ; $r < $items ; $r++ ) {
				$row = $result->fetch_array();
				$son = $row["son"];
				if ( is_bom_allowed( $son ) )
					$link = return_bom_link( $son );
				else {
					if ( $hl != $son )
						$link = return_where_used_link( $son );
					else
						$link = return_where_used_link( $son , 1 );
				}
				$code_detail = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$son'" );
				$bglevel = get_level_bg_color( $level );
				$fglevel = get_level_fg_color( $level );
				if ( check_bom_presence( $son ) ) {
					$nlevel = $level + 1;
					$down = 1;
					if ( $level < $maxlevel ) 
						$level_link = "<a href=\"bom.php?code=$origin&level=$level\" ><b>-</b></a> <a href=\"code.php?code=$son\" ><b>C</b></a>";
					else
						$level_link = "<a href=\"bom.php?code=$origin&level=$nlevel\" ><b>+</b></a> <a href=\"code.php?code=$son\" ><b>C</b></a>";
				}
				else {
					$level_link = "";
					$down = 0;
				}
				$atttext = "<a href=\"attributes.php?code=$son&action=Create\"><b>Create</b></a>";
				$chstyle = "border:1px solid #999;  background-color:#e99;border-radius: 7px;";
				$uexist = "-";
				if ( check_attributes_presence( $son ) ) {
					$atttext = "<a href=\"attributes.php?code=$son&action=Show\"><b>Show</b></a>";
					$chstyle = "border:1px solid #999;  background-color:#9e9;border-radius: 7px;";
					$uexist = "+";
				}

				if ( check_in_bom_presence( $son , $hash ) ) {
					$remove_link = "<a href=\"bom.php?code=$code&delete=$son&action=Remove\"><b>Remove</b></a>";
					$remstyle = "border:1px solid #999;  background-color:#e99;border-radius: 7px;";
				}
				else {
					$remove_link = "";
					$remstyle = "background-color:#eee;";
				}
				if ( $hl != $son ) 
					$cstyle = "border:1px solid #999; font-weight:bold; background-color:#ddd;";
				else
					$cstyle = "border:1px solid #999; font-weight:bold; background-color:#ffd;";
				$table->addValoreRiga( array( $level_link , $link , $code_detail["abbreviazione"] , $code_detail["descrizione"] , $row["quantity"] , $uexist , $atttext , $remove_link ));
				$table->aggiungiRiga( array("style"=>"$bglevel $fglevel") , 8 , array( array(  "style"=>"background-color:#eee;white-space: nowrap;" , "align"=>"center" , "width"=>"2%") , array(  "style"=>$cstyle , "align"=>"center" )  ,  array("style"=>"border:1px solid #999;" , "align"=>"left" , "width"=>"15%" )  ,  array("style"=>"border:1px solid #999; " , "align"=>"left" , "width"=>"60%" ) , array("style"=>"border:1px solid #999; " , "align"=>"center" )  ,  array("style"=>"border:1px solid #999; " , "align"=>"center" )  ,  array("style"=>$chstyle , "align"=>"center"  , "width"=>"6%" )  ,  array("style"=>$remstyle , "align"=>"center" , "width"=>"6%") ) );
				if ( $down ) {
					get_next_level_bom( $origin , $son , $nlevel , $table , $hash , $hl , $maxlevel );
				}
			}
		}
	}
	
	
	function get_level_bg_color( $level ) {
		$result = "background-color:#";
		if ( $level == 0 )			 $result .= "fff";
		else if ( $level == 1  ) $result .= "ddd";
		else if ( $level == 2  ) $result .= "bbb";
		else if ( $level == 3  ) $result .= "999";
		else if ( $level == 4  ) $result .= "777";
		else if ( $level == 5  ) $result .= "555";
		else if ( $level == 6  ) $result .= "333";
		else if ( $level == 7  ) $result .= "111";
		$result .= "; ";
		return $result;
	}

	function get_level_fg_color( $level ) {
		$result = "color:#";
		if ( $level == 15 )			 $result .= "fff";
		else if ( $level == 14 ) $result .= "fff";
		else if ( $level == 13 ) $result .= "fff";
		else if ( $level == 12 ) $result .= "fff";
		else if ( $level == 11 ) $result .= "fff";
		else if ( $level == 10 ) $result .= "fff";
		else if ( $level == 9 )  $result .= "fff";
		else if ( $level == 8 )  $result .= "fff";
		else if ( $level == 7 )  $result .= "fff";
		else if ( $level == 6 )  $result .= "fff";
		else if ( $level == 5 )  $result .= "fff";
		else if ( $level == 4 )  $result .= "fff";
		else if ( $level == 3 )  $result .= "fff";
		else if ( $level == 2 )  $result .= "000";
		else if ( $level == 1 )  $result .= "000";
		else if ( $level == 0 )  $result .= "000";
		$result .= "; ";
		return $result;
	}


	function get_father( $son , $clean = 0 ) {
		$sql = "SELECT *  FROM `lista_composizione` WHERE `son` LIKE '$son' limit 0,1";
		$bom = query_single_line( $sql );
		if ( ! $bom )
			return "";
		if ( $clean ) 
			$link = $bom["father"];
		else
			$link = return_code_link( $bom["father"] );
		return $link;
	}


	function create_bom_environment( $father , $rev ) {
		$sql = "SELECT *  FROM `bom` WHERE `code` LIKE '$father' AND `Revisione` = $rev";
		$r = query_get_result( $sql );
		if ( $r ) {
			$row = $r->fetch_array();
			return $row["hashid"];
		}
		unset( $r );
		$hfather = md5( $father . " " . ext_today_human() );
		$sql  = "INSERT INTO `bom` (`idDistinta`, `code`, `hashid`, `Revisione`, `createTS`, `modifyTS`) ";
		$sql .= "VALUES (NULL, '$father', '$hfather', '$rev', current_timestamp(), current_timestamp())";
		query_insert_single_line( $sql );
		return $hfather;
	}


	function add_code_in_bom( $father , $code , $quantity , $rev = 1 ) {
		$sql = "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'";
		$check = query_get_num_rows( $sql );
		if ( ! $check ) {
			insert_blockquote( "$code: Code NOT found in the database.<br/><br/>Code NOT added." , "Caution" );
			return 0;
		}
		$hfather = create_bom_environment( $father , $rev );
		$sql = "SELECT *  FROM `lista_composizione` WHERE `father` LIKE '$father' AND `son` LIKE '$code' AND `revision` = $rev";
		$check = query_get_num_rows( $sql );
		if ( $check ) {
			insert_blockquote( "Code already present in this B.O.M. with Revison $rev.<br/><br/>Code NOT added." , "Caution" );
			return 0;
		}
		$sql  = "INSERT INTO `lista_composizione` (`id`, `hashid`, `father`, `son`, `quantity`, `revision`, `createTS`, `modifyTS`) ";
		$sql .= "VALUES (NULL, '$hfather', '$father', '$code', '$quantity', '$rev', current_timestamp(), current_timestamp())";
		query_insert_single_line( $sql );
		$sql = "SELECT *  FROM `lista_composizione` WHERE `father` LIKE '$father' AND `son` LIKE '$code' AND `revision` = $rev";
		$check = query_get_num_rows( $sql );
		if ( $check ) {
			insert_blockquote( "Code ADDED to this B.O.M. with Revison $rev." , "Success" );
			return 1;
		}
		else {
			insert_blockquote( "Code NOT added even if everything seems ok.<br/>Close and reopen the browser and try again, I'm sorry." , "Error" );
			return 0;
		}
	}

	function check_bom_presence( $code ) {
		$sql = "SELECT * FROM `lista_composizione` WHERE `father` LIKE '$code' ORDER BY `lista_composizione`.`modifyTS` DESC LIMIT 0,1";
		return query_get_num_rows( $sql );
	}


	function get_hashid_from_bom( $father ) {
		$sql = "SELECT *  FROM `bom` WHERE `code` LIKE '$father'";
		return query_get_a_field( $sql , "hashid" );
	}


	function check_upper_bom_presence( $code ) {
		$sql = "SELECT * FROM `lista_composizione` WHERE `father` LIKE \"%$code%\" Limit 0,1;";
		return ( query_get_num_rows( $sql ));
	}

	function check_in_bom_presence( $code , $hash = "%" ) {
		$sql = "SELECT *  FROM `lista_composizione` WHERE `son` LIKE '$code' and `hashid` LIKE '$hash' ORDER BY `createTS` DESC";
		return query_get_num_rows( $sql );
	}

	function return_bom_link( $code , $fl = 0 , $clean = 0 , $link = "bom.php?code" ) {
		if ( $clean ) 
			return $code;
		else {
			if ( $fl )
			return "<a href=\"$link=$code\" ><span class=\"blink_text\">$code</span></a>";
		else
			return "<a href=\"$link=$code\" >$code</a>";
		}
	}

	function return_where_used_text_link( $code , $link = "where_used.php?code" ) {
		return "<a href=\"$link=$code\">Where used</a>";
	}

	function return_where_used_link( $code , $hl = 0 , $link = "where_used.php?code" ) {
		if ( $hl )
			return "<a href=\"$link=$code\"><span class=\"blink_text\">$code</span></a>";
		else
			return "<a href=\"$link=$code\">$code</a>";
	}

	function is_bom_allowed( $code ) {
		$T = substr( $code , 0 , 1 );
		$sql = "SELECT *  FROM `tipologia` WHERE `idTip` = \"$T\"";
		$ret = query_get_a_field( $sql , "dbTip" );
//		echo $T . " " . $ret;
		return $ret;
	}
	
	
	function return_bom_link_highlighted( $code , $hl , $clean = 0 , $link = "bom.php?code" ) {
		if ( $clean ) 
			return $code;
		else
			return "<a href=\"$link=$code&hl=$hl\" >$code</a>";
	}

	
	
?>


