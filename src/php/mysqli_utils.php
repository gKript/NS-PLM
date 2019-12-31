<?php
	
	
	function query_single_line( $query , $echo = 0 ) {
		global $mysqli;
		if ( $echo ) 
			echo "<br/>".$query."<br/><br/>";
		$result = query_get_result( $query );
		if ( $result )
			return $result->fetch_array();
		return NULL;
	}

	function query_get_result( $query  , $echo = 0 ) {
		global $mysqli;

		if ( $echo ) 
			echo $query."<br/>";
		$result = $mysqli->query ( $query ) or 
			die( "query_single_line() : Problem with query<br/>&nbsp;&nbsp;&nbsp;&nbsp;Query true: $query<br/>&nbsp;&nbsp;&nbsp;&nbsp;MySql :" . $mysqli->error ."<br/>" );
		if ( $result->num_rows != 0 )
			return $result;
		else 
			return NULL;
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



	function new_code_insert( $code , $sdescr , $ldescr , $bom = 0 ) {
		global $mysqli;
		
		$t = substr($code, 0, 1);
		$g = substr($code, 1, 1);
		$s = substr($code, 2, 1);
		
		$sql = "INSERT INTO `elenco_codici` (`idCodice`, `codice`, `T`, `CG`, `CS`, `abbreviazione`, `descrizione`, `dbCodici`, `createTS`, `modifyTS`) VALUES (NULL, '$code', '$t', '$g', '$s', '$sdescr', '$ldescr', '$bom', current_timestamp(), current_timestamp())";
		
		$mysqli->query ( $sql ) or 
			die( "query_single_line() : Problem with query<br/>&nbsp;&nbsp;&nbsp;&nbsp;Query : $query<br/>&nbsp;&nbsp;&nbsp;&nbsp;MySql :" . $mysqli->error ."<br/>" );
				
	}


	function query_insert_single_line( $query , $echo = 0 ) {
		global $mysqli;
		
		if ( $echo ) 
			echo $query."<br/>";
		$mysqli->query ( $query ) or 
			die( "query_single_line() : Problem with query<br/>&nbsp;&nbsp;&nbsp;&nbsp;Query : $query<br/>&nbsp;&nbsp;&nbsp;&nbsp;MySql :" . $mysqli->error ."<br/>" );
	}
	
	function query_update_single_field( $id , $id_field , $table , $field , $value ) {
		global $mysqli;
		
		$query = "UPDATE `Formazione_E_school`.`$table` SET `$field` = '$value' WHERE `$table`.`$id_field` = '$id' LIMIT 1;";
		$mysqli->query ( $query ) or 
			die( "query_single_line() : Problem with query<br/>&nbsp;&nbsp;&nbsp;&nbsp;Query : $query<br/>&nbsp;&nbsp;&nbsp;&nbsp;MySql :" . $mysqli->error ."<br/>" );
	}

	
	function query_delete_a_record( $query ) {
		global $mysqli;
		
		$mysqli->query ( $query ) or 
			die( "query_single_line() : Problem with query<br/>&nbsp;&nbsp;&nbsp;&nbsp;Query : $query<br/>&nbsp;&nbsp;&nbsp;&nbsp;MySql :" . $mysqli->error ."<br/>" );
	}


	function query_get_a_field( $query , $fname  , $echo = 0 ) {
		$result = query_get_result( $query );
		if ( ! $result ) 
			return null;
		if ( $row = $result->fetch_array() )
			return $row[ $fname ];
		else 
			return 0;
	}
	

	function query_get_num_rows( $query , $echo = 0 ) {
		global $mysqli;
		
		if ( $echo ) 
			echo $query."<br/>";
		$result = $mysqli->query ( $query ) or 
			die( "query_single_line() : Problem with query<br/>&nbsp;&nbsp;&nbsp;&nbsp;Query : $query<br/>&nbsp;&nbsp;&nbsp;&nbsp;MySql :" . $mysqli->error ."<br/>" );
		return $result->num_rows;
	}

	function db_error( $query , $line , $file ) {
		$message = "<h3>MySql ERROR !!!</h3><br/><strong>".$query."</strong><br/><br/>query : Query non valida<br/><tt>Linea <strong>".$line."</strong><br/>File  <strong>".$file."</strong></tt><br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;".$mysqli->error ;
			echo $message;
		exit();	
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

?>
