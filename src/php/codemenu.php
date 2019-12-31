<?php

	function emphasis_code( $code , $bl = 0 ) {
		if ( ! $bl ) 
			$code_split = substr($code, 0, 3) . "  " . substr($code, 3, 5) . "  " . substr($code, 8, 2);
		else if ( $bl == 1) 
			$code_split = substr($code, 0, 3) . "  " . substr($code, 3, 5) . "  " . "<span class=\"blink_text\">" . substr($code, 8, 2) . "</span>";
		else if ( $bl == 2) 
			$code_split = substr($code, 0, 3) . "  " . "<span class=\"blink_text\">" . substr($code, 3, 5) . "</span>" . "  " . substr($code, 8, 2);
		$cod_id = (int)substr($code, 3, 5);
		$cod_rv = (int)substr($code, 8, 2);
		$snc = "00000";
		$spc = "00000";
		$snr = "00000";
		$spr = "00000";
//		echo $cod_id . "  " . $cod_rv . "<br/>";
		$snc = sprintf( "%05d" , $cod_id + 1 );
		$spc = sprintf( "%05d" , $cod_id - 1 );
		$snr = sprintf( "%02d" , $cod_rv + 1 );
		$spr = sprintf( "%02d" , $cod_rv - 1 );
//		echo $snc . "  " . $spc . "  " . $snr . "  " . $spr . "<br/>";
		$ncode = substr($code, 0, 3) . $snc . substr($code, 8, 2);
		$pcode = substr($code, 0, 3) . $spc . substr($code, 8, 2);
		$nrev  = substr($code, 0, 3) . substr($code, 3, 5) . $snr;
		$prev  = substr($code, 0, 3) . substr($code, 3, 5) . $spr;
		$synop_link  = "code.php?code=$code" ;
		$attrib_link = "attributes.php?code=$code&nav=1" ;
		$ncode_link  = "code.php?code=$ncode&pcode=$code&nav=1" ;
		$pcode_link  = "code.php?code=$pcode&pcode=$code&nav=1" ;
		$nrev_link   = "code.php?code=$nrev&pcode=$code&nav=1" ;
		$prev_link   = "code.php?code=$prev&pcode=$code&nav=1" ;
		if ( ! $bl ) 
			echo "<blockquote class=\"code\">";
		else
			echo "<blockquote class=\"code_update\">";
		
		
?>
		<h1>
			<?php 
					echo $code_split;
			?>
		</h1>
<?php

		if ( ! $bl ) {
?>
		<div style="border:1px solid #ccc;" >
			<ul id="navmenu">
			
				<li><a>Navigator +</a>
					<ul>
						<li><a href="<?php 	 	 echo $ncode_link; ?>">Next id</a></li>
						<?php
							if ( ($cod_id - 1)	> 0 ) {
								echo "<li><a href=\"$pcode_link\">Prev id</a></li>";
							}
						?>
<!--				<li><a href="">Last Rev</a></li>		-->
						<li><a href="<?php 	 	 echo $nrev_link; ?>">Next Rev</a></li>
						<?php
							if ( ($cod_rv - 1)	>= 0 ) {
								echo "<li><a href=\"$prev_link\">Prev Rev</a></li>";
							}
						?>
						
					</ul>
				</li>
				<li><a>Details +</a>
					<ul>
						<li><a href="<?php 	 	 echo $synop_link; ?>">Synopsis</a></li>
						<li><a href="<?php 	 	 echo $attrib_link; ?>">Attributes</a></li>
						<li><a href="">State</a></li>
						<li><a href="">Provider</a></li>
						<li><a href="">Price</a></li>
					</ul>
				</li>
				<li><a href="code.php?code=0">Structure +</a>
					<ul>
						<li><a href="">B.O.M.</a></li>
						<li><a href="">Where used</a></li>
						<li><a href="">Documentation</a></li>
					</ul>
				</li>
				<li><a href="code.php?code=0">Where used +</a>
					<ul>
						<li><a href="">Code</a></li>
						<li><a href="">Description</a></li>
					</ul>
				</li>
				<li><a href="code.php?code=0">Related +</a>
					<ul>
						<li><a href="">Attachment</a></li>
						<li><a href="">Link</a></li>
					</ul>
				</li>
				<li><a href="code.php?code=0">Changes +</a>
					<ul>
						<li><a href="">Request</a></li>
						<li><a href="">Issues</a></li>
						<li><a href="">Affected by</a></li>
						<li><a href="">Variances</a></li>
						<li><a href="">History</a></li>
						<li><a href="">Close</a></li>
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
				<li><a href="code.php?code=0">Tracebility +</a>
					<ul>
						<li><a href="">Serial number</a></li>
					</ul>
				</li>
				<li><a href="code.php?code=0">Packages +</a>
					<ul>
						<li><a href="">Shipment</a></li>
					</ul>
				</li>
				<li><a href="">New +</a>
					<ul>
						<li><a href="code.php?code=0&new=1">Code</a></li>
						<li><a href="code.php?code=<?php echo $code; ?>&new=2">Revision</a></li>
					</ul>
				</li>
			</ul>
		</div>
	<?php		
		}
	
	?>
		</blockquote>
<?php
	}


?>