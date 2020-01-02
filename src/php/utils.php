<?php
	
		
	function println( $text ) {
		echo $text . "\n";
	}
	
	function link_css( $name , $path , $src = "local"  ) {
		if ( $src == "local" ) {
			$fname = $path . $name;
			println( "<link rel=\"stylesheet\" href=\"$fname\" type=\"text/css\" />" );
		}
		else if ( $src == "online" ) {
			println( "<link rel=\"stylesheet\" href=\"$path\" type=\"text/css\" />" );
		}
	}
	
	function link_js( $name , $path ) {
		$fname = $path . $name;
		println( "<script type=\"text/javascript\" src=\"$fname\"></script>" );
	}
	
	
	function insert_blockquote( $text , $type = "Blockquote" , $die = 0 ) {
		global $mysqli;
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
		else
			$border = "border:1px solid #be0000; background-color:#eee;";

		if ( $type != "Blockquote" ) {
?>
		<blockquote style = "<?php print( $border ); ?>" >
			<p>
				<?php print( $text ); ?><br /><br />
				<h3>&nbsp;&nbsp;&nbsp;&nbsp;<span class="blink_text"><?php print( $type); ?></span></h3><br />
			</p>
<?php
		}
		else {
?>
		<blockquote style = "<?php print( $border ); ?>" >
			<p><?php print( $text ); ?></p>
<?php
		}
		if ( $die ) {
//			echo "<br/>&nbsp;<b>I'm died!</b>";
			if ( ! $mysqli->connect_error)
				$mysqli->close();
			die();
		}
		echo "		</blockquote>";
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
		echo "<a href=\"$addr\" ". $target?"target=\"$target\"":"" . " >'$text</a>";
	}

	function TGS_link( $code , $pos , $link = "code.php?code" ) {
		if ( $pos == "T" )
			return "<a href=\"$link=$code%\">$code</a>";
		if ( $pos == "G" )
			return "<a href=\"$link=_$code%\">$code</a>";
		if ( $pos == "S" )
			return "<a href=\"$link=__$code%\">$code</a>";
	}


	function new_code_step2_link_from_context( $context ) {
		$T = substr( $context , 0 , 1 );
		$G = substr( $context , 1 , 1 );
		$S = substr( $context , 2 , 1 );
		$link = "<a href=\"code.php?T=$T&G=$G&S=$S&action=Create\">$context</a>";
		return $link;		
	}


	function get_check( $var , $notset = "" ) {
		$res = isset($_GET[ "$var" ]) ? $_GET[ "$var" ] : NULL;
		if ( $res == NULL )
			$res = $notset;
		return $res;
	}
	
	
	function get_current_url() {
		$url  = 'http' . '://'
					. $_SERVER['SERVER_NAME']
					. $_SERVER['REQUEST_URI'];
		return $url;
	}
	


?>



