<?php

	
	function open_block( $title , $icon = "" , $class ="codelite" ) {
		$url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];	
		//echo $page;		
		$page  = div_block_open( $class , "padding-left: 16px; padding-right: 16px;" );
		$page .= link_generator( $url , img_generator( "top.svg" , "icona top" , "" , "float: right;" , "autoclose" , 0 , 24 , 24) );
		if ( ! $icon ) {
			$text  = $title;
			$st =  "margin-left: 12px; vertical-align: middle; ";
		}
		else {
			$text  = img_generator( $icon , "Generic tag" , "" , "margin-left: 12px;" , "autoclose" , 0 , 24 , 24 ) . $title;
			$st = "vertical-align: middle;";
		}
		$page .= tag_enclosed( "h2" , $text , $st );
//		$page .= title_h2( $title , $icon );
		$page .= BR( 1 , 0 );
		return $page;	
	}
	
	
	function close_block() {
		return div_block_close();
	}	
	
	function top_link( ) {
		$page = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];	
		//echo $page;
		$ret  = link_generator( $page , img_generator( "top.svg" , "icona top" , "" , "float: right;" ) );
		$ret .= BR( 2 , 0 );
		return $ret;
	}
	
	function title_h2( $title , $icon = "" ) {
		if ( $icon == "" )
			$text = $title;
		else
			$text = img_generator( $icon , "generic tag" , "" , "" , "autoclose" , 0 , 24 , 24 ) . $title;
		$ret = tag_enclosed( "h2" , $text , "vertical-align: middle;" );
//		$ret .= BR( 1 , 0 );
		return $ret;
	}
	
	function title_h3( $title , $icon = "" ) {
		if ( $icon == "" )
			$text = $title;
		else
			$text = img_generator( $icon , "generic tag" , "" , "" , "autoclose" , 0 , 24 , 24 ) . $title;
		$ret = tag_enclosed( "h3" , $text , "vertical-align: middle;" );
//		$ret .= BR( 1 , 0 );
		return $ret;
	}
	
?>
