<?php

	function create_bom_table( $code , $maxlevel ) {
		$sql = "SELECT * FROM `lista_composizione` WHERE `father` LIKE '$code' ORDER BY `lista_composizione`.`modify` DESC";
		$items = 0;
		$result = query_get_result( $sql );
		if ( $result ) 
			$items = $result->num_rows;
		$code_detail = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'" );
		$level = 0;
		$origin = $code;
		
		println( "<div class=\"codelite\">" );
		println( "<h2>Bill of Materials</h2><br/>" );
		$myTabella = new classTabella;

		$myTabella->setTabella();
		$myTabella->stdAttributiTabella(array("class"=>"codellite_img" , "width"=>"100%" , "align"=>"center" , "style"=>"padding-left: 10px; padding-right: 10px;" ));
		
		$myTabella->addValoreRiga(array( "" , "Code" , "Short description" , "Long description" , "Quantity" , "Unit" , "Attributes" ));
		$myTabella->aggiungiRiga(array( "style"=>"font-weight:bold;" ) , 7 , array(array(  "align"=>"center" , "width"=>"2%") , array(  "style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"10%")  ,  array("style"=>"border:1px solid #999; " , "width"=>"30px", "align"=>"left")  ,  array("style"=>"border:1px solid #999; " , "width"=>"50px", "align"=>"left") , array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"5%"  )  ,  array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"5%" )  ,  array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"80px" ) ) );
		$link = return_code_link( $code );
		$atttext = "<a href=\"attributes.php?code=$code&action=create\"><b>Create</b></a>";
		$chstyle = "border:1px solid #999;  background-color:#e99;";
		$uexist = "-";
		if ( check_attributes_presence( $code ) ) {
			$atttext = "<a href=\"attributes.php?code=$code\"><b>Show</b></a>";
			$chstyle = "border:1px solid #999;  background-color:#9e9;";
			$uexist = "+";
		}
		$myTabella->addValoreRiga( array( "F" , $link , $code_detail["abbreviazione"] , $code_detail["descrizione"] , "-" , "-" , $atttext ));
		$myTabella->aggiungiRiga( array("style"=>"background-color:#fff;") , 7 , array(array(  "style"=>"background-color:#eee;" , "align"=>"center") , array(  "style"=>"border:1px solid #999; font-weight:bold; " , "align"=>"left" , "align"=>"center" )  ,  array("style"=>"border:1px solid #999;" , "align"=>"left")  ,  array("style"=>"border:1px solid #999; " , "align"=>"left") , array("style"=>"border:1px solid #999; " , "align"=>"center" )  ,  array("style"=>"border:1px solid #999; " , "align"=>"center" )  ,  array("style"=>$chstyle , "align"=>"center") ) );
		$level = 1;
		if ( $items )
			get_next_level_bom( $origin , $code , $level , $myTabella , $maxlevel );
//		$l = "<span class=\"blink_text\"><a href=\"bom_insert.php&father=$code\" >ADD A NEW CODE TO THIS BOM</a></span>";
		
//		$myTabella->addValoreRiga( array( "" , $l ));
//		$myTabella->aggiungiRiga( null , 2 , array( array(  "style"=>"background-color:#eee;" , "align"=>"center" , "width"=>"1%") , array("colspan"=>"5" , "style"=>"border:1px solid #999; font-weight:bold; background-color:#faa;" , "align"=>"center"  ) ) );

		$code_input = "<input id=\"newcode\" name=\"newcode\" type=\"text\" size=\"10\" maxlength=\"10\" />";
		$quantity_input = "<input id=\"quantity\" name=\"quantity\" type=\"numbers\" size=\"5\" maxlength=\"5\" />";
		$button = "<input type=\"submit\" name=\"action\" value=\"Add to this bom\">";

		$myTabella->addValoreRiga( array( "" , $code_input , "" , $quantity_input , "" , $button ));
		$myTabella->aggiungiRiga( null , 6 , array( array(  "style"=>"background-color:#eee;" ) , array( "style"=>"border:1px solid #999; background-color:#c55;" , "align"=>"center"  )  , array( "colspan"=>"2" , "style"=>"border:1px solid #999; background-color:#c55;" ) , array( "style"=>"border:1px solid #999; background-color:#c55;" ) , array( "style"=>"border:1px solid #999; background-color:#c55;" ) , array( "style"=>"border:1px solid #999; background-color:#c55;" , "align"=>"center"  )   ) );
	
		open_form( "GET" , "bom.php" );
		$myTabella->stampaTabella();
		
		add_hidden( "code" , $code );
		
		println( "<br/>" );
		echo "<span style=\"padding-left: 33px;\">";
		insert_link( "bom.php?code=$code&level=16" , "Expand all" );
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		insert_link( "bom.php?code=$code&level=1" , "Collaps all" );
		echo "</span>";
		println( "<br/></div>" );
	}


	function get_next_level_bom( $origin , $code , $curlevel , &$table , $maxlevel = 1 ) {
		if ( ( $maxlevel >= 1 ) && ( $curlevel <= $maxlevel ) ) {
			$sql = "SELECT * FROM `lista_composizione` WHERE `father` LIKE '$code' ORDER BY `lista_composizione`.`modify` DESC";
			$result = query_get_result( $sql );
			$items = $result->num_rows;
			$level = $curlevel;
			for( $r = 0 ; $r < $items ; $r++ ) {
				$row = $result->fetch_array();
				$son = $row["son"];
				$link = return_code_link( $son );
				$code_detail = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$son'" );
				$bglevel = get_level_bg_color( $level );
				$fglevel = get_level_fg_color( $level );
				if ( check_bom_presence( $son ) ) {
					$nlevel = $level + 1;
					$down = 1;
					if ( $level < $maxlevel ) 
						$level_link = "<a href=\"bom.php?code=$origin&level=$level\" ><b>-</b></a>";
					else
						$level_link = "<a href=\"bom.php?code=$origin&level=$nlevel\" ><b>+</b></a>";
				}
				else {
					$level_link = "";
					$down = 0;
				}
				$atttext = "<a href=\"attributes.php?code=$son&action=Create\"><b>Create</b></a>";
				$chstyle = "border:1px solid #999;  background-color:#e99;";
				$uexist = "-";
				if ( check_attributes_presence( $son ) ) {
					$atttext = "<a href=\"attributes.php?code=$son&action=Show\"><b>Show</b></a>";
					$chstyle = "border:1px solid #999;  background-color:#9e9;";
					$uexist = "+";
				}
			$table->addValoreRiga( array( $level_link , $link , $code_detail["abbreviazione"] , $code_detail["descrizione"] , $row["quantity"] , $uexist , $atttext ));
			$table->aggiungiRiga( array("style"=>"$bglevel $fglevel") , 7 , array( array(  "style"=>"background-color:#eee;" , "align"=>"center" , "width"=>"1%") , array(  "style"=>"border:1px solid #999; font-weight:bold; background-color:#ddd;" , "align"=>"left" , "align"=>"center" )  ,  array("style"=>"border:1px solid #999;" , "align"=>"left")  ,  array("style"=>"border:1px solid #999; " , "align"=>"left") , array("style"=>"border:1px solid #999; " , "align"=>"center" )  ,  array("style"=>"border:1px solid #999; " , "align"=>"center" )  ,  array("style"=>$chstyle , "align"=>"center") ) );
			if ( $down )
				get_next_level_bom( $origin , $son , $nlevel , $table , $maxlevel );
			}
		}
	}
	
	
	function check_attributes_presence( $code ) {
		$sql = "SELECT *  FROM `codattributes` WHERE `code` LIKE \"%$code%\" Limit 0,1;";
		return ( query_get_num_rows( $sql ));
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
		else if ( $level == 3 )  $result .= "000";
		else if ( $level == 2 )  $result .= "000";
		else if ( $level == 1 )  $result .= "000";
		else if ( $level == 0 )  $result .= "000";
		$result .= "; ";
		return $result;
	}


	function get_father( $son ) {
		$sql = "SELECT *  FROM `lista_composizione` WHERE `son` LIKE '$son' limit 0,1";
		$bom = query_single_line( $sql );
		if ( ! $bom ) 
			return "";
		$link = return_code_link( $bom["father"] );
		return $link;
	}


	function add_code_in_bom( $father , $code , $quantity , $rev = 1 ) {
		$sql = "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'";
		$check = query_get_num_rows( $sql );
		if ( ! $check ) {
			insert_blockquote( "$code: Code NOT found in the database.<br/><br/>Code NOT added." , "Caution" );
			return 0;
		}
		$sql = "SELECT *  FROM `lista_composizione` WHERE `father` LIKE '$father' AND `son` LIKE '$code' AND `revision` = $rev";
		$check = query_get_num_rows( $sql );
		if ( $check ) {
			insert_blockquote( "Code already present in this B.O.M. with Revison $rev.<br/><br/>Code NOT added." , "Caution" );
			return 0;
		}
		$sql = "INSERT INTO `lista_composizione` (`id`, `father`, `son`, `quantity`, `revision`, `creation`, `modify`) VALUES (NULL, '$father', '$code', '$quantity', '$rev', current_timestamp(), current_timestamp())";
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


?>

