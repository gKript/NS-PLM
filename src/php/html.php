<?php

	function	tag_img( $img , $alt , $path = "" , $style = "" , $tag = "autoclose" , $border = 0 , $width = 0 , $heigth = 0 ) {
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
		return "<img src=\"$path$img\" $s alt=\"$alt\" $w $h $b $c>\n";
	}


?>