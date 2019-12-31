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


?>


