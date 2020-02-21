<?php

/*

		File: gk.php

		gK.php  -  gKript php library
		[asy][skymatrix]
		R 00.1.xx

*/


	global	$gkcfg;

	class	gkMenu {
		
		var $page;
		var $level;
		var $pinned_level;
		var $indent;
		var $output;
		
		function __construct ( $page , $level = 0	) {
			$this->output = 0;
			$this->level = $level;
			$this->page = $page;
			$this->indent = 0;
			$this->pinned_level[ $this->indent ] = $level;
		}
		
		function get_level() {
			return $this->level;	
		}

		function set_output( $output ) {
			$this->output = $output;	
		}
	
		function open( $id , $style = "" , $reqlevel = 0 ) {
//			if ( $reqlevel 
			$ret  = div_block_open( "" , $style );
			$ret .= generic_tag_open( "ul" , "" , "" , "" , $id );
			if ( $this->output ) echo $ret;				
			return $ret;
		}
		
		function close() {
			$ret  = generic_tag_close( "ul" );
			$ret .= div_block_close();
			if ( $this->output ) echo $ret;				
			return $ret;
		}
		
		function submenu_open( $reqlevel , $name , $link = "" ) {
			$ret = "";
			$this->indent++;
			$this->pinned_level[ $this->indent ]  = $reqlevel;
			if ( $this->pinned_level[ $this->indent ] <= $this->level ) {
				$ret  = generic_tag_open( "li" ); 
				$ret .= link_generator( $link , $name );
				$ret .= generic_tag_open( "ul" ); 
			}
			if ( $this->output ) echo $ret;				
			return $ret;
		}

		function submenu_close() {
			$ret = "";
			if ( $this->pinned_level[ $this->indent ] <= $this->level ) {
				$ret  = generic_tag_close( "ul" );
				$ret .= generic_tag_close( "li" );
				if ( $this->indent == 1 )
					$ret .= $this->separator(1);
			}
			unset( $this->pinned_level[ $this->indent ] );
			$this->indent--;
			if ( $this->output ) echo $ret;				
			return $ret;
		}
		
		function voice( $name , $link = "" ) {
			$ret = "";
			if ( $this->pinned_level[ $this->indent ] <= $this->level ) {
				$url = link_generator( $link , $name );
				$ret = tag_enclosed( "li" , $url );
			}
			if ( $this->output ) echo $ret;				
			return $ret;
		}
		
		
		
		function voice_icon( $icon , $alt , $w , $h , $blink = 0 ) {
			$ret = "";
			if ( $this->pinned_level[ $this->indent ] <= $this->level ) {
				$tx = "";
				if ( $blink ) $tx .= generic_tag_open( "span" , "blink_text" );
				$tx .= link_generator( "message.php?action=list" , "" , "" , "" , "" , "" );
				$tx .= img_generator( $icon , $alt , "" , "" , "autoclose" , 0 , $w , $h );
				$tx .= generic_tag_close( "a" );
				if ( $blink ) $tx .= generic_tag_close( "span" );
				$ret = tag_enclosed( "li" , $tx );
			}
			if ( $this->output ) echo $ret;				
			return $ret;
		}
		
		
		function separator( $sp = 2 ) {
			$sep = "";
			for( $l = 0 ; $l < $sp ; $l++ )
				$sep .= "&nbsp;";
			$ret = tag_enclosed( "li" , $sep );
			if ( $this->output ) echo $ret;				
			return $ret;
		}
		
		
	}
	
?>