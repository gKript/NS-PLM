<?php

	require_once NSID_PLM_SRC_PHP . 'html.php';
	
	function open_block( $title , $icon = "" , $class ="codelite" ) {
		$url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];	
		//echo $page;		
		$page  = div_block_open( $class );
		$page .= link_generator( $url , img_generator( "top.svg" , "icona top" , "" , "float: right;" ) );
//		$text = img_generator( "syn.svg" , "icona synopsis" ) . $title;
//		echo tag_enclosed( "h2" , $title , "vertical-align: middle;" );
		$page .= title_h2( $title , $icon );
		$page .= BR( 1 , 0 );
		return $page;	
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
			$text = img_generator( $icon , "generic tag" ) . $title;
		$ret = tag_enclosed( "h2" , $text , "vertical-align: middle;" );
//		$ret .= BR( 1 , 0 );
		return $ret;
	}
	
?>
