<?php

	function generic_tag_open( $tag , $class ="" , $style ="" , $type = "" ) {
		$cl = "";
		$s = "";
		$c = "";
		if ( $class )
			$cl = "class=\"$class\"";
		if ( $style )
			$s = "style=\"$style\"";
		if ( $type == "autoclose" )
			$c = "/";
		return "<$tag $cl $s $c>\n";
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
		$ret  = "<$tag ";
		$ret .= "style=\"$style\" >";
		$ret .= $enclose;
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
		if ( $tag == "open" )
			$c = "";
		return "<img src=\"$path$img\" $s alt=\"$alt\" width=\"$w\" heigth=\"$h\" border=\"$b\" $c>\n";
	}

	function div_block_open( $class , $style = "" , $id = "" ) {
		return "<div class=\"$class\" style=\"$style\" id=\"$id\" >\n";
	}

	function div_block_close() {
		return "</div>\n";
	}
	
	
	function link_generator( $ref , $text = "" , $target = "" , $style = "" , $tag = "autoclose" ) {
		$ret  = "<a ";
		$ret .= "href=\"$ref\" ";
		$ret .= $target != ""	? "target=\"$target\"" : "";
		$ret .= $style != ""	? "style=\"$style\"" : "";
		$ret .= $text;
		$ret .= " >";	
		if ( $tag == "autoclose" )
			$ret .= "</a>\n";
		return $ret;
	}

?>
