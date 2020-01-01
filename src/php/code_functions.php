<?php

	function synopsis( $code , $sd , $ld , $image = "" ) {
		println( "<div class=\"codelite\">");
		println ( "<h2>Code	 synopsis</h2><br/>" );
		
		println( "<div class=\"box50\" style=\"height:140px;\">");
		println( "<table class=\"codelite_img\" width=\"100%\" >" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999;'width=\"20%\">Code:</td>" );
		println ( "		<td style='border:1px solid #999;'><b>$code</b></td>" );
		println( "	</tr>" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999;' >Short descr:</td>" );
		println ( 		"<td style='border:1px solid #999;'>$sd</td>" );
		println( "	</tr>" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999;  height:70px; text-align: justify; text-justify: inter-word;'>Long descr:</td>" );
		println ( 		"<td style='border:1px solid #999; text-align: justify; text-justify: inter-word;'>$ld</td>" );
		println( "	</tr>" );
		println( "</table>" );
		println ( "</div>" );
		
		println( "<div class=\"box25\" style=\"height:140px;\">");
		println( "<table class=\"codelite_img\" width=\"100%\" >" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999;'width=\"40%\">Attachment:</td>" );
		println ( "		<td style='border:1px solid #999;'>&nbsp;</td>" );
		println( "	</tr>" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999;'width=\"40%\">Documentation</td>" );
		println ( 		"<td style='border:1px solid #999;'>&nbsp;</td>" );
		println( "	</tr>" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999;' width=\"40%\">Provider:</td>" );
		println ( 		"<td style='border:1px solid #999;'>&nbsp;</td>" );
		println( "	</tr>" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999;' width=\"40%\">Origin:</td>" );
		println ( 		"<td style='border:1px solid #999;'>&nbsp;</td>" );
		println( "	</tr>" );
		println( "	<tr>" );
		println ( "		<td  style='border:1px solid #999; ' width=\"40%\">Link:</td>" );
		println ( 		"<td style='border:1px solid #999;'>&nbsp;</td>" );
		println( "	</tr>" );
		println( "</table>" );
		
		println ( "</div>" );
		println( "<div class=\"box25\" style=\"height:140px;\">");
		println ( "<img class=\"codelite_img\" src=\"" . NSID_PLM_SRC_IMG . "noimg.png\" />" );
		println ( "</div>" );
		println ( "</div>" );
	}


function create_top_n_table( $top ) {
	println( "<div class=\"codelite\">" );
	println( "<h2>Top ten context advisor</h2><br/><br/>" );
	$myTabella = new classTabella;
	$myTabella->setTabella();
	$myTabella->stdAttributiTabella(array("class"=>"codellite_img" , "width"=>"95%" , "align"=>"center"));
	$myTabella->addValoreRiga(array("Contexts" , "Occurrences" , "Percentages" , "Charts" ));
	$myTabella->aggiungiRiga(array( "style"=>"font-weight:bold;" ),4,array(array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"100px"),array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"50px"),array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"50px") , array("style"=>"border:1px solid #999; ") ));
	$items = count( $top );
	for( $r = 0 ; $r < $items ; $r++ ) {
		$link = return_link( "index.php?text=" . $top[ $r ][ "context" ] . "&src=Go" , $top[ $r ][ "context" ] );
		$myTabella->addValoreRiga(array( $link , $top[ $r ][ "value" ] , $top[ $r ][ "perc" ]."%" , "<div style=\"background:#eee; \"><div style=\"height:14px;width:" . $top[ $r ][ "perc" ] . "%; background:#aaa; \"></div></div>" ));	
		$myTabella->aggiungiRiga(null,4,array(array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"100px"),array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"50px"),array("style"=>"border:1px solid #999; " , "align"=>"center" , "width"=>"50px") , array("style"=>"border:1px solid #999; ") ));
	}	
	$myTabella->stampaTabella();
	println( "<br/></div>" );
}


?>


