<!--
|
|	File: code-insert.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php
	$nspage = "code-insert";

	require_once 'includes.php';	
	require_once NSID_PLM_SRC_TEMPLATE . 'code_functions.php';

	$db = new config_database();
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
?>


<?php

	$code		= get_check( 'code'   );
	$sdescr = get_check( 'sdescr' );
	$ldescr = get_check( 'ldescr' );
	$action = get_check( 'action' );
	
	include NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
	if ( ( $_SESSION["clean_user"] == "guest" ) && ( ! $nscfg->param->user->guest_allowed ) ) 
		insert_blockquote( "Sorry but Guest user is not allowed here!<br/>Please, go to <a href=\"index.php\">home page</a> to log in." , "Error" , 1 );
?>

<?php
	
	$ppath = "";
	if ( isset( $_SERVER["HTTP_REFERER"] ) ) {
		$ppath = $_SERVER["HTTP_REFERER"];
	}


	if ( ( ! $code ) || ( ! $sdescr ) || ( ! $ldescr ) || ( ! $action ) ) {
		echo "<br/>";
		insert_blockquote( "The code parameters are not duly filled.<br/>Please, go back and double check everything.<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$ppath\" ><big>Back</big></a><br/><br/>" , "Error" );
	}
	else {
		if ( $action == "Insert" ) {
			new_code_insert( $code , $sdescr , $ldescr );
			$array = query_single_line( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'" );
			if ($array) {
				insert_blockquote( "The code creation has been succesfully completed!" , "Success" );
				get_codetype( $array );
				emphasis_code( $code );
				?>
			
				<div class="insidecodelite">
				<div class="codelite">
				<h2>Code synopsis</h2><br/>
				<?php		
				print( "<b>$code</b>" . "  -  " . $array["abbreviazione"] . "  -  " . $array["descrizione"] ); 	
				?>
				</div>
				<?php
				$hr  = "index.php?T=" . $codetype["T"] . "&G=" . $codetype["CG"] . "&S=" . $codetype["CS"];
				$hrt = $codetype["T"] . $codetype["CG"] . $codetype["CS"];
				$title  = "Code structure - ";
				$title .= link_generator( $hr , $hrt );
				echo open_block( $title );
				?>
				<table style="margin:1em;" width="90%">
				<?php
				println( "<tr>" );
				println( "  <td style='text-align: right;' width='13%' >Typology</td>" );
				$ln = TGS_link( $codetype["T"]  , "T" , "index.php?text" );
				println( "  <td style='text-align: center; border:1px solid #999;' width='5%' >$ln</td>" );
				println( "  <td style='border:1px solid #999;' width='25%'>"   . $codetype["Tname"]   . "</td>" );
				println( "  <td></td>" );
				println( "</tr>" );
				println( "<tr>" );
				println( "  <td style='text-align: right;' >Generic category</td>" );
				$ln = TGS_link( $codetype["CG"]  , "G" , "index.php?text" );
				println( "  <td style='text-align: center; border:1px solid #999;' width='5%' >$ln</td>" );
				println( "  <td style='border:1px solid #999;' width='25%' >"  . $codetype["CGname"]  . "</td>" );
				println( "  <td style='border:1px solid #999;' >"              . $codetype["CGdescr"] . "</td>" );
				println( "</tr>" );
				println( "<tr>" );
				println( "  <td style='text-align: right;' >Specific category</td>" );
				$ln = TGS_link( $codetype["CS"]  , "S" , "index.php?text" );
				println( "  <td style='text-align: center; border:1px solid #999;' width='5%' >$ln</td>" );
				println( "  <td style='border:1px solid #999;' width='25%' >"  . $codetype["CSname"]  . "</td>" );
				println( "  <td style='border:1px solid #999;' >"              . $codetype["CSdescr"] . "</td>" );
				println( "</tr>" );
				println( "<tr>" );
				println( "  <td style='text-align: right;' >B.O.M. Allowed</td>" );
				$dbtip = query_get_a_field( "SELECT *  FROM `tipologia` WHERE `idTip` = " . $codetype["T"] , "dbTip" );
				if( $dbtip == 1 )
					$bom = "YES";
				else
					$bom = "NO";
				println( "  <td style='text-align: center; border:1px solid #999;' width='5%' >"  . $bom      . "</td>" );
				println( "  <td></td>" );
				println( "  <td></td>" );
				println( "</tr>" );
				?>
				</table>
				</div>
				
				<div class="codelite">
				<h2>Code details</h2>
				<table style="margin:1em;" width="40%">
				<?php
				println( "<tr>" );
				println( "  <td style='text-align: right;' width='30%' >Identifier</td>" );
				println( "  <td style='text-align: center; border:1px solid #999;' >"  . substr($code, 3, 5)  . "</td>" );
				println( "</tr>" );
				println( "<tr>" );
				println( "  <td style='text-align: right;' width='30%' >Revision</td>" );
				println( "  <td style='text-align: center; border:1px solid #999;' >"  . substr($code, 8, 2)  . "</td>" );
				println( "  <td style='text-align: center; border:1px solid #999; background-color:#faa;' width=\"20%\" ><a href=\"code.php?code=". $code . "&new=2\"><span class=\"blink_text\"><b>New rev</b></span></td>" );
				println( "</tr>" );
				?>
				</table>
				</div>
				
				<div class="codelite">
				<h2>Creation, modification and attributes</h2>
				<table style="margin:1em;" width="40%">
				<?php
				println( "<tr>" );
				println( "  <td style='text-align: right;' width='30%' >Created</td>" );
				println( "  <td style='text-align: center; border:1px solid #999;' >"  . long_date_human( $array["createTS"] ) . "</td>" );
				println( "</tr>" );
				println( "<tr>" );
				println( "  <td style='text-align: right;' width='30%' >Modified</td>" );
				println( "  <td style='text-align: center; border:1px solid #999;' >"  . long_date_human( $array["modifyTS"] )  . "</td>" );
				println( "</tr>" );
				println( "<tr>" );
				println( "  <td style='text-align: right;' width='30%' >Attributes set</td>" );
				$sql = "SELECT *  FROM `codattributes` WHERE `code` LIKE \"%$code%\"";
				if( query_get_num_rows( $sql )  )
					$dbc = "YES";
				else
					$dbc = "NO";
				println( "  <td style='text-align: center; border:1px solid #999;' >"  . $dbc  . "</td>" );
				if ( $dbc == "NO" )
					println( "  <td style='text-align: center; border:1px solid #999; background-color:#faa;' ><a href=\"attributes.php?code=$code&action=Create\"><span class=\"blink_text\"><b>Create</b></span></td>" );
				else {
					println( "  <td style='text-align: center; border:1px solid #999; background-color:#dfd;' ><a href=\"attributes.php?code=$code\"><b>Show</b></td>" );
					println( "  <td style='text-align: center; border:1px solid #999; background-color:#ffd;' ><a href=\"attributes.php?code=$code&action=modify\"><b>Modify</b></td>" );
				}
				println( "</tr>" );
				?>
				</table>
				</div>
				<?php				
				
				
				
				
				
				
				
				
			}
			else {
				insert_blockquote( "Ther's something wrong!<br/>A new code should have been created but, I can't find it in the Database.<br/>Try to repeat this action again." , "Error" );
				
			}
		}
	}
		
	









?>

		</div>
	
<?php
	include NSID_PLM_SRC_TEMPLATE . 'footer.php';
	$mysqli->close();
?>
