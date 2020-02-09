<!--
|
|	File: code.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php
	$nspage = "code";

	require_once 'includes.php';
	
	$db = new config_database();
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

	$code = get_check( 'code' );
	$pcode = get_check( 'pcode' );
	$updstate  = get_check( 'updstate' );
	$action = get_check( 'action' );
	$nav  = get_check( 'nav' );
	$nl = (int)get_check( 'nl' , 0 );
	$new = (int)get_check( 'new' );
	$T = get_check( 'T' );
	$G = get_check( 'G' );
	$S = get_check( 'S' );
	
	if ( $action == "Create" )  {
		if ( ! $gk_Auth->check_user_level( "Create" , "Code" ) ) {
			$back = "";
			if ( isset( $_SERVER["HTTP_REFERER"] ) ) {
				$back = $_SERVER["HTTP_REFERER"];
			}
			$redirect = true;
			if ( $back != "" )
				$redirect_addy = $back;
			else
				$redirect_addy = "index.php";
			$pagetime = 10;
		}
	}
	if ( ( $gk_Auth->get_current_user_name() == "guest" ) && ( ! $nscfg->param->user->guest_allowed ) ) {
		$redirect = true;
		$redirect_addy = "index.php";
		$pagetime = 10;
		insert_blockquote( "Sorry but Guest user is not allowed here!<br/>Please, go to <a href=\"index.php\">home page</a> to log in." , "Error" , 1 );
	}

	require NSID_PLM_SRC_TEMPLATE . 'code_functions.php';
	include NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
?>

<?php

	
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//	Create Secondo step
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	if ( $action == "Create" )  {
		if ( $gk_Auth->check_user_level( "Create" , "Code" ) ) {
			if ( ( $T == "x" ) || ( $G == "x" ) || ( $S == "x" ) ) {
				if ( isset( $_SERVER["HTTP_REFERER"] ) )
					$ppath = $_SERVER["HTTP_REFERER"];
				insert_blockquote( "To create a new code each context is needed and must be indicated.<br/>Please, duly fill the code context using the selection boxes in the first step page.<br/><br/>Come back here : <a href=\"$ppath\" >Last page</a>" , "Error" , 1 );
			}
			
			get_codetype_from_tgs( $T ,$G , $S );
			$ncode = get_new_code( $T ,$G , $S );
			//echo $ncode;
			echo "<div class=\"insidecodelite\">\n<h2 style=\"padding-left: 12px;\">Code Creation - step 2</h2><br/>\n";
			insert_blockquote( "This page is going to access to Database in write mode.<br/>Please proceed only if you are sure about what you are doing, but always after a double check." , "Warning" );
	//		echo "<hr/>\n";
			?>

				
				<?php	emphasis_code( $ncode , 4 );	?>
				
				<?php	stat_presence_of_context();		?>
				
				
				<div class="codelite">
					<h2>Context information</h2><br/>
					Please, insert all the others information for the new code:<br/>	

					<table style="margin:1em;" width="90%">
			<?php
			
			println( "<tr>" );
			println( "  <td style='text-align: right;' width='13%' >Typology</td>" );
			println( "  <td style='text-align: center; border:1px solid #999;' width='5%' ><b>$T</b></td>" );
			println( "  <td style='border:1px solid #999;' width='25%'>"   . $codetype["Tname"]   . "</td>" );
			println( "  <td></td>" );
			println( "</tr>" );
			println( "<tr>" );
			println( "  <td style='text-align: right;' >Generic category</td>" );
			println( "  <td style='text-align: center; border:1px solid #999;' width='5%' ><b>$G</b></td>" );
			println( "  <td style='border:1px solid #999;' width='25%' >"  . $codetype["CGname"]  . "</td>" );
			println( "  <td style='border:1px solid #999;' >"              . $codetype["CGdescr"] . "</td>" );
			println( "</tr>" );
			println( "<tr>" );
			println( "  <td style='text-align: right;' >Specific category</td>" );
			println( "  <td style='text-align: center; border:1px solid #999;' width='5%' ><b>$S</b></td>" );
			println( "  <td style='border:1px solid #999;' width='25%' >"  . $codetype["CSname"]  . "</td>" );
			println( "  <td style='border:1px solid #999;' >"              . $codetype["CSdescr"] . "</td>" );
			println( "</tr>" );
			
?>
				</table>
			</div>
			<div class="codelite">
				<form id="form_att" class="appnitro"  method="get" action="code-insert.php">
					<h3>Code descriptions</h3>
					<ul>
						<li id="li_1" >
							<label class="description" for="sdescr">Short desrciption</label>
							<div>
							<input id="sdescr" name="sdescr" class="element text medium" type="text" maxlength="255" value=""/> 
							</div> 
							<label class="description" for="ldescr">Long description </label>
							<div>
							<input id="ldescr" name="ldescr" class="element text medium" type="text" maxlength="255" value=""/> 
							</div>
							<input id="saveForm" class="button_text" type="submit" name="action" value="Insert" />
						</li>
					</ul>
					<input type="hidden" name="code" value="<?php echo $ncode; ?>" />  
				</form>
			</div>
		</div>
<?php
		}
		else {
			insert_blockquote( "You haven't the necessary privileges to perform this action.<br/><br/>If you are thinking there's something wrong please, contact the system administrator!<br/>For security policy, this event is logged.<br/>Please wait! You will be redirected to the previous page in  <b><span id=\"time\">$pagetime</span></b> seconds." , "Caution" );
		}
	}

	// ----------------------------------------------------------------------
	//	Create Secondo step
	// ----------------------------------------------------------------------


	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//	pagina con codice specifico
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	else {
		if ( $code != '0' ) {
			
			if ( ( $gk_Auth->check_user_level( "Modify" , "Code" ) ) && ( ( $nl > 0 ) && ( $nl < 5 ) ) ) {
				query_sql_run( "UPDATE `elenco_codici` SET `status` = '$nl' WHERE `elenco_codici`.`codice` LIKE '$code'" );
				if ( $nl == 3 )
					set_notice_by_action_review( $code );
//				if ( ( $action == "approved" ) || ( $action == "rejected" ) ) {
//					query_sql_run( "UPDATE `code_action` SET `done` = '1' WHERE `code_action`.`action` = 'review' AND `code_action`.`code` = '$code';" );
//				}
			}

			if ( $action == "approved" ) {
				$sql = "SELECT * FROM `notice` WHERE `type` LIKE 'Action required' AND `body` LIKE '%$code%' ORDER BY `notice`.`createTS` DESC LIMIT 0,1;";
				$array = query_single_line( $sql );
				$promoter = $array["promoter"];
				$sender = $array["sender"];
				$csender = $gk_Auth->get_current_clean_user_name();
				$promoter = $array["promoter"];
				$head = "Promotion approved: $code";
				$body = "Your promotion for $code was succesfully APPROVED by ".$gk_Auth->get_current_clean_user_name();

				$sql  = "INSERT INTO `notice` (`id`, `promoter`, `level`, `sender`, `sender_clean`, `receiver`, `type`, `head`, `body`, `link`, `active`, `createTS`, `modifyTS`) ";
				$sql .= "VALUES (NULL, '$code', '99', 'system', '$csender', '$promoter', 'Approved', '$head', '$body', NULL, '1', current_timestamp(), current_timestamp());";
				query_sql_run( $sql );
				query_sql_run( "DELETE FROM `notice` WHERE `type` LIKE 'Action required' AND `body` LIKE '%$code%'" );
				insert_blockquote( "Code $code succesfully APPROVED!" , "Success" );
			}
			else if ( $action == "rejected" )
				insert_blockquote( "Code $code is REJECTED and the new status is now DRAFT" , "Warning" );
			
			$array = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'" );
			if ($array) {
				get_codetype( $array );
		//	print_r( $codetype );

				if ( $new == 2 ) {
					$ncode = get_new_revision( $code );
					$nrev = substr($ncode, 8, 2);
					echo "<br/>";
					insert_blockquote( "This is a new revision [<b>$nrev</b>] for the code $code.<br/>You are going to update the Database. Please, proceed with caution." , "Caution" );
					emphasis_code( $ncode , 1 );
				}
				else {
					$nrev = get_next_revision( $code );
					$nrev_exist = query_get_num_rows( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$nrev'" );
					$latest_rev = get_latest_revision( $code );
					if ( $nrev_exist ) {
						insert_blockquote( "Pay attention!<br/>This is not the latest code $code revision. Please, proceed with caution." , "Caution" );
					}
					emphasis_code( $code , 0 , $updstate );
				}
				
				
				if ( ! $new ) {
			?>
			
			<div class="insidecodelite">

<?php
					synopsis( $code , $array["abbreviazione"] , $array["descrizione"]  );
					
					code_structure( $code , $new );
				
				}

				if ( $new == 2 ) {
		?>
					<form id="form_att" class="appnitro"  method="get" action="code-insert.php">
						<ul>
							<li id="li_1" >
								<label class="description" for="sdescr">Short desrciption</label>
								<div>
								<input id="sdescr" name="sdescr" class="element text medium" type="text" maxlength="255" value="<?php echo $array["abbreviazione"] ?>"/> 
								</div> 
								<label class="description" for="ldescr">Long description </label>
								<div>
								<input id="ldescr" name="ldescr" class="element text medium" type="text" maxlength="255" value="<?php echo $array["descrizione"] ?>"/> 
								</div>
								<input id="saveForm" class="button_text" type="submit" name="action" value="Insert" />
							</li>
						</ul>
						<input type="hidden" name="code" value="<?php echo $ncode; ?>" />
					</form>
		<?php			
				}
		?>
				</div>
		<?php 
				if ( ! $new ) {
					echo open_block( "Code details" , "details.svg" );
					echo generic_tag_open( "div" , "clearfix" );
					echo generic_tag_open( "div" , "box33" , "padding: 0.5em; background-color:#ccc; height:160px;" );
					echo title_h3( "Code identifier" , "identifier.svg" );
//				echo tag_enclosed( "h2" , "Code identifier" );
			?>

						<table style="margin:1em;" width="80%">

				<?php
					println( "<tr>" );
					println( "  <td style='text-align: right;' width='15%' >Identifier</td>" );
					println( "  <td style='text-align: center; border:1px solid #999;' >"  . substr($code, 3, 5)  . "</td>" );
					println( "</tr>" );
					println( "<tr>" );
					println( "  <td style='text-align: right;' width='15%' >Revision</td>" );
					println( "  <td style='text-align: center; border:1px solid #999;' >"  . substr($code, 8, 2)  . "</td>" );
					$nrev = get_next_revision( $code );
					$nrev_exist = query_get_num_rows( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$nrev'" );
					//echo $nrev_exist;
					if ( ! $nrev_exist ) 
						println( "  <td style='text-align: center; border:1px solid #999; background-color:#faa;border-radius: 7px;' width=\"20%\" ><a href=\"code.php?code=". $code . "&new=2\"><span class=\"blink_text\"><b>New</b></span></td>" );
					else {
						$latest_rev = get_latest_revision( $code );
						println( "  <td style='text-align: center; border:1px solid #999; background-color:#faa;border-radius: 7px;' width=\"20%\" ><a href=\"code.php?code=". $code . "&new=2\"><span class=\"blink_text\"><b>New</b></span></td>" );
						println( "</tr>" );
						println( "<tr>" );
						println( "  <td></td>" );
						println( "  <td colspan=\"2\" style='text-align: center; border:1px solid #999; background-color:#ffd;border-radius: 7px;' width=\"20%\" ><a href=\"code.php?code=$latest_rev\"><span class=\"blink_text\"><b>Latest</b></span></a></td>" );
					}
					println( "</tr>" );
					
					echo generic_tag_close( "table" );
					echo div_block_close();
					echo div_block_open( "box66" , "padding: 0.5em; background-color:#ddd; height:160px;" );
					echo title_h3( "Creation, modification and attributes" , "create.svg" );
				?>
				
						<table style="margin:1em;" width="80%">

				<?php
					println( "<tr>" );
					println( "  <td style='text-align: right;' width='15%' >Created</td>" );
					println( "  <td style='text-align: center; border:1px solid #999;' >"  . timestamp_human( $array["createTS"] ) . "</td>" );
					println( "</tr>" );
					println( "<tr>" );
					println( "  <td style='text-align: right;' width='15%' >Modified</td>" );
					println( "  <td style='text-align: center; border:1px solid #999;' >"  . timestamp_human( $array["modifyTS"] )  . "</td>" );
					println( "</tr>" );
					println( "<tr>" );
					println( "  <td style='text-align: right;' width='15%' >Attributes</td>" );
					$sql = "SELECT *  FROM `codattributes` WHERE `code` LIKE \"%$code%\"";
					if( query_get_num_rows( $sql )  )
						$dbc = "YES";
					else
						$dbc = "NO";
					println( "  <td style='text-align: center; border:1px solid #999;' >"  . $dbc  . "</td>" );
					if ( $dbc == "NO" )
						println( "  <td style='text-align: center; border:1px solid #999; background-color:#faa;border-radius: 7px;' ><a href=\"attributes.php?code=$code&action=Create\"><span class=\"blink_text\"><b>Create</b></span></a></td>" );
					else {
						println( "  <td style='text-align: center; border:1px solid #999; background-color:#dfd;border-radius: 7px;' ><a href=\"attributes.php?code=$code&action=Show\"><b>Show</b></a></td>" );
						println( "</tr>" );
						println( "<tr>" );
						println( "  <td></td>" );
						println( "  <td colspan=\"2\" style='text-align: center; border:1px solid #999; background-color:#ffd;border-radius: 7px;' ><a href=\"attributes.php?code=$code&action=Edit\"><b>Edit</b></a></td>" );
					}
					println( "</tr>" );
				?>
				
						</table>
					</div>
				</div>
			</div>

			<?php
				}
			?>
				</div>

		<?php
			}
			else {
				$notfound = 1;
				echo "<br/>";
				insert_blockquote( "Code not found<br/><b>$code</b>" , "Error" );
				$code = 0;
			}
		}
	}

	// ----------------------------------------------------------------------
	//	pagina con codice specifico
	// ----------------------------------------------------------------------

	

	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//	pagina generica
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	if ( ( $nav ) && ( $code == 0) ) {
	?>
	
		<div class="insidecodelite">
		<div class="codelite">
			<h2>Last valid code</h2><br/><br/>

	<?php
	
		if ( isset( $_SERVER["HTTP_REFERER"] ) ) {
			$ppath = $_SERVER["HTTP_REFERER"];
			echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$ppath\" ><big>$pcode</big></a><br/><br/>";
		}
		
	?>

		</div>
		</div>	
		
	<?php
	}
	else {
		if ( $code == '0' ) {
			echo "<div class=\"insidecodelite\">\n";
			if ( $new ) {
			echo "<h2 style=\"padding-left: 12px;\">Code Creation - step 1</h2><br/>\n";
			insert_blockquote( "The <b>code creation</b> is divided in 2 steps: <br/><ol><li><b>Choose the context</b></li><li>Enter all the others information</li></o	l>" , "Blockquote" );
//			echo "<hr/>\n";

			$rest = stat_top_n_context();
			
			create_top_n_table( $rest );
			
			
			?>

				<div class="codelite">
					<h2>Step one</h2><br/><br/>
					Please, insert the context for the new code:<br/><br/>

			<?php
			}
			if ( $new == 1 ) 
				open_form( "GET" , "code.php" );
			else {
				echo "<h2 style=\"padding-left: 12px;\">Code Filtering</h2><br/>\n";
				open_form( "GET" , "search.php" );
			}
			select_composer_from_sql( "Typology" , "T" , 1 , "SELECT * FROM `tipologia`"    , 1 , "codelite" , "" , "" , 1 , "Typology"					, "DX" );
			select_composer_from_sql( "Generic"  , "G" , 1 , "SELECT * FROM `catgenerica`"  , 1 , "codelite" , "" , "" , 1 , "Generic category"	, "DX" );
			select_composer_from_sql( "Specific" , "S" , 2 , "SELECT * FROM `catspecifica`" , 1 , "codelite" , "" , "" , 1 , "Specific category"	, "DX" );	
			if ( $new == 1 )
				button( "submit" , "action" , "Create" , 0 , "codelite" );
			else
				button( "submit" , "action" , "Filter" , 0 , "codelite" );
			close_form();
			
/*			if ( ( ! $new ) && ( ! $action ) )
				echo "<hr/>";
*/			
			if ( ( ! $new ) && ( ! $action ) ) {
				echo "<h2 style=\"padding-left: 12px;\">Code Creation</h2><br/>\n";
				insert_blockquote( "The <b>code creation</b> is divided in 2 steps: <br/><ol><li>Choose the context</li><li>Enter all the others information</li></ol>" , "Blockquote" );
				open_form( "GET" , "code.php" );
				select_composer_from_sql( "Typology" , "T" , 1 , "SELECT * FROM `tipologia`"    , 1 , "codelite" , "" , "" , 1 , "Typology"					, "DX" );
				select_composer_from_sql( "Generic"  , "G" , 1 , "SELECT * FROM `catgenerica`"  , 1 , "codelite" , "" , "" , 1 , "Generic category"	, "DX" );
				select_composer_from_sql( "Specific" , "S" , 2 , "SELECT * FROM `catspecifica`" , 1 , "codelite" , "" , "" , 1 , "Specific category"	, "DX" );
				button( "submit" , "action" , "Create" , 0 , "codelite" );
				close_form();
			}

			if ( $new )
				echo "</div>\n";
			echo "</div>\n";
		}
	}
	
	
	// ----------------------------------------------------------------------
	//	pagina generica
	// ----------------------------------------------------------------------

	?>

<?php
	include NSID_PLM_SRC_TEMPLATE . 'footer.php';
	$mysqli->close();
?>

