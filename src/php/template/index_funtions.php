<?php

	function is_context( $test ) {
		
		global $mysqli;
		
		if ( strlen( $test ) != 3 ) 
			return false;
		
		$upstr = strtoupper( $test );
	
		$T = substr( $upstr , 0 , 1 );
		$G = substr( $upstr , 1 , 1 );
		$S = substr( $upstr , 2 , 1 );

//		Tipology
		$sql = "SELECT * FROM `tipologia`";
		$result = query_get_result( $sql );
		$num = $result->num_rows;
		$rT = 0;
		for( $r = 0 ; $r < $num ; $r++ ) {
			$array = $result->fetch_array();
			if ( $T == $array["idTip"] ) 
				$rT++;
		}
//		Generic
		$sql = "SELECT * FROM `catgenerica`";
		$result = query_get_result( $sql );
		$num = $result->num_rows;
		$rG = 0;
		for( $r = 0 ; $r < $num ; $r++ ) {
			$array = $result->fetch_array();
			if ( $G == $array["idCatGen"] ) 
				$rG++;
		}

//		Specific
		$sql = "SELECT * FROM `catspecifica`";
		$result = query_get_result( $sql );
		$num = $result->num_rows;
		$rS = 0;
		for( $r = 0 ; $r < $num ; $r++ ) {
			$array = $result->fetch_array();
			if ( $S == $array["idCatSpec"] ) 
				$rS++;
		}
		if ( ( $rT == 1 ) && ( $rG == 1 ) && ( $rS == 1 ) )
			return true;
		return false;
	}
	
	function check_search_in_history( $search , $user ) {
		return query_get_num_rows( "SELECT * FROM `search` WHERE `user` LIKE '$user' LIMIT 0,1;" );
	}

	function add_search_in_history( $search , $user ) {
		if ( $search != "" ) {
			if ( $result = query_get_result( "SELECT *  FROM `search` WHERE `search` LIKE '$search' AND `user` LIKE '$user' " ) ) {
				$row = $result->fetch_array();
				$id = $row["id"];
				query_sql_run( "DELETE FROM `search` WHERE `search`.`id` = $id" );
				$ret = 1;
			}
			else {
				if ( query_get_num_rows( "SELECT * FROM `search` WHERE `user` LIKE '$user' " ) >= ITEMS_IN_HISTORY ) {
					$id = query_get_a_field( "SELECT * FROM `search`  WHERE `user` LIKE '$user' ORDER BY `search`.`createTS` ASC LIMIT 0,1" , "id" );
					query_sql_run( "DELETE FROM `search` WHERE `search`.`id` = $id" );
					$ret = 1;
				}
				if ( ! query_get_num_rows( "SELECT * FROM `search` WHERE `user` LIKE '$user' " ) )
					$ret = 0;
			} 
			query_sql_run( "INSERT INTO `search` (`id`, `search`, `user`, `createTS`) VALUES (NULL, '$search', '$user', current_timestamp())" );
			$ret = 1;
		}
		else
			$ret = check_search_in_history( $search , $user );
		return $ret;
	}


	function code_to_check() {
		$sql = "SELECT *  FROM `elenco_codici` WHERE `status` = 3 ORDER BY `elenco_codici`.`createTS`  ASC LIMIT 0, 20";
		$rtab = new classTabella;

		$rtab->stdAttributiTabella(array("border"=>"1","width"=>"50%","align"=>"center"));
		$rtab->addValoreRiga(array("Questo e' il titolo"));
		$rtab->aggiungiRiga(array("bgcolor"=>"white"),1,array(array("colspan"=>"3")));

		$rtab->addValoreRiga(array("R1C1","R1C2","R1C3"));
		$rtab->aggiungiRiga(array("bgcolor"=>"red"),3,array(array("bgcolor"=>"black"),array("bgcolor"=>"yellow" ),array("bgcolor"=>"yellow")));

		$rtab->addValoreRiga(array("R2C1","R2C2","R2C3"));
		$rtab->aggiungiRiga(array("bgcolor"=>"green"),3,array(array("bgcolor"=>""),array("bgcolor"=>""),array(" bgcolor"=>"")));

		$rtab->stampaTabella();
		
	}


?>


