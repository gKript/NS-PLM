<?php


	
	function check_next_prev_code( $code ) {
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
		
		$xnc = query_get_num_rows( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$ncode'" );
		$xpc = query_get_num_rows( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$pcode'" );
		$xnr = query_get_num_rows( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$nrev'" );
		$xpr = query_get_num_rows( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$prev'" );
		
		$check = 0;
		
		if ( $nav["xnc"] = $xnc ) {
			$nav["nc"] = $ncode;
			$check++;
		}
		else
			$nav["nc"] = null;
		
		if ( $nav["xpc"] = $xpc ) {
			$nav["pc"] = $pcode;
			$check++;
		}
		else
			$nav["pc"] = null;
		
		if ( $nav["xnr"] = $xnr ) {
			$nav["nr"] = $nrev;
			$check++;
			$lr = get_latest_revision( $code );
			$nav["lr"] = $lr;
		}
		else
			$nav["nr"] = null;
		
		if ( $nav["xpr"] = $xpr ) {
			$nav["pr"] = $prev;
			$check++;
		}
		else
			$nav["pr"] = null;
		
		$nav["check"] = $check;
		
		//var_dump( $nav );
		
		return $nav;
	}



	function emphasis_code( $code , $bl = 0 , $updstate = "" ) {
		
		global $codestate;
		global $gk_Auth;
		
		if ( ! $bl ) 
			$code_split = substr($code, 0, 3) . "  " . substr($code, 3, 5) . "  " . substr($code, 8, 2);
		else if ( $bl == 1) 
			$code_split = substr($code, 0, 3) . "  " . substr($code, 3, 5) . "  " . "<span class=\"blink_text\">" . substr($code, 8, 2) . "</span>";
		else if ( $bl == 2) 
			$code_split = substr($code, 0, 3) . "  " . "<span class=\"blink_text\">" . substr($code, 3, 5) . "</span>" . "  " . substr($code, 8, 2);

		$nav = check_next_prev_code( $code );
		if ( $nav["check"] ) {
			$ncode_link = "";
			if ( $nav["xnc"] )
				$ncode_link = "<li><a href=\"code.php?code=" . $nav["nc"] . "&nav=1\" >Next ID</a></li>\n";

			$pcode_link = "";
			if ( $nav["xpc"] )
				$pcode_link = "<li><a href=\"code.php?code=" . $nav["pc"] . "&nav=1\" >Previous ID</a></li>\n";

			$nrev_link = "";
			if ( $nav["xnr"] ) {
				if ( ( $nav["nr"] == $nav["lr"] ) ) {
					$nrev_link = "<li><a href=\"code.php?code=" . $nav["nr"] . "&nav=1\" >Next/Last REVISION</a></li>\n";
				}
				else {
					$nrev_link  = "<li><a href=\"code.php?code=" . $nav["nr"] . "&nav=1\" >Next REVISION</a></li>\n";
					$nrev_link .= "<li><a href=\"code.php?code=" . $nav["lr"] . "&nav=1\" >LAST REVISION</a></li>\n";
				}
			}
			
			
			$prev_link = "";
			if ( $nav["xpr"] )
				$prev_link = "<li><a href=\"code.php?code=$code&code=" . $nav["pr"] . "&nav=1\" >Previous REVISION</a></li>";
		}

		
		$synop_link  = "code.php?code=$code" ;
		if ( query_get_num_rows( "SELECT * FROM `codattributes` WHERE `code` like '$code'" ) ) {
			$attrib_create_link = "";
			$attrib_show_link   = "<li><a href=\"attributes.php?code=$code&action=Show\">Show</a></li>" ;
			$attrib_edit_link   = "<li><a href=\attributes.php?code=$code&action=Edit\">Edit</a></li>" ;
		}
		else {
			$attrib_show_link   = "" ;
			$attrib_edit_link   = "" ;
			$attrib_create_link = "<li><a href=\"attributes.php?code=$code&action=Create\">Create</a></li>" ;
		}
		

		if ( ! $bl ) 
			echo "<blockquote class=\"code\">";
		else
			echo "<blockquote class=\"code_update\">";
		
		
		$uname = $gk_Auth->get_current_user_name();
		if ( $uname != "guest" ) {
			if ( $bl == 0 ) {
				$query = 'SELECT * FROM `gk_users` where user_login = \''. $uname .'\' ';
				$urole = query_get_a_field( $query , "user_role" );
				$sql = "SELECT *  FROM `gk_role` WHERE `role_name` LIKE '$urole'";
				$ulevel = query_get_a_field( $query , "user_role" );
				$cstate = query_get_a_field( "SELECT * FROM `elenco_codici` WHERE `codice` LIKE '$code'" , "state" );
				if ( $updstate != "" ) {
					if ( $updstate == "prev" ) {
						if ( $cstate == 3 ) {
							$newstate = 1;
						}
						else if ( $cstate > 3 ) 
							$newstate = $cstate - 1;
						else
							$newstate = $cstate;
					}
					if ( $updstate == "next" ) {
						if ( $cstate == 1 ) {
							$newstate = 3;
						}
						else if ( ( $cstate < 8 ) && ( $cstate >= 3 ) )
							$newstate = $cstate + 1;
						else
							$newstate = $cstate;
					}
					query_sql_run( "UPDATE `elenco_codici` SET `state` = '$newstate' WHERE `elenco_codici`.`codice` LIKE '$code'" );
					$cstate = query_get_a_field( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'" , "state" );
				}
				$cstatestr = $codestate[ $cstate ];
				if ( $cstate == 1 ) {
					$pstate = 0;
					$nstate = 3;
				}
				else if ( $cstate == 2 ) {
					$pstate = 0;
					$nstate = 3;
				}
				else if ( $cstate == 3 ) {
					$pstate = 1;
					$nstate = 4;
				}
				else {
					$pstate = $cstate - 1;
					$nstate = $cstate + 1;
				}
		?>
				
				<div style="width: 40%; background-color: #eee; float: right; border:1px solid #999; box-shadow: 1px 2px 3px #999; 	border-radius: 5px;">
					<?php echo title_h2( "Current state -  $cstatestr <small>[$cstate]</small>" , "procedure.png" , "padding-left: 16px; padding-right: 16px;" ); ?>
					<br/>
					<table style="margin:9px;" width="97%">
						<tr >
							<th width="25%"><small>Previous state</small></th>
							<th width="50%">Current state</th>
							<th width="25%"><small>Next state</small></th>
						</tr>
						<tr align="center" valign="center" height="40px" >
							<td style="border:1px solid #999; background-color: #ada;">
								<a href="code.php?code=<?php echo $code; ?>&updstate=prev" >
								<img src="src/img/prev.svg" alt="ok" border=0 height=24 style="float: right;"/><small>
								<?php echo $codestate[ $pstate ]; ?></a>
								</small>
							</td>
							<td style="border:1px solid #999; background-color: #dda;">
								<b>
	<!--						<img src="src/img/pause.svg" alt="ok" border=0 height=24 style="float: left;"/>		-->
									<big><?php echo $codestate[ $cstate ]; ?></big>
								</b>
							</td>
							<td style="border:1px solid #999; background-color: #bbb;">
								<a href="code.php?code=<?php echo $code; ?>&updstate=next" >
								<img src="src/img/next.svg" alt="ok" border=0 height=24 style="float: left;"/><small>
								<?php echo $codestate[ $nstate ]; ?></a>
								</small>
							</td>
						</tr>
					</table>
				</div>
	<?php
			}
		}
?>		
		<h1>
			<?php 
					echo $code_split;
			?>
		</h1>
<?php

		if ( ! $bl ) {
?>
		<div style="margin-left: 10px; margin-right: 10px; margin-bottom: 10px;" >
			<ul id="navmenu">

				<?php if ( $nav["check"] ) { ?>
				<li><a>Navigator +</a>
					<ul>
						<?php
						echo $ncode_link;
						echo $pcode_link;
						echo $nrev_link;
						echo $prev_link;
						?>
					</ul>
				</li>
				<?php } ?>
				<li><a>Details +</a>
					<ul>
						<li><a href="<?php 	 	 echo $synop_link; ?>">Synopsis</a></li>
						<li><a>Attributes +</a>
							<ul>
								<?php echo $attrib_show_link . "\n"; ?>
								<?php echo $attrib_create_link . "\n"; ?>
								<?php echo $attrib_edit_link . "\n"; ?>

							</ul>
						</li>
						<li><a href="">State</a></li>
						<li><a href="">Provider</a></li>
						<li><a href="">Price +</a>
							<ul>
								<li><a href="">Last</a></li>
								<li><a href="">Average</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li><a href="code.php?code=0">Structure +</a>
					<ul>
						<li><a href="">B.O.M.</a></li>
						<li><a href="where_used.php?code=<?php echo $code; ?>">Where used</a></li>
						<li><a href="">Documentation</a></li>
					</ul>
				</li>
				<?php if ( check_in_bom_presence( $code ) ) { ?>
				<li><a href="where_used.php?code=<?php echo $code; ?>">Where used</a></li>
				<?php } ?>
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
				<li><a href="code.php?code=0">traceability +</a>
					<ul>
						<li><a href="">Serial number</a></li>
					</ul>
				</li>
<!--				<li><a href="code.php?code=0">Packages +</a>
					<ul>
						<li><a href="">Shipment</a></li>
					</ul>
				</li>
-->
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