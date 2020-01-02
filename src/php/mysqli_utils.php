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

	
	function query_sql_run( $query ) {
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

?>
