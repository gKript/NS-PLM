<?php

	global	$gkcfg;

	class	gkMenu {
		
		var $level;
		
		function __construct ( $level = 0	) {
			$this->level = $level;
		}
		
		function get_level() {
			return $this->level;	
		}
		
		function open( $id , $style ) {
			$ret  = div_block_open( "" , $style );
			$ret .= generic_tag_open( "ul" , "" , "" , "" , $id ); 
			return $ret;
		}
		
		function close() {
			$ret  = generic_tag_close( "ul" );
			$ret .= div_block_close();
			return $ret;
		}
		
		function submenu_open( $name , $link = "" ) {
			$ret  = generic_tag_open( "li" ); 
			$ret .= link_generator( $link , $name );
			$ret .= generic_tag_open( "ul" ); 
			return $ret;
		}

		function submenu_close() {
			$ret  = generic_tag_close( "ul" );
			$ret .= generic_tag_close( "li" );
			return $ret;
		}
		
		function voice( $name , $link = "" ) {
			$url = link_generator( $link , $name );
			$ret = tag_enclosed( "li" , $url );
			return $ret;
		}
		
		
		
	}
	
?>