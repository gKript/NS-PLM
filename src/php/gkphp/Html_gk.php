<?php

	function DocType( $html = "HTML 5" ) {
		print( "<!DOCTYPE " );
		if ( $html == "HTML 5" ) 
			print( "html" );
		
		if ( $html == "HTML 4.01 Strict" ) 
			print( 'HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"' );
		
		if ( $html == "HTML 4.01 Transitional" ) 
			print( 'HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"' );
		
		if ( $html == "HTML 4.01 Frameset" ) 
			print( 'HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd"' );

		if ( $html == "XHTML 1.0 Strict" ) 
			print( 'html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"' );
		
		if ( $html == "XHTML 1.0 Transitional" ) 
			print( 'html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"' );
		
		if ( $html == "XHTML 1.0 Frameset" ) 
			print( 'html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd"' );
		
		if ( $html == "XHTML 1.1" ) 
			print( 'html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"' );
		
		println( ">" );
	}

	function html_open( $xmlns ) {
		println( "<html xmlns=\"$xmlns\" >" );
	}

	function html_close() {
		println( "</html>" );
	}
	
	
	function generic_tag_open( $tag , $class ="" , $style ="" , $type = "" , $id = "" ) {
		$ret  = "<$tag";
		$ret .= $class == "" ? "" : " class=\"$class\"";
		$ret .= $style == "" ? "" : " style=\"$style\"";
		$ret .= $id == "" ? "" : " id=\"$id\"";
		$ret .= $type == "" ? "" : " /";
		$ret .= ">\n";
		return $ret;
	}

	function generic_tag_close( $tag ) {
		return "</$tag>\n";		
	}
	
	function BR( $repeat = 1 , $clean = 1 , $class = "" ) {
		$ret = "";
		$cl  = $class == ""	? ""	: "class=\"$class\"";

		for( $r = 0 ; $r < $repeat ; $r++ ) {
			if ( ! $clean )
				$ret .= "<br $cl />\n";
			else
				echo "<br $cl />\n";
		}
		return $ret;
	}
	
	function TAB( $repeat = 1 , $print = 1 ) {
		$ret = "";
		$sp = "&nbsp;&nbsp;&nbsp;&nbsp;\n";
		for( $r = 0 ; $r < $repeat ; $r++ ) {
			if ( ! $print )
				$ret .= $sp;
			else
				echo $sp;
		}
		return $ret;
	}
	
	function tag_enclosed( $tag , $enclose , $style = "" ) {
		$ret  = "<$tag";
		$ret .= $style == "" ? ">\n" : " style=\"$style\" >\n";
		$ret .= $enclose;
		if( strpos( $enclose , '\n' ) !== false )
			echo "\n";
		$ret .= "</$tag>\n";
		return $ret;
	}

	function	img_generator( $img , $alt , $path = "" , $style = "" , $tag = "autoclose" , $border = 0 , $width = 0 , $heigth = 0 ) {
		$b = $border != 0	? $border	: "";
		$w = $width != 0	? $width	: "";
		$h = $heigth != 0	? $heigth	: "";
		$ss = $style != ""	? $style	: "";
		$s = "style=\"$ss\"";
		$c = "/";
		if ( ! $path )
			$path = "src/img/";
		if ( $tag != "autoclose" )
			$c = "";
		return "<img src=\"$path$img\" $s alt=\"$alt\" width=\"$w\" heigth=\"$h\" border=\"$b\" $c>\n";
	}

	function div_block_open( $class = "" , $style = "" , $id = "" ) {
		$ret  = "<div";
		$ret .= $class == "" ? "" : " class=\"$class\"";
		$ret .= $style == "" ? "" : " style=\"$style\"";
		$ret .= $id == "" ? "" : " id=\"$id\"";
		$ret .= ">\n";
		return $ret;
	}

	function div_block_close() {
		return "</div>\n";
	}
	
	
	function link_generator( $href , $text = "" , $target = "" , $style = "" , $tag = "autoclose" ) {
		$ret  = "<a";
		$ret .= $href == ""	?  "" : " href=\"$href\"";
		$ret .= $target == ""	? "" : " target=\"$target\"";
		$ret .= $style == ""	? "" : " style=\"$style\"";
		$ret .= ">";	
		$ret .= $text;
		$ret .= $tag == "autoclose"	? "</a>\n" : "\n";
		return $ret;
	}
	
	
	function open_script( $type ) {
		return "<script type=\"$type\">";
	}


	function close_script() {
		return "</script>";
	}


	function table_open( $border = 0 , $width = "" , $class = "" , $style = "" , $id = "" ) {
		$style .= $border == 0 ? "" : "border: $norderpx solid black; ";
		$style .= $width == "" ? "" : "width: $width; ";
		$ret  = "<table";
		$ret .= $class == "" ? "" : " class=\"$class\"";
		$ret .= $style == "" ? "" : " style=\"$style\"";
		$ret .= $id == "" ? "" : " id=\"$id\"";
		$ret .= ">\n";
		return $ret;
	}

	function row_open( $style = "" ) {
		$ret  = "<tr";
		$ret .= $style == "" ? "" : " style=\"$style\"";
		$ret .= ">\n";
		return $ret;
	}	
	
	function col_open( $border = 0 , $width = "" , $style = "" ) {
		$style .= $border == 0 ? "" : " border: $norderpx solid black;";
		$style .= $width == "" ? "" : " width: $width;";
		$ret  = "<td";
		$ret .= $style == "" ? "" : " style=\"$style\"";
		$ret .= ">\n";
		return $ret;
	}
	
	function col_close() {
		return generic_tag_close( "td" );
	}

	function row_close() {
		return generic_tag_close( "tr" );
	}

	function table_close() {
		return generic_tag_close( "table" );
	}


?>



