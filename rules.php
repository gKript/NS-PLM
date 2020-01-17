<!--
|
|	File: rules.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php
	$nspage = "rules";
	
	require_once 'includes.php';
	$db = new config_database();
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
?>


<?php
	include NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
	if ( ( $_SESSION["clean_user"] == "guest" ) && ( ! $nscfg->param->user->guest_allowed ) ) 
		insert_blockquote( "Sorry but Guest user is not allowed here!<br/>Please, go to <a href=\"index.php\">home page</a> to log in." , "Error" , 1 );
	
	insert_blockquote( "This page helps you to understand the codes meaning and to manage them in the proper way ." , "Blockquote" );
?>

		<hr/>
		<div class="insidecodelite">
		<div class="codelite">
			<h2>Typology</h2>
			<table style="margin:1em;" width="90%">
		<?php

		$sql = "SELECT * FROM `tipologia`";
		$rows = query_get_num_rows( $sql );
		if ($result = $mysqli->query($sql)) {
			for( $r = 0 ; $r < $rows ; $r++ ) {
					println( "<tr>" );
					$array = $result->fetch_array();
					println( "	<td style='text-align: center; border:1px solid #999;' width='5%' >" . $array[1] . "	</td>" );
					println( "	<td style='border:1px solid #999;' width='25%'>" . $array[2] . "</td>" );
					println( "	<td></td>" );
					println( "</tr>" );
			}
		}
		
		?> 
			</table>
		</div>
		<hr/>
		<div class="codelite">
			<h2>Generic category</h2>
			<table style="margin:1em;" width="90%">
		<?php

		$sql = "SELECT * FROM `catgenerica`";
		$rows = query_get_num_rows( $sql );
		if ($result = $mysqli->query($sql)) {
			for( $r = 0 ; $r < $rows ; $r++ ) {
					println( "<tr>" );
					$array = $result->fetch_array();
					println( "	<td style='text-align: center; border:1px solid #999;' width='5%' >" . $array[1] . "	</td>" );
					println( "	<td style='border:1px solid #999;' width='25%'>" . $array[2] . "</td>" );
					println( "	<td style='border:1px solid #999;' >" . $array[3] . "</td>" );
					println( "</tr>" );
			}
		}

		?> 
			</table>
		</div>
		<hr/>
		<div class="codelite">
			<h2>Specific category</h2>
			<table style="margin:1em;" width="90%">
		<?php

		$sql = "SELECT * FROM `catspecifica`";
		$rows = query_get_num_rows( $sql );
		if ($result = $mysqli->query($sql)) {
			for( $r = 0 ; $r < $rows ; $r++ ) {
					println( "<tr>" );
					$array = $result->fetch_array();
					println( "	<td style='text-align: center; border:1px solid #999;' width='5%' >" . $array[1] . "	</td>" );
					println( "	<td style='border:1px solid #999;' width='25%'>" . $array[2] . "</td>" );
					println( "	<td style='border:1px solid #999;' >" . $array[3] . "</td>" );
					println( "</tr>" );
			}
		}
		
		?> 
			</table>
		</div>
		</div>

	
<?php
	include NSID_PLM_SRC_TEMPLATE . 'footer.php';
	$mysqli->close();
?>

