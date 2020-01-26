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
					$id = query_get_a_field( "SELECT * FROM `search`  WHERE `user` LIKE '$user' ORDER BY `search`.`createTS` ASC LIMIT 0,1" , "id" , 1 );
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



?>


