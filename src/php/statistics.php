<?php
 
 
	function stat_CodeCountDaily() {
		$ins = 0;
		$name = "CodeCountDaily";
		$today = today_mysql();
		$sql = "SELECT * FROM `statistics` WHERE `name` = '$name' AND `timest` like '$today%'";
		$res = query_get_num_rows( $sql );
		if ( ! $res ) {
			$codnum = stat_codes_total_from_codes();
			$sql = "INSERT INTO `statistics` (`statid`, `name`, `value`, `timest`) VALUES (NULL, '$name', '$codnum', current_timestamp())";
			query_insert_single_line( $sql );
			$ins = 1;
		}
		return $ins;
	}
 
	function stat_AttribCountDaily() {
		$ins = 0;
		$name = "AttribCountDaily";
		$today = today_mysql();
		$sql = "SELECT * FROM `statistics` WHERE `name` = '$name' AND `timest` like '$today%'";
		$res = query_get_num_rows( $sql );
		if ( ! $res ) {
			$attnum = stat_attrib_total_from_attrib();
			$sql = "INSERT INTO `statistics` (`statid`, `name`, `value`, `timest`) VALUES (NULL, '$name', '$attnum', current_timestamp())";
			query_insert_single_line( $sql );
			$ins = 1;
		}
		return $ins;
	}


	function stat_BomCountDaily() {
		$ins = 0;
		$name = "BomCountDaily";
		$today = today_mysql();
		$sql = "SELECT * FROM `statistics` WHERE `name` = '$name' AND `timest` like '$today%'";
		$res = query_get_num_rows( $sql );
		if ( ! $res ) {
			$bom = 0;
			$result = query_get_result( "SELECT * FROM `elenco_codici`" );
			$items = $result->num_rows;
			for( $r = 0 ; $r < $items ; $r++ ) {
				$row = $result->fetch_array();
				$code = $row["codice"];
				$sql = "SELECT *  FROM `lista_composizione` WHERE `father` LIKE '$code' ORDER BY `lista_composizione`.`modify` DESC LIMIT 0,1";	
				$bom += query_get_num_rows( $sql );
			}
			$sql = "INSERT INTO `statistics` (`statid`, `name`, `value`, `timest`) VALUES (NULL, '$name', '$bom', current_timestamp())";
			query_insert_single_line( $sql );
			$ins = 1;
		}
		return $ins;
	}



	function stat_presence_of_context( $th = 10 ) {
		
		global $codetype;
		
		$totcodnum  = query_get_num_rows( "SELECT * FROM `elenco_codici`" );
		$context = $codetype["T"] . $codetype["CG"] . $codetype["CS"];
		$sql = "SELECT * FROM `elenco_codici` WHERE `codice` LIKE '$context%'";
		$totcontext = query_get_num_rows( $sql );
		$perc = (int)( ( (float)$totcontext / (float)$totcodnum ) * 100 );
		if ( $totcontext ) {
			if ( $perc <= $th ) {
				insert_blockquote( "Context occurrences in the database: <b>$perc%</b>.<br/><br/>Please, double check it before to proceed!" , "Unusual context!");
			}
		}
		else 
			insert_blockquote( "This code is not yet present in the databse.<br/>Please, double check it before to proceed!" , "Context never used before!");
	} 
 
 
	function stat_codes_total_from_codes() {
		return query_get_num_rows( "SELECT * FROM `elenco_codici`" );
	}

		
	function stat_attrib_total_from_attrib() {
		return query_get_num_rows( "SELECT * FROM `codattributes`" );
	}
		
	
	function stat_codes_total_from_stats( $sentence = 1 ) {
		$sql = "SELECT * FROM `statistics` WHERE `name` = 'CodeCountDaily' ORDER BY `statistics`.`timest` DESC LIMIT 0,1";
		$value = query_get_a_field( $sql , "value" );
		if ( $sentence )
			return "We are managing $value codes!";
		else
			return $value;
	}
		
		
	function stat_attributes_total_from_stats( $sentence = 1 ) {
		$sql = "SELECT * FROM `statistics` WHERE `name` = 'AttribCountDaily' ORDER BY `statistics`.`timest` DESC LIMIT 0,1";
		$value = query_get_a_field( $sql , "value" );
		if ( $sentence )
			return "We are managing $value attributes!";
		else
			return $value;
	}
		
	function stat_bom_total_from_stats( $sentence = 1 ) {
		$sql = "SELECT * FROM `statistics` WHERE `name` = 'BomCountDaily' ORDER BY `statistics`.`timest` DESC LIMIT 0,1";
		$value = query_get_a_field( $sql , "value" );
		if ( $sentence )
			return "We are managing $value B.O.M.!";
		else
			return $value;
	}
		
		
	function stat_top_n_context( $n = 10 ) {
		$tot = stat_codes_total_from_codes();
		$Tn = query_get_num_rows( "SELECT * FROM `tipologia`" );
		$Gn = query_get_num_rows( "SELECT * FROM `catgenerica`" );
		$Sn = query_get_num_rows( "SELECT * FROM `catspecifica`" );
		
		for( $T = $Tn ; $T > 0 ; $T-- ) {
			for( $G = $Gn ; $G > 0 ; $G-- ) {
				for( $S = $Sn ; $S > 0 ; $S-- ) {
				$Ts = query_get_a_field( "SELECT * FROM `tipologia` WHERE `ind` LIKE $T"	, "idTip" );
				$Gs = query_get_a_field( "SELECT * FROM `catgenerica` WHERE `ind` LIKE $G"	, "idCatGen" );
				$Ss = query_get_a_field( "SELECT * FROM `catspecifica` WHERE `ind` LIKE $S"	, "idCatSpec" );
				$index = (string)"$Ts". "$Gs" . "$Ss";
				$res[ $index ] = query_get_num_rows( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$index%'" );
				}
			}
		}
		arsort( $res );
		reset( $res );
		for( $r = 0 ; $r < $n ; $r++ ) {
			$k = (string)key( $res );
			$perc = (int)( ( (float)$res[ $k ] / (float)$tot ) * 100 );
			$ret[ $r ] = array( 'id'=>$r, 'context'=>(string)$k, 'value'=>$res[ $k ], 'perc'=>$perc );
			next( $res );
		}
		return $ret;
	}
		
	
			
 ?>
 