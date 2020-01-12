<?php

require_once NSID_PLM_SRC_TEMPLATE . 'index_funtions.php';

?>


<!DOCTYPE html>
<!--  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">  -->
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	
<?php

		$hist 	= get_check( 'hist'	, "" );
		if ( $hist != "" )
			$text 	= $hist;
		else
			$text 	= get_check( 'text'				, $hist					);
		
		//echo $hist . "  " . $text;

		$H = add_search_in_history( $text );

		if ( ( $nspage == "code" ) || ( $nspage == "bom" ) || ( $nspage == "where_used" ) || ( $nspage == "code-insert" ) ) {
			if ( ( $nspage == "code" ) && ( $action == "Create" ) ) {
				println( "<title>" . NSID_PLM_TITLE . " - Create step 2</title>" );
			}
			if ( ( $nspage == "code" ) && ( $action == "filter" ) ) {
				println( "<title>" . NSID_PLM_TITLE . " - Filtering
				</title>" );
			}
			else if ( ( $nspage == "code" ) && ( $code == "0" ) ) {
				println( "<title>" . NSID_PLM_TITLE . " - Create step 1</title>"  );
			}
			else {
				println( "<title>" . NSID_PLM_TITLE . " - " . $code . "</title>" );
			}
		}
		else 
			println( "<title>" . NSID_PLM_TITLE . "</title>" );
		
		println( "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />" );
		
		println( "<link rel=\"shortcut icon\" href=\"src/img/logo/ns-plm.ico\">" );
		
		//CSS Locali
		link_css( "menu.css"     , NSID_PLM_SRC_CSS );
		link_css( "h.css"        , NSID_PLM_SRC_CSS );
		link_css( "body.css"     , NSID_PLM_SRC_CSS );
		link_css( "view.css"     , NSID_PLM_SRC_CSS );
		
		
		//CSS online
		link_css( "https://fonts.googleapis.com/css?family=Montserrat&display=swap"  , null , "online" );


		//CSS locali	
		link_js ( "view.js"      , NSID_PLM_SRC_JS  );
		link_js ( "calendar.js"  , NSID_PLM_SRC_JS  );
?>		

	</head>
	<body>
		<?php
			$back = "";
			$reload = 0;
			if ( isset( $_SERVER["HTTP_REFERER"] ) ) {
				$back = $_SERVER["HTTP_REFERER"];
				if ( $back == get_current_url() )
					$reload = 1;
			}
/*
			echo "<br/>Back:   " . $back;
			echo "<br/>Url:    " . get_current_url();
			echo "<br/>Reload: " . $reload;
*/
		?> 
	<div id="centerColumn">
		<div id="header">
			<table border="0" width="100%" >
				<tr>
					<td width="20%"><a href="index.php" ><img src="src/img/logo/ns-plm.png" border="0" width="310" alt="nsplm logo" /></a></td>
					<td valign="middle" ><h1>Next Step PLM</h1><h2><b>Product Lifecycle Management</b> by gKript.org</h2></td>
					<td width="20%"><img src="src/img/logo/gk.png" border="0" width="90px" style="float: right; vertical-align: middle; padding-right:20px;padding-top: 20px;" alt="gk logo" /></td>
				</tr>
			</table>
		</div>
		<div style="margin-left: 10px; margin-right: 10px; margin-bottom: 24px;" >
			<Form Name ="menu_srch" Method ="GET" ACTION = "index.php">
				<ul id="navmenu">
					<li><a href="index.php">Start</a></li>
					<li><a>Code +</a>
						<ul>
							<li><a>Change +</a>
								<ul>
									<li><a href="">Modify</a></li>
									<li><a href="">Delete</a></li>
									<li><a href="">Duplicate</a></li>
								</ul>
							</li>
							<li><a href="code.php?code=0&new=1">Create</a></li>
						</ul>
					</li>
					<li><a>Provider +</a>
						<ul>
							<li><a>Change +</a>
								<ul>
									<li><a href="">Modify</a></li>
									<li><a href="">Delete</a></li>
									<li><a href="">Duplicate</a></li>
								</ul>
							</li>
							<li><a href="">Create</a></li>
						</ul>
					</li>
					<li><a>Report +</a>
						<ul>
							<li><a href="">Code</a></li>
							<li><a href="">B.O.M.</a></li>
							<li><a href="">Provider</a></li>
							<li><a href="">Charts</a></li>
							<li><a href="">Statistics</a></li>
						</ul>
					</li>

					<li><a>Info +</a>
						<ul>
							<li><a href="code_concept.php">Code concept</a></li>
							<li><a href="rules.php">Related contexts</a></li>
							<li><a href="info.php">About & License</a></li>
							<li><a href="phpinfo.php">PHP info</a></li>
						</ul>
					</li>
					<li><a href="code.php?code=0&action=filter">Quick Filter</a></li>
					<li><a href="<?php echo $back; ?>">Back</a></li>
					<?php
					if ( $H ) { 
					?>
						<li style="float:right;">
							<a>
	<?php
								$sql = "SELECT * FROM `search` ORDER BY `search`.`createTS` DESC";
								$result = query_get_result( $sql );
								if ( $result ) {
									$loop = ITEMS_IN_HISTORY;
									if ( $result->num_rows != ITEMS_IN_HISTORY )
										$loop = $result->num_rows;
									select_option( "reset" );
									for( $r = 0 ; $r < $loop ; $r++ ) {
										$row = $result->fetch_array();
										select_option( "insert" , $row["search"] , $row["search"] );
									}
									//var_dump($A_options);
									select_composer_from_array( "hist" , "hist" , 1 , "" , "this.form.submit()" , "" , 0 , "History: " );
								}
	?>							
							</a>
						</li>
					<?php
					}
					?>
					<li style="float:right;"><a>Search <INPUT style="border-radius: 5px;" TYPE = "Text" NAME = "text" value="<?php echo $text; ?>"><INPUT style="border-radius: 5px;" TYPE = "Submit" Name = "src" VALUE = "Go"></a></li>
					
				</ul>
			</FORM>
		</div>
		<?php
		
		$c =  stat_CodeCountDaily();
		$c += stat_AttribCountDaily();
		$c += stat_BomCountDaily();
		
		if ( $c )
			insert_blockquote( "Daily statistics updated!" , "Blockquote");
		
		if ( $reload )
			emphasis( "" , "Pay attention, this page is reloaded." );
			
		?>
		
		
		
		
		