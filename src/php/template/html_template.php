<?php

	function open_block( $title = "" , $icon = "" , $class ="codelite" ) {
		$url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];	
		$page = "";
		if ( $title != "" ) 
			$page  = div_block_open( $class , "padding-left: 16px; padding-right: 16px;" );
		$page .= link_generator( $url , img_generator( "top.svg" , "icona top" , "" , "float: right;" , "autoclose" , 0 , 24 , 24) );
		if ( ! $icon ) {
			$text = $title;
			$st =  "margin-left: 12px; vertical-align: middle; ";
		}
		else {
			$text = img_generator( $icon , "Generic tag" , "" , "margin-left: 12px;" , "autoclose" , 0 , 24 , 24 ).$title;
			$st = "vertical-align: middle;";
		}
		$page .= tag_enclosed( "h2" , $text , $st );
		$page .= BR( 1 , 0 );
		return $page;	
	}
	
	function open_block_no_top( $title = "" , $icon = "" , $class ="codelite" ) {
		$url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];	
		$page = "";
		if ( $title != "" ) 
			$page  = div_block_open( $class , "padding-left: 16px; padding-right: 16px;" );
		if ( ! $icon ) {
			$text  = $title;
			$st =  "margin-left: 12px; vertical-align: middle; ";
		}
		else {
			$text  = img_generator( $icon , "Generic tag" , "" , "margin-left: 12px;" , "autoclose" , 0 , 24 , 24 ). $title;
			$st = "vertical-align: middle;";
		}
		$page .= tag_enclosed( "h2" , $text , $st );
		$page .= BR( 1 , 0 );
		return $page;	
	}
	
	function insert_blockquote( $text , $type = "Blockquote" , $die = 0 ) {
		
		global $mysqli;
		
		$im = "";
		$border = "";
		if ( $type == "Blockquote" )
			$border = "border-top:1px solid #999; border-bottom:1px solid #999; background-color:#edd;";

		if ( $type == "Notice" )
			$border = "border-top:1px solid #999; border-bottom:1px solid #999; background-color:#eef;";
		else if ( $type == "Caution" )
			$border = "border-top:4px solid #e8e848; border-bottom:4px solid #e8e848; background-color:#ffd;";
		else if ( $type == "Warning" )
			$border = "border-top:4px solid #be0000; border-bottom:4px solid #be0000; background-color:#fee; text-align: justify; text-justify: inter-word;";
		else if ( $type == "Error" )
			$border = "border-top:10px solid #be0000; border-bottom:10px solid #be0000; background-color:#f99;";
		else if ( $type == "Success" )
			$border = "border-top:10px solid #8f8; border-bottom:10px solid #8f8; background-color:#dfd;";
		else if ( $type == "Are you sure?" )
			$border = "border-top:10px solid #f88; border-bottom:10px solid #f88; background-color:#fdd;";
		else if ( $type == "Redirect" )
			$border = "border-top:4px solid #e8e848; border-bottom:4px solid #e8e848; background-color:#ffd;";
		else {
			$border = "border:1px solid #be0000; background-color:#eee;";
			$im = "message";
		}
		
		if ( $type == "Are you sure?" )
			$type = "sure";

		if ( $type != "Blockquote" ) {
			echo generic_tag_open( "blockquote" , "" , $border );
			if ( $im != "" ) 
				echo 	img_generator( $im.".svg" , $type , "" , "float: left; margin: 20px; vertical-align: middle; " , "autoclose" , 0 , 72 , 72 );
			else
				echo 	img_generator( $type.".svg" , $type , "" , "float: left; margin: 20px; vertical-align: middle; " , "autoclose" , 0 , 72 , 72 );
			echo 	generic_tag_open( "p" );
//			$type = "Please wait";
			
		if ( $type == "sure" )
			$type = "Are you sure?";

			println( $text );
			echo 	BR(2);
//			$tx  = "&nbsp;&nbsp;&nbsp;&nbsp;";
			$tx = generic_tag_open( "span" , "blink_text" );
			$tx .= $type;
			$tx .= generic_tag_close( "span" );
			echo 	tag_enclosed( "h2" , $tx );
			echo 	BR();
			echo  generic_tag_close( "p" );
		}
		else {
			echo generic_tag_open( "blockquote" , "" , $border  );
			echo 	tag_enclosed( "p" , $text );
		}
		if ( ( $type == "Notice" ) || ( $type == "Success" )  || ( $type == "Warning" ) )
			echo BR(2);
		if ( $die ) {
			if ( ! $mysqli->connect_error ) {
				$mysqli->close();
			}
			die();
		}
		echo  generic_tag_close( "blockquote" );
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
	
	function title_h2( $title , $icon = "" , $style = "" ) {
		if ( $icon == "" )
			$text = $title;
		else
			$text = img_generator( $icon , "generic tag" , "" , "" , "autoclose" , 0 , 24 , 24 ) . $title;
		$ret = tag_enclosed( "h2" , $text , "vertical-align: middle;  $style" );
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
