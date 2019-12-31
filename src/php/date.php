<?php
	
	function date_human( $date ) {
		return date( 'd-m-Y' , strtotime( $date ) );
	}

	function long_date_human( $date ) {
		setlocale(LC_TIME, "it_IT", "it", "it_IT.utf8");
		return date( 'd F Y' , strtotime( $date ) );
	}

	function time_human( $date ) {
		return strftime("%H:%M", $date ); 
		//return date('H:i' , $date );
	}

	function long_time_human( $date ) {
			return strftime("%H:%M:%S", $date ); 
//		return date('H:i:s' , $date );
	}

	function timestamp_human( $date ) {
		setlocale(LC_TIME, "it_IT", "it", "it_IT.utf8");
		return date( 'd-m-Y - H:i' , strtotime( $date ) );
	}

	function long_timestamp_human( $date ) {
		setlocale(LC_TIME, "it_IT", "it", "it_IT.utf8");
		return date( 'd F Y - H:i:s' , strtotime( $date ) );
	}


//-----------------------------------------------------------------------------------------------




	function date_mysql( $date ) {
		return date( 'Y-m-d   H:i' , strtotime( $date ) );
	}

	function today_mysql() {
		return date("Y-m-d");
	}

	function today_human() {
		return date("d-m-Y");
	}

	function ext_today_human() {
		return date("d-m-Y - H:i");
	}

	function make_timestamp_now() {
		return time();
	}
	
	function date_human_from_timestamp( $timestamp ) {
		return date( "r" , $timestamp );
	}
	
	function make_timestamp_from_human( $data ) {
		list($dd, $mm, $yyyy) = explode('-', $data);
		return mktime(0,0,0,$mm, $dd, $yyyy);
	}

	function make_timestamp_from_mysql( $data ) {
		list($yyyy, $mm, $gg) = explode('-', $data);
		return mktime(0,0,0,$mm, $gg, $yyyy);
	}



/*

$time1 = date('H:i:s', time() - date('Z')); // 12:50:29
$time2 = date('H:i:s', gmdate('U')); // 13:50:29
$time3 = date('H:i:s', time()); // 13:50:29
$time4 = time() - date('Z'); // 1433418629
$time5 = gmdate('U'); // 1433422229
$time6 = time(); // 1433422229

*/

?>






