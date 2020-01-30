<?php

	function new_attrib_insert( $attr , $action , $en = 1 ) {
		global $attrib;
		if ( $action == "Insert" ) {
			extract( $attr );
			if ( ( $yyyy != "" ) && ( $mm != "" ) && ( $dd != "" ) ) {
				$ds = sprintf( "%02d" , $dd );
				$ms = sprintf( "%02d" , $mm );
				$ys = sprintf( "%04d" , $yyyy );
				$expdate = $ys . $ms . $ds;
				$expiration = 1;
				$attrib["expiration"] = 1;
			}
			else {
				$expdate = NULL;
				$expiration = 0;
				$attrib["expiration"] = 0;
			}
			$sql0 = "INSERT INTO `codattributes` (`code`, `bom`, `Supplier`, `origin`, `critical`, `important`, `testing`, `expiration`, `expiration_time`, `rohs`, `dangerous`, `regulatory`, `warranty`, `unit`, `compliance`, `traceability`, `consumables`, `length`, `width`, `height`, `weight`, `createTS`, `modifyTS`) ";
			$sql1 = "VALUES ('$code', '$bom', '$Supplier', '$origin', '$critical', '$important', '$testing', '$expiration', '$expdate', '$rohs', '$dangerous', '$regulatory', '$warranty', '$unit', '$compliance', '$traceability', '$consumables', '$length', '$width', '$height', '$weight', current_timestamp(), current_timestamp())";
			$sql = $sql0 . $sql1;
			if ( $en ) {
				query_insert_single_line( $sql );
				$sql = "SELECT *  FROM `codattributes` WHERE `code` LIKE '$code' ";
				$check = query_get_num_rows( $sql );
			}
			else 
				$check = 1;
			if ( $check ) { 
				insert_blockquote( "Attributes tab correctly ADDED." , "Success" );
				return 1;
			}
			else {
				insert_blockquote( "Attributes tab NOT added even if everything seems ok.<br/>Close and reopen the browser and try again, I'm sorry." , "Error" );
				return 0;
			}
		}
		else if ( $action == "Modify" ) {
			attrib_update_data( $attr );
			insert_blockquote( "Attributes tab correctly UPDATED." , "Success" );
		}
	}


	function check_attributes_presence( $code ) {
		$sql = "SELECT *  FROM `codattributes` WHERE `code` LIKE \"%$code%\" Limit 0,1;";
		return ( query_get_num_rows( $sql ));
	}


	function check_weight_attribute_presence( $code ) {
		$sql = "SELECT *  FROM `codattributes` WHERE `code` LIKE \"%$code%\" Limit 0,1;";
		return ( query_get_a_field( $sql , "weight" ));
	}


	function	attrib_get_data_from_sql() {
		global $attrib;
		$code = $attrib["code"];
		//var_dump( $attrib );
		foreach( $attrib as $key=>$value ) {
			if ( ( $key != "code" ) && ( $key != "action" ) && ( $key != "yyyy" ) && ( $key != "mm" ) && ( $key != "dd" ) ) {
				$sql = "SELECT `$key` FROM `codattributes` WHERE `code` LIKE '$code' ";
				$attrib[ $key ] = query_get_a_field( $sql , $key );
			}
		}
		$expdate = query_get_a_field( "SELECT `expiration_time` FROM `codattributes` WHERE `code` LIKE '$code' " , "expiration_time" );
		$attrib["yyyy"] = substr( $expdate , 0 , 4 );
		$attrib["mm"]   = substr( $expdate , 4 , 2 );
		$attrib["dd"]   = substr( $expdate , 6 , 2 );
	}


	function	attrib_update_data() {
		global $attrib;
		$code = $attrib["code"];
		foreach( $attrib as $key=>$value ) {
			if ( ( $key != "code" ) && ( $key != "action" ) && ( $key != "yyyy" ) && ( $key != "mm" ) && ( $key != "dd" ) ) {
				query_update_single_field( $code , "code" , "codattributes" , $key , $value );
			}
		}
		$ds = sprintf( "%02d" , $attrib[ "dd" ] );
		$ms = sprintf( "%02d" , $attrib[ "mm" ] );
		$ys = sprintf( "%04d" , $attrib["yyyy"] );
		$expdate = $ys . $ms . $ds;
		if ( ! (int)$expdate ) 
			$expdate = "";
		query_update_single_field( $code , "code" , "codattributes" , "expiration_time" , $expdate );
		
		attrib_get_data_from_sql();
	}


?>