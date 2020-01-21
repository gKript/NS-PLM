  <!--
|
|	File: index.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php

	$nspage = "index";

	require_once 'includes.php';	
	
	

	$db = new config_database();
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

	require_once NSID_PLM_SRC_TEMPLATE . 'code_functions.php';
	require_once( NSID_PLM_SRC_TEMPLATE . "codemenu.php" );


	require_once NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
	// ---------------- PAGE GENERATION START
	
	echo open_block( "Title class codelite" , "create.svg" );
	echo 		tag_enclosed( "span" , "An this is a text enclosed in a paragraph." , "margin-left: 16px;" );
	echo close_block();
	echo BR( );

	echo open_block( "Title  class insidecodelite" , "noimg.png" , "insidecodelite" );
	echo 		tag_enclosed( "p" , "An this is a text enclosed in a paragraph." , "margin-left: 30px;" );
	echo close_block();
	echo BR( );

	echo open_block( "Title  class insidecodelite" , "noimg.png" , "insidecodelite" );
	echo 		open_block( "codelite" , "noimg.png" , "codelite" );
	echo 				tag_enclosed( "p" , "An this is a codelight box enclosed " , "margin-left: 30px;" );
	echo 		close_block();
	echo close_block();
	echo BR( );
	
	echo open_block( "Title" , "" , "insidecodelite" );
	echo 		tag_enclosed( "p" , "It is possible to highlight the CODE with these functions" , "margin-left: 16px;" );
	echo 		tag_enclosed( "p" , "This is a 'emphasis_code' type 0" , "margin-left: 24px;" );
	echo 		tag_enclosed( "p" , "In the 'emphasis_code' type 0 the code context menu is automatically included " , "margin-left: 24px;" );
					emphasis_code( "53E0000100" , 0 );
	echo 		tag_enclosed( "p" , "This is a 'emphasis_code' type 1 - Only the revision is blinking" , "margin-left: 24px;" );
					emphasis_code( "53E0000100" , 1 );
	echo 		tag_enclosed( "p" , "This is a 'emphasis_code' type 2 - Only the identifier is blinking" , "margin-left: 24px;" );
					emphasis_code( "53E0000100" , 2 );
	echo close_block();
	echo BR( );
	
	echo open_block( "Boxes!" , "create.svg" , "insidecodelite");
	echo 		tag_enclosed( "p" , "These are blocks of various dimensions" , "margin-left: 16px;"  );
	
	echo		div_block_open( "box25" , "background-color: #eee; " );
	echo 				tag_enclosed( "p" , "25%" , "margin-left: 16px;"  );
	echo 		div_block_close();
	echo		div_block_open( "box25" , "background-color: #edd; " );
	echo 				tag_enclosed( "p" , "25%" , "margin-left: 16px;"  );
	echo 		div_block_close();
	echo		div_block_open( "box25" , "background-color: #ecc; " );
	echo 				tag_enclosed( "p" , "25%" , "margin-left: 16px;"  );
	echo 		div_block_close();
	echo		div_block_open( "box25" , "background-color: #ebb; " );
	echo 				tag_enclosed( "p" , "25%" , "margin-left: 16px;"  );
	echo 		div_block_close();
	echo 		BR( 8 , 1 );

	echo		div_block_open( "box33" , "background-color: #eee; " );
	echo 				tag_enclosed( "p" , "33,3%" , "margin-left: 16px;"  );
	echo 		div_block_close();
	echo		div_block_open( "box33" , "background-color: #ded; " );
	echo 				tag_enclosed( "p" , "33,3%" , "margin-left: 16px;"  );
	echo 		div_block_close();
	echo		div_block_open( "box33" , "background-color: #cec; " );
	echo 				tag_enclosed( "p" , "33,3%" , "margin-left: 16px;"  );
	echo 		div_block_close();
	echo 		BR( 9 , 1 );

	echo		div_block_open( "box50" , "background-color: #eee; " );
	echo 				tag_enclosed( "p" , "50%" , "margin-left: 16px;"  );
	echo 		div_block_close();
	echo		div_block_open( "box50" , "background-color: #ede; " );
	echo 				tag_enclosed( "p" , "50%" , "margin-left: 16px;"  );
	echo 		div_block_close();
	echo 		BR( 8 , 1 );

	echo		div_block_open( "box25" , "background-color: #eee; " );
	echo 				tag_enclosed( "p" , "25%" , "margin-left: 16px;"  );
	echo 		div_block_close();
	echo		div_block_open( "box50" , "background-color: #dde; " );
	echo 				tag_enclosed( "p" , "50%" , "margin-left: 16px;"  );
	echo 		div_block_close();
	echo		div_block_open( "box25" , "background-color: #cce; " );
	echo 				tag_enclosed( "p" , "25%" , "margin-left: 16px;"  );
	echo 		div_block_close();
	echo 		BR( 8 , 1 );
	
	echo		div_block_open( "box75" , "background-color: #eee; " );
	echo 				tag_enclosed( "p" , "75%" , "margin-left: 16px;"  );
	echo 		div_block_close();
	echo		div_block_open( "box25" , "background-color: #dee	; " );
	echo 				tag_enclosed( "p" , "25%" , "margin-left: 16px;"  );
	echo 		div_block_close();
	echo 		BR( 8 , 1 );

	echo close_block();
	echo BR( );	
	
	echo open_block( "Notifications" , "create.svg" , "insidecodelite");
					insert_blockquote( "This is an example of Blockquote type 'Generic'" , "Generic" );
					insert_blockquote( "This is an example of Blockquote type 'Are you sure?'" , "Are you sure?" );
					insert_blockquote( "This is an example of Blockquote type 'Success'" , "Success" );
					insert_blockquote( "This is an example of Blockquote type 'Error'" , "Error" );
					insert_blockquote( "This is an example of Blockquote type 'Warning'" , "Warning" );
					insert_blockquote( "This is an example of Blockquote type 'Caution'" , "Caution" );
					insert_blockquote( "This is an example of Blockquote type 'Notice'" , "Notice" );
					insert_blockquote( "This is an example of Blockquote type 'Blockquote'" , "Blockquote" );
	echo close_block();
	echo BR( );	

	require_once NSID_PLM_SRC_TEMPLATE . 'footer.php';
	
	$mysqli->close();

?>


