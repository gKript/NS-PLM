<?php

	
	$A_options = [	
		'option0' => [
			'value' => '' ,
			'name' 	=> ' '
		],
	];
	
	
	function open_form( $method , $action , $class = "" , $id = "" , $name = ""	, $fieldset = 0 , $legend = "" ) {
		$ret  = "<form";
		$ret .= $method == ""	?  "" : " method=\"$method\"";
		$ret .= $action == ""	? "" : " action=\"$action\"";
		$ret .= $class == ""	? "" : " class=\"$class\"";
		$ret .= $name == ""	? "" : " name=\"$name\"";
		$ret .= $id == ""	? "" : " id=\"$id\"";
		$ret .= ">\n";
		if ( $fieldset ) {
			$ret .= "<fieldset>\n";
			$ret .= $legend == ""	? "" : tag_enclosed( "legend" , $legend );
		}
		println( $ret );
	}
	
	function close_form( $fieldset = 0 ) {
		if ( $fieldset ) println( "</fieldset>\n" );
		println( "</form>" );
	}

	function button( $type , $name , $value , $nl = 0 , $class = "" , $style = "" ) {
		if ( $nl )
			println( "<br/>" );
		println( "<input class=\"$class\" type=\"$type\" name=\"$name\" value=\"$value\" style=\"$style\">" );
	}
	
	
	function select_option( $command , $value = "" , $name = "" , $id = 0 ) {
		
		global $A_options;
		
		$elementi = count( $A_options );
		if ( $command == "insert" ) {
			$index = "option" . $elementi;
			$A_options[ $index ] = [
				'value' => $value ,
				'name' => $name 
			];
			$elementi = count( $A_options );
			return $elementi;
		}
		else if ( $command == "count" ) {
			return $elementi;			
		}
		else if ( $command == "reset" ) {
			$A_options = array();
			$A_options = [	
				'option0' => [
					'value' => '',
					'name' 	=> '&nbsp;'
				],
			];
			$elementi = count( $A_options );
			return $elementi;
		}
		else if ( $command == "get" ) {
			$index = "option" . $id;
			$res = array_values( $A_options[ $index ] );
			return $res;
		}
		return 0;
	}

	function select_composer_from_array( $id , $name , $undefined = 0 , $class = "" , $onchange = "" , $select = "" , $nl = 0 , $label = "" , $position = "sx" ) {
		
		global 				$A_options;
		
		$Sclass 		= $class		? "class=\"$class\"" 				: "" ;
		$Sonchange	=	$onchange ? "onchange=\"$onchange\""	: "" ;			// this.form.submit()
		$elements		=	select_option( "count" );
		$r 					= 1;
		
		if ( $position == "sx" )
			println( "<label for=\"$id\">$label</label>" );

		println( "<select name=\"$name\" id=\"$id\" $Sclass $Sonchange >" );

		if ( $undefined )
				$r = 0;
		for( $r ; $r < $elements ; $r++ ) {
				$array = select_option( "get" , "" , "" , $r );
				$ssel = "";
				if ( $array[0] == $select ) 
					$ssel = " selected ";
				println( "	<option value='" . $array[0] . "'$ssel>" . $array[1] . "</option>" );
		}
		println( "</select>" );
		if ( $position == "dx" )
			println( "<label for=\"$id\">$label</label>" );
		if ( $nl )
			echo "<br/>";
	}
	
	
	function select_composer_from_sql( $id , $name , $style , $sql , $undefined = 0 , $class = "" , $onchange = "" , $select = "" , $nl = 0 , $label = "" , $position = "" , $opt0 = "" , $opt1 = "" ) {
		//	Style 0: solo array 0, Style 1 anche array 1, Style 2 anche array 2
		global $mysqli;
		
		$Sclass 		= $class		? "class=\"$class\"" 				: "" ;
		$Sonchange	=	$onchange ? "onchange=\"$onchange\""	: "" ;			// this.form.submit()
		
		if ( $position == "SX" )
			println( "<label for=\"$id\">$label</label>" );
		println( "<select name=\"$name\" id=\"$id\" $Sclass $Sonchange >" );
		if ( $undefined )
			println( "<option value=\"x\" >Undefined</option>" );
		$rows = query_get_num_rows( $sql );
		if ($result = $mysqli->query($sql)) {
			for( $r = 0 ; $r < $rows ; $r++ ) {
					$array = $result->fetch_array();
					$ssel = "";
					if ( $array[1] == $select ) 
						$ssel = " selected ";
					if ( $style == 0 ) 
						println( "	<option value='" . $array[1] . "' $ssel >" . $array[1] . "</option>" );
					else if ( $style == 1 ) 
						println( "	<option value='" . $array[1] . "' $ssel >" . $array[1] . "   -   " . $array[2] . "</option>" );
					else if ( $style == 2 ) 
						println( "	<option value='" . $array[1] . "' $ssel >" . $array[1] . "   -   " . $array[2] . "   -   " . $array[3] . "</option>" );
					else if ( $style == 3 ) 
						println( "	<option value='" . $array[$opt0] . "' $ssel >" . $array[$opt1] . "</option>" );
			}
		}
		?>
		</select>
		<?php			
		if ( $position == "DX" )
			println( "<label for=\"$id\">$label</label>" );
		if ( $nl )
			echo "<br/>";
	}
	
	
	function checkbox_composer( $name , $value , $class , $checked = 0 , $label = 0 , $label_class = "" , $label_text = "" , $label_pos = "after" , $disable = 0 ) {
		if ( ( $label ) && ( $label_pos == "before" )	)
			echo "<label class=\"" . $label_class . "\" for=\"" . $name . "\">$label_text</label>\n";
		$ch  = $checked ? "checked"  : "";
		$dis = $disable ? "disabled" : "";
		echo "<input id=\"" . $name . "\" name=\"" . $name . "\" class=\"" . $class . "\" type=\"checkbox\" value=\"" . $value . "\" " . $ch . " " . $dis . " />\n";
		if ( ( $label ) && ( $label_pos == "after" )	)
			echo "<label class=\"" . $label_class . "\" for=\"" . $name . "\">$label_text</label>\n";
	}
	
	
	
	function text_input_composer( $name , $value , $class , $type , $size , $maxlength , $label = 0 , $label_class = "" , $label_text = "" , $label_pos = "after" , $disable = 0 , $style = "" ) {	
		if ( ( $label ) && ( $label_pos == "before" )	)
			echo "<label class=\"" . $label_class . "\" for=\"" . $name . "\">$label_text</label>\n";
		$dis = $disable ? "disabled" : "";
		echo "<input style =\"$style\" id=\"" . $name . "\" name=\"" . $name . "\" class=\"" . $class . "\" type=\"" . $type . "\" size=\"" . $size . "\" maxlength=\"" . $maxlength . "\" value=\"" . $value . "\" " . $dis . " />\n";
		if ( ( $label ) && ( $label_pos == "after" )	)
			echo "<label class=\"" . $label_class . "\" for=\"" . $name . "\">$label_text</label>\n";
	}
	


	function add_hidden( $name , $value , $null = null ) {
		if ( $value != $null )
			println( "<input type=\"hidden\" name=\"$name\" value=\"$value\" />" );
	}


	function textarea( $rows , $cols, $name , $text = "" , $form = "" , $disable = 0 ) {
		$ret  = "<textarea ";
		$ret .= "rows=$rows ";
		$ret .= "cols=$cols ";
		$ret .= "name=$name ";
		$ret .= $form == "" ? "" : "form=\"$form\" ";
		$ret .= $disable ? " disabled" : "";
		$ret .= ">\n";
		$ret .= $text;
		$ret .= "</textarea>\n";
		return $ret;
	}


?>