<?php

	echo div_block_open( "" , "" , "footer" );
		echo div_block_open( "" , "text-align: center;" );
			echo div_block_open( "" , "float: left; vertical-align: middle; padding-left: 32px;" );
				echo "Powered by: ";
				echo BR();
				echo img_generator( "logo/gkphp.png" , "gkphp logo" , "" , "" , "autoclose" , 0 , "100px" );
				echo BR();
				echo "Version: " . GK_VERSION;
				echo BR();
			echo div_block_close();
			echo img_generator( "logo/gkl.png" , "gKript logo" , "" ,  "float: right; vertical-align: middle; padding-right:32px; " , "autoclose" , 0 , "160px" );
			$text  = "NS-PLM [V".$nscfg->plm->version."".$nscfg->plm->status."] by gKript.org - 2019 &reg; [asy] Code: ";
			if ( ( $_SESSION["clean_user"] != "guest" ) || ( $nscfg->param->user->guest_allowed ) ) 
				$text .= link_generator( "code.php?code=53E0000100" , "53E0000100" );
			else
				$text .= "53E0000100";
			echo tag_enclosed( "h4" , $text );
			$codes = tag_enclosed( "b" , stat_codes_total_from_stats(0) );
			$attr = tag_enclosed( "b" , stat_attributes_total_from_stats(0) );
			$bom = tag_enclosed( "b" , stat_bom_total_from_stats(0) );
			echo tag_enclosed( "p" , "We are managing $codes items, $attr attributes tabs and $bom B.O.M." );
			echo BR();
		echo div_block_close();
	echo div_block_close();
	echo div_block_close();
	echo BR();
	echo BR();
	echo generic_tag_close( "body" );
	echo generic_tag_close( "html" );

?>

