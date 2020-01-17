 <!--
|
|	File: Code_concept.php
|
|	Next Step ID  -  Product Lifecycle Management
|	Danilo Zannoni
|	V 00.001
|	Code: 53E0000100
|
-->

<?php

	$nspage = "Code_concept";

	require_once 'includes.php';
	$db = new config_database();
	
	$mysqli = new mysqli( NS_DB_SERVER , NS_DB_USER , NS_DB_PASS , NS_DB_NAME , NS_DB_PORT );
	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

	include NSID_PLM_SRC_TEMPLATE . 'navmenu.php';
	
	if ( ( $_SESSION["clean_user"] == "guest" ) && ( ! $nscfg->param->user->guest_allowed ) ) 
		insert_blockquote( "Sorry but Guest user is not allowed here!<br/>Please, go to <a href=\"index.php\">home page</a> to log in." , "Error" , 1 );
?>

		<div class="insidecodelite">
			<div class="codelite">
				<h1 style="text-align: center;">The CODE</h1>
				<p style="text-align: justify; text-justify: inter-word;" >
					With the word 'code' we mean a little alphanumeric string able to identify something uniquely and it is the most important information inside a Product Lifecycle Management program (PLM) as this one. 
					Each code managed by NS-PLM is composed by 10 characters and it's divided in three different parts:
					<ol>
						<li><b>Context</b>: first 3 chars</li>
						<li><b>Identifier</b>: from fourth to eighth chars</li>
						<li><b>Revision</b>: the last two chars</li>
					</ol>
					This is an example code :<br/><br/> 
					<div class="clearfix">
						<div class="box33" style="background-color:#eee">
							<?php println ( "<img class=\"codelite_img\" src=\"" . NSID_PLM_SRC_IMG . "code-context.png\" />" ); ?>
						</div>
						<div class="box33" style="background-color:#ddd">
							<?php println ( "<img class=\"codelite_img\" src=\"" . NSID_PLM_SRC_IMG . "code-identifier.png\" />" ); ?>
						</div>
						<div class="box33" style="background-color:#ccc">
							<?php println ( "<img class=\"codelite_img\" src=\"" . NSID_PLM_SRC_IMG . "code-revision.png\" />" ); ?>					
						</div>
					</div>
				</p>
			</div>
			
			
			<div class="codelite">
				<h1 style="text-align: center;">Context</h1>
				<h4 style="text-align: center;">Alpanumeric and user difined</h4>
				<p style="text-align: justify; text-justify: inter-word;" >
					The context describes in which aspect of your business the code is involved. A mechanical item or an electronic component, a business model document or a complex system composed by a lot of parts, in turn coded.
					The context is divided in 3 main categories:
					<ol>
						<li><b>Typology</b></li>
						<li><b>Generic category</b></li>
						<li><b>Specific category</b></li>
					</ol>
					NS-PLM is to configure with your preferred categories options. After that you can start to codify everything you want or you need. Not only physical items but documentations or procedures too.
					This is the meaning of the example code context with <a href="rules.php" >the current configuration</a>:<br/><br/> 
					<div class="clearfix">
						<div class="box33" style="background-color:#eee">
							<?php println ( "<img class=\"codelite_img\" src=\"" . NSID_PLM_SRC_IMG . "context-typology.png\" />" ); ?>
						</div>
						<div class="box33" style="background-color:#ddd">
							<?php println ( "<img class=\"codelite_img\" src=\"" . NSID_PLM_SRC_IMG . "context-generic.png\" />" ); ?>
						</div>
						<div class="box33" style="background-color:#ccc">
							<?php println ( "<img class=\"codelite_img\" src=\"" . NSID_PLM_SRC_IMG . "context-specific.png\" />" ); ?>					
						</div>
					</div>
					<div class="clearfix">
						<div class="box33" style="background-color:#eee; height:70px; ">
							<h4 style="text-align: center;">5 - Project under development</h4>
						</div>
						<div class="box33" style="background-color:#ddd; height:70px; ">
							<h4 style="text-align: center;vertical-align: middle;">3 - Software</h4>
						</div>
						<div class="box33" style="background-color:#ccc; height:70px; ">
							<h4 style="text-align: center;">E - Management</h4>
						</div>
					</div>
				</p>
			</div>
			
			
			<div class="codelite">
				<h1 style="text-align: center;">Identifier</h1>
				<h4 style="text-align: center;">Hexadecimal and auto-incremental</h4>
				<p style="text-align: justify; text-justify: inter-word;" >
					The identifier part of a code is an auto-incremental counter, not choosable by the user, the give an unique id to the code.
					This part of the code is a hexadecimal number by 5 digits and it cannot be defined '00000'.<br/><br/> 
					<div class="clearfix">
						<div class="box33" style="background-color:#eee">
							<?php println ( "<img class=\"codelite_img\" src=\"" . NSID_PLM_SRC_IMG . "identifier-notallowed.png\" />" ); ?>
						</div>
						<div class="box33" style="background-color:#ddd">
							<?php println ( "<img class=\"codelite_img\" src=\"" . NSID_PLM_SRC_IMG . "identifier-minimum.png\" />" ); ?>
						</div>
						<div class="box33" style="background-color:#ccc">
							<?php println ( "<img class=\"codelite_img\" src=\"" . NSID_PLM_SRC_IMG . "identifier-maximum.png\" />" ); ?>					
						</div>
					</div>
				</p>
			</div>

		
			<div class="codelite">
				<h1 style="text-align: center;">Revision</h1>
				<h4 style="text-align: center;">Hexadecimal and auto-incremental</h4>
				<p style="text-align: justify; text-justify: inter-word;" >
					The revision indicates whether, during the corporate life, a new revision of the object described by a code has been released. 
					A subsequent revision indicates improvements to an object, material or not, which however retains its own identity, in this case described by the identifier.<br/><br/> 
					<div class="clearfix">
						<div class="box50" style="background-color:#ddd">
							<?php println ( "<img class=\"codelite_img\" src=\"" . NSID_PLM_SRC_IMG . "revision-minimum.png\" />" ); ?>
						</div>
						<div class="box50" style="background-color:#ccc">
							<?php println ( "<img class=\"codelite_img\" src=\"" . NSID_PLM_SRC_IMG . "revision-maximum.png\" />" ); ?>					
						</div>
					</div>
				</p>
			</div>
		</div>


<?php

	include NSID_PLM_SRC_TEMPLATE . 'footer.php';
	$mysqli->close();

?>

