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
					<td width="20%"><img src="src/img/logo/gkbw.png" border="0" width="80px" style="float: right; vertical-align: middle;" alt="gk logo" /></td>
				</tr>
			</table>
		</div>
		<div style="border:1px solid #ddd;" >
			<Form Name ="menu_srch" Method ="GET" ACTION = "index.php">
				<ul id="navmenu">
					<li><a href="index.php">Start</a></li>
					<li><a href="">Code +</a>
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
					<li><a href="">Provider +</a>
						<ul>
							<li><a href="">Change +</a>
								<ul>
									<li><a href="">Modify</a></li>
									<li><a href="">Delete</a></li>
									<li><a href="">Duplicate</a></li>
								</ul>
							</li>
							<li><a href="">Create</a></li>
						</ul>
					</li>
					<li><a href="code.php?code=0">Report +</a>
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
					<li><a>Search <INPUT TYPE = "Text" NAME = "text"><INPUT TYPE = "Submit" Name = "src" VALUE = "Go"></a></li>
					<li><a href="<?php echo $back; ?>">Back</a></li>
				</ul>
			</FORM>
		</div>
		<?php
		
		$c =  stat_CodeCountDaily();
		$c += stat_AttribCountDaily();
		if ( $c )
			insert_blockquote( "Daily statistics updated!" , "Blockquote");
		if ( $reload )
			insert_blockquote( "Pay attention, this page is reloaded." , "Blockquote");
			
		?>
		
		
		
		
		