<?php
	
		
	function println( $text ) {
		echo $text . "\n";
	}
	
	function link_css( $name , $path , $src = "local" , $type = "" ) {
		if ( $src == "local" ) {
			$fname = $path . $name;
			println( "<link rel=\"stylesheet\" href=\"$fname\" type=\"text/css\" />" );
		}
		else if ( $src == "online" ) {
			if ( $type != "" )
				$type = "type=\"text/css\"";
			println( "<link rel=\"stylesheet\" href=\"$name\" $type />" );
		}
	}
	
	function link_js( $name , $path ) {
		$fname = $path . $name;
		println( "<script type=\"text/javascript\" src=\"$fname\"></script>" );
	}
	
	function emphasis( $title , $text  ) {
		println( "<blockquote class=\"code\">" );
		if ( $title ) 
			println( "	<h2>$title</h2><br/>" );
		println( "	" . $text );
		println( "</blockquote>" );
	}

	function text_trunc( $text , $trunc ) {
		if ( strlen( $text ) <= $trunc ) 
			return $text; 
		$nuovo = wordwrap( $text , $trunc , "|" ); 
		$nuovotesto = explode( "|" , $nuovo ); 
		return $nuovotesto[0]."...";
	}

	function marker_generator( $marker ) {
		echo "\n"."<a name=\"$marker\"></a>"."\n";
	}

	function return_link( $addr , $text , $target = null ) {
		$ret = "<a href=\"$addr\" >$text</a>";
		return $ret;
	}

	function insert_link( $addr , $text , $target = null ) {
		if ( ! $target ) 
			echo "<a href=\"$addr\">$text</a>";
		else
			echo "<a href=\"$addr\" ". $target?"target=\"$target\"":"" . " >$text</a>";
	}

	function TGS_link( $code , $pos , $link = "code.php?code" ) {
		if ( $pos == "T" )
			return "<a href=\"$link=$code%\">$code</a>";
		if ( $pos == "G" )
			return "<a href=\"$link=_$code%\">$code</a>";
		if ( $pos == "S" )
			return "<a href=\"$link=__$code%\">$code</a>";
	}



	function get_check( $var , $notset = "" ) { 
		if ( isset( $var ) )
			return isset($_GET[ "$var" ]) ? $_GET[ "$var" ] : $notset;
		return $notset;
	}
	
	
	function get_current_url() {
		$url  = 'http' . '://'
					. $_SERVER['SERVER_NAME']
					. $_SERVER['REQUEST_URI'];
		return $url;
	}
	
		
	function map( $x, $in_min, $in_max, $out_min, $out_max) {
		return ($x - $in_min) * ($out_max - $out_min) / ($in_max - $in_min) + $out_min;
	}


	function gk_text_trunc( $text , $trunc ) {
		if ( strlen( $text ) <= $trunc ) 
			return $text;
		$nuovo = wordwrap( $text , $trunc , "|" ); 
		$nuovotesto = explode( "|" , $nuovo );
		return $nuovotesto[0]."...";
	}



?>



