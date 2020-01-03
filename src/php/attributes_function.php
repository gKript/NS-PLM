<?php

function new_attrib_insert( $attr , $action , $en = 1 ) {
	global $attrib;
	if ( $action == "Insert" ) {
		extract( $attr );
		$expdate = NULL;
		if ( ( $yyyy != "" ) && ( $mm != "" ) && ( $dd != "" ) ) {
			$expdate = $yyyy . $mm . $dd;
			$expiration = 1;
			$attrib["expiration"] = 1;
		}
		$sql0 = "INSERT INTO `codattributes` (`code`, `bom`, `provider`, `origin`, `critical`, `important`, `testing`, `expiration`, `expiration_time`, `rohs`, `dangerous`, `regulatory`, `warranty`, `unit`, `compliance`, `tracebility`, `consumables`, `length`, `width`, `height`, `weight`, `createTS`, `modifyTS`) ";
		$sql1 = "VALUES ('$code', '$bom', '$provider', '$origin', '$critical', '$important', '$testing', '$expiration', '$expdate', '$rohs', '$dangerous', '$regulatory', '$warranty', '$unit', '$compliance', '$tracebility', '$consumables', '$length', '$width', '$height', '$weight', current_timestamp(), current_timestamp())";
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
}


function	attrib_update_data() {
	global $attrib;
	$code = $attrib["code"];
	foreach( $attrib as $key=>$value ) {
		if ( ( $key != "code" ) && ( $key != "action" ) && ( $key != "yyyy" ) && ( $key != "mm" ) && ( $key != "dd" ) ) {
			//$sql = "UPDATE `codattributes` SET `$key` = '$value' WHERE `codattributes`.`Codice` = '$code'";
			//echo $sql . "<br/>";
			query_update_single_field( $code , "code" , "codattributes" , $key , $value );
		}
	}
	attrib_get_data_from_sql();
}


?>