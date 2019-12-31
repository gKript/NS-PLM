<!--
|
|	File: attributes.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php
	$gk_page = "attributes";
	
	define( 'NSID_PLM_TITLE'		,	'NextStep PLM' );
	define( 'NSID_PLM_SRC_PHP'	, 'src/php/');
	define( 'NSID_PLM_SRC_HTML'	, 'src/html/');
	define( 'NSID_PLM_SRC_CSS'	, 'src/css/');
	define( 'NSID_PLM_SRC_JS'	  , 'src/js/');
	define( 'NSID_PLM_SRC_IMG'  ,	'src/img/');

	require NSID_PLM_SRC_PHP.'includes.php';

	$db = new config_database();
	
	$mysqli = new mysqli( $db->host , $db->username , $db->password , $db->dbname , $db->port );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
?>


<?php
	include NSID_PLM_SRC_PHP . 'navmenu.php';
?>

<?php

	$code   			= get_check( 'code'								);
	$action 			= get_check( 'action'							);
	
	$bom					= get_check( 'bom' 					, "0" );
	$provider			= get_check( 'provider'			, "0" );
	$critical   	= get_check( 'critical'			, "0" );
	$important		= get_check( 'important'		, "0" );
	$expiration		= get_check( 'expiration'		, "0" );
	$warranty			= get_check( 'warranty'			, "0" );
	$rohs					= get_check( 'rohs'					, "0" );
	$dangerous		= get_check( 'dangerous'		, "0" );
	$regulatory		= get_check( 'regulatory'		, "0" );
	$tracebility	= get_check( 'tracebility'	, "0" );
	$testing			= get_check( 'testing'			, "0" );
	$consumables	= get_check( 'consumables'	, "0" );
	$element_2_1	= get_check( 'element_2_1'	, "" 	);		//giorno
	$element_2_2	= get_check( 'element_2_2'	, "" 	);		//mese
	$element_2_3	= get_check( 'element_2_3'	, "" 	);		//anno
	$compliance		= get_check( 'compliance'		, "" 	);
	$length				= get_check( 'length'				, "" 	);
	$width				= get_check( 'width'				, "" 	);
	$height				= get_check( 'height'				, "" 	);
	$weight				= get_check( 'weight'				, "" 	);
	
	$attrib["code"]					= $code;
	$attrib["action"]				= $action;
	$attrib["bom"]					= $bom;
	$attrib["provider"]			= $provider;
	$attrib["critical"]			= $critical;
	$attrib["important"]		= $important;
	$attrib["expiration"]		= $expiration;
	$attrib["warranty"]			= $warranty;
	$attrib["dangerous"]		= $dangerous;
	$attrib["regulatory"]		= $regulatory;
	$attrib["tracebility"]	= $tracebility;
	$attrib["testing"]			= $testing;
	$attrib["consumables"]	= $consumables;
	$attrib["dd"]						= $element_2_1;
	$attrib["mm"]						= $element_2_2;
	$attrib["yyyy"]					= $element_2_3;
	$attrib["compliance"]		= $compliance;
	$attrib["length"]				= $length;
	$attrib["width"]				= $width;
	$attrib["height"]				= $height;
	$attrib["weight"]				= $weight;
	
	$array = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'" );
	if ($array) 
		get_codetype( $array );
	else 
		insert_blockquote( "Code not found<br/>$code" , "Warning" );

	emphasis_code( $code );

	$sql = "SELECT * FROM `codattributes` WHERE `Codice` like '%$code%'";
	//echo $sql;
	$exist = query_get_num_rows( $sql );

	if( ! $exist ) {
		if ( $action != "Insert" )
			insert_blockquote( "No attributes found for code:<b>$code</b>" , "Blockquote" );
	}

	if ( $array ) {
		
		//-------------------------------------------------------CREATE INIZIO---------------------------------------------------------------
		if ( $action == "create" ) {
?>	
			
		<div class="insidecodelite">
			<div class="codelite">
				<h2>Code synopsis</h2><br/>
<?php		
				print( "<b>$code</b>" . "  -  " . $array["abbreviazione"] . "  -  " . $array["descrizione"] );
?>
			</div>
			<div class="codelite">

			<form id="form_att" class="appnitro"  method="get" action="">
			<div class="form_description">
				<h3>Attributes</h3>
			</div>						
				<ul >

					<li id="li_1" >
					<label class="description" for="element_1"> </label>
					<span >
					<?php
					checkbox_composer( "bom" 					, "1" , "element checkbox" , $bom 				, 1 , "choice" , "B.O.M." 			);
					checkbox_composer( "provider" 		, "1" , "element checkbox" , $provider		, 1 , "choice" , "Provider"			);
					checkbox_composer( "critical" 		, "1" , "element checkbox" , $critical		, 1 , "choice" , "Critical"			);
					checkbox_composer( "important"		, "1" , "element checkbox" , $important		, 1 , "choice" , "Important"		);
					checkbox_composer( "expiration" 	, "1" , "element checkbox" , $expiration	, 1 , "choice" , "Expiration"		);
					checkbox_composer( "warranty" 		, "1" , "element checkbox" , $warranty		, 1 , "choice" , "Warranty"			);
					?>
					</span>
					<span>
					<?php
					checkbox_composer( "rohs" 				, "1" , "element checkbox" , $rohs				, 1 , "choice" , "RoHS"					);
					checkbox_composer( "dangerous"		, "1" , "element checkbox" , $dangerous		, 1 , "choice" , "Dangerous"		);
					checkbox_composer( "regulatory" 	, "1" , "element checkbox" , $regulatory	, 1 , "choice" , "Regulatory"		);
					checkbox_composer( "tracebility"	, "1" , "element checkbox" , $tracebility	, 1 , "choice" , "Tracebility"	);
					checkbox_composer( "testing" 			, "1" , "element checkbox" , $testing			, 1 , "choice" , "Testing"			);
					checkbox_composer( "consumables"	, "1" , "element checkbox" , $consumables	, 1 , "choice" , "Consumables"	);
					?>
					</span> 

					<br/><br/><br/><br/><br/><br/>
					<br/><br/><br/><br/><br/>
					
					<label class="description" for="element_2">Expiration date </label>
					<span>
					<input id="element_2_1" name="element_2_1" class="element text" size="2" maxlength="2" value="" type="text"> /
					<label for="element_2_1">DD</label>
					</span>
					<span>
					<input id="element_2_2" name="element_2_2" class="element text" size="2" maxlength="2" value="" type="text"> /
					<label for="element_2_2">MM</label>
					</span>
					<span>
					<input id="element_2_3" name="element_2_3" class="element text" size="4" maxlength="4" value="" type="text">
					<label for="element_2_3">YYYY</label>
					</span>

					<span id="calendar_2">
					<img id="cal_img_2" class="datepicker" src="src/img/calendar.gif" alt="Pick a date.">	
					</span>
					<script type="text/javascript">
					Calendar.setup({
					inputField	 : "element_2_3",
					baseField    : "element_2",
					displayArea  : "calendar_2",
					button		 : "cal_img_2",
					ifFormat	 : "%B %e, %Y",
					onSelect	 : selectEuropeDate
					});
					</script>

					<br/><br/><br/><br/>
					
					<?php
					text_input_composer( "compliance" , $compliance , "element text medium" , "text" , "" , "255" , 1 , "description" , "Compliance"	, "before" );
					text_input_composer( "length" 		, $length 		, "element text medium" , "text" , "" , "255" , 1 , "description" , "Length" 			, "before" );
					text_input_composer( "width"			, $width			, "element text medium" , "text" , "" , "255" , 1 , "description" , "Width"				, "before" );
					text_input_composer( "height" 		, $height 		, "element text medium" , "text" , "" , "255" , 1 , "description" , "Height" 			, "before" );
					text_input_composer( "weight" 		, $weight 		, "element text medium" , "text" , "" , "255" , 1 , "description" , "Weight" 			, "before" );
					?>
					</li>

					<li class="buttons">
					<input type="hidden" name="code" value="<?php echo $code; ?>" />
<?php
					if ( ! $exist ) 
						println ( "<input id=\"saveForm\" class=\"button_text\" type=\"submit\" name=\"action\" value=\"Insert\" />" );
					else {
						println ( "<input id=\"saveForm\" class=\"button_text\" type=\"submit\" name=\"action\" value=\"Update\" />" );
						println ( "<input type=\"hidden\" name=\"action\" value=\"modify\" />" );
					}
?>
					</li>
				</ul>
			</form>	

			</div>
		</div>

<?php
		}		
		//-------------------------------------------------------CREATE FINE---------------------------------------------------------------
		//-------------------------------------------------------INSERT START--------------------------------------------------------------
		if ( $action == "Insert" ) {	
			new_attrib_insert( $code , $sdescr , $ldescr );
			insert_blockquote( "The code creation has been succesfully completed!" , "Success" );


?>	
			
		<div class="insidecodelite">
			<div class="codelite">
				<h2>Code synopsis</h2><br/>
<?php		
				print( "<b>$code</b>" . "  -  " . $array["abbreviazione"] . "  -  " . $array["descrizione"] );
?>
			</div>
			<div class="codelite">

			<form id="form_att" class="appnitro"  method="get" action="">
			<div class="form_description">
				<h3>Attributes</h3>
			</div>						
				<ul >

					<li id="li_1" >
					<label class="description" for="element_1"> </label>
					<span >
					<?php
					checkbox_composer( "bom" 					, "1" , "element checkbox" , $bom 				, 1 , "choice" , "B.O.M." 			, "after"	, 1	);
					checkbox_composer( "provider" 		, "1" , "element checkbox" , $provider		, 1 , "choice" , "Provider"			, "after"	, 1	);
					checkbox_composer( "critical" 		, "1" , "element checkbox" , $critical		, 1 , "choice" , "Critical"			, "after"	, 1	);
					checkbox_composer( "important"		, "1" , "element checkbox" , $important		, 1 , "choice" , "Important"		, "after"	, 1	);
					checkbox_composer( "expiration" 	, "1" , "element checkbox" , $expiration	, 1 , "choice" , "Expiration"		, "after"	, 1	);
					checkbox_composer( "warranty" 		, "1" , "element checkbox" , $warranty		, 1 , "choice" , "Warranty"			, "after"	, 1	);
					?>
					</span>
					<span>
					<?php
					checkbox_composer( "rohs" 				, "1" , "element checkbox" , $rohs				, 1 , "choice" , "RoHS"					, "after"	, 1	);
					checkbox_composer( "dangerous"		, "1" , "element checkbox" , $dangerous		, 1 , "choice" , "Dangerous"		, "after"	, 1	);
					checkbox_composer( "regulatory" 	, "1" , "element checkbox" , $regulatory	, 1 , "choice" , "Regulatory"		, "after"	, 1	);
					checkbox_composer( "tracebility"	, "1" , "element checkbox" , $tracebility	, 1 , "choice" , "Tracebility"	, "after"	, 1	);
					checkbox_composer( "testing" 			, "1" , "element checkbox" , $testing			, 1 , "choice" , "Testing"			, "after"	, 1	);
					checkbox_composer( "consumables"	, "1" , "element checkbox" , $consumables	, 1 , "choice" , "Consumables"	, "after"	, 1	);
					?>
					</span> 

					<br/><br/><br/><br/><br/><br/>
					<br/><br/><br/><br/><br/>
					
					<label class="description" for="element_2">Expiration date </label>
					<span>
					<?php
					text_input_composer( "element_2_1" , $element_2_1 , "element text" , "text" , "2" , "2" , 1 , "" , "DD"		, "after" , 1 );
					?>
					</span>
					<span>
					<?php
					text_input_composer( "element_2_2" , $element_2_2 , "element text" , "text" , "2" , "2" , 1 , "" , "MM"		, "after" , 1 );
					?>
					</span>
					<span>
					<?php
					text_input_composer( "element_2_3" , $element_2_3 , "element text" , "text" , "4" , "4" , 1 , "" , "YYYY"	, "after" , 1 );
					?>
					</span>

					<br/><br/><br/><br/>
					
					<?php
					text_input_composer( "compliance" , $compliance , "element text medium" , "text" , "" , "255" , 1 , "description" , "Compliance"	, "before" , 1 );
					text_input_composer( "length" 		, $length 		, "element text medium" , "text" , "" , "255" , 1 , "description" , "Length" 			, "before" , 1 );
					text_input_composer( "width"			, $width			, "element text medium" , "text" , "" , "255" , 1 , "description" , "Width"				, "before" , 1 );
					text_input_composer( "height" 		, $height 		, "element text medium" , "text" , "" , "255" , 1 , "description" , "Height" 			, "before" , 1 );
					text_input_composer( "weight" 		, $weight 		, "element text medium" , "text" , "" , "255" , 1 , "description" , "Weight" 			, "before" , 1 );
					?>
					</li>
				</ul>
			</form>	

			</div>
		</div>

<?php


		}
		//-------------------------------------------------------INSERT FINE---------------------------------------------------------------
	}
?>

	
<?php
	include NSID_PLM_SRC_PHP . 'footer.php';
	$mysqli->close();
?>


