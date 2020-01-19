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
	$nspage = "attributes";

	require_once 'includes.php';

	require_once NSID_PLM_SRC_TEMPLATE . 'attributes_function.php';
	require_once NSID_PLM_SRC_TEMPLATE . 'code_functions.php';

	$db = new config_database();
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
?>


<?php

	$code   			= get_check( 'code'								);
	$action 			= get_check( 'action'							);
	
	$bom					= get_check( 'bom' 					, "0" );
	$provider			= get_check( 'provider'			, "0" );
	$origin   		= get_check( 'origin'				, "0" );
	$critical   	= get_check( 'critical'			, "0" );
	$important		= get_check( 'important'		, "0" );
	$expiration		= get_check( 'expiration'		, "0" );
	$warranty			= get_check( 'warranty'			, "0" );
	$rohs					= get_check( 'rohs'					, "0" );
	$dangerous		= get_check( 'dangerous'		, "0" );
	$regulatory		= get_check( 'regulatory'		, "0" );
	$traceability	= get_check( 'traceability'	, "0" );
	$testing			= get_check( 'testing'			, "0" );
	$consumables	= get_check( 'consumables'	, "0" );
	$element_2_1	= get_check( 'element_2_1'	, "" 	);		//giorno
	$element_2_2	= get_check( 'element_2_2'	, "" 	);		//mese
	$element_2_3	= get_check( 'element_2_3'	, "" 	);		//anno
	$unit					= get_check( 'unit'					, "N"	);
	$compliance		= get_check( 'compliance'		, "" 	);
	$length				= get_check( 'length'				, "" 	);
	$width				= get_check( 'width'				, "" 	);
	$height				= get_check( 'height'				, "" 	);
	$weight				= get_check( 'weight'				, "" 	);
	
	include NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
	if ( ( $_SESSION["clean_user"] == "guest" ) && ( ! $nscfg->param->user->guest_allowed ) ) 
		insert_blockquote( "Sorry but Guest user is not allowed here!<br/>Please, go to <a href=\"index.php\">home page</a> to log in." , "Error" , 1 );
?>

<?php
	$attrib["code"]					= $code;
	$attrib["action"]				= $action;
	$attrib["bom"]					= $bom;
	$attrib["provider"]			= $provider;
	$attrib["origin"]				= $origin;
	$attrib["critical"]			= $critical;
	$attrib["important"]		= $important;
	$attrib["expiration"]		= $expiration;
	$attrib["warranty"]			= $warranty;
	$attrib["rohs"]					= $rohs;
	$attrib["dangerous"]		= $dangerous;
	$attrib["regulatory"]		= $regulatory;
	$attrib["traceability"]	= $traceability;
	$attrib["testing"]			= $testing;
	$attrib["consumables"]	= $consumables;
	$attrib["dd"]						= $element_2_1;
	$attrib["mm"]						= $element_2_2;
	$attrib["yyyy"]					= $element_2_3;
	$attrib["unit"]					= $unit;
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

	$sql = "SELECT * FROM `codattributes` WHERE `code` like '$code'";
//	echo $sql;
	$exist = query_get_num_rows( $sql );
//		echo $exist;
	if( ! $exist ) {
		if ( ( $action != "Insert" ) && ( $action != "Create" ) ) {
			insert_blockquote( "No attributes found for code:<b>$code</b><br/><br/>Page switched in <b>Creation</b> mode." , "Caution" );
			$action = "Create";
		}
	}
	else {
		if ( $action != "Modify" ) {
			attrib_get_data_from_sql();
			
			$code = $attrib["code"];
			$action = $attrib["action"];
			$bom = $attrib["bom"];
			$provider = $attrib["provider"];
			$origin = $attrib["origin"];
			$critical = $attrib["critical"];
			$important = $attrib["important"];
			$expiration = $attrib["expiration"];
			$warranty = $attrib["warranty"];
			$rohs = $attrib["rohs"];
			$dangerous = $attrib["dangerous"];
			$regulatory = $attrib["regulatory"];
			$traceability = $attrib["traceability"];
			$testing = $attrib["testing"];
			$consumables = $attrib["consumables"];
			$element_2_1 = $attrib["dd"];
			$element_2_2 = $attrib["mm"];
			$element_2_3 = $attrib["yyyy"];
			$unit = $attrib["unit"];
			$compliance = $attrib["compliance"];
			$length = $attrib["length"];
			$width = $attrib["width"];
			$height = $attrib["height"];
			$weight = $attrib["weight"];
		}
	}

	
	$disable = 0;

	if ( $array ) {
		
		//-------------------------------------------------------CREATE INIZIO---------------------------------------------------------------
		if ( ( $action == "Create" ) || ( $action == "Edit" ) ) {
?>	
			
		<div class="insidecodelite">
<?php		
			synopsis( $code , $array["abbreviazione"] , $array["descrizione"] );
?>
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
					checkbox_composer( "traceability"	, "1" , "element checkbox" , $traceability	, 1 , "choice" , "traceability"	);
					checkbox_composer( "testing" 			, "1" , "element checkbox" , $testing			, 1 , "choice" , "Testing"			);
					checkbox_composer( "consumables"	, "1" , "element checkbox" , $consumables	, 1 , "choice" , "Consumables"	);
					?>
					</span> 

					<br/><br/><br/><br/><br/><br/>
					<br/><br/><br/><br/><br/>
					
					<label class="description" for="element_2">Expiration date </label>
					<span>
					<input id="element_2_1" name="element_2_1" class="element text" size="2" maxlength="2" value="<?php echo $element_2_1; ?>" type="text"> /
					<label for="element_2_1">DD</label>
					</span>
					<span>
					<input id="element_2_2" name="element_2_2" class="element text" size="2" maxlength="2" value="<?php echo $element_2_2; ?>" type="text"> /
					<label for="element_2_2">MM</label>
					</span>
					<span>
					<input id="element_2_3" name="element_2_3" class="element text" size="4" maxlength="4" value="<?php echo $element_2_3; ?>" type="text">
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
					
					select_composer_from_sql( "unit" , "unit" , 1 , "SELECT * FROM `units`" , 1 , "element text" , "" , $unit , 1 , "Unit:&nbsp;" , "SX" );
					echo "<br/><br/>";
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
						println ( "<input id=\"saveForm\" class=\"button_text\" type=\"submit\" name=\"action\" value=\"Modify\" />" );
//						println ( "<input type=\"hidden\" name=\"action\" value=\"Edit\" />" );
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
		if ( ( $action != "Create" ) && ( $action != "Edit" ) ) {
	?>	
			<div class="insidecodelite">
<?php		
			synopsis( $code , $array["abbreviazione"] , $array["descrizione"] );
			
			if ( ( $action == "Insert" ) || ( $action == "Update" ) ) {
				new_attrib_insert( $attrib , $action );
				$disable = 1;
			}
			else if  ( $action == "Show" ) {
				$disable = 1;
			}
			else if ( $action == "Modify" ) {
				new_attrib_insert( $_GET , $action );
				
				
				$disable = 1	;
			}
			if ( $action != "Show" ) {
				$code = $attrib["code"];
				$action = $attrib["action"];
				$bom = $attrib["bom"];
				$provider = $attrib["provider"];
				$origin = $attrib["origin"];
				$critical = $attrib["critical"];
				$important = $attrib["important"];
				$expiration = $attrib["expiration"];
				$warranty = $attrib["warranty"];
				$rohs = $attrib["rohs"];
				$dangerous = $attrib["dangerous"];
				$regulatory = $attrib["regulatory"];
				$traceability = $attrib["traceability"];
				$testing = $attrib["testing"];
				$consumables = $attrib["consumables"];
				$element_2_1 = $attrib["dd"];
				$element_2_2 = $attrib["mm"];
				$element_2_3 = $attrib["yyyy"];
				$unit = $attrib["unit"];
				$compliance = $attrib["compliance"];
				$length = $attrib["length"];
				$width = $attrib["width"];
				$height = $attrib["height"];
				$weight = $attrib["weight"];
			}
			
			
?>		

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
						checkbox_composer( "bom" 					, "1" , "element checkbox" , $bom 				, 1 , "choice" , "B.O.M." 			, "after"	, $disable	);
						checkbox_composer( "provider" 		, "1" , "element checkbox" , $provider		, 1 , "choice" , "Provider"			, "after"	, $disable	);
						checkbox_composer( "critical" 		, "1" , "element checkbox" , $critical		, 1 , "choice" , "Critical"			, "after"	, $disable	);
						checkbox_composer( "important"		, "1" , "element checkbox" , $important		, 1 , "choice" , "Important"		, "after"	, $disable	);
						checkbox_composer( "expiration" 	, "1" , "element checkbox" , $expiration	, 1 , "choice" , "Expiration"		, "after"	, $disable	);
						checkbox_composer( "warranty" 		, "1" , "element checkbox" , $warranty		, 1 , "choice" , "Warranty"			, "after"	, $disable	);
						?>
						</span>
						<span>
						<?php
						checkbox_composer( "rohs" 				, "1" , "element checkbox" , $rohs				, 1 , "choice" , "RoHS"					, "after"	, $disable	);
						checkbox_composer( "dangerous"		, "1" , "element checkbox" , $dangerous		, 1 , "choice" , "Dangerous"		, "after"	, $disable	);
						checkbox_composer( "regulatory" 	, "1" , "element checkbox" , $regulatory	, 1 , "choice" , "Regulatory"		, "after"	, $disable	);
						checkbox_composer( "traceability"	, "1" , "element checkbox" , $traceability	, 1 , "choice" , "traceability"	, "after"	, $disable	);
						checkbox_composer( "testing" 			, "1" , "element checkbox" , $testing			, 1 , "choice" , "Testing"			, "after"	, $disable	);
						checkbox_composer( "consumables"	, "1" , "element checkbox" , $consumables	, 1 , "choice" , "Consumables"	, "after"	, $disable	);
						?>
						</span> 

						<br/><br/><br/><br/><br/><br/>
						<br/><br/><br/><br/><br/>
						
						<label class="description" for="element_2">Expiration date </label>
						<span>
						<?php
						text_input_composer( "element_2_1" , $element_2_1 , "element text" , "text" , "2" , "2" , 1 , "" , "DD"		, "after" , $disable );
						?>
						</span>
						<span>
						<?php
						text_input_composer( "element_2_2" , $element_2_2 , "element text" , "text" , "2" , "2" , 1 , "" , "MM"		, "after" , $disable );
						?>
						</span>
						<span>
						<?php
						text_input_composer( "element_2_3" , $element_2_3 , "element text" , "text" , "4" , "4" , 1 , "" , "YYYY"	, "after" , $disable );
						?>
						</span>

						<br/><br/><br/>
						
						<?php
						text_input_composer( "unit" 			, $unit 			, "element text medium" , "text" , "" , "255" , 1 , "description" , "Unit"				, "before" , $disable );
						text_input_composer( "compliance" , $compliance , "element text medium" , "text" , "" , "255" , 1 , "description" , "Compliance"	, "before" , $disable );
						text_input_composer( "length" 		, $length 		, "element text medium" , "text" , "" , "255" , 1 , "description" , "Length" 			, "before" , $disable );
						text_input_composer( "width"			, $width			, "element text medium" , "text" , "" , "255" , 1 , "description" , "Width"				, "before" , $disable );
						text_input_composer( "height" 		, $height 		, "element text medium" , "text" , "" , "255" , 1 , "description" , "Height" 			, "before" , $disable );
						text_input_composer( "weight" 		, $weight 		, "element text medium" , "text" , "" , "255" , 1 , "description" , "Weight" 			, "before" , $disable );
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
	include NSID_PLM_SRC_TEMPLATE . 'footer.php';
	$mysqli->close();
?>


