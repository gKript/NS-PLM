<?php

	require_once( NSID_PLM_SRC_PHP."table.php" );

	function	small_box_provider_info( $code ) {
		println( "<h2>Creation, modification and attributes</h2><br/>" );
		$Tab = new classTabella;
		$Tab->setTabella();
		
		
	}


$myTabella = new classTabella;
$myTabella->setTabella();
$myTabella->stdAttributiTabella(array("border"=>"1","w idth"=>"50%","align"=>"center"));
$myTabella->addValoreRiga(array("Questo e' il titolo"));
$myTabella->aggiungiRiga(array("bgcolor"=>"white"),1,a rray(array("colspan"=>"3")));

$myTabella->addValoreRiga(array("R1C1","R1C2","R1C3"));
$myTabella->aggiungiRiga(array("bgcolor"=>"red"),3,arr ay(array("bgcolor"=>"black"),array("bgcolor"=>"yellow" ),array("bgcolor"=>"yellow")));

$myTabella->addValoreRiga(array("R2C1","R2C2","R2C3"));
$myTabella->aggiungiRiga(array("bgcolor"=>"green"),3,a rray(array("bgcolor"=>""),array("bgcolor"=>""),array(" bgcolor"=>"")));

$myTabella->stampaTabella();



?>


						<table style="margin:1em;" width="80%">

				<?php
					println( "<tr>" );
					println( "  <td style='text-align: right;' width='15%' >Created</td>" );
					println( "  <td style='text-align: center; border:1px solid #999;' >"  . long_timestamp_human( $array["createTS"] ) . "</td>" );
					println( "</tr>" );
					println( "<tr>" );
					println( "  <td style='text-align: right;' width='15%' >Modified</td>" );
					println( "  <td style='text-align: center; border:1px solid #999;' >"  . long_timestamp_human( $array["modifyTS"] )  . "</td>" );
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
						println( "  <td style='text-align: center; border:1px solid #999; background-color:#faa;' ><a href=\"attributes.php?code=$code&action=Create\"><span class=\"blink_text\"><b>Create</b></span></a></td>" );
					else {
						println( "  <td style='text-align: center; border:1px solid #999; background-color:#dfd;' ><a href=\"attributes.php?code=$code&action=Show\"><b>Show</b></a></td>" );
						println( "  <td style='text-align: center; border:1px solid #999; background-color:#ffd;' ><a href=\"attributes.php?code=$code&action=Edit\"><b>Edit</b></a></td>" );
					}
					println( "</tr>" );
				?>
				
						</table>
