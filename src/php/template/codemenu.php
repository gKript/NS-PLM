<?php
	
	global $gk_Auth;
	global $nspage;
	
	$codemenu = new gkMenu( $nspage , $gk_Auth->get_current_user_level() );
	
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
		
//		var_dump( $nav );
		
		return $nav;
	}


	


	function emphasis_code( $code , $bl = 0 , $nl = 0 ) {
		
		global $cstatus_seq;
		global $cstatus_seq;
		global $codemenu;
		global $gk_Auth;
		
		if ( ! $bl ) 
			$code_split = substr($code, 0, 3) . "  " . substr($code, 3, 5) . "  " . substr($code, 8, 2);
		else if ( $bl == 1) 
			$code_split = substr($code, 0, 3) . "  " . substr($code, 3, 5) . "  " . "<span class=\"blink_text\">" . substr($code, 8, 2) . "</span>";
		else if ( $bl == 2) 
			$code_split = substr($code, 0, 3) . "  " . "<span class=\"blink_text\">" . substr($code, 3, 5) . "</span>" . "  " . substr($code, 8, 2);
		else if ( ( $bl == 3) || ( $bl == 4 ) )
			$code_split = "<span class=\"blink_text\">" . substr($code, 0, 3) . "  " . substr($code, 3, 5) . "  " . substr($code, 8, 2) . "</span>";

		$synop_link  = "code.php?code=$code" ;

		if ( ( $bl == 0 ) || ( $bl == 3 ) )
			echo generic_tag_open( "blockquote" , "code" );
		else
			echo generic_tag_open( "blockquote" , "code_update" );

		$uname = $gk_Auth->get_current_user_name();
		if ( $uname != "guest" ) {
			if ( ( $bl == 0 ) || ( $bl == 3 ) ) {
				$query = "SELECT * FROM `gk_users` where user_login = '$uname '";
				$urole = query_get_a_field( $query , "user_role" );
				$sql = "SELECT *  FROM `gk_role` WHERE `role_name` LIKE '$urole'";
				$ulevel = query_get_a_field( $query , "user_role" );
//				if ( ( $nl != 0 ) && ( $nl != 9 ) )
//					query_sql_run( "UPDATE `elenco_codici` SET `status` = '$nl' WHERE `elenco_codici`.`codice` LIKE '$code'" );
			}
			if ( ( $bl != 4 ) && ( $bl != 1 ) ) {
				$cstate = query_get_a_field( "SELECT *  FROM `elenco_codici` WHERE `codice` LIKE '$code'" , "status" );
				$cstatestr	= $cstatus_seq[ $cstate ]["t"];
				$pstate			= $cstatus_seq[ $cstate ]["p"];
				$pststr			= $cstatus_seq[ $pstate ]["t"];
				$nstate			= $cstatus_seq[ $cstate ]["n"];
				$nststr			= $cstatus_seq[ $nstate ]["t"];
			}
			
			//echo $cstate . " " . $pstate . " " . $pststr . " " . $nstate . " " . $nststr; 
			
			if ( $bl == 0 ) {
				
				echo div_block_open( "" , "width: 40%; background-color: #eee; float: right; border:1px solid #999; box-shadow: 1px 2px 3px #999; 	border-radius: 5px;" );
				echo title_h2( "Current status -  $cstatestr <small>[$cstate]</small>" , "procedure.png" , "padding-left: 16px; padding-right: 16px;" );
				echo BR();
				echo table_open( "" , "97%" , "" , "margin:9px;" );
					echo row_open( "text-align:center; vertical-align:middle;" );
						echo set_header_table( tag_enclosed( "small" , "Previous status" ) , "" , "25%" , "" );
						echo set_header_table( "Current status" , "" , "50%" , "" );
						echo set_header_table( tag_enclosed( "small" , "Next status" ) , "" , "25%" , "" );
					echo row_close();
					
					echo row_open( "text-align:center; vertical-align:middle; height: 40px;" );
						if ( $gk_Auth->check_user_level( "Approve" , "Code" ) ) { 
							$tmp  = img_generator( "prev.svg" , "ok" , "" , "float:right;" , "autoclose" , 0 , 0 , 24 );
							$tmp .= tag_enclosed( "small" , $pststr );
							$tx   = link_generator( "code.php?code=$code&nl=$pstate" , $tmp );
							echo set_col_table( $tx , "" , "" , "background-color: #bbb; box-shadow: 1px 2px 3px #999; border-radius: 10px 10px 10px 10px;" );
						}
						else {
							echo set_col_table( $cstatus_seq[ $pstate ]["t"] , "" , "" , "background-color: #bbb; box-shadow: 1px 2px 3px #999; border-radius: 10px 10px 10px 10px;" );
						}
						
						
						
	//				echo row_close();
					
					
					
				
		?>
							<td style="background-color: #dda; box-shadow: 1px 2px 3px #999; border-radius: 10px 10px 10px 10px;">
								<b>
								<?php
										if ( ( $cstate == 3 ) && ( $gk_Auth->check_user_level( "Approve" , "Code" ) ) ) 
											echo link_generator( "check.php?code=$code" , "<span style=\"	font-size: 20pt;\" class=\"blink_text\">".$cstatus_seq[ $cstate ]["t"]."</span>\n" );
										else
											echo "<big>".$cstatus_seq[ $cstate ]["t"]."</big>\n";
									?>
								</b>
							</td>
							<td style="background-color: #bbb; box-shadow: 1px 2px 3px #999; border-radius: 10px 10px 10px 10px;">
							<?php if ( $gk_Auth->check_user_level( "Approve" , "Code" ) ) { ?>
								<?php if ( $nstate ) { ?>
								<?php 	if ( $nstate < 5 ) { ?>
								<a href="code.php?code=<?php echo $code; ?>&nl=<?php echo $nstate; ?>" >
									<?php }
										}
										?>
								<img src="src/img/next.svg" alt="ok" border=0 height=24 style="float: left;"/><small>
								<?php echo $cstatus_seq[ $nstate ]["t"];
											if ( $nstate != 5 ) { ?>
								</small>
								</a>
									<?php } ?>
							<?php }
										else if ( ( $gk_Auth->check_user_level( "Create" , "Code" ) ) && ( $cstate == 1 ) ) { ?>
								<a href="code.php?code=<?php echo $code; ?>&nl=<?php echo $nstate; ?>" >
								<img src="src/img/next.svg" alt="ok" border=0 height=24 style="float: left;"/>
								<span class="blink_text"><big> <?php echo $cstatus_seq[ $nstate ]["t"]; ?> </big></span></a>
								<?php
										}
										else {
											echo $cstatus_seq[ $nstate ]["t"];
										}
							?>
								</a> </big></span>
							</td>
						</tr>
					</table>
				</div>
	<?php
			}
		}
	
		echo tag_enclosed( "h1" , $code_split );

		if ( ( $bl == 0 ) || ( $bl == 3 ) ) {
			$nav = check_next_prev_code( $code );
			$codemenu->set_output(1);
			$codemenu->open( "navmenu" , "margin-left: 10px; margin-right: 10px; margin-bottom: 10px; " );
			if ( $nav["check"] ) {
					$codemenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Navigator +" );
							if ( $nav["xnc"] ) {
								$ncode_link = "code.php?code=" . $nav["nc"];
								$codemenu->voice( "Next ID"							, $ncode_link );
							}
							if ( $nav["xpc"] ) {
								$pcode_link = "code.php?code=" . $nav["pc"];
								$codemenu->voice( "Previous ID"					, $pcode_link );
							}
							if ( $nav["xnr"] ) {
								if ( $nav["nr"] == $nav["lr"] ) {
									$nrev_link = "code.php?code=" . $nav["nr"];
									$codemenu->voice( "Next/Last REVISION"	, $nrev_link );
								}
								else {
									$nrev_link = "code.php?code=" . $nav["nr"];
									$lrev_link = "code.php?code=" . $nav["lr"];
									$codemenu->voice( "Next REVISION"				, $nrev_link );
									$codemenu->voice( "Last REVISION"				, $lrev_link );
								}
							}
							if ( $nav["xpr"] ) {
								$prev_link = "code.php?code=" . $nav["pr"];
								$codemenu->voice( "Previous REVISION"		, $prev_link );
							}
					$codemenu->submenu_close();
			}
					$codemenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Details +" );
							$codemenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Attributes +" );
									if ( query_get_num_rows( "SELECT * FROM `codattributes` WHERE `code` like '$code'" ) ) {
										$codemenu->voice( "Show" , "attributes.php?code=$code&action=Show"  );
										$codemenu->voice( "Edit" , "attributes.php?code=$code&action=Edit" );
									}
									else {
										$codemenu->voice( "Create" , "attributes.php?code=$code&action=Create" );
									}
							$codemenu->submenu_close();
							$codemenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Price +" );
									$codemenu->voice( "Last" );
									$codemenu->voice( "Average" );
							$codemenu->submenu_close();
							$codemenu->voice( "Synopsis" , $synop_link );
							$codemenu->submenu_open( $gk_Auth->get_level_by_role( "Approver" ) , "Status +" );
									if ( $cstate > 1 ) {
										$pst = $cstatus_seq[ $cstate ]["p"];
										$codemenu->voice( "Set ".$cstatus_seq[ $pst ]["t"] , "code.php?code=$code&nl=$pst&promoter=".$gk_Auth->get_current_user_name() );
									}
									if ( $cstate < 8 ) {
										$nst = $cstatus_seq[ $cstate ]["n"];
										$codemenu->voice( "Set ".$cstatus_seq[ $nst ]["t"] , "code.php?code=$code&nl=$nst&promoter=".$gk_Auth->get_current_user_name() );
									}
							$codemenu->submenu_close();
							$codemenu->voice( "Supplier" , $synop_link );
					$codemenu->submenu_close();
					$codemenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Structure +" );
							$codemenu->voice( "B.O.M." , "bom.php?code=$code" );
							$codemenu->voice( "Where used" , "where_used.php?code=$code" );
							$codemenu->voice( "Documentation" );
					$codemenu->submenu_close();
					if ( check_in_bom_presence( $code ) ) {
						$codemenu->voice( "Where used" , "where_used.php?code=$code"  );
						$codemenu->separator(1);
					}
					$codemenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Related +" );
							$codemenu->voice( "Attachment" );
							$codemenu->voice( "Link" );
					$codemenu->submenu_close();
					$codemenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Changes +" );
							$codemenu->voice( "Request" );
							$codemenu->voice( "Issues" );
							$codemenu->voice( "Affected by" );
							$codemenu->voice( "Variances" );
							$codemenu->voice( "History" );
							$codemenu->voice( "Close" );
					$codemenu->submenu_close();
					$codemenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Report +" );
							$codemenu->voice( "Code" );
							$codemenu->voice( "B.O.M." );
							$codemenu->voice( "Supplier" );
							$codemenu->voice( "Charts" );
							$codemenu->voice( "Statistics" );
					$codemenu->submenu_close();
					$codemenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "Traceability +" );
								$codemenu->voice( "Serial number" );
					$codemenu->submenu_close();
					$codemenu->submenu_open( $gk_Auth->get_level_by_role( "Editor" ) , "New +" );
								$codemenu->voice( "Code" , "code.php?code=0&new=1" );
								$codemenu->voice( "Revision" , "code.php?code=$code&new=2" );
					$codemenu->submenu_close();
			$codemenu->close();
		}
		echo generic_tag_close( "blockquote" );
	}

?>

